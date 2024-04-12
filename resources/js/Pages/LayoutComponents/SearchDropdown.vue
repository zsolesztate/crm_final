<template>
    <div class="mt-2.5 ">
        <button type="button" @click.prevent="showDropdown" :class="customClass" data-dropdown-toggle="dropdown" class="w-full text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center inline-flex items-center">
            {{defaultOption }}
            <svg class="w-2.5 h-2.5 ms-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 4 4 4-4"/>
            </svg>
                <svg v-if="!loading" @click="deleteSearch(route)"
                     xmlns="http://www.w3.org/2000/svg"
                     class="flex items-center justify-end ml-5
                 h-5 w-5 text-white"
                     fill="none"
                     viewBox="0 0 24 24"
                     stroke="currentColor"
                >
                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        stroke-width="2"
                        d="M6 18L18 6M6 6l12 12"
                    />
                </svg>
            <svg v-if="loading"
                 xmlns="http://www.w3.org/2000/svg"
                 class="flex items-center justify-end ml-5
                 h-5 w-5 text-white animate-spin"
                 fill="none"
                 viewBox="0 0 24 24"
                 stroke="currentColor"
            >
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke-width="4"></circle>
                <path class="opacity-75" stroke-linecap="round" stroke-linejoin="round" stroke-width="4" d="M4 12a8 8 0 018-8V2.5m0 19a8 8 0 008-8h-2m-6-4a8 8 0 00-8 8v1.5m0-19a8 8 0 018 8h2"></path>
            </svg>
        </button>
        <div v-if="show" id="dropdown" class="z-10 absolute  bg-white divide-y divide-gray-100 w-auto">
            <ul v-for="option in options" class="py-2 text-sm bg-gray-50  text-gray-700" aria-labelledby="dropdownDefaultButton">
                <li>
                    <button @click.prevent="selectOption(option)" class="block px-4 py-2 hover:bg-gray-100">{{option.name}}</button>
                </li>
            </ul>
        </div>
    </div>
    <div v-if=error class="block mt-1.5 ml-1 text-sm font-semibold leading-6 text-rose-500">
        {{error}}
    </div>
</template>
<script setup>
import {ref, defineProps, computed} from "vue";
import {router} from "@inertiajs/vue3";

const props = defineProps(['options','error','customClass','route','type','selected']);
const loading = ref(false);
const show = ref(false);
const SelectedOption = ref(props.selected);

const showDropdown = () => {
    show.value = ! show.value
}

const deleteSearch = (route) => {
    router.get(route);
}

const selectOption = (option) => {
    loading.value = true
    startSearch(props.route,option.id)
    SelectedOption.value = option;
    showDropdown()
}

const startSearch = async (searchRoute,search) => {
    //loading.value = true;


   setTimeout(async() => {
        const type = props.type;
        const url = `/${searchRoute}/${type}?${type}=${search}`;
        await router.get(url);
       // loading.value = false;
    }, 1000);
};

const defaultOption = computed(() => SelectedOption.value ? SelectedOption.value.name : 'Keresés');
</script>
