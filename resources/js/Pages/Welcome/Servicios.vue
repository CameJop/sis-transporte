<script setup>
import { Head } from '@inertiajs/vue3';
import AppLayout from '@/Pages/Welcome/AppLayout.vue';
</script>

<template>
    <Head title="Servicios — Trans. Copacabana S.A." />
    <AppLayout>
        <div class="page-top-pad">
            <section id="servicios" class="section section-darker">
                <div class="section-inner">
                    <div class="section-header">
                        <span class="section-tag">Lo que ofrecemos</span>
                        <h2 class="section-title">Nuestros Servicios</h2>
                        <div class="section-rule"></div>
                    </div>

                    <div class="servicios-grid">
                        <!-- Pasajeros -->
                        <div class="servicio-card">
                            <div class="servicio-icon-wrap">
                                <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                                    <rect x="1" y="3" width="15" height="13" rx="2"/>
                                    <path d="M16 8h4l3 3v5h-7V8z"/>
                                    <circle cx="5.5" cy="18.5" r="2.5"/>
                                    <circle cx="18.5" cy="18.5" r="2.5"/>
                                </svg>
                            </div>
                            <h3 class="servicio-title">Transporte de Pasajeros</h3>
                            <p class="servicio-desc">Viaja con comodidad y seguridad en nuestra flota moderna. Buses cama, semicama y normal con salidas diarias a todos los destinos del país.</p>
                            <ul class="servicio-features">
                                <li>Asientos cama totalmente reclinables</li>
                                <li>Televisión individual a bordo</li>
                                <li>Aire acondicionado y calefacción</li>
                                <li>Baño en buses de largo recorrido</li>
                                <li>Mantenimiento constante de la flota</li>
                            </ul>
                            <a href="/login" class="servicio-btn">Comprar pasaje</a>
                        </div>

                        <!-- Carga -->
                        <div class="servicio-card">
                            <div class="servicio-icon-wrap">
                                <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                                    <path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"/>
                                    <polyline points="3.27 6.96 12 12.01 20.73 6.96"/>
                                    <line x1="12" y1="22.08" x2="12" y2="12"/>
                                </svg>
                            </div>
                            <h3 class="servicio-title">Carga y Encomiendas</h3>
                            <p class="servicio-desc">Servicio confiable y seguro para transportar tus materiales. Desde sobres hasta traslados completos, a cualquier destino nacional.</p>
                            <ul class="servicio-features">
                                <li>Recepción y entrega en sucursales</li>
                                <li>Servicio puerta a puerta</li>
                                <li>Camiones especializados de carga</li>
                                <li>Rastreo en tiempo real</li>
                                <li>Soluciones logísticas a medida</li>
                            </ul>
                            <a href="/contacto" class="servicio-btn servicio-btn-outline">Cotizar envío</a>
                        </div>

                        <!-- Corporativo -->
                        <div class="servicio-card">
                            <div class="servicio-icon-wrap">
                                <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                                    <rect x="2" y="7" width="20" height="14" rx="2"/>
                                    <path d="M16 21V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v16"/>
                                </svg>
                            </div>
                            <h3 class="servicio-title">Servicio Corporativo</h3>
                            <p class="servicio-desc">Diseñamos soluciones de logística adaptadas a las necesidades de tu empresa. Traslados puerta a puerta en el eje troncal del país.</p>
                            <ul class="servicio-features">
                                <li>Contratos personalizados</li>
                                <li>Transporte de personal</li>
                                <li>Flota dedicada</li>
                                <li>Facturación corporativa</li>
                                <li>Atención ejecutiva dedicada</li>
                            </ul>
                            <a href="/contacto" class="servicio-btn servicio-btn-outline">Consultar</a>
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

.servicios-grid { display: grid; grid-template-columns: repeat(3, 1fr); gap: 24px; }

.servicio-card {
    background: rgba(255,255,255,0.04); border: 1px solid rgba(255,255,255,0.08);
    border-radius: 20px; padding: 40px 32px;
    display: flex; flex-direction: column; gap: 16px;
    transition: border-color 0.3s, background 0.3s, transform 0.3s;
}
.servicio-card:hover { border-color: rgba(192,57,43,0.4); background: rgba(255,255,255,0.06); transform: translateY(-4px); }
.servicio-icon-wrap {
    width: 60px; height: 60px; border-radius: 14px;
    background: rgba(192,57,43,0.12); border: 1px solid rgba(192,57,43,0.25);
    display: flex; align-items: center; justify-content: center; color: #e05c4b;
}
.servicio-title { font-family: 'Playfair Display', serif; font-size: 1.3rem; font-weight: 700; color: #fff; }
.servicio-desc  { font-size: 0.88rem; color: rgba(255,255,255,0.55); line-height: 1.7; }
.servicio-features { list-style: none; display: flex; flex-direction: column; gap: 8px; flex: 1; }
.servicio-features li { font-size: 0.82rem; color: rgba(255,255,255,0.6); display: flex; align-items: center; gap: 8px; }
.servicio-features li::before { content: '✓'; color: #c0392b; font-weight: 700; flex-shrink: 0; }
.servicio-btn {
    display: block; text-align: center;
    padding: 11px 24px; border-radius: 50px;
    background: linear-gradient(135deg, #c0392b, #96281b);
    color: #fff; font-weight: 700; font-size: 0.87rem;
    text-decoration: none; transition: filter 0.2s, transform 0.2s;
    box-shadow: 0 4px 14px rgba(192,57,43,0.35); margin-top: auto;
    font-family: 'Nunito', sans-serif;
}
.servicio-btn:hover { filter: brightness(1.1); transform: translateY(-1px); }
.servicio-btn-outline {
    background: transparent; border: 1px solid rgba(192,57,43,0.5);
    color: rgba(255,255,255,0.8); box-shadow: none;
}
.servicio-btn-outline:hover { background: rgba(192,57,43,0.1); border-color: rgba(192,57,43,0.8); }

@media (max-width: 1024px) { .servicios-grid { grid-template-columns: 1fr 1fr; } }
@media (max-width: 768px)  { .servicios-grid { grid-template-columns: 1fr; } }
</style>