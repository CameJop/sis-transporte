<script setup>
import { ref } from 'vue';
import { useForm, Head } from '@inertiajs/vue3';
import Layout from '@/Layouts/Layout.vue';

// PrimeVue
import DataTable from 'primevue/datatable';
import Column from 'primevue/column';
import Button from 'primevue/button';
import Dialog from 'primevue/dialog';
import InputText from 'primevue/inputtext';
import InputNumber from 'primevue/inputnumber';
import Dropdown from 'primevue/dropdown';
import Tag from 'primevue/tag';
import Message from 'primevue/message';

const props = defineProps({
    boletos: Array,
    viajes: Array,
    clientes: Array
});

const displayModal = ref(false);
const editMode = ref(false);

const form = useForm({
    id_boleto: null,
    id_viaje: null,
    id_cliente: null,
    asiento: '',
    precio: null,
});

const openNew = () => {
    form.reset();
    editMode.value = false;
    displayModal.value = true;
};

const editBoleto = (data) => {
    form.id_boleto = data.id_boleto;
    form.id_viaje = data.id_viaje;
    form.id_cliente = data.id_cliente;
    form.asiento = data.asiento;
    form.precio = data.precio;
    editMode.value = true;
    displayModal.value = true;
};

const submit = () => {
    if (editMode.value) {
        form.put(route('boletos.update', form.id_boleto), {
            onSuccess: () => displayModal.value = false
        });
    } else {
        form.post(route('boletos.store'), {
            onSuccess: () => displayModal.value = false
        });
    }
};
</script>

