<script setup>
// import { FacebookIcon, InstagramIcon, XIcon, SoundCloudIcon, YouTubeIcon } from "vue3-simple-icons";
import { ArrowRightIcon, MusicalNoteIcon, LightBulbIcon, CameraIcon, VideoCameraIcon } from "@heroicons/vue/24/solid";
</script>

<script>
import VueDatePicker from "@vuepic/vue-datepicker";
import "@vuepic/vue-datepicker/dist/main.css";
import axios from "axios";

export default {
   components: { VueDatePicker },
   data() {
      return {
         date: undefined,
         djService: false,
         lightsService: false,
         photoService: false,
         videoService: false,
         values: {
            DJ: 30000,
            lights: 30000,
            photo: 30000,
            video: 30000,
         },
         total: 0,
      };
   },
   async mounted() {
      this.$refs.headerTitle.addEventListener("click", () => {
         this.$router.push("/");
      });

      this.calculateMargins();
   },
   methods: {
      calculateMargins() {
         let headerHeight = this.$refs.header.clientHeight;

         this.$refs.content.style.marginTop = `${headerHeight}px`;
      },
      calculatePrice() {},
      async sendEmail() {
         let nev = this.$refs.nameInput.value;
         let email = this.$refs.mailInput.value;
         let telefon = this.$refs.phoneInput.value;
         let datum = this.date;
         let helyszin = this.$refs.locationInput.value;
         let letszam = this.$refs.numberOfPeopleInput.value;
         let dj = this.djService ? "Igen" : "Nem";
         let fenyek = this.lightsService ? "Igen" : "Nem";
         let foto = this.photoService ? "Igen" : "Nem";
         let video = this.videoService ? "Igen" : "Nem";

         try {
            const response = await axios.post("https://spdisco.hu/api.php", {
               message: `${nev}|||${email}|||${telefon}|||${datum}|||${helyszin}|||${letszam}|||${dj}|||${fenyek}|||${foto}|||${video}`,
            });

            console.log(response.data);
         } catch (error) {
            console.log(error);
         }

         this.$router.push("/");
      },
   },
};
</script>

