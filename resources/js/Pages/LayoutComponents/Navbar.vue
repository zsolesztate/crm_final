<template>
    <nav class="bg-white border-gray-200">
        <div class="max-w-screen-xl flex flex-wrap items-center justify-between mx-auto p-4">
            <button @click="toggleMobileMenu" class="inline-flex items-center p-2 w-10 h-10 justify-center text-sm text-gray-500 rounded-lg md:hidden hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-gray-200 dark:text-gray-400 dark:hover:bg-gray-700 dark:focus:ring-gray-600" aria-controls="navbar-default" aria-expanded="false">
                <span class="sr-only">Open main menu</span>
                <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 17 14">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M1 1h15M1 7h15M1 13h15"/>
                </svg>
            </button>
        </div>
        <!-- Mobil -->
        <div v-if="isMobileMenuOpen" class="md:hidden">
            <ul class="font-medium flex flex-col p-4 mt-4 border  rounded-lg md:flex-row md:space-x-8 rtl:space-x-reverse md:mt-0 md:border-0 md:bg-white bg-gray-800 border-gray-700">
                <li>
                    <Link v-if="userCanModify.can_view_users" href="/users" class="block py-2 px-3 text-white rounded md:bg-transparent md:text-blue-700 md:p-0 ">Munkatársak kezelése</Link>
                </li>
                <li>
                    <Link v-if="userCanModify.can_view_roles" href="/roles" class="block py-2 px-3 text-white rounded hover:bg-gray-100 md:hover:bg-transparent md:border-0 md:hover:text-blue-700 md:p-0">Jogosultságok kezelése</Link>
                </li>
                <li>
                    <Link v-if="userCanModify.can_view_partners" href="/partners" class="block py-2 px-3 text-white rounded hover:bg-gray-100 md:hover:bg-transparent md:border-0 md:hover:text-blue-700 md:p-0">Partnerek kezelése</Link>
                </li>
                <li>
                    <Link v-if="userCanModify.can_view_partners" href="/partners" class="block py-2 px-3 text-white rounded hover:bg-gray-100 md:hover:bg-transparent md:border-0 md:hover:text-blue-700 md:p-0">Partnerek kezelése</Link>
                </li>
                <li>
                    <Link  href="/projects" class="block py-2 px-3 text-white rounded hover:bg-gray-100 md:hover:bg-transparent md:border-0 md:hover:text-blue-700 md:p-0">Projektek kezelése</Link>
                </li>
                <li>
                    <Link href="/contacts" class="block py-2 px-3 text-white rounded hover:bg-gray-100 md:hover:bg-transparent md:border-0 md:hover:text-blue-700 md:p-0 ">Kapcsolattartók kezelése</Link>
                </li>
                <li>
                    <Link href="/logout" method="post" as="button" class="block py-2 px-3 text-white rounded hover:bg-gray-100 md:hover:bg-transparent md:border-0 md:hover:text-blue-700 md:p-0 ">Kijelentkezés</Link>
                </li>
            </ul>
        </div>
    </nav>
    <div class="relative mt-10 isolate px-6 pt-14 lg:px-8 flex flex-col lg:flex-row">

        <div id="docs-sidebar" class="hs-overlay hs-overlay-open:translate-x-0 -translate-x-full transition-all duration-300 transform hidden fixed top-0 start-0 bottom-0 z-[60] w-50 bg-gray-100 border-e border-gray-200 pt-7 pb-10 overflow-y-auto lg:block lg:translate-x-0 lg:end-auto lg:bottom-0 [&::-webkit-scrollbar]:w-2 [&::-webkit-scrollbar-thumb]:rounded-full [&::-webkit-scrollbar-track]:bg-gray-100 [&::-webkit-scrollbar-thumb]:bg-gray-300 dark:[&::-webkit-scrollbar-track]:bg-slate-700" v-show="!isMobileMenuOpen">
            <nav class="hs-accordion-group p-6 w-full flex flex-col flex-wrap bg-gray-100" data-hs-accordion-always-open>
                <ul class="space-y-2.5">
                    <li>
                        <Link v-if="userCanModify.can_view_users" href="/users" class="text-sm font-semibold hover:text-indigo-500 leading-6 text-gray-900">Munkatársak kezelése</Link>
                    </li>
                    <li>
                        <Link v-if="userCanModify.can_view_roles" href="/roles" class="text-sm font-semibold hover:text-indigo-500 leading-6 text-gray-900 mb-4">Jogosultságok kezelése</Link>
                    </li>
                    <li>
                        <Link v-if="userCanModify.can_view_partners" href="/partners" class="text-sm font-semibold hover:text-indigo-500 leading-6 text-gray-900 mb-4">Partnerek kezelése</Link>
                    </li>
                    <li>
                        <Link  href="/projects" class="text-sm font-semibold hover:text-indigo-500 leading-6 text-gray-900 mb-4">Projektek kezelése</Link>
                    </li>
                    <li>
                        <Link  href="/contacts" class="text-sm font-semibold hover:text-indigo-500 leading-6 text-gray-900 mb-4">Kapcsolattartók kezelése</Link>
                    </li>
                    <li>
                        <Link v-if="userCanModify.userCanModify" href="/profile" class="text-sm font-semibold hover:text-indigo-500 leading-6 text-gray-900 mb-4">Profil szerkesztése</Link>
                    </li>
                    <li>
                        <Link href="/logout" method="post" as="button" class="text-sm font-semibold leading-6 hover:text-indigo-500 text-gray-900">Kijelentkezés <span aria-hidden="true">&rarr;</span></Link>
                    </li>
                </ul>
            </nav>
        </div>


    </div>
</template>

<script setup>
import { Link } from "@inertiajs/vue3";
import { defineProps, ref } from "vue";

const { userCanModify } = defineProps(["userCanModify"]);
const isMobileMenuOpen = ref(false);

const toggleMobileMenu = () => {
    isMobileMenuOpen.value = !isMobileMenuOpen.value;
};
</script>
