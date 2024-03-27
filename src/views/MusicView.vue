<script setup>
import { } from "vue3-simple-icons";
import { HandThumbUpIcon, ArrowRightCircleIcon, XMarkIcon, CheckIcon } from "@heroicons/vue/24/solid";
</script>

<script>
import axios from "axios";
import { v4 as uuidv4 } from 'uuid';

class VoterIDs {
   
}

class Record {
   constructor(addedOn, canPlay, id, url, playedAlready, title, votes, display) {
      this.addedOn = addedOn;
      this.canPlay = canPlay;
      this.id = id;
      this.url = url;
      this.playedAlready = playedAlready;
      this.title = title;
      this.votes = votes;
      this.display = display;
      this.voterIDs = new VoterIDs();
   }
}

export default {
   data() {
      return {
         uuid: null,
         records: [],
         viewportHeight: window.innerHeight,
      };
   },
   async mounted() {
      if (localStorage.getItem("uuid") == null) {
         this.uuid = uuidv4();
         localStorage.setItem("uuid", this.uuid);
      }
      else {
         this.uuid = localStorage.getItem("uuid");
      }

      document.addEventListener("keydown", this.handleKeyDown);

      this.$refs.sendButton.addEventListener("click", this.sendRequest);

      let songsListMaxHeight = this.viewportHeight - this.$refs.titleHeader.clientHeight - this.$refs.inputHeader.clientHeight;

      this.$refs.songsList.style.maxHeight = `${songsListMaxHeight}px`;

      this.getSongs();
   },
   beforeUnmount() {
      document.removeEventListener("keydown", this.handleKeyDown);

      this.$refs.sendButton.removeEventListener("click", this.sendRequest);
   },
   methods: {
      async sendPostRequest(message) {
         await axios.post("http://localhost:3000/db.php", {
            message: message
         })
            .then(response => {
               console.log(response.data);
            })
            .catch(error => {
               console.error('Error:', error);
            });
      },
      async sendRequest() {
         let currentDate = new Date();
         let formattedDate = currentDate.toISOString().slice(0, 10);
         let formattedTime = currentDate.toTimeString().slice(0, 8);
         let mysqlDateTime = `${formattedDate} ${formattedTime}`;


         // TODO: Clean up and validate input
         let inputText = this.$refs.songInput.value;


         await this.sendPostRequest(`add:${inputText}|||null|||0|||${mysqlDateTime}|||0|||1|||${this.uuid}`);

         this.$refs.songInput.value = "";

         await this.getSongs();
      },
      async getSongs() {
         try {
            const response = await axios.get("https://spdisco.hu/db.php");

            console.log(response)

            const records = response.data.map(record => {

               let display = "normal";
               if (record.CanPlay == 0) {
                  display = "cantPlay";
               } else if (record.PlayedAlready == 1) {
                  display = "playedAlready";
               }
               return new Record(record.AddedOn, record.CanPlay, record.ID, record.Link, record.PlayedAlready, record.Title, record.Votes, display);
            });

            records.sort((a, b) => new Date(b.addedOn) - new Date(a.addedOn));

            const otherSongs = records.filter(x => x.canPlay == 1 && x.playedAlready == 0);
            const alreadyPlayedSongs = records.filter(x => x.playedAlready == 1);
            const cantPlaySongs = records.filter(x => x.canPlay == 0);

            this.records = otherSongs.concat(alreadyPlayedSongs, cantPlaySongs);
         } catch (error) {
            console.error('Error:', error);
         }

      },
      handleKeyDown(event) {
         if (event.keyCode === 13) {
            this.sendRequest();
         }
      },
      async handleUpvote(id) {
         await this.sendPostRequest(`upvote:${id}|||${this.uuid}`);

         await this.getSongs();
      }
   },
}
</script>

