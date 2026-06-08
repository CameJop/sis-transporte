<script setup>
import { Head } from '@inertiajs/vue3';
import AppLayout from '@/Pages/Welcome/AppLayout.vue';

const sucursales = [
    { ciudad: 'Cochabamba', direccion: 'Calle Luis Uriona Nro. 1936', telefono: '4252004 – 4235927', horario: '05:30 – 23:00 hrs', badge: 'Oficina Central' },
    { ciudad: 'La Paz',     direccion: 'Terminal Bimodal La Paz',     telefono: '+591 2 228 5478',   horario: '06:00 – 22:00 hrs', badge: '' },
    { ciudad: 'Santa Cruz', direccion: 'Terminal Bimodal Santa Cruz', telefono: '+591 3 348 7890',   horario: '06:00 – 23:00 hrs', badge: '' },
    { ciudad: 'Oruro',      direccion: 'Terminal de Buses de Oruro',  telefono: '+591 2 525 6789',   horario: '05:30 – 22:00 hrs', badge: '' },
    { ciudad: 'Sucre',      direccion: 'Terminal de Buses de Sucre',  telefono: '+591 4 644 3210',   horario: '06:00 – 22:00 hrs', badge: '' },
];
</script>

<template>
    <Head title="Sucursales — Trans. Copacabana S.A." />
    <AppLayout>
        <div class="page-top-pad">
            <section id="sucursales" class="section section-darker">
                <div class="section-inner">
                    <div class="section-header">
                        <span class="section-tag">Estamos cerca de ti</span>
                        <h2 class="section-title">Nuestras Sucursales</h2>
                        <div class="section-rule"></div>
                        <p class="section-desc">Más de 30 agencias en todo el país para que puedas realizar tus compras, envíos y consultas de forma personal.</p>
                    </div>

                    <div class="sucursales-grid">
                        <div v-for="s in sucursales" :key="s.ciudad" class="sucursal-card">
                            <div class="sucursal-city">{{ s.ciudad }}</div>
                            <div class="sucursal-detail">
                                <p>🏢 {{ s.direccion }}</p>
                                <p>📞 {{ s.telefono }}</p>
                                <p>⏰ {{ s.horario }}</p>
                            </div>
                            <span v-if="s.badge" class="sucursal-badge">{{ s.badge }}</span>
                        </div>

                        <div class="sucursal-card sucursal-more">
                            <div class="sucursal-more-text">+25 sucursales más en todo Bolivia</div>
                            <a href="/contacto" class="sucursal-more-btn">Contáctenos</a>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </AppLayout>
</template>

<style scoped>
@import '@/Pages/Welcome/welcome.css';

.page-top-pad { padding-top: 68px; }

.sucursales-grid { display: grid; grid-template-columns: repeat(3, 1fr); gap: 20px; }
.sucursal-card {
    background: rgba(255,255,255,0.04); border: 1px solid rgba(255,255,255,0.08);
    border-radius: 16px; padding: 28px 24px; position: relative;
    transition: border-color 0.3s, transform 0.3s;
}
.sucursal-card:hover { border-color: rgba(192,57,43,0.35); transform: translateY(-3px); }
.sucursal-city   { font-family: 'Playfair Display', serif; font-size: 1.2rem; font-weight: 700; color: #fff; margin-bottom: 14px; }
.sucursal-detail { display: flex; flex-direction: column; gap: 6px; }
.sucursal-detail p { font-size: 0.82rem; color: rgba(255,255,255,0.5); line-height: 1.5; }
.sucursal-badge {
    position: absolute; top: 16px; right: 16px;
    font-size: 0.62rem; font-weight: 700; letter-spacing: 1.5px; text-transform: uppercase;
    background: rgba(192,57,43,0.2); color: #e05c4b;
    padding: 3px 10px; border-radius: 50px;
    border: 1px solid rgba(192,57,43,0.3);
}
.sucursal-more {
    display: flex; flex-direction: column; align-items: center; justify-content: center; gap: 16px;
    background: rgba(192,57,43,0.05); border-color: rgba(192,57,43,0.2); text-align: center;
}
.sucursal-more-text { font-size: 0.9rem; color: rgba(255,255,255,0.5); font-weight: 600; }
.sucursal-more-btn {
    padding: 9px 24px; border-radius: 50px;
    border: 1px solid rgba(192,57,43,0.5); color: rgba(224,92,75,0.9);
    font-weight: 700; font-size: 0.85rem; text-decoration: none;
    transition: background 0.2s; font-family: 'Nunito', sans-serif;
}
.sucursal-more-btn:hover { background: rgba(192,57,43,0.1); }

@media (max-width: 768px) { .sucursales-grid { grid-template-columns: 1fr 1fr; } }
@media (max-width: 500px) { .sucursales-grid { grid-template-columns: 1fr; } }
</style>