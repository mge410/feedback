import { createRouter, createWebHistory } from 'vue-router'
import FormCreatePage from '@/pages/FormCreatePage.vue';
import FormShowPage from '@/pages/FormShowPage.vue';

const router = createRouter({
    history: createWebHistory(import.meta.env.BASE_URL),
    routes: [
        {
            path: '/:pathMatch(.*)*',
            redirect: { name: 'feedback-create' }
        },
        {
            path: '/feedback/create',
            name: 'feedback-create',
            component: FormCreatePage
        },
        {
            path: '/feedback/:id',
            name: 'feedback-show',
            component: FormShowPage
        }
    ]
})

export default router
