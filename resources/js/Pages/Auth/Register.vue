<script setup>
import { Head, Link, useForm } from "@inertiajs/vue3";
import AppLayout from "@/Layouts/AppLayout.vue";
import { Button, InputText, Checkbox, Card, Divider, Password } from "primevue";

const form = useForm({
    name: "",
    email: "",
    password: "",
    password_confirmation: "",
    terms: false,
});

const submit = () => {
    form.post(route("register"), {
        onFinish: () => form.reset("password", "password_confirmation"),
    });
};

const handleGoogleRegister = () => {
    // TODO: Implement Google OAuth registration
    console.log("Google register clicked");
};
</script>

<template>
    <Head title="สมัครสมาชิก" />

    <AppLayout title="สมัครสมาชิก">
        <div class="min-h-screen flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8 bg-[var(--p-content-background)]">
            <div class="w-full max-w-md">
                <!-- Logo -->
                <div class="text-center mb-8">
                    <Link :href="route('welcome')">
                        <h1 class="text-3xl font-bold text-[var(--p-primary-color)]">
                            Smart Travel Search
                        </h1>
                    </Link>
                    <p class="mt-2 text-sm opacity-70">
                        สมัครสมาชิกเพื่อเริ่มต้นการเดินทางของคุณ
                    </p>
                </div>

                <!-- Card -->
                <Card class="border border-surface-300 dark:border-surface-700">
                    <template #content>
                        <!-- Google Register Button -->
                        <Button
                            label="สมัครด้วย Google"
                            severity="secondary"
                            outlined
                            size="large"
                            class="w-full mb-4"
                            @click="handleGoogleRegister"
                        >
                            <svg
                                class="w-5 h-5 mr-2"
                                viewBox="0 0 24 24"
                                xmlns="http://www.w3.org/2000/svg"
                            >
                                <path
                                    d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z"
                                    fill="#4285F4"
                                />
                                <path
                                    d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z"
                                    fill="#34A853"
                                />
                                <path
                                    d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l2.85-2.22.81-.62z"
                                    fill="#FBBC05"
                                />
                                <path
                                    d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z"
                                    fill="#EA4335"
                                />
                            </svg>
                            สมัครด้วย Google
                        </Button>

                        <!-- Divider -->
                        <Divider align="center">
                            <span class="text-sm opacity-70">หรือ</span>
                        </Divider>

                        <!-- Register Form -->
                        <form @submit.prevent="submit" class="space-y-4">
                            <!-- Name -->
                            <div>
                                <label
                                    for="name"
                                    class="block text-sm font-medium mb-2"
                                >
                                    ชื่อ
                                </label>
                                <InputText
                                    id="name"
                                    v-model="form.name"
                                    type="text"
                                    placeholder="ชื่อของคุณ"
                                    class="w-full"
                                    :class="{ 'p-invalid': form.errors.name }"
                                    required
                                    autofocus
                                    autocomplete="name"
                                />
                                <small
                                    v-if="form.errors.name"
                                    class="text-red-500 text-xs mt-1"
                                >
                                    {{ form.errors.name }}
                                </small>
                            </div>

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
                                    v-model="form.email"
                                    type="email"
                                    placeholder="your@email.com"
                                    class="w-full"
                                    :class="{ 'p-invalid': form.errors.email }"
                                    required
                                    autocomplete="username"
                                />
                                <small
                                    v-if="form.errors.email"
                                    class="text-red-500 text-xs mt-1"
                                >
                                    {{ form.errors.email }}
                                </small>
                            </div>

                            <!-- Password -->
                            <div>
                                <label
                                    for="password"
                                    class="block text-sm font-medium mb-2"
                                >
                                    รหัสผ่าน
                                </label>
                                <Password
                                    id="password"
                                    v-model="form.password"
                                    placeholder="••••••••"
                                    :class="{ 'p-invalid': form.errors.password }"
                                    toggleMask
                                    :feedback="false"
                                    inputClass="w-full"
                                    class="w-full"
                                    required
                                    autocomplete="new-password"
                                />
                                <small
                                    v-if="form.errors.password"
                                    class="text-red-500 text-xs mt-1"
                                >
                                    {{ form.errors.password }}
                                </small>
                            </div>

                            <!-- Password Confirmation -->
                            <div>
                                <label
                                    for="password_confirmation"
                                    class="block text-sm font-medium mb-2"
                                >
                                    ยืนยันรหัสผ่าน
                                </label>
                                <Password
                                    id="password_confirmation"
                                    v-model="form.password_confirmation"
                                    placeholder="••••••••"
                                    :class="{
                                        'p-invalid':
                                            form.errors.password_confirmation,
                                    }"
                                    toggleMask
                                    :feedback="false"
                                    inputClass="w-full"
                                    class="w-full"
                                    required
                                    autocomplete="new-password"
                                />
                                <small
                                    v-if="form.errors.password_confirmation"
                                    class="text-red-500 text-xs mt-1"
                                >
                                    {{ form.errors.password_confirmation }}
                                </small>
                            </div>

                            <!-- Terms -->
                            <div
                                v-if="
                                    $page.props.jetstream
                                        .hasTermsAndPrivacyPolicyFeature
                                "
                                class="flex items-start"
                            >
                                <Checkbox
                                    v-model="form.terms"
                                    inputId="terms"
                                    :binary="true"
                                    :class="{ 'p-invalid': form.errors.terms }"
                                />
                                <label
                                    for="terms"
                                    class="ml-2 text-sm cursor-pointer"
                                >
                                    ฉันยอมรับ
                                    <a
                                        :href="route('terms.show')"
                                        target="_blank"
                                        class="text-[var(--p-primary-color)] hover:underline"
                                    >
                                        ข้อกำหนดการให้บริการ
                                    </a>
                                    และ
                                    <a
                                        :href="route('policy.show')"
                                        target="_blank"
                                        class="text-[var(--p-primary-color)] hover:underline"
                                    >
                                        นโยบายความเป็นส่วนตัว
                                    </a>
                                </label>
                            </div>
                            <small
                                v-if="form.errors.terms"
                                class="text-red-500 text-xs mt-1 block"
                            >
                                {{ form.errors.terms }}
                            </small>

                            <!-- Submit Button -->
                            <div class="space-y-3">
                                <Button
                                    type="submit"
                                    label="สมัครสมาชิก"
                                    size="large"
                                    class="w-full"
                                    :loading="form.processing"
                                    :disabled="form.processing"
                                >
                                    <i class="pi pi-user-plus"></i>
                                    สมัครสมาชิก
                                </Button>
                            </div>
                        </form>
                    </template>
                </Card>

                <!-- Login Link -->
                <div class="mt-6 text-center">
                    <p class="text-sm opacity-70">
                        มีบัญชีอยู่แล้ว?
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
