<template>
    <Link :href="href" class="mt-3.5 block w-full rounded-md bg-gray-600 px-3.5 py-2.5 text-center text-sm font-semibold text-white shadow-sm hover:bg-gray-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">
        <slot />
    </Link>

</template>
<script setup>
import {Link} from "@inertiajs/vue3";
import {defineProps} from "vue";

const {href} = defineProps(['href']);
</script>
