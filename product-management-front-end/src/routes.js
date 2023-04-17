import { createRouter, createWebHistory } from 'vue-router'
// import Home from './components/Home.vue'
import Products from './components/ProductTable.vue'

const routes = [
    { path: '/', component: null },
    { path: '/products', component: Products },

    // other routes
]

const router = createRouter({
    history: createWebHistory(),
    routes,
})

export default router