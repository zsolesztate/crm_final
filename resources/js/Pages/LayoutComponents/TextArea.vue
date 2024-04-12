<template>
    <textarea :id="id" rows="4" :class="customClass" v-model="model"
              class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50
              rounded-lg border border-gray-300 focus:ring-blue-500
              focus:border-blue-500" :placeholder="placeholder">
    </textarea>
    <div v-if="error" class="block mt-1.5 ml-1 text-sm font-semibold leading-6 text-rose-500">
        {{ error }}
    </div>
</template>
<script setup>
import { defineProps } from "vue";

const { modelValue, error,id, placeholder, customClass } = defineProps(['modelValue','id', 'error', 'placeholder','customClass']);
const model = defineModel()
</script>
