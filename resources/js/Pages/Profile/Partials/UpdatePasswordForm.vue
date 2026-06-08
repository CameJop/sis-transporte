<script setup>
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import { useForm } from '@inertiajs/vue3';
import { ref } from 'vue';

const passwordInput = ref(null);
const currentPasswordInput = ref(null);

const form = useForm({
    current_password: '',
    password: '',
    password_confirmation: '',
});

const updatePassword = () => {
    form.put(route('password.update'), {
        preserveScroll: true,
        onSuccess: () => form.reset(),
        onError: () => {
            if (form.errors.password) {
                form.reset('password', 'password_confirmation');
                passwordInput.value.focus();
            }
            if (form.errors.current_password) {
                form.reset('current_password');
                currentPasswordInput.value.focus();
            }
        },
    });
};
</script>

<template>
    <section class="form-wrapper">
        <header>
            <h2 class="text-lg font-bold text-white font-playfair">
                Actualizar Contraseña
            </h2>

            <p class="mt-1 text-sm text-slate-400 font-nunito">
                Asegúrate de que tu cuenta utilice una contraseña larga y aleatoria para mantenerse segura.
            </p>
        </header>

        <form @submit.prevent="updatePassword" class="mt-6 space-y-6">
            <div>
                <InputLabel for="current_password" value="Contraseña Actual" class="text-slate-300 font-nunito font-semibold mb-1 block" />

                <TextInput
                    id="current_password"
                    ref="currentPasswordInput"
                    v-model="form.current_password"
                    type="password"
                    class="custom-input mt-1 block w-full"
                    autocomplete="current-password"
                />

                <InputError
                    :message="form.errors.current_password"
                    class="mt-2 text-red-400"
                />
            </div>

            <div>
                <InputLabel for="password" value="Nueva Contraseña" class="text-slate-300 font-nunito font-semibold mb-1 block" />

                <TextInput
                    id="password"
                    ref="passwordInput"
                    v-model="form.password"
                    type="password"
                    class="custom-input mt-1 block w-full"
                    autocomplete="new-password"
                />

                <InputError :message="form.errors.password" class="mt-2 text-red-400" />
            </div>

            <div>
                <InputLabel
                    for="password_confirmation"
                    value="Confirmar Contraseña"
                    class="text-slate-300 font-nunito font-semibold mb-1 block"
                />

                <TextInput
                    id="password_confirmation"
                    v-model="form.password_confirmation"
                    type="password"
                    class="custom-input mt-1 block w-full"
                    autocomplete="new-password"
                />

                <InputError
                    :message="form.errors.password_confirmation"
                    class="mt-2 text-red-400"
                />
            </div>

            <div class="flex items-center gap-4 pt-2">
                <PrimaryButton :disabled="form.processing" class="btn-submit">
                    Guardar Cambios
                </PrimaryButton>

                <Transition
                    enter-active-class="transition ease-in-out duration-300"
                    enter-from-class="opacity-0 -translate-x-2"
                    leave-active-class="transition ease-in-out duration-300"
                    leave-to-class="opacity-0"
                >
                    <p
                        v-if="form.recentlySuccessful"
                        class="text-sm text-emerald-400 font-nunito font-semibold flex items-center gap-1.5"
                    >
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                        Guardado exitosamente.
                    </p>
                </Transition>
            </div>
        </form>
    </section>
</template>

<style scoped>
@import url('https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,700;0,900;1,700&family=Nunito:wght@400;500;600;700&display=swap');

.font-playfair {
    font-family: 'Playfair Display', serif;
}

.font-nunito {
    font-family: 'Nunito', sans-serif;
}

/* ══ ESTILOS PARA INPUTS (Forzando sobreescritura de Tailwind nativo) ══ */
:deep(.custom-input) {
    background: rgba(0, 0, 0, 0.2) !important;
    border: 1px solid rgba(255, 255, 255, 0.1) !important;
    color: #ffffff !important;
    border-radius: 8px !important;
    font-family: 'Nunito', sans-serif;
    transition: border-color 0.3s ease, box-shadow 0.3s ease;
}

:deep(.custom-input:focus) {
    border-color: #c0392b !important;
    box-shadow: 0 0 0 1px #c0392b !important;
    outline: none !important;
}

:deep(.custom-input::placeholder) {
    color: rgba(255, 255, 255, 0.3) !important;
}

/* ══ ESTILOS PARA BOTÓN PRINCIPAL ══ */
:deep(.btn-submit) {
    background: linear-gradient(135deg, #c0392b, #96281b) !important;
    border: none !important;
    color: #fff !important;
    font-family: 'Nunito', sans-serif !important;
    font-weight: 700 !important;
    font-size: 0.85rem !important;
    padding: 10px 24px !important;
    border-radius: 50px !important;
    text-transform: uppercase !important;
    letter-spacing: 0.5px;
    box-shadow: 0 4px 14px rgba(192, 57, 43, 0.35) !important;
    transition: filter 0.2s, transform 0.2s, box-shadow 0.2s !important;
}

:deep(.btn-submit:hover:not(:disabled)) {
    filter: brightness(1.1) !important;
    transform: translateY(-1px) !important;
    box-shadow: 0 6px 20px rgba(192, 57, 43, 0.5) !important;
}

:deep(.btn-submit:disabled) {
    opacity: 0.6 !important;
    cursor: not-allowed !important;
    transform: none !important;
    box-shadow: none !important;
}
</style>