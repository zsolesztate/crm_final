<template>
    <Navbar :userCanModify="userPermissions" />
    <FormSection @submit.prevent="submit">
        <template #title>
            Csoport módosítása
        </template>
        <template #form>
            <div class="sm:col-span-2">
                <Label for="name">Csoport neve *</Label>
                <InputField v-model="form.name" :error="form.errors.name" type="text" name="name"
                            customClass="block w-full rounded-md border-0 px-3.5 py-2 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6"
                />
            </div>
            <CheckboxesGrid v-model="selectedCheckboxes"  :options="permissions"/>
        </template>
        <template #actions>
            <PrimaryButton type="submit" :disabled="form.processing">Mentés</PrimaryButton>
            <BackButton href="/roles" >Mégse</BackButton>
        </template>
    </FormSection>
</template>
<vue3-snackbar bottom right :duration="4000"></vue3-snackbar>
<script setup>
import {Vue3Snackbar} from "vue3-snackbar";
import { useSnackbar } from "vue3-snackbar";
import {useForm} from '@inertiajs/vue3';
import Navbar from "./LayoutComponents/Navbar.vue";
import { FormComponents } from "./CommonComponents.js";
import {defineProps,ref,watchEffect} from "vue";

const snackbar = useSnackbar();
const {FormSection,Label,InputField,PrimaryButton,BackButton,CheckboxesGrid} = FormComponents
const { userPermissions,role,permissions } = defineProps(['userPermissions','role','permissions']);
const selectedCheckboxes = ref([]);

const form = useForm({
    _method:"PUT",
    name: role.name,
    permissions:[]
});

const submit = () => {
    form.permissions = selectedCheckboxes.value;
    form.post(`/roles/${role.id}`,{
        onSuccess: () => {
            snackbar.add({
                type: 'success',
                text: 'Csoport sikeresen módosítva'
            })
            form.reset();
        },
    });
};

watchEffect(() => {
    if (role.permissions) {
        selectedCheckboxes.value = role.permissions.map(permission => permission.id);
    }
});
</script>
