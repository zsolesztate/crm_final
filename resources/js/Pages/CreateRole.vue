<template>
    <Navbar :userCanModify="userPermissions" />
    <FormSection @submit.prevent="submit">
        <template #title>
            Csoport létrehozása
        </template>
        <template #form>
                <div class="sm:col-span-2">
                    <Label for="name">Csoport neve *</Label>
                    <InputField v-model="form.name" :error="form.errors.name" type="text" name="name" customClass="block w-full rounded-md border-0 px-3.5 py-2 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6" />
                </div>
                     <CheckboxesGrid v-model="selectedCheckboxes" :options="permissions"/>
        </template>
        <template #actions>
                    <PrimaryButton type="submit" :disabled="form.processing">Mentés</PrimaryButton>
                    <BackButton href="/roles" >Mégse</BackButton>
        </template>
    </FormSection>
</template>
<script setup>
import Navbar from "./LayoutComponents/Navbar.vue";
import {defineProps,ref} from "vue";
import {useForm} from "@inertiajs/vue3";
import {useSnackbar} from "vue3-snackbar";
import { FormComponents } from "./CommonComponents.js";

const {FormSection,Label,InputField,PrimaryButton,BackButton,CheckboxesGrid} = FormComponents
const { permissions ,userPermissions } = defineProps(["permissions","userPermissions"]);
const snackbar = useSnackbar();
const selectedCheckboxes = ref([]);

const form = useForm({
    name: '',
    permissions:[],
})

const submit = () => {
    form.permissions = selectedCheckboxes.value
    form.post('/roles',{
        onSuccess: () => {
            snackbar.add({
                type: 'success',
                text: 'Csoport hozzáadva'
            })
            form.reset();
            closeField();
        },
    });
};
</script>
