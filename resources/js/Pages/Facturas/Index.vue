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
import Tag from 'primevue/tag';
import Message from 'primevue/message';

const props = defineProps({
    facturas: Array,
    clientes: Array,
    empleados: Array,
    metodos_pago: Array
});

const displayModal = ref(false);

const form = useForm({
    id_cliente: null,
    id_empleado: null,
    id_metodo_pago: null,
    fecha: new Date().toISOString().slice(0, 19).replace('T', ' '),
});

const openNew = () => {
    form.reset();
    form.fecha = new Date().toISOString().slice(0, 19).replace('T', ' ');
    displayModal.value = true;
};

const submit = () => {
    form.post(route('facturas.store'), {
        onSuccess: () => displayModal.value = false
    });
};

const formatDate = (dateString) => {
    return new Date(dateString).toLocaleString('es-ES', {
        year: 'numeric', month: '2-digit', day: '2-digit',
        hour: '2-digit', minute: '2-digit'
    });
};
</script>

<template>
    <Head title="Facturación" />
    <Layout>
        <div class="bg-[#1a1d2b] p-8 rounded-[2rem] border border-white/5 shadow-2xl min-h-[70vh]">
            
            <transition name="p-message">
                <Message v-if="$page.props.errors.error" severity="error" class="mb-6 !bg-red-500/10 !border-red-500/20 !text-red-400" sticky>
                    {{ $page.props.errors.error }}
                </Message>
            </transition>

            <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 mb-8">
                <div>
                    <h1 class="text-2xl font-bold text-white tracking-tight flex items-center gap-3">
                        <i class="pi pi-file-pdf text-indigo-500"></i>
                        Registro de Facturas
                    </h1>
                    <p class="text-slate-500 text-sm mt-1">Control de emisiones y transacciones comerciales.</p>
                </div>
                <Button label="Nueva Factura" icon="pi pi-plus" @click="openNew" 
                    class="!bg-indigo-600 !border-none !rounded-xl !px-6 !py-3 shadow-lg shadow-indigo-500/20 hover:!bg-indigo-500 transition-all" />
            </div>

            <DataTable :value="facturas" paginator :rows="10" class="p-datatable-atlantis" responsiveLayout="stack">
                <Column header="ID" class="w-16 text-slate-500 text-xs font-mono">
                    <template #body="{ data }">
                        {{ data.id_factura }}
                    </template>
                </Column>

                <Column header="Nº FACTURA" class="w-32">
                    <template #body="{ data }">
                        <span class="font-mono text-indigo-400 font-bold tracking-tighter">
                            FAC-{{ String(data.id_factura).padStart(6, '0') }}
                        </span>
                    </template>
                </Column>
                
                <Column header="CLIENTE">
                    <template #body="{ data }">
                        <div class="flex flex-col">
                            <span class="text-white font-medium">{{ data.cliente?.nombre }}</span>
                            <span class="text-[10px] text-slate-500 uppercase tracking-widest">CI/NIT: {{ data.cliente?.documento_identidad || 'S/N' }}</span>
                        </div>
                    </template>
                </Column>

                <Column header="CAJERO/RESPONSABLE">
                    <template #body="{ data }">
                        <div class="flex items-center gap-2">
                            <div class="w-6 h-6 rounded-full bg-slate-700 flex items-center justify-center text-[10px]">
                                <i class="pi pi-user text-slate-400"></i>
                            </div>
                            <span class="text-slate-300 text-sm">{{ data.empleado?.nombre }}</span>
                        </div>
                    </template>
                </Column>

                <Column header="PAGO">
                    <template #body="{ data }">
                        <Tag :value="data.metodo_pago?.nombre" severity="info" class="!bg-indigo-500/10 !text-indigo-300 !border-indigo-500/20" />
                    </template>
                </Column>

                <Column header="FECHA Y HORA">
                    <template #body="{ data }">
                        <span class="text-slate-400 text-xs font-mono">{{ formatDate(data.fecha) }}</span>
                    </template>
                </Column>

                <Column header="ACCIONES" class="text-right w-20">
                    <template #body="{ data }">
                        <Button icon="pi pi-trash" text rounded severity="danger" 
                            @click="() => { if(confirm('¿Anular esta factura definitivamente?')) form.delete(route('facturas.destroy', data.id_factura)) }" />
                    </template>
                </Column>
            </DataTable>
        </div>

        <Dialog v-model:visible="displayModal" header="Emitir Nueva Factura" modal 
            class="p-dark w-full max-w-md"
            :pt="{ 
                root: { class: 'bg-[#1a1d2b] border border-white/10 shadow-2xl' },
                header: { class: 'bg-[#1a1d2b] text-white border-b border-white/5 p-6' },
                content: { class: 'bg-[#1a1d2b] text-white p-6' }
            }">
            
            <form @submit.prevent="submit" class="grid grid-cols-1 gap-6 pt-2">
                <div class="flex flex-col gap-2">
                    <label class="text-xs font-bold text-slate-500 uppercase tracking-widest">Cliente Receptor</label>
                    <Dropdown v-model="form.id_cliente" :options="clientes" optionLabel="nombre" optionValue="id_cliente" 
                        placeholder="Buscar cliente..." filter class="w-full !bg-[#0f111a] !border-white/10" />
                    <small v-if="form.errors.id_cliente" class="text-red-400 text-[10px]">{{ form.errors.id_cliente }}</small>
                </div>

                <div class="flex flex-col gap-2">
                    <label class="text-xs font-bold text-slate-500 uppercase tracking-widest">Cajero en Turno</label>
                    <Dropdown v-model="form.id_empleado" :options="empleados" optionLabel="nombre" optionValue="id_empleado" 
                        placeholder="Seleccionar responsable" filter class="w-full !bg-[#0f111a] !border-white/10" />
                </div>

                <div class="flex flex-col gap-2">
                    <label class="text-xs font-bold text-slate-500 uppercase tracking-widest">Método de Transacción</label>
                    <Dropdown v-model="form.id_metodo_pago" :options="metodos_pago" optionLabel="nombre" optionValue="id_metodo_pago" 
                        placeholder="Efectivo, QR, Tarjeta..." class="w-full !bg-[#0f111a] !border-white/10" />
                </div>

                <div class="flex justify-end gap-3 mt-4">
                    <Button label="Cancelar" text severity="secondary" @click="displayModal = false" class="!text-slate-400" />
                    <Button label="Generar Factura" type="submit" icon="pi pi-file-pdf" :loading="form.processing" 
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

.p-message-enter-active { transition: all 0.3s ease-out; }
.p-message-enter-from { opacity: 0; transform: translateY(-20px); }
</style>