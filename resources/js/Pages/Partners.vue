<template>
    <div class="bg-white">
        <div class="mt-10 block text-center">
            <h1 class="text-4xl font-bold tracking-tight text-gray-900">Partnerek kezelése</h1>
        </div>
        <Navbar :userCanModify="userPermissions"/>
        <div class="relative isolate px-6 lg:px-8 flex flex-col lg:flex-row mt-10">
            <div class="flex-grow ml-52">
                <div class="flex items-center justify-end">
                    <Link href="partners/create" class="hover:text-indigo-300 no-underline hover:underline flex items-center space-x-2 text-green-500">
                        <span class="">Partner hozzáadása</span>
                       <PlusIcon />
                    </Link>
                </div>
                <table-skeleton>
                    <template v-slot:thead>
                        <table-head>Megjelenítési név</table-head>
                        <table-head>Cégnév</table-head>
                        <table-head>Email cím</table-head>
                        <table-head>Munkatársak száma</table-head>
                        <table-head>Szerkesztés/Törlés</table-head>
                    </template>
                    <template v-slot:tbody>
                        <tr  v-for="(partner) in partners" :key="partner.id">
                            <table-body>
                                <template v-slot:default>
                                    {{ partner.name}}
                                </template>
                            </table-body>
                            <table-body>
                                <template v-slot:default>
                                    {{ partner.company_name}}
                                </template>
                            </table-body>
                            <table-body>
                                <template v-slot:default>
                                    {{ partner.email}}
                                </template>
                            </table-body>
                            <table-body>
                                <template v-slot:default>

                                <span v-if="partner.users.length === 1">
                                    {{ partner.users[0].name }}
                                </span>
                                <span v-else-if="partner.users.length > 1">
                                    {{ partner.users[0].name }} és még {{ partner.users.length - 1 }} munkatárs
                                </span>
                                <span v-else>
                                    Nincs hozzárendelt munkatárs.
                                </span>
                                </template>
                            </table-body>
                            <table-body>
                                <template v-slot:link>
                                    <Link :href="`/partners/${partner.id}/edit`" class="relative align-middle select-none font-sans font-medium text-center uppercase transition-all disabled:opacity-50 disabled:shadow-none disabled:pointer-events-none w-10 max-w-[40px] h-10 max-h-[40px] rounded-lg text-xs text-blue-gray-500 hover:bg-blue-gray-500/10 active:bg-blue-gray-500/30" as="button" aria-current="page">
                                <span class="absolute top-1/2 left-1/2 transform -translate-y-1/2 -translate-x-1/2">
                                    <EditIcon />
                                </span>
                                    </Link>
                                    <button @click="openDeletePartnerModal(partner.id)"  class="relative align-middle select-none font-sans font-medium text-center uppercase transition-all disabled:opacity-50 disabled:shadow-none disabled:pointer-events-none w-10 max-w-[40px] h-10 max-h-[40px] rounded-lg text-xs text-blue-gray-500 hover:bg-blue-gray-500/10 active:bg-blue-gray-500/30" type="button">
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
    <PartnerDeleteModal :modalPartnerId="modalPartnerId" :show="showModal" @close="closeModal"/>
    <vue3-snackbar bottom right :duration="4000"></vue3-snackbar>
</template>
<script setup>
import Navbar from "./LayoutComponents/Navbar.vue";
import { Icons, Table } from "./CommonComponents.js";
import PartnerDeleteModal from "./LayoutComponents/PartnerDeleteModal.vue";
import {defineProps,ref} from "vue";
import {Vue3Snackbar} from "vue3-snackbar";
import {Link} from "@inertiajs/vue3";

const { EditIcon, DeleteIcon,PlusIcon } = Icons
const {TableSkeleton,TableHead,TableBody } = Table
const {partners,userPermissions,users} = defineProps(['partners','userPermissions','users']);

const modalPartnerId = ref('');
const showModal = ref(false);

const openDeletePartnerModal = (partnerId) => {
    modalPartnerId.value = partnerId;
    showModal.value = true;
}

const closeModal = () => {
    modalPartnerId.value = '';
    showModal.value = false;
}
</script>
