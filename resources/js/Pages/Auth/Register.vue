<script setup>
import GuestLayout from '@/Layouts/GuestLayout.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';
import { ref } from 'vue'; // Importamos ref para el ojo

const showPassword = ref(false); // Estado para mostrar/ocultar

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
        <Head title="Register" />

        <div class="mb-6 text-center">
            <h2 class="text-2xl font-bold text-gray-200">Crea tu cuenta</h2>
            <p class="text-sm text-gray-500">Regístrate para comenzar a usar el sistema</p>
        </div>

        <form @submit.prevent="submit" class="space-y-4">
            <div>
                <InputLabel for="name" value="Nombre Completo" class="text-gray-100"/>
                <TextInput
                    id="name"
                    type="text"
                    class="mt-1 block w-full border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500"
                    v-model="form.name"
                    required
                    autofocus
                    placeholder="Juan Perez"
                />
                <InputError class="mt-2" :message="form.errors.name" />
            </div>

            <div>
                <InputLabel for="email" value="Correo Electrónico" class="text-gray-100"/>
                <TextInput
                    id="email"
                    type="email"
                    class="mt-1 block w-full border-gray-300 rounded-lg shadow-sm"
                    v-model="form.email"
                    required
                    placeholder="correo@ejemplo.com"
                />
                <InputError class="mt-2" :message="form.errors.email" />
            </div>

            <div>
                <InputLabel for="password" value="Contraseña" class="text-gray-100"/>
                <div class="relative mt-1">
                    <TextInput
                        id="password"
                        :type="showPassword ? 'text' : 'password'"
                        class="block w-full border-gray-300 rounded-lg shadow-sm pr-10"
                        v-model="form.password"
                        required
                        placeholder="••••••••"
                    />
                    <button 
                        type="button" 
                        @click="showPassword = !showPassword"
                        class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-400 hover:text-indigo-600 transition"
                    >
                        <span v-if="!showPassword" class="material-symbols-outlined text-xl">🙂</span>
                        <span v-else class="material-symbols-outlined text-xl">🫣</span>
                    </button>
                </div>
                <InputError class="mt-2" :message="form.errors.password" />
            </div>

            <div>
                <InputLabel for="password_confirmation" value="Confirmar Contraseña" class="text-gray-100"/>
                <TextInput
                    id="password_confirmation"
                    :type="showPassword ? 'text' : 'password'"
                    class="mt-1 block w-full border-gray-300 rounded-lg shadow-sm"
                    v-model="form.password_confirmation"
                    required
                    placeholder="••••••••"
                />
                <InputError class="mt-2" :message="form.errors.password_confirmation" />
            </div>

            <div class="flex flex-col space-y-4 pt-2">
                <PrimaryButton
                    class="w-full justify-center py-3 bg-indigo-600 hover:bg-indigo-700 rounded-lg text-sm font-semibold tracking-widest transition duration-200"
                    :class="{ 'opacity-25': form.processing }"
                    :disabled="form.processing"
                >
                    Registrarse
                </PrimaryButton>

                <div class="text-center">
                    <Link
                        :href="route('login')"
                        class="text-sm text-gray-600 hover:text-indigo-600 underline underline-offset-4"
                    >
                        ¿Ya estás registrado? Inicia sesión
                    </Link>
                </div>
            </div>
        </form>
    </GuestLayout>
</template>