<template>
    <Head title="Venta de Boletos" />
    <Layout>
        <div class="bg-[#1a1d2b] p-8 rounded-[2rem] border border-white/5 shadow-2xl min-h-[70vh]">
            
            <transition name="p-message">
                <Message v-if="form.errors.asiento" severity="error" class="mb-6 !bg-red-500/10 !border-red-500/20 !text-red-400">
                    {{ form.errors.asiento }}
                </Message>
            </transition>

            <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 mb-8">
                <div>
                    <h1 class="text-2xl font-bold text-white tracking-tight flex items-center gap-3">
                        <i class="pi pi-ticket text-indigo-500"></i>
                        Control de Boletos
                    </h1>
                    <p class="text-slate-500 text-sm mt-1">Emisión de pasajes, asignación de asientos y precios.</p>
                </div>
                <Button label="Vender Boleto" icon="pi pi-plus" @click="openNew" 
                    class="!bg-indigo-600 !border-none !rounded-xl !px-6 !py-3 shadow-lg shadow-indigo-500/20 hover:!bg-indigo-500 transition-all" />
            </div>

            <DataTable :value="boletos" paginator :rows="10" class="p-datatable-atlantis" responsiveLayout="stack">
                <Column header="ID" class="w-16 text-slate-500 text-xs font-mono">
                    <template #body="{ data }">
                        {{ data.id_boleto }}
                    </template>
                </Column>
                
                <Column header="CLIENTE">
                    <template #body="{ data }">
                        <div class="flex flex-col">
                            <span class="text-white font-medium">{{ data.cliente?.nombre }}</span>
                            <span class="text-[10px] text-indigo-400 font-bold uppercase tracking-widest">Asiento: {{ data.asiento }}</span>
                        </div>
                    </template>
                </Column>

                <Column header="VIAJE / RUTA">
                    <template #body="{ data }">
                        <div class="flex flex-col">
                            <div class="flex items-center gap-2 text-slate-200">
                                <span class="font-bold">{{ data.viaje?.ruta?.origen?.nombre }}</span>
                                <i class="pi pi-arrow-right text-[10px] text-indigo-500"></i>
                                <span class="font-bold">{{ data.viaje?.ruta?.destino?.nombre }}</span>
                            </div>
                            <span class="text-[10px] text-slate-500 font-mono">
                                {{ data.viaje?.fecha_salida }} | {{ data.viaje?.hora_salida }}
                            </span>
                        </div>
                    </template>
                </Column>

                <Column header="PRECIO">
                    <template #body="{ data }">
                        <Tag :value="'Bs ' + data.precio" severity="success" class="!bg-emerald-500/10 !text-emerald-400 !border-emerald-500/20" />
                    </template>
                </Column>

                <Column header="ACCIONES" class="text-right w-32">
                    <template #body="{ data }">
                        <div class="flex justify-end gap-1">
                            <Button icon="pi pi-pencil" text rounded severity="secondary" @click="editBoleto(data)" />
                            <Button icon="pi pi-trash" text rounded severity="danger" 
                                @click="() => { if(confirm('¿Anular este boleto?')) form.delete(route('boletos.destroy', data.id_boleto)) }" />
                        </div>
                    </template>
                </Column>
            </DataTable>
        </div>

        <Dialog v-model:visible="displayModal" :header="editMode ? 'Modificar Boleto' : 'Emitir Nuevo Boleto'" modal 
            class="p-dark w-full max-w-lg" 
            :pt="{ 
                root: { class: 'bg-[#1a1d2b] border border-white/10 shadow-2xl' },
                header: { class: 'bg-[#1a1d2b] text-white border-b border-white/5 p-6' },
                content: { class: 'bg-[#1a1d2b] text-white p-6' }
            }">
            
            <form @submit.prevent="submit" class="grid grid-cols-1 gap-6 pt-2">
                <div class="flex flex-col gap-2">
                    <label class="text-xs font-bold text-slate-500 uppercase tracking-widest">Seleccionar Viaje</label>
                    <Dropdown v-model="form.id_viaje" :options="viajes" optionValue="id_viaje" 
                        placeholder="Elija un viaje programado" filter class="w-full !bg-[#0f111a] !border-white/10">
                        <template #option="slotProps">
                            <div class="flex flex-col text-xs">
                                <span>{{ slotProps.option.ruta.origen.nombre }} - {{ slotProps.option.ruta.destino.nombre }}</span>
                                <span class="text-indigo-400">{{ slotProps.option.fecha_salida }} ({{ slotProps.option.bus.placa }})</span>
                            </div>
                        </template>
                    </Dropdown>
                </div>

                <div class="flex flex-col gap-2">
                    <label class="text-xs font-bold text-slate-500 uppercase tracking-widest">Pasajero</label>
                    <Dropdown v-model="form.id_cliente" :options="clientes" optionLabel="nombre" optionValue="id_cliente" 
                        placeholder="Buscar cliente..." filter class="w-full !bg-[#0f111a] !border-white/10" />
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div class="flex flex-col gap-2">
                        <label class="text-xs font-bold text-slate-500 uppercase tracking-widest">Nº Asiento</label>
                        <InputText v-model="form.asiento" placeholder="Ej. 12A" 
                            class="w-full !bg-[#0f111a] !border-white/10 !text-white font-mono uppercase" />
                    </div>
                    <div class="flex flex-col gap-2">
                        <label class="text-xs font-bold text-slate-500 uppercase tracking-widest">Costo (Bs)</label>
                        <InputNumber v-model="form.precio" :min="0" placeholder="0.00" mode="decimal" :minFractionDigits="2"
                            class="w-full" inputClass="!bg-[#0f111a] !border-white/10 !text-white font-mono" />
                    </div>
                </div>

                <div class="flex justify-end gap-3 mt-4">
                    <Button label="Cancelar" text severity="secondary" @click="displayModal = false" class="!text-slate-400" />
                    <Button :label="editMode ? 'Actualizar' : 'Confirmar Venta'" type="submit" 
                        icon="pi pi-check" :loading="form.processing" class="!bg-indigo-600 !border-none !rounded-xl" />
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
:deep(.p-paginator .p-paginator-pages .p-paginator-page.p-highlight) {
    background: rgba(99, 102, 241, 0.1) !important;
    color: #818cf8 !important;
    border-radius: 10px;
}
</style>