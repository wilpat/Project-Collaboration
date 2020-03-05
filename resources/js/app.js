import Vue from 'vue';
import VueRouter from 'vue-router';
import routes from './routes';
import App from './App.vue';
import store from './store/store'
import { requiresAuth } from './middleware';
import utilMixins from './mixins/utils_mixins';

Vue.use(VueRouter);
Vue.mixin(utilMixins);

let router =  new VueRouter(routes);

router.beforeEach((to, from, next) => {
    requiresAuth(to, from, next, store.state)
})

let app = new Vue({
    el: '#app',
    router,
    store,
    render: h => h(App)
})


