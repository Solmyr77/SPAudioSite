<script setup>
import { ArrowRightIcon, ArrowLeftIcon, MusicalNoteIcon, LightBulbIcon, CameraIcon, VideoCameraIcon, SpeakerWaveIcon, MicrophoneIcon, FilmIcon, UsersIcon } from "@heroicons/vue/24/solid";
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
         sound: false,
         show: false,
         concert: false,
         live: false,
         total: 0,
         popup: false,
         error: false,
         errorMessage: "",
      };
   },
   async mounted() {
      this.$refs.headerTitle.addEventListener("click", () => {
         this.$router.push("/");
      });

      this.$refs.backButton.addEventListener("click", () => {
         this.$router.push("/");
      });

      this.calculateMargins();
   },
   methods: {
      calculateMargins() {
         let headerHeight = this.$refs.header.clientHeight;

         this.$refs.content.style.marginTop = `${headerHeight}px`;
      },
      termTest() {
         let currentDate = new Date();
         this.$router.push({ name: "aszf", params: { termName: this.$refs.nameInput.value, currentDate: currentDate } });
      },
      async sendEmail() {
         this.error = false;

         let nev = this.$refs.nameInput.value;
         let email = this.$refs.mailInput.value;
         let telefon = this.$refs.phoneInput.value;
         let datum = this.date;
         let helyszin = this.$refs.locationInput.value;
         let letszam = this.$refs.numberOfPeopleInput.value;
         let extraReqs = this.$refs.extraReqs.value;
         let sound = this.sound ? "Igen" : "Nem";
         let show = this.show ? "Igen" : "Nem";
         let concert = this.concert ? "Igen" : "Nem";
         let live = this.live ? "Igen" : "Nem";
         let dj = this.djService ? "Igen" : "Nem";
         let fenyek = this.lightsService ? "Igen" : "Nem";
         let foto = this.photoService ? "Igen" : "Nem";
         let video = this.videoService ? "Igen" : "Nem";

         datum = new Date(datum);

         let readableDate = `${datum.getFullYear()}.${datum.getMonth() + 1}.${datum.getDate()}. ${datum.getHours()}:${datum.getMinutes()}:${datum.getSeconds()}`

         let termsDate = new Date();
         let readableTermsDate = `${termsDate.getFullYear()}.${termsDate.getMonth() + 1}.${termsDate.getDate()}. ${termsDate.getHours()}:${termsDate.getMinutes()}:${termsDate.getSeconds()}`

         if (!this.$refs.termsAcceptCheckbox.checked) {
            this.popup = true;
            this.error = true;

            scrollTo(0, 0);

            this.errorMessage = "Az ÁSZF-et kötelező elfogadni!";

            setTimeout(() => {
               this.popup = false;
            }, 3500);

            return 0;
         }
         if (!nev || !email) {
            this.popup = true;
            this.error = true;

            scrollTo(0, 0);

            this.errorMessage = "A csillagos mezőket kötelező kitölteni!";

            setTimeout(() => {
               this.popup = false;
            }, 3500);

            return 0;
         } else {
            try {
               const response = await axios.post("https://spdisco.hu/api.php", {
                  message: `${nev}|||${email}|||${telefon}|||${readableDate}|||${helyszin}|||${letszam}|||${extraReqs}|||${sound}|||${show}|||${concert}|||${live}|||${dj}|||${fenyek}|||${foto}|||${video}|||${readableTermsDate}`,
               });

               console.log(response.data);
            } catch (error) {
               this.popup = true;
               this.error = true;

               scrollTo(0, 0);

               this.errorMessage = "Ismeretlen hiba történt!";

               setTimeout(() => {
                  this.popup = false;
               }, 3500);

               console.log(error);
               return 0;
            }

            this.$refs.main.style.overflow = "hidden";

            this.popup = true;

            scrollTo(0, 0);

            setTimeout(() => {
               this.$router.push("/");
            }, 3500);
         }
      },
   },
};
</script>

