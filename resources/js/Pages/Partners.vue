<template>
    <div class="bg-white">
        <Navbar :userCanModify="userPermissions"/>
        <div class="mt-20 block text-center">
            <h1 class="text-4xl font-bold tracking-tight text-gray-900">Partnerek</h1>
            <div class="mt-10 flex flex-col items-center justify-center gap-y-6 sm:gap-y-0 sm:flex-row sm:justify-center sm:gap-x-6">
                <div class="text-sm font-semibold leading-6 text-gray-900">Partner hozzáadása <span aria-hidden="true">→</span></div>
                <button type="button" @click="showPartnerAddField" class="rounded-md bg-indigo-600 px-3.5 py-2.5 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">Lenyit</button>
            </div>
        </div>
        <PartnerInput v-if="partnerInputShow" @hide="hideAddPartner" :users="users"/>
        <PartnerEditInput v-if="partnerEditShow" :partner="partnerEditObject" @hide="editPartner" :users="users"/>
        <div class="relative mt-10 isolate px-6 pt-14 lg:px-8">
            <SearchBar :searchedText="searchedText" :errors="errors" />
            <div class="mx-auto">
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

                                </template>
                            </table-body>
                            <table-body>
                                <template v-slot:link>
                                    <button @click="editPartner(partner)" class="relative align-middle select-none font-sans font-medium text-center uppercase transition-all disabled:opacity-50 disabled:shadow-none disabled:pointer-events-none w-10 max-w-[40px] h-10 max-h-[40px] rounded-lg text-xs text-blue-gray-500 hover:bg-blue-gray-500/10 active:bg-blue-gray-500/30" as="button" aria-current="page">
                                <span class="absolute top-1/2 left-1/2 transform -translate-y-1/2 -translate-x-1/2">
                                    <EditIcon />
                                </span>
                                    </button>
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
import EditIcon from "./LayoutComponents/Icons/EditIcon.vue";
import TableHead from "./LayoutComponents/TableHead.vue";
import TableSkeleton from "./LayoutComponents/TableSkeleton.vue";
import DeleteIcon from "./LayoutComponents/Icons/DeleteIcon.vue";
import TableBody from "./LayoutComponents/TableBody.vue";
import PartnerInput from "./LayoutComponents/PartnerInput.vue";
import PartnerEditInput from "./LayoutComponents/PartnerEditInput.vue";
import PartnerDeleteModal from "./LayoutComponents/PartnerDeleteModal.vue";

import SearchBar from "./LayoutComponents/SearchBar.vue";
import {defineProps,ref} from "vue";
import {Vue3Snackbar} from "vue3-snackbar";

const {partners,userPermissions,users} = defineProps(['partners','userPermissions','users']);


const partnerInputShow = ref(false);
const showPartnerAddField = () => {
    partnerInputShow.value = !partnerInputShow.value
}

const hideAddPartner = () => {
    partnerInputShow.value = !partnerInputShow.value;
}

const partnerEditShow = ref(false);
const partnerEditObject = ref('');
const editPartner = (partner) => {
    partnerEditShow.value = !partnerEditShow.value;
    partnerEditObject.value = partner;
}

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
