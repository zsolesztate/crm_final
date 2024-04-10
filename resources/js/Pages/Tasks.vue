<template>
    <Navbar :userCanModify="userPermissions"/>
    <ShowLayout>
        <template v-slot:title>
           Feladatok kezelése
            <SubInfo>
                <template #main_info>
                   Projekt neve :  {{project.name}}
                </template>
            </SubInfo>
        </template>
        <template v-slot:content>
            <div class="flex items-center justify-between">
                <Link href="/projects/" class="hover:text-indigo-300 no-underline hover:underline mt-4 flex items-center space-x-2 text-blue-500">
                    <BackIcon />
                    <span class="">Vissza a projektekhez</span>
                </Link>
                <Link :href="`/tasks/${project.id}/create`" class="hover:text-indigo-300 no-underline hover:underline flex items-center space-x-2 text-green-500">
                    <span class="">Feladat hozzáadása</span>
                    <PlusIcon />
                </Link>
            </div>
            <table-skeleton>
                <template v-slot:thead>
                    <table-head>Feladatnév</table-head>
                    <table-head>Leírás</table-head>
                    <table-head>Munkatársak</table-head>
                    <table-head>Tervezett kezdés dátuma</table-head>
                    <table-head>Tervezett befejezés dátuma</table-head>
                    <table-head>Kapcsolattartó</table-head>
                    <table-head>Státusz</table-head>
                    <table-head>Szerkesztés/törlés</table-head>
                </template>
                <template v-slot:tbody>
                    <tr v-for="task in tasks"  >
                        <table-body>
                            <template v-slot:default>
                                {{ task.name}}
                            </template>
                        </table-body>
                        <table-body>
                            <template v-slot:default>
                                {{ shortText(task.description)}}
                            </template>
                        </table-body>
                        <table-body>
                            <template v-slot:default>
                                <div v-if="task.users.length > 0">
                                    {{ task.users[0].name }}
                                    <span v-if="task.users.length > 1">
                                            és még {{ task.users.length - 1 }} munkatárs
                                        </span>
                                </div>
                                <div v-else>
                                    Nincs hozzárendelt munkatárs.
                                </div>
                            </template>
                        </table-body>
                        <table-body>
                            <template v-slot:default>
                                {{ task.start_date}}
                            </template>
                        </table-body>
                        <table-body>
                            <template v-slot:default>
                                {{ task.finnish_date}}
                            </template>
                        </table-body>
                        <table-body>
                            <template v-slot:default>
                                {{ task.contact.name}}
                            </template>
                        </table-body>
                        <table-body>
                            <template v-slot:default>
                                {{ statusName(task.status)}}
                            </template>
                        </table-body>
                        <table-body>
                            <template v-slot:link>
                                <Link :href="`/tasks/${task.id}/edit`" class="relative align-middle select-none font-sans font-medium text-center uppercase transition-all disabled:opacity-50 disabled:shadow-none disabled:pointer-events-none w-10 max-w-[40px] h-10 max-h-[40px] rounded-lg text-xs text-blue-gray-500 hover:bg-blue-gray-500/10 active:bg-blue-gray-500/30" as="button" aria-current="page">
                                <span class="absolute top-1/2 left-1/2 transform -translate-y-1/2 -translate-x-1/2">
                                    <EditIcon />
                                </span>
                                </Link>
                                <button @click="openDeleteTaskModal(task.id)"  class="relative align-middle select-none font-sans font-medium text-center uppercase transition-all disabled:opacity-50 disabled:shadow-none disabled:pointer-events-none w-10 max-w-[40px] h-10 max-h-[40px] rounded-lg text-xs text-blue-gray-500 hover:bg-blue-gray-500/10 active:bg-blue-gray-500/30" type="button">
                                <span class="absolute top-1/2 left-1/2 transform -translate-y-1/2 -translate-x-1/2">
                                    <DeleteIcon />
                                </span>
                                </button>
                            </template>
                        </table-body>
                    </tr>
                </template>
            </table-skeleton>
            <div class="mt-10" v-if="tasks.length === 0">
                Nincs megjeleníthető feladatok.
            </div>
        </template>
    </ShowLayout>
    <DeleteModal :modalId="modalTaskId" :show="showModal" :route="'tasks'" @close="closeModal"/>
    <vue3-snackbar bottom right :duration="4000"></vue3-snackbar>
</template>
<script setup>
import Navbar from "./LayoutComponents/Navbar.vue";
import ShowLayout from "./LayoutComponents/ShowLayout.vue";
import { Icons, Table } from "./CommonComponents.js";
import {defineProps, ref} from "vue";
import {Vue3Snackbar} from "vue3-snackbar";
import DeleteModal from "./LayoutComponents/DeleteModal.vue";
import {Link} from "@inertiajs/vue3";

const { EditIcon, DeleteIcon,PlusIcon,BackIcon } = Icons
const {TableSkeleton,TableHead,TableBody,SubInfo } = Table
const {tasks,userPermissions,project} = defineProps(['tasks','userPermissions','project']);


const modalTaskId = ref('');
const showModal = ref(false);

const openDeleteTaskModal = (taskId) => {
    modalTaskId.value = taskId;
    showModal.value = true;
}

const closeModal = () => {
    modalTaskId.value = '';
    showModal.value = false;
}

const shortText = (text) => {
    if (!text) return '';
    return text.length <= 25 ? text : text.substring(0, 30) + '...';
}

const statusName = (status) => {
    return status ? 'Folyamatban' : 'Befejezett';
};
</script>
