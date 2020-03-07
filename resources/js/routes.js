import Vue from 'vue';
import VueRouter from 'vue-router';
import ProjectsLayout from './layouts/ProjectsLayout.vue'
import AuthLayout from './layouts/ProjectsLayout.vue' // I'd change the layout for authentication later

Vue.use(VueRouter);
const router = new VueRouter({
    mode: 'history',
    linkExactActiveClass: 'active',
    routes: [
        {
            path: '/projects',
            meta: { requiresUserAuth: true },
            component: ProjectsLayout,
            children: [
                {
                    path: '',
                    name: 'projects',
                    component: () => import(/* webpackChunkName: "demo" */ './views/projects/Index.vue'),
                },
                {
                    path: 'create',
                    name: 'create',
                    component: () => import(/* webpackChunkName: "demo" */ './views/projects/Create.vue'),
                },
                {
                    path: ':id',
                    name: 'view',
                    component: () => import(/* webpackChunkName: "demo" */ './views/projects/View.vue'),
                },
                {
                    path: 'edit/:id',
                    name: 'edit_project',
                    component: () => import(/* webpackChunkName: "demo" */ './views/projects/Edit.vue'),
                }
            ]
        },
        {
            path: '',
            meta: { requiresUserAuth: false },
            component: AuthLayout,
            children: [
                {
                    path: '',
                    name: 'home',
                    component: () => import(/* webpackChunkName: "demo" */ './views/Home.vue'),
                },
                {
                    path: 'login',
                    name: 'login',
                    component: () => import(/* webpackChunkName: "demo" */ './views/auth/Login.vue'),
                },
                {
                    path: 'register',
                    name: 'register',
                    component: () => import(/* webpackChunkName: "demo" */ './views/auth/Register.vue'),
                }
            ]
        }
    ]
});

export default router;