<script setup>
import { Head, Link, useForm, usePage } from "@inertiajs/vue3";
import AppLayout from "@/Layouts/AppLayout.vue";
import { Button, InputText, Card, Message, Password } from "primevue";
import { computed, watch } from "vue";

const page = usePage();

// Check if email is validated from server
const emailValidated = computed(() => page.props.emailValidated || false);
const validatedEmail = computed(() => page.props.email || "");

// Step 1: Email validation form
const emailForm = useForm({
    email: validatedEmail.value,
});

const validateEmail = () => {
    emailForm.post(route("password.validate"), {
        preserveScroll: true,
    });
};

// Step 2: Password reset form
const resetForm = useForm({
    email: validatedEmail.value,
    password: "",
    password_confirmation: "",
});

// Watch for validated email and update reset form
watch(validatedEmail, (newEmail) => {
    resetForm.email = newEmail;
    emailForm.email = newEmail;
});

const resetPassword = () => {
    resetForm.post(route("password.direct.update"));
};
</script>

<template>
    <Head title="รีเซ็ตรหัสผ่าน" />

    <AppLayout title="รีเซ็ตรหัสผ่าน">
        <div
            class="min-h-screen flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8 bg-[var(--p-content-background)]"
        >
            <div class="w-full max-w-md">
                <!-- Logo -->
                <div class="text-center mb-8">
                    <Link :href="route('welcome')">
                        <h1
                            class="text-3xl font-bold text-[var(--p-primary-color)]"
                        >
                            Smart Travel Search
                        </h1>
                    </Link>
                    <p class="mt-2 text-sm opacity-70">
                        รีเซ็ตรหัสผ่านของคุณ
                    </p>
                </div>

                <!-- Card -->
                <Card class="border border-surface-300 dark:border-surface-700">
                    <template #content>
                        <!-- Step 1: Email Validation (if not validated yet) -->
                        <div v-if="!emailValidated">
                            <div class="mb-6">
                                <p class="text-sm opacity-70 leading-relaxed">
                                    กรุณากรอกอีเมลที่คุณใช้สมัครสมาชีก
                                    เราจะตรวจสอบว่าอีเมลนี้มีในระบบหรือไม่
                                </p>
                            </div>

                            <form @submit.prevent="validateEmail" class="space-y-4">
                                <!-- Email -->
                                <div>
                                    <label
                                        for="email"
                                        class="block text-sm font-medium mb-2"
                                    >
                                        อีเมล
                                    </label>
                                    <InputText
                                        id="email"
                                        v-model="emailForm.email"
                                        type="email"
                                        placeholder="your@email.com"
                                        class="w-full"
                                        :class="{
                                            'p-invalid': emailForm.errors.email,
                                        }"
                                        required
                                        autofocus
                                        autocomplete="email"
                                    />
                                    <small
                                        v-if="emailForm.errors.email"
                                        class="text-red-500 text-xs mt-1"
                                    >
                                        {{ emailForm.errors.email }}
                                    </small>
                                </div>

                                <!-- Submit Button -->
                                <div class="space-y-3">
                                    <Button
                                        type="submit"
                                        label="ตรวจสอบอีเมล"
                                        size="large"
                                        class="w-full"
                                        :loading="emailForm.processing"
                                        :disabled="emailForm.processing"
                                    >
                                        <i class="pi pi-search"></i>
                                        ตรวจสอบอีเมล
                                    </Button>
                                </div>
                            </form>
                        </div>

                        <!-- Step 2: Password Reset (if email is validated) -->
                        <div v-else>
                            <Message
                                severity="success"
                                :closable="false"
                                class="mb-4"
                            >
                                พบอีเมล {{ validatedEmail }} ในระบบ
                                กรุณากรอกรหัสผ่านใหม่
                            </Message>

                            <form @submit.prevent="resetPassword" class="space-y-4">
                                <!-- Email (readonly) -->
                                <div>
                                    <label
                                        for="reset-email"
                                        class="block text-sm font-medium mb-2"
                                    >
                                        อีเมล
                                    </label>
                                    <InputText
                                        id="reset-email"
                                        v-model="resetForm.email"
                                        type="email"
                                        class="w-full"
                                        readonly
                                        disabled
                                    />
                                </div>

                                <!-- New Password -->
                                <div>
                                    <label
                                        for="password"
                                        class="block text-sm font-medium mb-2"
                                    >
                                        รหัสผ่านใหม่
                                    </label>
                                    <Password
                                        id="password"
                                        v-model="resetForm.password"
                                        placeholder="••••••••"
                                        :class="{
                                            'p-invalid': resetForm.errors.password,
                                        }"
                                        toggleMask
                                        :feedback="true"
                                        inputClass="w-full"
                                        class="w-full"
                                        required
                                        autocomplete="new-password"
                                    />
                                    <small
                                        v-if="resetForm.errors.password"
                                        class="text-red-500 text-xs mt-1"
                                    >
                                        {{ resetForm.errors.password }}
                                    </small>
                                </div>

                                <!-- Confirm Password -->
                                <div>
                                    <label
                                        for="password_confirmation"
                                        class="block text-sm font-medium mb-2"
                                    >
                                        ยืนยันรหัสผ่านใหม่
                                    </label>
                                    <Password
                                        id="password_confirmation"
                                        v-model="resetForm.password_confirmation"
                                        placeholder="••••••••"
                                        :class="{
                                            'p-invalid':
                                                resetForm.errors
                                                    .password_confirmation,
                                        }"
                                        toggleMask
                                        :feedback="false"
                                        inputClass="w-full"
                                        class="w-full"
                                        required
                                        autocomplete="new-password"
                                    />
                                    <small
                                        v-if="
                                            resetForm.errors.password_confirmation
                                        "
                                        class="text-red-500 text-xs mt-1"
                                    >
                                        {{
                                            resetForm.errors.password_confirmation
                                        }}
                                    </small>
                                </div>

                                <!-- Submit Button -->
                                <div class="space-y-3">
                                    <Button
                                        type="submit"
                                        label="เปลี่ยนรหัสผ่าน"
                                        size="large"
                                        class="w-full"
                                        :loading="resetForm.processing"
                                        :disabled="resetForm.processing"
                                    >
                                        <i class="pi pi-check"></i>
                                        เปลี่ยนรหัสผ่าน
                                    </Button>

                                    <!-- Back to Email Step -->
                                    <Button
                                        label="เปลี่ยนอีเมล"
                                        severity="secondary"
                                        outlined
                                        size="large"
                                        class="w-full"
                                        @click="
                                            () => {
                                                $inertia.get(
                                                    route('password.request')
                                                );
                                            }
                                        "
                                    >
                                        <i class="pi pi-arrow-left"></i>
                                        เปลี่ยนอีเมล
                                    </Button>
                                </div>
                            </form>
                        </div>
                    </template>
                </Card>

                <!-- Login Link -->
                <div class="mt-6 text-center">
                    <p class="text-sm opacity-70">
                        จำรหัสผ่านได้แล้ว?
                        <Link
                            :href="route('login')"
                            class="text-[var(--p-primary-color)] font-semibold hover:underline"
                        >
                            เข้าสู่ระบบ
                        </Link>
                    </p>
                </div>

                <!-- Back to Home -->
                <div class="mt-4 text-center">
                    <Button
                        label="กลับหน้าหลัก"
                        severity="secondary"
                        text
                        asChild
                        v-slot="slotProps"
                    >
                        <Link :class="slotProps.class" :href="route('welcome')">
                            <i class="pi pi-arrow-left"></i>
                            กลับหน้าหลัก
                        </Link>
                    </Button>
                </div>
            </div>
        </div>
    </AppLayout>
</template>
