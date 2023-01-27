import { createRouter, createWebHistory } from 'vue-router'
import store from '@/store'
import { __notify } from '@/composables'
const routes = [
    {
        path: '/',
        name: 'Home',
        component: () => import('@/pages/home.vue'),
    },
    {
        path: '/about',
        name: 'about',
        component: () => import('@/pages/about.vue'),
        meta: {
            requireAuth: true,
            permission: {
                read: true,
            }
        }
    },
    {
        path: '/login',
        name: 'Login',
        component: () => import('@/pages/login.vue'),
        meta: {
            requireAuth: false,
        },
    },
    {
        path: '/register',
        name: 'Register',
        component: () => import('@/pages/register.vue'),
        meta: {
            requireAuth: false,
        }
    },
    {
        path: '/fileupload',
        name: 'FileUpload',
        component: () => import('@/pages/fileupload.vue'),
        meta: {
            requireAuth: false,
        }
    },
    {
        path: '/dashboard',
        name: 'Dashboard',
        component: () => import('@/pages/dashboard.vue'),
        meta: {
            requireAuth: true,
            permission: {
                read: true,
                write: true,
                update: true,
                delete: true,
            }
        }
    },
];


const router = createRouter({
    mode: 'history',
    linkActiveClass: "active",
    history: createWebHistory(), 
    routes 
});


router.beforeEach((to, from) => {
    if (to.meta.requireAuth == true && store.getters.getToken == null) {
        __notify('Opps', 'Don\'t Have Enaugh Access', 'error')
        return {
            name: 'Login'
        }
    }
    if(to.meta.requireAuth == false && store.getters.getToken != null) {
        return {
            name: 'Dashbaord'
        }
    }
});



export default router;



