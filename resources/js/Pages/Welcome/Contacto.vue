<script setup>
import { Head } from '@inertiajs/vue3';
import AppLayout from '@/Pages/Welcome/AppLayout.vue';

const contactoItems = [
    {
        label: 'Atención al cliente',
        value: '+591 72 233 555',
        sub: 'WhatsApp disponible',
        icon: `<svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07A19.5 19.5 0 0 1 4.69 13a19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 3.62 2h3a2 2 0 0 1 2 1.72c.127.96.361 1.903.7 2.81a2 2 0 0 1-.45 2.11L7.91 9.91a16 16 0 0 0 6.12 6.12l.87-.87a2 2 0 0 1 2.11-.45c.907.339 1.85.573 2.81.7A2 2 0 0 1 22 16.92z"/></svg>`,
    },
    {
        label: 'Correo electrónico',
        value: 'info@transcopacabanasa.com',
        sub: 'Respondemos en 24 hrs',
        icon: `<svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/><polyline points="22,6 12,13 2,6"/></svg>`,
    },
    {
        label: 'Oficina Central',
        value: 'Calle Luis Uriona Nro. 1936',
        sub: 'Cochabamba, Bolivia',
        icon: `<svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/><circle cx="12" cy="10" r="3"/></svg>`,
    },
    {
        label: 'Carga y Encomiendas',
        value: '4250428 – 4235928',
        sub: 'Lunes a domingo',
        icon: `<svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="4" width="18" height="18" rx="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>`,
    },
];
</script>

<template>
    <Head title="Contacto — Trans. Copacabana S.A." />
    <AppLayout>
        <div class="page-top-pad">
            <section id="contacto" class="section section-dark">
                <div class="section-inner">
                    <div class="section-header">
                        <span class="section-tag">Estamos para ayudarte</span>
                        <h2 class="section-title">Contáctenos</h2>
                        <div class="section-rule"></div>
                    </div>

                    <div class="contacto-layout">
                        <!-- Info de contacto -->
                        <div class="contacto-info">
                            <div v-for="item in contactoItems" :key="item.label" class="contacto-item">
                                <div class="contacto-icon-wrap" v-html="item.icon"></div>
                                <div>
                                    <p class="contacto-label">{{ item.label }}</p>
                                    <p class="contacto-value">{{ item.value }}</p>
                                    <p class="contacto-sub">{{ item.sub }}</p>
                                </div>
                            </div>

                            <div class="redes-wrap">
                                <p class="redes-label">Síguenos en redes sociales</p>
                                <div class="redes-links">
                                    <a href="https://www.facebook.com/Transcopacabanasabolivia" target="_blank" class="red-btn">Facebook</a>
                                    <a href="https://www.instagram.com/transcopacabanasa/"      target="_blank" class="red-btn">Instagram</a>
                                    <a href="https://twitter.com/transcopasa"                   target="_blank" class="red-btn">Twitter</a>
                                    <a href="https://www.linkedin.com/company/trans-copacabana-sa/" target="_blank" class="red-btn">LinkedIn</a>
                                </div>
                            </div>
                        </div>

                        <!-- Formulario -->
                        <div class="contacto-form-wrap">
                            <h3 class="form-title">Envíanos un mensaje</h3>
                            <div class="form-field">
                                <label class="form-label">Nombre completo</label>
                                <input type="text" class="form-input" placeholder="Juan Pérez" />
                            </div>
                            <div class="form-field">
                                <label class="form-label">Correo electrónico</label>
                                <input type="email" class="form-input" placeholder="correo@ejemplo.com" />
                            </div>
                            <div class="form-field">
                                <label class="form-label">Asunto</label>
                                <select class="form-input">
                                    <option>Consulta sobre pasajes</option>
                                    <option>Carga y encomiendas</option>
                                    <option>Servicio corporativo</option>
                                    <option>Reclamo o sugerencia</option>
                                </select>
                            </div>
                            <div class="form-field">
                                <label class="form-label">Mensaje</label>
                                <textarea class="form-input form-textarea" placeholder="Escribe tu mensaje aquí..."></textarea>
                            </div>
                            <button class="btn-primary-lg">Enviar mensaje</button>
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

.contacto-layout { display: grid; grid-template-columns: 1fr 1fr; gap: 56px; align-items: start; }

.contacto-item { display: flex; align-items: flex-start; gap: 16px; margin-bottom: 28px; }
.contacto-icon-wrap {
    width: 44px; height: 44px; border-radius: 12px; flex-shrink: 0;
    background: rgba(192,57,43,0.1); border: 1px solid rgba(192,57,43,0.2);
    display: flex; align-items: center; justify-content: center; color: #e05c4b;
}
.contacto-label { font-size: 0.72rem; font-weight: 700; text-transform: uppercase; letter-spacing: 1.5px; color: rgba(255,255,255,0.35); margin-bottom: 4px; }
.contacto-value { font-weight: 700; font-size: 0.95rem; color: #fff; }
.contacto-sub   { font-size: 0.75rem; color: rgba(255,255,255,0.35); margin-top: 2px; }

.redes-wrap  { margin-top: 8px; }
.redes-label { font-size: 0.75rem; font-weight: 700; text-transform: uppercase; letter-spacing: 1.5px; color: rgba(255,255,255,0.35); margin-bottom: 12px; }
.redes-links { display: flex; gap: 10px; flex-wrap: wrap; }
.red-btn {
    padding: 7px 16px; border-radius: 8px;
    border: 1px solid rgba(255,255,255,0.12); color: rgba(255,255,255,0.55);
    font-size: 0.78rem; font-weight: 700; text-decoration: none;
    transition: border-color 0.2s, color 0.2s; font-family: 'Nunito', sans-serif;
}
.red-btn:hover { border-color: rgba(255,255,255,0.3); color: #fff; }

.contacto-form-wrap {
    background: rgba(255,255,255,0.04); border: 1px solid rgba(255,255,255,0.08);
    border-radius: 20px; padding: 36px 32px;
    display: flex; flex-direction: column; gap: 16px;
}
.form-title { font-family: 'Playfair Display', serif; font-size: 1.3rem; font-weight: 700; color: #fff; margin-bottom: 4px; }
.form-field { display: flex; flex-direction: column; gap: 6px; }
.form-label { font-size: 0.75rem; font-weight: 700; color: rgba(255,255,255,0.5); text-transform: uppercase; letter-spacing: 1px; }
.form-input {
    background: rgba(255,255,255,0.06); border: 1px solid rgba(255,255,255,0.12);
    border-radius: 10px; color: #fff;
    font-family: 'Nunito', sans-serif; font-size: 0.9rem;
    padding: 11px 14px; outline: none; transition: border-color 0.2s;
}
.form-input::placeholder { color: rgba(255,255,255,0.25); }
.form-input:focus { border-color: rgba(192,57,43,0.5); }
.form-textarea { resize: vertical; min-height: 110px; }

@media (max-width: 768px) { .contacto-layout { grid-template-columns: 1fr; } }
</style>