<template>
    <input :name="name" v-model="model" class="w-full text-xs border-gray-300 mt-2 rounded" type="date">
    <div v-if="error" class="block mt-1.5 ml-1 text-sm font-semibold leading-6 text-rose-500">
        {{ error }}
    </div>
</template>
<script setup>
import { defineProps } from "vue";

const { name, error, modelValue} = defineProps(['name', 'error', 'modelValue']);
const model = defineModel()
</script>
