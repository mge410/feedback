<template>
    <div class="flex items-center justify-center h-screen">
        <form @submit.prevent="sendForm" class="
            border-8 border-gray-200 rounded-xl
            w-[500px] -mt-14 p-8
            flex flex-col gap-y-3
        ">
            <label class="flex flex-col gap-y-0.5 text-gray-500 focus-within:text-brand-2">
                <span class="text-lg">Заголовок</span>
                <input class="
                px-3 py-2 border-2 border-gray-300 rounded-md shadow-inner
                focus-visible:outline-brand-2 outline-2
            " type="text" v-model="data.title">
                <span class="text-red-500">{{ errors.title }}</span>
            </label>

            <div>
                <input v-model="data.datetime" type="datetime-local" />
                <p class="text-red-500 m-1">{{ errors.datetime }}</p>
            </div>


            <label class="flex flex-col gap-y-0.5 text-gray-500 focus-within:text-brand-2">
                <span class="text-lg">Описание</span>
                <textarea class="
                    px-3 py-2 border-2 border-gray-300 rounded-md shadow-inner
                    focus-visible:outline-brand-2 outline-2
                " rows="6" v-model="data.description" />
                <span class="text-red-500">{{ errors.description }}</span>
            </label>

            <label class="flex flex-col gap-y-0.5 text-gray-500 focus-within:text-brand-2">
                <span class="text-lg">Cервис:</span>
                <select v-model="data.service_id" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                    <option selected disabled></option>
                    <option v-for="service in services" :key="service.id" :value="service.id">{{ service.title }}</option>
                </select>
                <span class="text-red-500">{{ errors.service_id }}</span>
            </label>

            <div class="flex items-center flex-wrap">
                <label class="flex flex-col gap-y-0.5 text-gray-500 focus-within:text-brand-2 mr-3">
                    <span class="text-lg">Оценка:</span>
                </label>
                <div class="flex items-center">
                    <input type="radio" id="star1" name="rating" v-model="data.rating" value="1" class="hidden" />
                    <label for="star1" :class="{ 'text-gray-500': data.rating < 1, 'text-yellow-500': data.rating >= 1 }" class="text-4xl cursor-pointer" @click="data.rating = 1">&#9733;</label>
                    <input type="radio" id="star2" name="rating" v-model="data.rating" value="2" class="hidden" />
                    <label for="star2" :class="{ 'text-gray-500': data.rating < 2, 'text-yellow-500': data.rating >= 2 }" class="text-4xl cursor-pointer" @click="data.rating = 2">&#9733;</label>
                    <input type="radio" id="star3" name="rating" v-model="data.rating" value="3" class="hidden" />
                    <label for="star3" :class="{ 'text-gray-500': data.rating < 3, 'text-yellow-500': data.rating >= 3 }" class="text-4xl cursor-pointer" @click="data.rating = 3">&#9733;</label>
                    <input type="radio" id="star4" name="rating" v-model="data.rating" value="4" class="hidden" />
                    <label for="star4" :class="{ 'text-gray-500': data.rating < 4, 'text-yellow-500': data.rating >= 4 }" class="text-4xl cursor-pointer" @click="data.rating = 4">&#9733;</label>
                    <input type="radio" id="star5" name="rating" v-model="data.rating" value="5" class="hidden" />
                    <label for="star5" :class="{ 'text-gray-500': data.rating < 5, 'text-yellow-500': data.rating >= 5 }" class="text-4xl cursor-pointer" @click="data.rating = 5">&#9733;</label>
                </div>
                <p class="text-red-500 m-1">{{ errors.rating }}</p>
            </div>

            <button class="
                grid place-content-center w-full p-2 mt-1 border-2 border-gray-300 rounded-md shadow-sm outline-none bg-white
                text-lg font-semibold tracking-wide text-gray-400
                transition-all
                focus-visible:bg-brand-2 focus-visible:border-green-700 focus-visible:text-green-800 focus-visible:shadow-xl
                hover:bg-brand-2 hover:border-green-700 hover:text-green-800 hover:shadow-xl
            " type="submit">Отправить</button>
        </form>
    </div>
</template>

<script setup lang="ts">

import { reactive, ref, onMounted } from 'vue';
import axios from 'axios';
import env from '@/env.json'
import router from '@/router';

const data = reactive({
    description: '',
    title: '',
    datetime: '',
    service: null,
    rating: null,
});

const errors = ref({
    title: '',
    description: '',
    datetime: '',
    service_id: '',
    rating: '',
});

const services = ref([]);

const sendForm = async () => {
    try {
        const response = await sendFormImpl();
        if (response && response.data && response.data.id)
            await router.push({ name: 'feedback-show', params: { id: response.data.id } });
    } catch (error) {
        console.log(error)
    }
}

const sendFormImpl = async () => {
    try {
        const response = await axios.post<StoreFeedbackResponse>(env.backend_url + '/feedbacks', {
            'description': data.description,
            'title': data.title,
            'datetime':  new Date(data.datetime).getTime(),
            'service_id':  data.service_id,
            'rating': data.rating,
        });
        return response;
    } catch (error) {
        if (error.response && error.response.data && error.response.data.errors) {
            const errorMessages = error.response.data.errors;
            errors.value.title = errorMessages.title ? errorMessages.title[0] : '';
            errors.value.description = errorMessages.description ? errorMessages.description[0] : '';
            errors.value.datetime = errorMessages.datetime ? errorMessages.datetime[0] : '';
            errors.value.service_id = errorMessages.service_id ? errorMessages.service_id[0] : '';
            errors.value.rating = errorMessages.rating ? errorMessages.rating[0] : '';
        } else {
            throw new Error('Ошибка сервера');
        }
    }
}

interface StoreFeedbackResponse {
    id: number
}

onMounted(async () => {
    try {
        const response = await axios.get(env.backend_url + '/feedbacks');
        services.value = response.data;
    } catch (error) {
        console.log(error);
    }
});
</script>
