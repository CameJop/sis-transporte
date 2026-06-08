<script setup>
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import { Link, useForm, usePage } from '@inertiajs/vue3';

const props = defineProps({
    mustVerifyEmail: {
        type: Boolean,
    },
    status: {
        type: String,
    },
    customRoute: {
        type: String,
        default: null
    }
});

const user = usePage().props.auth.user;

// Mapeamos los dos campos para evitar problemas de compatibilidad entre Admin y Cliente
const form = useForm({
    name: user.name || user.nombre || '',
    nombre: user.nombre || user.name || '',
    email: user.email || user.username || '',
});

// Sincronizar los campos en tiempo real mientras el usuario escribe
const sincronizarNombre = (valor) => {
    form.name = valor;
    form.nombre = valor;
};

// 🌟 Función encargada de hacer el guardado silencioso (AJAX) en la Modal
const updateProfileInformation = () => {
    const endpoint = props.customRoute || route('profile.update');

    form.patch(endpoint, {
        preserveScroll: true, // 🌟 EVITA QUE LA PÁGINA O MODAL SE RECARGUE/DESPLACE
        onSuccess: () => {
            console.log('Cambios aplicados con éxito en segundo plano.');
        },
        onError: (errors) => {
            console.error('Error al guardar cambios:', errors);
        }
    });
};
</script>

<template>
    <section class="form-wrapper">
        <header>
            <h2 class="text-lg font-bold text-white font-playfair">
                Información de Perfil
            </h2>

            <p class="mt-1 text-sm text-slate-400 font-nunito">
                Actualiza la información de tu cuenta y dirección de correo electrónico.
            </p>
        </header>

        <form
            @submit.prevent="updateProfileInformation"
            class="mt-6 space-y-6"
        >
            <div>
                <InputLabel for="name" value="Nombre Completo" class="text-slate-300 font-nunito font-semibold mb-1 block" />

                <TextInput
                    id="name"
                    type="text"
                    class="custom-input mt-1 block w-full"
                    v-model="form.name"
                    @input="sincronizarNombre($event.target.value)"
                    required
                    autofocus
                    autocomplete="name"
                />

                <InputError class="mt-2 text-red-400" :message="form.errors.name || form.errors.nombre" />
            </div>

            <div>
                <InputLabel for="email" value="Correo Electrónico" class="text-slate-300 font-nunito font-semibold mb-1 block" />

                <TextInput
                    id="email"
                    type="email"
                    class="custom-input mt-1 block w-full"
                    v-model="form.email"
                    required
                    autocomplete="username"
                />

                <InputError class="mt-2 text-red-400" :message="form.errors.email" />
            </div>

            <div v-if="mustVerifyEmail && user.email_verified_at === null" class="bg-amber-500/10 border border-amber-500/20 p-4 rounded-lg">
                <p class="text-sm text-amber-400 font-nunito">
                    Tu dirección de correo electrónico no está verificada.
                    <Link
                        :href="route('verification.send')"
                        method="post"
                        as="button"
                        class="underline font-bold hover:text-amber-300 transition-colors focus:outline-none ml-1"
                    >
                        Haz clic aquí para reenviar el correo de verificación.
                    </Link>
                </p>

                <div
                    v-show="status === 'verification-link-sent'"
                    class="mt-3 text-sm font-medium text-emerald-400 flex items-center gap-2"
                >
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                    Se ha enviado un nuevo enlace de verificación a tu correo.
                </div>
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
    border-radius: 50px !important; /* Estilo de píldora igual al botón 'Mi Cuenta' */
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