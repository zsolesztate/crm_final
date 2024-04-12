<template>
    <Navbar :userCanModify="userPermissions"/>
    <FormSection @submit.prevent="submitUserData">
        <template #title>
            Profil szerkesztése
        </template>
        <template #form>
            <div>
                <Label for="name">Név *</Label>
                <InputField v-model="userData.name" :error="userData.errors.name" type="text" name="username"
                            customClass="block w-full rounded-md border-0 px-3.5 py-2 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6"
                />
            </div>
            <div>
                <Label for="email">Email cím *</Label>
                <InputField v-model="userData.email" :error="userData.errors.email" type="email" name="email"
                            customClass="block w-full rounded-md border-0 px-3.5 py-2 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6"
                />
            </div>
            <div>
                <Label for="phone">Telefonszám *</Label>
                <InputField v-model="userData.phone" :error="userData.errors.phone" type="text" name="phone"
                            customClass="block w-full rounded-md border-0 px-3.5 py-2 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6"
                />
            </div>
            <div>
                <Label for="position">Beosztás *</Label>
                <InputField v-model="userData.position" :error="userData.errors.position" type="text" name="position"
                            customClass="block w-full rounded-md border-0 px-3.5 py-2 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6"
                />
            </div>
        </template>
        <template #actions>
            <PrimaryButton type="submit" :disabled="userData.processing">Adatok módosítása</PrimaryButton>
            <BackButton href="/" >Mégse</BackButton>
        </template>
    </FormSection>
    <FormSection @submit.prevent="submitPasswordChange">
        <template #form>
            <div class="sm:col-span-2">
                <Label for="password">Jelenlegi jelszó</Label>
                <InputField v-model="passwordData.currentPassword" :error="passwordData.errors.currentPassword" type="password" name="currentPassword"
                            customClass="block w-full rounded-md border-0 px-3.5 py-2 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6"
                />
            </div>
            <div class="sm:col-span-2">
                <Label for="password">Új jelszó</Label>
                <InputField v-model="passwordData.newPassword" :error="passwordData.errors.newPassword" type="password" name="newPassword"
                            customClass="block w-full rounded-md border-0 px-3.5 py-2 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6"
                />
            </div>
            <div class="sm:col-span-2">
                <Label for="password">Új jelszó megerősítése</Label>
                <InputField v-model="passwordData.confirmPassword" :error="passwordData.errors.confirmPassword" type="password" name="confirmPassword"
                            customClass="block w-full rounded-md border-0 px-3.5 py-2 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6"
                />
            </div>
        </template>
        <template #actions>
            <PrimaryButton type="submit" :disabled="passwordData.processing">Jelszó módosítása</PrimaryButton>
            <BackButton href="/" >Mégse</BackButton>
        </template>
    </FormSection>
    <vue3-snackbar bottom right :duration="4000"></vue3-snackbar>
</template>
<script setup>
import Navbar from "./LayoutComponents/Navbar.vue";
import {useForm} from '@inertiajs/vue3';
import {Vue3Snackbar} from "vue3-snackbar";
import { FormComponents } from "./CommonComponents.js";
import { useSnackbar } from "vue3-snackbar";
import { defineProps} from "vue";

const {FormSection,Label,InputField,PrimaryButton,BackButton,CheckboxesGrid} = FormComponents
const { userPermissions,user } = defineProps(['userPermissions','user']);
const snackbar = useSnackbar();

const userData = useForm({
    _method:"PUT",
    name: user.name,
    email: user.email,
    phone: user.phone,
    position: user.position
});

const submitUserData = () => {
    userData.post(`/profile/${user.id}`, {
        onSuccess: () => {
            snackbar.add({
                type: 'success',
                text: 'Felhasználói adatok sikeresen módosítva'
            });
        },
    });
};

const passwordData = useForm({
    _method:"PUT",
    currentPassword: '',
    newPassword: '',
    confirmPassword: ''
});

let formErrors = {};

const submitPasswordChange = () => {
    passwordData.post(`/profile/${user.id}/password`, {
        onSuccess: () => {
            snackbar.add({
                type: 'success',
                text: 'Jelszó sikeresen módosítva'
            });
            passwordData.reset();
        },
        onError: (errors) => {
            formErrors = errors;
        }
    });
};
</script>
