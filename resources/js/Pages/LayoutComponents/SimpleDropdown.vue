<template>
    <div class="mt-2.5 ">
        <button type="button" @click.prevent="showDropdown" data-dropdown-toggle="dropdown" class="w-full text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center inline-flex items-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
            {{defaultOption }}
            <svg class="w-2.5 h-2.5 ms-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 4 4 4-4"/>
            </svg>
        </button>
        <div v-if="show" id="dropdown" class="z-10  bg-white divide-y divide-gray-100 w-full">
            <ul v-for="option in options" class="py-2 text-sm bg-gray-50  text-gray-700" aria-labelledby="dropdownDefaultButton">
                <li>
                    <button @click.prevent="selectOption(option)" class="block px-4 py-2 hover:bg-gray-100 w-full">{{option.name}}</button>
                </li>
            </ul>
        </div>
    </div>
    <div v-if=error class="block mt-1.5 ml-1 text-sm font-semibold leading-6 text-rose-500">
        {{error}}
    </div>
</template>
<script setup>
import {ref, defineProps, defineEmits, computed, watch, watchEffect, onMounted, onUpdated} from "vue";

const props = defineProps(['options','error','currentOption']);

const emits = defineEmits(['selected']);


const show = ref(false);
const SelectedOption = ref(props.currentOption);

const showDropdown = () => {
    show.value = ! show.value
}

const selectOption = (option) => {
    SelectedOption.value = option
    showDropdown()
    emits('selected',option);
}
const defaultOption = computed(() => SelectedOption.value ? SelectedOption.value.name : 'Válassz');
</script>
