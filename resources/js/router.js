import { createRouter, createWebHistory } from 'vue-router'
import Home from './pages/Home.vue'
import Login from './pages/Login.vue'
import Dashboard from './pages/Dashboard.vue'

const routes = [
    {
        path: '/',
        name: 'home',
        component: Home
    },
    {
        path: '/admin/login',
        name: 'login',
        component: Login
    },
    {
        path: '/admin/dashboard',
        name: 'dashboard',
        component: Dashboard,
        meta: { requiresAuth: true }
    }
]

const router = createRouter({
    history: createWebHistory(),
    routes
})

router.beforeEach((to, from, next) => {
    const token = localStorage.getItem('admin_token')
    if (to.meta.requiresAuth && !token) {
        next({ name: 'login' })
    } else {
        next()
    }
})

export default router
