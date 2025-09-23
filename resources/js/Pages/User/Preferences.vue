<script setup>
import { useForm } from '@inertiajs/vue3';
import { Checkbox, Button } from 'primevue';
defineProps({
    featureWellnessGoals: {
        type: Object,
        required: true
    }
})
const form = useForm({
    wellness_goals: []
})
const submit = () => {
    form.post(route('preferences.store'));
}
</script>

<template>
    <form @submit.prevent="submit" class="space-y-6">
        <div>
            <div v-for="option in featureWellnessGoals" class="flex items-center gap-2">
                <Checkbox v-model="form.wellness_goals" :inputId="option.slug" :name="option.slug" :value="option.id" />
                <label :for="option.slug"> {{ option.name }} </label>
            </div>
        </div>

        <Button label="Save Preferences" type="submit" :loading="form.processing" :disabled="form.processing" />
    </form>
</template>