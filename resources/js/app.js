import './bootstrap';
import { createApp } from 'vue';
import router from './router';
import store from './store/index.js';
import app from './App.vue'
// Import our custom CSS
import '../css/app.scss'

import VueSweetalert2 from 'vue-sweetalert2';
import 'sweetalert2/dist/sweetalert2.min.css';

//import Nofity from './components/tm.vue';
//Mixins
import GlobalMethods from './common.js'


const vueApp = createApp(app)

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
vueApp.mount("#app")

