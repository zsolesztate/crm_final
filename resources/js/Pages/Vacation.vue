<template>
    <Navbar :userCanModify="userPermissions"/>
    <ShowLayout>
        <template v-slot:title>
            Szabadságok kezelése
            <div class="flex items-center">
                <div class="flex-1 mt-4 min-w-0 ms-4">
                    <p class="text-lg font-medium text-gray-900 truncate">
                        {{ contact.name}}
                    </p>
                    <p class="text-sm mt-2 text-gray-500 truncate">
                        {{ contact.email}}
                    </p>
                </div>
            </div>
        </template>
        <template v-slot:content>
            <div class="flex items-center justify-between">
                <Link href="/contacts/" class="hover:text-indigo-300 no-underline hover:underline mt-4 flex items-center space-x-2 text-blue-500">
                    <BackIcon />
                    <span class="">Vissza a kapcsolattartókhoz</span>
                </Link>
                <Link :href="`/vacations/${contact.id}/create`" class="hover:text-indigo-300 no-underline hover:underline mt-4 flex items-center space-x-2 text-green-500">
                    <span class="">Szabadság hozzáadása</span>
                    <PlusIcon />
                </Link>
            </div>
            <table-skeleton>
                <template v-slot:thead>
                    <table-head>Szabadság oka</table-head>
                    <table-head>Dátumtól</table-head>
                    <table-head>Dátumig</table-head>
                    <table-head>Szerkesztés/törlés</table-head>
                </template>
                <template v-slot:tbody v-if="vacations.length > 0">
                    <tr v-for="(vacation) in vacations" :key="vacation.id">
                        <table-body>
                            <template v-slot:default>
                                {{ vacation.name}}
                            </template>
                        </table-body>
                        <table-body>
                            <template v-slot:default>
                                {{ vacation.from_date}}
                            </template>
                        </table-body>
                        <table-body>
                            <template v-slot:default>
                                {{ vacation.to_date}}
                            </template>
                        </table-body>
                        <table-body>
                            <template v-slot:link>
                                <Link  :href="`/vacations/${contact.id}/${vacation.id}/edit`" class="relative align-middle select-none font-sans font-medium text-center uppercase transition-all disabled:opacity-50 disabled:shadow-none disabled:pointer-events-none w-10 max-w-[40px] h-10 max-h-[40px] rounded-lg text-xs text-blue-gray-500 hover:bg-blue-gray-500/10 active:bg-blue-gray-500/30" as="button" aria-current="page">
                                <span class="absolute top-1/2 left-1/2 transform -translate-y-1/2 -translate-x-1/2">
                                    <EditIcon />
                                </span>
                                </Link>
                                <button  @click="openDeleteVacationModal(vacation.id)"  class="relative align-middle select-none font-sans font-medium text-center uppercase transition-all disabled:opacity-50 disabled:shadow-none disabled:pointer-events-none w-10 max-w-[40px] h-10 max-h-[40px] rounded-lg text-xs text-blue-gray-500 hover:bg-blue-gray-500/10 active:bg-blue-gray-500/30" type="button">
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
        </template>
    </ShowLayout>
    <DeleteModal :modalId="modalVacationId" :show="showModal" :route="`vacations/${contact.id}`" @close="closeModal"/>
    <vue3-snackbar bottom right :duration="4000"></vue3-snackbar>
</template>
<script setup>
import Navbar from "./LayoutComponents/Navbar.vue";
import {defineProps, ref} from "vue";
import ShowLayout from "./LayoutComponents/ShowLayout.vue";
import { Icons, Table } from "./CommonComponents.js"
import {Link} from "@inertiajs/vue3";
import DeleteModal from "./LayoutComponents/DeleteModal.vue";
import {Vue3Snackbar} from "vue3-snackbar";

const { EditIcon, DeleteIcon,PlusIcon,BackIcon } = Icons
const {TableSkeleton,TableHead,TableBody } = Table
const {vacations,contact,userPermissions} = defineProps(['vacations','userPermissions','contact']);

const modalVacationId = ref('');
const showModal = ref(false);

const openDeleteVacationModal = (vacationId) => {
    modalVacationId.value = vacationId;
    showModal.value = true;
}

const closeModal = () => {
    modalVacationId.value = '';
    showModal.value = false;
}

</script>