<template>
   <div class="flex flex-col justify-center items-center w-vw-full lg:h-1 min-h-screen bg-ui-background overflow-hidden">
      <div ref="header" class="flex justify-center items-center w-full py-4 fixed top-0 bg-ui-background z-50">
         <h1 ref="headerTitle" class="dm-sans-bold text-3xl text-center text-white hover:text-gray-400 cursor-pointer">SP Audio</h1>
      </div>

      <div ref="content" class="flex flex-col lg:flex-row justify-center items-center w-11/12 h-full pb-8">
         <div class="flex flex-col justify-center items-start w-full h-full gap-8 pb-16 pt-8 lg:pt-0 lg:pb-0 lg:basis-1/2">
            <div class="flex flex-col justify-center items-center w-full gap-2">
               <h2 class="flex justify-left items-center text-white text-2xl dm-sans-semibold w-3/4">Név</h2>
               <input ref="nameInput" class="flex justify-center items-center dm-sans-regular rounded-lg ring-ui-ring ring-1 bg-ui-card text-gray-300 w-3/4 py-2 px-4" type="text" name="" id="" />
            </div>

            <div class="flex flex-col justify-center items-center w-full gap-2">
               <h2 class="flex justify-left items-center text-white text-2xl dm-sans-semibold w-3/4">E-mail</h2>
               <input ref="mailInput" class="flex justify-center items-center dm-sans-regular rounded-lg ring-ui-ring ring-1 bg-ui-card text-gray-300 w-3/4 py-2 px-4" type="text" name="" id="" />
            </div>

            <div class="flex flex-col justify-center items-center w-full gap-2">
               <h2 class="flex justify-left items-center text-white text-2xl dm-sans-semibold w-3/4">Telefonszám</h2>
               <input ref="phoneInput" class="flex justify-center items-center dm-sans-regular rounded-lg ring-ui-ring ring-1 bg-ui-card text-gray-300 w-3/4 py-2 px-4" type="text" name="" id="" />
            </div>

            <div class="flex flex-col justify-center items-center w-full gap-2">
               <h2 class="flex justify-left items-center text-white text-2xl dm-sans-semibold w-3/4">Esemény dátuma</h2>
               <div class="flex justify-center items-center w-3/4 rounded-xl">
                  <VueDatePicker v-model="date" dark />
               </div>
            </div>

            <div class="flex flex-col justify-center items-center w-full gap-2">
               <h2 class="flex justify-left items-center text-white text-2xl dm-sans-semibold w-3/4">Esemény helyszíne</h2>
               <input ref="locationInput" class="flex justify-center items-center dm-sans-regular rounded-lg ring-ui-ring ring-1 bg-ui-card text-gray-300 w-3/4 py-2 px-4" type="text" name="" id="" />
            </div>

            <div class="flex flex-col justify-center items-center w-full gap-2">
               <h2 class="flex justify-left items-center text-white text-2xl dm-sans-semibold w-3/4">Létszám</h2>
               <input ref="numberOfPeopleInput" class="flex justify-center items-center dm-sans-regular rounded-lg ring-ui-ring ring-1 bg-ui-card text-gray-300 w-3/4 py-2 px-4" type="number" name="" id="" />
            </div>
         </div>

         <div class="flex justify-around items-center flex-col w-full h-full lg:basis-1/2">
            <div class="flex justify-center items-center basis-2/3 pb-16 lg:pb-0">
               <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 pt-8">
                  <div @click="djService = !djService" :class="{ 'ring-ui-primary ring-2': djService, 'ring-ui-ring ring-2': !djService }" class="flex justify-center items-center w-full h-full bg-ui-card rounded-xl p-4 cursor-pointer">
                     <div class="flex flex-col justify-center items-start w-full h-full pointer-events-none select-none">
                        <div class="flex justify-between items-center basis-1/3 w-full mb-3">
                           <h2 class="text-center text-white dm-sans-medium">DJ Szolgáltatást kérek</h2>
                           <h2 class="text-center text-white dm-sans-medium"><MusicalNoteIcon class="size-6 fill-white"/></h2>
                        </div>

                        <div class="flex justify-center items-center basis-2/3 w-full">
                           <p class="text-left dm-sans-regular text-gray-300">A bulit <span class="dm-sans-semibold text-ui-primary">DJ SP</span> hozza! Garantáltan felejthetetlen élményt biztosít minden résztvevőnek.</p>
                        </div>
                     </div>
                  </div>

                  <div @click="lightsService = !lightsService" :class="{ 'ring-ui-primary ring-2': lightsService, 'ring-ui-ring ring-2': !lightsService }" class="flex justify-center items-center w-full h-full bg-ui-card rounded-xl p-4 cursor-pointer">
                     <div class="flex flex-col justify-center items-start w-full h-full pointer-events-none select-none">
                        <div class="flex justify-between items-center basis-1/3 w-full mb-3">
                           <h2 class="text-center text-white dm-sans-medium">Extra fényeket kérek</h2>
                           <h2 class="text-center text-white dm-sans-medium"><LightBulbIcon class="size-6 fill-white"/></h2>
                        </div>

                        <div class="flex justify-center items-center basis-2/3 w-full">
                           <p class="text-left dm-sans-regular text-gray-300">Az <span class="dm-sans-semibold text-ui-primary">MM Lights</span> segítségével különleges atmoszférát varázsolunk a buliba.</p>
                        </div>
                     </div>
                  </div>

                  <div @click="photoService = !photoService" :class="{ 'ring-ui-primary ring-2': photoService, 'ring-ui-ring ring-2': !photoService }" class="flex justify-center items-center w-full h-full bg-ui-card rounded-xl p-4 cursor-pointer">
                     <div class="flex flex-col justify-center items-start w-full h-full pointer-events-none select-none">
                        <div class="flex justify-between items-center basis-1/3 w-full mb-3">
                           <h2 class="text-center text-white dm-sans-medium">Fotózást kérek</h2>
                           <h2 class="text-center text-white dm-sans-medium"><CameraIcon class="size-6 fill-white"/></h2>
                        </div>

                        <div class="flex justify-center items-center basis-2/3 w-full">
                           <p class="text-left dm-sans-regular text-gray-300">Legyen minden pillanat megörökítve! Rögzítjük az emlékezetes pillanatokat.</p>
                        </div>
                     </div>
                  </div>

                  <div @click="videoService = !videoService" :class="{ 'ring-ui-primary ring-2': videoService, 'ring-ui-ring ring-2': !videoService }" class="flex justify-center items-center w-full h-full bg-ui-card rounded-xl p-4 cursor-pointer">
                     <div class="flex flex-col justify-center items-start w-full h-full pointer-events-none select-none">
                        <div class="flex justify-between items-center basis-1/3 w-full mb-3">
                           <h2 class="text-center text-white dm-sans-medium">Videókészítést kérek</h2>
                           <h2 class="text-center text-white dm-sans-medium"><VideoCameraIcon class="size-6 fill-white"/></h2>
                        </div>

                        <div class="flex justify-center items-center basis-2/3 w-full">
                           <p class="text-left dm-sans-regular text-gray-300">Mozgóképet készítünk amivel felidézhetik az esemény hangulatát és pillanatait.</p>
                        </div>
                     </div>
                  </div>
               </div>
            </div>

            <div class="flex justify-center items-center basis-1/3 pb-8 lg:pb-0">
               <button @click="sendEmail()" ref="offerButton" class="rounded-full flex justify-center items-center border-none dm-sans-semibold bg-white hover:bg-gray-400 transition-colors px-6 py-3 text-4xl">
                  Küldés
                  <ArrowRightIcon class="ml-2 size-16 text-xl" />
               </button>
            </div>
         </div>
      </div>
   </div>
</template>

<style></style>
