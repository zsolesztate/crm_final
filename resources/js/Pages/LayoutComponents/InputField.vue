<template>
    <div class="mt-2.5">
        <input :type="type" :name="name" :disabled="isDisabled" :class="customClass" v-model="model">
    </div>
    <div v-if="error" class="block mt-1.5 ml-1 text-sm font-semibold leading-6 text-rose-500">
        {{ error }}
    </div>
</template>
<script setup>
import { defineProps } from "vue";

const { modelValue, error, type, name, customClass,disabled } = defineProps(['modelValue', 'error', 'type', 'name', 'customClass','disabled']);
const model = defineModel()
const isDisabled = disabled ? true : false;

</script>
