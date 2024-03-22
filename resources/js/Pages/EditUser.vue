<template>
    <Navbar :userCanModify="userPermissions"/>
    <FormSection @submit.prevent="submitBasicInfo">
        <template #title>
            Munkatárs módosítása
        </template>
        <template #form>
            <div>
                <Label for="name">Név *</Label>
                <InputField v-model="basicInfoForm.name" :error="basicInfoForm.errors.name" type="text" name="username" customClass="block w-full rounded-md border-0 px-3.5 py-2 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6" />
            </div>
            <div>
                <Label for="email">Email cím *</Label>
                <InputField v-model="basicInfoForm.email" :error="basicInfoForm.errors.email" type="text" name="email" customClass="block w-full rounded-md border-0 px-3.5 py-2 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6" />
            </div>
            <div>
                <Label for="phone">Telefonszám *</Label>
                <InputField v-model="basicInfoForm.phone" :error="basicInfoForm.errors.phone" type="text" name="phone" customClass="block w-full rounded-md border-0 px-3.5 py-2 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6" />
            </div>
            <div>
                <Label for="position">Beosztás *</Label>
                <InputField v-model="basicInfoForm.position" :error="basicInfoForm.errors.position" type="text" name="phone" customClass="block w-full rounded-md border-0 px-3.5 py-2 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6" />
            </div>
            <div class="sm:col-span-2">
                <label for="role" class="block text-sm font-semibold leading-6 text-gray-900">Csoport kiválasztása *</label>
                <SimpleDropdown :options="roles" :error="basicInfoForm.errors.role" @selected="handleSelectedRole" :currentOption="SelectedRole"/>
            </div>
            <div class="flex gap-x-4 sm:col-span-2 z-30">
                <SimpleCheckbox v-model="basicInfoForm.active_status"/>
                <label class="text-sm leading-6 text-gray-600" id="switch-1-label">
                    Aktív
                </label>
                <SimpleCheckbox v-model="basicInfoForm.can_modify" true-value="1" false-value="0"/>
                <label class="text-sm leading-6 text-gray-600" id="switch-1-label">
                    Módosíthatja-e az adatit
                </label>
            </div>
        </template>
        <template #actions>
            <PrimaryButton type="submit" :disabled="basicInfoForm.processing">Adatok módosítása</PrimaryButton>
        </template>
    </FormSection>
    <FormSection @submit.prevent="submitPassword">
        <template #form>
            <div class="sm:col-span-2">
                <Label for="position">Új Jelszó</Label>
                <InputField v-model="passwordForm.password" :error="passwordForm.errors.password" type="password" name="password" customClass="block w-full rounded-md border-0 px-3.5 py-2 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6" />
            </div>
            <div class="sm:col-span-2">
                <label for="role" class="block text-sm font-semibold leading-6 text-gray-900">Jelsző megerősítése</label>
                <InputField v-model="passwordForm.confirmPassword" :error="passwordForm.errors.confirmPassword" type="password" name="confirmPassword" customClass="block w-full rounded-md border-0 px-3.5 py-2 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6" />
            </div>
        </template>
        <template #actions>
            <PrimaryButton type="submit" :disabled="passwordForm.processing">Jelszó módosítása</PrimaryButton>
            <BackButton href="/users" >Mégse</BackButton>
        </template>
    </FormSection>
    <vue3-snackbar bottom right :duration="4000"></vue3-snackbar>
</template>
<script setup>
import {useForm} from '@inertiajs/vue3';
import {useSnackbar, Vue3Snackbar} from "vue3-snackbar";
import {defineProps, ref} from 'vue'
import Navbar from "./LayoutComponents/Navbar.vue";
import { FormComponents } from "./CommonComponents.js";


const {user,userPermissions,roles } = defineProps(['user','userPermissions','roles']);
const {FormSection,Label,InputField,PrimaryButton,BackButton,SimpleDropdown,SimpleCheckbox} = FormComponents

const snackbar = useSnackbar();
const SelectedRole = ref(user.roles[0]);

const handleSelectedRole = (role) => {
    SelectedRole.value = role;
};

const basicInfoForm = useForm({
    _method:"PUT",
    name: user.name,
    email:user.email,
    phone:user.phone,
    role:[],
    position:user.position,
    active_status:user.active_status,
    can_modify:user.can_modify
});

const submitBasicInfo = () => {
    basicInfoForm.role = SelectedRole.value;
    basicInfoForm.post(`/users/${user.id}`,{
        onSuccess: () => {
            snackbar.add({
                type: 'success',
                text: 'Munkatárs módosítva'
            })
        },
    });
};

const passwordForm = useForm({
    _method: "PUT",
    password: '',
    confirmPassword: ''
});

const submitPassword = () => {
    passwordForm.post(`/users/${user.id}/password`, {
        onSuccess: () => {
            snackbar.add({
                type: 'success',
                text: 'Munkatárs jelszava módosítva'
            })
        },
    });
};
</script>
