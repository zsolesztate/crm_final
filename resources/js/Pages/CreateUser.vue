<template>
    <Navbar :userCanModify="userPermissions"/>
    <FormSection @submit.prevent="submit">
        <template #title>
            Munkatárs létrehozása
        </template>
        <template #form>
            <div>
                <Label for="name">Név *</Label>
                <InputField v-model="form.name" :error="form.errors.name" type="text" name="username"
                            customClass="block w-full rounded-md border-0 px-3.5 py-2 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6"
                />
            </div>
            <div>
                <Label for="email">Email cím *</Label>
                <InputField v-model="form.email" :error="form.errors.email" type="email" name="email"
                            customClass="block w-full rounded-md border-0 px-3.5 py-2 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6"
                />
            </div>
            <div>
                <Label for="phone">Telefonszám *</Label>
                <InputField v-model="form.phone" :error="form.errors.phone" type="text" name="phone"
                            customClass="block w-full rounded-md border-0 px-3.5 py-2 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6"
                />
            </div>
            <div>
                <Label for="position">Beosztás *</Label>
                <InputField v-model="form.position" :error="form.errors.position" type="text" name="phone"
                            customClass="block w-full rounded-md border-0 px-3.5 py-2 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6"
                />
            </div>
            <div class="sm:col-span-2">
                <label for="role" class="block text-sm font-semibold leading-6 text-gray-900">Csoport kiválasztása *</label>
                <SimpleDropdown :options="roles" :error="form.errors.role" @selected="handleSelectedRole"/>
            </div>
            <div class="sm:col-span-2">
                <Label for="password">Jelszó *</Label>
                <InputField v-model="form.password" :error="form.errors.password" type="password" name="password"
                            customClass="block w-full rounded-md border-0 px-3.5 py-2 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6"
                />
            </div>
            <div class="flex gap-x-4 sm:col-span-2 z-30">
                <SimpleCheckbox v-model="status"/>
                <label class="text-sm leading-6 text-gray-600" id="switch-1-label">
                    Aktív
                </label>
                <SimpleCheckbox v-model="modify"/>
                <label class="text-sm leading-6 text-gray-600" id="switch-1-label">
                    Módosíthatja-e az adatit
                </label>
            </div>
        </template>
        <template #actions>
            <PrimaryButton type="submit" :disabled="form.processing">Mentés</PrimaryButton>
            <BackButton href="/users" >Mégse</BackButton>
        </template>
    </FormSection>
    <vue3-snackbar bottom right :duration="4000"></vue3-snackbar>
</template>
<script setup>
import { useForm } from '@inertiajs/vue3';
import {useSnackbar, Vue3Snackbar} from "vue3-snackbar";
import {defineProps, ref} from 'vue'
import Navbar from "./LayoutComponents/Navbar.vue";
import { FormComponents } from "./CommonComponents.js";

const {roles,userPermissions} = defineProps(['roles','userPermissions']);
const {FormSection,Label,InputField,PrimaryButton,BackButton,SimpleDropdown,SimpleCheckbox} = FormComponents

const SelectedRole = ref(null);

const handleSelectedRole = (role) => {
    SelectedRole.value = role;
};

const snackbar = useSnackbar();
const status = ref(false);
const modify = ref(false);

const form = useForm({
    name: '',
    email:'',
    password:'',
    phone:'',
    role:'',
    position:'',
    active_status:false,
    can_modify:false
});
const submit = () => {
    form.active_status = status.value;
    form.can_modify = modify.value;
    form.role = SelectedRole.value
    console.log(form)
    form.post('/users',{
        onSuccess: () => {
            snackbar.add({
                type: 'success',
                text: 'Munkatárs létrehozva!'
            })
            form.reset();
        },
    });
};
</script>
