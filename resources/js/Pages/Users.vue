<template>
    <div class="bg-white">
        <div class="mt-10 block text-center">
            <h1 class="text-4xl font-bold tracking-tight text-gray-900">Munkatársak kezelése</h1>
        </div>
        <Navbar :userCanModify="userPermissions"/>
        <div class="relative isolate px-6 lg:px-8 flex flex-col lg:flex-row">
            <div class="flex-grow ml-52">
                <SearchBar :searchedText="searchedText" :errors="errors" />
                <div class="flex items-center justify-end">
                    <Link href="users/create" class="hover:text-indigo-300 no-underline hover:underline flex items-center space-x-2 text-green-500">
                        <span class="">Munkatárs hozzáadása</span>
                        <PlusIcon />
                    </Link>
                </div>
                <table-skeleton>
                    <template v-slot:thead>
                        <table-head>Felhasználó neve</table-head>
                        <table-head>Email címe</table-head>
                        <table-head>Státusz</table-head>
                        <table-head>Módosítási jog</table-head>
                        <table-head>Utolsó belépés</table-head>
                        <table-head>Csoport</table-head>
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
                                <template v-slot:default>
                                    {{ user.roles[0].name}}
                                </template>
                            </table-body>
                            <table-body>
                                <template v-slot:link>
                                    <Link :href="`/users/${user.id}/edit`" class="relative align-middle select-none font-sans font-medium text-center uppercase transition-all disabled:opacity-50 disabled:shadow-none disabled:pointer-events-none w-10 max-w-[40px] h-10 max-h-[40px] rounded-lg text-xs text-blue-gray-500 hover:bg-blue-gray-500/10 active:bg-blue-gray-500/30" as="button" aria-current="page">
                                <span class="absolute top-1/2 left-1/2 transform -translate-y-1/2 -translate-x-1/2">
                                    <EditIcon />
                                </span>
                                    </Link>
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
import Navbar from "./LayoutComponents/Navbar.vue";
import { Icons, Table } from "./CommonComponents.js"
import SearchBar from "./LayoutComponents/SearchBar.vue";
import UserDeleteModal from "./LayoutComponents/UserDeleteModal.vue";
import {Vue3Snackbar} from "vue3-snackbar";
import {Link} from "@inertiajs/vue3";
import { defineProps,ref } from 'vue';

const { EditIcon, DeleteIcon,PlusIcon } = Icons
const {TableSkeleton,TableHead,TableBody } = Table
const {users,userPermissions,errors,searchedText} = defineProps(['users','userPermissions','errors','searchedText']);

const isActive = (activeStatus) => {
    return activeStatus ? 'Aktív' : 'Inaktív';
};

const canModify = (can) => {
    return can ? 'Igen' : 'Nem';
};

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
