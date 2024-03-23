<script setup>
import { FacebookIcon, InstagramIcon, XIcon, SoundCloudIcon, YouTubeIcon } from "vue3-simple-icons";
import { BuildingLibraryIcon, ArrowRightIcon, CogIcon, CheckIcon, UserIcon, SpeakerWaveIcon, CurrencyDollarIcon, ChartBarIcon, Bars3Icon, XMarkIcon, CubeIcon, CreditCardIcon, AcademicCapIcon, ChevronDownIcon, DocumentTextIcon } from "@heroicons/vue/24/solid";
</script>

<script>
export default {
   data() {
      return {
         isMenuVisible: false,
         activeMenuItem: "",
         contactMenu: false,
         isScrolling: false,
         cookieMenu: false,
         images: [],
         imgLoadedFlag: false,
      };
   },
   async mounted() {
      let allImages = [...document.querySelectorAll("img")];

      const imgPromises = allImages.map(img => new Promise(response => img.onload = () => response([img.width, img.height])));

      let start = Date.now();

      console.log("Started image loading . . .")

      Promise.all(imgPromises).then(data => {
         console.log("All images have loaded!")
         console.log(`Images have loaded in: ${Date.now() - start} ms`);
         this.imgLoadedFlag = true;
         this.handlePromoImages();
      });

      window.addEventListener("scroll", this.handleScroll);
      this.handleScroll();

      this.$refs.offerButton.addEventListener("click", () => {
         this.$router.push("/arajanlat");
      });

      this.$refs.titleOfferButton.addEventListener("click", () => {
         this.$router.push("/arajanlat");
      });
   },
   beforeUnmount() {
      window.removeEventListener("scroll", this.handleScroll);
   },
   methods: {
      handlePromoImages() {
         this.$nextTick(() => {
            this.$refs.promoImageContainer.style.backgroundImage = `url(./images/img_promo.webp)`;

            let counter = 1;
            setInterval(() => {
               this.$refs.promoImageContainer.style.backgroundImage = `url(./images/img${counter}.webp)`;

               counter++;
               if (counter == 13) {
                  counter = 1;
               }
            }, 3000)
         });
      },
      handleScroll() {
         document.onscrollend = () => {
            let viewPortHeight = window.innerHeight;

            let detailsDistanceToTop = window.scrollY + this.$refs.details.getBoundingClientRect().top - this.$refs.header.clientHeight;
            let detailsBottomDistanceToTop = window.scrollY + this.$refs.details.getBoundingClientRect().bottom;

            let pricingDistanceToTop = window.scrollY + this.$refs.pricing.getBoundingClientRect().top - this.$refs.header.clientHeight;
            let pricingBottomDistanceToTop = window.scrollY + this.$refs.pricing.getBoundingClientRect().bottom;

            let technologyDistanceToTop = window.scrollY + this.$refs.technology.getBoundingClientRect().top - this.$refs.header.clientHeight;
            let technologyBottomDistanceToTop = window.scrollY + this.$refs.technology.getBoundingClientRect().bottom;

            let reviewsDistanceToTop = window.scrollY + this.$refs.reviews.getBoundingClientRect().top - this.$refs.header.clientHeight;
            let reviewsBottomDistanceToTop = window.scrollY + this.$refs.reviews.getBoundingClientRect().bottom;

            let impressumDistanceToTop = window.scrollY + this.$refs.impressum.getBoundingClientRect().top - this.$refs.header.clientHeight;
            let impressumBottomDistanceToTop = window.scrollY + this.$refs.impressum.getBoundingClientRect().bottom;

            if (scrollY + viewPortHeight / 2 >= detailsDistanceToTop && scrollY + viewPortHeight / 2 <= detailsBottomDistanceToTop) {
               this.activeMenuItem = "details";
            } else if (scrollY + viewPortHeight / 2 >= pricingDistanceToTop && scrollY + viewPortHeight / 2 <= pricingBottomDistanceToTop) {
               this.activeMenuItem = "pricing";
            } else if (scrollY + viewPortHeight / 2 >= reviewsDistanceToTop && scrollY + viewPortHeight / 2 <= reviewsBottomDistanceToTop) {
               this.activeMenuItem = "reviews";
            } else if (scrollY + viewPortHeight / 2 >= technologyDistanceToTop && scrollY + viewPortHeight / 2 <= technologyBottomDistanceToTop) {
               this.activeMenuItem = "technology";
            } else if (scrollY + viewPortHeight / 2 >= impressumDistanceToTop && scrollY + viewPortHeight / 2 <= impressumBottomDistanceToTop) {
               this.activeMenuItem = "impressum";
            } else {
               this.activeMenuItem = "none";
            }
         };
      },
      scrollAction(element) {
         const yOffset = -this.$refs.header.clientHeight;
         const y = element.getBoundingClientRect().top + window.scrollY + yOffset;
         window.scrollTo({ top: y, behavior: "smooth" });
      },
      scrollToElement(element) {
         switch (element) {
            case "top":
               window.scrollTo({ top: 0, behavior: "smooth" });
               this.activeMenuItem = "none";
               break;
            case "details":
               this.scrollAction(this.$refs.details);
               this.activeMenuItem = "details";
               break;

            case "pricing":
               this.scrollAction(this.$refs.pricing);
               this.activeMenuItem = "pricing";
               break;

            case "reviews":
               this.scrollAction(this.$refs.reviews);
               this.activeMenuItem = "reviews";
               break;

            case "technology":
               this.scrollAction(this.$refs.technology);
               this.activeMenuItem = "technology";
               break;

            case "impressum":
               this.scrollAction(this.$refs.impressum);
               this.activeMenuItem = "impressum";
               break;
         }
      },
      contactButtonAction() {
         this.contactMenu = !this.contactMenu;
      },
      handleCookieMenu() {
         this.cookieMenu = true;
      },
   },
};
</script>

