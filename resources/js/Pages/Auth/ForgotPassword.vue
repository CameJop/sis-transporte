<script setup>
import GuestLayout from '@/Layouts/GuestLayout.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import TextInput from '@/Components/TextInput.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';

defineProps({
    status: { type: String },
});

const form = useForm({
    email: '',
});

const submit = () => {
    form.post(route('password.email'));
};
</script>

<template>
    <GuestLayout>
        <Head title="Recuperar Contraseña" />

        <div class="card-brand">
            <img src="/images/logo.png" alt="Trans. Copacabana S.A." class="card-logo-img" />
        </div>

        <div class="card-header">
            <h2 class="card-title">¿Olvidaste tu contraseña?</h2>
            <p class="card-subtitle">
                Sin problema. Ingresa tu correo y te enviaremos un enlace para restablecer tu contraseña.
            </p>
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

            <button
                type="submit"
                class="btn-primary"
                :class="{ 'btn-disabled': form.processing }"
                :disabled="form.processing"
            >
                Enviar enlace de recuperación
            </button>

            <p class="switch-link">
                <Link :href="route('login')" class="link-accent">
                    ← Volver al inicio de sesión
                </Link>
            </p>
        </form>
    </GuestLayout>
</template>