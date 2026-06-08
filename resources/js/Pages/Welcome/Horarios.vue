<script setup>
import { ref, computed } from 'vue';
import { Head } from '@inertiajs/vue3';
import AppLayout from '@/Pages/Welcome/AppLayout.vue';

const ciudades = ['Cochabamba', 'La Paz', 'Santa Cruz', 'Oruro', 'Potosí', 'Tarija', 'Sucre'];
const ciudadActiva = ref('Cochabamba');

const horarios = {
    Cochabamba: [
        { destino: 'La Paz',      horas: ['07:30', '10:00', '11:30', '16:00', '21:00', '21:30', '22:00', '22:30'] },
        { destino: 'Santa Cruz',  horas: ['08:00', '19:00', '20:00', '21:00', '21:30'] },
        { destino: 'Oruro',       horas: ['07:00', '10:30', '13:30', '15:30', '17:30'] },
        { destino: 'Sucre',       horas: ['21:30'] },
        { destino: 'Potosí',      horas: ['21:00'] },
        { destino: 'Tarija',      horas: ['17:00'] },
    ],
    'La Paz': [
        { destino: 'Cochabamba',  horas: ['07:00', '09:30', '12:00', '15:00', '20:30', '21:00', '21:30'] },
        { destino: 'Oruro',       horas: ['06:30', '09:00', '11:00', '14:00', '17:00'] },
        { destino: 'Santa Cruz',  horas: ['19:30', '20:30', '21:30'] },
    ],
    'Santa Cruz': [
        { destino: 'Cochabamba',  horas: ['08:00', '20:00', '21:00', '22:00'] },
        { destino: 'La Paz',      horas: ['19:00', '20:00', '21:00'] },
        { destino: 'Trinidad',    horas: ['09:00', '19:00'] },
    ],
    Oruro: [
        { destino: 'Cochabamba',  horas: ['07:00', '10:00', '13:00', '16:00'] },
        { destino: 'La Paz',      horas: ['06:00', '09:00', '12:00', '15:00', '18:00'] },
        { destino: 'Potosí',      horas: ['08:00', '14:00'] },
    ],
    Potosí: [
        { destino: 'Cochabamba',  horas: ['20:00'] },
        { destino: 'Sucre',       horas: ['08:00', '14:00', '18:00'] },
        { destino: 'Oruro',       horas: ['07:00', '13:00'] },
    ],
    Tarija: [
        { destino: 'Cochabamba',  horas: ['17:00'] },
        { destino: 'Yacuiba',     horas: ['08:00', '14:00'] },
        { destino: 'Sucre',       horas: ['18:00'] },
    ],
    Sucre: [
        { destino: 'Cochabamba',  horas: ['20:30'] },
        { destino: 'Potosí',      horas: ['07:00', '13:00', '17:00'] },
        { destino: 'Oruro',       horas: ['19:00'] },
    ],
};

const horariosFiltrados = computed(() => horarios[ciudadActiva.value] ?? []);
</script>

<template>
    <Head title="Horarios — Trans. Copacabana S.A." />
    <AppLayout>
        <div class="page-top-pad">
            <section id="horarios" class="section section-darker">
                <div class="section-inner">
                    <div class="section-header">
                        <span class="section-tag">Salidas diarias</span>
                        <h2 class="section-title">Horarios de Salida</h2>
                        <div class="section-rule"></div>
                    </div>

                    <div class="horarios-tabs">
                        <button v-for="ciudad in ciudades" :key="ciudad"
                            class="htab" :class="{ 'htab-active': ciudadActiva === ciudad }"
                            @click="ciudadActiva = ciudad">
                            {{ ciudad }}
                        </button>
                    </div>

                    <div class="horarios-grid">
                        <div v-for="ruta in horariosFiltrados" :key="ruta.destino" class="horario-row">
                            <div class="horario-destino">
                                <span class="horario-icon">📍</span>
                                <span class="horario-ciudad">{{ ruta.destino }}</span>
                            </div>
                            <div class="horario-horas">
                                <span v-for="hora in ruta.horas" :key="hora" class="hora-pill">{{ hora }}</span>
                            </div>
                        </div>
                    </div>

                    <p class="horarios-note">* Horarios sujetos a disponibilidad. Salidas todos los días desde la Terminal de Buses.</p>
                    <div style="text-align:center; margin-top:28px">
                        <a href="/login" class="btn-primary-lg">Ver todos los horarios y comprar</a>
                    </div>
                </div>
            </section>
        </div>
    </AppLayout>
</template>

<style scoped>
@import '@/Pages/Welcome/welcome.css';

.page-top-pad { padding-top: 68px; }

.horarios-tabs { display: flex; flex-wrap: wrap; gap: 8px; margin-bottom: 36px; justify-content: center; }
.htab {
    padding: 8px 22px; border-radius: 50px;
    border: 1px solid rgba(255,255,255,0.12);
    background: transparent; color: rgba(255,255,255,0.45);
    font-family: 'Nunito', sans-serif; font-weight: 700; font-size: 0.82rem;
    cursor: pointer; transition: all 0.2s;
}
.htab:hover     { border-color: rgba(192,57,43,0.4); color: rgba(255,255,255,0.8); }
.htab-active    { background: linear-gradient(135deg, #c0392b, #96281b); border-color: transparent; color: #fff; }

.horarios-grid  { display: flex; flex-direction: column; gap: 2px; }
.horario-row {
    display: flex; align-items: center; gap: 24px;
    background: rgba(255,255,255,0.03); border: 1px solid rgba(255,255,255,0.06);
    border-radius: 12px; padding: 16px 24px;
    transition: background 0.2s;
}
.horario-row:hover   { background: rgba(255,255,255,0.055); }
.horario-destino     { display: flex; align-items: center; gap: 10px; min-width: 130px; }
.horario-icon        { font-size: 1rem; }
.horario-ciudad      { font-weight: 700; font-size: 0.9rem; color: #fff; }
.horario-horas       { display: flex; flex-wrap: wrap; gap: 8px; }
.hora-pill {
    padding: 4px 12px; border-radius: 50px;
    background: rgba(192,57,43,0.12); border: 1px solid rgba(192,57,43,0.25);
    font-size: 0.8rem; font-weight: 700; color: rgba(224,92,75,0.9); letter-spacing: 0.5px;
}
.horarios-note { font-size: 0.75rem; color: rgba(255,255,255,0.25); text-align: center; margin-top: 20px; line-height: 1.6; }
</style>