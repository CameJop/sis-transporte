<script setup>
import { Head, Link } from '@inertiajs/vue3';
import AppLayout from '@/Pages/Welcome/AppLayout.vue';
</script>

<template>
    <Head title="Trans. Copacabana S.A. — Conectando Bolivia desde 1959" />
    <AppLayout>

        <!-- ══ HERO ══ -->
        <section class="hero">
            <div class="hero-overlay"></div>
            <div class="hero-content">
                <p class="hero-eyebrow">Empresa boliviana de transporte terrestre</p>
                <h1 class="hero-title">Conectando Bolivia<br /><span class="hero-accent">desde 1959</span></h1>
                <p class="hero-sub">Más de 65 años siendo la empresa pionera en transporte de pasajeros,<br />carga y encomiendas en todo el territorio nacional.</p>

                <div class="search-box">
                    <div class="search-field">
                        <label class="search-label">Origen</label>
                        <select class="search-select">
                            <option>Cochabamba</option>
                            <option>La Paz</option>
                            <option>Santa Cruz</option>
                            <option>Oruro</option>
                            <option>Sucre</option>
                            <option>Potosí</option>
                            <option>Tarija</option>
                        </select>
                    </div>
                    <div class="search-divider">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M5 12h14M12 5l7 7-7 7"/>
                        </svg>
                    </div>
                    <div class="search-field">
                        <label class="search-label">Destino</label>
                        <select class="search-select">
                            <option>La Paz</option>
                            <option>Cochabamba</option>
                            <option>Santa Cruz</option>
                            <option>Oruro</option>
                            <option>Sucre</option>
                            <option>Tarija</option>
                            <option>Trinidad</option>
                            <option>Yacuiba</option>
                        </select>
                    </div>
                    <div class="search-field">
                        <label class="search-label">Fecha</label>
                        <input type="date" class="search-select" />
                    </div>
                    <button class="search-btn">Buscar Pasaje</button>
                </div>
            </div>

            <div class="stats-bar">
                <div class="stat-item">
                    <span class="stat-num">65+</span>
                    <span class="stat-lbl">Años de experiencia</span>
                </div>
                <div class="stat-item">
                    <span class="stat-num">1M+</span>
                    <span class="stat-lbl">Pasajeros al año</span>
                </div>
                <div class="stat-item">
                    <span class="stat-num">11M km</span>
                    <span class="stat-lbl">Recorridos anuales</span>
                </div>
                <div class="stat-item">
                    <span class="stat-num">30+</span>
                    <span class="stat-lbl">Sucursales en Bolivia</span>
                </div>
                <div class="stat-item">
                    <span class="stat-num">9</span>
                    <span class="stat-lbl">Departamentos</span>
                </div>
            </div>
        </section>

        <!-- ══ HISTORIA ══ -->
        <section class="section section-dark" id="nosotros">
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

    </AppLayout>
</template>

<script>
const valores = [
    { icon: '🛡️', title: 'Seguridad',    desc: 'La seguridad y bienestar de nuestros clientes es nuestra prioridad absoluta.' },
    { icon: '⚡', title: 'Eficiencia',   desc: 'Maximizamos nuestros recursos para brindar el mejor servicio a nivel nacional.' },
    { icon: '🤝', title: 'Respeto',      desc: 'Entre todos los que conformamos la familia Trans. Copacabana S.A.' },
    { icon: '❤️', title: 'Solidaridad', desc: 'Comprometidos al servicio social y apoyo a las causas necesitadas.' },
    { icon: '✨', title: 'Honestidad',   desc: 'Un valor fundamental transmitido a clientes, proveedores y la comunidad.' },
];
export default { data: () => ({ valores }) };
</script>

<style scoped>
@import url('https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,700;0,900;1,700&family=Nunito:wght@400;500;600;700&display=swap');
@import '@/Pages/Welcome/welcome.css';

