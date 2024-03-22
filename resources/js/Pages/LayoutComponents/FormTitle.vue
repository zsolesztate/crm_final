<template>
    <FormSection
        title="Profil információ"
        description="Frissítse a fiók profiladatait és e-mail címét."
        @submitted="updateProfile"
    >
        <template #form>
            <InputGroup
                for="name"
                label="Név"
                :errors="form.errors.name"
                class="col-span-6 sm:col-span-4"
                required
            >
                <TextInput
                    id="name"
                    v-model="form.name"
                    type="text"
                >
                    <template #prefix>
                        <font-awesome-icon
                            :icon="['fa-light', 'fa-user']"
                            class="w-5 h-5 text-gray-400"
                        />
                    </template>
                </TextInput>
            </InputGroup>

            <InputGroup
                for="email"
                label="E-mail cím"
                :errors="form.errors.email"
                class="col-span-6 sm:col-span-4"
                required
            >
                <TextInput
                    id="email"
                    v-model="form.email"
                    type="email"
                >
                    <template #prefix>
                        <font-awesome-icon
                            :icon="['fa-light', 'fa-envelope']"
                            class="w-5 h-5 text-gray-400"
                        />
                    </template>
                </TextInput>
            </InputGroup>
        </template>

        <template #actions>
            <ActionMessage :on="form.recentlySuccessful" class="ml-auto mr-3 font-bold text-success-600">
                Elmentve. ✓
            </ActionMessage>

            <PrimaryButton
                type="submit"
                :class="{ 'opacity-25': form.processing }"
                :disabled="form.processing"
            >
                Mentés
            </PrimaryButton>
        </template>
    </FormSection>
</template>
