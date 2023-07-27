import { createRouter, createWebHistory } from '@ionic/vue-router';
import TheNav from '@/components/TheNav.vue';
import HomePage from '../views/HomeView.vue';
import { usePlayerStore } from "@/store/radioPlayer";


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
        name: 'Agenda',
        component: () => import('@/views/AgendaView.vue'),
      },
      {
        path: 'podcast',
        component: () => import('@/views/PodcastView.vue'),
      },
      {
        path: 'podcast/:id',
        name: 'PodcastId',
        component: () => import('@/views/PodcastIdView.vue'),
      },
      {
        path: 'agenda/:id',
        name: 'AgendaId',
        component: () => import('@/views/AgendaIdView.vue'),
      }

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