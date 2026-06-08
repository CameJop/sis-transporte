<script setup>
import { ref, computed } from 'vue';
import { Link } from '@inertiajs/vue3';
import Button from 'primevue/button';
import InputText from 'primevue/inputtext';

const isCollapsed = ref(false);
const isUserMenuOpen = ref(false);

// Corregido: Ahora es un computed para que route().current() reaccione a la navegación de Inertia
const menuGroups = computed(() => [
    {
        label: 'Panel de Control',
        items: [
            { label: 'Panel Principal', icon: 'pi pi-home', route: 'dashboard', active: route().current('dashboard') }
        ]
    },
    {
        label: 'Gestión de Transporte',
        items: [
            { label: 'Viajes', icon: 'pi pi-map', route: 'viajes.index', active: route().current('viajes.*') },
            { label: 'Boletos', icon: 'pi pi-ticket', route: 'boletos.index', active: route().current('boletos.*') },
            { label: 'Encomiendas', icon: 'pi pi-box', route: 'encomiendas.index', active: route().current('encomiendas.*') },
            { label: 'Rutas', icon: 'pi pi-directions', route: 'rutas.index', active: route().current('rutas.*') },
            { label: 'Buses', icon: 'pi pi-truck', route: 'buses.index', active: route().current('buses.*') },
        ]
    },
    {
        label: 'Personas y Seguridad',
        items: [
            { label: 'Usuarios', icon: 'pi pi-user-edit', route: 'users.index', active: route().current('users.*') },
            { label: 'Clientes', icon: 'pi pi-users', route: 'clientes.index', active: route().current('clientes.*') },
            { label: 'Empleados', icon: 'pi pi-id-card', route: 'empleados.index', active: route().current('empleados.*') },
            { label: 'Roles', icon: 'pi pi-shield', route: 'roles.index', active: route().current('roles.*') },
            { label: 'Asignaciones', icon: 'pi pi-user-plus', route: 'asignaciones.index', active: route().current('asignaciones.*') },
        ]
    },
    {
        label: 'Finanzas y Control',
        items: [
            { label: 'Facturas', icon: 'pi pi-file-pdf', route: 'facturas.index', active: route().current('facturas.*') },
            { label: 'Detalles Factura', icon: 'pi pi-list', route: 'detalles-factura.index', active: route().current('detalles-factura.*') },
            { label: 'Métodos de Pago', icon: 'pi pi-credit-card', route: 'metodos-pago.index', active: route().current('metodos-pago.*') },
        ]
    },
    {
        label: 'Mantenimiento y Otros',
        items: [
            { label: 'Mantenimientos', icon: 'pi pi-cog', route: 'mantenimientos.index', active: route().current('mantenimientos.*') },
            { label: 'Tipos Mant.', icon: 'pi pi-wrench', route: 'tipos-mantenimiento.index', active: route().current('tipos-mantenimiento.*') },
            { label: 'Terminales', icon: 'pi pi-building', route: 'terminales.index', active: route().current('terminales.*') },
            { label: 'Notificaciones', icon: 'pi pi-bell', route: 'notificaciones.index', active: route().current('notificaciones.*') },
        ]
    },
    {
        label: 'Sistema',
        items: [
            { label: 'Respaldos', icon: 'pi pi-database', route: 'respaldos.index', active: route().current('respaldos.*') },
        ]
    }
]);
</script>

