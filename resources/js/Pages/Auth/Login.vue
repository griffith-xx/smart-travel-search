<script setup>
import { Head, Link, useForm } from "@inertiajs/vue3";
import AppLayout from "@/Layouts/AppLayout.vue";
import { Button, InputText, Checkbox, Card, Divider, Message } from "primevue";

defineProps({
    canResetPassword: Boolean,
    status: String,
});

const form = useForm({
    email: "",
    password: "",
    remember: false,
});

const submit = () => {
    form.transform((data) => ({
        ...data,
        remember: form.remember ? "on" : "",
    })).post(route("login"), {
        onFinish: () => form.reset("password"),
    });
};

const handleGoogleLogin = () => {
    // TODO: Implement Google OAuth login
    console.log("Google login clicked");
};
</script>

<template>
    <Head title="เข้าสู่ระบบ" />

    <AppLayout title="เข้าสู่ระบบ">
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
                        เข้าสู่ระบบเพื่อค้นหาสถานที่ท่องเที่ยวเพื่อสุขภาพ
                    </p>
                </div>

                <!-- Card -->
                <Card class="border border-surface-300 dark:border-surface-700">
                    <template #content>
                        <!-- Status Message -->
                        <Message
                            v-if="status"
                            severity="success"
                            :closable="false"
                            class="mb-4"
                        >
                            {{ status }}
                        </Message>

                        <!-- Google Login Button -->
                        <Button
                            label="เข้าสู่ระบบด้วย Google"
                            severity="secondary"
                            outlined
                            size="large"
                            class="w-full mb-4"
                            @click="handleGoogleLogin"
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
                            เข้าสู่ระบบด้วย Google
                        </Button>

                        <!-- Divider -->
                        <Divider align="center">
                            <span class="text-sm opacity-70">หรือ</span>
                        </Divider>

                        <!-- Login Form -->
                        <form @submit.prevent="submit" class="space-y-4">
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
                                    autofocus
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
                                <InputText
                                    id="password"
                                    v-model="form.password"
                                    type="password"
                                    placeholder="••••••••"
                                    class="w-full"
                                    :class="{ 'p-invalid': form.errors.password }"
                                    required
                                    autocomplete="current-password"
                                />
                                <small
                                    v-if="form.errors.password"
                                    class="text-red-500 text-xs mt-1"
                                >
                                    {{ form.errors.password }}
                                </small>
                            </div>

                            <!-- Remember Me -->
                            <div class="flex items-center">
                                <Checkbox
                                    v-model="form.remember"
                                    inputId="remember"
                                    :binary="true"
                                />
                                <label
                                    for="remember"
                                    class="ml-2 text-sm cursor-pointer"
                                >
                                    จดจำการเข้าสู่ระบบ
                                </label>
                            </div>

                            <!-- Submit Button -->
                            <div class="space-y-3">
                                <Button
                                    type="submit"
                                    label="เข้าสู่ระบบ"
                                    size="large"
                                    class="w-full"
                                    :loading="form.processing"
                                    :disabled="form.processing"
                                >
                                    <i class="pi pi-sign-in"></i>
                                    เข้าสู่ระบบ
                                </Button>

                                <!-- Forgot Password -->
                                <div class="text-center">
                                    <Link
                                        v-if="canResetPassword"
                                        :href="route('password.request')"
                                        class="text-sm text-[var(--p-primary-color)] hover:underline"
                                    >
                                        ลืมรหัสผ่าน?
                                    </Link>
                                </div>
                            </div>
                        </form>
                    </template>
                </Card>

                <!-- Register Link -->
                <div class="mt-6 text-center">
                    <p class="text-sm opacity-70">
                        ยังไม่มีบัญชี?
                        <Link
                            :href="route('register')"
                            class="text-[var(--p-primary-color)] font-semibold hover:underline"
                        >
                            สมัครสมาชิก
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
