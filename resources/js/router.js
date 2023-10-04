import Index from "./pages/Index.vue"
import Contacts from "./pages/AddContact.vue"
import Logs from "./pages/Logs.vue"

import { createRouter, createWebHistory,  } from 'vue-router'


const routes = [
    { path: '/', component: Index, name: 'index' },
    { path: '/:id/add-contact', component: Contacts, name: 'add-contact' },
    { path: '/logs', component: Logs, name: 'logs' }
]

const router = createRouter({
    history: createWebHistory(),
    routes,
})

router.onError((e) => {
    console.info(e)
})

export default router


