<template>
    <section id="nosotros" class="section section-dark">
        <div class="section-inner">
            <div class="section-header">
                <span class="section-tag">Nuestra Empresa</span>
                <h2 class="section-title">Quiénes Somos</h2>
                <div class="section-rule"></div>
            </div>

            <div class="nosotros-layout">
                <!-- Historia + Misión/Visión -->
                <div class="nosotros-text">
                    <div class="historia-block">
                        <h3 class="historia-title">Nuestra Historia</h3>
                        <p class="historia-p">Somos una empresa boliviana de transporte terrestre, fundada el <strong>5 de agosto de 1959</strong> en la ciudad de La Paz, recibiendo nuestro nombre en honor a la patrona de la empresa, la <strong>Virgen de Copacabana</strong>.</p>
                        <p class="historia-p">Inauguramos el servicio interdepartamental de pasajeros entre La Paz y Oruro, siendo <strong>pioneros en la introducción de omnibuses</strong> en el territorio boliviano. Desde entonces hemos extendido nuestros destinos a Cochabamba, Santa Cruz, Sucre, Potosí, Trinidad, Tarija, Villamontes, Camargo, El Alto y Yacuiba.</p>
                        <p class="historia-p">Hoy contamos con más de <strong>30 sucursales en toda Bolivia</strong>, viajamos 11 millones de kilómetros al año y transportamos aproximadamente un millón de pasajeros anualmente.</p>
                    </div>

                    <div class="mv-tabs-wrap">
                        <div class="mv-block">
                            <h4 class="mv-label">🎯 Misión</h4>
                            <p class="mv-p">Brindar un servicio eficiente y de valor añadido en el transporte de pasajeros, carga y encomiendas, ofreciendo calidad en el servicio, garantizando la satisfacción y bienestar del cliente, uniendo a Bolivia a través de sus rutas de todo el territorio nacional.</p>
                        </div>
                        <div class="mv-block">
                            <h4 class="mv-label">🌐 Visión</h4>
                            <p class="mv-p">Consolidarnos como pioneros del transporte terrestre en Bolivia, continuamente expandiendo nuestras rutas, implementando nuevas tecnologías y mejorando nuestros servicios para seguir integrando el país.</p>
                        </div>
                    </div>
                </div>

                <!-- Valores -->
                <div class="valores-wrap">
                    <h3 class="valores-heading">Nuestros Valores</h3>
                    <div class="valor-item" v-for="v in valores" :key="v.title">
                        <span class="valor-icon">{{ v.icon }}</span>
                        <div>
                            <h4 class="valor-title">{{ v.title }}</h4>
                            <p class="valor-desc">{{ v.desc }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</template>

<script setup>
const valores = [
    { icon: '🛡️', title: 'Seguridad',    desc: 'La seguridad y bienestar de nuestros clientes es nuestra prioridad absoluta.' },
    { icon: '⚡', title: 'Eficiencia',   desc: 'Maximizamos nuestros recursos para brindar el mejor servicio a nivel nacional.' },
    { icon: '🤝', title: 'Respeto',      desc: 'Entre todos los que conformamos la familia Trans. Copacabana S.A.' },
    { icon: '❤️', title: 'Solidaridad', desc: 'Comprometidos al servicio social y apoyo a las causas necesitadas.' },
    { icon: '✨', title: 'Honestidad',   desc: 'Un valor fundamental transmitido a clientes, proveedores y la comunidad.' },
];
</script>

<style scoped>
@import '@/Pages/Welcome/welcome.css';

.nosotros-layout { display: grid; grid-template-columns: 1fr 420px; gap: 56px; align-items: start; }

.historia-block  { margin-bottom: 40px; }
.historia-title  { font-family: 'Playfair Display', serif; font-size: 1.4rem; font-weight: 700; color: #fff; margin-bottom: 18px; }
.historia-p      { font-size: 0.92rem; color: rgba(255,255,255,0.65); line-height: 1.8; margin-bottom: 14px; }
.historia-p strong { color: rgba(255,255,255,0.9); }

.mv-tabs-wrap    { display: flex; flex-direction: column; gap: 16px; }
.mv-block {
    background: rgba(255,255,255,0.04); border: 1px solid rgba(255,255,255,0.08);
    border-left: 3px solid #c0392b; border-radius: 0 12px 12px 0;
    padding: 20px 24px;
}
.mv-label { font-weight: 700; font-size: 0.9rem; color: #fff; margin-bottom: 8px; }
.mv-p     { font-size: 0.85rem; color: rgba(255,255,255,0.6); line-height: 1.7; }

.valores-wrap {
    background: rgba(255,255,255,0.04); border: 1px solid rgba(255,255,255,0.08);
    border-radius: 20px; padding: 32px 28px;
}
.valores-heading { font-family: 'Playfair Display', serif; font-size: 1.2rem; font-weight: 700; color: #fff; margin-bottom: 24px; }
.valor-item {
    display: flex; align-items: flex-start; gap: 16px;
    padding: 16px 0; border-bottom: 1px solid rgba(255,255,255,0.06);
}
.valor-item:last-child { border-bottom: none; padding-bottom: 0; }
.valor-icon  { font-size: 1.5rem; flex-shrink: 0; margin-top: 2px; }
.valor-title { font-weight: 700; font-size: 0.9rem; color: #fff; margin-bottom: 4px; }
.valor-desc  { font-size: 0.8rem; color: rgba(255,255,255,0.45); line-height: 1.6; }

@media (max-width: 1024px) { .nosotros-layout { grid-template-columns: 1fr; } }
@media (max-width: 768px)  { .nosotros-layout { gap: 32px; } }
</style>