<template>
   <div class="flex flex-col items-center w-vw-full min-h-screen bg-ui-background">
      <div ref="titleHeader" class="flex w-full justify-center items-center bg-ui-background pt-4">
         <h1 class="text-white dm-sans-bold text-2xl brightness-100">Zenekérés</h1>
      </div>

      <div ref="inputHeader" class="flex max-w-7xl w-11/12 justify-center items-center pb-12 pt-6">
         <input ref="songInput" placeholder="Zene cím vagy link"
            class="flex justify-center items-center dm-sans-regular rounded-tl-lg rounded-bl-lg ring-ui-ring ring-1 bg-ui-card text-gray-300 basis-5/6 py-4 px-4 text-xl"
            type="text" />

         <button ref="sendButton"
            class="flex justify-center items-center basis-1/6 bg-ui-stone ring-1 ring-ui-ring py-4 rounded-tr-lg rounded-br-lg">
            <ArrowRightCircleIcon class="h-7 w-7 stroke-white fill-ui-card stroke-2" />
         </button>
      </div>

      <div ref="songsList" class="flex flex-col max-w-7xl w-full items-center pb-4 overflow-auto pt-2">

         <!--Music card-->
         <div v-for="record in records" class="flex justify-center items-center w-11/12 mb-4 relative">

            <!--Badge-->
            <div v-if="record.display == 'normal'" @click="handleUpvote(record.id)"
               class="absolute -top-0 right-0 bg-ui-primary size-6 rounded-tr-lg rounded-bl-lg ring-ui-ring ring-2 flex justify-center items-center">
               <p class="dm-sans-bold text-ui-background">{{ record.votes }}</p>
            </div>
            <!--Badge-->

            <!--Normal-->
            <template v-if="record.display == 'normal'">
               <div :ref="record.id"
                  class="flex flex-col justify-between items-start w-full h-full basis-4/5 ring-ui-ring bg-ui-card rounded-tl-md rounded-bl-md ring-2 pl-3 py-3">
                  <div class="flex justify-center items-center">
                     <h3 class="text-gray-300 dm-sans-medium text-lg mr-2">{{ record.title }}</h3>
                  </div>

                  <h3 class="italic text-gray-400 dm-sans-regular mt-2">
                     Érkezett: {{ record.addedOn.split(" ")[1].substring(0, 5) }}
                  </h3>
               </div>

               <div @click="handleUpvote(record.id)"
                  class="flex justify-center items-center w-full basis-1/5 bg-ui-stone ring-ui-ring rounded-tr-md rounded-br-md ring-2 cursor-pointer active:bg-stone-950">
                  <HandThumbUpIcon class="fill-white size-10 absolute bottom-4" />
               </div>
            </template>
            <!--Normal-->

            <!--Played already-->
            <template v-if="record.display == 'playedAlready'">
               <div
                  class="flex flex-col justify-between items-start w-full h-full basis-4/5 ring-ui-ring bg-ui-card rounded-tl-md rounded-bl-md ring-2 pl-3 py-3">
                  <div class="flex justify-center items-center">
                     <h3 class="text-ui-primary dm-sans-medium text-lg mr-2">{{ record.title }}</h3>
                  </div>

                  <h3 class="italic text-ui-primary dm-sans-regular mt-2">
                     Lejátszva
                  </h3>
               </div>

               <div @click="handleUpvote(record.id)"
                  class="flex justify-center items-center w-full h-full basis-1/5 bg-ui-stone ring-ui-ring rounded-tr-md rounded-br-md ring-2 cursor-pointer active:bg-stone-950">
                  <CheckIcon class="fill-ui-primary size-10" />
               </div>
            </template>
            <!--Played already-->

            <!--Can't play-->
            <template v-if="record.display == 'cantPlay'">
               <div
                  class="flex flex-col justify-center items-start w-full h-full basis-4/5 ring-ui-ring bg-ui-card rounded-tl-md rounded-bl-md ring-2 pl-3 py-3">
                  <div class="flex justify-center items-center">
                     <h3
                        class="text-gray-300 dm-sans-medium text-lg mr-2 line-through decoration-gray-300 decoration-4">
                        {{
            record.title }}</h3>
                  </div>
               </div>

               <div @click="handleUpvote(record.id)"
                  class="flex justify-center items-center w-full h-full basis-1/5 bg-ui-stone ring-ui-ring rounded-tr-md rounded-br-md ring-2 cursor-pointer active:bg-stone-950">
                  <XMarkIcon class="fill-white stroke-2 size-10" />
               </div>
            </template>
            <!--Can't play-->

            <!--Right marker

            <div v-if="record.uuid.includes(uuid) && record.canPlay == 1 && record.playedAlready == 0"
               class="flex justify-center items-center w-full h-full basis-1/5 bg-ui-stone ring-ui-ring rounded-tr-md rounded-br-md ring-2">
               <h3 class="text-ui-primary text-3xl dm-sans-medium">{{ record.votes }}</h3>
            </div>

            Right marker-->

         </div>
         <!--Music card-->

      </div>
   </div>
</template>
