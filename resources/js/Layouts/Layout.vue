<script setup>
import { ref } from 'vue';
import { Link } from '@inertiajs/vue3';
import Button from 'primevue/button';
import Avatar from 'primevue/avatar';
import InputText from 'primevue/inputtext';

const isCollapsed = ref(false);

const menuGroups = ref([
    {
        label: 'Dashboards',
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
            // Corregido: Ahora apunta a la ruta de respaldos y detecta el estado activo
            { label: 'Respaldos', icon: 'pi pi-database', route: 'respaldos.index', active: route().current('respaldos.*') },
        ]
    }
]);
</script>

<template>
    <div class="flex h-screen bg-[#0f111a] text-slate-300 font-sans overflow-hidden my-app-dark">
        <aside 
            :class="[
                'bg-[#1a1d2b] border-r border-white/5 transition-all duration-300 flex flex-col',
                isCollapsed ? 'w-20' : 'w-64'
            ]"
        >
            <Link :href="route('dashboard')" class="p-6 flex items-center gap-3 hover:opacity-80 transition-opacity">
                <div class="h-8 w-8 bg-indigo-500 rounded-lg flex items-center justify-center shadow-[0_0_15px_rgba(99,102,241,0.5)]">
                    <i class="pi pi-bolt text-white text-lg"></i>
                </div>
                <span v-if="!isCollapsed" class="font-bold text-xl text-white tracking-tight">Atlantis</span>
            </Link>

            <nav class="flex-1 overflow-y-auto px-4 py-2 custom-scrollbar overflow-x-hidden">
                <div v-for="group in menuGroups" :key="group.label" class="mb-6">
                    <p v-if="!isCollapsed" class="text-[10px] uppercase tracking-[2px] text-slate-500 font-bold mb-4 px-2">
                        {{ group.label }}
                    </p>
                    <div class="space-y-1">
                        <Link 
                            v-for="item in group.items" 
                            :key="item.label"
                            :href="item.route ? route(item.route) : '#'"
                            :class="[
                                'flex items-center p-3 rounded-xl transition-all group relative',
                                item.active ? 'bg-white/5 text-white shadow-sm border border-white/5' : 'hover:bg-white/5 text-slate-400 hover:text-slate-200'
                            ]"
                        >
                            <i :class="[item.icon, item.active ? 'text-indigo-400' : 'group-hover:text-slate-300', 'text-lg']"></i>
                            <span v-if="!isCollapsed" class="ml-4 font-medium text-sm whitespace-nowrap">{{ item.label }}</span>
                            
                            <div v-if="isCollapsed" class="absolute left-full ml-4 bg-indigo-600 text-white text-xs py-1 px-2 rounded opacity-0 group-hover:opacity-100 pointer-events-none transition-opacity z-50">
                                {{ item.label }}
                            </div>
                        </Link>
                    </div>
                </div>
            </nav>

            <div class="p-4 border-t border-white/5">
                <Button @click="isCollapsed = !isCollapsed" :icon="isCollapsed ? 'pi pi-chevron-right' : 'pi pi-chevron-left'" class="w-full !bg-transparent !border-none !text-slate-500 hover:!text-white" />
            </div>
        </aside>

        <main class="flex-1 flex flex-col overflow-hidden">
            <header class="h-16 border-b border-white/5 bg-[#1a1d2b]/50 backdrop-blur-md flex items-center justify-between px-8 z-10">
                <div class="flex items-center gap-4">
                    <span class="text-sm font-semibold text-slate-400 uppercase tracking-widest text-[10px]">
                        {{ route().current() }}
                    </span>
                </div>
                <div class="flex items-center gap-6">
                    <div class="relative hidden md:block">
                        <i class="pi pi-search absolute left-3 top-1/2 -translate-y-1/2 text-slate-500"></i>
                        <InputText placeholder="Search..." class="!bg-[#0f111a] !border-none !pl-10 !rounded-full !text-sm !w-64 focus:ring-1 focus:ring-indigo-500" />
                    </div>
                    <div class="flex items-center gap-3">
                        <Button icon="pi pi-bell" text rounded severity="secondary" />
                        <Link :href="route('profile.edit')">
                            <Avatar image="https://i.pravatar.cc/100" shape="circle" class="border-2 border-indigo-500/20 hover:border-indigo-500 transition-colors" />
                        </Link>
                    </div>
                </div>
            </header>

            <div class="flex-1 overflow-y-auto p-8 custom-scrollbar bg-[#0f111a]">
                <slot />
            </div>
        </main>
    </div>
</template>

<style>
.custom-scrollbar::-webkit-scrollbar {
    width: 4px;
}
.custom-scrollbar::-webkit-scrollbar-track {
    background: transparent;
}
.custom-scrollbar::-webkit-scrollbar-thumb {
    background: rgba(255, 255, 255, 0.05);
    border-radius: 10px;
}
.custom-scrollbar::-webkit-scrollbar-thumb:hover {
    background: rgba(99, 102, 241, 0.2);
}
</style>