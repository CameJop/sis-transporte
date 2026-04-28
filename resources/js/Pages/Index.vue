<script setup>
import { ref } from 'vue';
import Layout from '@/Layouts/Layout.vue';
import Button from 'primevue/button';

const stats = ref([
    { label: 'Conversion Rate', value: '0.81%', trend: '-0.6%', color: 'text-red-400', bg: 'bg-red-400/10' },
    { label: 'Avg. Order Value', value: '$306.2', trend: '+4.2%', color: 'text-green-400', bg: 'bg-green-400/10' },
    { label: 'Order Quantity', value: '1,620', trend: '-2.1%', color: 'text-cyan-400', bg: 'bg-cyan-400/10' }
]);
</script>

<template>
    <Layout>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
            <div v-for="stat in stats" :key="stat.label" class="bg-[#1a1d2b] p-6 rounded-[1.5rem] border border-white/5">
                <p class="text-xs font-bold text-slate-500 uppercase tracking-wider mb-4">{{ stat.label }}</p>
                <div class="flex items-end justify-between">
                    <h2 class="text-3xl font-bold text-white">{{ stat.value }}</h2>
                    <div :class="[stat.bg, stat.color, 'px-2 py-1 rounded-lg text-[10px] font-black']">{{ stat.trend }}</div>
                </div>
                <div class="mt-4 h-1 w-full bg-slate-800 rounded-full overflow-hidden">
                    <div class="h-full bg-indigo-500 w-2/3 shadow-[0_0_8px_#6366f1]"></div>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <div class="lg:col-span-2 bg-[#1a1d2b] p-8 rounded-[2rem] border border-white/5 relative overflow-hidden">
                <div class="flex justify-between items-start mb-8">
                    <div>
                        <h3 class="text-slate-400 text-sm font-medium mb-1">Unique Visitor Graph</h3>
                        <div class="text-4xl font-black text-white">$620,076</div>
                    </div>
                    <Button label="2026" icon="pi pi-chevron-down" iconPos="right" text severity="secondary" class="!bg-[#0f111a] !rounded-xl" />
                </div>
                <div class="h-64 flex items-end gap-2">
                    <div v-for="n in 12" :key="n" :style="{height: (Math.random() * 100) + '%'}" class="flex-1 bg-gradient-to-t from-indigo-600/20 to-indigo-500 rounded-t-lg transition-all hover:to-cyan-400"></div>
                </div>
            </div>

            <div class="bg-[#1a1d2b] p-8 rounded-[2rem] border border-white/5">
                <h3 class="text-white font-bold mb-6">Transaction History</h3>
                <div class="space-y-6">
                    <div v-for="i in 4" :key="i" class="flex items-center justify-between group cursor-pointer">
                        <div class="flex items-center gap-4">
                            <div class="h-10 w-10 rounded-full bg-indigo-500/10 flex items-center justify-center text-indigo-400">
                                <i class="pi pi-arrow-up-right text-xs"></i>
                            </div>
                            <div>
                                <p class="text-sm font-bold text-white leading-none mb-1">Payment #{{ 28490 + i }}</p>
                                <p class="text-[10px] text-slate-500 uppercase">April 13, 2026</p>
                            </div>
                        </div>
                        <span class="text-green-400 font-black text-sm">+$250.00</span>
                    </div>
                </div>
            </div>
        </div>
    </Layout>
</template>