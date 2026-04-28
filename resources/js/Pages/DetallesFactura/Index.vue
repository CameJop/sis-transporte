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
import Tag from 'primevue/tag';
import Message from 'primevue/message';

const props = defineProps({
    detalles: Array,
    facturas: Array,
    boletos: Array
});

const displayModal = ref(false);

const tipos = [
    { label: 'Boleto de Viaje', value: 'BOLETO' },
    { label: 'Encomienda', value: 'ENCOMIENDA' }
];

const form = useForm({
    id_detalle: null,
    id_factura: null,
    tipo: 'BOLETO',
    id_referencia: null,
    monto: 0,
});

const openNew = () => {
    form.reset();
    displayModal.value = true;
};

const submit = () => {
    form.post(route('detalles-factura.store'), {
        onSuccess: () => displayModal.value = false
    });
};

const formatCurrency = (value) => {
    return new Intl.NumberFormat('es-BO', { 
        style: 'currency', 
        currency: 'BOB' 
    }).format(value);
};
</script>

<template>
    <Head title="Detalles de Facturación" />
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
                        <i class="pi pi-list text-indigo-500"></i>
                        Detalle de Ventas
                    </h1>
                    <p class="text-slate-500 text-sm mt-1">Desglose de servicios facturados (Boletos y Encomiendas).</p>
                </div>
                <Button label="Añadir Ítem" icon="pi pi-plus" @click="openNew" 
                    class="!bg-indigo-600 !border-none !rounded-xl !px-6 !py-3 shadow-lg shadow-indigo-500/20 hover:!bg-indigo-500 transition-all" />
            </div>

            <DataTable :value="detalles" paginator :rows="10" class="p-datatable-atlantis" responsiveLayout="stack">
                <Column header="ID" class="w-16 text-slate-500 text-xs font-mono">
                    <template #body="{ data }">
                        {{ data.id_detalle }}
                    </template>
                </Column>

                <Column header="FACTURA ORIGEN">
                    <template #body="{ data }">
                        <div class="flex flex-col">
                            <span class="text-indigo-400 font-bold font-mono tracking-tighter">FAC-{{ String(data.id_factura).padStart(6, '0') }}</span>
                            <span class="text-[9px] text-slate-500 uppercase tracking-widest">{{ data.factura?.cliente?.nombre }}</span>
                        </div>
                    </template>
                </Column>
                
                <Column header="TIPO DE SERVICIO">
                    <template #body="{ data }">
                        <Tag :value="data.tipo" 
                             :class="data.tipo === 'BOLETO' 
                                ? '!bg-emerald-500/10 !text-emerald-400 !border-emerald-500/20' 
                                : '!bg-sky-500/10 !text-sky-400 !border-sky-500/20'" 
                             rounded />
                    </template>
                </Column>

                <Column header="REFERENCIA">
                    <template #body="{ data }">
                        <div class="flex items-center gap-2">
                            <i class="pi pi-tag text-[10px] text-slate-500"></i>
                            <span class="text-slate-300 font-mono text-sm">Ref ID: {{ data.id_referencia }}</span>
                        </div>
                    </template>
                </Column>

                <Column header="SUBTOTAL">
                    <template #body="{ data }">
                        <span class="text-white font-bold">{{ formatCurrency(data.monto) }}</span>
                    </template>
                </Column>

                <Column header="ACCIONES" class="text-right w-20">
                    <template #body="{ data }">
                        <Button icon="pi pi-trash" text rounded severity="danger" 
                            @click="() => { if(confirm('¿Remover este ítem del detalle?')) form.delete(route('detalles-factura.destroy', data.id_detalle)) }" />
                    </template>
                </Column>
            </DataTable>
        </div>

        <Dialog v-model:visible="displayModal" header="Agregar Detalle de Venta" modal 
            class="p-dark w-full max-w-md"
            :pt="{ 
                root: { class: 'bg-[#1a1d2b] border border-white/10 shadow-2xl' },
                header: { class: 'bg-[#1a1d2b] text-white border-b border-white/5 p-6' },
                content: { class: 'bg-[#1a1d2b] text-white p-6' }
            }">
            
            <form @submit.prevent="submit" class="grid grid-cols-1 gap-6 pt-2">
                <div class="flex flex-col gap-2">
                    <label class="text-xs font-bold text-slate-500 uppercase tracking-widest">Factura Relacionada</label>
                    <Dropdown v-model="form.id_factura" :options="facturas" 
                        :optionLabel="(f) => `FAC-${String(f.id_factura).padStart(4,'0')} | ${f.cliente?.nombre}`" 
                        optionValue="id_factura" placeholder="Seleccionar Factura" filter 
                        class="w-full !bg-[#0f111a] !border-white/10" />
                    <small v-if="form.errors.id_factura" class="text-red-400 text-[10px]">{{ form.errors.id_factura }}</small>
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div class="flex flex-col gap-2">
                        <label class="text-xs font-bold text-slate-500 uppercase tracking-widest">Tipo</label>
                        <Dropdown v-model="form.tipo" :options="tipos" optionLabel="label" optionValue="value" 
                            class="w-full !bg-[#0f111a] !border-white/10" />
                    </div>
                    <div class="flex flex-col gap-2">
                        <label class="text-xs font-bold text-slate-500 uppercase tracking-widest">ID Ref.</label>
                        <InputNumber v-model="form.id_referencia" :useGrouping="false" placeholder="Boleto ID" 
                            inputClass="!bg-[#0f111a] !border-white/10 !text-white !w-full" />
                    </div>
                </div>

                <div class="flex flex-col gap-2">
                    <label class="text-xs font-bold text-slate-500 uppercase tracking-widest">Costo del Servicio (Bs.)</label>
                    <InputNumber v-model="form.monto" mode="currency" currency="BOB" locale="es-BO" 
                        inputClass="!bg-[#0f111a] !border-white/10 !text-emerald-400 font-bold !w-full" class="w-full" />
                    <small v-if="form.errors.monto" class="text-red-400 text-[10px]">{{ form.errors.monto }}</small>
                </div>

                <div class="flex justify-end gap-3 mt-4">
                    <Button label="Cancelar" text severity="secondary" @click="displayModal = false" class="!text-slate-400" />
                    <Button label="Vincular a Factura" type="submit" icon="pi pi-check" :loading="form.processing" 
                        class="!bg-indigo-600 !border-none !rounded-xl" />
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