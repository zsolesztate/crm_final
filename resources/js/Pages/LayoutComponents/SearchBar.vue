<template>
    <div class="relative">
        <input  v-model="searchData.text"  @input="startSearch(route)"
            class="appearance-none border-2 pl-10 border-gray-300 hover:border-gray-400 transition-colors rounded-md w-full py-2 px-3 text-gray-800 leading-tight focus:outline-none focus:ring-indigo-600 focus:border-purple-600 focus:shadow-outline"
            id="searchBar"
            type="text"
            placeholder="Keresés..."
        />
        <div class="absolute right-0 inset-y-0 flex items-center">
            <svg v-if="!loading" @click="deleteSearch(route)"
                xmlns="http://www.w3.org/2000/svg"
                class="-ml-1 mr-3 h-5 w-5 text-gray-400 hover:text-gray-500"
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
                 class="-ml-1 mr-3 h-5 w-5 text-gray-400 animate-spin"
                 fill="none"
                 viewBox="0 0 24 24"
                 stroke="currentColor"
            >
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke-width="4"></circle>
                <path class="opacity-75" stroke-linecap="round" stroke-linejoin="round" stroke-width="4" d="M4 12a8 8 0 018-8V2.5m0 19a8 8 0 008-8h-2m-6-4a8 8 0 00-8 8v1.5m0-19a8 8 0 018 8h2"></path>
            </svg>
        </div>

        <div class="absolute left-0 inset-y-0 flex items-center">
            <svg
                xmlns="http://www.w3.org/2000/svg"
                class="h-6 w-6 ml-3 text-gray-400 hover:text-gray-500"
                fill="none"
                viewBox="0 0 24 24"
                stroke="currentColor"
            >
                <path
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    stroke-width="2"
                    d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"
                />
            </svg>
        </div>
    </div>
    <span v-if="errors && errors.search" class="text-red-500">{{ errors.search }}</span>
</template>
<script setup>
import {ref,watchEffect} from "vue";
import {router} from "@inertiajs/vue3";

const {searchedText,route,errors = {}} = defineProps(['searchedText','route','errors']);

const searchData = ref({
    text: '',
    error: '',
});

let searchTimeout = null;
const loading = ref(false);


const deleteSearch = (route) => {
    router.get(route);
}

const startSearch = async (route) => {
    loading.value = true;
    if (searchTimeout) {
        clearTimeout(searchTimeout);
    }

    const searchText = searchData.value.text.trim();
    if (!searchText) {
        deleteSearch(route)
    }

    searchTimeout = setTimeout(async() => {
        const Text = searchData.value.text.toLowerCase();
        const type = 'search';
        const url = `/${route}/${type}?search=${Text}`;
        await router.get(url);
        loading.value = false;
    }, 2000);
};

watchEffect(() => {
    if (searchedText !== undefined) {
        searchData.value.text = searchedText;
    } else {
        searchData.value.text = '';
    }
});
</script>
