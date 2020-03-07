import Vue from 'vue';
import router from './routes';
import App from './App.vue';
import store from './store/store'
import { requiresAuth } from './middleware';
import utilMixins from './mixins/utils_mixins';
import VueIziToast from 'vue-izitoast'
import 'izitoast/dist/css/iziToast.min.css'

Vue.mixin(utilMixins);
Vue.use(VueIziToast);


router.beforeEach((to, from, next) => {
    requiresAuth(to, from, next, store.state)
})

let app = new Vue({
    el: '#app',
    router,
    store,
    render: h => h(App)
})


