<script setup>
import { FacebookIcon, InstagramIcon, XIcon, SoundCloudIcon, YouTubeIcon } from "vue3-simple-icons";
import { ArrowRightIcon, CogIcon, CheckIcon, UserIcon, SpeakerWaveIcon, CurrencyDollarIcon, ChartBarIcon, Bars3Icon, XMarkIcon, CubeIcon, CreditCardIcon, AcademicCapIcon, PhotoIcon } from "@heroicons/vue/24/solid";
</script>

<script>
export default {
   data() {
      return {
         isMenuVisible: false,
         activeMenuItem: "",
      };
   },
   async mounted() {},
   methods: {
      scrollToElement(element) {
         switch (element) {
            case "top":
               window.scrollTo({ top: 0, behavior: "smooth" });
               this.activeMenuItem = "none"
               break;
            case "details":
               this.$refs.details.scrollIntoView({ behavior: "smooth" });
               this.activeMenuItem = "details";
               break;

            case "pricing":
               this.$refs.pricing.scrollIntoView({ behavior: "smooth" });
               this.activeMenuItem = "pricing";
               break;

            case "reviews":
               this.$refs.reviews.scrollIntoView({ behavior: "smooth" });
               this.activeMenuItem = "reviews";
               break;
         }
      },
   },
};
</script>

