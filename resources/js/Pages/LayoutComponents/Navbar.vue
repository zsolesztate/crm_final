<template>
    <div class="relative mt-10 isolate px-6 pt-14 lg:px-8 flex flex-col lg:flex-row">
    <div id="docs-sidebar" class="hs-overlay hs-overlay-open:translate-x-0 -translate-x-full transition-all duration-300 transform hidden fixed top-0 start-0 bottom-0 z-[60] w-50 bg-gray-100 border-e border-gray-200 pt-7 pb-10 overflow-y-auto lg:block lg:translate-x-0 lg:end-auto lg:bottom-0 [&::-webkit-scrollbar]:w-2 [&::-webkit-scrollbar-thumb]:rounded-full [&::-webkit-scrollbar-track]:bg-gray-100 [&::-webkit-scrollbar-thumb]:bg-gray-300 dark:[&::-webkit-scrollbar-track]:bg-slate-700">
        <nav class="hs-accordion-group p-6 w-full flex flex-col flex-wrap bg-gray-100" data-hs-accordion-always-open>
            <ul class="space-y-2.5">
                <li>
                    <Link v-if="userCanModify.can_view_users" href="/users" class="text-sm font-semibold hover:text-indigo-500 leading-6 text-gray-900">Munkatársak kezelése</Link>
                </li>
                <li>
                    <Link v-if="userCanModify.can_view_roles" href="/roles" class="text-sm font-semibold hover:text-indigo-500 leading-6 text-gray-900 mb-4">Jogosultságok kezelése</Link>
                </li>
                <li>
                    <Link href="/partners" class="text-sm font-semibold hover:text-indigo-500 leading-6 text-gray-900 mb-4">Partnerek kezelése</Link>
                </li>
                <li>
                    <Link v-if="userCanModify.userCanModify" href="/profile" class="text-sm font-semibold hover:text-indigo-500 leading-6 text-gray-900 mb-4">Profil szerkesztése</Link>
                </li>
                <li>
                    <Link href="/logout" method="post" class="text-sm font-semibold leading-6 hover:text-indigo-500 text-gray-900">Kijelentkezés <span aria-hidden="true">&rarr;</span></Link>
                </li>
            </ul>
        </nav>
    </div>
    </div>
</template>
<script setup>
import {Link} from "@inertiajs/vue3";
import {defineProps} from "vue";

const { userCanModify } = defineProps(['userCanModify']);
</script>
