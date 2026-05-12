<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link, router } from '@inertiajs/vue3';
import { ref, onMounted } from 'vue';

const showProfileMenu = ref(false);
const activeSection = ref('mision');
const visible = ref(false);

onMounted(() => {
    setTimeout(() => { visible.value = true; }, 100);
});

const logout = () => {
    router.post(route('logout'));
};

const values = [
    {
        icon: '🛡️',
        title: 'Seguridad',
        desc: 'La seguridad y bienestar de nuestros clientes es nuestra prioridad. Realizamos mantenimiento mecánico constante con personal profesional, capacitado y de confianza.',
    },
    {
        icon: '⚡',
        title: 'Eficiencia',
        desc: 'Maximizamos nuestros recursos cada día para brindar el mejor servicio de transporte de pasajeros y el más rápido servicio de carga y encomiendas a nivel nacional.',
    },
    {
        icon: '🤝',
        title: 'Respeto',
        desc: 'Entre todos los que conformamos la familia Trans. Copacabana S.A. y fundamentalmente hacia nuestros clientes.',
    },
    {
        icon: '❤️',
        title: 'Solidaridad',
        desc: 'Somos una empresa comprometida al servicio social mediante el apoyo silencioso y solidario a las causas necesitadas.',
    },
    {
        icon: '✨',
        title: 'Honestidad',
        desc: 'Un valor fundamental inculcado a los trabajadores y transmitido a nuestros clientes, proveedores y la comunidad en general.',
    },
];

const stats = [
    { number: '60+', label: 'Años de experiencia' },
    { number: '100%', label: 'Empresa boliviana' },
    { number: '9', label: 'Departamentos' },
    { number: '∞', label: 'Confianza' },
];
</script>

