import { createRouter, createWebHistory } from 'vue-router'

const routes = [
    {
        path: '/',
        name: 'homepage',
        component: () => import('./pages/home.vue')
    },
    {
        path: '/about',
        name: 'about',
        component: () => import('./pages/about.vue')
    }
]
// const router = createRouter({
//   mode: 'history',
//   history: createWebHistory(import.meta.env.BASE_URL),
//   routes,
// })

const router = createRouter({
    mode: 'history',
    history: createWebHistory(), 
    routes 
});


export default router;