<script setup>
import { Head, Link } from '@inertiajs/vue3';

defineProps({
    canLogin: {
        type: Boolean,
    },
    canRegister: {
        type: Boolean,
    },
    laravelVersion: {
        type: String,
        required: true,
    },
    phpVersion: {
        type: String,
        required: true,
    },
});
</script>

<template>
    <Head title="Trans. Copacabana S.A." />

    <div class="welcome-wrapper">
        <!-- Background image overlay -->
        <div class="bg-overlay"></div>

        <!-- Top navbar -->
        <header class="navbar">
            <div class="navbar-logo">
                <img src="/images/logo.png" alt="Trans. Copacabana S.A." class="navbar-logo-img" />
            </div>

            <nav class="navbar-right">
                <div class="lang-selector">
                    <span>Español</span>
                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="6 9 12 15 18 9"></polyline></svg>
                </div>
                <div class="social-links">
                    <!-- Facebook -->
                    <a href="#" class="social-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="white"><path d="M18 2h-3a5 5 0 0 0-5 5v3H7v4h3v8h4v-8h3l1-4h-4V7a1 1 0 0 1 1-1h3z"></path></svg>
                    </a>
                    <!-- Instagram -->
                    <a href="#" class="social-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="2" y="2" width="20" height="20" rx="5" ry="5"></rect><path d="M16 11.37A4 4 0 1 1 12.63 8 4 4 0 0 1 16 11.37z"></path><line x1="17.5" y1="6.5" x2="17.51" y2="6.5"></line></svg>
                    </a>
                    <!-- YouTube -->
                    <a href="#" class="social-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="white"><path d="M22.54 6.42a2.78 2.78 0 0 0-1.95-1.96C18.88 4 12 4 12 4s-6.88 0-8.59.46a2.78 2.78 0 0 0-1.95 1.96A29 29 0 0 0 1 12a29 29 0 0 0 .46 5.58A2.78 2.78 0 0 0 3.41 19.6C5.12 20 12 20 12 20s6.88 0 8.59-.4a2.78 2.78 0 0 0 1.95-1.96A29 29 0 0 0 23 12a29 29 0 0 0-.46-5.58z"></path><polygon points="9.75 15.02 15.5 12 9.75 8.98 9.75 15.02" fill="#1a1a2e"></polygon></svg>
                    </a>
                </div>
            </nav>
        </header>

        <!-- Center card -->
        <main class="main-content">
            <div class="login-card">
                <!-- Logo inside card -->
                <div class="card-brand">
                    <img src="/images/logo.png" alt="Trans. Copacabana S.A." class="card-logo-img" />
                </div>

                <p class="card-subtitle">Más de 60 años haciendo Bolivia</p>

                <!-- Auth buttons -->
                <div v-if="canLogin" class="auth-buttons">
                    <Link
                        v-if="$page.props.auth.user"
                        :href="route('dashboard')"
                        class="btn btn-dashboard"
                    >
                        Dashboard
                    </Link>

                    <template v-else>
                        <Link
                            :href="route('login')"
                            class="btn btn-login"
                        >
                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M15 3h4a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2h-4"></path><polyline points="10 17 15 12 10 7"></polyline><line x1="15" y1="12" x2="3" y2="12"></line></svg>
                            Iniciar Sesión
                        </Link>

                        <Link
                            v-if="canRegister"
                            :href="route('register')"
                            class="btn btn-register"
                        >
                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M16 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path><circle cx="8.5" cy="7" r="4"></circle><line x1="20" y1="8" x2="20" y2="14"></line><line x1="23" y1="11" x2="17" y2="11"></line></svg>
                            Registrarse
                        </Link>
                    </template>
                </div>

                <p class="card-help">
                    ¿Necesitas ayuda? <a href="#" class="help-link">Contáctanos</a>
                </p>
            </div>
        </main>

        <!-- WhatsApp floating button -->
        <a href="#" class="whatsapp-btn" aria-label="WhatsApp">
            <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 24 24" fill="white">
                <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/>
            </svg>
        </a>

        <!-- Footer -->
        <footer class="site-footer">
            Laravel v{{ laravelVersion }} (PHP v{{ phpVersion }})
        </footer>
    </div>
</template>

<style scoped>
@import url('https://fonts.googleapis.com/css2?family=Great+Vibes&family=Cinzel:wght@600;700&family=Nunito:wght@400;500;600&display=swap');

* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
}

.welcome-wrapper {
    position: relative;
    min-height: 100vh;
    width: 100%;
    background-image: url('https://images.unsplash.com/photo-1593642632559-0c6d3fc62b89?w=1600&q=80');
    background-size: cover;
    background-position: center;
    font-family: 'Nunito', sans-serif;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    overflow: hidden;
}

.bg-overlay {
    position: absolute;
    inset: 0;
    background: linear-gradient(
        135deg,
        rgba(10, 15, 40, 0.82) 0%,
        rgba(20, 30, 70, 0.65) 50%,
        rgba(80, 40, 10, 0.45) 100%
    );
    z-index: 1;
}

