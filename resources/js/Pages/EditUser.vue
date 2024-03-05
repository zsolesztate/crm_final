<template>
    <Navbar :userCanModify="userPermissions"/>
    <div class="relative isolate px-6 lg:px-8 flex flex-col lg:flex-row">
        <div class="flex-grow ml-52">
            <div class="mx-auto max-w-2xl text-center">
                <h2 class="text-3xl font-bold tracking-tight text-gray-900 sm:text-4xl">Munkatárs módosítása</h2>
            </div>
            <form @submit.prevent="submitBasicInfo" class="mx-auto mt-16 max-w-xl sm:mt-20">
                <div class="grid grid-cols-1 gap-x-8 gap-y-6 sm:grid-cols-2">
                    <div>
                        <label for="username" class="block text-sm font-semibold leading-6 text-gray-900">Név</label>
                        <div class="mt-2.5">
                            <input v-model="basicInfoForm.name" type="text" name="username" id="username"  class="block w-full rounded-md border-0 px-3.5 py-2 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                        </div>
                        <div v-if=basicInfoForm.errors.name class="block mt-1.5 ml-1 text-sm font-semibold leading-6 text-rose-500">
                            {{basicInfoForm.errors.name }}
                        </div>
                    </div>
                    <div>
                        <label for="email" class="block text-sm font-semibold leading-6 text-gray-900">Email cím</label>
                        <div class="mt-2.5">
                            <input v-model="basicInfoForm.email" type="email" name="email" id="email" class="block w-full rounded-md border-0 px-3.5 py-2 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                        </div>
                        <div v-if=basicInfoForm.errors.email class="block mt-1.5 ml-1 text-sm font-semibold leading-6 text-rose-500">
                            {{basicInfoForm.errors.email }}
                        </div>
                    </div>
                    <div>
                        <label for="username" class="block text-sm font-semibold leading-6 text-gray-900">Telefonszám</label>
                        <div class="mt-2.5">
                            <input v-model="basicInfoForm.phone" type="text" name="phone" id="phone" class="block w-full rounded-md border-0 px-3.5 py-2 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                        </div>
                        <div v-if=basicInfoForm.errors.phone class="block mt-1.5 ml-1 text-sm font-semibold leading-6 text-rose-500">
                            {{basicInfoForm.errors.phone }}
                        </div>
                    </div>
                    <div>
                        <label for="email" class="block text-sm font-semibold leading-6 text-gray-900">Beosztás</label>
                        <div class="mt-2.5">
                            <input v-model="basicInfoForm.position" type="text" name="position" id="position" class="block w-full rounded-md border-0 px-3.5 py-2 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                        </div>
                    </div>
                    <div v-if=basicInfoForm.errors.position class="block mt-1.5 ml-1 text-sm font-semibold leading-6 text-rose-500">
                        {{basicInfoForm.errors.position }}
                    </div>
                </div>
                <div class="sm:col-span-2 mt-10">
                    <label for="role" class="block text-sm font-semibold leading-6 text-gray-900">Csoport kiválasztása</label>
                    <div class="mt-2.5 ">
                        <button type="button" @click.prevent="showDropdown" data-dropdown-toggle="dropdown" class="w-full text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center inline-flex items-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">{{SelectedRole.name }}<svg class="w-2.5 h-2.5 ms-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 4 4 4-4"/>
                        </svg>
                        </button>
                        <div v-if="show" id="dropdown" class="z-10  bg-white divide-y divide-gray-100 w-full">
                            <ul v-for="role in roles" class="py-2 text-sm bg-gray-50  text-gray-700" aria-labelledby="dropdownDefaultButton">
                                <li>
                                    <button @click.prevent="selectRole(role)" class="block px-4 py-2 hover:bg-gray-100 w-full">{{ role.name}}</button>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div v-if=basicInfoForm.errors.role class="block mt-1.5 ml-1 text-sm font-semibold leading-6 text-rose-500">
                        {{basicInfoForm.errors.role }}
                    </div>
                    <div class="flex mt-10 gap-x-4 sm:col-span-2 z-30">
                        <div class="flex h-6 items-center">
                            <input v-model="basicInfoForm.active_status" type="checkbox" true-value="1" false-value="0" class="h-4 w-4">
                        </div>
                        <label class="text-sm leading-6 text-gray-600" id="switch-1-label">
                            Aktív
                        </label>
                        <div class="flex h-6 items-center">
                            <input v-model="basicInfoForm.can_modify" type="checkbox" true-value="1" false-value="0">
                        </div>
                        <label class="text-sm leading-6 text-gray-600" id="switch-1-label">
                            Módosíthatja-e az adatit
                        </label>
                    </div>
                    <div class="mt-10">
                        <button type="submit" :disabled="basicInfoForm.processing" class="block w-full rounded-md bg-indigo-600 px-3.5 py-2.5 text-center text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">Adatok módosítása</button>
                    </div>
                </div>
            </form>
            <form @submit.prevent="submitPassword" class="mx-auto  max-w-xl sm:mt-20">
                <div class="sm:col-span-2">
                    <label for="password" class="block text-sm font-semibold leading-6 text-gray-900">Új Jelszó</label>
                    <div class="mt-2.5">
                        <input v-model="passwordForm.password" type="password" name="password" id="password" autocomplete="organization" class="block w-full rounded-md border-0 px-3.5 py-2 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                    </div>
                    <div v-if=passwordForm.errors.password class="block mt-1.5 ml-1 text-sm font-semibold leading-6 text-rose-500">
                        {{passwordForm.errors.password }}
                    </div>
        </div>
                <div class="mt-10">
                    <button type="submit" :disabled="basicInfoForm.processing" class="block w-full rounded-md bg-indigo-600 px-3.5 py-2.5 text-center text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">Jelszó módosítása</button>
                </div>
            </form>
        </div>
    </div>
    <vue3-snackbar bottom right :duration="4000"></vue3-snackbar>
</template>
<script setup>
import {useForm} from '@inertiajs/vue3';
import {useSnackbar, Vue3Snackbar} from "vue3-snackbar";
import {defineProps, ref} from 'vue'
import Navbar from "./LayoutComponents/Navbar.vue";


const {user,userPermissions,roles } = defineProps(['user','userPermissions','roles']);

const snackbar = useSnackbar();

const show = ref(false);
const SelectedRole = ref(user.roles[0]);

const showDropdown = () => {
    show.value = ! show.value
}

const selectRole = (role) => {
    SelectedRole.value = role
    showDropdown()
}

const basicInfoForm = useForm({
    _method:"PUT",
    name: user.name,
    email:user.email,
    phone:user.phone,
    role:[],
    position:user.position,
    active_status:user.active_status,
    can_modify:user.can_modify
});

const submitBasicInfo = () => {
    basicInfoForm.role = SelectedRole.value;
    basicInfoForm.post(`/users/${user.id}`,{
        onSuccess: () => {
            snackbar.add({
                type: 'success',
                text: 'Munkatárs módosítva'
            })
        },
    });
};

const passwordForm = useForm({
    _method: "PUT",
    password: ''
});

const submitPassword = () => {
    passwordForm.post(`/users/${user.id}/password`, {
        onSuccess: () => {
            snackbar.add({
                type: 'success',
                text: 'Munkatárs jelszava módosítva'
            })
        },
    });
};
</script>