<template>
    <AuthenticatedLayout>
        <Head title="Dashboard — Trans. Copacabana S.A." />

        <div class="dashboard-root">

            <!-- ══ TOP NAVBAR ══ -->
            <nav class="topbar">
                <div class="topbar-left">
                    <img src="/images/logo.png" alt="Trans. Copacabana S.A." class="topbar-logo" />
                </div>
                <div class="topbar-right">
                    <!-- Profile dropdown -->
                    <div class="profile-wrapper" @click.stop="showProfileMenu = !showProfileMenu">
                        <div class="avatar">
                            {{ $page.props.auth.user.name.charAt(0).toUpperCase() }}
                        </div>
                        <div class="profile-info">
                            <span class="profile-name">{{ $page.props.auth.user.name }}</span>
                            <span class="profile-role">Miembro</span>
                        </div>
                        <svg class="chevron" :class="{ rotated: showProfileMenu }" xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="6 9 12 15 18 9"></polyline></svg>

                        <!-- Dropdown -->
                        <transition name="drop">
                            <div v-if="showProfileMenu" class="dropdown" @click.stop>
                                <Link :href="route('profile.edit')" class="dropdown-item">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path><circle cx="12" cy="7" r="4"></circle></svg>
                                    Mi Perfil
                                </Link>
                                <div class="dropdown-divider"></div>
                                <button @click="logout" class="dropdown-item dropdown-logout">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"></path><polyline points="16 17 21 12 16 7"></polyline><line x1="21" y1="12" x2="9" y2="12"></line></svg>
                                    Cerrar Sesión
                                </button>
                            </div>
                        </transition>
                    </div>
                </div>
            </nav>

            <!-- Backdrop to close menu -->
            <div v-if="showProfileMenu" class="backdrop" @click="showProfileMenu = false"></div>

            <!-- ══ HERO BANNER ══ -->
            <section class="hero" :class="{ 'hero-visible': visible }">
                <div class="hero-overlay"></div>
                <div class="hero-content">
                    <p class="hero-eyebrow">Bienvenido al Portal</p>
                    <h1 class="hero-title">Trans. Copacabana <span class="hero-accent">S.A.</span></h1>
                    <p class="hero-tagline">Más de 60 años haciendo Bolivia</p>
                    <div class="hero-divider"></div>
                    <p class="hero-sub">Empresa 100% boliviana uniendo el país a través de sus rutas</p>
                </div>

                <!-- Stats bar -->
                <div class="stats-bar">
                    <div v-for="s in stats" :key="s.label" class="stat-item">
                        <span class="stat-number">{{ s.number }}</span>
                        <span class="stat-label">{{ s.label }}</span>
                    </div>
                </div>
            </section>

            <!-- ══ MAIN CONTENT ══ -->
            <main class="main">

                <!-- Section: Quiénes Somos header -->
                <div class="section-header" :class="{ 'fade-up': visible }">
                    <span class="section-tag">Nuestra Empresa</span>
                    <h2 class="section-title">Quiénes Somos</h2>
                    <div class="section-rule"></div>
                </div>

                <!-- Mission / Vision tabs -->
                <div class="mv-tabs" :class="{ 'fade-up': visible }" style="animation-delay: 0.1s">
                    <button
                        class="mv-tab"
                        :class="{ active: activeSection === 'mision' }"
                        @click="activeSection = 'mision'"
                    >Misión</button>
                    <button
                        class="mv-tab"
                        :class="{ active: activeSection === 'vision' }"
                        @click="activeSection = 'vision'"
                    >Visión</button>
                </div>

                <transition name="slide-fade" mode="out-in">
                    <!-- MISIÓN -->
                    <div v-if="activeSection === 'mision'" key="mision" class="mv-card">
                        <div class="mv-icon">🚌</div>
                        <div class="mv-body">
                            <h3 class="mv-heading">Nuestra Misión</h3>
                            <p class="mv-text">
                                Trans. Copacabana S.A. busca la excelencia en servicios de transporte de carga y pasajeros
                                mediante el desarrollo de relaciones mutuamente gratificantes con nuestro equipo, clientes,
                                aliados y proveedores. La empresa está comprometida en brindar un servicio eficiente y de
                                valor añadido en el transporte de pasajeros, carga y encomiendas, ofreciendo calidad en el
                                servicio, garantizando la satisfacción y bienestar del cliente uniendo a Bolivia a través
                                de sus rutas de todo el territorio nacional.
                            </p>
                            <p class="mv-text mv-highlight">
                                Trans. Copacabana S.A. es una empresa <strong>100% boliviana</strong>, confiamos en nuestra
                                gente y buscamos ser el aliado logístico de los bolivianos en el transporte terrestre de
                                carga y pasajeros.
                            </p>
                        </div>
                    </div>

                    <!-- VISIÓN -->
                    <div v-else key="vision" class="mv-card">
                        <div class="mv-icon">🌐</div>
                        <div class="mv-body">
                            <h3 class="mv-heading">Nuestra Visión</h3>
                            <p class="mv-text">
                                Consolidarnos como <strong>pioneros del transporte terrestre en Bolivia</strong>,
                                continuamente expandiendo nuestras rutas, implementando nuevas tecnologías y mejorando
                                nuestros servicios para seguir integrando el país.
                            </p>
                        </div>
                    </div>
                </transition>

                <!-- Section: Valores -->
                <div class="section-header mt-section" :class="{ 'fade-up': visible }" style="animation-delay:0.2s">
                    <span class="section-tag">Nuestra Empresa</span>
                    <h2 class="section-title">Nuestros Valores</h2>
                    <div class="section-rule"></div>
                </div>

                <div class="values-grid">
                    <div
                        v-for="(v, i) in values"
                        :key="v.title"
                        class="value-card"
                        :class="{ 'fade-up': visible }"
                        :style="{ animationDelay: (0.15 * i + 0.3) + 's' }"
                    >
                        <div class="value-icon">{{ v.icon }}</div>
                        <h4 class="value-title">{{ v.title }}</h4>
                        <p class="value-desc">{{ v.desc }}</p>
                        <div class="value-accent"></div>
                    </div>
                </div>

            </main>

            <!-- ══ FOOTER ══ -->
            <footer class="site-footer">
                <p>© {{ new Date().getFullYear() }} Trans. Copacabana S.A. — Todos los derechos reservados.</p>
                <p class="footer-sub">Empresa 100% boliviana · Más de 60 años de servicio</p>
            </footer>

        </div>
    </AuthenticatedLayout>
</template>

<style scoped>
@import url('https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,700;0,900;1,700&family=Nunito:wght@400;500;600;700&display=swap');

/* ══ RESET & ROOT ══ */
*, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

