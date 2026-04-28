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
import InputText from 'primevue/inputtext';
import InputNumber from 'primevue/inputnumber';
import Tag from 'primevue/tag';

const props = defineProps({
    encomiendas: Array,
    viajes: Array,
    clientes: Array
});

const displayModal = ref(false);
const editMode = ref(false);

const estadosEncomienda = [
    { label: 'Recibido en Oficina', value: 'RECIBIDO' },
    { label: 'En Tránsito', value: 'EN_TRANSITO' },
    { label: 'Listo para Entrega', value: 'LISTO' },
    { label: 'Entregado', value: 'ENTREGADO' },
    { label: 'Cancelado', value: 'CANCELADO' }
];

const form = useForm({
    id_encomienda: null,
    id_viaje: null,
    id_cliente_remitente: null,
    id_cliente_destinatario: null,
    peso: null,
    estado: 'RECIBIDO',
    fecha_envio: new Date().toISOString().slice(0, 10),
});

const openNew = () => {
    form.reset();
    form.fecha_envio = new Date().toISOString().slice(0, 10);
    editMode.value = false;
    displayModal.value = true;
};

const editEncomienda = (data) => {
    form.id_encomienda = data.id_encomienda;
    form.id_viaje = data.id_viaje;
    form.id_cliente_remitente = data.id_cliente_remitente;
    form.id_cliente_destinatario = data.id_cliente_destinatario;
    form.peso = data.peso;
    form.estado = data.estado;
    form.fecha_envio = data.fecha_envio;
    editMode.value = true;
    displayModal.value = true;
};

const submit = () => {
    if (editMode.value) {
        form.put(route('encomiendas.update', form.id_encomienda), {
            onSuccess: () => displayModal.value = false
        });
    } else {
        form.post(route('encomiendas.store'), {
            onSuccess: () => displayModal.value = false
        });
    }
};

const getSeverity = (estado) => {
    switch (estado) {
        case 'ENTREGADO': return 'success';
        case 'EN_TRANSITO': return 'info';
        case 'RECIBIDO': return 'secondary';
        case 'LISTO': return 'warning';
        case 'CANCELADO': return 'danger';
        default: return 'secondary';
    }
};
</script>

