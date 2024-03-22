<template>
    <div class="flex h-6 items-center">
        <input
            :checked="modelValue"
            @change="$emit('update:modelValue', !modelValue)"
            type="checkbox"
            class="h-4 w-4"
        >
    </div>
</template>

<script setup>
import { defineProps } from "vue";

const { modelValue } = defineProps(['modelValue']);
</script>
