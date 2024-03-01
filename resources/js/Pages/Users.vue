<template>
    <div class="bg-white">
    <Navbar :userCanModify="userPermissions"/>
        <div class="mt-20 block text-center">
            <h1 class="text-4xl font-bold tracking-tight text-gray-900">Felhasználók</h1>
            <div class="mt-10 flex flex-col items-center justify-center gap-y-6 sm:gap-y-0 sm:flex-row sm:justify-center sm:gap-x-6">
                <div class="text-sm font-semibold leading-6 text-gray-900">Felhasználó hozzáadása <span aria-hidden="true">→</span></div>
                <button type="button" @click="showUserAddField" class="rounded-md bg-indigo-600 px-3.5 py-2.5 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">Lenyit</button>
            </div>
        </div>
        <UserInput v-if="userInputShow" @hide="hideAddUser"/>
        <UserEditInput v-if="userEditShow" :user="userEditObject" @hide="editUser"/>
        <div class="relative mt-10 isolate px-6 pt-14 lg:px-8">
            <SearchBar :searchedText="searchedText" :errors="errors" />
            <div class="mx-auto">
                <table-skeleton>
                    <template v-slot:thead>
                        <table-head>Felhasználó neve</table-head>
                        <table-head>Email címe</table-head>
                        <table-head>Státusz</table-head>
                        <table-head>Módosítási jog</table-head>
                        <table-head>Utolsó belépés</table-head>
                        <table-head>Szerkesztés/Törlés</table-head>
                    </template>
                    <template v-slot:tbody>
                        <tr  v-for="(user) in users" :key="user.id">
                            <table-body>
                                <template v-slot:default>
                                    {{ user.name}}
                                </template>
                            </table-body>
                            <table-body>
                                <template v-slot:default>
                                    {{ user.email}}
                                </template>
                            </table-body>
                            <table-body>
                                <template v-slot:default>
                                    {{ isActive(user.active_status)}}
                                </template>
                            </table-body>
                            <table-body>
                                <template v-slot:default>
                                    {{ canModify(user.can_modify)}}
                                </template>
                            </table-body>
                            <table-body>
                                <template v-slot:default>
                                    {{ user.last_login_at ? user.last_login_at : 'Nincs adat.'}}
                                </template>
                            </table-body>
                            <table-body>
                                <template v-slot:link>
                                    <button @click="editUser(user)" class="relative align-middle select-none font-sans font-medium text-center uppercase transition-all disabled:opacity-50 disabled:shadow-none disabled:pointer-events-none w-10 max-w-[40px] h-10 max-h-[40px] rounded-lg text-xs text-blue-gray-500 hover:bg-blue-gray-500/10 active:bg-blue-gray-500/30" as="button" aria-current="page">
                                <span class="absolute top-1/2 left-1/2 transform -translate-y-1/2 -translate-x-1/2">
                                    <EditIcon />
                                </span>
                                    </button>
                                    <button @click="openDeleteUserModal(user.id)"  class="relative align-middle select-none font-sans font-medium text-center uppercase transition-all disabled:opacity-50 disabled:shadow-none disabled:pointer-events-none w-10 max-w-[40px] h-10 max-h-[40px] rounded-lg text-xs text-blue-gray-500 hover:bg-blue-gray-500/10 active:bg-blue-gray-500/30" type="button">
                                <span class="absolute top-1/2 left-1/2 transform -translate-y-1/2 -translate-x-1/2">
                                    <DeleteIcon />
                                </span>
                                    </button>
                                </template>
                            </table-body>
                        </tr>
                    </template>
                </table-skeleton>
            </div>
        </div>
    </div>
    <UserDeleteModal :modalUserId="modalUserId" :show="showModal" @close="closeModal"/>
    <vue3-snackbar bottom right :duration="4000"></vue3-snackbar>
</template>
<script setup>
import { defineProps,ref } from 'vue';
import Navbar from "./LayoutComponents/Navbar.vue";
import TableSkeleton from "./LayoutComponents/TableSkeleton.vue";
import TableHead from "./LayoutComponents/TableHead.vue";
import TableBody from "./LayoutComponents/TableBody.vue";
import DeleteIcon from "./LayoutComponents/Icons/DeleteIcon.vue";
import EditIcon from "./LayoutComponents/Icons/EditIcon.vue";
import UserInput from "./LayoutComponents/UserInput.vue";
import UserEditInput from "./LayoutComponents/UserEditInput.vue";
import UserDeleteModal from "./LayoutComponents/UserDeleteModal.vue";
import {Vue3Snackbar} from "vue3-snackbar";
import SearchBar from "./LayoutComponents/SearchBar.vue";

const {users,userPermissions,errors,searchedText} = defineProps(['users','userPermissions','errors','searchedText']);
const userInputShow = ref(false);

const userEditShow = ref(false);
const userEditObject = ref('');
const isActive = (activeStatus) => {
    return activeStatus ? 'Aktív' : 'Inaktív';
};

//todo ugyanaz a két függvény
const canModify = (can) => {
    return can ? 'Igen' : 'Nem';
};

const showUserAddField = () => {
    userInputShow.value = !userInputShow.value
}

const editUser = (user) => {
    userEditShow.value = !userEditShow.value;
    userEditObject.value = user;
}

const hideAddUser = () => {
    userInputShow.value = !userInputShow.value;
}

const modalUserId = ref('');
const showModal = ref(false);

const openDeleteUserModal = (userId) => {
    modalUserId.value = userId;
    showModal.value = true;
}

const closeModal = () => {
    modalUserId.value = '';
    showModal.value = false;
}
</script>
