import 'vue-loading-overlay/dist/vue-loading.css'
import 'izitoast/dist/css/iziToast.min.css'

import Vue from 'vue';
import router from './routes';
import App from './App.vue';
import store from './store/store'
import { requiresAuth } from './middleware';
import utilMixins from './mixins/utils_mixins';
import VueIziToast from 'vue-izitoast'
import VueLoading from 'vue-loading-overlay'


Vue.use(VueLoading)
Vue.mixin(utilMixins);
Vue.use(VueIziToast);
Vue.component('Loading', VueLoading)

router.beforeEach((to, from, next) => {
    requiresAuth(to, from, next, store.state)
})

let app = new Vue({
    el: '#app',
    router,
    store,
    render: h => h(App)
})


