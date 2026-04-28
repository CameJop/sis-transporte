<script setup>
import ApplicationLogo from '@/Components/ApplicationLogo.vue';
import { Link } from '@inertiajs/vue3';
</script>

<template>
    <div
        class="flex min-h-screen flex-col items-center bg-slate-950 pt-6 sm:justify-center sm:pt-0"
    >
        <div class="transition-transform duration-500 hover:scale-110">
            
        </div>

        <div
            class="mt-8 w-full overflow-hidden bg-slate-900/50 border border-slate-800 px-8 py-10 shadow-2xl backdrop-blur-xl sm:max-w-md sm:rounded-2xl"
        >
            <div class="absolute top-0 left-0 w-full h-1 bg-gradient-to-r from-transparent via-indigo-500 to-transparent opacity-50"></div>

            <slot />
        </div>

        <div class="mt-8 text-center">
            <p class="text-xs text-slate-500 font-medium tracking-widest uppercase">
                &copy; 2026 Sistema Automatizado
            </p>
        </div>
    </div>
</template>

<style scoped>
/* Animación suave para el fondo si quisieras algo más dinámico */
.bg-slate-950 {
    background-image: 
        radial-gradient(circle at 50% -20%, #1e1b4b 0%, #020617 80%);
}
</style>