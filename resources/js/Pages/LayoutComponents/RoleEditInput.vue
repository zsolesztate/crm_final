<template>
    <div class="mx-auto max-w-2xl text-center mt-10">
        <h2 class="text-2xl font-bold tracking-tight text-gray-900 sm:text-4xl">Csoport módosítása</h2>
    </div>
    <form @submit.prevent="submit" class="mx-auto mt-16 max-w-xl sm:mt-20">
        <div class="grid grid-cols-1 gap-x-8 gap-y-6 sm:grid-cols-2">
            <div class="sm:col-span-2">
                <label for="name" class="block text-sm font-semibold leading-6 text-gray-900">Csoport neve</label>
                <div class="mt-2.5">
                    <input v-model="form.name" type="text" name="name" id="name" autocomplete="organization" class="block w-full rounded-md border-0 px-3.5 py-2 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                </div>
                <div v-if=form.errors.name class="block mt-1.5 ml-1 text-sm font-semibold leading-6 text-rose-500">
                    {{form.errors.name }}
                </div>
            </div>
        </div>
        <div class="mt-10">
            <button type="submit" :disabled="form.processing" class="block w-full rounded-md bg-indigo-600 px-3.5 py-2.5 text-center text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">Mentés</button>
            <button @click="closeField" type="button" class="mt-3.5 block w-full rounded-md bg-gray-600 px-3.5 py-2.5 text-center text-sm font-semibold text-white shadow-sm hover:bg-gray-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">Mégse</button>
        </div>
    </form>
</template>
<script setup>
import { useForm } from '@inertiajs/vue3';
import {useSnackbar, Vue3Snackbar} from "vue3-snackbar";
import {defineEmits, defineProps} from 'vue'

const emits = defineEmits(['hide']);
const {role } = defineProps(['role']);

const snackbar = useSnackbar();

const form = useForm({
    _method:"PUT",
    name: role.name,
});

const closeField = () => {
    form.reset();
    emits('hide');
};

const submit = () => {
    form.post(`/roles/${role.id}`,{
        onSuccess: () => {
            snackbar.add({
                type: 'success',
                text: 'Csoport sikeresen módosítva'
            })
            form.reset();
            closeField();
        },
    });
};
</script>
