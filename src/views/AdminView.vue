<script>
import PocketBase from "pocketbase";

class Setting {
   constructor(id, value) {
      this.id = id;
      this.value = value;
   }
}

export default {
   data() {
      return {
         zenek: [],
         pb: undefined,
         collection: undefined,
         settingsCollection: undefined,
         votesVisible: new Setting(0, 0),
         songsPerPerson: new Setting(0, 3),
         songLimit: new Setting(0, 1),
         isEnabled: new Setting(0, 1),
      };
   },
   async mounted() {
      this.pb = new PocketBase("https://sp.myddns.me/pb");

      this.pb.autoCancellation(false);

      this.collection = this.pb.collection("zenek");
      this.settingsCollection = this.pb.collection("settings");

      await this.getSettings();
      await this.getItems();

      this.songsPerPersonInput = this.songsPerPerson.value;

      this.collection.subscribe("*", () => this.getItems());
      this.settingsCollection.subscribe("*", () => this.getSettings());
   },
   methods: {
      async getItems() {
         const { items } = await this.collection.getList(1, 10000);
         this.zenek = items;

         this.zenek.sort((a, b) => b.votes - a.votes);
      },
      async resetVotes() {
         await this.clearUsers();

         for (let i = 0; i < this.zenek.length; i++) {
            const zene = this.zenek[i];
            await this.collection.update(zene.id, { votes: null });
         }

         await this.getItems();
      },
      async deleteRecord(id) {
         await this.collection.delete(id);
         await this.getItems();
      },
      async clearUsers() {
         for (let i = 0; i < this.zenek.length; i++) {
            const zene = this.zenek[i];
            await this.collection.update(zene.id, { uuid: null });
         }

         await this.getItems();
      },
      async deleteAll() {
         for (let i = 0; i < this.zenek.length; i++) {
            const zene = this.zenek[i];
            await this.collection.delete(zene.id);
         }

         await this.getItems();
      },
      async fixDB() {
         for (let i = 0; i < this.zenek.length; i++) {
            const zene = this.zenek[i];

            if (zene.lowercaseTitle != zene.title.toLowerCase()) {
               await this.collection.update(zene.id, {
                  lowercaseTitle: zene.title.toLowerCase(),
               });
            }
         }
      },
      async getSettings() {
         await this.settingsCollection.getList(1, 4).then((settings) => {
            settings.items.forEach((record) => {
               if (record.setting == "votesVisible") {
                  this.votesVisible = new Setting(record.id, record.value);
               } else if (record.setting == "songsPerPerson") {
                  this.songsPerPerson = new Setting(record.id, record.value);
               } else if (record.setting == "songLimit") {
                  this.songLimit = new Setting(record.id, record.value);
               } else if (record.setting == "isEnabled") {
                  this.isEnabled = new Setting(record.id, record.value);
               }
            });
         });
      },
      async setSongsPerPerson() {
         await this.settingsCollection.update(this.songsPerPerson.id, {
            value: this.songsPerPersonInput,
         });
      },
      async enableSite() {
         if (this.isEnabled.value == 0) {
            await this.settingsCollection.update(this.isEnabled.id, {
               value: 1,
            });
         }
         else {
            await this.settingsCollection.update(this.isEnabled.id, {
               value: 0,
            });
         }
      },
      async toggleSongLimit() {
         let newValue = 0;

         if (this.songLimit.value == 0) {
            newValue = 1;
         } else {
            newValue = 0;
         }

         await this.settingsCollection.update(this.songLimit.id, {
            value: newValue,
         });
      },
      async toggleVotesVisible() {
         let newValue = 0;

         if (this.votesVisible.value == 0) {
            newValue = 1;
         } else {
            newValue = 0;
         }

         await this.settingsCollection.update(this.votesVisible.id, {
            value: newValue,
         });
      },
   },
};
</script>

