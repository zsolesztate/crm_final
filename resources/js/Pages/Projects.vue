<template>
    <Navbar :userCanModify="userPermissions"/>
    <ShowLayout>
        <template v-slot:title>
            Projektek kezelése
        </template>
        <template v-slot:content>
            <div class="flex items-center justify-between">
                <div class="flex items-center space-x-4">
                    <div class="w-96"><SearchBar :searchedText="searchedText" :route="'projects'" :errors="errors"/></div>
                    <div class="w-48 mb-2">
                        <Label for="name">Munkatársak között</Label>
                        <SearchDropdown :options="users" type="user" :route="'projects'" :selected="user" customClass="bg-gray-400 hover:bg-gray-500 focus:ring-gray-300"/>
                    </div>
                    <div class="w-48 mb-2">
                        <Label for="name">Kapcsolattartók között</Label>
                        <SearchDropdown :options="contacts" type="contact" :route="'projects'" :selected="contact" customClass="bg-gray-400 hover:bg-gray-500 focus:ring-gray-300"/>
                    </div>
                </div>
                <div class="flex items-center space-x-4">
                    <Link href="/projects/create" class="hover:text-indigo-300 no-underline hover:underline flex items-center space-x-2 text-green-500">
                        <span class="">Projekt hozzáadása</span>
                        <PlusIcon />
                    </Link>
                </div>
            </div>
            <table-skeleton>
                <template v-slot:thead>
                    <table-head>Projektnév</table-head>
                    <table-head>Leírás</table-head>
                    <table-head>Feladatok</table-head>
                    <table-head>Feladatok száma</table-head>
                    <table-head>Projekt státusza</table-head>
                    <table-head>Partner</table-head>
                    <table-head>Projekt kezdetének dátuma</table-head>
                    <table-head>Projekt zárásának dátuma</table-head>
                    <table-head>Projekten dolgozó munkatársak</table-head>
                    <table-head>Szerkesztés/törlés</table-head>
                </template>
                <template v-slot:tbody>
                    <tr v-for="project in projects"  >
                        <table-body>
                                {{ project.project.name}}
                        </table-body>
                        <table-body>
                                {{ project.project.description}}
                        </table-body>
                        <table-body>
                                <GradientButton :href="`/tasks/${project.project.id}`" type="button">
                                   Feladatok kezelése
                                </GradientButton>
                        </table-body>
                        <table-body>
                               Összesen {{ project.task_count}} ebből  {{ project.completed_task_count}} van kész.
                        </table-body>
                        <table-body>
                                {{ statusName(project.is_in_progress)}}
                        </table-body>
                        <table-body>
                              {{ project.project.partner.name}}
                        </table-body>
                        <table-body>
                                {{ project.earliest_start_date}}
                        </table-body>
                        <table-body>
                                {{ project.latest_end_date}}
                        </table-body>
                        <table-body>
                                <div v-for="user in project.users">
                                    {{ user.name}}
                                </div>
                        </table-body>
                        <table-body>
                            <template v-slot:link>
                                <Link :href="`/projects/${project.project.id}/edit`"
                                      class="relative align-middle select-none font-sans font-medium text-center uppercase transition-all disabled:opacity-50 disabled:shadow-none disabled:pointer-events-none w-10 max-w-[40px] h-10 max-h-[40px] rounded-lg text-xs text-blue-gray-500 hover:bg-blue-gray-500/10 active:bg-blue-gray-500/30"
                                      as="button" aria-current="page"
                                >
                                <span class="absolute top-1/2 left-1/2 transform -translate-y-1/2 -translate-x-1/2">
                                    <EditIcon />
                                </span>
                                </Link>
                                <button @click="openDeleteProjectModal(project.project.id)"
                                        class="relative align-middle select-none font-sans font-medium text-center uppercase transition-all disabled:opacity-50 disabled:shadow-none disabled:pointer-events-none w-10 max-w-[40px] h-10 max-h-[40px] rounded-lg text-xs text-blue-gray-500 hover:bg-blue-gray-500/10 active:bg-blue-gray-500/30"
                                        type="button"
                                >
                                <span class="absolute top-1/2 left-1/2 transform -translate-y-1/2 -translate-x-1/2">
                                    <DeleteIcon />
                                </span>
                                </button>
                            </template>
                        </table-body>
                    </tr>
                </template>
            </table-skeleton>
            <div class="mt-10" v-if="projects.length === 0">
                Nincs megjeleníthető projekt.
            </div>
        </template>
    </ShowLayout>
    <DeleteModal :modalId="modalProjectId" :show="showModal" :route="'projects'" @close="closeModal"/>
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
import SearchBar from "./LayoutComponents/SearchBar.vue";
import SearchDropdown from "./LayoutComponents/SearchDropdown.vue";
import Label from "./LayoutComponents/Label.vue";

const { EditIcon, DeleteIcon,PlusIcon,GradientButton } = Icons
const {TableSkeleton,TableHead,TableBody } = Table
const {projects,userPermissions,searchedText,errors,users,contacts,user,contact} = defineProps(['projects','userPermissions','searchedText','errors','users','contacts','user','contact']);


const modalProjectId = ref('');
const showModal = ref(false);

const openDeleteProjectModal = (projectctId) => {
    modalProjectId.value = projectctId;
    showModal.value = true;
}

const closeModal = () => {
    modalProjectId.value = '';
    showModal.value = false;
}

const statusName = (status) => {
    return status ? 'Folyamatban' : 'Kész';
};
</script>
