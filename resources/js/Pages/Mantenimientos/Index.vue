<script setup>
import { ref } from 'vue';
import { useForm, Head } from '@inertiajs/vue3';
import Layout from '@/Layouts/Layout.vue';

// PrimeVue
import DataTable from 'primevue/datatable';
import Column from 'primevue/column';
import Button from 'primevue/button';
import Dialog from 'primevue/dialog';
import Dropdown from 'primevue/dropdown';
import InputNumber from 'primevue/inputnumber';
import InputText from 'primevue/inputtext';
import Tag from 'primevue/tag';
import Message from 'primevue/message';

const props = defineProps({
    mantenimientos: Array,
    buses: Array,
    tipos: Array,
    empleados: Array
});

const displayModal = ref(false);
const editMode = ref(false);

const estadosMant = [
    { label: 'Pendiente', value: 'PENDIENTE' },
    { label: 'En Proceso', value: 'EN_PROCESO' },
    { label: 'Finalizado', value: 'FINALIZADO' }
];

const form = useForm({
    id_mantenimiento: null,
    id_bus: null,
    id_tipo_mant: null,
    id_empleado: null,
    fecha: new Date().toISOString().slice(0, 10),
    costo: 0,
    descripcion: '',
    estado: 'PENDIENTE',
});

const openNew = () => {
    form.reset();
    form.fecha = new Date().toISOString().slice(0, 10);
    editMode.value = false;
    displayModal.value = true;
};

const editMantenimiento = (data) => {
    form.id_mantenimiento = data.id_mantenimiento;
    form.id_bus = data.id_bus;
    form.id_tipo_mant = data.id_tipo_mant;
    form.id_empleado = data.id_empleado;
    form.fecha = data.fecha;
    form.costo = data.costo;
    form.descripcion = data.descripcion;
    form.estado = data.estado;
    editMode.value = true;
    displayModal.value = true;
};

const submit = () => {
    if (editMode.value) {
        form.put(route('mantenimientos.update', form.id_mantenimiento), {
            onSuccess: () => displayModal.value = false
        });
    } else {
        form.post(route('mantenimientos.store'), {
            onSuccess: () => displayModal.value = false
        });
    }
};

const getSeverity = (estado) => {
    switch (estado) {
        case 'FINALIZADO': return 'success';
        case 'EN_PROCESO': return 'info';
        case 'PENDIENTE': return 'warning';
        default: return 'secondary';
    }
};

const formatCurrency = (val) => {
    return new Intl.NumberFormat('es-BO', { style: 'currency', currency: 'BOB' }).format(val);
};
</script>

