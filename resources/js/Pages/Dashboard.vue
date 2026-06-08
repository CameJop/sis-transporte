<script setup>
import { Head, Link, router } from '@inertiajs/vue3';
import { ref, computed } from 'vue';

const props = defineProps({
    cliente: Object,
    boletos: Array,
    encomiendas: Array,
    facturas: Array,
});

const activeTab = ref('boletos');

const tabs = [
    { key: 'boletos',     label: 'Mis Boletos',     icon: '🎟️' },
    { key: 'encomiendas', label: 'Encomiendas',      icon: '📦' },
    { key: 'facturas',    label: 'Facturas',         icon: '🧾' },
];

const estadoBadge = (estado) => {
    const map = {
        PROGRAMADO:  { text: 'Programado',  color: '#1D9E75', bg: '#E1F5EE' },
        EN_CURSO:    { text: 'En curso',    color: '#185FA5', bg: '#E6F1FB' },
        FINALIZADO:  { text: 'Finalizado',  color: '#5F5E5A', bg: '#F1EFE8' },
        PENDIENTE:   { text: 'Pendiente',   color: '#BA7517', bg: '#FAEEDA' },
        ENTREGADO:   { text: 'Entregado',   color: '#1D9E75', bg: '#E1F5EE' },
        EN_TRANSITO: { text: 'En tránsito', color: '#185FA5', bg: '#E6F1FB' },
    };
    return map[estado?.toUpperCase()] ?? { text: estado ?? '—', color: '#888780', bg: '#F1EFE8' };
};

const logout = () => router.post(route('logout'));
</script>

