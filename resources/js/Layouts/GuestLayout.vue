<script setup>
defineProps({
    scrollable: {
        type: Boolean,
        default: false,
    },
});
</script>

<template>
    <div class="auth-page">

        <!-- Overlay multicapa: oscuro profundo + acento rojo sutil, igual que el hero -->
        <div class="bg-overlay"></div>

        <!-- Partículas decorativas de fondo -->
        <div class="bg-particles">
            <span class="particle p1"></span>
            <span class="particle p2"></span>
            <span class="particle p3"></span>
            <span class="particle p4"></span>
        </div>

        <!-- Franja lateral de marca -->
        <div class="brand-strip">
            <div class="brand-strip-inner">
                <span class="brand-strip-text">TRANS · COPACABANA · S.A. · DESDE 1959 · EMPRESA BOLIVIANA ·</span>
                <span class="brand-strip-text" aria-hidden="true">TRANS · COPACABANA · S.A. · DESDE 1959 · EMPRESA BOLIVIANA ·</span>
            </div>
        </div>

        <!-- Card principal -->
        <div class="auth-card" :class="{ 'auth-card--scrollable': scrollable }">

            <!-- Acento superior de la card -->
            <div class="card-top-accent"></div>

            <slot />

            <!-- Pie de la card -->
            <div class="card-footer-note">
                <span class="dot"></span>
                Empresa 100% boliviana
                <span class="dot"></span>
            </div>
        </div>

    </div>
</template>

<style>
@import url('https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,700;0,900&family=Nunito:wght@400;500;600;700&display=swap');

/* ══ RESET ══ */
*, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

/* ══ FONDO ══ */
.auth-page {
    position: fixed;
    inset: 0;
    display: flex;
    align-items: center;
    justify-content: center;
    background-color: #080c18;
    background-image:
        url('https://images.unsplash.com/photo-1544620347-c4fd4a3d5957?w=1920&q=80');
    background-size: cover;
    background-position: center;
    font-family: 'Nunito', sans-serif;
    overflow: hidden;
}

/* Mismo overlay cinematográfico que el Hero de Welcome */
.bg-overlay {
    position: absolute;
    inset: 0;
    background: linear-gradient(
        160deg,
        rgba(6,  9, 22, 0.93) 0%,
        rgba(12, 20, 48, 0.85) 45%,
        rgba(60, 20,  8, 0.70) 100%
    );
    z-index: 0;
}

/* ══ PARTÍCULAS ══ */
.bg-particles { position: absolute; inset: 0; z-index: 0; pointer-events: none; }

.particle {
    position: absolute;
    border-radius: 50%;
    background: radial-gradient(circle, rgba(192,57,43,0.18), transparent 70%);
    animation: floatParticle 12s ease-in-out infinite;
}
.p1 { width: 380px; height: 380px; top: -80px;  left: -100px; animation-delay: 0s;   animation-duration: 14s; }
.p2 { width: 260px; height: 260px; bottom: -60px; right: -60px; animation-delay: -4s;  animation-duration: 11s; }
.p3 { width: 160px; height: 160px; top: 40%;  left: 10%;  animation-delay: -7s;  animation-duration: 16s; background: radial-gradient(circle, rgba(30,60,120,0.15), transparent 70%); }
.p4 { width: 200px; height: 200px; top: 20%;  right: 8%;  animation-delay: -2s;  animation-duration: 13s; background: radial-gradient(circle, rgba(192,57,43,0.10), transparent 70%); }

@keyframes floatParticle {
    0%, 100% { transform: translateY(0) scale(1); }
    50%       { transform: translateY(-28px) scale(1.06); }
}

/* ══ FRANJA LATERAL MARQUEE ══ */
.brand-strip {
    position: absolute;
    left: 0; top: 0; bottom: 0;
    width: 28px;
    background: rgba(192, 57, 43, 0.12);
    border-right: 1px solid rgba(192, 57, 43, 0.2);
    overflow: hidden;
    z-index: 1;
    display: flex;
    align-items: center;
    justify-content: center;
}

