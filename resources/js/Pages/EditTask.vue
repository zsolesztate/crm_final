<template>
    <Navbar :userCanModify="userPermissions"/>
    <FormSection @submit.prevent="submit">
        <template #title>
            Feladat szerkesztése
            <SubInfo>
                <template #main_info>
                    Projekt neve : {{ task.project.name}}
                </template>
            </SubInfo>
        </template>
        <template #form>
            <div class="sm:col-span-2">
                <Label for="name">Feladat neve*</Label>
                <InputField v-model="form.name" :error="form.errors.name" type="text" name="username" customClass="block w-full rounded-md border-0 px-3.5 py-2 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6" />
            </div>
            <div class="sm:col-span-2">
                <Label for="description">Leírás *</Label>
                <TextArea v-model="form.description" :error="form.errors.description" :placeholder="'Rövid leírás megadása'" :id="'description'"/>
            </div>
            <div class="sm:col-span-2">
                <Label for="coworkers">Munkatársak hozzáadása</Label>
                <DropdownWithSelectedField :options="availableUsers" :selectedItems="selectedUsers" @selected="handleSelect" :error="form.errors.users">
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
            <div class="mt-2">
                <Label for="fromDate">Kezdés*</Label>
                <DateInputField v-model="form.start_date" :error="form.errors.start_date"  />
            </div>
            <div class="mt-2">
                <Label for="todate">Tervezett befejezés*</Label>
                <DateInputField v-model="form.finnish_date" :error="form.errors.finnish_date" />
            </div>
            <div class="sm:col-span-2">
                <PrimaryButton type="button" @click="openSelectContactModal">Kapcsolattartó módosítása</PrimaryButton>
            </div>
            <div class="sm:col-span-2">
                <div v-if="selectedContact.name">
                    Kiválasztott kapcsolattartó :
                    {{ selectedContact.name }}
                </div>
                <div v-else>
                    Még nincs kiválasztott kapcsolattartó
                </div>
            </div>
            <div v-if=form.errors.contact_id class="flex flex-wrap gap-x-4 sm:col-span-2 z-30 mt-3 justify-center text-sm font-semibold leading-6 text-rose-500">
                {{form.errors.contact_id}}
            </div>
            <div v-if="errorMessage" class="flex flex-wrap gap-x-4 sm:col-span-2 z-30 mt-3 justify-center text-red-500">{{ errorMessage }}</div>
            <div>
                <Label for="contact">Állapot*</Label>
                <div class="flex items-center mb-4 mt-4">
                    <input v-model="form.status" id="default-radio-1" type="radio" :value="0" name="default-radio" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                    <label for="default-radio-1" class="ms-2 text-sm font-medium text-gray-900 dark:text-gray-300">Folyamatban</label>
                </div>
                <div class="flex items-center">
                    <input v-model="form.status" id="default-radio-2" type="radio" :value="1" name="default-radio" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                    <label for="default-radio-2" class="ms-2 text-sm font-medium text-gray-900 dark:text-gray-300">Kész</label>
                </div>
            </div>
        </template>
        <template #actions>
            <PrimaryButton type="submit" :disabled="form.processing">Mentés</PrimaryButton>
            <BackButton :href="`/tasks/${task.project_id}`" >Mégse</BackButton>
        </template>
    </FormSection>
    <vue3-snackbar bottom right :duration="4000"></vue3-snackbar>
    <SelectModal :show="showModal" @close="closeModal" v-model:selectedOption="selectedContact" :options="availableContacts"/>
</template>
<script setup>
import Navbar from "./LayoutComponents/Navbar.vue";
import {FormComponents} from "./CommonComponents.js";
import {computed, defineProps, onMounted, ref, watch} from "vue";
import {useForm} from '@inertiajs/vue3';
import {useSnackbar, Vue3Snackbar} from "vue3-snackbar";
import SelectModal from "./LayoutComponents/SelectModal.vue";
import {dateWatcher} from "./dateWatcher.js";


const {FormSection, Label, InputField, PrimaryButton, BackButton,TextArea,DropdownWithSelectedField,DateInputField,SubInfo} = FormComponents
const {task,users, userPermissions} = defineProps(['task', 'userPermissions','users']);
const snackbar = useSnackbar();

const selectedUserIds = computed(() => task.users.map(user => user.id));
const availableUsers = computed(() => {
    return users.filter(user => !selectedUserIds.value.includes(user.id));
});
const selectedUsers = ref(task.users);

const handleSelect = (selected) => {
    availableUsers.value = users.filter(user => !selected.includes(user));
    selectedUsers.value = selected.map(user => user.id);
};

const availableContacts = ref([]);
const errorMessage = ref('');
const selectedContact = ref(task.contact);

const form = useForm({
    _method:"PUT",
    name: task.name,
    description: task.description,
    users: [],
    status: task.status,
    contact_id: '',
    start_date: task.start_date,
    finnish_date: task.finnish_date,
});

watch(
    [() => form.start_date, () => form.finnish_date],
    ([fromDate, toDate], [oldFromDate, oldToDate]) => {
        dateWatcher(form, availableContacts, fetchAvailableContacts, errorMessage, () => {
            selectedContact.value = '';
        });
    }
);

const fetchAvailableContacts = async () => {
    try {
        const response = await fetch(`/fetch-available-contacts?startDate=${form.start_date}&endDate=${form.finnish_date}${task.id ? `&task=${task.id}` : ''}`);
        availableContacts.value = await response.json();

    } catch (error) {
        console.error('Hiba történt a GET kérés során:', error);
    }
}

onMounted(() => {
    fetchAvailableContacts();
});

const submit = () => {
    form.users = selectedUserIds.value;
    form.contact_id = selectedContact.value.id;
    form.post(`/tasks/${task.id}`, {
        onSuccess: () => {
            snackbar.add({
                type: 'success',
                text: 'Feladat módosítva'
            })
            form.reset();
        },
    });
};

const show = ref(false);
const showModal = ref(false);

const openSelectContactModal = () => {
    showModal.value = true;
}

const closeModal = () => {
    showModal.value = false;
}
</script>
