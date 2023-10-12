// Composables
import { createRouter, createWebHistory } from 'vue-router'
import store from "../store";
import { log } from 'console';

const routes = [
  {
    path: '/',
    component: () => import('@/layouts/default/Default.vue'),
    meta: {requiresAuth: true},
    children: [
      {
        path: '',
        name: 'Home',
        component: () => import( '@/views/Home.vue'),
      },
      {
        path: '/tasks/create',
        name: 'tasks.create',
        component: () => import( '@/views/Tasks/Create.vue'),
      },
      {
        path: '/tasks/:id/edit',
        name: 'tasks.edit',
        component: () => import( '@/views/Tasks/Edit.vue'),
      },
    ],
  },
  {
    path: '/',
    component: () => import('@/layouts/authentication/Default.vue'),
    meta: { guest: true },
    children: [
      {
        path: '/login',
        name: 'Login',
        component: () => import( '@/views/Auth/Login.vue'),
      },
      {
        path: '/register',
        name: 'Register',
        component: () => import( '@/views/Auth/Register.vue'),
      },
    ],
  },
]

const router = createRouter({
  history: createWebHistory(process.env.BASE_URL),
  routes,
})

router.beforeEach((to, from, next) => {
  if (to.matched.some((record) => record.meta.requiresAuth)) {
    if (store.getters.isAuthenticated) {
      next();
      return;
    }
    next("/login");
  } else {
    next();
  }
});

router.beforeEach((to, from, next) => {
  if (to.matched.some((record) => record.meta.guest)) {
    if (store.getters.isAuthenticated) {
      next("/");
      return;
    }
    next();
  } else {
    next();
  }
});

export default router
