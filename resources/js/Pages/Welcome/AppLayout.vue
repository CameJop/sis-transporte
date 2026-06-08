<template>
    <div class="root">

        <!-- ══ NAVBAR ══ -->
        <nav class="navbar">
            <div class="navbar-inner">
                <div class="navbar-left">
                    <Link href="/" class="navbar-logo-link">
                        <img src="/images/logo.png" alt="Trans. Copacabana S.A." class="navbar-logo" />
                    </Link>
                    <Link href="/" class="nav-link nav-link-inicio" :class="{ 'nav-link-active': isActive('/') }">Inicio</Link>
                    <div class="nav-links">
                        <Link href="/destinos"   class="nav-link" :class="{ 'nav-link-active': isActive('/destinos') }">Destinos</Link>
                        <Link href="/horarios"   class="nav-link" :class="{ 'nav-link-active': isActive('/horarios') }">Horarios</Link>
                        <Link href="/servicios"  class="nav-link" :class="{ 'nav-link-active': isActive('/servicios') }">Servicios</Link>
                        <Link href="/flota"      class="nav-link" :class="{ 'nav-link-active': isActive('/flota') }">Nuestra Flota</Link>
                        <Link href="/sucursales" class="nav-link" :class="{ 'nav-link-active': isActive('/sucursales') }">Sucursales</Link>
                        <Link href="/contacto"   class="nav-link" :class="{ 'nav-link-active': isActive('/contacto') }">Contacto</Link>
                    </div>
                </div>
                <div class="navbar-right">
                    <a href="/login" class="btn-cuenta">
                        <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24"
                            fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round">
                            <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                            <circle cx="12" cy="7" r="4"></circle>
                        </svg>
                        Mi Cuenta
                    </a>
                    <!-- Menú hamburguesa móvil -->
                    <button class="hamburger" @click="menuOpen = !menuOpen" aria-label="Menú">
                        <span></span><span></span><span></span>
                    </button>
                </div>
            </div>

            <!-- Menú móvil -->
            <div class="mobile-menu" :class="{ 'mobile-menu-open': menuOpen }">
                <Link href="/"           class="mobile-link" @click="menuOpen = false">Inicio</Link>
                <Link href="/destinos"   class="mobile-link" @click="menuOpen = false">Destinos</Link>
                <Link href="/horarios"   class="mobile-link" @click="menuOpen = false">Horarios</Link>
                <Link href="/servicios"  class="mobile-link" @click="menuOpen = false">Servicios</Link>
                <Link href="/flota"      class="mobile-link" @click="menuOpen = false">Nuestra Flota</Link>
                <Link href="/sucursales" class="mobile-link" @click="menuOpen = false">Sucursales</Link>
                <Link href="/contacto"   class="mobile-link" @click="menuOpen = false">Contacto</Link>
                <a href="/login"         class="mobile-link mobile-link-cta">Mi Cuenta</a>
            </div>
        </nav>

        <!-- ══ CONTENIDO DE LA PÁGINA ══ -->
        <main>
            <slot />
        </main>

        <!-- ══ FOOTER ══ -->
        <footer class="footer">
            <div class="footer-inner">
                <div class="footer-brand">
                    <Link href="/">
                        <img src="/images/logo.png" alt="Trans. Copacabana S.A." class="footer-logo" />
                    </Link>
                    <p class="footer-tagline">Empresa 100% boliviana con más de 65 años conectando el país.</p>
                </div>
                <div class="footer-col">
                    <h4 class="footer-col-title">Navegación</h4>
                    <Link href="/destinos"   class="footer-link">Destinos</Link>
                    <Link href="/horarios"   class="footer-link">Horarios</Link>
                    <Link href="/servicios"  class="footer-link">Servicios</Link>
                    <Link href="/flota"      class="footer-link">Nuestra Flota</Link>
                    <Link href="/sucursales" class="footer-link">Sucursales</Link>
                    <Link href="/contacto"   class="footer-link">Contacto</Link>
                </div>
                <div class="footer-col">
                    <h4 class="footer-col-title">Servicios</h4>
                    <a href="/login"         class="footer-link">Comprar pasaje</a>
                    <a href="/login"         class="footer-link">Rastrear envío</a>
                    <Link href="/contacto"   class="footer-link">Carga y encomiendas</Link>
                    <Link href="/contacto"   class="footer-link">Servicio corporativo</Link>
                    <a href="/login"         class="footer-link">Mi cuenta</a>
                </div>
                <div class="footer-col">
                    <h4 class="footer-col-title">Contacto</h4>
                    <p class="footer-link">+591 72 233 555</p>
                    <p class="footer-link">info@transcopacabanasa.com</p>
                    <p class="footer-link">Calle Luis Uriona Nro. 1936</p>
                    <p class="footer-link">Cochabamba, Bolivia</p>
                </div>
            </div>
            <div class="footer-bottom">
                <p>© {{ new Date().getFullYear() }} Trans. Copacabana S.A. — Todos los derechos reservados.</p>
                <p>Empresa 100% boliviana · Fundada el 5 de agosto de 1959</p>
            </div>
        </footer>

    </div>
</template>

<script setup>
import { ref } from 'vue';
import { Link, usePage } from '@inertiajs/vue3';

const menuOpen = ref(false);
const page = usePage();

function isActive(path) {
    const current = page.url;
    if (path === '/') return current === '/';
    return current.startsWith(path);
}
</script>