<template>
   <div class="items-center flex min-h-screen flex-col bg-custom-bg-dark text-white">
      <div
         class="grid grid-rows-7 lg:grid-rows-1 grid-cols-1 lg:grid-cols-12 grid-flow-col bg-custom-custom-elevation-3 w-full text-center elevation-3 justify-center items-center">

         <div class="lg:hidden lg:col-span-3 flex justify-around items-center border-b-4 py-2 border-stone-600">
            <h1 class="text-xl">Zenedoboz<br />By: Lori</h1>
            <h1 class="text-xl">Version: E3.0</h1>
         </div>

         <div
            class="flex items-center justify-center border-b-4 border-stone-600 lg:border-b-0 lg:border-r-2 lg:border-x-stone-600 h-full lg:col-span-2">
            <button @click="toggleSongLimit" class="text-white rounded-lg text-l p-1 mt-1 mb-1 lg:w-auto w-3/4" :class="[
               this.songLimit.value == 1
                  ? 'bg-rose-700 elevation-4 hover:bg-rose-500 active:bg-rose-950'
                  : 'bg-emerald-600  hover:bg-emerald-500 active:bg-emerald-800',
            ]">
               Turn request limit<br />{{
               this.songLimit.value == 1 ? "OFF" : "ON"
            }}
            </button>
         </div>

         <div
            class="flex items-center justify-center lg:border-x-2 lg:border-x-stone-600 h-full lg:col-span-2 border-b-4 border-stone-600 lg:border-b-0">
            <button @click="toggleVotesVisible"
               class="bg-emerald-600 elevation-4 hover:bg-emerald-500 text-white rounded-lg text-l p-1 mt-1 mb-1 lg:w-auto w-3/4"
               :class="[
                  this.votesVisible.value == 1
                     ? 'bg-rose-700 elevation-4 hover:bg-rose-500 active:bg-rose-950'
                     : 'bg-emerald-600  hover:bg-emerald-500 active:bg-emerald-800',
               ]">
               Turn votes visible<br />{{
               this.votesVisible.value == 1 ? "OFF" : "ON"
            }}
            </button>
         </div>

         <div
            class="flex lg:hidden items-center justify-center lg:col-span-2 lg:border-l-2 lg:border-r-4 lg:border-x-stone-600 h-full border-b-4 border-stone-600 lg:border-b-0">
            <div class="flex w-3/4 justify-between">
               <button @click="setSongsPerPerson"
                  class="w-3/5 bg-emerald-600 elevation-4 hover:bg-emerald-500 text-white rounded-lg text-l p-1 mt-1 mb-1 active:bg-emerald-800">
                  Set requests <br> per person
               </button>

               <div class="w-2/5 flex justify-center items-center">
                  <input class="text-black w-3/4 text-center h-3/4 text-2xl" type="number" min="1" max="999"
                     v-model="songsPerPersonInput" />
               </div>
            </div>
         </div>

         <div
            class="hidden lg:flex items-center justify-center lg:col-span-2 lg:border-l-2 lg:border-r-4 lg:border-x-stone-600 h-full border-b-4 border-stone-600 lg:border-b-0">
            <button @click="setSongsPerPerson"
               class="w-2/5 bg-emerald-600 elevation-4 hover:bg-emerald-500 text-white rounded-lg text-l p-1 mt-1 mb-1 active:bg-emerald-800">
               Set requests <br> per person
            </button>

            <div class="w-2/5 flex justify-center items-center">
               <input class="text-black w-3/4 text-center" type="number" min="1" max="999"
                  v-model="songsPerPersonInput" />
            </div>
         </div>

         <div class="hidden lg:col-span-3 lg:flex justify-around items-center">
            <h1 class="text-xl">Zenedoboz<br />By: Lori</h1>
            <h1 class="text-xl">Version: E3.0</h1>
         </div>

         <div
            class="flex items-center justify-center lg:border-l-4 lg:border-r-2 lg:border-x-stone-600 h-full border-b-4 border-stone-600 lg:border-b-0">
            <button @click="deleteAll"
               class="w-3/4 bg-rose-700 elevation-4 hover:bg-rose-500 text-white rounded-lg text-l p-1 mt-1 mb-1 active:bg-rose-950">
               Delete<br />all
            </button>
         </div>

         <div
            class="flex items-center justify-center lg:border-x-2 lg:border-x-stone-600 h-full border-b-4 border-stone-600 lg:border-b-0">
            <button @click="resetVotes"
               class="w-3/4 bg-rose-700 elevation-4 hover:bg-rose-500 text-white rounded-lg text-l p-1 mt-1 mb-1 active:bg-rose-950">
               Reset<br />votes
            </button>
         </div>

         <div
            class="flex items-center justify-center lg:border-l-2 lg:border-x-stone-600 h-full border-b-4 border-stone-600 lg:border-b-0">
            <button @click="enableSite" class="w-3/4 text-white rounded-lg text-l p-1 mt-1 mb-1 h-3/4 lg:h-auto" :class="[
               this.isEnabled.value == 1
                  ? 'bg-rose-700 elevation-4 hover:bg-rose-500 active:bg-rose-950'
                  : 'bg-emerald-600  hover:bg-emerald-500 active:bg-emerald-800',
            ]">
               {{
               this.isEnabled.value == 1 ? "Disable ZeneDoboz" : "Enable ZeneDoboz"
            }}
            </button>
         </div>
      </div>

      <div class="hidden lg:flex items-center m-0 p-0 w-full">
         <ul class="text-center w-full overflow-y-auto mb-4">
            <li class="" v-for="item in zenek" :key="item.id">
               <div class="hover:bg-custom-custom-elevation-3 w-full grid grid-cols-36 pt-2 pb-2 gap-2 elevation-2">
                  <span></span>
                  <button
                     class="bg-rose-700 elevation-1 col-span-2 hover:bg-rose-500 active:bg-rose-950 text-white rounded-lg text-2xl py-1 px-3"
                     @click="deleteRecord(item.id)">
                     Delete
                  </button>
                  <span v-if="item.ytlink == ''"
                     class="text-3xl col-span-27 overflow-hidden flex items-center justify-center"><a target="_blank"
                        class="hover:text-gray-400" :href="`https://www.google.com/search?q=${item.title}`">{{
               item.title }}</a><br /><span class="text-red-400"><a class="hover:text-red-500"
                           :href="item.ytlink">{{
               item.ytlink
            }}</a></span></span>
                  <span v-else class="text-3xl col-span-27 overflow-hidden">{{ item.title }}<br /><span
                        class="text-red-400"><a target="_blank" class="hover:text-red-500" :href="item.ytlink">{{
               item.ytlink }}</a></span></span>
                  <span :class="[
               item.votes == 0
                  ? 'text-blue-400'
                  : item.votes < 0
                     ? 'text-red-600'
                     : item.votes > 0
                        ? 'text-emerald-600'
                        : '',
            ]" class="justify-center items-center flex text-3xl overflow-hidden col-span-2">{{ item.votes
                     }}</span>
               </div>
               <span></span>
            </li>
         </ul>
      </div>

      <div class="flex lg:hidden items-center m-0 p-0 w-full">
         <ul class="text-center w-full overflow-y-auto mb-4">
            <li class="" v-for="item in zenek" :key="item.id">
               <div class="hover:bg-custom-custom-elevation-3 w-full grid grid-cols-36 pt-2 pb-2 elevation-2">
                  <span></span>

                  <button
                     class="bg-rose-700 elevation-1 col-span-2 hover:bg-rose-500 active:bg-rose-950 text-white rounded-lg text-lg px-5 flex justify-center items-center"
                     @click="deleteRecord(item.id)">
                     Del
                  </button>

                  <span></span>
                  <span v-if="item.ytlink == ''"
                     class="text-xl col-span-32 overflow-hidden flex items-center justify-center text-wrap w-full"><a
                        target="_blank" class="hover:text-gray-400"
                        :href="`https://www.google.com/search?q=${item.title}`">{{
                        item.title }}</a><br /><span class="text-red-400"><a class="hover:text-red-500"
                           :href="item.ytlink">{{
                     item.ytlink
                  }}</a>
                  </span>
            
                  </span>
                  <span v-else class="text-xl col-span-32 overflow-hidden text-wrap">{{ item.title }}<br /><span
                        class="text-red-400"><a target="_blank" class="hover:text-red-500 text-base" :href="item.ytlink">{{
               item.ytlink }}</a></span>
                  </span>

                  <span></span>

                  <span :class="[
               item.votes == 0
                  ? 'text-blue-400'
                  : item.votes < 0
                     ? 'text-red-600'
                     : item.votes > 0
                        ? 'text-emerald-600'
                        : '',
            ]" class="justify-center items-center flex text-xl overflow-hidden col-span-2">{{ item.votes
                     }}
                  </span>
               </div>
               <span></span>
               <span></span>
            </li>
         </ul>
      </div>

   </div>

</template>

<style>
@import '../assets/main.css'
</style>
