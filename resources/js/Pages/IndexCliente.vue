<script setup>
import { Head, router, useForm, usePage } from '@inertiajs/vue3';
import { ref, computed } from 'vue';

const props = defineProps({
    cliente: Object,
    boletos: Array,
    encomiendas: Array,
    facturas: Array,
    stats: Object,
});

// Nombre del usuario autenticado (de users.name, no de cliente.nombre)
const authUser = usePage().props.auth.user;

// ── Tabs ──────────────────────────────────────────────────────────────────────
const activeTab = ref('viajes');
const tabs = [
    { key: 'viajes',      label: 'Mis viajes',  icon: '🚌' },
    { key: 'encomiendas', label: 'Encomiendas', icon: '📦' },
    { key: 'facturas',    label: 'Facturas',    icon: '🧾' },
    { key: 'pasajero',    label: 'Pasajero',    icon: '🪪' },
];

// ── Badge helper ──────────────────────────────────────────────────────────────
const estadoBadge = (estado) => {
    const map = {
        PROGRAMADO: 'badge-green',
        EN_CURSO:   'badge-blue',
        FINALIZADO: 'badge-gray',
        Pagado:     'badge-green',
        Pendiente:  'badge-amber',
    };
    return map[estado] ?? 'badge-gray';
};

// ── Dropdown navbar ───────────────────────────────────────────────────────────
const dropdownOpen = ref(false);
const toggleDropdown = () => dropdownOpen.value = !dropdownOpen.value;
const closeDropdown  = () => dropdownOpen.value = false;

// ── Modal: Mi cuenta (User) ───────────────────────────────────────────────────
const modalCuenta = ref(false);

const formCuenta = useForm({
    name:                  authUser?.name  ?? '',
    email:                 authUser?.email ?? '',
    password:              '',
    password_confirmation: '',
});

const openModalCuenta = () => {
    // Pre-rellenar con datos actuales
    formCuenta.name     = authUser?.name  ?? '';
    formCuenta.email    = authUser?.email ?? '';
    formCuenta.password = '';
    formCuenta.password_confirmation = '';
    formCuenta.clearErrors();
    modalCuenta.value = true;
    closeDropdown();
};

const submitCuenta = () => {
    formCuenta.patch(route('profile.update'), {
        preserveScroll: true,
        onSuccess: () => { modalCuenta.value = false; },
    });
};

// ── Formulario pasajero (solo teléfono) ───────────────────────────────────────
const formPasajero = useForm({
    telefono: props.cliente?.telefono ?? '',
});

const pasajeroEditando = ref(false);

const submitPasajero = () => {
    formPasajero.patch(route('cliente.updatePerfil'), {
        preserveScroll: true,
        onSuccess: () => { pasajeroEditando.value = false; },
    });
};

const cancelarPasajero = () => {
    formPasajero.telefono = props.cliente?.telefono ?? '';
    formPasajero.clearErrors();
    pasajeroEditando.value = false;
};

// ── Logout ────────────────────────────────────────────────────────────────────
const logout = () => {
    closeDropdown();
    router.post(route('logout'));
};
</script>

