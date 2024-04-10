<template>
    <Navbar :userCanModify="userPermissions"/>
    <FormSection @submit.prevent="submit">
        <template #title>
            Projekt létrehozása
        </template>
        <template #form>
            <div class="sm:col-span-2">
                <Label for="name">Projekt neve*</Label>
                <InputField v-model="form.name" :error="form.errors.name" type="text" name="username" customClass="block w-full rounded-md border-0 px-3.5 py-2 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6" />
            </div>
            <div class="sm:col-span-2">
            <Label for="description">Leírás *</Label>
            <TextArea v-model="form.description" :error="form.errors.description" :placeholder="'Rövid leírás megadása'" :id="'description'"/>
            </div>
            <div class="sm:col-span-2">
                <label for="role" class="block text-sm font-semibold leading-6 text-gray-900">Partner kiválasztása *</label>
                <SimpleDropdown :options="partners" :error="form.errors.partner_id" @selected="handleSelectedPartner"/>
            </div>
        </template>
        <template #actions>
            <PrimaryButton type="submit" :disabled="form.processing">Mentés</PrimaryButton>
            <BackButton href="/projects" >Mégse</BackButton>
        </template>
    </FormSection>
    <vue3-snackbar bottom right :duration="4000"></vue3-snackbar>
</template>
<script setup>
import { useForm } from '@inertiajs/vue3';
import {useSnackbar, Vue3Snackbar} from "vue3-snackbar";
import Navbar from "./LayoutComponents/Navbar.vue";
import {defineProps, ref} from "vue";
import { FormComponents } from "./CommonComponents.js";

const {FormSection,Label,InputField,PrimaryButton,BackButton,SimpleDropdown,SimpleCheckbox,TextArea} = FormComponents
const {userPermissions,partners} = defineProps(['userPermissions','partners']);
const snackbar = useSnackbar();

const SelectedPartner = ref(null);

const handleSelectedPartner = (partner) => {
    SelectedPartner.value = partner.id;
};

const form = useForm({
    name: '',
    description:'',
    partner_id:'',
});

const submit = () => {
    form.partner_id = SelectedPartner.value;
    form.post('/projects',{
        onSuccess: () => {
            snackbar.add({
                type: 'success',
                text: 'Projekt létrehozva'
            })
            form.reset();
        },
    });
};
</script>
