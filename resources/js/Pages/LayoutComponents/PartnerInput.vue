<template>
    <div class="isolate bg-white px-6 py-24 sm:py-32 lg:px-8">
        <div class="absolute inset-x-0 top-[calc(100%-13rem)] -z-10 transform-gpu overflow-hidden blur-3xl sm:top-[calc(100%-30rem)]" aria-hidden="true">
            <div class="relative left-1/2 -z-10 aspect-[1155/678] w-[36.125rem] max-w-none -translate-x-1/2 rotate-[30deg] bg-gradient-to-tr from-[#ff80b5] to-[#9089fc] opacity-30 sm:left-[calc(50%-40rem)] sm:w-[72.1875rem]" style="clip-path: polygon(74.1% 44.1%, 100% 61.6%, 97.5% 26.9%, 85.5% 0.1%, 80.7% 2%, 72.5% 32.5%, 60.2% 62.4%, 52.4% 68.1%, 47.5% 58.3%, 45.2% 34.5%, 27.5% 76.7%, 0.1% 64.9%, 17.9% 100%, 27.6% 76.8%, 76.1% 97.7%, 74.1% 44.1%)"></div>
        </div>
        <div class="mx-auto max-w-2xl text-center">
            <h2 class="text-3xl font-bold tracking-tight text-gray-900 sm:text-4xl">Partner létrehozása</h2>
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
                            <div v-if="allUsers.length > 0 "  class="py-2 p-2" role="menu" aria-orientation="vertical" aria-labelledby="dropdown-button">
                               <div v-for="(user,index) in allUsers" :key="index">
                                   <div @click="selectUser(index,user)"  class="block px-4 py-2 mb-1 text-sm text-gray-700 rounded-md bg-white hover:bg-gray-100" role="menuitem">{{user.name}}</div>
                               </div>
                            </div>
                        </div>
                        <label for="coworkers" class="block text-sm mt-3.5 font-semibold leading-6 text-gray-900">Kiválasztott munkatársak:</label>
                        <div class="flex flex-wrap gap-x-4 sm:col-span-2 z-30 mt-3 justify-center">
                            <div v-for="(selectedUser,index) in selectedUsers" :key="index" class="flex-shrink-0">
                                <button @click.prevent="removeUser(index,selectedUser)" class="text-sm text-white text-center px-3.5 py-2.5 flex h-6 items-center rounded-md bg-indigo-400 p-3">
                                    {{ selectedUser.name }}
                                    <span class="ml-3 text-indigo-950">X</span>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="mt-10">
                <button type="submit" :disabled="form.processing" class="block w-full rounded-md bg-indigo-600 px-3.5 py-2.5 text-center text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">Felhasználó mentése</button>
                <button @click="closeField" type="button" class="mt-3.5 block w-full rounded-md bg-gray-600 px-3.5 py-2.5 text-center text-sm font-semibold text-white shadow-sm hover:bg-gray-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">Mégse</button>
            </div>
        </form>
    </div>
    <vue3-snackbar bottom right :duration="4000"></vue3-snackbar>
</template>
<script setup>
import { useForm } from '@inertiajs/vue3';
import {useSnackbar, Vue3Snackbar} from "vue3-snackbar";
import {defineEmits, defineProps, ref} from 'vue'

const {users} = defineProps(['users']);

const selectedUsers = ref([]);
const allUsers = ref(users);

const emits = defineEmits(['hide']);
const snackbar = useSnackbar();


const form = useForm({
    name: '',
    company_name:'',
    email:'',
    users:[],
});

const closeField = () => {
    form.reset();
    emits('hide');
};

const submit = () => {
    form.users = selectedUsers.value;
    console.log(form)
    form.post('/partners',{
        onSuccess: () => {
            snackbar.add({
                type: 'success',
                text: 'Felhasználó feltöltve'
            })
            form.reset();
            closeField();
        },
    });
};


const show = ref(false);

const showDropdown = () => {
    show.value = !show.value
}

const selectUser = (index,user) => {
    allUsers.value.splice(index, 1);
    selectedUsers.value.push(user);
}

const removeUser = (index,user) => {
    selectedUsers.value.splice(index, 1);
    allUsers.value.push(user);
    show.value = false
}
</script>