.dashboard-root {
    min-height: 100vh;
    background: #0d1117;
    font-family: 'Nunito', sans-serif;
    color: #e2e8f0;
    overflow-x: hidden;
}

/* ══ TOPBAR ══ */
.topbar {
    position: fixed;
    top: 0; left: 0; right: 0;
    z-index: 100;
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 12px 40px;
    background: rgba(10, 12, 20, 0.85);
    backdrop-filter: blur(14px);
    border-bottom: 1px solid rgba(255,255,255,0.07);
}

.topbar-logo {
    height: 44px;
    width: auto;
    object-fit: contain;
    filter: drop-shadow(0 2px 4px rgba(0,0,0,0.5));
}

.topbar-right {
    display: flex;
    align-items: center;
    gap: 16px;
}

/* Profile */
.profile-wrapper {
    position: relative;
    display: flex;
    align-items: center;
    gap: 10px;
    cursor: pointer;
    padding: 6px 14px 6px 6px;
    border-radius: 50px;
    background: rgba(255,255,255,0.06);
    border: 1px solid rgba(255,255,255,0.1);
    transition: background 0.2s, border-color 0.2s;
    user-select: none;
}

.profile-wrapper:hover {
    background: rgba(255,255,255,0.1);
    border-color: rgba(192,57,43,0.5);
}

