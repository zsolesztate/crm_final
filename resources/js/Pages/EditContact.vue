<template>
    <Navbar :userCanModify="userPermissions"/>
    <FormSection @submit.prevent="submit">
        <template #title>
            Kapcsolattartó szerkesztése
        </template>
        <template #form>
            <div>
                <Label for="name">Név *</Label>
                <InputField v-model="form.name" :error="form.errors.name" type="text" name="username" customClass="block w-full rounded-md border-0 px-3.5 py-2 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6" />
            </div>
            <div>
                <Label for="email">Email cím *</Label>
                <InputField v-model="form.email" :error="form.errors.email" type="email" name="email" customClass="block w-full rounded-md border-0 px-3.5 py-2 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6" />
            </div>
            <div>
                <Label for="phone">Telefonszám *</Label>
                <InputField v-model="form.phone" :error="form.errors.phone" type="text" name="phone" customClass="block w-full rounded-md border-0 px-3.5 py-2 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6" />
            </div>
            <div>
                <Label for="position">Beosztás *</Label>
                <InputField v-model="form.position" :error="form.errors.position" type="text" name="phone" customClass="block w-full rounded-md border-0 px-3.5 py-2 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6" />
            </div>
            <div class="sm:col-span-2">
                <label for="role" class="block text-sm font-semibold leading-6 text-gray-900">Partner kiválasztása *</label>
                <SimpleDropdown :options="partners" :error="form.errors.partner_id" @selected="handleSelectedPartner" :currentOption="SelectedPartner"/>
            </div>
            <div class="flex gap-x-4 sm:col-span-2 z-30">
                <SimpleCheckbox v-model="form.primary_contact"/>
                <label class="text-sm leading-6 text-gray-600" id="switch-1-label">
                    Elsődleges kapcsolattartó
                </label>
                <div v-if="form.errors.primary_contact" class="block mt-1.5 ml-1 text-sm font-semibold leading-6 text-rose-500">
                    {{ form.errors.primary_contact }}
                </div>
            </div>
        </template>
        <template #actions>
            <PrimaryButton type="submit" :disabled="form.processing">Mentés</PrimaryButton>
            <BackButton href="/contacts" >Mégse</BackButton>
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

const {FormSection,Label,InputField,PrimaryButton,BackButton,SimpleDropdown,SimpleCheckbox} = FormComponents
const {userPermissions,partners,contact} = defineProps(['userPermissions','partners','contact']);

const SelectedPartner = ref(contact.partner);

const handleSelectedPartner = (partner) => {
    SelectedPartner.value = partner;
};

const snackbar = useSnackbar();

const form = useForm({
    _method:"PUT",
    name: contact.name,
    email:contact.email,
    phone:contact.phone,
    position:contact.position,
    primary_contact:contact.primary_contact,
    partner_id:'',
});

const submit = () => {
    form.partner_id = SelectedPartner.value.id;

    console.log(form)
    form.post(`/contacts/${contact.id}`,{
        onSuccess: () => {
            snackbar.add({
                type: 'success',
                text: 'Kapcsolat módosítva'
            })
            form.reset();
        },
    });
};

</script>
