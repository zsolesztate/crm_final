<template>
    <div class="bg-white">
        <Navbar :userCanModify="userPermissions" />
        <div class="px-6 lg:px-8">
            <div class="mx-auto max-w-2xl py-32 sm:py-48 lg:py-56">
                <div class="text-center">
                    <h1 class="text-4xl font-bold tracking-tight text-gray-900 sm:text-6xl">CRM Teszt</h1>
                    <p class="mt-6 text-lg leading-8 text-gray-600">CRM CRUD feladat</p>
                </div>
            </div>
        </div>
    </div>
</template>
<script setup>
import Navbar from "./LayoutComponents/Navbar.vue";
import {defineProps} from "vue";

const { userPermissions } = defineProps(['userPermissions']);

</script>
