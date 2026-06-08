<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import DeleteUserForm from './Partials/DeleteUserForm.vue';
import UpdatePasswordForm from './Partials/UpdatePasswordForm.vue';
import UpdateProfileInformationForm from './Partials/UpdateProfileInformationForm.vue';
import { Head } from '@inertiajs/vue3';
import { ref } from 'vue';

defineProps({
    mustVerifyEmail: {
        type: Boolean,
    },
    status: {
        type: String,
    },
});

// Pestaña activa por defecto para el control del Modo Venta
const activeTab = ref('info');
</script>

<template>
    <Head title="Configuración de Perfil" />

    <AuthenticatedLayout>
        <template #header>
            <div class="flex items-center space-x-3">
                <div class="header-icon-wrapper">
                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                    </svg>
                </div>
                <h2 class="text-xl font-bold leading-tight tracking-tight page-title">
                    Gestión de <span class="text-accent">Cuenta / Perfil</span>
                </h2>
            </div>
        </template>

        <div class="profile-root py-8 min-h-[calc(100vh-64px)]">
            <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                
                <div class="profile-container overflow-hidden lg:grid lg:grid-cols-12 min-h-[600px]">
                    
                    <aside class="py-8 px-4 border-b border-white/10 lg:border-b-0 lg:border-r lg:col-span-3 sidebar-glass">
                        <nav class="space-y-2">
                            <button 
                                @click="activeTab = 'info'"
                                :class="['tab-btn', activeTab === 'info' ? 'active' : '']"
                            >
                                <span class="truncate">Información del Cliente</span>
                            </button>

                            <button 
                                @click="activeTab = 'security'"
                                :class="['tab-btn', activeTab === 'security' ? 'active' : '']"
                            >
                                <span class="truncate">Cambiar Contraseña</span>
                            </button>

                            <button 
                                @click="activeTab = 'danger'"
                                :class="['tab-btn danger', activeTab === 'danger' ? 'active-danger' : '']"
                            >
                                <span class="truncate">Desactivar Cuenta</span>
                            </button>
                        </nav>
                    </aside>

                    <main class="p-6 sm:p-10 lg:col-span-9 relative">
                        <transition name="slide-fade" mode="out-in">
                            
                            <div v-if="activeTab === 'info'" key="info" class="space-y-6">
                                <div class="section-header pb-4 border-b border-white/10">
                                    <h3 class="section-title">Información del Cliente</h3>
                                    <p class="section-desc">Actualiza los datos personales básicos y de contacto en el sistema.</p>
                                </div>
                                <div class="form-card max-w-2xl">
                                    <UpdateProfileInformationForm
                                        :must-verify-email="mustVerifyEmail"
                                        :status="status"
                                    />
                                </div>
                            </div>

                            <div v-else-if="activeTab === 'security'" key="security" class="space-y-6">
                                <div class="section-header pb-4 border-b border-white/10">
                                    <h3 class="section-title">Seguridad de Acceso</h3>
                                    <p class="section-desc">Asegúrate de usar una clave segura para proteger tus operaciones mercantiles.</p>
                                </div>
                                <div class="form-card max-w-2xl">
                                    <UpdatePasswordForm />
                                </div>
                            </div>

                            <div v-else key="danger" class="space-y-6">
                                <div class="section-header pb-4 border-b border-red-900/30">
                                    <h3 class="section-title text-red-500">Zona Crítica</h3>
                                    <p class="section-desc">Solicitar la baja total de la plataforma transaccional de transportes.</p>
                                </div>
                                <div class="danger-card max-w-2xl">
                                    <DeleteUserForm />
                                </div>
                            </div>

                        </transition>
                    </main>
                </div>

            </div>
        </div>
    </AuthenticatedLayout>
</template>

<style scoped>
@import url('https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,700;0,900;1,700&family=Nunito:wght@400;500;600;700&display=swap');

/* ══ CONTENEDOR PRINCIPAL ══ */
.profile-root {
    background: #0d1117;
    font-family: 'Nunito', sans-serif;
    color: #e2e8f0;
}

/* ══ CABECERA INERTIA ══ */
.header-icon-wrapper {
    background: linear-gradient(135deg, #c0392b, #96281b);
    padding: 8px;
    border-radius: 8px;
    box-shadow: 0 4px 10px rgba(192, 57, 43, 0.3);
}

.page-title {
    font-family: 'Playfair Display', serif;
    color: #fff;
    font-size: 1.5rem;
}

.text-accent {
    color: #e05c4b;
}

/* ══ ESTRUCTURA DE PANELES (GLASSMORPHISM) ══ */
.profile-container {
    background: rgba(255, 255, 255, 0.02);
    border: 1px solid rgba(255, 255, 255, 0.08);
    border-radius: 20px;
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.5);
    backdrop-filter: blur(10px);
}

.sidebar-glass {
    background: rgba(0, 0, 0, 0.2);
}

/* ══ BOTONES DE PESTAÑAS ══ */
.tab-btn {
    width: 100%;
    display: flex;
    align-items: center;
    padding: 12px 20px;
    font-size: 0.95rem;
    font-weight: 600;
    border-radius: 12px;
    color: rgba(255, 255, 255, 0.5);
    background: transparent;
    border: 1px solid transparent;
    transition: all 0.3s ease;
    text-align: left;
}

.tab-btn:hover {
    background: rgba(255, 255, 255, 0.05);
    color: #fff;
}

/* Estado Activo Normal */
.tab-btn.active {
    background: linear-gradient(135deg, #c0392b, #96281b);
    color: #fff;
    border-color: transparent;
    box-shadow: 0 4px 14px rgba(192, 57, 43, 0.35);
    transform: translateX(4px);
}

/* Estado Activo Peligro */
.tab-btn.danger:hover {
    background: rgba(220, 38, 38, 0.1);
    color: #ef4444;
}

.tab-btn.active-danger {
    background: rgba(220, 38, 38, 0.15);
    color: #ef4444;
    border: 1px solid rgba(220, 38, 38, 0.4);
    transform: translateX(4px);
}

/* ══ ÁREA DE CONTENIDO ══ */
.section-title {
    font-family: 'Playfair Display', serif;
    font-size: 1.4rem;
    font-weight: 700;
    color: #fff;
    margin-bottom: 4px;
}

.section-desc {
    font-size: 0.85rem;
    color: rgba(255, 255, 255, 0.5);
}

/* Tarjetas internas para formularios */
.form-card {
    background: rgba(255, 255, 255, 0.03);
    border: 1px solid rgba(255, 255, 255, 0.06);
    border-radius: 16px;
    padding: 24px;
    transition: border-color 0.3s ease;
}

.form-card:hover {
    border-color: rgba(192, 57, 43, 0.3);
}

.danger-card {
    background: rgba(220, 38, 38, 0.05);
    border: 1px solid rgba(220, 38, 38, 0.2);
    border-radius: 16px;
    padding: 24px;
}

/* ══ ANIMACIONES ══ */
.slide-fade-enter-active {
    animation: slideFadeIn 0.4s ease;
}
.slide-fade-leave-active {
    animation: slideFadeIn 0.2s ease reverse;
}

@keyframes slideFadeIn {
    from {
        opacity: 0;
        transform: translateY(10px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

/* Fuerza el modo oscuro en inputs si los componentes hijos de Laravel Jetstream/Breeze no lo tienen nativo */
:deep(input), :deep(select), :deep(textarea) {
    color-scheme: dark;
}
</style>