.avatar {
    width: 34px;
    height: 34px;
    border-radius: 50%;
    background: linear-gradient(135deg, #c0392b, #96281b);
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: 700;
    font-size: 0.9rem;
    color: #fff;
    flex-shrink: 0;
}

.profile-info {
    display: flex;
    flex-direction: column;
    line-height: 1.2;
}

.profile-name {
    font-size: 0.85rem;
    font-weight: 700;
    color: #fff;
}

.profile-role {
    font-size: 0.7rem;
    color: rgba(255,255,255,0.45);
}

.chevron {
    color: rgba(255,255,255,0.5);
    transition: transform 0.25s;
    flex-shrink: 0;
}

.chevron.rotated { transform: rotate(180deg); }

/* Dropdown */
.dropdown {
    position: absolute;
    top: calc(100% + 10px);
    right: 0;
    background: #1a1f2e;
    border: 1px solid rgba(255,255,255,0.1);
    border-radius: 12px;
    min-width: 180px;
    padding: 6px;
    box-shadow: 0 16px 40px rgba(0,0,0,0.5);
    z-index: 200;
}

.dropdown-item {
    display: flex;
    align-items: center;
    gap: 10px;
    padding: 10px 14px;
    border-radius: 8px;
    font-size: 0.85rem;
    font-weight: 600;
    color: rgba(255,255,255,0.75);
    text-decoration: none;
    cursor: pointer;
    background: none;
    border: none;
    width: 100%;
    text-align: left;
    font-family: 'Nunito', sans-serif;
    transition: background 0.15s, color 0.15s;
}

.dropdown-item:hover {
    background: rgba(255,255,255,0.07);
    color: #fff;
}

.dropdown-logout {
    color: #fca5a5;
}

.dropdown-logout:hover {
    background: rgba(192,57,43,0.15);
    color: #f87171;
}

.dropdown-divider {
    height: 1px;
    background: rgba(255,255,255,0.07);
    margin: 4px 0;
}

.backdrop {
    position: fixed;
    inset: 0;
    z-index: 99;
}

/* Dropdown animation */
.drop-enter-active { animation: dropIn 0.2s ease; }
.drop-leave-active { animation: dropIn 0.15s ease reverse; }
@keyframes dropIn {
    from { opacity: 0; transform: translateY(-8px) scale(0.97); }
    to   { opacity: 1; transform: translateY(0) scale(1); }
}

/* ══ HERO ══ */
.hero {
    position: relative;
    height: 520px;
    margin-top: 68px;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    background-image: url('https://images.unsplash.com/photo-1593642632559-0c6d3fc62b89?w=1600&q=80');
    background-size: cover;
    background-position: center;
    overflow: hidden;
    opacity: 0;
    transition: opacity 0.8s ease;
}

.hero-visible { opacity: 1; }

.hero-overlay {
    position: absolute;
    inset: 0;
    background: linear-gradient(
        160deg,
        rgba(8, 12, 30, 0.88) 0%,
        rgba(15, 25, 55, 0.75) 50%,
        rgba(70, 30, 10, 0.6) 100%
    );
}

.hero-content {
    position: relative;
    z-index: 2;
    text-align: center;
    padding: 0 20px;
}

.hero-eyebrow {
    font-size: 0.75rem;
    font-weight: 700;
    letter-spacing: 3px;
    text-transform: uppercase;
    color: rgba(192,57,43,0.9);
    margin-bottom: 12px;
}

.hero-title {
    font-family: 'Playfair Display', serif;
    font-size: clamp(2.2rem, 5vw, 4rem);
    font-weight: 900;
    color: #fff;
    line-height: 1.1;
    text-shadow: 0 4px 20px rgba(0,0,0,0.6);
}

.hero-accent { color: #e05c4b; }

.hero-tagline {
    font-size: 1rem;
    color: rgba(255,255,255,0.75);
    margin-top: 10px;
    font-weight: 500;
    letter-spacing: 0.5px;
}

.hero-divider {
    width: 60px;
    height: 2px;
    background: linear-gradient(90deg, #c0392b, transparent);
    margin: 18px auto;
}

.hero-sub {
    font-size: 0.88rem;
    color: rgba(255,255,255,0.5);
    max-width: 420px;
    margin: 0 auto;
    line-height: 1.6;
}

/* Stats bar */
.stats-bar {
    position: absolute;
    bottom: 0;
    left: 0; right: 0;
    z-index: 2;
    display: flex;
    justify-content: center;
    gap: 0;
    background: rgba(5, 8, 18, 0.75);
    backdrop-filter: blur(10px);
    border-top: 1px solid rgba(255,255,255,0.08);
}

.stat-item {
    flex: 1;
    max-width: 200px;
    display: flex;
    flex-direction: column;
    align-items: center;
    padding: 16px 8px;
    border-right: 1px solid rgba(255,255,255,0.06);
}

.stat-item:last-child { border-right: none; }

.stat-number {
    font-family: 'Playfair Display', serif;
    font-size: 1.8rem;
    font-weight: 700;
    color: #e05c4b;
    line-height: 1;
}

.stat-label {
    font-size: 0.7rem;
    color: rgba(255,255,255,0.45);
    font-weight: 600;
    letter-spacing: 0.5px;
    margin-top: 4px;
    text-transform: uppercase;
}

/* ══ MAIN ══ */
.main {
    max-width: 1100px;
    margin: 0 auto;
    padding: 64px 24px 80px;
}

/* Section header */
.section-header {
    text-align: center;
    margin-bottom: 36px;
}

.mt-section { margin-top: 80px; }

.section-tag {
    display: inline-block;
    font-size: 0.7rem;
    font-weight: 700;
    letter-spacing: 3px;
    text-transform: uppercase;
    color: #c0392b;
    margin-bottom: 10px;
}

.section-title {
    font-family: 'Playfair Display', serif;
    font-size: clamp(1.7rem, 3vw, 2.5rem);
    font-weight: 700;
    color: #fff;
    margin-bottom: 14px;
}

.section-rule {
    width: 48px;
    height: 3px;
    background: linear-gradient(90deg, #c0392b, transparent);
    margin: 0 auto;
    border-radius: 2px;
}

/* ══ MISSION / VISION TABS ══ */
.mv-tabs {
    display: flex;
    justify-content: center;
    gap: 8px;
    margin-bottom: 24px;
}

.mv-tab {
    padding: 9px 30px;
    border-radius: 50px;
    border: 1px solid rgba(255,255,255,0.15);
    background: transparent;
    color: rgba(255,255,255,0.5);
    font-family: 'Nunito', sans-serif;
    font-weight: 700;
    font-size: 0.88rem;
    cursor: pointer;
    transition: all 0.25s ease;
    letter-spacing: 0.3px;
}

.mv-tab.active {
    background: linear-gradient(135deg, #c0392b, #96281b);
    border-color: transparent;
    color: #fff;
    box-shadow: 0 4px 16px rgba(192,57,43,0.4);
}

.mv-tab:not(.active):hover {
    border-color: rgba(192,57,43,0.5);
    color: rgba(255,255,255,0.8);
}

/* ══ MV CARD ══ */
.mv-card {
    display: flex;
    gap: 32px;
    background: rgba(255,255,255,0.04);
    border: 1px solid rgba(255,255,255,0.08);
    border-radius: 20px;
    padding: 40px 44px;
    align-items: flex-start;
    transition: all 0.3s ease;
}

.mv-card:hover {
    background: rgba(255,255,255,0.06);
    border-color: rgba(192,57,43,0.3);
}

.mv-icon {
    font-size: 2.8rem;
    flex-shrink: 0;
    filter: drop-shadow(0 2px 6px rgba(0,0,0,0.4));
    margin-top: 4px;
}

.mv-body { flex: 1; }

.mv-heading {
    font-family: 'Playfair Display', serif;
    font-size: 1.4rem;
    font-weight: 700;
    color: #fff;
    margin-bottom: 16px;
}

.mv-text {
    font-size: 0.95rem;
    color: rgba(255,255,255,0.7);
    line-height: 1.8;
    margin-bottom: 14px;
}

.mv-text:last-child { margin-bottom: 0; }

.mv-highlight {
    border-left: 3px solid #c0392b;
    padding-left: 16px;
    color: rgba(255,255,255,0.8);
}

/* ══ VALUES GRID ══ */
.values-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
    gap: 20px;
}

.value-card {
    position: relative;
    background: rgba(255,255,255,0.04);
    border: 1px solid rgba(255,255,255,0.08);
    border-radius: 16px;
    padding: 32px 24px 28px;
    text-align: center;
    overflow: hidden;
    transition: transform 0.3s ease, border-color 0.3s ease, background 0.3s ease;
}

.value-card:hover {
    transform: translateY(-5px);
    background: rgba(255,255,255,0.07);
    border-color: rgba(192,57,43,0.4);
}

.value-card:hover .value-accent {
    opacity: 1;
    transform: scaleX(1);
}

.value-icon {
    font-size: 2.2rem;
    margin-bottom: 14px;
    display: block;
    filter: drop-shadow(0 2px 4px rgba(0,0,0,0.3));
}

.value-title {
    font-family: 'Playfair Display', serif;
    font-size: 1.1rem;
    font-weight: 700;
    color: #fff;
    margin-bottom: 10px;
}

.value-desc {
    font-size: 0.82rem;
    color: rgba(255,255,255,0.55);
    line-height: 1.7;
}

.value-accent {
    position: absolute;
    bottom: 0; left: 0; right: 0;
    height: 3px;
    background: linear-gradient(90deg, #c0392b, #e74c3c);
    opacity: 0;
    transform: scaleX(0.3);
    transition: opacity 0.3s ease, transform 0.3s ease;
    transform-origin: left;
}

/* ══ ANIMATIONS ══ */
.fade-up {
    animation: fadeUp 0.65s ease both;
}

@keyframes fadeUp {
    from { opacity: 0; transform: translateY(28px); }
    to   { opacity: 1; transform: translateY(0); }
}

.slide-fade-enter-active {
    animation: slideFadeIn 0.3s ease;
}
.slide-fade-leave-active {
    animation: slideFadeIn 0.2s ease reverse;
}

@keyframes slideFadeIn {
    from { opacity: 0; transform: translateX(12px); }
    to   { opacity: 1; transform: translateX(0); }
}

/* ══ FOOTER ══ */
.site-footer {
    text-align: center;
    padding: 32px 20px;
    background: rgba(0,0,0,0.3);
    border-top: 1px solid rgba(255,255,255,0.06);
    font-size: 0.8rem;
    color: rgba(255,255,255,0.25);
    line-height: 1.7;
}

.footer-sub {
    font-size: 0.72rem;
    color: rgba(255,255,255,0.15);
}

/* ══ RESPONSIVE ══ */
@media (max-width: 640px) {
    .topbar { padding: 12px 20px; }
    .profile-info { display: none; }
    .hero { height: 420px; }
    .stats-bar { flex-wrap: wrap; }
    .stat-item { min-width: 50%; border-bottom: 1px solid rgba(255,255,255,0.06); }
    .mv-card { flex-direction: column; padding: 28px 24px; gap: 16px; }
    .values-grid { grid-template-columns: 1fr 1fr; }
    .main { padding: 40px 16px 60px; }
}
</style>