<style scoped>
@import url('https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,700;0,900;1,700&family=Nunito:wght@400;500;600;700&display=swap');

*, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

.root {
    min-height: 100vh;
    background: #0d1117;
    font-family: 'Nunito', sans-serif;
    color: #e2e8f0;
    overflow-x: hidden;
}

/* ══ NAVBAR ══ */
.navbar {
    position: fixed; top: 0; left: 0; right: 0; z-index: 200;
    background: rgba(9, 11, 20, 0.88);
    backdrop-filter: blur(16px);
    border-bottom: 1px solid rgba(255,255,255,0.07);
}
.navbar-inner {
    max-width: 1280px; margin: 0 auto;
    padding: 10px 36px;
    display: flex; align-items: center; justify-content: space-between;
}
.navbar-left  { display: flex; align-items: center; gap: 28px; }
.navbar-logo-link { display: flex; align-items: center; text-decoration: none; flex-shrink: 0; }
.navbar-logo  { height: 42px; width: auto; filter: drop-shadow(0 2px 4px rgba(0,0,0,0.5)); }
.nav-link-inicio { margin-right: 8px; border-right: 1px solid rgba(255,255,255,0.1); padding-right: 20px !important; border-radius: 0 !important; }
.nav-link-inicio:hover { background: transparent !important; }
.nav-links    { display: flex; align-items: center; gap: 2px; }
.nav-link {
    padding: 7px 13px; border-radius: 8px;
    font-size: 0.8rem; font-weight: 600;
    color: rgba(255,255,255,0.55); text-decoration: none;
    transition: color 0.2s, background 0.2s; white-space: nowrap;
}
.nav-link:hover { color: #fff; background: rgba(255,255,255,0.07); }
.nav-link-active { color: #e05c4b !important; background: rgba(192,57,43,0.1) !important; }

.navbar-right { display: flex; align-items: center; gap: 12px; }
.btn-cuenta {
    display: flex; align-items: center; gap: 8px;
    padding: 8px 20px; border-radius: 50px;
    background: linear-gradient(135deg, #c0392b, #96281b);
    color: #fff; font-weight: 700; font-size: 0.84rem;
    text-decoration: none;
    transition: filter 0.2s, transform 0.2s, box-shadow 0.2s;
    box-shadow: 0 4px 14px rgba(192,57,43,0.35);
}
.btn-cuenta:hover { filter: brightness(1.1); transform: translateY(-1px); }

/* Hamburguesa */
.hamburger {
    display: none; flex-direction: column; justify-content: center; gap: 5px;
    background: none; border: none; cursor: pointer; padding: 6px;
}
.hamburger span {
    display: block; width: 22px; height: 2px;
    background: rgba(255,255,255,0.7); border-radius: 2px;
    transition: background 0.2s;
}
.hamburger:hover span { background: #fff; }

/* Menú móvil */
.mobile-menu {
    display: none; flex-direction: column; gap: 2px;
    padding: 8px 16px 12px; border-top: 1px solid rgba(255,255,255,0.06);
    background: rgba(9,11,20,0.97);
}
.mobile-menu-open { display: flex; }
.mobile-link {
    padding: 11px 14px; border-radius: 8px;
    color: rgba(255,255,255,0.65); text-decoration: none;
    font-weight: 600; font-size: 0.9rem;
    transition: background 0.2s, color 0.2s;
}
.mobile-link:hover { background: rgba(255,255,255,0.06); color: #fff; }
.mobile-link-cta {
    margin-top: 6px;
    background: linear-gradient(135deg, #c0392b, #96281b);
    color: #fff !important; text-align: center; border-radius: 50px;
}

/* ══ FOOTER ══ */
.footer { background: #060810; border-top: 1px solid rgba(255,255,255,0.06); }
.footer-inner {
    max-width: 1200px; margin: 0 auto;
    padding: 60px 36px 40px;
    display: grid; grid-template-columns: 1.5fr 1fr 1fr 1fr; gap: 40px;
}
.footer-logo    { height: 50px; width: auto; margin-bottom: 14px; filter: drop-shadow(0 2px 4px rgba(0,0,0,0.5)); }
.footer-tagline { font-size: 0.82rem; color: rgba(255,255,255,0.35); line-height: 1.7; }
.footer-col     { display: flex; flex-direction: column; gap: 10px; }
.footer-col-title { font-weight: 700; font-size: 0.8rem; text-transform: uppercase; letter-spacing: 2px; color: rgba(255,255,255,0.45); margin-bottom: 6px; }
.footer-link { font-size: 0.82rem; color: rgba(255,255,255,0.35); text-decoration: none; transition: color 0.2s; }
a.footer-link:hover { color: rgba(255,255,255,0.8); }
.footer-bottom {
    max-width: 1200px; margin: 0 auto;
    padding: 20px 36px; border-top: 1px solid rgba(255,255,255,0.05);
    display: flex; flex-direction: column; gap: 4px;
    font-size: 0.75rem; color: rgba(255,255,255,0.18); line-height: 1.7;
}

/* ══ RESPONSIVE ══ */
@media (max-width: 900px) {
    .nav-links { display: none; }
    .hamburger { display: flex; }
}
@media (max-width: 500px) {
    .footer-inner { grid-template-columns: 1fr; }
    .navbar-inner { padding: 10px 20px; }
    .btn-cuenta { display: none; }
}
</style>