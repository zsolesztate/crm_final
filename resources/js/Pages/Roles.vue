<template>
    <Navbar :userCanModify="userPermissions" />
    <div class="mt-20 block text-center">
        <h1 class="text-4xl font-bold tracking-tight text-gray-900">Felhasználók és csoportok</h1>
    </div>
    <div class="relative mt-10 isolate px-6 pt-14 lg:px-8">
        <div class="mx-auto">
            <table-skeleton>
                <template v-slot:thead>
                    <table-head>Felhasználó neve</table-head>
                    <table-head>Email címe</table-head>
                    <table-head>Beállított csoport</table-head>
                    <table-head>Csoport beállítása</table-head>
                    <table-head></table-head>
                </template>
                <template v-slot:tbody>
                    <tr v-for="(user) in users" :key="user.id">
                        <table-body>
                            <template v-slot:default>
                                {{ user.name }}
                            </template>
                        </table-body>
                        <table-body>
                            <template v-slot:default>
                                {{ user.email }}
                            </template>
                        </table-body>
                        <table-body>
                            <template v-slot:default>
                                {{ user.roles[0]?.name ? user.roles[0]?.name : 'Nincs még csoport hozzáadva.' }}
                            </template>
                        </table-body>
                        <table-body>
                            <template v-slot:default>
                                <button @click="toggleDropdown(user.id)" id="dropdownDefaultButton" data-dropdown-toggle="dropdown" class="w-44 text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center inline-flex items-center" type="button">
                                    {{ selectedRoles[user.id] ? selectedRoles[user.id] : (user.roles[0]?.name ? user.roles[0]?.name : 'Válassz') }}
                                    <svg class="w-2.5 h-2.5 ms-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 4 4 4-4"/>
                                    </svg>
                                </button>
                                <div v-if="showDropdown === user.id" id="dropdown" class="absolute z-10 bg-gray-200 divide-y divide-gray-50 rounded-lg shadow w-44">
                                    <ul class="py-2 text-sm text-gray-700" aria-labelledby="dropdownDefaultButton">
                                        <li @click="selectRole(user.id, role.name,role.id)" v-for="role in roles" class="hover:bg-gray-50 px-4 py-2">
                                            <button >{{ role.name }}</button>
                                        </li>
                                    </ul>
                                </div>
                            </template>
                        </table-body>
                        <table-body>
                            <template v-slot:default>
                                <button @click="save" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">
                                   Mentés
                                </button>
                            </template>
                        </table-body>
                    </tr>
                </template>
            </table-skeleton>
        </div>
    </div>
    <div class="mt-20 block text-center">
    <h1 class="text-4xl font-bold tracking-tight text-gray-900">Jogosultságok kezelése</h1>
    </div>
    <div class="mt-10 flex flex-col items-center justify-center gap-y-6 sm:gap-y-0 sm:flex-row sm:justify-center sm:gap-x-6">
        <div class="text-sm font-semibold leading-6 text-gray-900">Csoport hozzáadása <span aria-hidden="true">→</span></div>
        <button type="button" @click="showRoleAddField" class="rounded-md bg-indigo-600 px-3.5 py-2.5 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">{{ showRoleAddField ? 'Lenyit' : 'Bezár'}}</button>
    </div>
    <RoleInput v-if="roleInputShow" @hide="showRoleAddField"/>
    <RoleEditImput v-if="roleEditShow" :role="roleEditObject" @hide="editRole"/>
    <div class="relative mt-10 isolate px-6 pt-14 lg:px-8">
        <div class="mx-auto w-2/5">
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
                                <button @click="editRole(role)" class="relative align-middle select-none font-sans font-medium text-center uppercase transition-all disabled:opacity-50 disabled:shadow-none disabled:pointer-events-none w-10 max-w-[40px] h-10 max-h-[40px] rounded-lg text-xs text-blue-gray-500 hover:bg-blue-gray-500/10 active:bg-blue-gray-500/30" as="button" aria-current="page">
                                <span class="absolute top-1/2 left-1/2 transform -translate-y-1/2 -translate-x-1/2">
                                    <EditIcon />
                                </span>
                                </button>
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
import { defineProps, ref } from "vue";
import TableHead from "./LayoutComponents/TableHead.vue";
import TableSkeleton from "./LayoutComponents/TableSkeleton.vue";
import TableBody from "./LayoutComponents/TableBody.vue";
import {useSnackbar, Vue3Snackbar} from "vue3-snackbar";
import { router } from '@inertiajs/vue3';
import EditIcon from "./LayoutComponents/Icons/EditIcon.vue";
import DeleteIcon from "./LayoutComponents/Icons/DeleteIcon.vue";
import RoleInput from "./LayoutComponents/RoleInput.vue";
import RoleEditImput from "./LayoutComponents/RoleEditInput.vue";
import RoleDeleteModal from "./LayoutComponents/RoleDeleteModal.vue";
import UserDeleteModal from "./LayoutComponents/UserDeleteModal.vue";

const { users, roles,userPermissions } = defineProps(["users", "roles","userPermissions"]);
const snackbar = useSnackbar();

const showDropdown = ref(false);
const selectedRoles = ref({});
const selectedData = ref({
    userId:'',
    roleId:''
});

const toggleDropdown = (userid) => {
    if (showDropdown.value === userid) {
        showDropdown.value = false;
    } else {
        showDropdown.value = userid;
    }
};

const selectRole = (userId, role,roleId) => {
    selectedRoles.value[userId] = role;
    showDropdown.value = false
    selectedData.value.userId = userId;
    selectedData.value.roleId = roleId;
};

const save = () => {
    if (!selectedData.value.userId) {
        snackbar.add({
            type: 'warning',
            text: 'Nem változtattál az adatokon.'
        })
        return;
    }
     router.post(`/roles/user/`,selectedData.value ,{
        onSuccess: () => {
            snackbar.add({
                type: 'success',
                text: 'Csoport módosítva'
            })
        },
        onError: () => {
            snackbar.add({
                type: 'error',
                text: 'Hiba történt.'
            })
        },
    });
}

const roleInputShow = ref(false);

const showRoleAddField = () => {
    roleInputShow.value = !roleInputShow.value;
}

const roleEditShow = ref(false);
const roleEditObject = ref('');
const editRole = (role) => {
    roleEditShow.value = !roleEditShow.value;
    roleEditObject.value = role;
}

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
