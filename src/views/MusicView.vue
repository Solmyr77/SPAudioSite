<script setup>
import { } from "vue3-simple-icons";
import { PlusCircleIcon, ArrowRightCircleIcon } from "@heroicons/vue/24/solid";
</script>

<script>
import axios from "axios";

export default {
   data() {
      return {

      };
   },
   async mounted() {
      this.$refs.sendButton.addEventListener("click", this.sendRequest);
   },
   beforeUnmount() {
      this.$refs.sendButton.removeEventListener("click", this.sendRequest);
   },
   methods: {
      async sendRequest() {
         await axios.post("https://spdisco.hu/db.php", {
            message: `${this.$refs.songInput.value}|||null|||uuid|||0|||${Date.now().toString()}|||0|||1`
         })
            .then(response => {
               console.log(response.data);
            })
            .catch(error => {
               console.error('Error:', error);
            });
      }
   },
}
</script>

<template>
   <div class="flex flex-col items-center w-vw-full min-h-screen bg-ui-background">
      <div class="flex w-full justify-center items-center bg-ui-background pt-4">
         <h1 class="text-white dm-sans-bold text-2xl brightness-100">Zenekérés</h1>
      </div>

      <div class="flex max-w-7xl w-11/12 justify-center items-center pb-12 pt-6">
         <input ref="songInput" placeholder="Zene cím vagy link"
            class="flex justify-center items-center dm-sans-regular rounded-tl-lg rounded-bl-lg ring-ui-ring ring-1 bg-ui-card text-gray-300 basis-5/6 py-4 px-4 text-xl"
            type="text" />

         <button ref="sendButton"
            class="flex justify-center items-center basis-1/6 bg-ui-card ring-1 ring-ui-ring py-4 rounded-tr-lg rounded-br-lg">
            <ArrowRightCircleIcon class="h-7 w-7 stroke-white fill-ui-card stroke-2" />
         </button>
      </div>

      <div class="flex flex-col max-w-7xl w-full items-center pb-4">

         <!--Music card-->
         <div v-for="x in 12"
            class="flex justify-center items-center w-11/12 ring-2 ring-ui-ring bg-ui-card rounded-md py-4 my-2">
            <div class="flex flex-col justify-center items-start w-full basis-4/5 pl-4">
               <div class="flex justify-center items-center">
                  <h3 class="text-gray-300 dm-sans-medium text-lg">Sean Paul - Temperature</h3>
               </div>

               <h3 class="italic text-gray-400 dm-sans-regular mt-2">
                  Érkezett: 23:17
               </h3>

            </div>

            <div class="flex justify-between items-center w-full basis-1/5 mr-2">
               <h3 class="text-ui-primary dm-sans-medium text-xl">13</h3>
               <PlusCircleIcon class="size-10 stroke-white fill-ui-card stroke-2" />
            </div>
         </div>
         <!--Music card-->

      </div>
   </div>
</template>
