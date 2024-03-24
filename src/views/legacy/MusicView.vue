<script>
// Made by Lori
// https://github.com/Solmyr77

import PocketBase from "pocketbase";
import { debounce } from "lodash";
import VueCookies from "vue-cookies";
import { v4 as uuidv4 } from "uuid";
import axios from "axios";

export default {
   data() {
      return {
         zenek: [],
         inputText: "",
         errorMessage: "",
         pb: undefined,
         collection: undefined,
         saveCollection: undefined,
         settingsCollection: undefined,
         uuid: undefined,
         title: undefined,
         voteCount: 0,
         votesVisible: 0,
         songsPerPerson: 3,
         songLimit: 1,
      };
   },
   async mounted() {
      if (
         !document.cookie
            .split(";")
            .some((cookie) => cookie.trim().startsWith("uuid="))
      ) {
         const expires = new Date(Date.now() + 7 * 24 * 60 * 60 * 1000);

         VueCookies.set("uuid", uuidv4(), { expires });
      }

      this.uuid = VueCookies.get("uuid");

      this.pb = new PocketBase("https://sp.myddns.me/pb");

      this.pb.autoCancellation(false);

      this.collection = this.pb.collection("zenek");
      this.saveCollection = this.pb.collection("songs");
      this.settingsCollection = this.pb.collection("settings");

      await this.getSettings();
      await this.getItems();

      this.collection.subscribe("*", () => this.getItems());
      this.settingsCollection.subscribe("*", () => this.getSettings());
   },
   methods: {
      isYoutubeLink(str) {
         const youtubeRegExp =
            /^(http(s)?:\/\/)?((w){3}.)?youtu(be|.be)?(\.com)?\/.+/;

         return youtubeRegExp.test(str);
      },
      getId(url) {
         let id = "";
         if (url.includes("youtu.be")) {
            id = url.split("/").pop();
         } else {
            let match = url.match(/[?&]v=([^&]+)/);
            if (match) {
               id = match[1];
            }
         }
         return id;
      },
      async fetchVideoTitle(url) {
         const videoId = this.getId(url);
         const response = await axios.get(
            `https://www.googleapis.com/youtube/v3/videos?id=${videoId}&key=AIzaSyAQ12mNG8tdsXFZXsMO-G_id4ZoLWz4Ai8&part=snippet`
         );
         const title = response.data.items[0].snippet.title;
         return title;
      },
      async getItems() {
         const { items } = await this.collection.getList(1, 10000);

         const zenekBuffer = items;
         zenekBuffer.sort((a, b) => b.votes - a.votes);

         const uuid = this.uuid;

         const resultList = await this.collection.getList(1, 10000, {
            filter: `uuid ~ "C${this.uuid}"`,
         });
         this.voteCount = resultList.totalItems;

         for (let i = 0; i < zenekBuffer.length; i++) {
            const zene = zenekBuffer[i];
            const isMatch = zene.uuid.includes(uuid);

            if (isMatch) {
               const lastChar = zene.uuid.slice(-1);
               zene.displayButtons = lastChar === "1" ? "up" : "down";

               if (uuid === zene.uuid) {
                  break;
               }
            } else {
               zene.displayButtons = true;
            }
         }

         this.zenek = zenekBuffer;
      },
      async createRecord(title, ytlink) {
         if (typeof ytlink !== "undefined") {
            const lowercaseTitle = title.toLowerCase();

            await this.collection.create({ title, lowercaseTitle });
            await this.saveCollection.create({ title });

            const record = await this.collection.getFirstListItem(
               `title="${title}"`
            );

            const uuid = "C" + this.uuid + "1";

            await this.collection.update(record.id, { votes: 1, uuid, ytlink });
         } else {
            const lowercaseTitle = title.toLowerCase();

            await this.collection.create({ title, lowercaseTitle });
            await this.saveCollection.create({ title });

            const record = await this.collection.getFirstListItem(
               `title="${title}"`
            );

            const uuid = "C" + this.uuid + "1";

            await this.collection.update(record.id, { votes: 1, uuid });
         }
      },
      async incrementNum(id) {
         const record = await this.collection.getFirstListItem(`id="${id}"`);
         const newNum = record.votes + 1;
         const newUuid = record.uuid + ";" + this.uuid + "1";

         await this.collection.update(id, { votes: newNum, uuid: newUuid });
      },
      async decrementNum(id) {
         const record = await this.collection.getFirstListItem(`id="${id}"`);
         const newNum = record.votes - 1;
         const newUuid = record.uuid + ";" + this.uuid + "0";

         await this.collection.update(id, { votes: newNum, uuid: newUuid });
      },
      async handleClick() {
         if (this.isYoutubeLink(this.inputText)) {
            const ytTitle = await this.fetchVideoTitle(this.inputText);

            if (
               this.voteCount > this.songsPerPerson - 1 &&
               this.songLimit == 1
            ) {
               this.inputText = "";
               this.errorMessage = "Nincs több kérésed!";

               setTimeout(() => {
                  this.errorMessage = "";
               }, 2000);

               return;
            }

            const resultList = await this.collection.getList(1, 10000, {
               filter: `title = "${ytTitle}" || lowercaseTitle = "${ytTitle.toLowerCase()}"`,
            });

            if (resultList.items.length > 0) {
               if (!resultList.items[0].uuid.includes(this.uuid)) {
                  this.inputText = "";
                  this.incrementNum(resultList.items[0].id);
               } else {
                  this.inputText = "";
                  this.errorMessage = "Nem szavazhatsz kétszer!";

                  setTimeout(() => {
                     this.errorMessage = "";
                  }, 2000);
               }
            } else {
               const ytLink = this.inputText;
               this.inputText = "";
               this.debouncedCreateRecord(ytTitle, ytLink);
            }
         } else {
            //#region
            if (this.inputText == "spadmin") {
               this.$router.push("secret/admin");
               return;
            }

            if (
               this.voteCount > this.songsPerPerson - 1 &&
               this.songLimit == 1
            ) {
               this.inputText = "";
               this.errorMessage = "Nincs több kérésed!";

               setTimeout(() => {
                  this.errorMessage = "";
               }, 2000);

               return;
            }

            if (this.inputText == "increment") {
               this.inputText = "";
               return;
            }

            if (
               this.inputText == "" ||
               this.inputText == null ||
               this.inputText == undefined ||
               this.inputText.trim() === ""
            ) {
               this.errorMessage = "A cím nem lehet üres!";
               setTimeout(() => {
                  this.errorMessage = "";
               }, 2000);
               return;
            }

            if (this.inputText.length < 4) {
               this.errorMessage = "A cím túl rövid!";
               setTimeout(() => {
                  this.errorMessage = "";
               }, 2000);
               return;
            }

            if (this.inputText.length > 100) {
               this.errorMessage = "A cím túl hosszú!";
               setTimeout(() => {
                  this.errorMessage = "";
               }, 2000);
               return;
            }
            //#endregion

            const resultList = await this.collection.getList(1, 10000, {
               filter: `title = "${
                  this.inputText
               }" || lowercaseTitle = "${this.inputText.toLowerCase()}"`,
            });

            if (resultList.items.length > 0) {
               if (!resultList.items[0].uuid.includes(this.uuid)) {
                  this.inputText = "";
                  this.incrementNum(resultList.items[0].id);
               } else {
                  this.inputText = "";
                  this.errorMessage = "Nem szavazhatsz kétszer!";

                  setTimeout(() => {
                     this.errorMessage = "";
                  }, 2000);
               }
            } else {
               this.title = this.inputText;
               this.inputText = "";
               await this.debouncedCreateRecord(this.title, undefined);
            }
         }
      },
      async getSettings() {
         await this.settingsCollection.getList(1, 3).then((settings) => {
            settings.items.forEach((record) => {
               if (record.setting == "votesVisible") {
                  this.votesVisible = record.value;
               } else if (record.setting == "songsPerPerson") {
                  this.songsPerPerson = record.value;
               } else if (record.setting == "songLimit") {
                  this.songLimit = record.value;
               }
            });
         });
      },
   },
   created() {
      this.debouncedCreateRecord = debounce(this.createRecord, 500);
   },
};
</script>

