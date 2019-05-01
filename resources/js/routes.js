export default {
	mode: 'history',

	routes: [
		{
			path: '/',
			name: 'home',
			component: () => import(/* webpackChunkName: "about" */ './components/Home.vue')
		},

		{
			path: '/about',
			name:'about',
			component: () => import(/* webpackChunkName: "about" */ './components/About.vue')
		}
	]
}