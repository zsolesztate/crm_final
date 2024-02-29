<template>
    <div class="bg-white">
        <Navbar :userCanModify="userCanModify.can_modify"/>
        <div class="mt-20 block text-center">
            <h1 class="text-4xl font-bold tracking-tight text-gray-900">Munkatársak</h1>
            <div class="mt-10 flex flex-col items-center justify-center gap-y-6 sm:gap-y-0 sm:flex-row sm:justify-center sm:gap-x-6">
                <div class="text-sm font-semibold leading-6 text-gray-900">Munkatárs hozzáadása <span aria-hidden="true">→</span></div>
                <button type="button" @click="showCoworkerAddField" class="rounded-md bg-indigo-600 px-3.5 py-2.5 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">Lenyit</button>
            </div>
        </div>
        <CoWorkerInput v-if="coworkerInputShow" @hide="hideAddCoworker"/>
        <CoWorkerEditInput v-if="coworkerEditShow" :coworker="coworkerEditObject" @hide="editCoworker"/>
        <div class="relative mt-10 isolate px-6 pt-14 lg:px-8">
            <SearchBar :searchedText="searchedText" :errors="errors" />
            <div class="mx-auto">
                <table-skeleton>
                    <template v-slot:thead>
                        <table-head>Név</table-head>
                        <table-head>Email címe</table-head>
                        <table-head>Telefonszám</table-head>
                        <table-head>Beosztás</table-head>
                        <table-head>Szerkesztés/Törlés</table-head>
                    </template>
                    <template v-slot:tbody>
                        <tr  v-for="(coworker) in coworkers" :key="coworker.id">
                            <table-body>
                                <template v-slot:default>
                                    {{ coworker.name}}
                                </template>
                            </table-body>
                            <table-body>
                                <template v-slot:default>
                                    {{ coworker.email}}
                                </template>
                            </table-body>
                            <table-body>
                                <template v-slot:default>
                                    {{ coworker.phone}}
                                </template>
                            </table-body>
                            <table-body>
                                <template v-slot:default>
                                    {{ coworker.position}}
                                </template>
                            </table-body>
                            <table-body>
                                <template v-slot:link>
                                    <button @click="editCoworker(coworker)" class="relative align-middle select-none font-sans font-medium text-center uppercase transition-all disabled:opacity-50 disabled:shadow-none disabled:pointer-events-none w-10 max-w-[40px] h-10 max-h-[40px] rounded-lg text-xs text-blue-gray-500 hover:bg-blue-gray-500/10 active:bg-blue-gray-500/30" as="button" aria-current="page">
                                <span class="absolute top-1/2 left-1/2 transform -translate-y-1/2 -translate-x-1/2">
                                    <EditIcon />
                                </span>
                                    </button>
                                    <button @click="openDeleteCoworkerModal(coworker.id)"  class="relative align-middle select-none font-sans font-medium text-center uppercase transition-all disabled:opacity-50 disabled:shadow-none disabled:pointer-events-none w-10 max-w-[40px] h-10 max-h-[40px] rounded-lg text-xs text-blue-gray-500 hover:bg-blue-gray-500/10 active:bg-blue-gray-500/30" type="button">
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
    <CoWorkerDeleteModal :modalCoworkerId="modalCoworkerId" :show="showModal" @close="closeModal"/>
    <vue3-snackbar bottom right :duration="4000"></vue3-snackbar>
</template>
<script setup>
import Navbar from "./LayoutComponents/Navbar.vue";
import EditIcon from "./LayoutComponents/Icons/EditIcon.vue";
import TableHead from "./LayoutComponents/TableHead.vue";
import TableSkeleton from "./LayoutComponents/TableSkeleton.vue";
import DeleteIcon from "./LayoutComponents/Icons/DeleteIcon.vue";
import TableBody from "./LayoutComponents/TableBody.vue";
import CoWorkerInput from "./LayoutComponents/CoWorkerInput.vue";
import CoWorkerEditInput from "./LayoutComponents/CoWorkerEditInput.vue";
import CoWorkerDeleteModal from "./LayoutComponents/CoWorkerDeleteModal.vue";
import SearchBar from "./LayoutComponents/SearchBar.vue";
import {defineProps,ref} from "vue";
import {Vue3Snackbar} from "vue3-snackbar";

const {coworkers,userCanModify,searchedText,errors} = defineProps(['coworkers','userCanModify','searchedText','errors']);


const coworkerInputShow = ref(false);
const showCoworkerAddField = () => {
    coworkerInputShow.value = !coworkerInputShow.value
}

const hideAddCoworker = () => {
    coworkerInputShow.value = !coworkerInputShow.value;
}

const coworkerEditShow = ref(false);
const coworkerEditObject = ref('');
const editCoworker = (coworker) => {
    coworkerEditShow.value = !coworkerEditShow.value;
    coworkerEditObject.value = coworker;
}

const modalCoworkerId = ref('');
const showModal = ref(false);

const openDeleteCoworkerModal = (coworkerId) => {
    modalCoworkerId.value = coworkerId;
    showModal.value = true;
}

const closeModal = () => {
    modalCoworkerId.value = '';
    showModal.value = false;
}
</script>
