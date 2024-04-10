<template>
    <Navbar :userCanModify="userPermissions"/>
    <FormSection @submit.prevent="submit">
        <template #title>
            Szabadságok kezelése
            <SubInfo>
                <template #main_info>
                    Igénylő neve : {{ contact.name}}
                </template>
                <template #sub_info>
                    Igénylő email címe : {{ contact.email}}
                </template>
            </SubInfo>
        </template>
        <template #form>
            <div class="sm:col-span-2">
                <Label for="email">Szabadság indoka*</Label>
                <InputField v-model="form.name" :error="form.errors.name" type="text" name="email" customClass="block w-full rounded-md border-0 px-3.5 py-2 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6"/>
            </div>
            <div>
                <Label for="fromDate">Szabadság kezdete*</Label>
                <DateInputField v-model="form.fromDate" :error="form.errors.fromDate"  />
            </div>
            <div>
                <Label for="todate">Szabadság vége*</Label>
                <DateInputField v-model="form.toDate" :error="form.errors.toDate" />
            </div>
        </template>
        <template #actions>
            <PrimaryButton type="submit" :disabled="form.processing">Mentés</PrimaryButton>
            <BackButton :href="`/vacations/${contact.id}`" >Mégse</BackButton>
        </template>
    </FormSection>
    <vue3-snackbar bottom right :duration="4000"></vue3-snackbar>
</template>
<script setup>
import Navbar from "./LayoutComponents/Navbar.vue";
import { FormComponents } from "./CommonComponents.js";
import {defineProps} from "vue";
import DateInputField from "./LayoutComponents/DateInputField.vue";
import { useForm } from '@inertiajs/vue3';
import {useSnackbar, Vue3Snackbar} from "vue3-snackbar";

const {FormSection,Label,InputField,PrimaryButton,BackButton,SubInfo} = FormComponents
const {contact,userPermissions} = defineProps(['contact','userPermissions']);
const snackbar = useSnackbar();

const form = useForm({
    name: '',
    fromDate:'',
    toDate:'',
});

const submit = () => {
        form.post(`/vacations/${contact.id}`,{
            onSuccess: () => {
                snackbar.add({
                    type: 'success',
                    text: 'Szabadság hozzáadva'
                })
                form.reset();
            },
        });
};
</script>
