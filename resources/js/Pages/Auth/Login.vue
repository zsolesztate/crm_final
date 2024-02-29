<template>
    <!-- component -->
    <div class="min-h-screen bg-gradient-to-bl from-slate-200 to-blue-300 py-6 flex flex-col justify-center sm:py-12">
        <div class="relative py-3 sm:max-w-xl sm:mx-auto">
            <div
                class="absolute inset-0 bg-gradient-to-r from-blue-300 to-blue-600 shadow-lg transform -skew-y-6 sm:skew-y-0 sm:-rotate-6 sm:rounded-3xl">
            </div>
            <div class="relative px-4 py-10 bg-white shadow-lg sm:rounded-3xl sm:p-20">
                <div class="max-w-md mx-auto">
                    <div>
                        <h1 class="text-2xl font-semibold">Bejelentkezés</h1>
                    </div>
                    <form @submit.prevent="submitForm" class="space-y-6">
                    <div class="divide-y divide-gray-200">
                        <div class="py-8 text-base leading-6 space-y-4 text-gray-700 sm:text-lg sm:leading-7">
                            <div class="relative">
                                <input v-model="form.email" autocomplete="off" id="email" name="email" type="text" class="peer placeholder-transparent h-10 w-full border-b-2 border-gray-300 text-gray-900 focus:outline-none focus:borer-rose-600" placeholder="Email cím" />
                                <div v-if="form.errors.email" class="block text-sm font-semibold leading-6 text-red-900">{{ form.errors.email }}</div>
                                <label for="email" class="absolute left-0 -top-3.5 text-gray-600 text-sm peer-placeholder-shown:text-base peer-placeholder-shown:text-gray-440 peer-placeholder-shown:top-2 transition-all peer-focus:-top-3.5 peer-focus:text-gray-600 peer-focus:text-sm">Email cím</label>
                            </div>
                            <div class="relative">
                                <input v-model="form.password" autocomplete="off" id="password" name="password" type="password" class="peer placeholder-transparent h-10 w-full border-b-2 border-gray-300 text-gray-900 focus:outline-none focus:borer-rose-600" placeholder="Jelszó" />
                                <div v-if="form.errors.password" class="block text-sm font-semibold leading-6 text-red-900">{{ form.errors.password }}</div>
                                <label for="password" class="absolute left-0 -top-3.5 text-gray-600 text-sm peer-placeholder-shown:text-base peer-placeholder-shown:text-gray-440 peer-placeholder-shown:top-2 transition-all peer-focus:-top-3.5 peer-focus:text-gray-600 peer-focus:text-sm">Jelszó</label>
                            </div>
                            <div class="text-sm">

                            </div>
                            <div class="text-sm">
                                <Link href="/forgot-password" class="font-semibold text-indigo-600 hover:text-indigo-500">Új jelszó</Link>
                            </div>
                            <div class="relative">
                                <button type="submit" class="bg-blue-500 hover:bg-blue-400 text-white rounded-md px-2 py-1">Bejelentkezés</button>
                            </div>
                        </div>
                    </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</template>
<script setup>
import { defineProps } from 'vue';
import { Link,useForm } from '@inertiajs/vue3';

const {errors,status } = defineProps(['errors','status']);

const form = useForm({
    email: '',
    password: '',
});
const submitForm = () => {
    form.post('/login', {
    });
};
</script>
