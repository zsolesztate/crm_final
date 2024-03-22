<template>
    <div class="grid h-screen place-content-center bg-white px-4">
        <div class="text-center">
            <h1 class="text-9xl font-black text-gray-200">403</h1>
            <p class="mt-4 text-gray-500">Nincs jogosultságod az oldalhoz</p>
            <Link
                href="/"
                class="mt-6 inline-block rounded bg-indigo-600 px-5 py-3 text-sm font-medium text-white hover:bg-indigo-700 focus:outline-none focus:ring"
            >
                Vissza
            </Link>
        </div>
    </div>
</template>
<script setup>
import {Link} from '@inertiajs/vue3';
</script>