<template>
    <div class="flex h-screen bg-[#0d1117] text-slate-200 overflow-hidden font-nunito selection:bg-[#c0392b]/30">

        <aside :class="[
            'bg-[#0a0c14] border-r border-white/5 transition-all duration-300 flex flex-col z-20 relative shadow-[4px_0_24px_rgba(0,0,0,0.3)]',
            isCollapsed ? 'w-20' : 'w-64'
        ]">
            <div class="h-20 flex items-center justify-center px-4 border-b border-white/5">
                <Link :href="route('dashboard')"
                    class="flex items-center justify-center transition-transform duration-200 hover:scale-[1.02]">
                    <img src="/images/logo.png" alt="Trans. Copacabana S.A." :class="[
                        'object-contain transition-all duration-300 drop-shadow-[0_2px_8px_rgba(0,0,0,0.6)]',
                        isCollapsed ? 'h-9 px-1' : 'h-11 px-2'
                    ]" />
                </Link>
            </div>

            <nav class="flex-1 overflow-y-auto px-3 py-4 custom-scrollbar overflow-x-hidden space-y-5">
                <div v-for="group in menuGroups" :key="group.label" class="mb-2">
                    <p v-if="!isCollapsed"
                        class="text-[10px] uppercase tracking-[3px] text-[#c0392b] font-bold mb-3 px-3 select-none opacity-90 font-nunito">
                        {{ group.label }}
                    </p>
                    <div v-else class="h-px bg-white/5 my-4 mx-2"></div>

                    <div class="space-y-1">
                        <Link v-for="item in group.items" :key="item.label" :href="item.route ? route(item.route) : '#'"
                            :class="[
                                'flex items-center p-3 rounded-xl transition-all duration-200 group relative',
                                item.active
                                    ? 'bg-gradient-to-r from-[#c0392b] to-[#96281b] text-white font-semibold shadow-[0_4px_15px_rgba(192,57,43,0.35)] border border-white/5'
                                    : 'hover:bg-white/5 text-slate-400 hover:text-white'
                            ]">
                            <i :class="[item.icon, item.active ? 'text-white' : 'text-slate-400 group-hover:text-white', 'text-base transition-colors duration-200']"></i>
                            <span v-if="!isCollapsed"
                                class="ml-4 font-medium text-xs tracking-wide whitespace-nowrap transition-opacity duration-300">
                                {{ item.label }}
                            </span>

                            <div v-if="isCollapsed"
                                class="absolute left-full ml-4 bg-gradient-to-r from-[#c0392b] to-[#96281b] text-white text-[11px] py-1.5 px-3.5 rounded-lg opacity-0 group-hover:opacity-100 pointer-events-none transition-all duration-200 transform translate-x-2 group-hover:translate-x-0 z-50 shadow-xl whitespace-nowrap font-bold tracking-wide">
                                {{ item.label }}
                            </div>
                        </Link>
                    </div>
                </div>
            </nav>

            <div class="p-3 border-t border-white/5 bg-[#07090e]/60">
                <Button @click="isCollapsed = !isCollapsed"
                    :icon="isCollapsed ? 'pi pi-chevron-right' : 'pi pi-chevron-left'"
                    class="w-full !bg-transparent !border-none !text-slate-500 hover:!text-white transition-colors duration-200 py-2.5 focus:shadow-none" />
            </div>
        </aside>

        <main class="flex-1 flex flex-col overflow-hidden">

            <header
                class="h-20 border-b border-white/5 bg-[#0a0c14]/85 backdrop-blur-md flex items-center justify-between px-8 z-10 shadow-[0_4px_20px_rgba(0,0,0,0.2)]">

                <div class="flex items-center gap-4">
                    <span
                        class="text-[10px] font-bold text-slate-400 uppercase tracking-[3px] bg-white/5 px-3 py-1.5 rounded-md border border-white/5 select-none font-nunito">
                        <i class="pi pi-folder-open text-[10px] mr-1.5 text-[#e05c4b]"></i>
                        {{ route().current() }}
                    </span>
                </div>

                <div class="flex items-center gap-6">
                    <div class="relative hidden md:block group">
                        <i class="pi pi-search absolute left-3.5 top-1/2 -translate-y-1/2 text-slate-500 group-focus-within:text-[#e05c4b] transition-colors duration-200"></i>
                        <InputText placeholder="Buscar en el sistema..."
                            class="!bg-[#0d1117] !border border-white/5 !pl-10 !pr-4 !py-2 !rounded-full !text-xs !w-64 focus:!border-[#c0392b]/50 focus:!ring-1 focus:!ring-[#c0392b] !text-white font-nunito tracking-wide transition-all duration-300 placeholder:text-slate-600 focus:!w-72" />
                    </div>

                    <div class="flex items-center gap-4">
                        <Button icon="pi pi-bell" text rounded severity="secondary"
                            class="hover:!text-white hover:!bg-white/5 transition-all duration-200 !text-slate-400" />

                        <div class="relative z-50">
                            <button @click="isUserMenuOpen = !isUserMenuOpen" type="button"
                                class="h-10 w-10 rounded-full bg-gradient-to-tr from-[#c0392b] to-[#96281b] flex items-center justify-center text-white font-bold text-base shadow-[0_0_15px_rgba(192,57,43,0.35)] border border-white/10 relative select-none hover:scale-105 active:scale-95 transition-all duration-200 focus:outline-none cursor-pointer z-10">
                                {{ $page.props.auth.user.name.charAt(0).toUpperCase() }}
                                <span class="absolute bottom-0 right-0 block h-2.5 w-2.5 rounded-full bg-emerald-500 ring-2 ring-[#0a0c14] animate-pulse"></span>
                            </button>

                            <div v-show="isUserMenuOpen" class="fixed inset-0 z-0 cursor-default" @click="isUserMenuOpen = false"></div>

                            <div v-show="isUserMenuOpen"
                                class="absolute right-0 mt-3 w-52 bg-[#0a0c14]/95 backdrop-blur-md border border-white/10 rounded-xl shadow-[0_10px_40px_rgba(0,0,0,0.6)] py-2 space-y-0.5 pointer-events-auto z-10">

                                <div class="px-4 py-2 border-b border-white/5 mb-1 select-none">
                                    <p class="text-[11px] font-bold text-white truncate">
                                        {{ $page.props.auth.user.name }}
                                    </p>
                                    <p class="text-[9px] text-slate-500 truncate">
                                        {{ $page.props.auth.user.email }}
                                    </p>
                                </div>

                                <Link :href="route('profile.edit')"
                                    class="flex items-center gap-3 px-4 py-2.5 text-xs font-semibold text-slate-300 hover:text-white hover:bg-white/5 transition-colors duration-150 cursor-pointer w-full">
                                    <i class="pi pi-user text-slate-400 text-sm"></i>
                                    Mi Perfil
                                </Link>

                                <div class="h-px bg-white/5 mx-2 my-1"></div>

                                <Link :href="route('logout')" method="post" as="button"
                                    class="w-full flex items-center gap-3 px-4 py-2.5 text-xs font-semibold text-red-400 hover:text-red-300 hover:bg-red-500/10 transition-colors duration-150 text-left cursor-pointer">
                                    <i class="pi pi-sign-out text-sm"></i>
                                    Cerrar Sesión
                                </Link>
                            </div>
                        </div>
                    </div>
                </div>
            </header>

            <div class="flex-1 overflow-y-auto p-8 custom-scrollbar bg-[#0d1117]">
                <div class="animate-fade-in">
                    <slot />
                </div>
            </div>
        </main>
    </div>
