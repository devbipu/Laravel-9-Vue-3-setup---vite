import './bootstrap';
import { createApp } from 'vue';
import router from './router';
import store from './store/index.js';
import App from './App.vue'
// Import our custom CSS
import '../css/app.scss'

import VueSweetalert2 from 'vue-sweetalert2';
import 'sweetalert2/dist/sweetalert2.min.css';

//import Nofity from './components/tm.vue';
//Mixins
import GlobalMethods from './common.js'

// Vue Localization 
import { i18nVue } from 'laravel-vue-i18n'
// import VueCookies from 'vue3-cookies'


const vueApp = createApp(App)

router.beforeEach((to, form) => {
	store.dispatch('setLoading', true)
})

router.beforeEach((to, form) => {
	store.dispatch('setLoading', false)
})

// vueApp.component('Nofity', Nofity)
vueApp.use(VueSweetalert2)
vueApp.mixin(GlobalMethods);
vueApp.use(router);
vueApp.use(store);
// vueApp.use(VueCookies);
vueApp.use(i18nVue, {
	resolve: async lang => {
        const langs = import.meta.glob('../../lang/*.json');
        return await langs[`../../lang/${lang}.json`]();
    }
})
vueApp.mount("#app")