/* ── Navbar ── */
.navbar {
    position: fixed;
    top: 0;
    left: 0;
    right: 0;
    z-index: 10;
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 18px 40px;
}

.navbar-logo {
    line-height: 1;
}

.navbar-logo-img {
    height: 48px;
    width: auto;
    object-fit: contain;
    filter: drop-shadow(1px 1px 3px rgba(0,0,0,0.5));
}

.navbar-right {
    display: flex;
    align-items: center;
    gap: 24px;
}

.lang-selector {
    display: flex;
    align-items: center;
    gap: 6px;
    color: #fff;
    font-size: 0.9rem;
    cursor: pointer;
    opacity: 0.9;
}

.social-links {
    display: flex;
    align-items: center;
    gap: 16px;
}

.social-icon {
    display: flex;
    align-items: center;
    opacity: 0.85;
    transition: opacity 0.2s;
}

.social-icon:hover {
    opacity: 1;
}

/* ── Main card ── */
.main-content {
    position: relative;
    z-index: 5;
    display: flex;
    align-items: center;
    justify-content: center;
    width: 100%;
    padding: 20px;
}

.login-card {
    background: rgba(5, 8, 20, 0.10);
    backdrop-filter: blur(6px);
    -webkit-backdrop-filter: blur(6px);
    border: 1px solid rgba(255, 255, 255, 0.15);
    border-radius: 20px;
    padding: 52px 56px;
    width: 100%;
    max-width: 440px;
    text-align: center;
    box-shadow: 0 24px 60px rgba(0, 0, 0, 0.2);
    animation: cardIn 0.6s ease both;
}

@keyframes cardIn {
    from { opacity: 0; transform: translateY(24px); }
    to   { opacity: 1; transform: translateY(0); }
}

/* ── Card brand ── */
.card-brand {
    display: flex;
    align-items: center;
    justify-content: center;
    margin-bottom: 10px;
}

.card-logo-img {
    height: 90px;
    width: auto;
    object-fit: contain;
    filter: drop-shadow(2px 2px 6px rgba(0,0,0,0.55));
}

.card-subtitle {
    color: rgba(255, 255, 255, 0.9);
    font-size: 0.92rem;
    margin-bottom: 36px;
    letter-spacing: 0.3px;
    text-shadow: 0 1px 4px rgba(0,0,0,0.7);
}

/* ── Auth buttons ── */
.auth-buttons {
    display: flex;
    flex-direction: column;
    gap: 12px;
    margin-bottom: 24px;
}

.btn {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 10px;
    padding: 13px 24px;
    border-radius: 50px;
    font-family: 'Nunito', sans-serif;
    font-weight: 600;
    font-size: 0.95rem;
    text-decoration: none;
    transition: all 0.25s ease;
    cursor: pointer;
}

.btn-login {
    background: #1a1e3a;
    color: #fff;
    border: 1px solid rgba(255, 255, 255, 0.15);
}

.btn-login:hover {
    background: #252a50;
    border-color: rgba(255, 255, 255, 0.3);
    transform: translateY(-1px);
    box-shadow: 0 6px 20px rgba(0, 0, 0, 0.35);
}

.btn-register {
    background: linear-gradient(135deg, #ff6b35, #f7931e);
    color: #fff;
    border: none;
}

.btn-register:hover {
    filter: brightness(1.1);
    transform: translateY(-1px);
    box-shadow: 0 6px 20px rgba(255, 107, 53, 0.45);
}

.btn-dashboard {
    background: linear-gradient(135deg, #ff6b35, #f7931e);
    color: #fff;
    border: none;
}

.btn-dashboard:hover {
    filter: brightness(1.1);
    transform: translateY(-1px);
}

/* ── Help text ── */
.card-help {
    color: rgba(255, 255, 255, 0.8);
    font-size: 0.82rem;
    text-shadow: 0 1px 3px rgba(0,0,0,0.6);
}

.help-link {
    color: rgba(255, 255, 255, 0.75);
    font-weight: 700;
    text-decoration: none;
    transition: color 0.2s;
}

.help-link:hover {
    color: #fff;
}

/* ── WhatsApp ── */
.whatsapp-btn {
    position: fixed;
    bottom: 28px;
    right: 28px;
    z-index: 20;
    background: #25d366;
    border-radius: 50%;
    width: 54px;
    height: 54px;
    display: flex;
    align-items: center;
    justify-content: center;
    box-shadow: 0 4px 16px rgba(37, 211, 102, 0.45);
    transition: transform 0.2s, box-shadow 0.2s;
}

.whatsapp-btn:hover {
    transform: scale(1.08);
    box-shadow: 0 6px 22px rgba(37, 211, 102, 0.6);
}

/* ── Footer ── */
.site-footer {
    position: fixed;
    bottom: 12px;
    left: 50%;
    transform: translateX(-50%);
    z-index: 5;
    color: rgba(255, 255, 255, 0.25);
    font-size: 0.72rem;
}
</style>