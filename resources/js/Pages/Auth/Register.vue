<script setup>
import GuestLayout from '@/Layouts/GuestLayout.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import TextInput from '@/Components/TextInput.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';
import { ref } from 'vue';

const showPassword = ref(false);

const form = useForm({
    name: '',
    documento_identidad: '',
    email: '',
    password: '',
    password_confirmation: '',
});

const submit = () => {
    form.post(route('register'), {
        onFinish: () => form.reset('password', 'password_confirmation'),
    });
};
</script>

<template>
    <Head title="Registrarse" />

    <GuestLayout :scrollable="true">
        <div class="card-brand">
            <img src="/images/logo.png" alt="Trans. Copacabana S.A." class="card-logo-img" />
        </div>

        <div class="card-header">
            <h2 class="card-title">Crea tu cuenta</h2>
            <p class="card-subtitle">Regístrate para comenzar a usar el sistema</p>
        </div>

        <form @submit.prevent="submit" class="auth-form">
            <div class="field-group">
                <InputLabel for="name" value="Nombre Completo" class="field-label" />
                <TextInput
                    id="name"
                    type="text"
                    class="field-input"
                    v-model="form.name"
                    required
                    autofocus
                    placeholder="Juan Pérez"
                />
                <InputError class="mt-1" :message="form.errors.name" />
            </div>

            <div class="field-group">
                <InputLabel for="documento_identidad" value="Cédula de Identidad (CI)" class="field-label" />
                <TextInput
                    id="documento_identidad"
                    v-model="form.documento_identidad"
                    type="text"
                    required
                    placeholder="Ej: 7890123"
                    class="field-input"
                />
                <p class="field-hint">
                    Debe coincidir con tu CI registrado como pasajero en Trans. Copacabana S.A.
                </p>
                <InputError class="mt-1" :message="form.errors.documento_identidad" />
            </div>

            <div class="field-group">
                <InputLabel for="email" value="Correo Electrónico" class="field-label" />
                <TextInput
                    id="email"
                    type="email"
                    class="field-input"
                    v-model="form.email"
                    required
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
                        placeholder="••••••••"
                    />
                    <button type="button" @click="showPassword = !showPassword" class="eye-btn">
                        <i :class="['bi', showPassword ? 'bi-eye' : 'bi-eye-slash']"></i>
                    </button>
                </div>
                <InputError class="mt-1" :message="form.errors.password" />
            </div>

            <div class="field-group">
                <InputLabel for="password_confirmation" value="Confirmar Contraseña" class="field-label" />
                <TextInput
                    id="password_confirmation"
                    :type="showPassword ? 'text' : 'password'"
                    class="field-input"
                    v-model="form.password_confirmation"
                    required
                    placeholder="••••••••"
                />
                <InputError class="mt-1" :message="form.errors.password_confirmation" />
            </div>

            <button
                type="submit"
                class="btn-primary"
                :class="{ 'btn-disabled': form.processing }"
                :disabled="form.processing"
            >
                Registrarse
            </button>

            <p class="switch-link">
                ¿Ya estás registrado?
                <Link :href="route('login')" class="link-accent">Inicia sesión</Link>
            </p>
        </form>
    </GuestLayout>
</template>