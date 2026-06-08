<script setup>
import { Head } from '@inertiajs/vue3';
import AppLayout from '@/Pages/Welcome/AppLayout.vue';
</script>

<template>
    <Head title="Destinos — Trans. Copacabana S.A." />
    <AppLayout>
        <div class="page-top-pad">
            <section id="destinos" class="section section-dark">
                <div class="section-inner">
                    <div class="section-header">
                        <span class="section-tag">Nuestros Destinos</span>
                        <h2 class="section-title">Viaja a cualquier rincón de Bolivia</h2>
                        <div class="section-rule"></div>
                        <p class="section-desc">Cubrimos las rutas más importantes del país, conectando norte a sur y de oriente a occidente.</p>
                    </div>

                    <div class="destinos-grid">
                        <div class="destino-card destino-featured">
                            <img src="https://images.unsplash.com/photo-1558618666-fcd25c85cd64?w=600&q=80" alt="Cochabamba" class="destino-img" />
                            <div class="destino-overlay">
                                <span class="destino-name">Cochabamba</span>
                                <span class="destino-tag">Ciudad Jardín</span>
                            </div>
                        </div>
                        <div class="destino-card">
                            <img src="https://images.unsplash.com/photo-1591608971362-f08b2a75731a?w=400&q=80" alt="La Paz" class="destino-img" />
                            <div class="destino-overlay">
                                <span class="destino-name">La Paz</span>
                                <span class="destino-tag">Sede de Gobierno</span>
                            </div>
                        </div>
                        <div class="destino-card">
                            <img src="https://images.unsplash.com/photo-1512438248247-f0f2a5a8b7f0?w=400&q=80" alt="Santa Cruz" class="destino-img" />
                            <div class="destino-overlay">
                                <span class="destino-name">Santa Cruz</span>
                                <span class="destino-tag">Capital económica</span>
                            </div>
                        </div>
                        <div class="destino-card">
                            <img src="https://images.unsplash.com/photo-1578662996442-48f60103fc96?w=400&q=80" alt="Oruro" class="destino-img" />
                            <div class="destino-overlay">
                                <span class="destino-name">Oruro</span>
                                <span class="destino-tag">Folklore y cultura</span>
                            </div>
                        </div>
                        <div class="destino-card">
                            <img src="https://images.unsplash.com/photo-1533050487297-09b450131914?w=400&q=80" alt="Sucre" class="destino-img" />
                            <div class="destino-overlay">
                                <span class="destino-name">Sucre</span>
                                <span class="destino-tag">Capital constitucional</span>
                            </div>
                        </div>
                        <div class="destino-card">
                            <img src="https://images.unsplash.com/photo-1506905925346-21bda4d32df4?w=400&q=80" alt="Potosí" class="destino-img" />
                            <div class="destino-overlay">
                                <span class="destino-name">Potosí</span>
                                <span class="destino-tag">Patrimonio mundial</span>
                            </div>
                        </div>
                        <div class="destino-card">
                            <img src="https://images.unsplash.com/photo-1519922639192-e73293ca430e?w=400&q=80" alt="Tarija" class="destino-img" />
                            <div class="destino-overlay">
                                <span class="destino-name">Tarija</span>
                                <span class="destino-tag">La tierra del vino</span>
                            </div>
                        </div>
                        <div class="destino-card">
                            <img src="https://images.unsplash.com/photo-1504893524553-b855bce32c67?w=400&q=80" alt="Trinidad" class="destino-img" />
                            <div class="destino-overlay">
                                <span class="destino-name">Trinidad</span>
                                <span class="destino-tag">Corazón del Beni</span>
                            </div>
                        </div>
                        <div class="destino-card">
                            <img src="https://images.unsplash.com/photo-1448375240586-882707db888b?w=400&q=80" alt="Yacuiba" class="destino-img" />
                            <div class="destino-overlay">
                                <span class="destino-name">Yacuiba</span>
                                <span class="destino-tag">Puerta del sur</span>
                            </div>
                        </div>
                    </div>

                    <div style="text-align:center; margin-top:48px">
                        <a href="/login" class="btn-primary-lg">Ver horarios y comprar pasaje</a>
                    </div>
                </div>
            </section>
        </div>
    </AppLayout>
</template>

<style scoped>
@import '@/Pages/Welcome/welcome.css';

.page-top-pad { padding-top: 68px; }

.destinos-grid {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    grid-template-rows: 260px 220px;
    gap: 12px;
}
.destino-card         { position: relative; border-radius: 14px; overflow: hidden; cursor: pointer; }
.destino-featured     { grid-column: span 2; grid-row: span 2; }
.destino-img          { width: 100%; height: 100%; object-fit: cover; transition: transform 0.5s ease; }
.destino-card:hover .destino-img { transform: scale(1.06); }
.destino-overlay {
    position: absolute; inset: 0;
    background: linear-gradient(to top, rgba(0,0,0,0.75) 0%, transparent 55%);
    display: flex; flex-direction: column; justify-content: flex-end;
    padding: 20px;
}
.destino-name         { font-family: 'Playfair Display', serif; font-size: 1.25rem; font-weight: 700; color: #fff; }
.destino-featured .destino-name { font-size: 2rem; }
.destino-tag          { font-size: 0.7rem; font-weight: 700; color: rgba(255,255,255,0.6); text-transform: uppercase; letter-spacing: 1px; margin-top: 3px; }

@media (max-width: 1024px) {
    .destinos-grid { grid-template-columns: repeat(3, 1fr); grid-template-rows: auto; }
    .destino-featured { grid-column: span 3; height: 280px; }
}
@media (max-width: 768px) {
    .destinos-grid { grid-template-columns: 1fr 1fr; }
    .destino-featured { grid-column: span 2; height: 220px; }
}
@media (max-width: 500px) {
    .destinos-grid { grid-template-columns: 1fr; }
    .destino-featured { grid-column: span 1; }
}
</style>