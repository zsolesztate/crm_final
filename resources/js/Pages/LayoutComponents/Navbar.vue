<template>
    <header class="absolute inset-x-0 top-0 z-50">
        <nav class="flex items-center h-8 bg-gray-100 justify-between p-6 lg:px-8 border-b-2 border-indigo-100" aria-label="Global">
            <div class="hidden lg:flex lg:justify-start lg:just lg:gap-x-12">
                <Link v-if="userCanModify.can_view_users" href="/users" class="text-sm font-semibold hover:text-indigo-500 leading-6 text-gray-900">Munkatársak kezelése</Link>
                <Link v-if="userCanModify.can_view_roles" href="/roles" class="text-sm font-semibold hover:text-indigo-500 leading-6 text-gray-900">Jogosultságok kezelése</Link>
                <Link href="/partners" class="text-sm font-semibold hover:text-indigo-500 leading-6 text-gray-900">Partnerek kezelése</Link>
            </div>
            <div class="hidden lg:flex lg:flex-1 lg:justify-end">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 mr-1">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M17.982 18.725A7.488 7.488 0 0 0 12 15.75a7.488 7.488 0 0 0-5.982 2.975m11.963 0a9 9 0 1 0-11.963 0m11.963 0A8.966 8.966 0 0 1 12 21a8.966 8.966 0 0 1-5.982-2.275M15 9.75a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                </svg>
                <Link v-if="userCanModify.userCanModify" href="/profile" class="mr-4 text-sm font-semibold hover:text-indigo-500 leading-6 text-gray-900">Profil szerkesztése</Link>
                <Link href="/logout" method="post" class="text-sm font-semibold leading-6 hover:text-indigo-500 text-gray-900">Kijelentkezés <span aria-hidden="true">&rarr;</span></Link>
            </div>
        </nav>
    </header>
</template>
<script setup>
import {Link} from "@inertiajs/vue3";
import {defineProps} from "vue";

const { userCanModify } = defineProps(['userCanModify']);
</script>
