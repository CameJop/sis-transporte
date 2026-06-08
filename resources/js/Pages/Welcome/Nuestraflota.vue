<script setup>
import { Head } from '@inertiajs/vue3';
import AppLayout from '@/Pages/Welcome/AppLayout.vue';
</script>

<template>
    <Head title="Nuestra Flota — Trans. Copacabana S.A." />
    <AppLayout>
        <div class="page-top-pad">
            <section id="flota" class="section section-dark">
                <div class="section-inner">
                    <div class="section-header">
                        <span class="section-tag">Comodidad garantizada</span>
                        <h2 class="section-title">Nuestra Flota</h2>
                        <div class="section-rule"></div>
                        <p class="section-desc">La flota más moderna y segura de Bolivia, con mantenimiento constante en nuestros propios talleres.</p>
                    </div>

                    <div class="flota-grid">
                        <!-- Normal -->
                        <div class="flota-card">
                            <div class="flota-badge">Económico</div>
                            <div class="flota-icon">🚌</div>
                            <h3 class="flota-title">Bus Normal</h3>
                            <p class="flota-sub">Ideal para trayectos cortos e intermedios</p>
                            <ul class="flota-list">
                                <li><span class="check">✓</span> Asientos cómodos reclinables</li>
                                <li><span class="check">✓</span> Sistema de audio a bordo</li>
                                <li><span class="check">✓</span> Televisión central</li>
                                <li><span class="check">✓</span> Bodega para equipaje</li>
                                <li><span class="cross">✗</span> Baño a bordo</li>
                                <li><span class="cross">✗</span> Aire acondicionado</li>
                            </ul>
                        </div>

                        <!-- Semicama -->
                        <div class="flota-card flota-featured">
                            <div class="flota-badge flota-badge-pop">Más popular</div>
                            <div class="flota-icon">🚌</div>
                            <h3 class="flota-title">Semi Cama</h3>
                            <p class="flota-sub">El balance perfecto entre precio y confort</p>
                            <ul class="flota-list">
                                <li><span class="check">✓</span> Asientos semi-reclinables 160°</li>
                                <li><span class="check">✓</span> TV individual por asiento</li>
                                <li><span class="check">✓</span> Calefacción a bordo</li>
                                <li><span class="check">✓</span> Bodega amplia para equipaje</li>
                                <li><span class="check">✓</span> Servicio de refrigerio</li>
                                <li><span class="cross">✗</span> Aire acondicionado</li>
                            </ul>
                        </div>

                        <!-- Cama -->
                        <div class="flota-card">
                            <div class="flota-badge flota-badge-premium">Premium</div>
                            <div class="flota-icon">✨</div>
                            <h3 class="flota-title">Bus Cama</h3>
                            <p class="flota-sub">La experiencia definitiva en viaje terrestre</p>
                            <ul class="flota-list">
                                <li><span class="check">✓</span> Asiento-cama 180° totalmente plano</li>
                                <li><span class="check">✓</span> TV individual por asiento</li>
                                <li><span class="check">✓</span> Aire acondicionado / calefacción</li>
                                <li><span class="check">✓</span> Baño privado a bordo</li>
                                <li><span class="check">✓</span> Servicio de cena a bordo</li>
                                <li><span class="check">✓</span> Manta y almohada incluidas</li>
                            </ul>
                        </div>
                    </div>

                    <div style="text-align:center; margin-top:48px">
                        <a href="/login" class="btn-primary-lg">Reservar mi asiento</a>
                    </div>
                </div>
            </section>
        </div>
    </AppLayout>
</template>

<style scoped>
@import '@/Pages/Welcome/welcome.css';

.page-top-pad { padding-top: 68px; }

.flota-grid { display: grid; grid-template-columns: repeat(3, 1fr); gap: 24px; }
.flota-card {
    background: rgba(255,255,255,0.04); border: 1px solid rgba(255,255,255,0.08);
    border-radius: 20px; padding: 36px 28px;
    position: relative; text-align: center;
    transition: border-color 0.3s, transform 0.3s;
}
.flota-card:hover  { border-color: rgba(255,255,255,0.2); transform: translateY(-4px); }
.flota-featured    { border-color: rgba(192,57,43,0.4); background: rgba(192,57,43,0.06); }
.flota-featured:hover { border-color: rgba(192,57,43,0.7); }

.flota-badge {
    display: inline-block; font-size: 0.65rem; font-weight: 700;
    letter-spacing: 2px; text-transform: uppercase;
    padding: 4px 12px; border-radius: 50px;
    background: rgba(255,255,255,0.08); color: rgba(255,255,255,0.45);
    margin-bottom: 20px;
}
.flota-badge-pop     { background: rgba(192,57,43,0.2); color: #e05c4b; }
.flota-badge-premium { background: rgba(255,200,80,0.15); color: rgba(255,200,80,0.9); }

.flota-icon  { font-size: 2.8rem; margin-bottom: 16px; display: block; }
.flota-title { font-family: 'Playfair Display', serif; font-size: 1.4rem; font-weight: 700; color: #fff; margin-bottom: 8px; }
.flota-sub   { font-size: 0.8rem; color: rgba(255,255,255,0.4); margin-bottom: 24px; line-height: 1.5; }
.flota-list  { list-style: none; text-align: left; display: flex; flex-direction: column; gap: 10px; }
.flota-list li { font-size: 0.83rem; color: rgba(255,255,255,0.6); display: flex; align-items: center; gap: 10px; }
.check { color: #4ade80; font-weight: 700; }
.cross { color: rgba(255,255,255,0.2); }

@media (max-width: 768px) { .flota-grid { grid-template-columns: 1fr; } }
</style>