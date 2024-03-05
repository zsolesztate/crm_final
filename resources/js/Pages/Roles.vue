<template>
    <Navbar :userCanModify="userPermissions" />
    <div class="mt-10 block text-center">
        <h1 class="text-4xl font-bold tracking-tight text-gray-900">Jogosultságok kezelése</h1>
    </div>
    <div class="relative mt-10 isolate px-6 pt-14 lg:px-8">
        <div class="mx-auto w-2/5">
            <div class="flex items-center justify-end">
                <Link href="roles/create" class="hover:text-indigo-300 text-green-500 flex items-center space-x-2">
                    <span>Hozzáadás</span>
                    <PlusIcon />
                </Link>
            </div>
            <table-skeleton>
                <template v-slot:thead>
                    <table-head>Csoport neve</table-head>
                    <table-head>Műveletek</table-head>
                </template>
                <template v-slot:tbody>
                    <tr v-for="(role) in roles" :key="role.id">
                        <table-body>
                            <template v-slot:default>
                                {{ role.name }}
                            </template>
                        </table-body>
                        <table-body>
                            <template v-slot:link>
                                <Link :href="`/roles/${role.id}/edit`"  class="relative align-middle select-none font-sans font-medium text-center uppercase transition-all disabled:opacity-50 disabled:shadow-none disabled:pointer-events-none w-10 max-w-[40px] h-10 max-h-[40px] rounded-lg text-xs text-blue-gray-500 hover:bg-blue-gray-500/10 active:bg-blue-gray-500/30" as="button" aria-current="page">
                                <span class="absolute top-1/2 left-1/2 transform -translate-y-1/2 -translate-x-1/2">
                                    <EditIcon />
                                </span>
                                </Link>
                                <button @click="openDeleteRoleModal(role.id)"  class="relative align-middle select-none font-sans font-medium text-center uppercase transition-all disabled:opacity-50 disabled:shadow-none disabled:pointer-events-none w-10 max-w-[40px] h-10 max-h-[40px] rounded-lg text-xs text-blue-gray-500 hover:bg-blue-gray-500/10 active:bg-blue-gray-500/30" type="button">
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
    <RoleDeleteModal :modalRoleId="modalRoleId" :show="showModal" @close="closeModal"/>
    <vue3-snackbar bottom right :duration="4000"></vue3-snackbar>
</template>
<script setup>
import Navbar from "./LayoutComponents/Navbar.vue";
import {Link} from "@inertiajs/vue3";
import { Icons, Table } from "./CommonComponents.js";
import RoleDeleteModal from "./LayoutComponents/RoleDeleteModal.vue";
import { defineProps, ref } from "vue";
import {useSnackbar, Vue3Snackbar} from "vue3-snackbar";

const { EditIcon, DeleteIcon,PlusIcon } = Icons
const {TableSkeleton,TableHead,TableBody } = Table
const { users, roles,userPermissions } = defineProps(["users", "roles","userPermissions"]);
const snackbar = useSnackbar();

const modalRoleId = ref('');
const showModal = ref(false);

const openDeleteRoleModal = (roleId) => {
    modalRoleId.value = roleId;
    showModal.value = true;
}

const closeModal = () => {
    modalRoleId.value = '';
    showModal.value = false;
}
</script>