<template>
    <Head title="Mantenimiento de Flota" />
    <Layout>
        <div class="bg-[#1a1d2b] p-8 rounded-[2rem] border border-white/5 shadow-2xl min-h-[75vh]">
            
            <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 mb-8">
                <div>
                    <h1 class="text-2xl font-bold text-white tracking-tight flex items-center gap-3">
                        <div class="w-10 h-10 bg-indigo-500/20 rounded-xl flex items-center justify-center border border-indigo-500/30">
                            <i class="pi pi-wrench text-indigo-400"></i>
                        </div>
                        Bitácora de Mantenimiento
                    </h1>
                    <p class="text-slate-500 text-sm mt-1">Control de servicios mecánicos y reparaciones de unidades.</p>
                </div>
                <Button label="Registrar Servicio" icon="pi pi-plus" @click="openNew" 
                    class="!bg-indigo-600 !border-none !rounded-xl !px-6 !py-3 shadow-lg shadow-indigo-500/20 hover:!bg-indigo-500 transition-all" />
            </div>

            <DataTable :value="mantenimientos" paginator :rows="10" class="p-datatable-atlantis" responsiveLayout="stack">
                <Column header="ID" class="w-16 text-slate-500 text-xs font-mono">
                    <template #body="{ data }">
                        {{ data.id_mantenimiento }}
                    </template>
                </Column>

                <Column header="UNIDAD / BUS">
                    <template #body="{ data }">
                        <div class="flex items-center gap-3">
                            <div class="w-8 h-8 rounded-lg bg-slate-800 flex items-center justify-center border border-white/5">
                                <i class="pi pi-truck text-xs text-slate-400"></i>
                            </div>
                            <div class="flex flex-col">
                                <span class="text-white font-bold font-mono tracking-wider">{{ data.bus?.placa }}</span>
                                <span class="text-[10px] text-indigo-400 font-bold uppercase tracking-tighter">{{ data.tipo_mantenimiento?.nombre }}</span>
                            </div>
                        </div>
                    </template>
                </Column>

                <Column header="DESCRIPCIÓN DEL TRABAJO">
                    <template #body="{ data }">
                        <div class="max-w-xs overflow-hidden text-ellipsis whitespace-nowrap text-slate-400 text-xs italic">
                            {{ data.descripcion || 'Sin observaciones detalladas' }}
                        </div>
                    </template>
                </Column>

                <Column header="COSTO">
                    <template #body="{ data }">
                        <span class="text-emerald-400 font-bold text-sm">{{ formatCurrency(data.costo) }}</span>
                    </template>
                </Column>

                <Column header="RESPONSABLE">
                    <template #body="{ data }">
                        <div class="text-slate-300 text-xs">
                            {{ data.empleado?.nombre }}
                        </div>
                    </template>
                </Column>

                <Column field="fecha" header="FECHA" class="text-slate-500 font-mono text-xs"></Column>

                <Column header="ESTADO">
                    <template #body="{ data }">
                        <Tag :value="data.estado" :severity="getSeverity(data.estado)" class="!text-[9px] !px-3 !rounded-full" />
                    </template>
                </Column>

                <Column header="ACCIONES" class="text-right w-32">
                    <template #body="{ data }">
                        <div class="flex justify-end gap-1">
                            <Button icon="pi pi-pencil" text rounded severity="secondary" @click="editMantenimiento(data)" />
                            <Button icon="pi pi-trash" text rounded severity="danger" 
                                @click="() => { if(confirm('¿Eliminar registro?')) form.delete(route('mantenimientos.destroy', data.id_mantenimiento)) }" />
                        </div>
                    </template>
                </Column>
            </DataTable>
        </div>

        <Dialog v-model:visible="displayModal" :header="editMode ? 'Actualizar Registro' : 'Nuevo Mantenimiento'" modal 
            class="p-dark w-full max-w-xl"
            :pt="{ 
                root: { class: 'bg-[#1a1d2b] border border-white/10 shadow-2xl rounded-[1.5rem]' },
                header: { class: 'bg-[#1a1d2b] text-white border-b border-white/5 p-6' },
                content: { class: 'bg-[#1a1d2b] text-white p-6' }
            }">
            
            <form @submit.prevent="submit" class="grid grid-cols-1 gap-5 pt-2">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="flex flex-col gap-2">
                        <label class="text-xs font-bold text-slate-500 uppercase tracking-widest px-1">Bus / Placa</label>
                        <Dropdown v-model="form.id_bus" :options="buses" optionLabel="placa" optionValue="id_bus" 
                            placeholder="Seleccionar unidad" filter class="atlantis-input" />
                    </div>
                    <div class="flex flex-col gap-2">
                        <label class="text-xs font-bold text-slate-500 uppercase tracking-widest px-1">Tipo de Servicio</label>
                        <Dropdown v-model="form.id_tipo_mant" :options="tipos" optionLabel="nombre" optionValue="id_tipo_mant" 
                            placeholder="Seleccionar tipo" class="atlantis-input" />
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="flex flex-col gap-2">
                        <label class="text-xs font-bold text-slate-500 uppercase tracking-widest px-1">Mecánico</label>
                        <Dropdown v-model="form.id_empleado" :options="empleados" optionLabel="nombre" optionValue="id_empleado" 
                            filter class="atlantis-input" />
                    </div>
                    <div class="flex flex-col gap-2">
                        <label class="text-xs font-bold text-slate-500 uppercase tracking-widest px-1">Fecha</label>
                        <InputText type="date" v-model="form.fecha" class="atlantis-input-text" />
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="flex flex-col gap-2">
                        <label class="text-xs font-bold text-slate-500 uppercase tracking-widest px-1">Inversión (Bs.)</label>
                        <InputNumber v-model="form.costo" mode="currency" currency="BOB" locale="es-BO" class="atlantis-input-number" />
                    </div>
                    <div class="flex flex-col gap-2">
                        <label class="text-xs font-bold text-slate-500 uppercase tracking-widest px-1">Estado</label>
                        <Dropdown v-model="form.estado" :options="estadosMant" optionLabel="label" optionValue="value" class="atlantis-input" />
                    </div>
                </div>

                <div class="flex flex-col gap-2">
                    <label class="text-xs font-bold text-slate-500 uppercase tracking-widest px-1">Descripción de la Falla / Reparación</label>
                    <textarea v-model="form.descripcion" rows="3" 
                        class="w-full bg-[#0f111a] border border-white/10 rounded-xl p-4 text-white focus:border-indigo-500 outline-none transition-all placeholder:text-slate-700"></textarea>
                </div>

                <div class="flex justify-end gap-3 mt-4 border-t border-white/5 pt-6">
                    <Button label="Cerrar" text severity="secondary" @click="displayModal = false" class="!text-slate-400" />
                    <Button :label="editMode ? 'Actualizar' : 'Guardar Registro'" type="submit" 
                        icon="pi pi-check" :loading="form.processing" class="!bg-indigo-600 !border-none !rounded-xl !px-8" />
                </div>
            </form>
        </Dialog>
    </Layout>
</template>

<style scoped>
/* Estilización de Inputs Atlantis Dark */
.atlantis-input :deep(.p-dropdown), 
.atlantis-input-text,
.atlantis-input-number :deep(.p-inputnumber-input) {
    background: #0f111a !important;
    border: 1px solid rgba(255, 255, 255, 0.1) !important;
    color: white !important;
    border-radius: 0.75rem !important;
    width: 100%;
}

.atlantis-input :deep(.p-dropdown-label),
.atlantis-input-text {
    padding: 0.75rem !important;
}

:deep(.p-datatable-atlantis) { background: transparent; }

:deep(.p-datatable-thead > tr > th) {
    background: rgba(255, 255, 255, 0.02) !important;
    color: #818cf8 !important;
    font-size: 0.7rem;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 0.05em;
    padding: 1.25rem 1rem;
    border-bottom: 1px solid rgba(255, 255, 255, 0.05);
}

:deep(.p-datatable-tbody > tr) {
    background: transparent !important;
    color: #cbd5e1;
    border-bottom: 1px solid rgba(255, 255, 255, 0.02);
}

:deep(.p-paginator) {
    background: transparent !important;
    border: none;
    padding: 1.5rem 0;
}

:deep(.p-paginator button) { color: #64748b !important; }

:deep(.p-paginator .p-paginator-pages .p-paginator-page.p-highlight) {
    background: rgba(99, 102, 241, 0.1) !important;
    color: #818cf8 !important;
}
</style>