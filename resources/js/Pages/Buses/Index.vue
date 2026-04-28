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

const props = defineProps({
    buses: Array
});

const displayModal = ref(false);
const editMode = ref(false);

const estadosBus = [
    { label: 'Activo / Operativo', value: 'ACTIVO' },
    { label: 'En Mantenimiento', value: 'MANTENIMIENTO' },
    { label: 'Fuera de Servicio', value: 'INACTIVO' }
];

const form = useForm({
    id_bus: null,
    placa: '',
    capacidad: null,
    estado: 'ACTIVO',
});

const openNew = () => {
    form.reset();
    editMode.value = false;
    displayModal.value = true;
};

const editBus = (data) => {
    form.id_bus = data.id_bus;
    form.placa = data.placa;
    form.capacidad = data.capacidad;
    form.estado = data.estado;
    editMode.value = true;
    displayModal.value = true;
};

const submit = () => {
    if (editMode.value) {
        form.put(route('buses.update', form.id_bus), {
            onSuccess: () => displayModal.value = false
        });
    } else {
        form.post(route('buses.store'), {
            onSuccess: () => displayModal.value = false
        });
    }
};

const getSeverity = (estado) => {
    switch (estado) {
        case 'ACTIVO': return 'success';
        case 'MANTENIMIENTO': return 'warning';
        case 'INACTIVO': return 'danger';
        default: return 'info';
    }
};
</script>

<template>
    <Head title="Gestión de Buses" />
    <Layout>
        <div class="bg-[#1a1d2b] p-8 rounded-[2rem] border border-white/5 shadow-2xl min-h-[70vh]">
            
            <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 mb-8">
                <div>
                    <h1 class="text-2xl font-bold text-white tracking-tight flex items-center gap-3">
                        <i class="pi pi-truck text-indigo-500"></i>
                        Flota de Buses
                    </h1>
                    <p class="text-slate-500 text-sm mt-1">Administración de vehículos y capacidad de transporte.</p>
                </div>
                <Button label="Nuevo Bus" icon="pi pi-plus" @click="openNew" 
                    class="!bg-indigo-600 !border-none !rounded-xl !px-6 !py-3 shadow-lg shadow-indigo-500/20 hover:!bg-indigo-500 transition-all" />
            </div>

            <DataTable :value="buses" paginator :rows="10" class="p-datatable-atlantis" responsiveLayout="stack">
                <Column header="ID" class="w-16 text-slate-500 text-xs font-mono">
                    <template #body="{ data }">
                        {{ data.id_bus }}
                    </template>
                </Column>
                
                <Column header="PLACA / IDENTIFICACIÓN">
                    <template #body="{ data }">
                        <div class="flex items-center gap-3">
                            <div class="bg-indigo-500/10 p-2 rounded-lg">
                                <i class="pi pi-credit-card text-indigo-400"></i>
                            </div>
                            <span class="text-white font-bold tracking-widest font-mono uppercase">{{ data.placa }}</span>
                        </div>
                    </template>
                </Column>

                <Column header="CAPACIDAD">
                    <template #body="{ data }">
                        <div class="flex items-center gap-2">
                            <i class="pi pi-users text-slate-500"></i>
                            <span class="text-slate-300 font-bold">{{ data.capacidad }} <small class="text-slate-500">Asientos</small></span>
                        </div>
                    </template>
                </Column>

                <Column header="ESTADO">
                    <template #body="{ data }">
                        <Tag :value="data.estado" :severity="getSeverity(data.estado)" rounded class="!px-4 !py-1 text-[10px]" />
                    </template>
                </Column>

                <Column header="ACCIONES" class="text-right w-32">
                    <template #body="{ data }">
                        <div class="flex justify-end gap-1">
                            <Button icon="pi pi-pencil" text rounded severity="secondary" @click="editBus(data)" />
                            <Button icon="pi pi-trash" text rounded severity="danger" 
                                @click="() => { if(confirm('¿Eliminar este bus de la flota?')) form.delete(route('buses.destroy', data.id_bus)) }" />
                        </div>
                    </template>
                </Column>
            </DataTable>
        </div>

        <Dialog v-model:visible="displayModal" :header="editMode ? 'Editar Bus' : 'Registrar Nuevo Bus'" modal 
            class="p-dark w-full max-w-md"
            :pt="{ 
                root: { class: 'bg-[#1a1d2b] border border-white/10' },
                header: { class: 'bg-[#1a1d2b] text-white p-6' },
                content: { class: 'bg-[#1a1d2b] text-white p-6' }
            }">
            
            <form @submit.prevent="submit" class="grid grid-cols-1 gap-5">
                <div class="flex flex-col gap-2">
                    <label class="text-xs font-bold text-slate-500 uppercase tracking-widest">Número de Placa</label>
                    <InputText v-model="form.placa" placeholder="Ej. 1234-ABC" 
                        class="w-full !bg-[#0f111a] !border-white/10 !text-white !p-3" />
                    <small v-if="form.errors.placa" class="text-red-400">{{ form.errors.placa }}</small>
                </div>

                <div class="flex flex-col gap-2">
                    <label class="text-xs font-bold text-slate-500 uppercase tracking-widest">Capacidad de Pasajeros</label>
                    <InputNumber v-model="form.capacidad" :min="1" placeholder="Cantidad de asientos"
                        inputClass="w-full !bg-[#0f111a] !border-white/10 !text-white !p-3" class="w-full" />
                </div>

                <div class="flex flex-col gap-2">
                    <label class="text-xs font-bold text-slate-500 uppercase tracking-widest">Estado Operativo</label>
                    <Dropdown v-model="form.estado" :options="estadosBus" optionLabel="label" optionValue="value" 
                        class="w-full !bg-[#0f111a] !border-white/10" />
                </div>

                <div class="flex justify-end gap-3 mt-4">
                    <Button label="Cancelar" text severity="secondary" @click="displayModal = false" class="!text-slate-400" />
                    <Button :label="editMode ? 'Actualizar' : 'Guardar Bus'" type="submit" 
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