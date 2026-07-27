import {createRouter, createWebHistory} from 'vue-router'
import {useAuthStore} from '../stores/auth'
import HomeView from '../views/HomeView.vue'

const router = createRouter({
    history: createWebHistory(import.meta.env.BASE_URL),
    routes: [
        {path: '/', name: 'home', component: HomeView},
        {path: '/category/:slug', name: 'category', component: () => import('../views/CategoryView.vue')},
        {
            path: '/admin',
            component: () => import('../views/admin/AdminLayout.vue'),
            meta: {requiresAuth: true},
            children: [
                {path: 'categories', component: () => import('../components/admin/Categories.vue')},
                {path: 'projects', component: () => import('../components/admin/Projects.vue')},
                {path: 'reviews', component: () => import('../components/admin/Reviews.vue')},
                {path: 'settings', component: () => import('../components/admin/Settings.vue')},
            ],
        },
        {path: '/login', component: () => import('../views/admin/AdminLogin.vue')},

        // {path: '/:pathMatch(.*)*', component: () => import('../views/NotFound.vue')},
    ],
})

router.beforeEach((to, from, next) => {
    const authStore = useAuthStore();

    if (to.meta.requiresAuth && !authStore.isAuthenticated) {
        next('/login');
    } else {
        next();
    }
});

export default router