<template>
    <Head title="Gestión de Encomiendas" />
    <Layout>
        <div class="bg-[#1a1d2b] p-8 rounded-[2rem] border border-white/5 shadow-2xl min-h-[70vh]">
            
            <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 mb-8">
                <div>
                    <h1 class="text-2xl font-bold text-white tracking-tight flex items-center gap-3">
                        <i class="pi pi-box text-indigo-500"></i>
                        Envíos y Encomiendas
                    </h1>
                    <p class="text-slate-500 text-sm mt-1">Seguimiento de carga y paquetes por viaje.</p>
                </div>
                <Button label="Nuevo Envío" icon="pi pi-plus" @click="openNew" 
                    class="!bg-indigo-600 !border-none !rounded-xl !px-6 !py-3 shadow-lg shadow-indigo-500/20 hover:!bg-indigo-500 transition-all" />
            </div>

            <DataTable :value="encomiendas" paginator :rows="10" class="p-datatable-atlantis" responsiveLayout="stack">
                <Column header="ID" class="w-16 text-slate-500 text-xs font-mono">
                    <template #body="{ data }">
                        {{ data.id_encomienda }}
                    </template>
                </Column>
                
                <Column header="REMITENTE / DESTINATARIO">
                    <template #body="{ data }">
                        <div class="flex flex-col gap-1">
                            <span class="text-white text-xs font-semibold">
                                <i class="pi pi-upload text-[10px] text-slate-500 mr-1"></i> {{ data.remitente?.nombre }}
                            </span>
                            <i class="pi pi-arrow-down text-[10px] ml-1 text-indigo-500"></i>
                            <span class="text-white text-xs font-semibold">
                                <i class="pi pi-download text-[10px] text-slate-500 mr-1"></i> {{ data.destinatario?.nombre }}
                            </span>
                        </div>
                    </template>
                </Column>

                <Column header="VIAJE / RUTA">
                    <template #body="{ data }">
                        <div class="text-xs text-slate-300">
                            {{ data.viaje?.ruta?.origen?.nombre }} ➔ {{ data.viaje?.ruta?.destino?.nombre }}
                        </div>
                        <div class="text-[10px] text-indigo-400 font-bold mt-1 uppercase font-mono">
                            Salida: {{ data.viaje?.fecha_salida }}
                        </div>
                    </template>
                </Column>

                <Column header="DETALLES">
                    <template #body="{ data }">
                        <Tag :value="`${data.peso} Kg`" class="!bg-white/5 !text-slate-300 !border !border-white/10 font-mono" />
                    </template>
                </Column>

                <Column header="ESTADO">
                    <template #body="{ data }">
                        <Tag :value="data.estado" :severity="getSeverity(data.estado)" rounded class="!px-3" />
                    </template>
                </Column>

                <Column header="ACCIONES" class="text-right w-32">
                    <template #body="{ data }">
                        <div class="flex justify-end gap-1">
                            <Button icon="pi pi-pencil" text rounded severity="secondary" @click="editEncomienda(data)" />
                            <Button icon="pi pi-trash" text rounded severity="danger" 
                                @click="() => { if(confirm('¿Eliminar registro?')) form.delete(route('encomiendas.destroy', data.id_encomienda)) }" />
                        </div>
                    </template>
                </Column>
            </DataTable>
        </div>

        <Dialog v-model:visible="displayModal" :header="editMode ? 'Editar Envío' : 'Registrar Encomienda'" modal 
            class="p-dark w-full max-w-lg"
            :pt="{ 
                root: { class: 'bg-[#1a1d2b] border border-white/10 shadow-2xl' },
                header: { class: 'bg-[#1a1d2b] text-white border-b border-white/5 p-6' },
                content: { class: 'bg-[#1a1d2b] text-white p-6' }
            }">
            
            <form @submit.prevent="submit" class="grid grid-cols-1 gap-5 pt-2">
                <div class="flex flex-col gap-2">
                    <label class="text-xs font-bold text-slate-500 uppercase tracking-widest">Viaje de Envío</label>
                    <Dropdown v-model="form.id_viaje" :options="viajes" 
                        :optionLabel="(v) => `${v.ruta?.origen?.nombre} ➔ ${v.ruta?.destino?.nombre} (${v.fecha_salida})`" 
                        optionValue="id_viaje" filter placeholder="Seleccione el viaje" class="w-full !bg-[#0f111a] !border-white/10" />
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div class="flex flex-col gap-2">
                        <label class="text-xs font-bold text-slate-500 uppercase tracking-widest">Remitente</label>
                        <Dropdown v-model="form.id_cliente_remitente" :options="clientes" optionLabel="nombre" optionValue="id_cliente" 
                            filter placeholder="Remitente" class="w-full !bg-[#0f111a] !border-white/10" />
                    </div>
                    <div class="flex flex-col gap-2">
                        <label class="text-xs font-bold text-slate-500 uppercase tracking-widest">Destinatario</label>
                        <Dropdown v-model="form.id_cliente_destinatario" :options="clientes" optionLabel="nombre" optionValue="id_cliente" 
                            filter placeholder="Destinatario" class="w-full !bg-[#0f111a] !border-white/10" />
                    </div>
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div class="flex flex-col gap-2">
                        <label class="text-xs font-bold text-slate-500 uppercase tracking-widest">Peso (Kg)</label>
                        <InputNumber v-model="form.peso" mode="decimal" :minFractionDigits="2" 
                            class="w-full" inputClass="!bg-[#0f111a] !border-white/10 !text-white" />
                    </div>
                    <div class="flex flex-col gap-2">
                        <label class="text-xs font-bold text-slate-500 uppercase tracking-widest">Fecha Envío</label>
                        <input type="date" v-model="form.fecha_envio" 
                            class="w-full bg-[#0f111a] border border-white/10 text-white rounded-lg p-2 outline-none focus:border-indigo-500 transition-colors" />
                    </div>
                </div>

                <div class="flex flex-col gap-2">
                    <label class="text-xs font-bold text-slate-500 uppercase tracking-widest">Estado de Entrega</label>
                    <Dropdown v-model="form.estado" :options="estadosEncomienda" optionLabel="label" optionValue="value" 
                        class="w-full !bg-[#0f111a] !border-white/10" />
                </div>

                <div class="flex justify-end gap-3 mt-4">
                    <Button label="Cerrar" text severity="secondary" @click="displayModal = false" class="!text-slate-400" />
                    <Button :label="editMode ? 'Actualizar' : 'Registrar Envío'" type="submit" 
                        icon="pi pi-check" :loading="form.processing" 
                        class="!bg-indigo-600 !border-none !rounded-xl shadow-lg shadow-indigo-500/20" />
                </div>
            </form>
        </Dialog>
    </Layout>
</template>

<style scoped>
:deep(.p-datatable-atlantis) { background: transparent; }

:deep(.p-datatable-thead > tr > th) {
    background: rgba(255, 255, 255, 0.02) !important;
    color: #818cf8 !important;
    font-size: 0.75rem;
    font-weight: 700;
    text-transform: uppercase;
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
    border-radius: 10px;
}
</style>