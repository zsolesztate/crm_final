<template>
    <header class="absolute inset-x-0 top-0 z-50">
        <nav class="flex items-center h-8 bg-gray-100 justify-between p-6 lg:px-8 border-b-2 border-indigo-100" aria-label="Global">
            <div class="flex lg:flex-1">
                <a href="#" class="-m-1.5 p-1.5">
                    <span class="sr-only">Your Company</span>
                    <img class="h-8 w-auto" src="https://tailwindui.com/img/logos/mark.svg?color=indigo&shade=600" alt="">
                </a>
            </div>
            <div class="flex lg:hidden">
                <button type="button" class="-m-2.5 inline-flex items-center justify-center rounded-md p-2.5 text-gray-700">
                    <span class="sr-only">Open main menu</span>
                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" />
                    </svg>
                </button>
            </div>
            <div class="hidden lg:flex lg:justify-start lg:just lg:gap-x-12">
                <Link href="/users" class="text-sm font-semibold hover:text-indigo-500 leading-6 text-gray-900">Felhasználók szerkesztése</Link>
                <Link href="/roles" class="text-sm font-semibold hover:text-indigo-500 leading-6 text-gray-900">Jogosultságok kezelése</Link>
                <Link href="/coworkers" class="text-sm font-semibold hover:text-indigo-500 leading-6 text-gray-900">Munkatársak kezelése</Link>
            </div>
            <div class="hidden lg:flex lg:flex-1 lg:justify-end">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 mr-1">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M17.982 18.725A7.488 7.488 0 0 0 12 15.75a7.488 7.488 0 0 0-5.982 2.975m11.963 0a9 9 0 1 0-11.963 0m11.963 0A8.966 8.966 0 0 1 12 21a8.966 8.966 0 0 1-5.982-2.275M15 9.75a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                </svg>

                <Link v-if="userCanModify" href="/profile" class="mr-4 text-sm font-semibold hover:text-indigo-500 leading-6 text-gray-900">Profil szerkesztése</Link>
                <Link href="/logout" method="post" class="text-sm font-semibold leading-6 hover:text-indigo-500 text-gray-900">Kijelentkezés <span aria-hidden="true">&rarr;</span></Link>
            </div>
        </nav>
        <!-- Mobile menu, show/hide based on menu open state. -->
        <div class="lg:hidden" role="dialog" aria-modal="true">
            <!-- Background backdrop, show/hide based on slide-over state. -->
            <div class="fixed inset-0 z-50"></div>
            <div class="fixed inset-y-0 right-0 z-50 w-full overflow-y-auto bg-white px-6 py-6 sm:max-w-sm sm:ring-1 sm:ring-gray-900/10">
                <div class="flex items-center justify-between">
                    <a href="#" class="-m-1.5 p-1.5">
                        <span class="sr-only">Your Company</span>
                        <img class="h-8 w-auto" src="https://tailwindui.com/img/logos/mark.svg?color=indigo&shade=600" alt="">
                    </a>
                    <button type="button" class="-m-2.5 rounded-md p-2.5 text-gray-700">
                        <span class="sr-only">Close menu</span>
                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
            </div>
        </div>
{{ user }}
    </header>
</template>
<script setup>
import {Link} from "@inertiajs/vue3";
import {defineProps} from "vue";

const { userCanModify } = defineProps(['userCanModify']);


</script>
