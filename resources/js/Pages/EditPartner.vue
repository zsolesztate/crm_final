<template>
    <div class="bg-white">
        <Navbar :userCanModify="userPermissions"/>
        <div class="relative isolate px-6 lg:px-8 flex flex-col lg:flex-row">
            <div class="flex-grow ml-52">
                <div class="mx-auto max-w-2xl text-center">
                    <h2 class="text-3xl font-bold tracking-tight text-gray-900 sm:text-4xl">Partner módosítása</h2>
                </div>
        <form @submit.prevent="submit" class="mx-auto mt-16 max-w-xl sm:mt-20">
            <div class="grid grid-cols-1 gap-x-8 gap-y-6 sm:grid-cols-2">
                <div>
                    <label for="username" class="block text-sm font-semibold leading-6 text-gray-900">Megjelenítési Név</label>
                    <div class="mt-2.5">
                        <input v-model="form.name" type="text" name="name" id="name"  class="block w-full rounded-md border-0 px-3.5 py-2 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                    </div>
                    <div v-if=form.errors.name class="block mt-1.5 ml-1 text-sm font-semibold leading-6 text-rose-500">
                        {{form.errors.name }}
                    </div>
                </div>
                <div>
                    <label for="company" class="block text-sm font-semibold leading-6 text-gray-900">Cégnév</label>
                    <div class="mt-2.5">
                        <input v-model="form.company_name" type="text" name="company" id="company" class="block w-full rounded-md border-0 px-3.5 py-2 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                    </div>
                    <div v-if=form.errors.company_name class="block mt-1.5 ml-1 text-sm font-semibold leading-6 text-rose-500">
                        {{form.errors.company_name }}
                    </div>
                </div>
                <div class="sm:col-span-2">
                    <label for="password" class="block text-sm font-semibold leading-6 text-gray-900">Email cím</label>
                    <div class="mt-2.5">
                        <input v-model="form.email" type="email" name="email" id="email" autocomplete="organization" class="block w-full rounded-md border-0 px-3.5 py-2 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                    </div>
                    <div v-if=form.errors.email class="block mt-1.5 ml-1 text-sm font-semibold leading-6 text-rose-500">
                        {{form.errors.email }}
                    </div>
                </div>
                <div class="sm:col-span-2">
                    <label for="coworkers" class="block text-sm font-semibold leading-6 text-gray-900">Munkatársak hozzáadása</label>
                    <div class="relative inline-block text-left w-full">
                        <button @click.prevent="showDropdown" id="dropdown-button" class="mt-3.5 inline-flex justify-center w-full px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-gray-100 focus:ring-blue-500">
                            Munkatárs kiválasztása
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 ml-2 -mr-1" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                <path fill-rule="evenodd" d="M6.293 9.293a1 1 0 011.414 0L10 11.586l2.293-2.293a1 1 0 111.414 1.414l-3 3a1 1 0 01-1.414 0l-3-3a1 1 0 010-1.414z" clip-rule="evenodd" />
                            </svg>
                        </button>
                        <div v-show="show" @click.stop id="dropdown-menu" class=" origin-top-right absolute right-0 mt-2 w-full rounded-md shadow-lg bg-white ring-1 ring-black ring-opacity-5">
                            <div v-if="nonSelectedUsersRef.length > 0"  class="py-2 p-2" role="menu" aria-orientation="vertical" aria-labelledby="dropdown-button">
                                <div v-for="(nonSelectedUser,index) in nonSelectedUsersRef" :key="index">
                                    <div @click="selectUser(index,nonSelectedUser)"  class="block px-4 py-2 mb-1 text-sm text-gray-700 rounded-md bg-white hover:bg-gray-100" role="menuitem">{{nonSelectedUser.name}}</div>
                                </div>
                            </div>
                        </div>
                        <label for="coworkers" class="block text-sm mt-3.5 font-semibold leading-6 text-gray-900">Kiválasztott munkatársak:</label>
                        <div class="flex flex-wrap gap-x-4 sm:col-span-2 z-30 mt-3 justify-center">
                            <div v-if="selectedUsersRef.length > 0" v-for="(user, index) in selectedUsersRef" :key="index" class="flex-shrink-0">
                                <button @click.prevent="removeUser(index, user)" class="mt-3.5 text-sm text-white text-center px-3.5 py-2.5 flex h-6 items-center rounded-md bg-indigo-400 p-3">
                                    {{ user.name }}
                                    <span class="ml-3 text-indigo-950">X</span>
                                </button>
                            </div>
                            <div v-else class="flex-shrink-0">
                                Még nincs hozzáadott munkatárs.
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="mt-10">
                <button type="submit" :disabled="form.processing" class="block w-full rounded-md bg-indigo-600 px-3.5 py-2.5 text-center text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">Felhasználó mentése</button>
                <Link href="/partners"   class="mt-3.5 block w-full rounded-md bg-gray-600 px-3.5 py-2.5 text-center text-sm font-semibold text-white shadow-sm hover:bg-gray-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">Mégse</Link>
            </div>
        </form>
    </div>
        </div>
    </div>
    <vue3-snackbar bottom right :duration="4000"></vue3-snackbar>
</template>
<script setup>
import { useForm,Link } from '@inertiajs/vue3';
import {useSnackbar, Vue3Snackbar} from "vue3-snackbar";
import { defineProps, ref, computed,watchEffect} from 'vue'
import Navbar from "./LayoutComponents/Navbar.vue";

const {partner,users,userPermissions} = defineProps(['partner','users','userPermissions']);

const selectedUserIds = computed(() => partner.users.map(user => user.id));

const nonSelectedUsersRef = ref('');
const selectedUsersRef = ref(partner.users);

const nonSelectedUsers = computed(() => {
    return users.filter(user => !selectedUserIds.value.includes(user.id));
});

watchEffect(() => {
    nonSelectedUsersRef.value = nonSelectedUsers.value;
});

const snackbar = useSnackbar();


const form = useForm({
    _method:"PUT",
    name: partner.name,
    company_name:partner.company_name,
    email:partner.email,
    users:[],
});


const submit = () => {
    form.users = selectedUsersRef.value;
    form.post(`/partners/${partner.id}`,{
        onSuccess: () => {
            snackbar.add({
                type: 'success',
                text: 'Partner módosítva.'
            })
            form.reset();
        },
    });
};


const show = ref(false);

const showDropdown = () => {
    show.value = !show.value
}

const selectUser = (index,user) => {
    nonSelectedUsersRef.value.splice(index, 1);
    selectedUsersRef.value.push(user);
}

const removeUser = (index,user) => {
    selectedUsersRef.value.splice(index, 1);
    nonSelectedUsersRef.value.push(user);
    show.value = false
}
</script>
