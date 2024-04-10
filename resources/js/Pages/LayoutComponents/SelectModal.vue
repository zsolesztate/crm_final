<template>
    <div v-if="props.show" class="relative z-10" aria-labelledby="modal-title" role="dialog" aria-modal="true">
        <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity"></div>
        <div class="fixed inset-0 z-10 w-screen overflow-y-auto flex justify-center items-center">
            <div id="popup-modal" tabindex="-1" class="w-2/3 overflow-y-auto overflow-x-hidden relative bg-white rounded-lg shadow max-w-md">
                <button @click="closeModal" type="button" class="absolute top-3 end-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center" data-modal-hide="popup-modal">
                    <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                    </svg>
                    <span class="sr-only">Close modal</span>
                </button>
                <div class="p-4 md:p-5 text-center">
                    <h3 class="mb-5 text-lg font-normal text-gray-500 dark:text-gray-400">Elérhető kapcsolattartók</h3>
                    <div v-if="props.options.length > 0">
                        <table-skeleton>
                            <template v-slot:tbody>
                                <tr v-for="option in props.options"  >
                                    <table-body>
                                        <template v-slot:default>
                                            {{ option.name}}
                                        </template>
                                    </table-body>

                                    <table-body>
                                        <button @click="selectOption(option)" type="button" class="focus:outline-none text-white bg-green-700 hover:bg-green-800 focus:ring-4 focus:ring-green-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-green-600 dark:hover:bg-green-700 dark:focus:ring-green-800">Kiválaszt</button>
                                    </table-body>
                                </tr>
                            </template>
                        </table-skeleton>
                    </div>
                   <div v-else>
                       Nincs megjeleníthető kapcsolattartó
                   </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script setup>
import {defineProps, defineEmits} from 'vue';
import { Icons, Table } from "../CommonComponents.js";

import {useSnackbar} from "vue3-snackbar";
const props = defineProps(['options','show']);

const emits = defineEmits(['close']);
const snackbar = useSnackbar();
const {TableSkeleton,TableBody } = Table
const selectOption = (option) => {
    emits('update:selectedOption', option);
    closeModal()
}

const closeModal = () => {
    emits('close');
};
</script>
