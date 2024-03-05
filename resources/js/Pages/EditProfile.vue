<template>
    <div class="bg-white">
        <div class="relative isolate px-6 lg:px-8 flex flex-col lg:flex-row">
            <Navbar :userCanModify="userPermissions"/>
            <div class="flex-grow ml-52 mt-20">
                <div class="mx-auto max-w-2xl text-center">
                    <h2 class="text-3xl font-bold tracking-tight text-gray-900 sm:text-4xl">Profil szerkesztése</h2>
                </div>
                <form @submit.prevent="submitUserData" class="mx-auto mt-16 max-w-xl sm:mt-20">
                    <div class="grid grid-cols-1 gap-x-8 gap-y-6 sm:grid-cols-2">
                        <div>
                            <label for="name" class="block text-sm font-semibold leading-6 text-gray-900">Név</label>
                            <div class="mt-2.5">
                                <input v-model="userData.name" type="text" name="name" id="name" class="block w-full rounded-md border-0 px-3.5 py-2 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                            </div>
                            <div v-if="userData.errors.name" class="block mt-1.5 ml-1 text-sm font-semibold leading-6 text-rose-500">
                                {{ userData.errors.name }}
                            </div>
                        </div>
                        <div>
                            <label for="email" class="block text-sm font-semibold leading-6 text-gray-900">Email cím</label>
                            <div class="mt-2.5">
                                <input v-model="userData.email" type="email" name="email" id="email" class="block w-full rounded-md border-0 px-3.5 py-2 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                            </div>
                            <div v-if="userData.errors.email" class="block mt-1.5 ml-1 text-sm font-semibold leading-6 text-rose-500">
                                {{ userData.errors.email}}
                            </div>
                        </div>
                        <div>
                            <label for="phone" class="block text-sm font-semibold leading-6 text-gray-900">Telefonszám</label>
                            <div class="mt-2.5">
                                <input v-model="userData.phone" type="text" name="phone" id="phone" class="block w-full rounded-md border-0 px-3.5 py-2 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                            </div>
                            <div v-if="userData.errors.phone" class="block mt-1.5 ml-1 text-sm font-semibold leading-6 text-rose-500">
                                {{ userData.errors.phone }}
                            </div>
                        </div>
                        <div>
                            <label for="position" class="block text-sm font-semibold leading-6 text-gray-900">Beosztás</label>
                            <div class="mt-2.5">
                                <input v-model="userData.position" type="text" name="position" id="position" class="block w-full rounded-md border-0 px-3.5 py-2 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                            </div>
                            <div v-if="userData.errors.position" class="block mt-1.5 ml-1 text-sm font-semibold leading-6 text-rose-500">
                                {{ userData.errors.position }}
                            </div>
                        </div>
                    </div>
                    <div class="mt-10">
                        <button type="submit" class="block w-full rounded-md bg-indigo-600 px-3.5 py-2.5 text-center text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">Adatok módosítása</button>
                        <Link href="/"  class="mt-3.5 block w-full rounded-md bg-gray-600 px-3.5 py-2.5 text-center text-sm font-semibold text-white shadow-sm hover:bg-gray-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">Mégse</Link>
                    </div>
                </form>
                <form @submit.prevent="submitPasswordChange" class="mx-auto mt-16 max-w-xl sm:mt-20">
                    <div class="grid grid-cols-1 gap-x-8 gap-y-6 sm:grid-cols-2">
                        <div class="sm:col-span-2">
                            <label for="currentPassword" class="block text-sm font-semibold leading-6 text-gray-900">Jelenlegi jelszó</label>
                            <div class="mt-2.5">
                                <input v-model="passwordData.currentPassword" type="password" name="currentPassword" id="currentPassword" autocomplete="current-password" class="block w-full rounded-md border-0 px-3.5 py-2 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                            </div>
                            <div v-if="passwordData.errors.currentPassword" class="block mt-1.5 ml-1 text-sm font-semibold leading-6 text-rose-500">
                                {{ passwordData.errors.currentPassword }}
                            </div>
                        </div>
                        <div class="sm:col-span-2">
                            <label for="newPassword" class="block text-sm font-semibold leading-6 text-gray-900">Új jelszó</label>
                            <div class="mt-2.5">
                                <input v-model="passwordData.newPassword" type="password" name="newPassword" id="newPassword" autocomplete="new-password" class="block w-full rounded-md border-0 px-3.5 py-2 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                            </div>
                            <div v-if="passwordData.errors.newPassword" class="block mt-1.5 ml-1 text-sm font-semibold leading-6 text-rose-500">
                                {{ passwordData.errors.newPassword }}
                            </div>
                            <div v-if="passwordsDoNotMatch" class="text-red-500 mt-2">Az új jelszó és a megerősítő jelszó nem egyezik meg.</div>
                        </div>
                        <div class="sm:col-span-2">
                            <label for="confirmPassword" class="block text-sm font-semibold leading-6 text-gray-900">Új jelszó megerősítése</label>
                            <div class="mt-2.5">
                                <input v-model="passwordData.confirmPassword" type="password" name="confirmPassword" id="confirmPassword" autocomplete="new-password" class="block w-full rounded-md border-0 px-3.5 py-2 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                            </div>
                            <div v-if="passwordData.errors.confirmPassword" class="block mt-1.5 ml-1 text-sm font-semibold leading-6 text-rose-500">
                                {{ passwordData.errors.confirmPassword }}
                            </div>
                        </div>
                    </div>
                    <div class="mt-10">
                        <button type="submit" class="block w-full rounded-md bg-indigo-600 px-3.5 py-2.5 text-center text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">Jelszó módosítása</button>
                        <Link href="/"  class="mt-3.5 block w-full rounded-md bg-gray-600 px-3.5 py-2.5 text-center text-sm font-semibold text-white shadow-sm hover:bg-gray-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">Mégse</Link>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <vue3-snackbar bottom right :duration="4000"></vue3-snackbar>
</template>
<script setup>
import Navbar from "./LayoutComponents/Navbar.vue";
import {Link, useForm} from '@inertiajs/vue3';
import {Vue3Snackbar} from "vue3-snackbar";
import { useSnackbar } from "vue3-snackbar";
import { defineProps,ref } from "vue";

const { userPermissions,user } = defineProps(['userPermissions','user']);
const snackbar = useSnackbar();

const userData = useForm({
    _method:"PUT",
    name: user.name,
    email: user.email,
    phone: user.phone,
    position: user.position
});

const submitUserData = () => {
    userData.post(`/users/profile/${user.id}`, {
        onSuccess: () => {
            snackbar.add({
                type: 'success',
                text: 'Felhasználói adatok sikeresen módosítva'
            });
        },
    });
};

const passwordData = useForm({
    _method:"PUT",
    currentPassword: '',
    newPassword: '',
    confirmPassword: ''
});

let formErrors = {};
const passwordsDoNotMatch = ref(false);

const submitPasswordChange = () => {
    if (passwordData.newPassword !== passwordData.confirmPassword) {
        passwordsDoNotMatch.value = true;
        return;
    }

    passwordsDoNotMatch.value = false;
    passwordData.post(`/users/profile/${user.id}/password`, {
        onSuccess: () => {
            snackbar.add({
                type: 'success',
                text: 'Jelszó sikeresen módosítva'
            });
            passwordData.reset();
        },
        onError: (errors) => {
            formErrors = errors;
        }
    });
};
</script>
