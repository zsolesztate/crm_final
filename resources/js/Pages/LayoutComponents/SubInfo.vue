<template>
    <div class="flex items-center">
        <div class="flex-1 mt-4 min-w-0 ms-4">
            <p class="text-lg font-medium text-gray-900 truncate">
                <slot name="main_info"/>
            </p>
            <p class="text-sm mt-2 text-gray-500 truncate">
                <slot name="sub_info"/>
            </p>
        </div>
    </div>
</template>
