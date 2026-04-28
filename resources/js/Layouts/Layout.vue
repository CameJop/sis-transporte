<script setup>
import { ref } from 'vue';
import { Link } from '@inertiajs/vue3'; // Importante para la navegación SPA
import Button from 'primevue/button';
import Avatar from 'primevue/avatar';
import InputText from 'primevue/inputtext';

const isCollapsed = ref(false);

// Añadimos la propiedad 'route' con el nombre de la ruta definida en web.php
const menuGroups = ref([
    {
        label: 'Dashboards',
        items: [
            { label: 'E-Commerce', icon: 'pi pi-home', route: 'dashboard', active: route().current('dashboard') }
        ]
    },
    {
        label: 'Apps',
        items: [
            // Usamos el nombre de la ruta que definiste: 'users.index'
            { label: 'Usuarios', icon: 'pi pi-users', route: 'users.index', active: route().current('users.*') },
            { label: 'Boletos', icon: 'pi pi-boletos', route: 'boletos.index', active: route().current('boletos.*') },
            { label: 'Chat', icon: 'pi pi-comments', route: 'dashboard', active: false },
            { label: 'Files', icon: 'pi pi-folder', route: 'dashboard', active: false },
            { label: 'Mail', icon: 'pi pi-envelope', route: 'dashboard', active: false }
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
                    <i class="pi pi-bolt text-white"></i>
                </div>
                <span v-if="!isCollapsed" class="font-bold text-xl text-white tracking-tight">Atlantis</span>
            </Link>

            <nav class="flex-1 overflow-y-auto px-4 py-2 custom-scrollbar">
                <div v-for="group in menuGroups" :key="group.label" class="mb-6">
                    <p v-if="!isCollapsed" class="text-[10px] uppercase tracking-[2px] text-slate-500 font-bold mb-4 px-2">
                        {{ group.label }}
                    </p>
                    <div class="space-y-1">
                        <Link 
                            v-for="item in group.items" 
                            :key="item.label"
                            :href="route(item.route)"
                            :class="[
                                'flex items-center p-3 rounded-xl transition-all group',
                                item.active ? 'bg-white/5 text-white shadow-sm border border-white/5' : 'hover:bg-white/5 text-slate-400 hover:text-slate-200'
                            ]"
                        >
                            <i :class="[item.icon, item.active ? 'text-indigo-400' : 'group-hover:text-slate-300', 'text-lg']"></i>
                            <span v-if="!isCollapsed" class="ml-4 font-medium text-sm">{{ item.label }}</span>
                        </Link>
                    </div>
                </div>
            </nav>

            <div class="p-4 border-t border-white/5">
                <Button @click="isCollapsed = !isCollapsed" icon="pi pi-bars" class="w-full !bg-transparent !border-none !text-slate-500 hover:!text-white" />
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
                        <Link :href="route('dashboard')">
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