</template>

<style scoped>
@import url('https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,700;0,900;1,700&family=Nunito:wght@400;500;600;700&display=swap');

.font-playfair {
    font-family: 'Playfair Display', serif;
}

.font-nunito {
    font-family: 'Nunito', sans-serif;
}

.animate-fade-in {
    animation: fadeUpIn 0.4s ease-out both;
}

@keyframes fadeUpIn {
    from {
        opacity: 0;
        transform: translateY(10px);
    }

    to {
        opacity: 1;
        transform: translateY(0);
    }
}

/* Transiciones fluidas del Dropdown */
.dropdown-enter-active {
    transition: all 0.2s ease-out;
}

.dropdown-leave-active {
    transition: all 0.15s ease-in;
}

.dropdown-enter-from,
.dropdown-leave-to {
    opacity: 0;
    transform: scale(0.95) translateY(-5px);
}

.custom-scrollbar::-webkit-scrollbar {
    width: 6px;
    height: 6px;
}

.custom-scrollbar::-webkit-scrollbar-track {
    background: transparent;
}

.custom-scrollbar::-webkit-scrollbar-thumb {
    background: rgba(255, 255, 255, 0.03);
    border-radius: 10px;
}

.custom-scrollbar::-webkit-scrollbar-thumb:hover {
    background: rgba(192, 57, 43, 0.5);
}
</style>