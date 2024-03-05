<script setup>
/*
import { FacebookIcon, InstagramIcon, XIcon, SoundCloudIcon, YouTubeIcon } from "vue3-simple-icons";
import { ArrowRightIcon, CogIcon, CheckIcon, UserIcon, SpeakerWaveIcon, CurrencyDollarIcon, ChartBarIcon, Bars3Icon, XMarkIcon, CubeIcon, CreditCardIcon, AcademicCapIcon, PhotoIcon } from "@heroicons/vue/24/solid";
*/
</script>

<script>
import VueDatePicker from "@vuepic/vue-datepicker";
import "@vuepic/vue-datepicker/dist/main.css";

export default {
   components: { VueDatePicker },
   data() {
      return {
         date: undefined,
      };
   },
   async mounted() {},
   methods: {},
};
</script>

<template>
   <div class="flex flex-col justify-center items-center w-vw-full min-h-screen bg-ui-background">
      <div>

      </div>

      <div class="flex flex-col max-w-7xl w-full h-full">
         <div class="flex w-full h-full justify-center items-center pt-16">
            <h1 class="dm-sans-bold text-7xl text-center text-white">Árkalkulátor</h1>
         </div>

         <div class="flex w-full h-full justify-center items-center py-24">
            <form class="flex flex-col justify-center gap-6 items-center w-2/3 h-full">
               <div class="flex flex-col justify-center items-center w-full gap-2">
                  <h2 class="flex justify-center items-center text-white text-2xl dm-sans-semibold">Név</h2>
                  <input class="flex justify-center items-center dm-sans-regular rounded-lg ring-ui-ring ring-1 bg-ui-card text-gray-300 w-1/2 py-2 px-4" type="text" name="" id="" />
               </div>

               <div class="flex flex-col justify-center items-center w-full gap-2">
                  <h2 class="flex justify-center items-center text-white text-2xl dm-sans-semibold">E-mail</h2>
                  <input class="flex justify-center items-center dm-sans-regular rounded-lg ring-ui-ring ring-1 bg-ui-card text-gray-300 w-1/2 py-2 px-4" type="text" name="" id="" />
               </div>

               <div class="flex flex-col justify-center items-center w-full gap-2">
                  <h2 class="flex justify-center items-center text-white text-2xl dm-sans-semibold">Telefonszám</h2>
                  <input class="flex justify-center items-center dm-sans-regular rounded-lg ring-ui-ring ring-1 bg-ui-card text-gray-300 w-1/2 py-2 px-4" type="text" name="" id="" />
               </div>

               <div class="flex flex-col justify-center items-center w-1/2 gap-2">
                  <h2 class="flex justify-center items-center text-white text-2xl dm-sans-semibold">Esemény dátuma</h2>
                  <VueDatePicker v-model="date" dark />
               </div>

               <div class="flex flex-col justify-center items-center w-full gap-2">
                  <h2 class="flex justify-center items-center text-white text-2xl dm-sans-semibold">Esemény helyszíne</h2>
                  <input class="flex justify-center items-center dm-sans-regular rounded-lg ring-ui-ring ring-1 bg-ui-card text-gray-300 w-1/2 py-2 px-4" type="text" name="" id="" />
               </div>

               <div class="flex flex-col justify-center items-center w-full gap-2">
                  <h2 class="flex justify-center items-center text-white text-2xl dm-sans-semibold">Létszám</h2>
                  <input class="flex justify-center items-center dm-sans-regular rounded-lg ring-ui-ring ring-1 bg-ui-card text-gray-300 w-1/4 py-2 px-4" type="number" name="" id="" />
               </div>

               <div class="flex flex-col justify-center items-start w-1/2 gap-2 mt-4">
                  <h1 class="flex justify-center items-center text-2xl text-white dm-sans-semibold">Extra szolgáltatások</h1>
                  <div class="flex justify-center items-center gap-2">
                     <input class="accent-ui-primary" type="checkbox" name="" id="" />
                     <p class="text-gray-400 dm-sans-regular text-lg">DJ Szolgáltatást kérek</p>
                  </div>

                  <div class="flex justify-center items-center gap-2">
                     <input class="accent-ui-primary" type="checkbox" name="" id="" />
                     <p class="text-gray-400 dm-sans-regular text-lg">Extra fényeket kérek</p>
                  </div>

                  <div class="flex justify-center items-center gap-2">
                     <input class="accent-ui-primary" type="checkbox" name="" id="" />
                     <p class="text-gray-400 dm-sans-regular text-lg">Fotóst kérek</p>
                  </div>

                  <div class="flex justify-center items-center gap-2">
                     <input class="accent-ui-primary" type="checkbox" name="" id="" />
                     <p class="text-gray-400 dm-sans-regular text-lg">Videóst kérek</p>
                  </div>
               </div>
            </form>
         </div>
      </div>
   </div>
</template>

<style></style>
