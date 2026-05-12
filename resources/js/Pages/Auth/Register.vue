<script setup>

import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';
import { ref } from 'vue';

const showPassword = ref(false);

const form = useForm({
    name: '',
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
    <GuestLayout>
        <Head title="Registrarse" />

        <div class="auth-page">
            <div class="bg-overlay"></div>

            <div class="auth-card">
                <!-- Logo -->
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
                            <button
                                type="button"
                                @click="showPassword = !showPassword"
                                class="eye-btn"
                            >
                                <span v-if="!showPassword">😣</span>
                                <span v-else>🙂</span>
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
            </div>
        </div>
    </GuestLayout>
</template>

<style scoped>
@import url('https://fonts.googleapis.com/css2?family=Nunito:wght@400;500;600;700&display=swap');

.auth-page {
    position: fixed;
    inset: 0;
    display: flex;
    align-items: center;
    justify-content: center;
    background-image: url('https://images.unsplash.com/photo-1593642632559-0c6d3fc62b89?w=1600&q=80');
    background-size: cover;
    background-position: center;
    font-family: 'Nunito', sans-serif;
}

.bg-overlay {
    position: absolute;
    inset: 0;
    background: linear-gradient(
        135deg,
        rgba(10, 15, 40, 0.82) 0%,
        rgba(20, 30, 70, 0.65) 50%,
        rgba(80, 40, 10, 0.45) 100%
    );
    z-index: 0;
}

.auth-card {
    position: relative;
    z-index: 1;
    background: rgba(5, 8, 20, 0.10);
    backdrop-filter: blur(6px);
    -webkit-backdrop-filter: blur(6px);
    border: 1px solid rgba(255, 255, 255, 0.15);
    border-radius: 20px;
    padding: 40px 52px;
    width: 100%;
    max-width: 440px;
    text-align: center;
    box-shadow: 0 24px 60px rgba(0, 0, 0, 0.2);
    animation: cardIn 0.55s ease both;
    max-height: 95vh;
    overflow-y: auto;
}

.auth-card::-webkit-scrollbar {
    width: 4px;
}
.auth-card::-webkit-scrollbar-track {
    background: transparent;
}
.auth-card::-webkit-scrollbar-thumb {
    background: rgba(255,255,255,0.2);
    border-radius: 2px;
}

@keyframes cardIn {
    from { opacity: 0; transform: translateY(22px); }
    to   { opacity: 1; transform: translateY(0); }
}

.card-brand {
    display: flex;
    justify-content: center;
    margin-bottom: 12px;
}

.card-logo-img {
    height: 75px;
    width: auto;
    object-fit: contain;
    filter: drop-shadow(2px 2px 6px rgba(0,0,0,0.55));
}

.card-header {
    margin-bottom: 24px;
}

.card-title {
    font-size: 1.4rem;
    font-weight: 700;
    color: #fff;
    text-shadow: 0 1px 4px rgba(0,0,0,0.6);
    margin-bottom: 4px;
}

.card-subtitle {
    font-size: 0.85rem;
    color: rgba(255,255,255,0.75);
    text-shadow: 0 1px 3px rgba(0,0,0,0.5);
}

.auth-form {
    display: flex;
    flex-direction: column;
    gap: 14px;
    text-align: left;
}

.field-group {
    display: flex;
    flex-direction: column;
    gap: 4px;
}

.field-label {
    font-size: 0.82rem !important;
    font-weight: 600 !important;
    color: rgba(255,255,255,0.9) !important;
    text-shadow: 0 1px 3px rgba(0,0,0,0.5);
}

.field-input {
    width: 100%;
    padding: 10px 14px;
    background: rgba(255,255,255,0.08) !important;
    border: 1px solid rgba(255,255,255,0.2) !important;
    border-radius: 10px !important;
    color: #fff !important;
    font-size: 0.9rem;
    font-family: 'Nunito', sans-serif;
    transition: border-color 0.2s, background 0.2s;
    outline: none;
}

.field-input::placeholder {
    color: rgba(255,255,255,0.35);
}

.field-input:focus {
    background: rgba(255,255,255,0.12) !important;
    border-color: rgba(192, 57, 43, 0.7) !important;
}

.input-wrapper {
    position: relative;
}

.input-wrapper .field-input {
    padding-right: 42px;
}

.eye-btn {
    position: absolute;
    right: 10px;
    top: 50%;
    transform: translateY(-50%);
    background: none;
    border: none;
    cursor: pointer;
    font-size: 1rem;
    line-height: 1;
    padding: 2px;
}

.btn-primary {
    width: 100%;
    padding: 12px;
    background: linear-gradient(135deg, #c0392b, #96281b);
    color: #fff;
    border: none;
    border-radius: 50px;
    font-family: 'Nunito', sans-serif;
    font-weight: 700;
    font-size: 0.95rem;
    cursor: pointer;
    transition: all 0.25s ease;
    margin-top: 4px;
}

.btn-primary:hover:not(:disabled) {
    filter: brightness(1.12);
    transform: translateY(-1px);
    box-shadow: 0 6px 20px rgba(192, 57, 43, 0.5);
}

.btn-disabled {
    opacity: 0.4;
    cursor: not-allowed;
}

.switch-link {
    text-align: center;
    font-size: 0.82rem;
    color: rgba(255,255,255,0.55);
    text-shadow: 0 1px 3px rgba(0,0,0,0.5);
}

.link-accent {
    color: #fff;
    font-weight: 700;
    text-decoration: underline;
    transition: color 0.2s;
}

.link-accent:hover {
    color: #e8a89c;
}
</style>