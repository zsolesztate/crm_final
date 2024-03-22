<template>
        <Navbar :userCanModify="userPermissions"/>
    <FormSection @submit.prevent="submit">
        <template #title>
            Partner Módosítása
        </template>
        <template #form>
            <div>
                <Label for="name">Megjelenítési Név *</Label>
                <InputField v-model="form.name" :error="form.errors.name" type="text" name="name" customClass="block w-full rounded-md border-0 px-3.5 py-2 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6" />
            </div>
            <div>
                <Label for="name">Cégnév *</Label>
                <InputField v-model="form.company_name" :error="form.errors.company_name" type="text" name="company" customClass="block w-full rounded-md border-0 px-3.5 py-2 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6" />
            </div>
            <div class="sm:col-span-2">
                <Label for="password">Email cím *</Label>
                <InputField v-model="form.email" :error="form.errors.email" type="email" name="email" customClass="block w-full rounded-md border-0 px-3.5 py-2 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6" />
            </div>
            <div class="sm:col-span-2">
                <Label for="coworkers">Munkatársak hozzáadása</Label>
                <DropdownWithSelectedField :options="nonSelectedUsers" :selectedItems="selectedUsersRef">
                    <template #dropdownTitle>
                        Munkatárs kiválasztása
                    </template>
                    <template #selected>
                        Kiválasztott munkatársak:
                    </template>
                    <template #empty>
                        Még nincs kiválasztott munkatárs.
                    </template>
                </DropdownWithSelectedField>
            </div>
        </template>
        <template #actions>
            <PrimaryButton type="submit" :disabled="form.processing">Mentés</PrimaryButton>
            <BackButton href="/partners" >Mégse</BackButton>
        </template>
    </FormSection>
    <vue3-snackbar bottom right :duration="4000"></vue3-snackbar>
</template>
<script setup>
import { useForm } from '@inertiajs/vue3';
import {useSnackbar, Vue3Snackbar} from "vue3-snackbar";
import { defineProps, ref, computed,watchEffect} from 'vue';
import { FormComponents } from "./CommonComponents.js";
import Navbar from "./LayoutComponents/Navbar.vue";

const {partner,users,userPermissions} = defineProps(['partner','users','userPermissions']);
const {FormSection,Label,InputField,PrimaryButton,BackButton,DropdownWithSelectedField} = FormComponents
const snackbar = useSnackbar();

const selectedUserIds = computed(() => partner.users.map(user => user.id));
const nonSelectedUsersRef = ref('');
const selectedUsersRef = ref(partner.users);

const nonSelectedUsers = computed(() => {
    return users.filter(user => !selectedUserIds.value.includes(user.id));
});

watchEffect(() => {
    nonSelectedUsersRef.value = nonSelectedUsers.value;
});

const form = useForm({
    _method:"PUT",
    name: partner.name,
    company_name:partner.company_name,
    email:partner.email,
    users:[],
});

const submit = () => {
    form.users = selectedUsersRef.value;
    console.log(form)
    form.post(`/partners/${partner.id}`,{
        onSuccess: () => {
            snackbar.add({
                type: 'success',
                text: 'Partner módosítva.'
            })
            form.reset();
        },
    });
};
</script>
