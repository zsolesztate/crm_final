<template>
{{fromDate }}
</template>
<script setup>
import {computed, defineProps, ref, watch} from "vue";

const {fromDate} = defineProps(['fromDate']);

const valami = ref(fromDate);

watch(valami.value, ( newValue, oldValue ) => {
    console.log(newValue);
})
</script>
