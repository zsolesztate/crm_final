<template>
    <Navbar :userCanModify="userPermissions"/>
    <ShowLayout>
        <template v-slot:title>
           Kapcsolattartók kezelése
        </template>
        <template v-slot:content>
            <div  class="flex items-center justify-end">
                <Link href="/contacts/create"
                      class="hover:text-indigo-300 no-underline hover:underline flex items-center space-x-2 text-green-500"
                >
                    <span class="">Kapcsolattartó hozzáadása</span>
                    <PlusIcon />
                </Link>
            </div>
            <table-skeleton>
                <template v-slot:thead>
                    <table-head>Név</table-head>
                    <table-head>Telefonszám</table-head>
                    <table-head>Email cím</table-head>
                    <table-head>Munkakör</table-head>
                    <table-head>Partner</table-head>
                    <table-head>Szabadságok</table-head>
                    <table-head>Elsődleges kontakt</table-head>
                    <table-head>Szerkesztés/Törlés</table-head>
                </template>
                <template v-slot:tbody>
                    <tr v-for="contact in contacts"  >
                        <table-body>
                               {{ contact.name}}
                        </table-body>
                        <table-body>
                                {{ contact.phone}}
                        </table-body>
                        <table-body>
                                {{ contact.email}}
                        </table-body>
                        <table-body>
                                {{ contact.position}}
                        </table-body>
                        <table-body>
                                {{ contact.partner.name}}
                        </table-body>
                        <table-body>
                                <GradientButton :href="`/vacations/${contact.id}`" type="button">
                                    Szabadságok kezelése
                                </GradientButton>
                        </table-body>
                        <table-body>
                                {{ isPrimary(contact.primary_contact)}}
                        </table-body>
                        <table-body>
                            <template v-slot:link>
                              <Link :href="`/contacts/${contact.id}/edit`"
                                    class="relative align-middle select-none font-sans font-medium text-center uppercase transition-all disabled:opacity-50 disabled:shadow-none disabled:pointer-events-none w-10 max-w-[40px] h-10 max-h-[40px] rounded-lg text-xs text-blue-gray-500 hover:bg-blue-gray-500/10 active:bg-blue-gray-500/30"
                                    as="button" aria-current="page"
                              >
                                    <span class="absolute top-1/2 left-1/2 transform -translate-y-1/2 -translate-x-1/2">
                                        <EditIcon />
                                    </span>
                              </Link>
                                <button @click="openDeleteContactModal(contact.id)"
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
            <div class="mt-10" v-if="contacts.length === 0">
                Nincs megjeleníthető kapcsolattartó.
            </div>
        </template>
    </ShowLayout>
    <DeleteModal :modalId="modalContactId" :show="showModal" route="contacts" @close="closeModal"/>
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

const { EditIcon, DeleteIcon,PlusIcon,GradientButton } = Icons
const {TableSkeleton,TableHead,TableBody } = Table
const {contacts,userPermissions} = defineProps(['contacts','userPermissions']);

const isPrimary = (primary_status) => {
    return primary_status ? 'Igen' : 'Nem';
};

const modalContactId = ref('');
const showModal = ref(false);

const openDeleteContactModal = (contactId) => {
    modalContactId.value = contactId;
    showModal.value = true;
}

const closeModal = () => {
    modalContactId.value = '';
    showModal.value = false;
}
</script>
