<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';

// Datos de ejemplo
const viajes = [
    { id: 1, origen: 'Santa Cruz', destino: 'La Paz', hora: '19:30', bus: 'Lecho Cama', precio: 180, estado: 'Disponible' },
    { id: 2, origen: 'Cochabamba', destino: 'Santa Cruz', hora: '21:00', bus: 'Semicama', precio: 100, estado: 'Lleno' },
    { id: 3, origen: 'La Paz', destino: 'Uyuni', hora: '20:00', bus: 'Bus Cama', precio: 150, estado: 'Disponible' },
];
</script>

<template>
    <Head title="Rutas de Viaje" />

    <AuthenticatedLayout>
        <div class="py-12 bg-slate-950 min-h-screen">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                
                <div class="mb-8 bg-slate-900 border border-slate-800 p-4 rounded-2xl flex gap-4">
                    <input type="text" placeholder="Buscar origen o destino..." class="bg-slate-800 border-none text-white rounded-xl flex-1 focus:ring-2 focus:ring-indigo-500 placeholder-slate-500">
                    <select class="bg-slate-800 border-none text-white rounded-xl focus:ring-2 focus:ring-indigo-500">
                        <option>Todos los buses</option>
                        <option>Lecho Cama</option>
                        <option>Semicama</option>
                    </select>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    <div v-for="viaje in viajes" :key="viaje.id" 
                         class="group relative bg-slate-900 border border-slate-800 rounded-3xl p-6 transition-all duration-300 hover:border-indigo-500/50 hover:shadow-2xl hover:shadow-indigo-500/10 overflow-hidden">
                        
                        <div class="absolute -top-10 -right-10 w-32 h-32 bg-indigo-500/5 rounded-full blur-3xl group-hover:bg-indigo-500/10 transition-colors"></div>

                        <div class="flex justify-between items-start mb-6">
                            <span :class="viaje.estado === 'Disponible' ? 'bg-emerald-500/10 text-emerald-500' : 'bg-red-500/10 text-red-500'" 
                                  class="text-[10px] uppercase font-black px-3 py-1 rounded-full tracking-widest">
                                {{ viaje.estado }}
                            </span>
                            <span class="text-2xl font-black text-white italic">BS. {{ viaje.precio }}</span>
                        </div>

                        <div class="space-y-4 mb-8">
                            <div class="flex items-center gap-4">
                                <div class="w-8 h-8 rounded-full bg-slate-800 flex items-center justify-center text-indigo-400">
                                    <span>📍</span>
                                </div>
                                <div>
                                    <p class="text-xs text-slate-500 font-bold uppercase tracking-tighter">Salida</p>
                                    <p class="text-white font-bold">{{ viaje.origen }}</p>
                                </div>
                            </div>

                            <div class="ml-4 h-6 border-l-2 border-dashed border-slate-700"></div>

                            <div class="flex items-center gap-4">
                                <div class="w-8 h-8 rounded-full bg-indigo-500 flex items-center justify-center text-white shadow-lg shadow-indigo-500/40">
                                    <span>🚩</span>
                                </div>
                                <div>
                                    <p class="text-xs text-slate-500 font-bold uppercase tracking-tighter">Llegada</p>
                                    <p class="text-white font-bold text-lg">{{ viaje.destino }}</p>
                                </div>
                            </div>
                        </div>

                        <div class="border-t border-slate-800 pt-6 flex justify-between items-center text-sm">
                            <div class="text-slate-400 font-bold uppercase tracking-widest text-[10px]">
                                {{ viaje.hora }}
                            </div>
                            <div class="text-indigo-400 font-bold">
                                {{ viaje.bus }}
                            </div>
                        </div>

                        <div class="mt-6">
                            <button class="w-full py-3 bg-slate-800 group-hover:bg-indigo-600 text-white rounded-xl font-bold transition-all duration-300">
                                Gestionar Boletos
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

<style scoped>
.bg-slate-950 {
    background: radial-gradient(circle at top center, #0f172a 0%, #020617 100%);
}
</style>