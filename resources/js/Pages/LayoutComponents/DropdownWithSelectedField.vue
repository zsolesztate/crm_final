<template>
    <div class="relative inline-block text-left w-full">
        <button @click.prevent="showDropdown" id="dropdown-button" class="mt-3.5 inline-flex justify-center w-full px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-gray-100 focus:ring-blue-500">
            <slot name="dropdownTitle"/>
            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 ml-2 -mr-1" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                <path fill-rule="evenodd" d="M6.293 9.293a1 1 0 011.414 0L10 11.586l2.293-2.293a1 1 0 111.414 1.414l-3 3a1 1 0 01-1.414 0l-3-3a1 1 0 010-1.414z" clip-rule="evenodd" />
            </svg>
        </button>
        <div v-show="show" @click.stop id="dropdown-menu" class=" origin-top-right absolute right-0 mt-2 w-full rounded-md shadow-lg bg-white ring-1 ring-black ring-opacity-5">
            <div v-if="options.length > 0 "  class="py-2 p-2" role="menu" aria-orientation="vertical" aria-labelledby="dropdown-button">
                <div v-for="(option,index) in options" :key="index">
                    <div @click="selectItem(index,option)"  class="block px-4 py-2 mb-1 text-sm text-gray-700 rounded-md bg-white hover:bg-gray-100" role="menuitem">{{option.name}}</div>
                </div>
            </div>
        </div>
        <Label for="selected" class="mt-3">
            <slot name="selected"/>
        </Label>
        <div class="flex flex-wrap gap-x-4 sm:col-span-2 z-30 mt-3 justify-center">
            <div v-if="selectedDropdownItems.length > 0" v-for="(selectedDropdownItem,index) in selectedDropdownItems" :key="index" class="flex-shrink-0">
                <button @click.prevent="removeItem(index,selectedDropdownItem)" class="text-sm text-white text-center px-3.5 py-2.5 flex h-6 items-center rounded-md bg-indigo-400 p-3">
                    {{ selectedDropdownItem.name }}
                    <span class="ml-3 text-indigo-950">X</span>
                </button>
            </div>
            <div v-else class="flex-shrink-0">
                <slot name="empty"/>
            </div>
        </div>
    </div>
    <div v-if=error class="block mt-1.5 ml-1 text-sm font-semibold leading-6 text-rose-500">
        {{error}}
    </div>
</template>
<script setup>
import {computed, defineEmits, defineProps, ref} from "vue";
import Label from "./Label.vue";

const show = ref(false);
const {options,error,selectedItems} = defineProps(['options','error','selectedItems']);
const emits = defineEmits(['selected']);


const allDropdownItems = ref(options);
const selectedDropdownItems = computed(() => selectedItems ? selectedItems : []);

const showDropdown = () => {
    show.value = !show.value
}

const selectItem = (index,item) => {
    allDropdownItems.value.splice(index, 1);
    selectedDropdownItems.value.push(item);
    emitselectedDropdownItems();

}

const removeItem = (index,item) => {
    selectedDropdownItems.value.splice(index, 1);
    allDropdownItems.value.push(item);
    show.value = false;
    emitselectedDropdownItems();

}

const emitselectedDropdownItems = () => {
    emits('selected', selectedDropdownItems.value);
}
</script>