<template>
   <!--Main-->
   <div class="flex flex-col justify-center items-center w-vw-full min-h-screen bg-ui-background">
      <!--Header-->
      <div class="invisible lg:visible flex justify-center items-center w-full py-4 dm-sans-medium mx-auto fixed top-0 z-50 bg-ui-background">
         <div class="flex justify-between items-center w-full max-w-7xl px-8 h-full">
            <!--Inline title-->
            <div @click="scrollToElement('top')" class="flex justify-center items-center cursor-pointer">
               <h1 class="text-white text-xl dm-sans-bold hover:text-gray-400 transition-colors">SP Audio</h1>
            </div>
            <!--Inline title-->

            <!--Nav-->
            <div class="flex justify-center items-center rounded-3xl h-full ring-ui-ring ring-1 px-2 py-1">
               <div class="px-4 py-1.5">
                  <!--Active test-->
                  <p @click="scrollToElement('details')" :class="{'text-white border-b-2 border-white -mb-0.5' : activeMenuItem == 'details', 'text-gray-400' : activeMenuItem != 'details'}" class="text-sm cursor-pointer transition-opacity">Részletek</p>
               </div>

               <div class="px-4 py-1.5">
                  <p @click="scrollToElement('pricing')" :class="{'text-white border-b-2 border-white -mb-0.5' : activeMenuItem == 'pricing', 'text-gray-400' : activeMenuItem != 'pricing'}" class="text-sm cursor-pointer transition-opacity">Árajánlat</p>
               </div>

               <div class="px-4 py-1.5">
                  <p @click="scrollToElement('reviews')" :class="{'text-white border-b-2 border-white -mb-0.5' : activeMenuItem == 'reviews', 'text-gray-400' : activeMenuItem != 'reviews'}" class="text-sm cursor-pointer transition-opacity">Vélemények</p>
               </div>
            </div>
            <!--Nav-->

            <!--Inline title-->
            <div class="flex justify-center items-center">
               <h1 class="text-gray-950 text-xl dm-sans-bold">SP Audio</h1>
            </div>
            <!--Inline title-->
         </div>
      </div>
      <!--Header-->

      <!--Header phone-->
      <div class="visible lg:invisible flex-col justify-center items-center w-full dm-sans-medium mx-auto fixed top-0 z-50 bg-ui-background">
         <div class="flex justify-between items-center w-full max-w-7xl px-8 h-full border-ui-ring border-b-2 py-4">
            <!--Inline title-->
            <div @click="scrollToElement('top')" class="flex justify-center items-center">
               <h1 class="text-white text-xl dm-sans-bold">SP Audio</h1>
            </div>
            <!--Inline title-->

            <!--Menu button-->
            <div class="flex justify-center items-center">
               <h1 v-if="!isMenuVisible" class="text-white text-xl dm-sans-bold"><Bars3Icon @click="isMenuVisible = true" class="size-8" /></h1>
               <h1 v-if="isMenuVisible" class="text-white text-xl dm-sans-bold"><XMarkIcon @click="isMenuVisible = false" class="size-8" /></h1>
            </div>
            <!--Menu button-->
         </div>

         <!--Menu-->
         <div v-if="isMenuVisible" class="flex flex-col w-full h-64 justify-around items-start bg-ui-background border-ui-ring border-b-2">
            <h1 @click="scrollToElement('details')" :class="{'text-ui-primary' : activeMenuItem == 'details', 'text-gray-400' : activeMenuItem != 'details'}" class="dm-sans-semibold ml-8"><CubeIcon :class="{'fill-ui-primary' : activeMenuItem == 'details', 'fill-white' : activeMenuItem != 'details'}" class="size-8 inline mr-4" /> Részletek</h1>
            <h1 @click="scrollToElement('pricing')" :class="{'text-ui-primary' : activeMenuItem == 'pricing', 'text-gray-400' : activeMenuItem != 'pricing'}" class="dm-sans-semibold ml-8"><CreditCardIcon :class="{'fill-ui-primary' : activeMenuItem == 'pricing', 'fill-white' : activeMenuItem != 'pricing'}" class="size-8 fill-white inline mr-4" /> Árajánlat</h1>
            <h1 @click="scrollToElement('reviews')" :class="{'text-ui-primary' : activeMenuItem == 'reviews', 'text-gray-400' : activeMenuItem != 'reviews'}" class="dm-sans-semibold ml-8"><AcademicCapIcon :class="{'fill-ui-primary' : activeMenuItem == 'reviews', 'fill-white' : activeMenuItem != 'reviews'}" class="size-8 fill-white inline mr-4" /> Vélemények</h1>
         </div>
         <!--Menu-->
      </div>
      <!--Header phone-->

      <!--Title body-->
      <div class="flex flex-col justify-center items-center py-32 w-full h-full max-w-7xl px-8 mx-auto">
         <div class="mt-12 w-full h-full"></div>
         <h1 class="flex justify-center items-center text-center text-7xl dm-sans-bold text-white w-full h-full">SP Audio</h1>
         <p class="flex justify-center items-center text-center text-lg dm-sans-regular text-gray-300 mt-6">Profi DJ, modern hang- és fénytechnika áll rendelkezésre esküvőkhöz, céges rendezvényekhez és bulikhoz is.</p>
         <div class="mt-6 flex justify-center items-center w-full h-full">
            <button class="rounded-full flex justify-center items-center border-none dm-sans-medium bg-white px-6 py-3 hover:bg-gray-400 transition-colors">
               Árajánlat

               <ArrowRightIcon class="ml-2 h-6 w-6 text-xl" />
            </button>
         </div>
      </div>
      <!--Title body-->

      <!--Promo image-->
      <div class="flex justify-center items-center p-4 rounded-xl max-w-7xl px-4 w-full h-full ring-1 ring-ui-ring mx-auto">
         <div class="aspect-3/2 flex justify-center items-center h-full w-full">
            <img class="rounded-xl" src="../images/img_promo.jpg" alt="Promo image" title="Promo image" />
         </div>
      </div>
      <!--Promo image-->

      <!--Social media-->
      <div class="flex flex-col w-full justify-center items-center max-w-7xl px-8 mt-20 mx-auto">
         <h2 class="text-lg dm-sans-semibold text-white leading-8">Elérhetőségeink</h2>
         <div class="mx-auto mt-10 flex flex-wrap items-center justify-between w-full">
            <FacebookIcon class="size-10 lg:size-16 fill-white cursor-pointer hover:fill-gray-400 transition-colors" />
            <InstagramIcon class="size-10 lg:size-16 fill-white cursor-pointer hover:fill-gray-400 transition-colors" />
            <SoundCloudIcon class="size-10 lg:size-24 fill-white cursor-pointer hover:fill-gray-400 transition-colors" />
            <YouTubeIcon class="size-10 lg:size-16 fill-white cursor-pointer hover:fill-gray-400 transition-colors" />
            <XIcon class="size-10 lg:size-16 fill-white cursor-pointer hover:fill-gray-400 transition-colors" />
         </div>
      </div>
      <!--Social media-->

      <!--Promo cards-->
      <div ref="details" class="flex flex-col justify-center items-center mx-auto mt-24 max-w-7xl px-8">
         <div class="flex flex-col w-full max-w-7xl px-8 justify-center items-center">
            <h2 class="text-ui-primary text-base/7 dm-sans-semibold text-center">Részletek</h2>
            <h2 class="text-3xl lg:text-5xl dm-sans-bold text-white tracking-tight text-center">Miért válasszon minket?</h2>
            <p class="mt-6 text-lg/8 text-gray-300 dm-sans-regular text-center">Válasszon minket, hogy garantáltan felejthetetlenné varázsoljuk rendezvényét a legfrissebb technikai megoldásokkal és profi szolgáltatásainkkal!</p>
         </div>

         <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 lg:grid-rows-2 gap-8 mt-24">
            <div class="flex justify-center items-start rounded-xl ring-1 ring-ui-ring bg-ui-card">
               <div class="flex flex-col justify-center items-start px-4 py-5">
                  <div class="mb-3 mt-1 pointer-events-none"><CogIcon class="size-8 fill-white stroke-0 bg-ui-card" /></div>
                  <div class="text-white dm-sans-bold">Tapasztalat és szakértelem</div>
                  <div class="text-gray-400 mt-1 dm-sans-regular">Csapatunk olyan tapasztalt szakemberekből áll, akik évek óta tevékenykednek a hang- és fénytechnika területén.</div>
               </div>
            </div>

            <div class="flex justify-center items-start rounded-xl ring-1 ring-ui-ring bg-ui-card">
               <div class="flex flex-col justify-center items-start px-4 py-5">
                  <div class="mb-3 mt-1 pointer-events-none"><CheckIcon class="size-8 fill-white stroke-0 bg-ui-card" /></div>
                  <div class="text-white dm-sans-bold">Egyedi megoldások</div>
                  <div class="text-gray-400 mt-1 dm-sans-regular">Nem állunk meg a bevett megoldásoknál. Minden ügyfelünk számára egyedi megoldásokat kínálunk, figyelembe véve az egyedi igényeket és a rendezvény jellegét.</div>
               </div>
            </div>

            <div class="flex justify-center items-start rounded-xl ring-1 ring-ui-ring bg-ui-card">
               <div class="flex flex-col justify-center items-start px-4 py-5">
                  <div class="mb-3 mt-1 pointer-events-none"><UserIcon class="size-8 fill-white stroke-0 bg-ui-card" /></div>
                  <div class="text-white dm-sans-bold">Ügyfélorientáltság</div>
                  <div class="text-gray-400 mt-1 dm-sans-regular">Rugalmasak vagyunk, és mindent megteszünk annak érdekében, hogy az elképzeléseiknek megfelelően valósítsuk meg igényeiket.</div>
               </div>
            </div>

            <div class="flex justify-center items-start rounded-xl ring-1 ring-ui-ring bg-ui-card">
               <div class="flex flex-col justify-center items-start px-4 py-5">
                  <div class="mb-3 mt-1 pointer-events-none"><SpeakerWaveIcon class="size-8 fill-white stroke-0 bg-ui-card" /></div>
                  <div class="text-white dm-sans-bold">Hangminőség</div>
                  <div class="text-gray-400 mt-1 dm-sans-regular">Hangosításunk kristálytiszta hangzással tölti meg a teret, hogy minden szó tökéletesen érthető legyen, és minden dallam életre keljen.</div>
               </div>
            </div>

            <div class="flex justify-center items-start rounded-xl ring-1 ring-ui-ring bg-ui-card">
               <div class="flex flex-col justify-center items-start px-4 py-5">
                  <div class="mb-3 mt-1 pointer-events-none"><CurrencyDollarIcon class="size-8 fill-white stroke-0 bg-ui-card" /></div>
                  <div class="text-white dm-sans-bold">Megfizethetőség</div>
                  <div class="text-gray-400 mt-1 dm-sans-regular">Tudjuk, hogy fontos szempont az ár, ezért törekszünk arra, hogy versenyképes áron kínáljuk szolgáltatásainkat anélkül, hogy a minőséget veszélyeztetnénk.</div>
               </div>
            </div>

            <div class="flex justify-center items-start rounded-xl ring-1 ring-ui-ring bg-ui-card">
               <div class="flex flex-col justify-center items-start px-4 py-5">
                  <div class="mb-3 mt-1 pointer-events-none"><ChartBarIcon class="size-8 fill-white stroke-0 bg-ui-card" /></div>
                  <div class="text-white dm-sans-bold">Technológiai fejlesztések</div>
                  <div class="text-gray-400 mt-1 dm-sans-regular">Cégünk folyamatosan nyomon követi a legújabb technológiai fejlesztéseket a hang- és fénytechnika területén.</div>
               </div>
            </div>
         </div>
      </div>
      <!--Promo cards-->

      <!--Price offer-->
      <div ref="pricing" class="flex flex-col justify-center items-center mx-auto mt-24">
         <div class="flex flex-col w-full max-w-7xl px-8 justify-center items-center">
            <h2 class="text-ui-primary text-base/7 dm-sans-semibold mb-2 text-center">Árkalkulátor</h2>
            <h2 class="text-5xl dm-sans-bold text-white tracking-tight text-center">Árajánlat igénylés</h2>
            <p class="mt-6 text-lg/8 text-gray-300 dm-sans-regular text-center">Állítsa össze csomagját sajátos igényei szerint, hogy a legmegfelelőbb szolgáltatást tudjuk nyújtani önnek!</p>
         </div>

         <div class="flex flex-col w-full max-w-7xl px-8 justify-center items-center mt-10">
            <button @click="this.$router.push('/arajanlat')" class="rounded-full flex justify-center items-center border-none dm-sans-semibold bg-white hover:bg-gray-400 transition-colors px-6 py-3 text-4xl">
               Árkalkulátor
               <ArrowRightIcon class="ml-2 size-10 text-xl" />
            </button>
         </div>
      </div>
      <!--Price offer-->

      <!--Reviews-->
      <div ref="reviews" class="flex flex-col justify-center items-center mx-auto mt-24">
         <div class="flex flex-col w-full max-w-7xl px-8 justify-center items-center">
            <h2 class="text-ui-primary text-base/7 dm-sans-semibold mb-2">Vélemények</h2>
            <h2 class="text-5xl dm-sans-bold text-white tracking-tight">Rólunk mondták</h2>
            <p class="mt-6 text-lg/8 text-gray-300 dm-sans-regular text-center">Az elégedett ügyfelek szavai az egyik legjobb visszajelzés számunkra. Itt olvashatja, mit mondtak rólunk azok, akik már dolgoztak velünk.</p>
         </div>

         <div class="columns-1 lg:columns-4 gap-8 max-w-7xl px-8 mt-12">
            <div class="break-inside-avoid my-12 lg:my-0">
               <div class="rounded-lg divide-y divide-ui-card ring-1 ring-ui-ring shadow bg-ui-card">
                  <div class="flex flex-col px-4 py-5 sm:p-6">
                     <div>
                        <q class="text-gray-300">abore ullamco enim excepteur. In fugiat Lorem sit velit id veniam esse eiusmod non ea voluptate cupidatat reprehenderit ullamco dolore. Mollit laborum occaecat aliquip.</q>
                        <div class="flex items-center gap-3 mt-6 relative">
                           <span class="relative inline-flex items-center justify-center flex-shrink-0 rounded-full h-10 w-10 text-base">
                              <img class="rounded-full h-10 w-10 text-base" alt="Rose Roberson" src="https://i.pravatar.cc/120?img=1" loading="lazy" />
                           </span>
                           <div>
                              <p class="font-semibold text-white text-sm">Rose Roberson</p>
                              <p class="text-gray-400 text-sm">CEO at Company</p>
                           </div>
                        </div>
                     </div>
                  </div>
               </div>
            </div>

            <div class="break-inside-avoid my-12 lg:my-0">
               <div class="rounded-lg divide-y divide-ui-card ring-1 ring-ui-ring shadow bg-ui-card">
                  <div class="flex flex-col px-4 py-5 sm:p-6">
                     <div>
                        <q class="text-gray-300">abore ullamco enim excepteur. In fugiat Lorem sit velit id veniam esse eiusmod non ea voluptate cupidatat reprehenderit ullamco dolore. Mollit laborum occaecat aliquip.</q>
                        <div class="flex items-center gap-3 mt-6 relative">
                           <span class="relative inline-flex items-center justify-center flex-shrink-0 rounded-full h-10 w-10 text-base">
                              <img class="rounded-full h-10 w-10 text-base" alt="Rose Roberson" src="https://i.pravatar.cc/120?img=1" loading="lazy" />
                           </span>
                           <div>
                              <p class="font-semibold text-white text-sm">Rose Roberson</p>
                              <p class="text-gray-400 text-sm">CEO at Company</p>
                           </div>
                        </div>
                     </div>
                  </div>
               </div>

               <div class="rounded-lg divide-y divide-ui-card ring-1 ring-ui-ring shadow bg-ui-card mt-8">
                  <div class="flex flex-col px-4 py-5 sm:p-6">
                     <div>
                        <q class="text-gray-300">abore ullamco enim excepteur. In fugiat Lorem sit velit id veniam esse eiusmod non ea voluptate cupidatat reprehenderit ullamco dolore. Mollit laborum occaecat aliquip.</q>
                        <div class="flex items-center gap-3 mt-6 relative">
                           <span class="relative inline-flex items-center justify-center flex-shrink-0 rounded-full h-10 w-10 text-base">
                              <img class="rounded-full h-10 w-10 text-base" alt="Rose Roberson" src="https://i.pravatar.cc/120?img=1" loading="lazy" />
                           </span>
                           <div>
                              <p class="font-semibold text-white text-sm">Rose Roberson</p>
                              <p class="text-gray-400 text-sm">CEO at Company</p>
                           </div>
                        </div>
                     </div>
                  </div>
               </div>
            </div>

            <div class="break-inside-avoid my-12 lg:my-0">
               <div class="rounded-lg divide-y divide-ui-card ring-1 ring-ui-ring shadow bg-ui-card">
                  <div class="flex flex-col px-4 py-5 sm:p-6">
                     <div>
                        <q class="text-gray-300">abore ullamco enim excepteur. In fugiat Lorem sit velit.</q>
                        <div class="flex items-center gap-3 mt-6 relative">
                           <span class="relative inline-flex items-center justify-center flex-shrink-0 rounded-full h-10 w-10 text-base">
                              <img class="rounded-full h-10 w-10 text-base" alt="Rose Roberson" src="https://i.pravatar.cc/120?img=1" loading="lazy" />
                           </span>
                           <div>
                              <p class="font-semibold text-white text-sm">Rose Roberson</p>
                              <p class="text-gray-400 text-sm">CEO at Company</p>
                           </div>
                        </div>
                     </div>
                  </div>
               </div>

               <div class="rounded-lg divide-y divide-ui-card ring-1 ring-ui-ring shadow bg-ui-card mt-8">
                  <div class="flex flex-col px-4 py-5 sm:p-6">
                     <div>
                        <q class="text-gray-300">abore ullamco enim excepteur. In fugiat Lorem sit velit id veniam esse eiusmod non ea voluptate cupidatat reprehenderit ullamco dolore. Mollit laborum occaecat aliquip.</q>
                        <div class="flex items-center gap-3 mt-6 relative">
                           <span class="relative inline-flex items-center justify-center flex-shrink-0 rounded-full h-10 w-10 text-base">
                              <img class="rounded-full h-10 w-10 text-base" alt="Rose Roberson" src="https://i.pravatar.cc/120?img=1" loading="lazy" />
                           </span>
                           <div>
                              <p class="font-semibold text-white text-sm">Rose Roberson</p>
                              <p class="text-gray-400 text-sm">CEO at Company</p>
                           </div>
                        </div>
                     </div>
                  </div>
               </div>
            </div>

            <div class="break-inside-avoid my-12 lg:my-0">
               <div class="rounded-lg divide-y divide-ui-card ring-1 ring-ui-ring shadow bg-ui-card">
                  <div class="flex flex-col px-4 py-5 sm:p-6">
                     <div>
                        <q class="text-gray-300">abore ullamco enim excepteur. In fugiat Lorem sit velit id veniam esse eiusmod non ea voluptate cupidatat reprehenderit ullamco dolore. Mollit laborum occaecat aliquip.</q>
                        <div class="flex items-center gap-3 mt-6 relative">
                           <span class="relative inline-flex items-center justify-center flex-shrink-0 rounded-full h-10 w-10 text-base">
                              <img class="rounded-full h-10 w-10 text-base" alt="Rose Roberson" src="https://i.pravatar.cc/120?img=1" loading="lazy" />
                           </span>
                           <div>
                              <p class="font-semibold text-white text-sm">Rose Roberson</p>
                              <p class="text-gray-400 text-sm">CEO at Company</p>
                           </div>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </div>
      <!--Reviews-->

      <!--Footer-->
      <div></div>
      <!--Footer-->
   </div>
   <!--Main-->
</template>