<template>
    <Head title="Mi Panel — Trans. Copacabana S.A." />

    <div class="root" @click="closeDropdown">

        <!-- ── NAVBAR ──────────────────────────────────────────────────────── -->
        <nav class="navbar" @click.stop>
            <div class="navbar-logo">Trans. Copacabana <span>S.A.</span></div>

            <div class="navbar-right">
                <div class="user-menu">
                    <button class="user-btn" @click.stop="toggleDropdown">
                        <div class="avatar">{{ authUser?.name?.charAt(0)?.toUpperCase() ?? 'U' }}</div>
                        <span class="user-name">{{ authUser?.name ?? 'Usuario' }}</span>
                        <svg class="chevron" :class="{ rotated: dropdownOpen }"
                            width="14" height="14" viewBox="0 0 24 24" fill="none"
                            stroke="currentColor" stroke-width="2.5">
                            <polyline points="6 9 12 15 18 9"/>
                        </svg>
                    </button>

                    <transition name="dropdown">
                        <div v-if="dropdownOpen" class="dropdown">
                            <div class="dropdown-header">
                                <div class="dropdown-avatar">{{ authUser?.name?.charAt(0)?.toUpperCase() ?? 'U' }}</div>
                                <div>
                                    <div class="dropdown-name">{{ authUser?.name ?? 'Usuario' }}</div>
                                    <div class="dropdown-email">{{ authUser?.email ?? '' }}</div>
                                </div>
                            </div>
                            <div class="dropdown-divider"/>
                            <button class="dropdown-item" @click="openModalCuenta">
                                <svg width="15" height="15" viewBox="0 0 24 24" fill="none"
                                    stroke="currentColor" stroke-width="2">
                                    <circle cx="12" cy="8" r="4"/>
                                    <path d="M4 20c0-4 3.6-7 8-7s8 3 8 7"/>
                                </svg>
                                Mi cuenta
                            </button>
                            <button class="dropdown-item danger" @click="logout">
                                <svg width="15" height="15" viewBox="0 0 24 24" fill="none"
                                    stroke="currentColor" stroke-width="2">
                                    <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/>
                                    <polyline points="16 17 21 12 16 7"/>
                                    <line x1="21" y1="12" x2="9" y2="12"/>
                                </svg>
                                Cerrar sesión
                            </button>
                        </div>
                    </transition>
                </div>
            </div>
        </nav>

        <main class="main">

            <!-- BIENVENIDA -->
            <div class="welcome">
                <h1>Bienvenido, {{ authUser?.name?.split(' ')[0] ?? 'Usuario' }}</h1>
                <p>Panel de cliente · Trans. Copacabana S.A.</p>
            </div>

            <!-- STATS -->
            <div class="stats-grid">
                <div class="stat-card">
                    <div class="stat-label">🎫 Boletos comprados</div>
                    <div class="stat-val">{{ stats?.total_boletos ?? 0 }}</div>
                </div>
                <div class="stat-card">
                    <div class="stat-label">📦 Encomiendas</div>
                    <div class="stat-val">{{ stats?.total_encomiendas ?? 0 }}</div>
                </div>
                <div class="stat-card">
                    <div class="stat-label">🧾 Facturas</div>
                    <div class="stat-val">{{ stats?.total_facturas ?? 0 }}</div>
                </div>
            </div>

            <!-- TABS -->
            <div class="tabs">
                <button v-for="tab in tabs" :key="tab.key"
                    class="tab" :class="{ active: activeTab === tab.key }"
                    @click="activeTab = tab.key">
                    {{ tab.icon }} {{ tab.label }}
                </button>
            </div>

            <!-- ── VIAJES ──────────────────────────────────────────────────── -->
            <div v-if="activeTab === 'viajes'" class="card">
                <div class="card-head">🚌 Mis viajes y boletos</div>
                <div class="table-wrap">
                    <table>
                        <thead>
                            <tr>
                                <th>Boleto</th><th>Ruta</th><th>Fecha salida</th>
                                <th>Hora</th><th>Asiento</th><th>Precio</th><th>Estado</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-if="!boletos?.length">
                                <td colspan="7" class="empty">No tienes boletos registrados.</td>
                            </tr>
                            <tr v-for="b in boletos" :key="b.id_boleto">
                                <td>#{{ b.id_boleto }}</td>
                                <td>{{ b.origen }} → {{ b.destino }}</td>
                                <td>{{ b.fecha_salida }}</td>
                                <td>{{ b.hora_salida }}</td>
                                <td>{{ b.asiento }}</td>
                                <td>Bs. {{ b.precio }}</td>
                                <td><span class="badge" :class="estadoBadge(b.estado)">{{ b.estado }}</span></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- ── ENCOMIENDAS ─────────────────────────────────────────────── -->
            <div v-if="activeTab === 'encomiendas'" class="card">
                <div class="card-head">📦 Mis encomiendas</div>
                <div class="table-wrap">
                    <table>
                        <thead>
                            <tr>
                                <th>Cód.</th><th>Descripción</th><th>Destino</th>
                                <th>Peso (kg)</th><th>Fecha</th><th>Estado</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-if="!encomiendas?.length">
                                <td colspan="6" class="empty">No tienes encomiendas registradas.</td>
                            </tr>
                            <tr v-for="e in encomiendas" :key="e.id_encomienda">
                                <td>#{{ e.id_encomienda }}</td>
                                <td>{{ e.descripcion }}</td>
                                <td>{{ e.destino }}</td>
                                <td>{{ e.peso }}</td>
                                <td>{{ e.fecha_envio }}</td>
                                <td><span class="badge" :class="estadoBadge(e.estado)">{{ e.estado }}</span></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- ── FACTURAS ────────────────────────────────────────────────── -->
            <div v-if="activeTab === 'facturas'" class="card">
                <div class="card-head">🧾 Mis facturas</div>
                <div class="table-wrap">
                    <table>
                        <thead>
                            <tr>
                                <th>N° Factura</th><th>Fecha</th><th>Concepto</th>
                                <th>Total</th><th>Estado</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-if="!facturas?.length">
                                <td colspan="5" class="empty">No tienes facturas registradas.</td>
                            </tr>
                            <tr v-for="f in facturas" :key="f.id_factura">
                                <td>#{{ f.id_factura }}</td>
                                <td>{{ f.fecha }}</td>
                                <td>{{ f.concepto }}</td>
                                <td>Bs. {{ f.total }}</td>
                                <td><span class="badge" :class="estadoBadge(f.estado)">{{ f.estado }}</span></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- ── PASAJERO ────────────────────────────────────────────────── -->
            <div v-if="activeTab === 'pasajero'" class="card">
                <div class="card-head">
                    🪪 Datos del pasajero
                    <button v-if="!pasajeroEditando" class="btn-edit" @click="pasajeroEditando = true">
                        ✏️ Editar
                    </button>
                </div>

                <!-- Modo lectura -->
                <div v-if="!pasajeroEditando" class="profile-grid">
                    <div class="prow">
                        <span class="prow-label">Nombre completo</span>
                        <span class="prow-val">{{ cliente?.nombre ?? '—' }}</span>
                    </div>
                    <div class="prow">
                        <span class="prow-label">Documento de identidad</span>
                        <span class="prow-val">{{ cliente?.documento_identidad ?? '—' }}</span>
                    </div>
                    <div class="prow prow-full">
                        <span class="prow-label">Teléfono</span>
                        <span class="prow-val">{{ cliente?.telefono ?? '—' }}</span>
                    </div>
                </div>

                <!-- Modo edición -->
                <div v-else class="edit-form">
                    <p class="edit-hint">Solo puedes actualizar tu número de teléfono.</p>
                    <div class="field-group-3">
                        <div class="field">
                            <label class="field-label">Nombre completo</label>
                            <input class="field-input readonly" :value="cliente?.nombre" disabled />
                        </div>
                        <div class="field">
                            <label class="field-label">Documento de identidad</label>
                            <input class="field-input readonly" :value="cliente?.documento_identidad" disabled />
                        </div>
                        <div class="field">
                            <label class="field-label">Teléfono</label>
                            <input class="field-input" v-model="formPasajero.telefono"
                                type="tel" placeholder="Ej: 70000000" />
                            <span v-if="formPasajero.errors.telefono" class="field-error">
                                {{ formPasajero.errors.telefono }}
                            </span>
                        </div>
                    </div>
                    <div class="form-actions">
                        <button class="btn-cancel" @click="cancelarPasajero">Cancelar</button>
                        <button class="btn-save" :disabled="formPasajero.processing" @click="submitPasajero">
                            {{ formPasajero.processing ? 'Guardando…' : 'Guardar cambios' }}
                        </button>
                    </div>
                </div>
            </div>

        </main>

        <footer class="footer">
            © {{ new Date().getFullYear() }} Trans. Copacabana S.A. — Empresa 100% boliviana
        </footer>

        <!-- ── MODAL: MI CUENTA ────────────────────────────────────────────── -->
        <transition name="fade">
            <div v-if="modalCuenta" class="modal-backdrop" @click.self="modalCuenta = false">
                <transition name="slide-up">
                    <div v-if="modalCuenta" class="modal">

                        <div class="modal-header">
                            <div class="modal-header-left">
                                <div class="modal-avatar">{{ authUser?.name?.charAt(0)?.toUpperCase() ?? 'U' }}</div>
                                <div>
                                    <h2 class="modal-title">Mi cuenta</h2>
                                    <p class="modal-subtitle">{{ authUser?.email }}</p>
                                </div>
                            </div>
                            <button class="modal-close" @click="modalCuenta = false">
                                <svg width="16" height="16" viewBox="0 0 24 24" fill="none"
                                    stroke="currentColor" stroke-width="2.5">
                                    <line x1="18" y1="6" x2="6" y2="18"/>
                                    <line x1="6" y1="6" x2="18" y2="18"/>
                                </svg>
                            </button>
                        </div>

                        <div class="modal-section-label">Información de acceso</div>

                        <div class="field-group">
                            <div class="field">
                                <label class="field-label">Nombre de usuario</label>
                                <input class="field-input" v-model="formCuenta.name"
                                    type="text" placeholder="Tu nombre" autocomplete="name" />
                                <span v-if="formCuenta.errors.name" class="field-error">{{ formCuenta.errors.name }}</span>
                            </div>
                            <div class="field">
                                <label class="field-label">Email</label>
                                <input class="field-input" v-model="formCuenta.email"
                                    type="email" placeholder="correo@ejemplo.com" autocomplete="email" />
                                <span v-if="formCuenta.errors.email" class="field-error">{{ formCuenta.errors.email }}</span>
                            </div>
                        </div>

                        <div class="modal-section-label" style="margin-top:18px;">Cambiar contraseña <span class="optional">(opcional)</span></div>

                        <div class="field-group">
                            <div class="field">
                                <label class="field-label">Nueva contraseña</label>
                                <input class="field-input" v-model="formCuenta.password"
                                    type="password" placeholder="••••••••" autocomplete="new-password" />
                                <span v-if="formCuenta.errors.password" class="field-error">{{ formCuenta.errors.password }}</span>
                            </div>
                            <div class="field">
                                <label class="field-label">Confirmar contraseña</label>
                                <input class="field-input" v-model="formCuenta.password_confirmation"
                                    type="password" placeholder="••••••••" autocomplete="new-password" />
                            </div>
                        </div>

                        <div class="modal-divider"/>

                        <div class="form-actions">
                            <button class="btn-cancel" @click="modalCuenta = false">Cancelar</button>
                            <button class="btn-save" :disabled="formCuenta.processing" @click="submitCuenta">
                                {{ formCuenta.processing ? 'Guardando…' : 'Guardar cambios' }}
                            </button>
                        </div>

                    </div>
                </transition>
            </div>
        </transition>

    </div>
