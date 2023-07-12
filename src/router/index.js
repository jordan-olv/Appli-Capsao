// import { createRouter, createWebHistory } from '@ionic/vue-router';
// import HomePage from '../views/HomeView.vue';

// const routes = [
//   {
//     path: '/',
//     name: 'Home',
//     component: HomePage
//   },
//   {
//     path: '/radio',
//     name: 'Radio',
//     component: () => import('@/views/RadioView.vue')
//   },
//   {
//     path: '/agenda',
//     name: 'Agenda',
//     component: () => import('@/views/AgendaView.vue')
//   },
//   // {
//   //   path: '/agenda/:id',
//   //   name: 'AgendaDetail',
//   //   component: () => import('@/views/AgendaDetailView.vue')
//   // },
//   {
//     path: '/podcast',
//     name: 'Podcast',
//     component: () => import('@/views/PodcastView.vue')
//   },
//   // {
//   //   path: '/podcast/:id',
//   //   name: 'PodcastDetail',
//   //   component: () => import('@/views/PodcastDetailView.vue')
//   // },


// ]

// const router = createRouter({
//   history: createWebHistory(import.meta.env.BASE_URL),
//   routes
// })

// export default router


import { createRouter, createWebHistory } from '@ionic/vue-router';
import TheNav from '@/components/TheNav.vue';
import HomePage from '../views/HomeView.vue';
import ThePlayer from '@/components/ThePlayer.vue';
import { usePlayerStore } from "@/store/radioPlayer";
import { onMounted } from 'vue';


const routes = [

  {
    path: '/',
    component: TheNav,
    children: [
      {
        path: '/',
        component: HomePage,
      },
      {
        path: 'radio',
        component: () => import('@/views/RadioView.vue'),
      },
      {
        path: 'agenda',
        component: () => import('@/views/AgendaView.vue'),
      },
      {
        path: 'podcast',
        component: () => import('@/views/PodcastView.vue'),
      },
      {
        path: 'podcastitem',
        name: 'PodcastId',
        props: true,
        component: () => import('@/views/PodcastIdView.vue'),
      }
      // {
      //   path: 'library',
      //   component: () => import('@/views/LibraryView.vue'),
      // },
      // {
      //   path: 'search',
      //   component: () => import('@/views/SearchView.vue'),
      // },
    ],
  },
];

const router = createRouter({
  // Use: createWebHistory(process.env.BASE_URL) in your app
  history: createWebHistory(),
  routes,
});

router.beforeEach(async (to, from, next) => {



  const store = usePlayerStore();

  // await store.refreshRadio();

  if (to.path === '/radio') {
    store.showPlayer();
    store.showFullPlayer();
  }

  if (from.path === '/radio') {
    store.showPlayer();
    store.hideFullPlayer();
  }
  next();
});


export default router;