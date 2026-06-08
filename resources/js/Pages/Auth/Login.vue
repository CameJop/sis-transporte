<script setup>
import GuestLayout from '@/Layouts/GuestLayout.vue';
import Checkbox from '@/Components/Checkbox.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import TextInput from '@/Components/TextInput.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';
import { ref } from 'vue';

defineProps({
    canResetPassword: { type: Boolean },
    status: { type: String },
});

const showPassword = ref(false);

const form = useForm({
    email: '',
    password: '',
    remember: false,
});

const submit = () => {
    form.post(route('login'), {
        onFinish: () => form.reset('password'),
    });
};
</script>

<template>
    <GuestLayout>
        <Head title="Iniciar Sesión" />

        <div class="card-brand">
            <img src="/images/logo.png" alt="Trans. Copacabana S.A." class="card-logo-img" />
        </div>

        <div class="card-header">
            <h2 class="card-title">Iniciar Sesión</h2>
            <p class="card-subtitle">Bienvenido de vuelta</p>
        </div>

        <div v-if="status" class="status-msg">
            {{ status }}
        </div>

        <form @submit.prevent="submit" class="auth-form">
            <div class="field-group">
                <InputLabel for="email" value="Correo Electrónico" class="field-label" />
                <TextInput
                    id="email"
                    type="email"
                    class="field-input"
                    v-model="form.email"
                    required
                    autofocus
                    autocomplete="username"
                    placeholder="correo@ejemplo.com"
                />
                <InputError class="mt-1" :message="form.errors.email" />
            </div>

            <div class="field-group">
                <InputLabel for="password" value="Contraseña" class="field-label" />
                <div class="input-wrapper">
                    <TextInput
                        id="password"
                        :type="showPassword ? 'text' : 'password'"
                        class="field-input"
                        v-model="form.password"
                        required
                        autocomplete="current-password"
                        placeholder="••••••••"
                    />
                    <button type="button" @click="showPassword = !showPassword" class="eye-btn">
                        <i :class="['bi', showPassword ? 'bi-eye' : 'bi-eye-slash']"></i>
                    </button>
                </div>
                <InputError class="mt-1" :message="form.errors.password" />
            </div>

            <div class="remember-row">
                <label class="remember-label">
                    <Checkbox name="remember" v-model:checked="form.remember" />
                    <span>Recordarme</span>
                </label>
                <Link v-if="canResetPassword" :href="route('password.request')" class="forgot-link">
                    ¿Olvidaste tu contraseña?
                </Link>
            </div>

            <button
                type="submit"
                class="btn-primary"
                :class="{ 'btn-disabled': form.processing }"
                :disabled="form.processing"
            >
                Iniciar Sesión
            </button>

            <p class="switch-link">
                ¿No tienes cuenta?
                <Link :href="route('register')" class="link-accent">Regístrate</Link>
            </p>
        </form>
    </GuestLayout>
</template>