<template>
   <div
      class="grid grid-rows-64 h-screen w-screen bg-custom-bg-dark gap-0 overflow-hidden"
   >
      <!--Heading-->
      <div
         class="flex items-center justify-center text-center basis-1/12 w-full bg-custom-custom-elevation-3 elevation-4 row-span-3"
      >
         <h1 class="text-2xl text-white">Zenekérés</h1>
      </div>
      <!--Heading-->

      <!--Input-->
      <div
         class="flex text-center w-screen items-center justify-center row-span-7"
      >
         <div class="grid grid-cols-5 h-full w-full">
            <input
               label="Zene"
               class="text-white elevation-1 bg-custom-custom-elevation-1 px-10 py-5 text-2xl col-span-4"
               v-model="inputText"
               type="text"
               placeholder="Ide írd a zene címét vagy a linket"
            />
            <button
               class="flex items-center align-middle justify-center elevation-3 bg-custom-custom-elevation-2 hover:bg-custom-custom-elevation-3 text-white text-3xl w-full"
               @click="handleClick"
            >
               <i class="fa-solid fa-play"></i>
            </button>
         </div>
      </div>
      <!--Input-->

      <!--List-->
      <div
         class="flex flex-col bg-custom-custom-elevation-2 elevation-3 w-screen row-span-54"
      >
         <div
            class="flex items-center justify-between bg-custom-custom-elevation-2 elevation-2 pt-2 pb-2"
         >
            <h2
               v-if="
                  this.errorMessage == '' ||
                  this.errorMessage == 'Nincs több kérésed!'
               "
               class="ml-4 text-xl text-white text-left"
            >
               Eddigi kérések és szavazás
            </h2>
            <h2
               v-else-if="this.errorMessage != ''"
               class="ml-4 text-xl text-rose-600"
            >
               {{ this.errorMessage }}
            </h2>

            <div v-if="this.songLimit == 1">
               <h2
                  v-if="this.voteCount < this.songsPerPerson"
                  class="mr-4 text-xl text-white text-right"
               >
                  Még {{ this.songsPerPerson - this.voteCount }} kérésed van.
               </h2>
               <h2 v-else class="mr-4 text-xl text-white text-right">
                  Nincs több kérésed.
               </h2>
            </div>
         </div>
         <ul class="text-white overflow-y-auto mb-3 mt-2">
            <li v-for="item in zenek" :key="item.id">
               <div
                  class="grid grid-cols-5 ml-2 mr-2 mt-2 pb-2 gap-2 elevation-1"
               >
                  <div class="flex col-span-3">
                     <span
                        class="ml-2 flex w-full items-center text-xl col-span-3 break-words"
                        >{{ item.title }}</span
                     >
                  </div>

                  <div
                     v-if="
                        item.displayButtons === true && this.votesVisible == 1
                     "
                     class="col-span-2 flex"
                  >
                     <span
                        :class="[
                           item.votes == 0
                              ? 'text-blue-400'
                              : item.votes < 0
                              ? 'text-red-600'
                              : item.votes > 0
                              ? 'text-emerald-600'
                              : '',
                        ]"
                        class="text-2xl overflow-hidden col-span-2 flex items-center justify-center basis-1/3"
                        >{{ item.votes }}</span
                     >

                     <button
                        @click="incrementNum(item.id)"
                        class="bg-emerald-600 elevation-2 hover:bg-emerald-400 active:bg-emerald-950 hover:rounded-xl text-white-100 rounded-lg text-xl p-2 basis-1/3 mr-1"
                     >
                        <i class="fa-solid fa-thumbs-up"></i>
                     </button>

                     <button
                        @click="decrementNum(item.id)"
                        class="bg-rose-700 elevation-2 hover:bg-rose-500 active:bg-rose-950 hover:rounded-xl text-white rounded-lg text-xl p-2 basis-1/3 ml-1"
                     >
                        <i class="fa-solid fa-thumbs-down"></i>
                     </button>
                  </div>

                  <div
                     v-if="
                        item.displayButtons === true && this.votesVisible == 0
                     "
                     class="col-span-2 flex"
                  >
                     <button
                        @click="incrementNum(item.id)"
                        class="bg-emerald-600 elevation-2 hover:bg-emerald-400 active:bg-emerald-950 hover:rounded-xl text-white-100 rounded-lg text-xl p-2 basis-1/2 mr-1"
                     >
                        <i class="fa-solid fa-thumbs-up"></i>
                     </button>
                     <button
                        @click="decrementNum(item.id)"
                        class="bg-rose-700 elevation-2 hover:bg-rose-500 active:bg-rose-950 hover:rounded-xl text-white rounded-lg text-xl p-2 basis-1/2 ml-1"
                     >
                        <i class="fa-solid fa-thumbs-down"></i>
                     </button>
                  </div>

                  <div
                     v-else-if="item.displayButtons === 'up'"
                     class="col-span-2 grid grid-cols-3 grid-flow-col"
                  >
                     <span></span>
                     <i
                        class="text-emerald-600 text-3xl fa-solid fa-thumbs-up flex items-center justify-center"
                     ></i>
                     <span
                        :class="[
                           item.votes == 0
                              ? 'text-blue-400'
                              : item.votes < 0
                              ? 'text-red-600'
                              : item.votes > 0
                              ? 'text-emerald-600'
                              : '',
                        ]"
                        class="text-2xl overflow-hidden col-span-2 flex items-center justify-center"
                        >{{ item.votes }}</span
                     >
                  </div>

                  <div
                     v-else-if="item.displayButtons === 'down'"
                     class="col-span-2 grid grid-cols-3 grid-flow-col"
                  >
                     <span></span>
                     <i
                        class="text-rose-700 text-3xl fa-solid fa-thumbs-down flex items-center justify-center"
                     ></i>
                     <span
                        :class="[
                           item.votes == 0
                              ? 'text-blue-400'
                              : item.votes < 0
                              ? 'text-rose-700'
                              : item.votes > 0
                              ? 'text-emerald-600'
                              : '',
                        ]"
                        class="text-2xl overflow-hidden col-span-2 flex items-center justify-center"
                        >{{ item.votes }}</span
                     >
                  </div>
               </div>
            </li>
         </ul>
      </div>
      <!--List-->
   </div>
</template>

<style>
@import '../../assets/main.css'
</style>
