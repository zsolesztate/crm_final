<template>
    <Navbar :userCanModify="userPermissions"/>
    <ShowLayout>
        <template v-slot:title>
            Partnerek kezelése
        </template>
        <template v-slot:content>
                <div v-if="userPermissions.can_create_partner" class="flex items-center justify-end">
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
                                    <div v-if="partner.users.length > 0">
                                        {{ partner.users[0].name }}
                                        <span v-if="partner.users.length > 1">
                                            és még {{ partner.users.length - 1 }} munkatárs
                                        </span>
                                    </div>
                                    <div v-else>
                                        Nincs hozzárendelt munkatárs.
                                    </div>
                                </template>
                            </table-body>
                            <table-body>
                                <template v-slot:link>
                                    <Link v-if="userPermissions.can_edit_partner" :href="`/partners/${partner.id}/edit`" class="relative align-middle select-none font-sans font-medium text-center uppercase transition-all disabled:opacity-50 disabled:shadow-none disabled:pointer-events-none w-10 max-w-[40px] h-10 max-h-[40px] rounded-lg text-xs text-blue-gray-500 hover:bg-blue-gray-500/10 active:bg-blue-gray-500/30" as="button" aria-current="page">
                                <span class="absolute top-1/2 left-1/2 transform -translate-y-1/2 -translate-x-1/2">
                                    <EditIcon />
                                </span>
                                    </Link>
                                    <button v-if="userPermissions.can_delete_partner" @click="openDeletePartnerModal(partner.id)"  class="relative align-middle select-none font-sans font-medium text-center uppercase transition-all disabled:opacity-50 disabled:shadow-none disabled:pointer-events-none w-10 max-w-[40px] h-10 max-h-[40px] rounded-lg text-xs text-blue-gray-500 hover:bg-blue-gray-500/10 active:bg-blue-gray-500/30" type="button">
                                <span class="absolute top-1/2 left-1/2 transform -translate-y-1/2 -translate-x-1/2">
                                    <DeleteIcon />
                                </span>
                                    </button>
                                </template>
                            </table-body>
                        </tr>
                    </template>
                </table-skeleton>
                <div class="mt-10" v-if="partners.length === 0">
                    Nincs megjeleníthető partner.
                </div>
        </template>
    </ShowLayout>
    <DeleteModal :modalId="modalPartnerId" :show="showModal" :route="'partners'" @close="closeModal"/>
    <vue3-snackbar bottom right :duration="4000"></vue3-snackbar>
</template>

<script setup>
import Navbar from "./LayoutComponents/Navbar.vue";
import { Icons, Table } from "./CommonComponents.js";
import {defineProps,ref} from "vue";
import {Vue3Snackbar} from "vue3-snackbar";
import {Link} from "@inertiajs/vue3";
import DeleteModal from "./LayoutComponents/DeleteModal.vue";
import ShowLayout from "./LayoutComponents/ShowLayout.vue";

const { EditIcon, DeleteIcon,PlusIcon } = Icons
const {TableSkeleton,TableHead,TableBody } = Table
const {partners,userPermissions} = defineProps(['partners','userPermissions']);

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