/* ══ HERO ══ */
.hero {
    position: relative; min-height: 100vh;
    display: flex; flex-direction: column;
    align-items: center; justify-content: center;
    background-image: url('https://images.unsplash.com/photo-1544620347-c4fd4a3d5957?w=1920&q=85');
    background-size: cover; background-position: center;
    padding-top: 68px;
}
.hero-overlay {
    position: absolute; inset: 0;
    background: linear-gradient(160deg, rgba(6,9,22,0.93) 0%, rgba(12,20,48,0.82) 45%, rgba(60,20,8,0.65) 100%);
}
.hero-content {
    position: relative; z-index: 2;
    text-align: center; padding: 0 24px;
    max-width: 860px;
}
.hero-eyebrow {
    font-size: 0.7rem; font-weight: 700;
    letter-spacing: 4px; text-transform: uppercase;
    color: rgba(192,57,43,0.85); margin-bottom: 16px;
}
.hero-title {
    font-family: 'Playfair Display', serif;
    font-size: clamp(2.8rem, 6vw, 5rem);
    font-weight: 900; color: #fff; line-height: 1.08;
    text-shadow: 0 4px 24px rgba(0,0,0,0.7); margin-bottom: 20px;
}
.hero-accent { color: #e05c4b; }
.hero-sub {
    font-size: 1rem; color: rgba(255,255,255,0.6);
    line-height: 1.7; margin-bottom: 44px;
    max-width: 600px; margin-inline: auto;
}

/* Search box */
.search-box {
    display: flex; align-items: flex-end; flex-wrap: wrap; gap: 16px;
    background: rgba(255,255,255,0.07);
    backdrop-filter: blur(12px);
    border: 1px solid rgba(255,255,255,0.12);
    border-radius: 16px; padding: 20px 24px;
}
.search-field  { display: flex; flex-direction: column; gap: 6px; flex: 1; min-width: 140px; }
.search-label  { font-size: 0.68rem; font-weight: 700; letter-spacing: 2px; text-transform: uppercase; color: rgba(255,255,255,0.45); }
.search-select {
    background: rgba(255,255,255,0.08); border: 1px solid rgba(255,255,255,0.14);
    border-radius: 10px; color: #fff;
    font-family: 'Nunito', sans-serif; font-size: 0.9rem; font-weight: 600;
    padding: 10px 14px; outline: none; cursor: pointer;
    transition: border-color 0.2s, background 0.2s;
}
.search-select:focus { background: rgba(255,255,255,0.12); border-color: rgba(192,57,43,0.6); }
.search-select option { background: #1a1f2e; color: #fff; }
.search-divider {
    display: flex; align-items: flex-end; padding-bottom: 10px;
    color: rgba(255,255,255,0.3); flex-shrink: 0;
}
.search-btn {
    padding: 11px 28px; background: linear-gradient(135deg, #c0392b, #96281b);
    color: #fff; border: none; border-radius: 10px;
    font-family: 'Nunito', sans-serif; font-weight: 700; font-size: 0.9rem;
    cursor: pointer; transition: filter 0.2s, transform 0.2s;
    white-space: nowrap; align-self: flex-end;
    box-shadow: 0 4px 16px rgba(192,57,43,0.4);
}
.search-btn:hover { filter: brightness(1.1); transform: translateY(-1px); }

/* Stats bar */
.stats-bar {
    position: relative; z-index: 2;
    width: 100%; display: flex; justify-content: center; flex-wrap: wrap;
    background: rgba(5,8,18,0.8); backdrop-filter: blur(12px);
    border-top: 1px solid rgba(255,255,255,0.07);
    margin-top: 60px;
}
.stat-item {
    flex: 1; min-width: 150px; max-width: 220px;
    display: flex; flex-direction: column; align-items: center;
    padding: 20px 12px;
    border-right: 1px solid rgba(255,255,255,0.06);
}
.stat-item:last-child { border-right: none; }
.stat-num { font-family: 'Playfair Display', serif; font-size: 2rem; font-weight: 700; color: #e05c4b; line-height: 1; }
.stat-lbl { font-size: 0.68rem; color: rgba(255,255,255,0.4); font-weight: 700; letter-spacing: 0.5px; text-transform: uppercase; margin-top: 5px; }

/* ══ NOSOTROS (Historia, Misión, Visión, Valores) ══ */
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
@media (max-width: 768px) {
    .hero-title { font-size: 2.4rem; }
    .search-box { flex-direction: column; }
    .stat-item { min-width: 50%; }
    .nosotros-layout { gap: 32px; }
}
</style>