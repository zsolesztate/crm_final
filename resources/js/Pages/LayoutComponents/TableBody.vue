<template>
    <td class="p-4 border-b border-blue-gray-50">
        <slot name="link"/>
        <div class="flex items-center gap-3">
            <slot name="image"/>
            <div class="flex flex-col">
                <p class="block antialiased font-sans text-sm leading-normal text-blue-gray-900 font-normal"> <slot /></p>
            </div>
        </div>
    </td>
</template>