<template>
   <div ref="main" class="flex flex-col items-center w-vw-full min-h-screen bg-ui-background relative">
      <div ref="header" :class="{ 'filter blur pointer-events-none': popup, '': !popup }" class="flex justify-center items-center w-full py-4 fixed top-0 bg-ui-background z-50">
         <div class="basis-1/3 flex justify-start items-center w-full cursor-pointer">
            <h1 ref="backButton" class="flex justify-center items-center ml-5 text-white hover:text-gray-400 text-xl dm-sans-medium"><ArrowLeftIcon class="mr-1 size-8 text-xl" />Vissza</h1>
         </div>

         <h1 ref="headerTitle" class="dm-sans-bold text-3xl text-center text-white hover:text-gray-400 cursor-pointer basis-1/3">SP Audio</h1>

         <span class="basis-1/3"></span>
      </div>

      <div ref="popup" v-if="popup" class="flex justify-center items-center absolute top-64 z-50">
         <h1 v-if="error" class="text-red-500 dm-sans-medium p-12 text-xl bg-ui-background ring-ui-ring ring-1 rounded-xl">{{ errorMessage }}</h1>
         <h1 v-else class="text-white dm-sans-medium p-12 text-xl bg-ui-background ring-ui-ring ring-1 rounded-xl">A kérését <span class="text-ui-primary">fogadtuk</span>, hamarosan válaszolunk, további szép napot!</h1>
      </div>

      <div ref="content" :class="{ 'filter blur pointer-events-none': popup, '': !popup }" class="flex flex-col lg:flex-row justify-center items-start pb-24">
         <div class="flex flex-col justify-center items-start w-full h-full gap-12 pb-16 pt-8 lg:pt-0 lg:pb-0 lg:basis-1/2">
            <div class="flex flex-col h-16 justify-center items-center w-full">
               <h1 class="text-white text-4xl dm-sans-bold mt-3">Megrendelő adatai</h1>
               <p class="text-gray-300 text-lg dm-sans-regular text-center mt-3 px-2">Adja meg az elérhetőségeket és a rendezvény körülményeit!</p>
            </div>
            <div class="flex flex-col justify-center items-center w-full gap-2">
               <h2 class="flex justify-left items-center text-white text-2xl dm-sans-semibold w-3/4">Név<span>*</span></h2>
               <input ref="nameInput" class="flex justify-center items-center dm-sans-regular rounded-lg ring-ui-ring ring-1 bg-ui-card text-gray-300 w-3/4 py-2 px-4" type="text" name="" id="" />
            </div>

            <div class="flex flex-col justify-center items-center w-full gap-2">
               <h2 class="flex justify-left items-center text-white text-2xl dm-sans-semibold w-3/4">E-mail<span>*</span></h2>
               <input ref="mailInput" class="flex justify-center items-center dm-sans-regular rounded-lg ring-ui-ring ring-1 bg-ui-card text-gray-300 w-3/4 py-2 px-4" type="text" name="" id="" />
            </div>

            <div class="flex flex-col justify-center items-center w-full gap-2">
               <h2 class="flex justify-left items-center text-white text-2xl dm-sans-semibold w-3/4">Telefonszám</h2>
               <input ref="phoneInput" class="flex justify-center items-center dm-sans-regular rounded-lg ring-ui-ring ring-1 bg-ui-card text-gray-300 w-3/4 py-2 px-4" type="text" name="" id="" />
            </div>

            <div class="flex flex-col justify-center items-center w-full gap-2">
               <h2 class="flex justify-left items-center text-white text-2xl dm-sans-semibold w-3/4">Létszám</h2>
               <input ref="numberOfPeopleInput" class="flex justify-center items-center dm-sans-regular rounded-lg ring-ui-ring ring-1 bg-ui-card text-gray-300 w-3/4 py-2 px-4" type="text" name="" id="" />
            </div>

            <div class="flex flex-col justify-center items-center w-full gap-2">
               <h2 class="flex justify-left items-center text-white text-2xl dm-sans-semibold w-3/4">Esemény helyszíne</h2>
               <input ref="locationInput" class="flex justify-center items-center dm-sans-regular rounded-lg ring-ui-ring ring-1 bg-ui-card text-gray-300 w-3/4 py-2 px-4" type="text" name="" id="" />
            </div>

            <div class="flex flex-col justify-center items-center w-full gap-2">
               <h2 class="flex justify-left items-center text-white text-2xl dm-sans-semibold w-3/4">Esemény dátuma</h2>
               <div class="flex justify-center items-center w-3/4 rounded-xl">
                  <VueDatePicker v-model="date" dark />
               </div>
            </div>

            <div class="flex flex-col justify-center items-center w-full gap-2">
               <h2 class="flex justify-left items-center text-white text-2xl dm-sans-semibold w-3/4">Egyéb kérések</h2>
               <textarea ref="extraReqs" class="resize-none flex justify-center items-center dm-sans-regular rounded-lg ring-ui-ring ring-1 bg-ui-card text-gray-300 w-3/4 py-2 px-4 h-24" />
            </div>
         </div>

         <div class="flex justify-center items-center flex-col w-full h-full lg:basis-1/2">
            <div class="flex justify-center items-center flex-col w-11/12 gap-24">
               <div class="flex flex-col justify-center items-center basis-2/3 pb-16 lg:pb-0">
                  <div class="flex flex-col justify-center items-center">
                     <h2 class="text-white text-3xl dm-sans-bold mb-2">Szolgáltatásaink</h2>
                     <h2 class="text-gray-300 text-xl dm-sans-regular">Válasszon szolgáltatásaink közül!</h2>
                  </div>

                  <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 pt-8">
                     <div @click="sound = !sound" :class="{ 'ring-ui-primary ring-2': sound, 'ring-ui-ring ring-2': !sound }" class="flex justify-center items-center w-full h-full bg-ui-card rounded-xl p-4 cursor-pointer">
                        <div class="flex flex-col justify-center items-start w-full h-full pointer-events-none select-none">
                           <div class="flex justify-between items-center basis-1/3 w-full mb-3">
                              <h2 class="text-center text-white dm-sans-medium">Hangosítás</h2>
                              <h2 class="text-center text-white dm-sans-medium"><SpeakerWaveIcon class="size-6 fill-white" /></h2>
                           </div>

                           <div class="flex justify-center items-center basis-2/3 w-full">
                              <p class="text-left dm-sans-regular text-gray-300">Hangtechnikai felszereltségünk alkalmas kis, közepes vagy nagy rendezvények hangosítására.</p>
                           </div>
                        </div>
                     </div>

                     <div @click="concert = !concert" :class="{ 'ring-ui-primary ring-2': concert, 'ring-ui-ring ring-2': !concert }" class="flex justify-center items-center w-full h-full bg-ui-card rounded-xl p-4 cursor-pointer">
                        <div class="flex flex-col justify-center items-start w-full h-full pointer-events-none select-none">
                           <div class="flex justify-between items-center basis-1/3 w-full mb-3">
                              <h2 class="text-center text-white dm-sans-medium">Élő koncert</h2>
                              <h2 class="text-center text-white dm-sans-medium"><UsersIcon class="size-6 fill-white" /></h2>
                           </div>

                           <div class="flex justify-center items-center basis-2/3 w-full">
                              <p class="text-left dm-sans-regular text-gray-300">Koncert hangosítási szolgáltatásunk a tökéletes hangélményt nyújtja kisebb szabadtéri előadásokon is.</p>
                           </div>
                        </div>
                     </div>

                     <div @click="show = !show" :class="{ 'ring-ui-primary ring-2': show, 'ring-ui-ring ring-2': !show }" class="flex justify-center items-center w-full h-full bg-ui-card rounded-xl p-4 cursor-pointer">
                        <div class="flex flex-col justify-center items-start w-full h-full pointer-events-none select-none">
                           <div class="flex justify-between items-center basis-1/3 w-full mb-3">
                              <h2 class="text-center text-white dm-sans-medium">Műsorvezetés</h2>
                              <h2 class="text-center text-white dm-sans-medium"><MicrophoneIcon class="size-6 fill-white" /></h2>
                           </div>

                           <div class="flex justify-center items-center basis-2/3 w-full">
                              <p class="text-left dm-sans-regular text-gray-300">Vállaljuk műsőrszámok felkonferálását, valamint a rendezvény menetének koordinálását.</p>
                           </div>
                        </div>
                     </div>

                     <div @click="djService = !djService" :class="{ 'ring-ui-primary ring-2': djService, 'ring-ui-ring ring-2': !djService }" class="flex justify-center items-center w-full h-full bg-ui-card rounded-xl p-4 cursor-pointer">
                        <div class="flex flex-col justify-center items-start w-full h-full pointer-events-none select-none">
                           <div class="flex justify-between items-center basis-1/3 w-full mb-3">
                              <h2 class="text-center text-white dm-sans-medium">Rendezvény DJ</h2>
                              <h2 class="text-center text-white dm-sans-medium"><MusicalNoteIcon class="size-6 fill-white" /></h2>
                           </div>

                           <div class="flex justify-center items-center basis-2/3 w-full">
                              <p class="text-left dm-sans-regular text-gray-300">Vállaljuk rendezvényeken a közönség szórakoztatását és a jó hangulatot. Egyedi zenekérő oldalunkon a vendégek élőben alakíthatják a zenei repertoárt.</p>
                           </div>
                        </div>
                     </div>

                     <div @click="lightsService = !lightsService" :class="{ 'ring-ui-primary ring-2': lightsService, 'ring-ui-ring ring-2': !lightsService }" class="flex justify-center items-center w-full h-full bg-ui-card rounded-xl p-4 cursor-pointer">
                        <div class="flex flex-col justify-between items-start w-full h-full pointer-events-none select-none">
                           <div class="flex justify-between items-center basis-1/3 w-full mb-3">
                              <h2 class="text-center text-white dm-sans-medium">Extra fények</h2>
                              <h2 class="text-center text-white dm-sans-medium"><LightBulbIcon class="size-6 fill-white" /></h2>
                           </div>

                           <div class="flex justify-center items-center basis-2/3 w-full">
                              <p class="text-left dm-sans-regular text-gray-300">Alapfelszereltségünkön túl, ha extra fényeket, szeretne akkor az <span class="dm-sans-semibold text-ui-primary">MM Lights</span> segítségével tudjuk biztosítani a kérést.</p>
                           </div>
                        </div>
                     </div>

                     <div @click="photoService = !photoService" :class="{ 'ring-ui-primary ring-2': photoService, 'ring-ui-ring ring-2': !photoService }" class="flex justify-center items-center w-full h-full bg-ui-card rounded-xl p-4 cursor-pointer">
                        <div class="flex flex-col justify-center items-start w-full h-full pointer-events-none select-none">
                           <div class="flex justify-between items-center basis-1/3 w-full mb-3">
                              <h2 class="text-center text-white dm-sans-medium">Fotózás</h2>
                              <h2 class="text-center text-white dm-sans-medium"><CameraIcon class="size-6 fill-white" /></h2>
                           </div>

                           <div class="flex justify-center items-center basis-2/3 w-full">
                              <p class="text-left dm-sans-regular text-gray-300">Legyen minden pillanat megörökítve! Rögzítjük az emlékezetes pillanatokat.</p>
                           </div>
                        </div>
                     </div>

                     <div @click="videoService = !videoService" :class="{ 'ring-ui-primary ring-2': videoService, 'ring-ui-ring ring-2': !videoService }" class="flex justify-center items-center w-full h-full bg-ui-card rounded-xl p-4 cursor-pointer">
                        <div class="flex flex-col justify-center items-start w-full h-full pointer-events-none select-none">
                           <div class="flex justify-between items-center basis-1/3 w-full mb-3">
                              <h2 class="text-center text-white dm-sans-medium">Videókészítés</h2>
                              <h2 class="text-center text-white dm-sans-medium"><FilmIcon class="size-6 fill-white" /></h2>
                           </div>

                           <div class="flex justify-center items-center basis-2/3 w-full">
                              <p class="text-left dm-sans-regular text-gray-300">Mozgóképet készítünk amivel felidézhetik az esemény hangulatát és pillanatait.</p>
                           </div>
                        </div>
                     </div>

                     <div @click="live = !live" :class="{ 'ring-ui-primary ring-2': live, 'ring-ui-ring ring-2': !live }" class="flex justify-center items-center w-full h-full bg-ui-card rounded-xl p-4 cursor-pointer">
                        <div class="flex flex-col justify-center items-start w-full h-full pointer-events-none select-none">
                           <div class="flex justify-between items-center basis-1/3 w-full mb-3">
                              <h2 class="text-center text-white dm-sans-medium">Élő közvetítés</h2>
                              <h2 class="text-center text-white dm-sans-medium"><VideoCameraIcon class="size-6 fill-white" /></h2>
                           </div>

                           <div class="flex justify-center items-center basis-2/3 w-full">
                              <p class="text-left dm-sans-regular text-gray-300">Mozgóképet készítünk amivel felidézhetik az esemény hangulatát és pillanatait.</p>
                           </div>
                        </div>
                     </div>
                  </div>
               </div>

               <div class="flex flex-col justify-center items-center basis-1/3 pb-10 lg:pb-0">
                  <div class="flex w-full justify-center items-center mb-12 lg:mb-3">
                     <div class="flex justify-center items-center w-4/5 lg:w-full">
                        <input ref="termsAcceptCheckbox" class="size-4 mr-3 accent-ui-primary" type="checkbox" name="termsAccept" />
                        <p class="text-gray-300 dm-sans-regular text-left">Elolvastam és elfogadom az <a target="_blank" class="text-ui-primary hover:text-violet-300" href="https://spdisco.hu/aszf.html">Általános Szerződési Feltételeket</a>.</p>
                     </div>
                  </div>
                  <button @click="sendEmail()" ref="offerButton" class="rounded-full flex justify-center items-center border-none dm-sans-semibold bg-white hover:bg-gray-400 transition-colors px-6 py-3 text-4xl">
                     Küldés
                     <ArrowRightIcon class="ml-2 size-16 text-xl" />
                  </button>
               </div>
            </div>
         </div>
      </div>
   </div>
</template>

<style>
@import "../assets/main.css";
</style>