<template>
    <Head title="Mi Cuenta — Trans. Copacabana" />

    <div class="root">

        <!-- TOPBAR -->
        <nav class="topbar">
            <Link :href="route('home')">
                <img src="/images/logo.png" alt="Trans. Copacabana S.A." class="logo" />
            </Link>
            <div class="topbar-right">
                <span class="user-name">{{ cliente.nombre }}</span>
                <button @click="logout" class="btn-logout">
                    <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"></path><polyline points="16 17 21 12 16 7"></polyline><line x1="21" y1="12" x2="9" y2="12"></line></svg>
                    Cerrar Sesión
                </button>
            </div>
        </nav>

        <main class="main">

            <!-- PERFIL -->
            <section class="profile-card">
                <div class="avatar">{{ cliente.nombre.charAt(0).toUpperCase() }}</div>
                <div class="profile-info">
                    <h1 class="profile-name">{{ cliente.nombre }}</h1>
                    <p class="profile-meta">CI: {{ cliente.documento_identidad ?? '—' }}</p>
                </div>
                <div class="profile-data">
                    <div class="profile-item">
                        <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07A19.5 19.5 0 0 1 4.11 13.5 19.79 19.79 0 0 1 1 4.84 2 2 0 0 1 2.96 2.68h3a2 2 0 0 1 2 1.72c.12.96.36 1.9.72 2.81a2 2 0 0 1-.45 2.11L7.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45c.91.36 1.85.6 2.81.72A2 2 0 0 1 21 16.92z"></path></svg>
                        {{ cliente.telefono ?? '—' }}
                    </div>
                    <div class="profile-item">
                        <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"></path><polyline points="22,6 12,13 2,6"></polyline></svg>
                        {{ cliente.email ?? '—' }}
                    </div>
                </div>
            </section>

            <!-- STATS -->
            <div class="stats-row">
                <div class="stat-card">
                    <span class="stat-num">{{ boletos.length }}</span>
                    <span class="stat-label">Boletos</span>
                </div>
                <div class="stat-card">
                    <span class="stat-num">{{ encomiendas.length }}</span>
                    <span class="stat-label">Encomiendas</span>
                </div>
                <div class="stat-card">
                    <span class="stat-num">{{ facturas.length }}</span>
                    <span class="stat-label">Facturas</span>
                </div>
                <div class="stat-card">
                    <span class="stat-num">
                        Bs {{ boletos.reduce((a, b) => a + parseFloat(b.precio || 0), 0).toFixed(2) }}
                    </span>
                    <span class="stat-label">Total gastado</span>
                </div>
            </div>

            <!-- TABS -->
            <div class="tabs">
                <button
                    v-for="tab in tabs"
                    :key="tab.key"
                    class="tab-btn"
                    :class="{ active: activeTab === tab.key }"
                    @click="activeTab = tab.key"
                >
                    {{ tab.icon }} {{ tab.label }}
                </button>
            </div>

            <!-- ── BOLETOS ── -->
            <div v-if="activeTab === 'boletos'">
                <div v-if="boletos.length === 0" class="empty">No tienes boletos registrados.</div>
                <div v-else class="cards-grid">
                    <div v-for="b in boletos" :key="b.id_boleto" class="ticket-card">
                        <div class="ticket-header">
                            <div>
                                <p class="ticket-route">
                                    {{ b.viaje?.ruta?.origen ?? '—' }}
                                    <span class="arrow">→</span>
                                    {{ b.viaje?.ruta?.destino ?? '—' }}
                                </p>
                                <p class="ticket-date">
                                    {{ b.viaje?.fecha_salida ?? '—' }} · {{ b.viaje?.hora_salida ?? '—' }}
                                </p>
                            </div>
                            <span class="badge" :style="{ color: estadoBadge(b.viaje?.estado).color, background: estadoBadge(b.viaje?.estado).bg }">
                                {{ estadoBadge(b.viaje?.estado).text }}
                            </span>
                        </div>
                        <div class="ticket-footer">
                            <div class="ticket-detail">
                                <span class="detail-label">Asiento</span>
                                <span class="detail-val">{{ b.asiento }}</span>
                            </div>
                            <div class="ticket-detail">
                                <span class="detail-label">Precio</span>
                                <span class="detail-val price">Bs {{ parseFloat(b.precio).toFixed(2) }}</span>
                            </div>
                            <div class="ticket-detail">
                                <span class="detail-label">Comprado</span>
                                <span class="detail-val">{{ b.fecha_compra ? new Date(b.fecha_compra).toLocaleDateString('es-BO') : '—' }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- ── ENCOMIENDAS ── -->
            <div v-if="activeTab === 'encomiendas'">
                <div v-if="encomiendas.length === 0" class="empty">No tienes encomiendas registradas.</div>
                <div v-else class="cards-grid">
                    <div v-for="e in encomiendas" :key="e.id_encomienda" class="ticket-card">
                        <div class="ticket-header">
                            <div>
                                <p class="ticket-route">
                                    {{ e.viaje?.ruta?.origen ?? '—' }}
                                    <span class="arrow">→</span>
                                    {{ e.viaje?.ruta?.destino ?? '—' }}
                                </p>
                                <p class="ticket-date">Envío: {{ e.fecha_envio ?? '—' }}</p>
                            </div>
                            <span class="badge" :style="{ color: estadoBadge(e.estado).color, background: estadoBadge(e.estado).bg }">
                                {{ estadoBadge(e.estado).text }}
                            </span>
                        </div>
                        <div class="ticket-footer">
                            <div class="ticket-detail">
                                <span class="detail-label">Remitente</span>
                                <span class="detail-val">{{ e.remitente?.nombre ?? '—' }}</span>
                            </div>
                            <div class="ticket-detail">
                                <span class="detail-label">Destinatario</span>
                                <span class="detail-val">{{ e.destinatario?.nombre ?? '—' }}</span>
                            </div>
                            <div class="ticket-detail">
                                <span class="detail-label">Peso</span>
                                <span class="detail-val">{{ e.peso ? e.peso + ' kg' : '—' }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- ── FACTURAS ── -->
            <div v-if="activeTab === 'facturas'">
                <div v-if="facturas.length === 0" class="empty">No tienes facturas registradas.</div>
                <div v-else class="cards-grid">
                    <div v-for="f in facturas" :key="f.id_factura" class="ticket-card">
                        <div class="ticket-header">
                            <div>
                                <p class="ticket-route">Factura #{{ f.id_factura }}</p>
                                <p class="ticket-date">{{ f.fecha ? new Date(f.fecha).toLocaleDateString('es-BO') : '—' }}</p>
                            </div>
                            <span class="badge" style="color:#1D9E75; background:#E1F5EE;">Emitida</span>
                        </div>
                        <div class="ticket-footer">
                            <div class="ticket-detail">
                                <span class="detail-label">Método de pago</span>
                                <span class="detail-val">{{ f.metodo_pago?.nombre ?? '—' }}</span>
                            </div>
                            <div class="ticket-detail">
                                <span class="detail-label">Atendido por</span>
                                <span class="detail-val">{{ f.empleado?.nombre ?? '—' }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </main>

        <footer class="site-footer">
            © {{ new Date().getFullYear() }} Trans. Copacabana S.A. · Empresa 100% boliviana
        </footer>
    </div>
</template>

<style scoped>
@import url('https://fonts.googleapis.com/css2?family=Playfair+Display:wght@700;900&family=Nunito:wght@400;500;600;700&display=swap');

*, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

.root {
    min-height: 100vh;
    background: #0d1117;
    font-family: 'Nunito', sans-serif;
    color: #e2e8f0;
}

/* TOPBAR */
.topbar {
    position: sticky;
    top: 0;
    z-index: 50;
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 12px 40px;
    background: rgba(10,12,20,0.9);
    backdrop-filter: blur(14px);
    border-bottom: 1px solid rgba(255,255,255,0.07);
}

.logo { height: 42px; object-fit: contain; filter: drop-shadow(0 2px 4px rgba(0,0,0,0.5)); }

.topbar-right { display: flex; align-items: center; gap: 16px; }

.user-name { font-size: 0.85rem; font-weight: 600; color: rgba(255,255,255,0.6); }

.btn-logout {
    display: flex;
    align-items: center;
    gap: 7px;
    padding: 7px 16px;
    border-radius: 50px;
    border: 1px solid rgba(255,255,255,0.12);
    background: transparent;
    color: rgba(255,255,255,0.55);
    font-family: 'Nunito', sans-serif;
    font-size: 0.82rem;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.2s;
}

.btn-logout:hover { background: rgba(192,57,43,0.15); border-color: rgba(192,57,43,0.4); color: #f87171; }

/* MAIN */
.main { max-width: 1000px; margin: 0 auto; padding: 48px 24px 80px; }

/* PERFIL */
.profile-card {
    display: flex;
    align-items: center;
    gap: 24px;
    background: rgba(255,255,255,0.04);
    border: 1px solid rgba(255,255,255,0.08);
    border-radius: 20px;
    padding: 32px 36px;
    margin-bottom: 28px;
    flex-wrap: wrap;
}

.avatar {
    width: 64px;
    height: 64px;
    border-radius: 50%;
    background: linear-gradient(135deg, #c0392b, #96281b);
    display: flex;
    align-items: center;
    justify-content: center;
    font-family: 'Playfair Display', serif;
    font-size: 1.8rem;
    font-weight: 700;
    color: #fff;
    flex-shrink: 0;
}

.profile-info { flex: 1; min-width: 160px; }

.profile-name {
    font-family: 'Playfair Display', serif;
    font-size: 1.5rem;
    font-weight: 700;
    color: #fff;
    margin-bottom: 4px;
}

.profile-meta { font-size: 0.82rem; color: rgba(255,255,255,0.4); }

.profile-data {
    display: flex;
    flex-direction: column;
    gap: 10px;
    min-width: 200px;
}

.profile-item {
    display: flex;
    align-items: center;
    gap: 8px;
    font-size: 0.85rem;
    color: rgba(255,255,255,0.55);
}

/* STATS */
.stats-row {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
    gap: 16px;
    margin-bottom: 36px;
}

.stat-card {
    background: rgba(255,255,255,0.04);
    border: 1px solid rgba(255,255,255,0.08);
    border-radius: 16px;
    padding: 24px 20px;
    text-align: center;
    transition: border-color 0.2s;
}

.stat-card:hover { border-color: rgba(192,57,43,0.35); }

.stat-num {
    display: block;
    font-family: 'Playfair Display', serif;
    font-size: 1.6rem;
    font-weight: 700;
    color: #e05c4b;
    line-height: 1;
    margin-bottom: 6px;
}

.stat-label { font-size: 0.75rem; color: rgba(255,255,255,0.4); text-transform: uppercase; letter-spacing: 0.5px; font-weight: 600; }

/* TABS */
.tabs {
    display: flex;
    gap: 8px;
    margin-bottom: 28px;
    flex-wrap: wrap;
}

.tab-btn {
    padding: 9px 22px;
    border-radius: 50px;
    border: 1px solid rgba(255,255,255,0.12);
    background: transparent;
    color: rgba(255,255,255,0.5);
    font-family: 'Nunito', sans-serif;
    font-weight: 700;
    font-size: 0.85rem;
    cursor: pointer;
    transition: all 0.22s;
}

.tab-btn.active {
    background: linear-gradient(135deg, #c0392b, #96281b);
    border-color: transparent;
    color: #fff;
    box-shadow: 0 4px 14px rgba(192,57,43,0.35);
}

.tab-btn:not(.active):hover { border-color: rgba(192,57,43,0.4); color: rgba(255,255,255,0.8); }

/* CARDS */
.cards-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
    gap: 18px;
}

.ticket-card {
    background: rgba(255,255,255,0.04);
    border: 1px solid rgba(255,255,255,0.08);
    border-radius: 16px;
    padding: 22px 24px;
    transition: transform 0.25s, border-color 0.25s, background 0.25s;
}

.ticket-card:hover {
    transform: translateY(-3px);
    background: rgba(255,255,255,0.07);
    border-color: rgba(192,57,43,0.35);
}

.ticket-header {
    display: flex;
    justify-content: space-between;
    align-items: flex-start;
    gap: 12px;
    margin-bottom: 18px;
}

.ticket-route {
    font-size: 0.95rem;
    font-weight: 700;
    color: #fff;
    margin-bottom: 4px;
}

.arrow { color: #e05c4b; margin: 0 4px; }

.ticket-date { font-size: 0.78rem; color: rgba(255,255,255,0.4); }

.badge {
    font-size: 0.72rem;
    font-weight: 700;
    padding: 4px 10px;
    border-radius: 50px;
    white-space: nowrap;
    flex-shrink: 0;
}

.ticket-footer {
    display: flex;
    flex-direction: column;
    gap: 10px;
    border-top: 1px solid rgba(255,255,255,0.06);
    padding-top: 16px;
}

.ticket-detail { display: flex; justify-content: space-between; align-items: center; }

.detail-label { font-size: 0.78rem; color: rgba(255,255,255,0.4); }

.detail-val { font-size: 0.85rem; font-weight: 600; color: rgba(255,255,255,0.8); }

.detail-val.price { color: #e05c4b; }

/* EMPTY */
.empty {
    text-align: center;
    padding: 60px 20px;
    color: rgba(255,255,255,0.3);
    font-size: 0.9rem;
}

/* FOOTER */
.site-footer {
    text-align: center;
    padding: 28px 20px;
    background: rgba(0,0,0,0.3);
    border-top: 1px solid rgba(255,255,255,0.06);
    font-size: 0.78rem;
    color: rgba(255,255,255,0.2);
}

@media (max-width: 640px) {
    .topbar { padding: 12px 20px; }
    .user-name { display: none; }
    .profile-card { flex-direction: column; padding: 24px 20px; }
    .stats-row { grid-template-columns: 1fr 1fr; }
    .main { padding: 32px 16px 60px; }
}
</style>