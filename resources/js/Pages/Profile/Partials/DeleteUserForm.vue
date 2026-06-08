<script setup>
import DangerButton from '@/Components/DangerButton.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import Modal from '@/Components/Modal.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import { useForm } from '@inertiajs/vue3';
import { nextTick, ref } from 'vue';

const confirmingUserDeletion = ref(false);
const passwordInput = ref(null);

const form = useForm({
    password: '',
});

const confirmUserDeletion = () => {
    confirmingUserDeletion.value = true;

    nextTick(() => passwordInput.value.focus());
};

const deleteUser = () => {
    form.delete(route('profile.destroy'), {
        preserveScroll: true,
        onSuccess: () => closeModal(),
        onError: () => passwordInput.value.focus(),
        onFinish: () => form.reset(),
    });
};

const closeModal = () => {
    confirmingUserDeletion.value = false;

    form.clearErrors();
    form.reset();
};
</script>

<template>
    <section class="form-wrapper space-y-6">
        <header>
            <h2 class="text-lg font-bold text-white font-playfair">
                Eliminar Cuenta
            </h2>

            <p class="mt-1 text-sm text-slate-400 font-nunito">
                Una vez que se elimine tu cuenta, todos sus recursos y datos se eliminarán permanentemente. Antes de eliminar tu cuenta, por favor descarga cualquier dato o información que desees conservar.
            </p>
        </header>

        <DangerButton class="btn-danger" @click="confirmUserDeletion">
            Eliminar Cuenta
        </DangerButton>

        <Modal :show="confirmingUserDeletion" @close="closeModal">
            <div class="p-6 bg-[#0f111a] border border-white/5 shadow-2xl">
                <h2 class="text-lg font-bold text-white font-playfair">
                    ¿Estás seguro de que deseas eliminar tu cuenta?
                </h2>

                <p class="mt-1 text-sm text-slate-400 font-nunito">
                    Una vez que se elimine tu cuenta, todos sus recursos y datos se eliminarán permanentemente. Por favor, ingresa tu contraseña para confirmar que deseas eliminar tu cuenta de forma definitiva.
                </p>

                <div class="mt-6">
                    <InputLabel
                        for="password"
                        value="Contraseña"
                        class="sr-only"
                    />

                    <TextInput
                        id="password"
                        ref="passwordInput"
                        v-model="form.password"
                        type="password"
                        class="custom-input mt-1 block w-full sm:w-3/4"
                        placeholder="Contraseña"
                        @keyup.enter="deleteUser"
                    />

                    <InputError :message="form.errors.password" class="mt-2 text-red-400" />
                </div>

                <div class="mt-6 flex justify-end gap-3">
                    <SecondaryButton class="btn-secondary" @click="closeModal">
                        Cancelar
                    </SecondaryButton>

                    <DangerButton
                        class="btn-danger"
                        :class="{ 'opacity-50 cursor-not-allowed': form.processing }"
                        :disabled="form.processing"
                        @click="deleteUser"
                    >
                        Eliminar Cuenta
                    </DangerButton>
                </div>
            </div>
        </Modal>
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

/* ══ ESTILOS PARA INPUTS ══ */
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

/* ══ ESTILOS PARA BOTÓN DE PELIGRO (DANGER) ══ */
:deep(.btn-danger) {
    background: linear-gradient(135deg, #e74c3c, #c0392b) !important;
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

:deep(.btn-danger:hover:not(:disabled)) {
    filter: brightness(1.1) !important;
    transform: translateY(-1px) !important;
    box-shadow: 0 6px 20px rgba(192, 57, 43, 0.5) !important;
}

:deep(.btn-danger:disabled) {
    opacity: 0.6 !important;
    cursor: not-allowed !important;
    transform: none !important;
    box-shadow: none !important;
}

/* ══ ESTILOS PARA BOTÓN SECUNDARIO (CANCELAR) ══ */
:deep(.btn-secondary) {
    background: transparent !important;
    border: 1px solid rgba(255, 255, 255, 0.2) !important;
    color: #cbd5e1 !important; /* Slate 300 */
    font-family: 'Nunito', sans-serif !important;
    font-weight: 600 !important;
    font-size: 0.85rem !important;
    padding: 10px 24px !important;
    border-radius: 50px !important;
    text-transform: uppercase !important;
    letter-spacing: 0.5px;
    box-shadow: none !important;
    transition: all 0.2s ease !important;
}

:deep(.btn-secondary:hover:not(:disabled)) {
    background: rgba(255, 255, 255, 0.05) !important;
    color: #fff !important;
    border-color: rgba(255, 255, 255, 0.4) !important;
}
</style>