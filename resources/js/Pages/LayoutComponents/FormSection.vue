<template>
        <div class="flex-grow md:ml-52 p-4">
            <div class="mx-auto max-w-2xl text-center">
                <h2 class="text-3xl font-bold tracking-tight text-gray-900 sm:text-4xl">
                    <slot name="title" />
                </h2>
            </div>
            <form class="mx-auto mt-16 max-w-xl sm:mt-20">
                <div class="grid grid-cols-1 gap-x-8 gap-y-6 sm:grid-cols-2">
                    <slot name="form" />
                </div>
                <div class="mt-10">
                <slot name="actions" />
                </div>
            </form>
        </div>
</template>