</template>

<style scoped>
@import url('https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap');

*, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

.root {
    min-height: 100vh;
    background: #0d1117;
    font-family: 'Nunito', sans-serif;
    color: #e2e8f0;
}

/* ── NAVBAR ────────────────────────────────────────────────────────────────── */
.navbar {
    position: sticky; top: 0; z-index: 100;
    display: flex; align-items: center; justify-content: space-between;
    padding: 12px 32px;
    background: rgba(10,12,20,0.92);
    backdrop-filter: blur(12px);
    border-bottom: 1px solid rgba(255,255,255,0.07);
}
.navbar-logo { font-size: 1rem; font-weight: 700; color: #fff; }
.navbar-logo span { color: #c0392b; }
.navbar-right { display: flex; align-items: center; }

.user-menu { position: relative; }
.user-btn {
    display: flex; align-items: center; gap: 8px;
    padding: 5px 10px 5px 5px;
    border-radius: 10px;
    background: rgba(255,255,255,0.05);
    border: 1px solid rgba(255,255,255,0.09);
    color: rgba(255,255,255,0.85);
    font-family: 'Nunito', sans-serif; font-size: 0.85rem; font-weight: 600;
    cursor: pointer; transition: background 0.2s, border-color 0.2s;
}
.user-btn:hover { background: rgba(255,255,255,0.09); border-color: rgba(255,255,255,0.15); }

.avatar {
    width: 28px; height: 28px; border-radius: 50%;
    background: linear-gradient(135deg, #c0392b, #96281b);
    display: flex; align-items: center; justify-content: center;
    font-weight: 700; font-size: 0.82rem; color: #fff; flex-shrink: 0;
}
.user-name { max-width: 140px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap; }
.chevron { color: rgba(255,255,255,0.4); transition: transform 0.2s; }
.chevron.rotated { transform: rotate(180deg); }

/* Dropdown */
.dropdown {
    position: absolute; top: calc(100% + 8px); right: 0;
    min-width: 220px;
    background: #161b22;
    border: 1px solid rgba(255,255,255,0.1);
    border-radius: 12px;
    box-shadow: 0 16px 48px rgba(0,0,0,0.6);
    overflow: hidden; z-index: 200;
}
.dropdown-header { display: flex; align-items: center; gap: 10px; padding: 14px 16px; }
.dropdown-avatar {
    width: 36px; height: 36px; border-radius: 50%;
    background: linear-gradient(135deg, #c0392b, #96281b);
    display: flex; align-items: center; justify-content: center;
    font-weight: 700; font-size: 0.9rem; color: #fff; flex-shrink: 0;
}
.dropdown-name  { font-size: 0.85rem; font-weight: 700; color: #fff; }
.dropdown-email { font-size: 0.75rem; color: rgba(255,255,255,0.4); margin-top: 1px; }
.dropdown-divider { height: 1px; background: rgba(255,255,255,0.07); }
.dropdown-item {
    display: flex; align-items: center; gap: 9px;
    width: 100%; padding: 11px 16px;
    background: none; border: none;
    color: rgba(255,255,255,0.7);
    font-family: 'Nunito', sans-serif; font-size: 0.85rem; font-weight: 600;
    cursor: pointer; text-align: left;
    transition: background 0.15s, color 0.15s;
}
.dropdown-item:hover        { background: rgba(255,255,255,0.05); color: #fff; }
.dropdown-item.danger:hover { background: rgba(192,57,43,0.12); color: #f87171; }

.dropdown-enter-active, .dropdown-leave-active { transition: opacity 0.15s, transform 0.15s; }
.dropdown-enter-from, .dropdown-leave-to       { opacity: 0; transform: translateY(-6px); }

/* ── MAIN ──────────────────────────────────────────────────────────────────── */
.main { max-width: 1100px; margin: 0 auto; padding: 36px 24px 80px; }

.welcome { margin-bottom: 24px; }
.welcome h1 { font-size: 1.5rem; font-weight: 700; color: #fff; margin-bottom: 4px; }
.welcome p  { font-size: 0.85rem; color: rgba(255,255,255,0.4); }

.stats-grid { display: grid; grid-template-columns: repeat(3,1fr); gap: 14px; margin-bottom: 28px; }
.stat-card {
    background: rgba(255,255,255,0.04);
    border: 1px solid rgba(255,255,255,0.08);
    border-radius: 14px; padding: 18px 20px;
}
.stat-label { font-size: 0.78rem; color: rgba(255,255,255,0.45); margin-bottom: 8px; font-weight: 600; }
.stat-val   { font-size: 2rem; font-weight: 700; color: #fff; line-height: 1; }

.tabs { display: flex; gap: 4px; border-bottom: 1px solid rgba(255,255,255,0.08); margin-bottom: 20px; }
.tab {
    padding: 9px 18px; font-size: 0.85rem; font-weight: 600;
    font-family: 'Nunito', sans-serif;
    color: rgba(255,255,255,0.45);
    background: none; border: none;
    border-bottom: 2px solid transparent; margin-bottom: -1px;
    cursor: pointer; transition: all 0.2s; white-space: nowrap;
}
.tab.active             { color: #fff; border-bottom-color: #c0392b; }
.tab:hover:not(.active) { color: rgba(255,255,255,0.7); }

.card {
    background: rgba(255,255,255,0.04);
    border: 1px solid rgba(255,255,255,0.08);
    border-radius: 16px; overflow: hidden;
}
.card-head {
    padding: 14px 20px;
    border-bottom: 1px solid rgba(255,255,255,0.07);
    font-size: 0.9rem; font-weight: 700; color: #fff;
    display: flex; align-items: center; justify-content: space-between;
}

.table-wrap { overflow-x: auto; }
table { width: 100%; border-collapse: collapse; font-size: 0.85rem; }
th {
    text-align: left; padding: 10px 20px;
    color: rgba(255,255,255,0.35); font-weight: 600;
    font-size: 0.75rem; letter-spacing: 0.5px; text-transform: uppercase;
    border-bottom: 1px solid rgba(255,255,255,0.07);
}
td { padding: 12px 20px; border-bottom: 1px solid rgba(255,255,255,0.05); color: rgba(255,255,255,0.8); }
tr:last-child td { border-bottom: none; }
tr:hover td { background: rgba(255,255,255,0.03); }
.empty { text-align: center; color: rgba(255,255,255,0.3); padding: 32px !important; }

.badge { display: inline-block; font-size: 0.72rem; font-weight: 700; padding: 3px 10px; border-radius: 20px; }
.badge-green { background: rgba(39,174,96,0.15);  color: #6ee7b7; }
.badge-blue  { background: rgba(52,152,219,0.15);  color: #93c5fd; }
.badge-amber { background: rgba(245,158,11,0.15);  color: #fcd34d; }
.badge-gray  { background: rgba(255,255,255,0.07); color: rgba(255,255,255,0.4); }

/* ── PASAJERO ──────────────────────────────────────────────────────────────── */
.profile-grid { display: grid; grid-template-columns: 1fr 1fr; }
.prow {
    display: flex; flex-direction: column; gap: 4px;
    padding: 16px 20px;
    border-bottom: 1px solid rgba(255,255,255,0.05);
    border-right: 1px solid rgba(255,255,255,0.05);
}
.prow:nth-child(even) { border-right: none; }
.prow:nth-last-child(-n+2) { border-bottom: none; }
/* Fila que ocupa columna completa (teléfono solo) */
.prow-full { grid-column: 1 / -1; border-right: none; border-bottom: none; }

.prow-label { font-size: 0.72rem; color: rgba(255,255,255,0.35); font-weight: 600; text-transform: uppercase; letter-spacing: 0.5px; }
.prow-val   { font-size: 0.9rem; color: rgba(255,255,255,0.85); font-weight: 600; }

/* ── Formularios ───────────────────────────────────────────────────────────── */
.edit-form { padding: 20px; }
.edit-hint { font-size: 0.8rem; color: rgba(255,255,255,0.35); margin-bottom: 18px; }

/* 3 columnas para el form pasajero */
.field-group-3 { display: grid; grid-template-columns: repeat(3,1fr); gap: 14px; }
/* 2 columnas para el modal */
.field-group   { display: grid; grid-template-columns: 1fr 1fr; gap: 14px; }

.field { display: flex; flex-direction: column; gap: 6px; }
.field-label {
    font-size: 0.72rem; font-weight: 700;
    color: rgba(255,255,255,0.4); text-transform: uppercase; letter-spacing: 0.4px;
}
.field-input {
    padding: 9px 13px;
    background: rgba(255,255,255,0.05);
    border: 1px solid rgba(255,255,255,0.1);
    border-radius: 8px; color: #fff;
    font-family: 'Nunito', sans-serif; font-size: 0.88rem;
    outline: none; transition: border-color 0.2s, background 0.2s;
}
.field-input:focus   { border-color: #c0392b; background: rgba(255,255,255,0.07); }
.field-input.readonly { opacity: 0.38; cursor: not-allowed; }
.field-error { font-size: 0.75rem; color: #f87171; }

.form-actions { display: flex; justify-content: flex-end; gap: 10px; margin-top: 20px; }

.btn-edit {
    padding: 5px 13px; border-radius: 7px;
    background: rgba(255,255,255,0.06); border: 1px solid rgba(255,255,255,0.1);
    color: rgba(255,255,255,0.6);
    font-family: 'Nunito', sans-serif; font-size: 0.78rem; font-weight: 600;
    cursor: pointer; transition: all 0.2s;
}
.btn-edit:hover { background: rgba(192,57,43,0.15); border-color: rgba(192,57,43,0.4); color: #f87171; }

.btn-cancel {
    padding: 8px 18px; border-radius: 8px;
    background: rgba(255,255,255,0.05); border: 1px solid rgba(255,255,255,0.1);
    color: rgba(255,255,255,0.55);
    font-family: 'Nunito', sans-serif; font-size: 0.85rem; font-weight: 600;
    cursor: pointer; transition: all 0.2s;
}
.btn-cancel:hover { background: rgba(255,255,255,0.09); color: rgba(255,255,255,0.8); }

.btn-save {
    padding: 8px 20px; border-radius: 8px;
    background: #c0392b; border: none; color: #fff;
    font-family: 'Nunito', sans-serif; font-size: 0.85rem; font-weight: 700;
    cursor: pointer; transition: background 0.2s, opacity 0.2s;
}
.btn-save:hover:not(:disabled) { background: #a93226; }
.btn-save:disabled { opacity: 0.5; cursor: not-allowed; }

/* ── MODAL MI CUENTA ───────────────────────────────────────────────────────── */
.modal-backdrop {
    position: fixed; inset: 0;
    background: rgba(0,0,0,0.65); backdrop-filter: blur(4px);
    display: flex; align-items: center; justify-content: center;
    z-index: 500; padding: 16px;
}
.modal {
    background: #161b22;
    border: 1px solid rgba(255,255,255,0.1);
    border-radius: 18px;
    width: 100%; max-width: 500px;
    padding: 24px;
    box-shadow: 0 24px 64px rgba(0,0,0,0.7);
}
.modal-header {
    display: flex; align-items: center; justify-content: space-between;
    margin-bottom: 20px;
}
.modal-header-left { display: flex; align-items: center; gap: 12px; }
.modal-avatar {
    width: 44px; height: 44px; border-radius: 50%;
    background: linear-gradient(135deg, #c0392b, #96281b);
    display: flex; align-items: center; justify-content: center;
    font-weight: 700; font-size: 1.1rem; color: #fff; flex-shrink: 0;
}
.modal-title    { font-size: 1.05rem; font-weight: 700; color: #fff; }
.modal-subtitle { font-size: 0.78rem; color: rgba(255,255,255,0.4); margin-top: 2px; }

.modal-section-label {
    font-size: 0.72rem; font-weight: 700;
    color: rgba(255,255,255,0.35);
    text-transform: uppercase; letter-spacing: 0.6px;
    margin-bottom: 10px;
}
.optional { font-weight: 400; text-transform: none; letter-spacing: 0; color: rgba(255,255,255,0.25); }

.modal-close {
    width: 30px; height: 30px; border-radius: 7px;
    background: rgba(255,255,255,0.06); border: none;
    color: rgba(255,255,255,0.5); cursor: pointer;
    display: flex; align-items: center; justify-content: center;
    transition: background 0.2s, color 0.2s; flex-shrink: 0;
}
.modal-close:hover { background: rgba(192,57,43,0.2); color: #f87171; }

.modal-divider { height: 1px; background: rgba(255,255,255,0.07); margin-top: 20px; }

/* Transitions */
.fade-enter-active, .fade-leave-active       { transition: opacity 0.2s; }
.fade-enter-from, .fade-leave-to             { opacity: 0; }
.slide-up-enter-active, .slide-up-leave-active { transition: opacity 0.2s, transform 0.2s; }
.slide-up-enter-from, .slide-up-leave-to     { opacity: 0; transform: translateY(16px); }

/* ── FOOTER ────────────────────────────────────────────────────────────────── */
.footer {
    text-align: center; padding: 24px;
    font-size: 0.75rem; color: rgba(255,255,255,0.2);
    border-top: 1px solid rgba(255,255,255,0.05);
}

/* ── RESPONSIVE ────────────────────────────────────────────────────────────── */
@media (max-width: 768px) {
    .field-group-3 { grid-template-columns: 1fr; }
    .profile-grid  { grid-template-columns: 1fr; }
    .prow          { border-right: none; }
    .prow-full     { grid-column: 1; }
}
@media (max-width: 640px) {
    .stats-grid  { grid-template-columns: 1fr; }
    .field-group { grid-template-columns: 1fr; }
    .navbar      { padding: 12px 16px; }
    .user-name   { display: none; }
    .tabs        { overflow-x: auto; }
    .tab         { padding: 9px 12px; font-size: 0.78rem; }
    .modal       { padding: 18px; }
}
</style>