<template>
   <!--Main-->
   <div class="flex flex-col justify-center items-center w-vw-full min-h-screen bg-ui-background relative">
      <!--Cookie menu-->
      <div v-if="!cookieMenu"
         class="fixed bottom-12 left-1/2 z-50 -translate-x-1/2 rounded-full bg-ui-background p-2 max-sm:w-11/12 ring-1 ring-ui-ring"
         id="gdpr">
         <div class="flex items-center justify-between gap-6 text-sm">
            <div class="content-left pl-4 text-white">Ez az oldal nem használ cookie-kat.</div>
            <div class="content-right text-end">
               <button @click="handleCookieMenu()"
                  class="cursor-pointer rounded-full bg-white px-4 py-2 text-ui-background dm-sans-bold">OK</button>
            </div>
         </div>
      </div>
      <!--Cookie menu-->

      <!--Header-->
      <div ref="header"
         class="invisible lg:visible flex justify-center items-center w-full py-4 dm-sans-medium mx-auto fixed top-0 z-50 bg-ui-background">
         <div class="flex justify-between items-center w-full max-w-7xl h-full relative">
            <!--Inline title-->
            <div class="flex justify-start items-center cursor-pointer basis-1/3 select-none">
               <h1 @click="scrollToElement('top')"
                  class="text-white text-xl dm-sans-bold antialiased hover:text-gray-400 transition-colors">SP Audio
               </h1>
            </div>
            <!--Inline title-->

            <!--Nav-->
            <div class="flex justify-center items-center rounded-3xl h-full ring-ui-ring ring-1 px-2 py-1 select-none">
               <div class="px-4 py-1.5">
                  <p @click="scrollToElement('details')"
                     :class="{ 'text-white': activeMenuItem == 'details', 'text-gray-400': activeMenuItem != 'details' }"
                     class="text-sm cursor-pointer transition-colors duration-75">Részletek</p>
               </div>

               <div class="px-4 py-1.5">
                  <p @click="scrollToElement('pricing')"
                     :class="{ 'text-white': activeMenuItem == 'pricing', 'text-gray-400': activeMenuItem != 'pricing' }"
                     class="text-sm cursor-pointer transition-opacity">Árajánlat</p>
               </div>

               <div class="px-4 py-1.5">
                  <p @click="scrollToElement('technology')"
                     :class="{ 'text-white': activeMenuItem == 'technology', 'text-gray-400': activeMenuItem != 'technology' }"
                     class="text-sm cursor-pointer transition-opacity">Technika</p>
               </div>

               <div class="px-4 py-1.5">
                  <p @click="scrollToElement('reviews')"
                     :class="{ 'text-white': activeMenuItem == 'reviews', 'text-gray-400': activeMenuItem != 'reviews' }"
                     class="text-sm cursor-pointer transition-opacity">Vélemények</p>
               </div>

               <div class="px-4 py-1.5">
                  <p @click="scrollToElement('impressum')"
                     :class="{ 'text-white': activeMenuItem == 'impressum', 'text-gray-400': activeMenuItem != 'impressum' }"
                     class="text-sm cursor-pointer transition-opacity">Impresszum</p>
               </div>


            </div>
            <!--Nav-->

            <!--Inline title-->
            <div class="flex flex-col justify-end items-center gap-1 basis-1/3">
               <div class="flex justify-end items-center w-full select-none">
                  <h1 @click="contactButtonAction()"
                     class="text-white text-xl dm-sans-semibold antialiased z-50 cursor-pointer">Kapcsolat</h1>
                  <ChevronDownIcon @click="contactButtonAction()" class="size-6 fill-white z-50 cursor-pointer" />
               </div>

               <div v-if="contactMenu" class="flex justify-end items-center w-full absolute top-0 -right-5 rounded-xl">
                  <div class="text-gray-300 text-base ring-1 ring-ui-ring p-4 pt-12 bg-ui-background rounded-lg">
                     <a href="https://spdisco.hu/gdpr.html" class="cursor-pointer">Kapcsolat - GDPR</a>
                  </div>
               </div>
            </div>

            <!--Inline title-->
         </div>
      </div>
      <!--Header-->

      <!--Header phone-->
      <div
         class="visible lg:invisible flex-col justify-center items-center w-full dm-sans-medium mx-auto fixed top-0 z-50 bg-ui-background">
         <div class="flex justify-between items-center w-full max-w-7xl px-8 h-full border-ui-ring border-b-2 py-4">
            <!--Inline title-->
            <div @click="scrollToElement('top')" class="flex justify-center items-center select-none">
               <h1 class="text-white text-xl dm-sans-bold antialiased">SP Audio</h1>
            </div>
            <!--Inline title-->

            <!--Menu button-->
            <div class="flex justify-center items-center select-none">
               <h1 v-if="!isMenuVisible" class="text-white text-xl dm-sans-bold antialiased">
                  <Bars3Icon @click="isMenuVisible = true" class="size-8" />
               </h1>
               <h1 v-if="isMenuVisible" class="text-white text-xl dm-sans-bold antialiased">
                  <XMarkIcon @click="isMenuVisible = false" class="size-8" />
               </h1>
            </div>
            <!--Menu button-->
         </div>

         <!--Menu-->
         <div v-if="isMenuVisible"
            class="flex flex-col w-full h-64 justify-around items-start bg-ui-background border-ui-ring border-b-2 select-none">
            <h1 @click="scrollToElement('details')"
               :class="{ 'text-ui-primary': activeMenuItem == 'details', 'text-gray-400': activeMenuItem != 'details' }"
               class="dm-sans-semibold antialiased ml-8">
               <CubeIcon
                  :class="{ 'fill-ui-primary': activeMenuItem == 'details', 'fill-white': activeMenuItem != 'details' }"
                  class="size-8 inline mr-4" /> Részletek
            </h1>
            <h1 @click="scrollToElement('pricing')"
               :class="{ 'text-ui-primary': activeMenuItem == 'pricing', 'text-gray-400': activeMenuItem != 'pricing' }"
               class="dm-sans-semibold antialiased ml-8">
               <CreditCardIcon
                  :class="{ 'fill-ui-primary': activeMenuItem == 'pricing', 'fill-white': activeMenuItem != 'pricing' }"
                  class="size-8 inline mr-4" /> Árajánlat
            </h1>
            <h1 @click="scrollToElement('reviews')"
               :class="{ 'text-ui-primary': activeMenuItem == 'reviews', 'text-gray-400': activeMenuItem != 'reviews' }"
               class="dm-sans-semibold antialiased ml-8">
               <AcademicCapIcon
                  :class="{ 'fill-ui-primary': activeMenuItem == 'reviews', 'fill-white': activeMenuItem != 'reviews' }"
                  class="size-8 inline mr-4" /> Vélemények
            </h1>
            <h1 @click="scrollToElement('impressum')"
               :class="{ 'text-ui-primary': activeMenuItem == 'impressum', 'text-gray-400': activeMenuItem != 'impressum' }"
               class="dm-sans-semibold antialiased ml-8">
               <DocumentTextIcon
                  :class="{ 'fill-ui-primary': activeMenuItem == 'impressum', 'fill-white': activeMenuItem != 'impressum' }"
                  class="size-8 inline mr-4" /> Impresszum
            </h1>
            <a href="https://spdisco.hu/gdpr.html" class="dm-sans-semibold antialiased ml-8 text-gray-400">
               <BuildingLibraryIcon class="size-8 fill-white inline mr-4" /> Kapcsolat - GDPR
            </a>
         </div>
         <!--Menu-->
      </div>
      <!--Header phone-->

      <!--Title body-->
      <div class="flex flex-col justify-center items-center py-32 w-full h-full max-w-7xl px-8 mx-auto">
         <div class="mt-12 w-full h-full"></div>
         <h1
            class="flex justify-center items-center text-center text-3xl md:text-7xl dm-sans-bold antialiased text-white w-full h-full">
            Rendezvénytechnika</h1>
         <p class="flex justify-center items-center text-center text-lg dm-sans-regular text-gray-300 mt-6">Profi DJ,
            modern hang- , fotó- , videó- , és fénytechnika áll rendelkezésre esküvőkhöz, céges rendezvényekhez és
            nagyobb bulikhoz is.</p>
         <div class="mt-6 flex justify-center items-center w-full h-full">
            <button ref="titleOfferButton"
               class="rounded-full flex justify-center items-center border-none dm-sans-medium bg-white px-6 py-3 hover:bg-gray-400 transition-colors">
               Árajánlat

               <ArrowRightIcon class="ml-2 h-6 w-6 text-xl" />
            </button>
         </div>
      </div>
      <!--Title body-->

      <!--Promo image-->
      <div v-if="!imgLoadedFlag"
         class="flex justify-center items-center p-2 lg:p-4 rounded-xl max-w-7xl w-full h-full ring-1 ring-ui-ring mx-auto">
         <div ref="promoImageContainer" class="aspect-3/2 flex justify-center items-center h-full w-full rounded-xl">
            <img src="/images/img_promo.webp" alt="Promo kép" title="Promo kép" class="rounded-xl">
         </div>
      </div>

      <div v-else
         class="flex justify-center items-center p-2 lg:p-4 rounded-xl max-w-7xl w-full h-full ring-1 ring-ui-ring mx-auto">

         <div ref="promoImageContainer" alt="Promo képnézegető" title="Promo képnézegető"
            class="aspect-3/2 flex justify-center items-center h-full w-full ease-in-out duration-1000 rounded-xl bg-cover">
         </div>
      </div>
      <!--Promo image-->

      <!--Social media-->
      <div class="flex flex-col w-full justify-center items-center max-w-7xl px-8 mt-20 mx-auto">
         <h2 class="text-lg dm-sans-semibold antialiased text-white leading-8">Elérhetőségeink</h2>
         <div class="mx-auto mt-10 flex flex-wrap items-center justify-between w-full">
            <a href="https://www.facebook.com/profile.php?id=61557404903107">
               <FacebookIcon
                  class="size-10 lg:size-16 fill-white cursor-pointer hover:fill-gray-400 transition-colors" />
            </a>
            <a href="https://www.instagram.com/sandorpeteer">
               <InstagramIcon
                  class="size-10 lg:size-16 fill-white cursor-pointer hover:fill-gray-400 transition-colors" />
            </a>
            <a href="https://soundcloud.com/peter-electro">
               <SoundCloudIcon
                  class="size-10 lg:size-24 fill-white cursor-pointer hover:fill-gray-400 transition-colors" />
            </a>
            <a href="https://youtu.be/oExCixqfnoQ?si=ltQ5FuJ-qg2cTDgX">
               <YouTubeIcon
                  class="size-10 lg:size-16 fill-white cursor-pointer hover:fill-gray-400 transition-colors" />
            </a>
            <a href="https://twitter.com/SPaudio_Miskolc">
               <XIcon class="size-10 lg:size-16 fill-white cursor-pointer hover:fill-gray-400 transition-colors" />
            </a>
         </div>
      </div>
      <!--Social media-->

      <!--Promo cards-->
      <div ref="details" class="flex flex-col justify-center items-center mx-auto mt-24 max-w-7xl px-8">
         <div class="flex flex-col w-full max-w-7xl md:px-8 justify-center items-center">
            <h2 class="text-ui-primary text-base/7 dm-sans-semibold antialiased text-center">Részletek</h2>
            <h2 class="text-3xl lg:text-5xl dm-sans-bold antialiased text-white tracking-tight text-center">Miért
               válasszon minket?</h2>
            <p class="mt-6 text-lg/8 text-gray-300 dm-sans-regular text-center">Válasszon minket, hogy garantáltan
               felejthetetlenné varázsoljuk rendezvényét a legfrissebb technikai megoldásokkal és profi
               szolgáltatásainkkal!</p>
         </div>

         <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 lg:grid-rows-2 gap-8 mt-24">
            <div class="flex justify-center items-start rounded-xl ring-1 ring-ui-ring bg-ui-card">
               <div class="flex flex-col justify-center items-start px-4 py-5">
                  <div class="mb-3 mt-1 pointer-events-none">
                     <CogIcon class="size-8 fill-white stroke-0 bg-ui-card" />
                  </div>
                  <div class="text-white dm-sans-bold antialiased">Tapasztalat és szakértelem</div>
                  <div class="text-gray-400 mt-1 dm-sans-regular">Csapatunk olyan tapasztalt szakemberekből áll, akik
                     évek óta tevékenykednek a hang- és fénytechnika területén.</div>
               </div>
            </div>

            <div class="flex justify-center items-start rounded-xl ring-1 ring-ui-ring bg-ui-card">
               <div class="flex flex-col justify-center items-start px-4 py-5">
                  <div class="mb-3 mt-1 pointer-events-none">
                     <CheckIcon class="size-8 fill-white stroke-0 bg-ui-card" />
                  </div>
                  <div class="text-white dm-sans-bold antialiased">Egyedi megoldások</div>
                  <div class="text-gray-400 mt-1 dm-sans-regular">Nem állunk meg a bevett megoldásoknál. Minden
                     ügyfelünk számára egyedi megoldásokat kínálunk, figyelembe véve az egyedi igényeket és a rendezvény
                     jellegét.</div>
               </div>
            </div>

            <div class="flex justify-center items-start rounded-xl ring-1 ring-ui-ring bg-ui-card">
               <div class="flex flex-col justify-center items-start px-4 py-5">
                  <div class="mb-3 mt-1 pointer-events-none">
                     <UserIcon class="size-8 fill-white stroke-0 bg-ui-card" />
                  </div>
                  <div class="text-white dm-sans-bold antialiased">Ügyfélorientáltság</div>
                  <div class="text-gray-400 mt-1 dm-sans-regular">Rugalmasak vagyunk, és mindent megteszünk annak
                     érdekében, hogy az elképzeléseiknek megfelelően valósítsuk meg igényeiket.</div>
               </div>
            </div>

            <div class="flex justify-center items-start rounded-xl ring-1 ring-ui-ring bg-ui-card">
               <div class="flex flex-col justify-center items-start px-4 py-5">
                  <div class="mb-3 mt-1 pointer-events-none">
                     <SpeakerWaveIcon class="size-8 fill-white stroke-0 bg-ui-card" />
                  </div>
                  <div class="text-white dm-sans-bold antialiased">Hangminőség</div>
                  <div class="text-gray-400 mt-1 dm-sans-regular">Hangosításunk kristálytiszta hangzással tölti meg a
                     teret, hogy minden szó tökéletesen érthető legyen, és minden dallam életre keljen.</div>
               </div>
            </div>

            <div class="flex justify-center items-start rounded-xl ring-1 ring-ui-ring bg-ui-card">
               <div class="flex flex-col justify-center items-start px-4 py-5">
                  <div class="mb-3 mt-1 pointer-events-none">
                     <CurrencyDollarIcon class="size-8 fill-white stroke-0 bg-ui-card" />
                  </div>
                  <div class="text-white dm-sans-bold antialiased">Megfizethetőség</div>
                  <div class="text-gray-400 mt-1 dm-sans-regular">Tudjuk, hogy fontos szempont az ár, ezért törekszünk
                     arra, hogy versenyképes áron kínáljuk szolgáltatásainkat anélkül, hogy a minőséget
                     veszélyeztetnénk.</div>
               </div>
            </div>

            <div class="flex justify-center items-start rounded-xl ring-1 ring-ui-ring bg-ui-card">
               <div class="flex flex-col justify-center items-start px-4 py-5">
                  <div class="mb-3 mt-1 pointer-events-none">
                     <ChartBarIcon class="size-8 fill-white stroke-0 bg-ui-card" />
                  </div>
                  <div class="text-white dm-sans-bold antialiased">Technológiai fejlesztések</div>
                  <div class="text-gray-400 mt-1 dm-sans-regular">Cégünk folyamatosan nyomon követi a legújabb
                     technológiai fejlesztéseket a hang- és fénytechnika területén.</div>
               </div>
            </div>
         </div>
      </div>
      <!--Promo cards-->

      <!--Price offer-->
      <div ref="pricing" class="flex flex-col justify-center items-center mx-auto mt-24 py-24">
         <div class="flex flex-col w-full max-w-7xl px-2 md:px-8 justify-center items-center">
            <h2 class="text-ui-primary text-base/7 dm-sans-semibold antialiased mb-3 text-center">Árkalkulátor</h2>
            <h2 class="text-5xl dm-sans-bold antialiased text-white tracking-tight text-center">Árajánlat igénylés</h2>
            <p class="mt-6 text-lg/8 text-gray-300 dm-sans-regular text-center">Állítsa össze csomagját sajátos igényei
               szerint, hogy a legmegfelelőbb szolgáltatást tudjuk nyújtani önnek!</p>
         </div>

         <div class="flex flex-col w-full max-w-7xl px-8 justify-center items-center mt-16">
            <button ref="offerButton"
               class="rounded-full flex justify-center items-center border-none dm-sans-semibold antialiased bg-white hover:bg-gray-400 transition-colors px-6 py-3 text-4xl">
               Árkalkulátor
               <ArrowRightIcon class="ml-2 size-10 text-xl" />
            </button>
         </div>
      </div>
      <!--Price offer-->

      <!--Technology-->
      <div ref="technology" class="flex flex-col justify-center items-center mx-auto mt-24 max-w-7xl px-8">
         <div class="flex flex-col w-full max-w-7xl md:px-8 justify-center items-center">
            <h2 class="text-ui-primary text-base/7 dm-sans-semibold antialiased text-center">Technika</h2>
            <h2 class="text-3xl lg:text-5xl dm-sans-bold antialiased text-white tracking-tight text-center">
               Rendelkezésre álló technika</h2>
            <p class="mt-6 text-lg/8 text-gray-300 dm-sans-regular text-center">A rendelkezésre álló teljes technikánk
               lenyűgöző előadásokat tesz lehetővé minden rendezvényen.</p>
         </div>

         <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 lg:grid-rows-2 gap-8 mt-24">
            <div class="flex justify-center items-start rounded-xl ring-1 ring-ui-ring bg-ui-card">
               <div class="flex flex-col justify-between items-start px-4 py-5 h-full">
                  <div class="flex justify-between items-center w-full">
                     <div class="mb-3 mt-1 pointer-events-none"><img class="rounded-xl w-32" alt="HK Sub" title="HK Sub"
                           src="../images/tech/hksub.webp" /></div>
                     <div class="mb-3 mt-1 pointer-events-none"><img class="rounded-xl w-32" alt="HK Top" title="HK Top"
                           src="../images/tech/hktop.webp" /></div>
                  </div>

                  <div>
                     <div class="text-white dm-sans-bold antialiased">HK Audio Rendszer</div>
                     <div class="text-gray-400 mt-1 dm-sans-regular break-words">A HK PR:O 15" top és 18" szub ládáinak
                        kombinációja rendkívül erőteljes hangzást biztosít, kiváló hangminőség mellett, ami ideális
                        választás akár élő rendezvényekhez.</div>
                  </div>
               </div>
            </div>

            <div class="flex justify-center items-start rounded-xl ring-1 ring-ui-ring bg-ui-card">
               <div class="flex flex-col justify-between items-start px-4 py-5 h-full">
                  <div class="flex justify-between items-center w-full">
                     <div class="mb-3 mt-1 pointer-events-none"><img class="rounded-xl w-36" alt="the box Sub"
                           title="the box Sub" src="../images/tech/boxsub.webp" /></div>
                     <div class="mb-3 mt-1 pointer-events-none"><img class="rounded-xl w-36" alt="Proline erősító"
                           title="Proline erősító" src="../images/tech/proline.webp" /></div>
                  </div>

                  <div>
                     <div class="text-white dm-sans-bold antialiased">Extra Bass</div>
                     <div class="text-gray-400 mt-1 dm-sans-regular">Ezek a szubládák erős és tiszta basszust nyújtanak,
                        ideálisak nagyobb hangterekben való használatra, ahol mély és erőteljes hangzásra van szükség.
                     </div>
                  </div>
               </div>
            </div>

            <div class="flex justify-center items-start rounded-xl ring-1 ring-ui-ring bg-ui-card">
               <div class="flex flex-col justify-between items-start px-4 py-5 h-full">
                  <div class="flex justify-between items-center w-full">
                     <div class="mb-3 mt-1 pointer-events-none"><img class="rounded-xl h-28 rotate-90"
                           alt="Power Dynamics Monitor" title="Power Dynamics Monitor"
                           src="../images/tech/pdmonitor.webp" /></div>
                     <div class="mb-3 mt-1 pointer-events-none"><img class="rounded-xl h-40 rotate-90" alt="FBT Monitor"
                           title="FBT Monitor" src="../images/tech/fbmonitor.webp" /></div>
                  </div>

                  <div>
                     <div class="text-white dm-sans-bold antialiased">Monitor rendszer</div>
                     <div class="text-gray-400 mt-1 dm-sans-regular">A színpadon álló minden hangot tökéletes
                        pontossággal hallhat a monitor rendszerünkből, így biztosítva a maximális élményt és a kényelmet
                        a fellépőknek.</div>
                  </div>
               </div>
            </div>

            <div class="flex justify-center items-start rounded-xl ring-1 ring-ui-ring bg-ui-card">
               <div class="flex flex-col justify-between items-start px-4 py-5 h-full">
                  <div class="flex justify-between items-center w-full">
                     <div class="mb-3 mt-1 pointer-events-none"><img class="rounded-xl w-32" alt="Rode vezeték nélküli"
                           title="Rode vezeték nélküli" src="../images/tech/rode1.webp" /></div>
                     <div class="mb-3 mt-1 pointer-events-none"><img class="rounded-xl w-48"
                           alt="Accsoon vezeték nélküli" title="Accsoon vezeték nélküli"
                           src="../images/tech/acson.webp" /></div>
                  </div>

                  <div>
                     <div class="text-white dm-sans-bold antialiased">Vezeték nélküli rendszer</div>
                     <div class="text-gray-400 mt-1 dm-sans-regular">A RODE vezeték nélküli mikrofonok és az ACCSOON
                        vezeték nélküli videó rendszer kombinációja tökéletesen sima felvételeket és stream-elést tesz
                        lehetővé.</div>
                  </div>
               </div>
            </div>

            <div class="flex justify-center items-start rounded-xl ring-1 ring-ui-ring bg-ui-card">
               <div class="flex flex-col justify-between items-start px-4 py-5 h-full">
                  <div class="flex justify-between items-center w-full">
                     <div class="mb-3 mt-1 pointer-events-none"><img class="rounded-xl w-36" alt="FLX6 DJ Kontroller"
                           title="FLX6 DJ Kontroller" src="../images/tech/flx6.webp" /></div>
                     <div class="mb-3 mt-1 pointer-events-none"><img class="rounded-xl w-36" alt="Macbook Pro"
                           title="Macbook Pro" src="../images/tech/mac.webp" /></div>
                  </div>

                  <div>
                     <div class="text-white dm-sans-bold antialiased">DJ Kontroller</div>
                     <div class="text-gray-400 mt-1 dm-sans-regular">A Pioneer FLX6 DJ kontroller és a MacBook Pro
                        kombinációja tökéletesen összehangolt, professzionális DJ élményt nyújt minden alkalommal.</div>
                  </div>
               </div>
            </div>

            <div class="flex justify-center items-start rounded-xl ring-1 ring-ui-ring bg-ui-card">
               <div class="flex flex-col justify-between items-start px-4 py-5 h-full">
                  <div class="flex justify-between items-center w-full">
                     <div class="mb-3 mt-1 pointer-events-none"><img class="rounded-xl w-36" alt="Atem videó mixer"
                           title="Atem videó mixer" src="../images/tech/atem.webp" /></div>
                     <div class="mb-3 mt-1 pointer-events-none"><img class="rounded-xl w-32" alt="Zoom mixer"
                           title="Zoom mixer" src="../images/tech/zoommix.webp" /></div>
                  </div>

                  <div>
                     <div class="text-white dm-sans-bold antialiased">Keverők</div>
                     <div class="text-gray-400 mt-1 dm-sans-regular">A BlackMagic ATEM videókeverő és a Zoom L12-es
                        digitális keverőpult egyesítése az audiovizuális élmény legmagasabb szintjét garantálja minden
                        előadáson és eseményen.</div>
                  </div>
               </div>
            </div>

            <div class="flex justify-center items-start rounded-xl ring-1 ring-ui-ring bg-ui-card">
               <div class="flex flex-col justify-between items-start px-4 py-5 h-full">
                  <div class="flex justify-between items-center w-full">
                     <div class="mb-3 mt-1 pointer-events-none"><img class="rounded-xl w-36" alt="Canon kamera"
                           title="Canon kamera" src="../images/tech/canoncam.webp" /></div>
                     <div class="mb-3 mt-1 pointer-events-none"><img class="rounded-xl w-32" alt="Objektív"
                           title="Objektív" src="../images/tech/lens.webp" /></div>
                  </div>

                  <div>
                     <div class="text-white dm-sans-bold antialiased">Fotótechnika</div>
                     <div class="text-gray-400 mt-1 dm-sans-regular">A Canon termékeit használjuk, hogy minden pillanat
                        tökéletesen legyen megörökítve az elmosódás mentes képekért.</div>
                  </div>
               </div>
            </div>

            <div class="flex justify-center items-start rounded-xl ring-1 ring-ui-ring bg-ui-card">
               <div class="flex flex-col justify-between items-start px-4 py-5 h-full">
                  <div class="flex justify-between items-center w-full">
                     <div class="mb-3 mt-1 pointer-events-none"><img class="rounded-xl w-36" alt="Sony kamera"
                           title="Sony kamera" src="../images/tech/sonycam1.webp" /></div>
                     <div class="mb-3 mt-1 pointer-events-none"><img class="rounded-xl w-32" alt="Sony kamera"
                           title="Sony kamera" src="../images/tech/sonycam2.webp" /></div>
                  </div>

                  <div>
                     <div class="text-white dm-sans-bold antialiased">Videótechnika</div>
                     <div class="text-gray-400 mt-1 dm-sans-regular">A Sony AX43 és AX700 profi 4K kameráik garanciát
                        jelentenek a tökéletes képminőségű videók létrehozásában.</div>
                  </div>
               </div>
            </div>

            <div class="flex justify-center items-start rounded-xl ring-1 ring-ui-ring bg-ui-card">
               <div class="flex flex-col justify-between items-start px-4 py-5 h-full">
                  <div class="flex justify-between items-center w-full">
                     <div class="mb-3 mt-1 pointer-events-none"><img class="rounded-xl w-36" alt="Scarlett hangkártya"
                           title="Scarlett hangkártya" src="../images/tech/scarlett1.webp" /></div>
                     <div class="mb-3 mt-1 pointer-events-none"><img class="rounded-xl w-40" alt="Scarlett hangkártya"
                           title="Scarlett hangkártya" src="../images/tech/scarlett.webp" /></div>
                  </div>

                  <div>
                     <div class="text-white dm-sans-bold antialiased">Hangmodulok</div>
                     <div class="text-gray-400 mt-1 dm-sans-regular">A Focusrite Scarlett 18i20 teszi lehetővé a több
                        sávos élő felvételek készítését, biztosítva a kiváló hangminőséget és sokoldalúságot.</div>
                  </div>
               </div>
            </div>
         </div>
      </div>
      <!--Technology-->

      <!--Reviews-->
      <div ref="reviews" class="flex flex-col justify-center items-center mx-auto mt-24 mb-12">
         <div class="flex flex-col w-full max-w-7xl px-8 justify-center items-center">
            <h2 class="text-ui-primary text-base/7 dm-sans-semibold antialiased mb-2">Vélemények</h2>
            <h2 class="text-5xl dm-sans-bold antialiased text-white tracking-tight text-center">Rólunk mondták</h2>
            <p class="mt-6 text-lg/8 text-gray-300 dm-sans-regular text-center">Az elégedett ügyfelek szavai az egyik
               legjobb visszajelzés számunkra. Itt olvashatja, mit mondtak rólunk azok, akik már dolgoztak velünk.</p>
         </div>

         <div class="columns-1 lg:columns-4 gap-8 max-w-7xl px-8 mt-12">
            <div class="break-inside-avoid my-12 lg:my-0">
               <div class="rounded-lg divide-y divide-ui-card ring-1 ring-ui-ring shadow bg-ui-card">
                  <div class="flex flex-col px-4 py-5 sm:p-6">
                     <div>
                        <q class="text-gray-300">A születésnapi bulink nagyon jól sikerült, és mindenki jól szórakozott.
                           A cégük fantasztikus munkát végzett, és igazán emlékezetessé tették az eseményt.
                           Köszönjük!</q>
                     </div>
                  </div>
               </div>
            </div>

            <div class="break-inside-avoid my-12 lg:my-0">
               <div class="rounded-lg divide-y divide-ui-card ring-1 ring-ui-ring shadow bg-ui-card">
                  <div class="flex flex-col px-4 py-5 sm:p-6">
                     <div>
                        <q class="text-gray-300">A srácok egyszerűen zseniálisak voltak. Folyamatosan fenntartották a
                           hangulatot. Nemcsak profik, hanem elképesztően barátságosak is.</q>
                     </div>
                  </div>
               </div>

               <div class="rounded-lg divide-y divide-ui-card ring-1 ring-ui-ring shadow bg-ui-card mt-12 lg:mt-8">
                  <div class="flex flex-col px-4 py-5 sm:p-6">
                     <div>
                        <q class="text-gray-300">Az esküvőnkön minden tökéletesen működött, köszönhetően a srácoknak! A
                           hangulat végig király volt, és mindenki jól érezte magát. Csak ajánlani tudom őket mindenki
                           számára!</q>
                     </div>
                  </div>
               </div>
            </div>

            <div class="break-inside-avoid my-12 lg:my-0">
               <div class="rounded-lg divide-y divide-ui-card ring-1 ring-ui-ring shadow bg-ui-card">
                  <div class="flex flex-col px-4 py-5 sm:p-6">
                     <div>
                        <q class="text-gray-300">Köszönünk mindent! Eddigi életünk legjobb napja volt! Köszönjük a
                           szuper bulit és koncert hangulatot!</q>
                     </div>
                  </div>
               </div>

               <div class="rounded-lg divide-y divide-ui-card ring-1 ring-ui-ring shadow bg-ui-card mt-12 lg:mt-8">
                  <div class="flex flex-col px-4 py-5 sm:p-6">
                     <div>
                        <q class="text-gray-300">Nagyon jó bulit csaptak, nagyon jó volt végig a hangulat.
                           Felejthetetlenné tették a nagy napunkat. Bármi kérésünk volt Péter azonnal elintézte. </q>
                     </div>
                  </div>
               </div>
            </div>

            <div class="break-inside-avoid my-12 lg:my-0">
               <div class="rounded-lg divide-y divide-ui-card ring-1 ring-ui-ring shadow bg-ui-card">
                  <div class="flex flex-col px-4 py-5 sm:p-6">
                     <div>
                        <q class="text-gray-300">Nem lehetett volna jobb buli! A zene tökéletesen szólt, és a hangulat
                           végig tetőponton volt. Ha valaki a legjobb bulit akarja, amit valaha átélhet, velük nem fog
                           mellényúlni!</q>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </div>
      <!--Reviews-->

      <!--Map-->
      <div class="flex flex-col justify-between items-center max-w-7xl w-full lg:py-24">
         <div class="flex justify-center items-center mb-6 flex-col">
            <h2 class="text-ui-primary text-base/7 dm-sans-semibold antialiased mb-2">Térkép</h2>
            <h2 class="text-5xl dm-sans-bold antialiased text-white tracking-tight text-center">Telephelyünk</h2>
         </div>
         <div class="flex justify-center items-center w-full max-w-7xl px-4">
            <iframe class="rounded-xl ring-1 ring-ui-ring lg:w-full" alt="Térkép" title="Térkép"
               src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d666.5390231691204!2d20.78542805872192!3d48.06862989999999!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x4740a1ffbd0dbd33%3A0xb1325a16661ea3b9!2shangtechnika%20-%20f%C3%A9nytechnika%20-%20DJ%20-%20esk%C3%BCv%C5%91%20-%20rendezv%C3%A9ny%20-%20Miskolc%20vonz%C3%A1sk%C3%B6rzet%C3%A9ben!5e0!3m2!1sen!2sca!4v1710000759765!5m2!1sen!2sca"
               width="600" height="450" style="border: 0" allowfullscreen="" loading="lazy"
               referrerpolicy="no-referrer-when-downgrade"></iframe>
         </div>
      </div>
      <!--Map-->

      <!--Impressum-->
      <div ref="impressum" class="flex flex-col justify-between items-center max-w-7xl w-full lg:py-24 py-12">
         <div class="flex justify-center items-center mb-4 flex-col">
            <h2 class="text-ui-primary text-base/7 dm-sans-semibold antialiased mb-2">Adatok</h2>
            <h2 class="text-5xl dm-sans-bold antialiased text-white tracking-tight text-center">Impresszum</h2>
         </div>

         <div class="flex flex-col-reverse lg:flex-row-reverse w-10/12 items-start justify-between mt-12">

            <div class="flex flex-col justify-center items-center mt-12 lg:mt-0">
               <div class="flex w-full justify-center items-center">
                  <h1 class="text-white dm-sans-semibold text-3xl">Webtárhely szolgáltató adatai</h1>
               </div>

               <div class="flex w-full flex-col mt-3 lg:mt-5">
                  <p class="text-gray-400 dm-sans-regular text-base"><span class="text-lg text-gray-300">Cégnév:</span>
                     Nethely Kft.</p>
                  <p class="text-gray-400 dm-sans-regular text-base"><span
                        class="text-lg text-gray-300">Székhely:</span> 1115 Budapest, Halmi utca 29.</p>
                  <p class="text-gray-400 dm-sans-regular text-base"><span
                        class="text-lg text-gray-300">Fióktelep:</span> 6724 Szeged, Teréz utca 34.</p>
                  <p class="text-gray-400 dm-sans-regular text-base"><span class="text-lg text-gray-300">Webcím: </span>
                     <a class="text-ui-primary" href="https://www.nethely.hu/">https://www.nethely.hu/</a>
                  </p>
                  <p class="text-gray-400 dm-sans-regular text-base"><span class="text-lg text-gray-300">Elérhetőség:
                     </span><a class="text-ui-primary"
                        href="https://www.nethely.hu/rolunk">https://www.nethely.hu/rolunk</a></p>
               </div>
            </div>

            <div class="flex flex-col justify-center items-center">
               <div class="flex w-full justify-start items-center">
                  <h1 class="text-white dm-sans-semibold text-3xl">Vállalkozás adatai</h1>
               </div>

               <div class="flex w-full flex-col mt-3 lg:mt-5">
                  <p class="text-gray-400 dm-sans-regular text-base"><span class="text-lg text-gray-300">Cégnév:</span>
                     Sándor Péter E.V.</p>
                  <p class="text-gray-400 dm-sans-regular text-base"><span class="text-lg text-gray-300">Adószám:</span>
                     60963879-1-25</p>
                  <p class="text-gray-400 dm-sans-regular text-base"><span
                        class="text-lg text-gray-300">Székhely:</span> 3508 Miskolc, Világ u. 56.</p>
                  <p class="text-gray-400 dm-sans-regular text-base"><span class="text-lg text-gray-300">Levelezési
                        cím:</span> 3553 Kistokaj, Széchényi u. 81.</p>
                  <p class="text-gray-400 dm-sans-regular text-base"><span
                        class="text-lg text-gray-300">Telefonszám:</span> +36709421310</p>
                  <p class="text-gray-400 dm-sans-regular text-base"><span class="text-lg text-gray-300">E-mail
                        cím:</span> <a class="text-ui-primary" href="mailto:hang@spdisco.hu">hang@spdisco.hu</a></p>
                  <p class="text-gray-400 dm-sans-regular text-base"><span class="text-lg text-gray-300">Nyilvántartási
                        szám:</span> 25530680</p>
                  <p class="text-gray-400 dm-sans-regular text-base"><span
                        class="text-lg text-gray-300">Bankszámlaszám:</span> 11773346-00063997</p>
               </div>
            </div>

         </div>

      </div>
      <!--Impressum-->

      <!--Footer-->
      <div class="flex justify-center items-center w-full border-ui-ring border-t">
         <div class="flex flex-col justify-center items-center w-full py-4 basis-1/3">
            <h3 class="text-lg text-white ml-4 dm-sans-semibold mb-4">Dokumentumok</h3>
            <a class="text-gray-300 text-base ml-4 hover:text-gray-500 transition-colors dm-sans-regular"
               href="https://spdisco.hu/gdpr.html">Kapcsolat - GDPR</a>
         </div>
      </div>
      <!--Footer-->
   </div>

   <!--Img loader-->
   <div class="hidden">
      <img src="/images/img1.webp" alt="img1" title="img1">
      <img src="/images/img2.webp" alt="img2" title="img2">
      <img src="/images/img3.webp" alt="img3" title="img3">
      <img src="/images/img4.webp" alt="img4" title="img4">
      <img src="/images/img5.webp" alt="img6" title="img5">
      <img src="/images/img6.webp" alt="img6" title="img6">
      <img src="/images/img7.webp" alt="img7" title="img7">
      <img src="/images/img8.webp" alt="img8" title="img8">
      <img src="/images/img9.webp" alt="img9" title="img9">
      <img src="/images/img10.webp" alt="img10" title="img10">
      <img src="/images/img11.webp" alt="img11" title="img11">
      <img src="/images/img12.webp" alt="img12" title="img12">
   </div>
   <!--Img loader-->

   <!--Main-->
</template>

<style>
@import '../assets/main.css'
</style>
