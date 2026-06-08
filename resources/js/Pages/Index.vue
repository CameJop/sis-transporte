<script setup>
import Layout from '@/Layouts/Layout.vue';
import { computed } from 'vue';
const props = defineProps({
    stats: {
        type: Object,
        default: () => ({
            total_viajes: 0,
            viajes_programados: 0,
            viajes_en_curso: 0,
            total_clientes: 0,
            total_empleados: 0,
            total_buses: 0,
            boletos_hoy: 0,
            ingresos_hoy: 0,
            encomiendas_activas: 0,
            mantenimientos_pendientes: 0,
        })
    },
    viajesRecientes: {
        type: Array,
        default: () => []
    },
    ingresosPorMes: {
        type: Object,
        default: () => ({})
    },
});
const meses = ['Ene','Feb','Mar','Abr','May','Jun','Jul','Ago','Sep','Oct','Nov','Dic'];

const maxIngreso = computed(() => {
    return Math.max(...Object.values(props.ingresosPorMes).map(m => m.total), 1);
});

function barHeight(mes) {
    const data = props.ingresosPorMes[mes + 1];
    return data ? Math.round((data.total / maxIngreso.value) * 100) : 4;
}

function badgeClass(estado) {
    return {
        'PROGRAMADO': 'bg-blue-500/10 text-blue-400',
        'EN_CURSO':   'bg-amber-500/10 text-amber-400',
        'FINALIZADO': 'bg-green-500/10 text-green-400',
    }[estado] ?? 'bg-slate-500/10 text-slate-400';
}
</script>

<template>
    <Layout>
        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-3 mb-6">
            <div class="bg-[#1a1d2b] rounded-xl p-4 border border-white/5">
                <p class="text-[11px] text-slate-500 mb-2">Total viajes</p>
                <p class="text-2xl font-bold text-white">{{ stats.total_viajes }}</p>
                <p class="text-[10px] text-slate-600 mt-1">todos los estados</p>
            </div>
            <div class="bg-[#1a1d2b] rounded-xl p-4 border border-white/5">
                <p class="text-[11px] text-slate-500 mb-2">Programados</p>
                <p class="text-2xl font-bold text-blue-400">{{ stats.viajes_programados }}</p>
                <p class="text-[10px] text-slate-600 mt-1">pendientes</p>
            </div>
            <div class="bg-[#1a1d2b] rounded-xl p-4 border border-white/5">
                <p class="text-[11px] text-slate-500 mb-2">En curso</p>
                <p class="text-2xl font-bold text-amber-400">{{ stats.viajes_en_curso }}</p>
                <p class="text-[10px] text-slate-600 mt-1">activos ahora</p>
            </div>
            <div class="bg-[#1a1d2b] rounded-xl p-4 border border-white/5">
                <p class="text-[11px] text-slate-500 mb-2">Clientes</p>
                <p class="text-2xl font-bold text-white">{{ stats.total_clientes }}</p>
                <p class="text-[10px] text-slate-600 mt-1">registrados</p>
            </div>
            <div class="bg-[#1a1d2b] rounded-xl p-4 border border-white/5">
                <p class="text-[11px] text-slate-500 mb-2">Boletos hoy</p>
                <p class="text-2xl font-bold text-green-400">{{ stats.boletos_hoy }}</p>
                <p class="text-[10px] text-slate-600 mt-1">vendidos</p>
            </div>
            <div class="bg-[#1a1d2b] rounded-xl p-4 border border-white/5">
                <p class="text-[11px] text-slate-500 mb-2">Mantenimientos</p>
                <p class="text-2xl font-bold text-red-400">{{ stats.mantenimientos_pendientes }}</p>
                <p class="text-[10px] text-slate-600 mt-1">pendientes</p>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-5 gap-6">
            <!-- Gráfico ingresos -->
            <div class="lg:col-span-3 bg-[#1a1d2b] p-6 rounded-2xl border border-white/5">
                <div class="flex justify-between items-center mb-4">
                    <p class="text-sm font-medium text-white">Ingresos por mes</p>
                    <span class="text-xs text-slate-500">año actual</span>
                </div>
                <div class="flex items-end gap-1 h-36">
                    <div
                        v-for="(mes, i) in meses" :key="i"
                        :style="{ height: barHeight(i) + '%' }"
                        :class="['flex-1 rounded-t-md transition-all', i === new Date().getMonth() ? 'bg-indigo-500' : 'bg-indigo-500/30']"
                    ></div>
                </div>
                <div class="flex justify-between mt-1">
                    <span v-for="mes in meses" :key="mes" class="text-[9px] text-slate-600 flex-1 text-center">{{ mes }}</span>
                </div>
                <div class="grid grid-cols-3 gap-4 mt-4 pt-4 border-t border-white/5">
                    <div>
                        <p class="text-[11px] text-slate-500">Ingresos hoy</p>
                        <p class="text-lg font-bold text-green-400">Bs {{ Number(stats.ingresos_hoy).toFixed(2) }}</p>
                    </div>
                    <div>
                        <p class="text-[11px] text-slate-500">Buses totales</p>
                        <p class="text-lg font-bold text-white">{{ stats.total_buses }}</p>
                    </div>
                    <div>
                        <p class="text-[11px] text-slate-500">Empleados activos</p>
                        <p class="text-lg font-bold text-white">{{ stats.total_empleados }}</p>
                    </div>
                </div>
            </div>

            <!-- Viajes recientes -->
            <div class="lg:col-span-2 bg-[#1a1d2b] p-6 rounded-2xl border border-white/5">
                <p class="text-sm font-medium text-white mb-4">Viajes recientes</p>
                <div class="space-y-3">
                    <div
                        v-for="viaje in viajesRecientes" :key="viaje.id_viaje"
                        class="flex items-center justify-between py-2 border-b border-white/5 last:border-0"
                    >
                        <div>
                            <p class="text-xs font-medium text-white leading-none">
                                {{ viaje.origen }} → {{ viaje.destino }}
                            </p>
                            <p class="text-[10px] text-slate-500 mt-1">
                                {{ viaje.placa }} · {{ viaje.hora_salida }}
                            </p>
                        </div>
                        <span :class="['text-[10px] font-bold px-2 py-1 rounded-md', badgeClass(viaje.estado)]">
                            {{ viaje.estado }}
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </Layout>
</template>