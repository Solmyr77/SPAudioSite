import { createRouter, createWebHistory } from "vue-router";
import HomeView from "../views/HomeView.vue";

const router = createRouter({
   history: createWebHistory(import.meta.env.BASE_URL),
   routes: [
      {
         path: "/zenekeres",
         name: "home",
         component: HomeView,
      },
      {
         path: "/arajanlat",
         name: "arajanlat",
         props: {
            termName: undefined,
         },
         component: () => import("../views/OfferView.vue"),
      },
      {
         path: "/",
         name: "zenekeres",
         component: () => import("../views/MusicView.vue"),
      },
      {
         path: "/secret/admin",
         name: "admin",
         component: () => import("../views/AdminView.vue"),
      },
      {
         path: "/aszf/:termName:currentDate",
         name: "aszf",
         component: () => import("../views/TermsView.vue"),
      },
   ],
});

export default router;