.brand-strip-inner {
    display: flex;
    flex-direction: column;
    animation: scrollUp 18s linear infinite;
    gap: 0;
}

.brand-strip-text {
    font-size: 0.58rem;
    font-weight: 700;
    letter-spacing: 2.5px;
    text-transform: uppercase;
    color: rgba(192, 57, 43, 0.55);
    writing-mode: vertical-rl;
    text-orientation: mixed;
    white-space: nowrap;
    padding: 12px 0;
    line-height: 28px;
}

@keyframes scrollUp {
    0%   { transform: translateY(0); }
    100% { transform: translateY(-50%); }
}

/* ══ CARD ══ */
.auth-card {
    position: relative;
    z-index: 2;
    background: rgba(8, 12, 28, 0.55);
    backdrop-filter: blur(20px);
    -webkit-backdrop-filter: blur(20px);
    border: 1px solid rgba(255, 255, 255, 0.10);
    border-top: 1px solid rgba(255, 255, 255, 0.18);
    border-radius: 24px;
    padding: 44px 52px 36px;
    width: 100%;
    max-width: 440px;
    text-align: center;
    box-shadow:
        0 32px 80px rgba(0, 0, 0, 0.5),
        0 0 0 1px rgba(255,255,255,0.04) inset,
        0 1px 0 rgba(255,255,255,0.12) inset;
    animation: cardIn 0.6s cubic-bezier(0.22, 1, 0.36, 1) both;
}

@keyframes cardIn {
    from { opacity: 0; transform: translateY(32px) scale(0.97); }
    to   { opacity: 1; transform: translateY(0)    scale(1); }
}

