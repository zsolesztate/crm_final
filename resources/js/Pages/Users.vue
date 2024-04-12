<template>
    <Navbar :userCanModify="userPermissions"/>
    <ShowLayout>
        <template v-slot:title>
            Munkatársak kezelése
        </template>
        <template v-slot:content>
                    <SearchBar :searchedText="searchedText" :route="'users'" :errors="errors"/>
                <div v-if="userPermissions.can_create_user" class="flex items-center justify-end">
                    <Link href="/users/create"
                          class="hover:text-indigo-300 no-underline hover:underline mt-4 flex items-center space-x-2 text-green-500">
                        <span class="">Munkatárs hozzáadása</span>
                        <PlusIcon />
                    </Link>
                </div>
                <table-skeleton v-if="userPermissions.can_view_users">
                    <template v-slot:thead>
                        <table-head>Felhasználó neve</table-head>
                        <table-head>Email címe</table-head>
                        <table-head>Státusz</table-head>
                        <table-head>Módosítási jog</table-head>
                        <table-head>Utolsó belépés</table-head>
                        <table-head>Csoport</table-head>
                        <table-head>Szerkesztés/Törlés</table-head>
                    </template>
                    <template v-slot:tbody v-if="users.length > 0">
                        <tr v-for="(user) in users" :key="user.id">
                            <table-body>
                                    {{ user.name}}
                            </table-body>
                            <table-body>
                                    {{ user.email}}
                            </table-body>
                            <table-body>
                                    {{ isActive(user.active_status)}}
                            </table-body>
                            <table-body>
                                    {{ canModify(user.can_modify)}}
                            </table-body>
                            <table-body>
                                    {{ user.last_login_at ? user.last_login_at : 'Nincs adat.'}}
                            </table-body>
                            <table-body>
                                    {{ user.roles[0].name}}
                            </table-body>
                            <table-body>
                                <template v-slot:link>
                                    <Link v-if="userPermissions.can_edit_user"
                                          :href="`/users/${user.id}/edit`"
                                          class="relative align-middle select-none font-sans font-medium text-center uppercase transition-all disabled:opacity-50 disabled:shadow-none disabled:pointer-events-none w-10 max-w-[40px] h-10 max-h-[40px] rounded-lg text-xs text-blue-gray-500 hover:bg-blue-gray-500/10 active:bg-blue-gray-500/30"
                                          as="button" aria-current="page"
                                    >
                                <span class="absolute top-1/2 left-1/2 transform -translate-y-1/2 -translate-x-1/2">
                                    <EditIcon />
                                </span>
                                    </Link>
                                    <button v-if="userPermissions.can_delete_user" @click="openDeleteUserModal(user.id)"
                                            class="relative align-middle select-none font-sans font-medium text-center uppercase transition-all disabled:opacity-50 disabled:shadow-none disabled:pointer-events-none w-10 max-w-[40px] h-10 max-h-[40px] rounded-lg text-xs text-blue-gray-500 hover:bg-blue-gray-500/10 active:bg-blue-gray-500/30" type="button">
                                <span class="absolute top-1/2 left-1/2 transform -translate-y-1/2 -translate-x-1/2">
                                    <DeleteIcon />
                                </span>
                                    </button>
                                </template>
                            </table-body>
                        </tr>
                    </template>
                     <template v-slot:tbody v-else>
                         <span>
                              Nincs a keresési feltételeknek megfelelő találat.
                         </span>
                     </template>
                </table-skeleton>
                <div v-else>
                    Nincs jogosultságod megnézni a munkatársakat.
                </div>
        </template>
    </ShowLayout>
    <DeleteModal :modalId="modalUserId" :show="showModal" :route="'users'" @close="closeModal"/>
    <vue3-snackbar bottom right :duration="4000"></vue3-snackbar>
</template>
<script setup>
import Navbar from "./LayoutComponents/Navbar.vue";
import { Icons, Table } from "./CommonComponents.js"
import SearchBar from "./LayoutComponents/SearchBar.vue";
import DeleteModal from "./LayoutComponents/DeleteModal.vue";
import ShowLayout from "./LayoutComponents/ShowLayout.vue";
import {Vue3Snackbar} from "vue3-snackbar";
import {Link} from "@inertiajs/vue3";
import { defineProps,ref } from 'vue';

const { EditIcon, DeleteIcon,PlusIcon } = Icons
const {TableSkeleton,TableHead,TableBody } = Table
const {users,userPermissions,searchedText,errors} = defineProps(['users','userPermissions','searchedText','errors']);

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
