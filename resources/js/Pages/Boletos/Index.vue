<script setup>
import { ref, computed } from 'vue';
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

const props = defineProps({
    boletos: Array,
    viajes: Array,
    clientes: Array // Ahora usamos clientes en lugar de pasajeros
});

const displayModal = ref(false);
const editMode = ref(false);

const form = useForm({
    id_boleto: null,
    id_viaje: null,
    id_cliente: null, // Cambio de id_pasajero a id_cliente
    asiento: '',
    precio: null,
});

// Formatear opciones de viajes para el Dropdown
const viajeOptions = computed(() => {
    return props.viajes.map(v => ({
        id: v.id_viaje,
        label: `${v.ruta?.origen?.nombre || 'S/O'} ➔ ${v.ruta?.destino?.nombre || 'S/D'} (${v.fecha_salida})`
    }));
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

const deleteBoleto = (id) => {
    if (confirm('¿Confirmas la anulación de este boleto?')) {
        form.delete(route('boletos.destroy', id));
    }
};
</script>

<template>
    <Head title="Gestión de Boletos" />
    <Layout>
        <div class="bg-[#1a1d2b] p-8 rounded-[2rem] border border-white/5 shadow-2xl">
            <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 mb-8">
                <div>
                    <h1 class="text-2xl font-bold text-white tracking-tight flex items-center gap-3">
                        <i class="pi pi-ticket text-indigo-500"></i>
                        Venta de Boletos
                    </h1>
                    <p class="text-slate-500 text-sm mt-1">Control de pasajes emitidos a clientes registrados.</p>
                </div>
                <Button label="Nueva Venta" icon="pi pi-plus" @click="openNew" class="!bg-indigo-600 !border-none !rounded-xl !px-6 !py-3 shadow-lg shadow-indigo-500/20" />
            </div>

            <DataTable :value="boletos" paginator :rows="10" class="p-datatable-" responsiveLayout="stack">
                <Column field="id_boleto" header="ID" class="w-16 text-slate-500 text-xs"></Column>
                
                <Column header="CLIENTE / PASAJERO">
                    <template #body="{ data }">
                        <div class="flex flex-col">
                            <span class="font-semibold text-white">{{ data.cliente?.nombre || 'Cliente no encontrado' }}</span>
                            <span class="text-xs text-slate-500">{{ data.cliente?.documento_identidad || 'Sin Documento' }}</span>
                        </div>
                    </template>
                </Column>

                <Column header="RUTA / DESTINO">
                    <template #body="{ data }">
                        <div class="flex items-center gap-2 text-slate-300 text-sm">
                            <i class="pi pi-map-marker text-indigo-400 text-xs"></i>
                            <span>
                                {{ data.viaje?.ruta?.origen?.nombre || '???' }} 
                                ➔ 
                                {{ data.viaje?.ruta?.destino?.nombre || '???' }}
                            </span>
                        </div>
                        <div class="text-[10px] text-slate-500 mt-1 uppercase tracking-wider">
                            Salida: {{ data.viaje?.fecha_salida }} | {{ data.viaje?.hora_salida }}
                        </div>
                    </template>
                </Column>

                <Column field="asiento" header="ASIENTO">
                    <template #body="{ data }">
                        <Tag :value="'Asiento ' + data.asiento" severity="info" class="!bg-indigo-500/10 !text-indigo-300 !border !border-indigo-500/20" />
                    </template>
                </Column>

                <Column header="PRECIO">
                    <template #body="{ data }">
                        <span class="text-green-400 font-mono font-bold">{{ data.precio }} BOB</span>
                    </template>
                </Column>

                <Column header="ACCIONES" class="text-right w-32">
                    <template #body="{ data }">
                        <div class="flex justify-end gap-1">
                            <Button icon="pi pi-pencil" text rounded severity="secondary" @click="editBoleto(data)" />
                            <Button icon="pi pi-trash" text rounded severity="danger" @click="deleteBoleto(data.id_boleto)" />
                        </div>
                    </template>
                </Column>
            </DataTable>
        </div>

        <Dialog v-model:visible="displayModal" :header="editMode ? 'Editar Boleto' : 'Emitir Nuevo Boleto'" modal class="p-dark w-full max-w-lg">
            <form @submit.prevent="submit" class="grid grid-cols-1 gap-6 pt-4">
                
                <div class="flex flex-col gap-2">
                    <label class="text-xs font-bold text-slate-500 uppercase tracking-widest">Cliente</label>
                    <Dropdown v-model="form.id_cliente" :options="clientes" optionLabel="nombre" optionValue="id_cliente" 
                        placeholder="Seleccionar Cliente" filter class="w-full" />
                    <small v-if="form.errors.id_cliente" class="text-red-400">{{ form.errors.id_cliente }}</small>
                </div>

                <div class="flex flex-col gap-2">
                    <label class="text-xs font-bold text-slate-500 uppercase tracking-widest">Viaje Disponible</label>
                    <Dropdown v-model="form.id_viaje" :options="viajeOptions" optionLabel="label" optionValue="id" 
                        placeholder="Destino y Fecha" filter class="w-full" />
                    <small v-if="form.errors.id_viaje" class="text-red-400">{{ form.errors.id_viaje }}</small>
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div class="flex flex-col gap-2">
                        <label class="text-xs font-bold text-slate-500 uppercase tracking-widest">Nº Asiento</label>
                        <InputText v-model="form.asiento" placeholder="A-12" class="w-full" />
                        <small v-if="form.errors.asiento" class="text-red-400">{{ form.errors.asiento }}</small>
                    </div>

                    <div class="flex flex-col gap-2">
                        <label class="text-xs font-bold text-slate-500 uppercase tracking-widest">Precio Final</label>
                        <InputNumber v-model="form.precio" mode="decimal" :minFractionDigits="2" suffix=" BOB" class="w-full" />
                        <small v-if="form.errors.precio" class="text-red-400">{{ form.errors.precio }}</small>
                    </div>
                </div>

                <div class="flex justify-end gap-3 mt-4">
                    <Button label="Cerrar" text severity="secondary" @click="displayModal = false" />
                    <Button :label="editMode ? 'Actualizar' : 'Confirmar Venta'" type="submit" 
                        icon="pi pi-check" :loading="form.processing" class="!bg-indigo-600 !border-none" />
                </div>
            </form>
        </Dialog>
    </Layout>
</template>

<style scoped>
:deep(.p-datatable-atlantis) { background: transparent; }
:deep(.p-datatable-thead > tr > th) {
    background: rgba(255, 255, 255, 0.02) !important;
    color: #6366f1 !important;
    font-size: 0.7rem;
    padding: 1.25rem 1rem;
    border-bottom: 1px solid rgba(255, 255, 255, 0.05);
}
:deep(.p-datatable-tbody > tr) {
    background: transparent !important;
    border-bottom: 1px solid rgba(255, 255, 255, 0.02);
}
</style>