/* Acento rojo superior (igual a section-rule de Welcome) */
.card-top-accent {
    position: absolute;
    top: 0; left: 50%;
    transform: translateX(-50%);
    width: 64px; height: 3px;
    background: linear-gradient(90deg, transparent, #c0392b, transparent);
    border-radius: 0 0 4px 4px;
}

/* Pie de card */
.card-footer-note {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
    margin-top: 20px;
    font-size: 0.65rem;
    font-weight: 700;
    letter-spacing: 2px;
    text-transform: uppercase;
    color: rgba(255, 255, 255, 0.18);
}
.dot {
    width: 4px; height: 4px;
    border-radius: 50%;
    background: rgba(192, 57, 43, 0.5);
    display: inline-block;
}

/* ══ CARD SCROLLABLE (Register) ══ */
.auth-card--scrollable {
    max-height: 90vh;
    overflow-y: auto;
    padding: 44px 52px 36px;
}
.auth-card--scrollable::-webkit-scrollbar       { width: 4px; }
.auth-card--scrollable::-webkit-scrollbar-track { background: transparent; }
.auth-card--scrollable::-webkit-scrollbar-thumb { background: rgba(192,57,43,0.3); border-radius: 2px; }

/* ══ MARCA / LOGO ══ */
.card-brand {
    display: flex;
    justify-content: center;
    margin-bottom: 16px;
}
.card-logo-img {
    height: 80px;
    width: auto;
    object-fit: contain;
    filter: drop-shadow(0 4px 12px rgba(0,0,0,0.6));
}

/* ══ ENCABEZADO ══ */
.card-header { margin-bottom: 28px; }

.card-title {
    font-family: 'Playfair Display', serif;   /* ← Igual que Welcome */
    font-size: 1.55rem;
    font-weight: 700;
    color: #fff;
    text-shadow: 0 2px 8px rgba(0,0,0,0.6);
    margin-bottom: 6px;
    line-height: 1.2;
}

.card-subtitle {
    font-size: 0.84rem;
    color: rgba(255, 255, 255, 0.5);
    line-height: 1.5;
}

/* ══ ESTADO ══ */
.status-msg {
    background: rgba(34, 197, 94, 0.1);
    border: 1px solid rgba(34, 197, 94, 0.35);
    color: #86efac;
    border-radius: 10px;
    padding: 10px 14px;
    font-size: 0.82rem;
    margin-bottom: 16px;
    text-align: left;
}

/* ══ FORMULARIO ══ */
.auth-form {
    display: flex;
    flex-direction: column;
    gap: 14px;
    text-align: left;
}
.field-group {
    display: flex;
    flex-direction: column;
    gap: 5px;
}

/* Label con section-tag del Welcome */
.field-label {
    font-size: 0.68rem !important;
    font-weight: 700 !important;
    letter-spacing: 1.5px !important;
    text-transform: uppercase !important;
    color: rgba(255, 255, 255, 0.5) !important;
}

.field-input {
    width: 100%;
    padding: 11px 16px;
    background: rgba(255, 255, 255, 0.06) !important;
    border: 1px solid rgba(255, 255, 255, 0.12) !important;
    border-radius: 12px !important;
    color: #fff !important;
    font-size: 0.9rem;
    font-family: 'Nunito', sans-serif;
    transition: border-color 0.2s, background 0.2s, box-shadow 0.2s;
    outline: none;
}
.field-input::placeholder { color: rgba(255,255,255,0.22); }
.field-input:focus {
    background: rgba(255, 255, 255, 0.09) !important;
    border-color: rgba(192, 57, 43, 0.65) !important;
    box-shadow: 0 0 0 3px rgba(192,57,43,0.12);
}

/* ══ INPUT CON ICONO ══ */
.input-wrapper                { position: relative; }
.input-wrapper .field-input   { padding-right: 44px; }
.eye-btn {
    position: absolute;
    right: 12px; top: 50%;
    transform: translateY(-50%);
    background: none; border: none;
    cursor: pointer; font-size: 1rem;
    line-height: 1; padding: 2px; color: #fff;
}

/* ══ BOTÓN PRINCIPAL ══ */
.btn-primary {
    width: 100%;
    padding: 13px;
    background: linear-gradient(135deg, #c0392b, #96281b);
    color: #fff;
    border: none;
    border-radius: 50px;
    font-family: 'Nunito', sans-serif;
    font-weight: 700;
    font-size: 0.95rem;
    cursor: pointer;
    transition: filter 0.25s, transform 0.25s, box-shadow 0.25s;
    margin-top: 6px;
    box-shadow: 0 4px 20px rgba(192,57,43,0.35);
    letter-spacing: 0.3px;
}
.btn-primary:hover:not(:disabled) {
    filter: brightness(1.12);
    transform: translateY(-2px);
    box-shadow: 0 8px 28px rgba(192,57,43,0.55);
}
.btn-disabled { opacity: 0.35; cursor: not-allowed; }

/* ══ ENLACES ══ */
.switch-link {
    text-align: center;
    font-size: 0.82rem;
    color: rgba(255,255,255,0.4);
}
.link-accent {
    color: rgba(255,255,255,0.85);
    font-weight: 700;
    text-decoration: underline;
    transition: color 0.2s;
}
.link-accent:hover { color: #e8a89c; }

/* ══ RECORDARME ══ */
.remember-row {
    display: flex;
    align-items: center;
    justify-content: space-between;
    font-size: 0.82rem;
}
.remember-label {
    display: flex; align-items: center; gap: 8px;
    color: rgba(255,255,255,0.6); cursor: pointer;
}
.forgot-link {
    color: rgba(255,255,255,0.45);
    text-decoration: underline;
    font-size: 0.78rem;
    transition: color 0.2s;
}
.forgot-link:hover { color: #fff; }

/* ══ HINT CAMPO ══ */
.field-hint {
    font-size: 0.72rem;
    color: rgba(255,255,255,0.28);
    line-height: 1.45;
    margin-top: 3px;
}

/* ══ RESPONSIVE ══ */
@media (max-width: 520px) {
    .auth-card { padding: 36px 28px 28px; border-radius: 18px; }
    .brand-strip { display: none; }
    .card-title { font-size: 1.35rem; }
}
</style>