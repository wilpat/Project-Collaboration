export default {
    mode: 'history',
    linkExactActiveClass: 'active',
    routes: [
        {
            path: '/',
            name: 'ProjectIndex',
            meta: { requiresUserAuth: true },
            component: () => import(/* webpackChunkName: "demo" */ './views/projects/Index.vue')
        },
        {
            path: '/login',
            name: 'Login',
            meta: { requiresUserAuth: false },
            component: () => import(/* webpackChunkName: "demo" */ './views/auth/Login.vue')
        }
    ]
}