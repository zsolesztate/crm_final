<template>
    <div class="isolate bg-white px-6 py-24 sm:py-32 lg:px-8">
        <div class="absolute inset-x-0 top-[calc(100%-13rem)] -z-10 transform-gpu overflow-hidden blur-3xl sm:top-[calc(100%-30rem)]" aria-hidden="true">
            <div class="relative left-1/2 -z-10 aspect-[1155/678] w-[36.125rem] max-w-none -translate-x-1/2 rotate-[30deg] bg-gradient-to-tr from-[#ff80b5] to-[#9089fc] opacity-30 sm:left-[calc(50%-40rem)] sm:w-[72.1875rem]" style="clip-path: polygon(74.1% 44.1%, 100% 61.6%, 97.5% 26.9%, 85.5% 0.1%, 80.7% 2%, 72.5% 32.5%, 60.2% 62.4%, 52.4% 68.1%, 47.5% 58.3%, 45.2% 34.5%, 27.5% 76.7%, 0.1% 64.9%, 17.9% 100%, 27.6% 76.8%, 76.1% 97.7%, 74.1% 44.1%)"></div>
        </div>
        <div class="mx-auto max-w-2xl text-center">
            <h2 class="text-3xl font-bold tracking-tight text-gray-900 sm:text-4xl">Munkatárs létrehozása</h2>
        </div>
        <form @submit.prevent="submit" class="mx-auto mt-16 max-w-xl sm:mt-20">
            <div class="grid grid-cols-1 gap-x-8 gap-y-6 sm:grid-cols-2">
                <div>
                    <label for="username" class="block text-sm font-semibold leading-6 text-gray-900">Név</label>
                    <div class="mt-2.5">
                        <input v-model="form.name" type="text" name="name" id="name"  class="block w-full rounded-md border-0 px-3.5 py-2 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                    </div>
                    <div v-if=form.errors.name class="block mt-1.5 ml-1 text-sm font-semibold leading-6 text-rose-500">
                        {{form.errors.name }}
                    </div>
                </div>
                <div>
                    <label for="email" class="block text-sm font-semibold leading-6 text-gray-900">Email cím</label>
                    <div class="mt-2.5">
                        <input v-model="form.email" type="email" name="email" id="email"  class="block w-full rounded-md border-0 px-3.5 py-2 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                    </div>
                    <div v-if=form.errors.email class="block mt-1.5 ml-1 text-sm font-semibold leading-6 text-rose-500">
                        {{form.errors.email }}
                    </div>
                </div>
                <div>
                    <label for="username" class="block text-sm font-semibold leading-6 text-gray-900">Telefonszám</label>
                    <div class="mt-2.5">
                        <input v-model="form.phone" type="text" name="phone" id="phone"  class="block w-full rounded-md border-0 px-3.5 py-2 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                    </div>
                    <div v-if=form.errors.phone class="block mt-1.5 ml-1 text-sm font-semibold leading-6 text-rose-500">
                        {{form.errors.phone }}
                    </div>
                </div>
                <div>
                    <label for="email" class="block text-sm font-semibold leading-6 text-gray-900">Beosztás</label>
                    <div class="mt-2.5">
                        <input v-model="form.position" type="text" name="position" id="position"  class="block w-full rounded-md border-0 px-3.5 py-2 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                    </div>
                    <div v-if=form.errors.position class="block mt-1.5 ml-1 text-sm font-semibold leading-6 text-rose-500">
                        {{form.errors.position }}
                    </div>
                </div>
            </div>
            <div class="mt-10">
                <button type="submit" class="block w-full rounded-md bg-indigo-600 px-3.5 py-2.5 text-center text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">Munkatárs mentése</button>
                <button @click="closeField" type="button" class="mt-3.5 block w-full rounded-md bg-gray-600 px-3.5 py-2.5 text-center text-sm font-semibold text-white shadow-sm hover:bg-gray-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">Mégse</button>
            </div>
        </form>
    </div>
    <vue3-snackbar bottom right :duration="4000"></vue3-snackbar>
</template>
<script setup>
import { useForm } from '@inertiajs/vue3';
import {useSnackbar, Vue3Snackbar} from "vue3-snackbar";
import {defineEmits, ref} from 'vue'

const emits = defineEmits(['hide']);
const snackbar = useSnackbar();

const form = useForm({
    name: '',
    email:'',
    phone:'',
    position:'',
});

const closeField = () => {
    form.reset();
    emits('hide');
};

const submit = () => {
    form.post('/coworkers',{
        onSuccess: () => {
            snackbar.add({
                type: 'success',
                text: 'Munkatárs létrehozva'
            })
            form.reset();
            closeField();
        },
    });
};
</script>
