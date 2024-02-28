<template>
    <table class="mt-4 w-full min-w-max table-auto text-left">
        <thead>
            <tr>
                 <slot name="thead"/>
            </tr>
        </thead>
        <tbody>
                <slot name="tbody"/>
        </tbody>
    </table>
</template>
