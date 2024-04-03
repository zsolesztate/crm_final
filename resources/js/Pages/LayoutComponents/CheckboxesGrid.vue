<template>
    <div class="sm:col-span-2">
        <div class="ml-8">
            <div class="grid grid-cols-2 gap-x-4 sm:col-span-2 z-30 mt-3">
                <div v-for="(translatedOption, index) in sortedTranslatedOptions" class="mb-3">
                    <label class="flex items-center">
                        <input v-model="model" :value="translatedOption.id" type="checkbox" class="mt-3.5 px-3.5 py-2.5 flex p-3 indigo-400">
                        <span class="ml-2 mt-4">{{ translatedOption.name }}</span>
                    </label>
                </div>
            </div>
        </div>
    </div>
</template>
<script setup>
import {computed, defineProps} from "vue";
import {translateRoles} from "../Utility.js";

const {options,error} = defineProps(['options','error']);
const model = defineModel()

const sortedTranslatedOptions = computed(() => {
    const translatedOptions = options.map(option => {
        return {
            id: option.id,
            name: translateRoles(option.name)
        };
    });

    return translatedOptions.sort((a, b) => a.name.localeCompare(b.name));
});
</script>
