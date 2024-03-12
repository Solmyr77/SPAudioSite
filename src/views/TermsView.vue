<script>
export default {
   data() {
      return {
         termName: undefined,
         currentDate: undefined,
      };
   },
   async mounted() {
      this.termName = this.$route.params.termName;
      this.currentDate = this.$route.params.currentDate;
   },
   beforeUnmount() {},
   methods: {},
};
</script>

<template>
   <h1 class="m-4 text-4xl font-serif">Általános Szerződési Feltételek</h1>
   <div class="ml-8 font-serif">
      <ol class="list-decimal list-inside">
         <li>
            <strong>Rendelés Leadása és Elfogadása</strong>
            <ol class="list-inside list-disc ml-8">
               <li>A rendezvénytechnikai szolgáltatásokra leadott rendelés kötelezettség nélküli.</li>
               <li>A Rendszerint jelzés és az időpont fixálása után a szolgáltató kötelezheti a Megrendelőt előleg fizetésére.</li>
            </ol>
         </li>
         <li>
            <strong>Előleg Fizetése</strong>
            <ol class="list-inside list-disc ml-8">
               <li>Az előleg fizetésére vonatkozó kötelezettség csak a Rendszerint jelzés és az időpont fixálása után lép hatályba.</li>
               <li>Az előleg összege a szolgáltatás típusától és összegétől függően a felek közötti megállapodás szerint kerül meghatározásra.</li>
            </ol>
         </li>
         <li>
            <strong>Jogdíjak</strong>
            <ol class="list-inside list-disc ml-8">
               <li>Jogdíjak előre történő bekérése a szolgáltatás típusától és jellegétől függően előfordulhat.</li>
               <li>A jogdíjak összege a felmerülő költségektől és a szolgáltatás jellegétől függően kerül meghatározásra, és a felek közötti megállapodás alapján fizetendő.</li>
            </ol>
         </li>
         <li>
            <strong>Megfelelőség</strong>
            <ol class="list-inside list-disc ml-8">
               <li>A szolgáltató köteles biztosítani, hogy a nyújtott szolgáltatások megfeleljenek a felek közötti megállapodásnak és a hatályos jogszabályoknak.</li>
               <li>A Megrendelő köteles biztosítani, hogy minden szükséges engedélyt és jogi kötelezettséget teljesítsen a rendezvénytechnikai szolgáltatások igénybevétele előtt.</li>
            </ol>
         </li>
         <li>
            <strong>Felelősség Korlátozása</strong>
            <ol class="list-inside list-disc ml-8">
               <li>A szolgáltató nem vállal felelősséget olyan esetekben, amelyek az ellenőrizhetetlen körülmények, mint például vis major, baleset vagy természeti katasztrófa miatt következnek be.</li>
               <li>A felek közötti megállapodás keretében a szolgáltató által nyújtott szolgáltatásokért és termékekért a szolgáltató maximális felelőssége az általa nyújtott szolgáltatások díjának összegére korlátozódik.</li>
            </ol>
         </li>
         <li>
            <strong>Jogi Viták Megoldása</strong>
            <ol class="list-inside list-disc ml-8">
               <li>A felek kötelesek minden esetleges vita megoldása érdekében először kölcsönösen megegyezni.</li>
               <li>Amennyiben a felek nem jutnak megegyezésre, a jogviták rendezése érdekében a felek választhatják az alternatív vitarendezési módszereket, mint például az arbitrációt vagy a bírósági eljárást.</li>
            </ol>
         </li>
         <li>
            <strong>Egyéb Rendeleti Feltételek</strong>
            <ol class="list-inside list-disc ml-8">
               <li>Az Általános Szerződési Feltételek kiegészíthetők egyéb specifikus feltételekkel, amelyek a felek közötti megállapodás részét képezik.</li>
            </ol>
         </li>
         <p class="ml-4">
            <strong>Ezek az általános szerződési feltételek kizárólagosan a Rendezvénytechnikai szolgáltatásokra vonatkoznak, és a felek közötti megállapodás részét képezik.</strong>
         </p>
      </ol>

      <p class="-ml-4 pt-6">Aláírás és Dátum:</p>
      <p class="-ml-4 pt-3">{{ termName }}, {{ currentDate }}</p>
      <p class="-ml-4 pt-3">Szolgáltató: Sándor Péter E.V. Megrendelő:</p>
   </div>
</template>

<style>
</style>
