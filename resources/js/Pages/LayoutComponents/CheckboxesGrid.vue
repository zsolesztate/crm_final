<template>
    <div class="sm:col-span-2">
        <div class="ml-8">
            <div class="grid grid-cols-2 gap-x-4 sm:col-span-2 z-30 mt-3">
                <div v-for="(option, index) in options" class="mb-3">
                    <label class="flex items-center">
                        <input v-model="model" :value="option.id" type="checkbox" class="mt-3.5 px-3.5 py-2.5 flex p-3 indigo-400">
                        <span class="ml-2 mt-4">{{ option.name }}</span>
                    </label>
                </div>
            </div>
        </div>
    </div>
</template>
<script setup>
import {defineProps} from "vue";

const {options,error} = defineProps(['options','error']);
const model = defineModel()
</script>
