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
import Dropdown from 'primevue/dropdown';
import Tag from 'primevue/tag';

const props = defineProps({
    viajes: Array,
    rutas: Array,
    buses: Array
});

const displayModal = ref(false);
const editMode = ref(false);

const estados = [
    { label: 'Programado', value: 'PROGRAMADO' },
    { label: 'En Curso', value: 'EN_CURSO' },
    { label: 'Finalizado', value: 'FINALIZADO' }
];

const form = useForm({
    id_viaje: null,
    id_ruta: null,
    id_bus: null,
    fecha_salida: '',
    hora_salida: '',
    estado: 'PROGRAMADO',
});

const openNew = () => {
    form.reset();
    editMode.value = false;
    displayModal.value = true;
};

const editViaje = (data) => {
    form.id_viaje = data.id_viaje;
    form.id_ruta = data.id_ruta;
    form.id_bus = data.id_bus;
    form.fecha_salida = data.fecha_salida;
    form.hora_salida = data.hora_salida;
    form.estado = data.estado;
    editMode.value = true;
    displayModal.value = true;
};

const submit = () => {
    if (editMode.value) {
        form.put(route('viajes.update', form.id_viaje), {
            onSuccess: () => displayModal.value = false
        });
    } else {
        form.post(route('viajes.store'), {
            onSuccess: () => displayModal.value = false
        });
    }
};

const getSeverity = (estado) => {
    switch (estado) {
        case 'PROGRAMADO': return 'info';
        case 'EN_CURSO': return 'warning';
        case 'FINALIZADO': return 'success';
        default: return 'secondary';
    }
};

const deleteViaje = (id) => {
    if (confirm('¿Deseas eliminar este viaje programado?')) {
        form.delete(route('viajes.destroy', id));
    }
};
</script>

<template>

    <Head title="Control de Viajes" />
    <Layout>
        <div class="bg-[#1a1d2b] p-8 rounded-[2rem] border border-white/5 shadow-2xl min-h-[70vh]">

            <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 mb-8">
                <div>
                    <h1 class="text-2xl font-bold text-white tracking-tight flex items-center gap-3">
                        <i class="pi pi-calendar text-indigo-500"></i>
                        Programación de Viajes
                    </h1>
                    <p class="text-slate-500 text-sm mt-1">Gestión de salidas, asignación de buses y monitoreo de
                        estados.</p>
                </div>
                <Button label="Programar Viaje" icon="pi pi-plus" @click="openNew"
                    class="!bg-indigo-600 !border-none !rounded-xl !px-6 !py-3 shadow-lg shadow-indigo-500/20" />
            </div>

            <DataTable :value="viajes" paginator :rows="10" class="p-datatable-atlantis" responsiveLayout="stack">
                <Column field="id_viaje" header="ID" class="w-16 text-slate-500 text-xs font-mono"></Column>

                <Column header="RUTA">
                    <template #body="{ data }">
                        <div class="flex flex-col">
                            <span class="text-white font-semibold">
                                {{ data.ruta?.origen?.nombre }} ➔ {{ data.ruta?.destino?.nombre }}
                            </span>
                            <span class="text-[10px] text-indigo-950 uppercase tracking-widest font-bold">
                                Ruta #{{ data.id_ruta }}
                            </span>
                        </div>
                    </template>
                </Column>

                <Column header="BUS ASIGNADO">
                    <template #body="{ data }">
                        <div class="flex items-center gap-2 text-slate-300">
                            <i class="pi pi-truck text-xs"></i>
                            <span>{{ data.bus?.placa || 'N/A' }}</span>
                        </div>
                    </template>
                </Column>

                <Column header="SALIDA">
                    <template #body="{ data }">
                        <div class="flex flex-col">
                            <span class="text-white text-sm font-mono">{{ data.fecha_salida }}</span>
                            <span class="text-slate-500 text-xs">{{ data.hora_salida }}</span>
                        </div>
                    </template>
                </Column>

                <Column header="ESTADO">
                    <template #body="{ data }">
                        <Tag :value="data.estado" :severity="getSeverity(data.estado)" class="!px-3" />
                    </template>
                </Column>

                <Column header="ACCIONES" class="text-right w-32">
                    <template #body="{ data }">
                        <div class="flex justify-end gap-1">
                            <Button icon="pi pi-pencil" text rounded severity="secondary" @click="editViaje(data)" />
                            <Button icon="pi pi-trash" text rounded severity="danger"
                                @click="deleteViaje(data.id_viaje)" />
                        </div>
                    </template>
                </Column>
            </DataTable>
        </div>

        <Dialog v-model:visible="displayModal" :header="editMode ? 'Modificar Viaje' : 'Programar Nueva Salida'" modal
            class="p-dark w-full max-w-lg" :pt="{
                root: { class: 'bg-[#1a1d2b] border border-white/10' },
                header: { class: 'bg-[#1a1d2b] text-white border-b border-white/5 p-6' },
                content: { class: 'bg-[#1a1d2b] text-white p-6' }
            }">

            <form @submit.prevent="submit" class="grid grid-cols-1 gap-6 pt-2">
                <div class="flex flex-col gap-2">
                    <label class="text-xs font-bold text-slate-500 uppercase tracking-widest">Seleccionar Ruta</label>
                    <Dropdown v-model="form.id_ruta" :options="rutas" optionValue="id_ruta"
                        placeholder="Origen - Destino" class="w-full !bg-[#0f111a] !border-white/10">
                        <template #option="slotProps" class="text-gray-300">
                            {{ slotProps.option.origen?.nombre }} ➔ {{ slotProps.option.destino?.nombre }}
                        </template>
                        <template #value="slotProps">
                            <div v-if="slotProps.value">
                                {{rutas.find(r => r.id_ruta === slotProps.value)?.origen?.nombre}} ➔
                                {{rutas.find(r => r.id_ruta === slotProps.value)?.destino?.nombre}}
                            </div>
                            <span v-else>{{ slotProps.placeholder }}</span>
                        </template>
                    </Dropdown>
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div class="flex flex-col gap-2">
                        <label class="text-xs font-bold text-slate-500 uppercase tracking-widest">Bus</label>
                        <Dropdown v-model="form.id_bus" :options="buses" optionLabel="placa" optionValue="id_bus"
                            class="w-full !bg-[#0f111a] !border-white/10" />
                    </div>
                    <div class="flex flex-col gap-2">
                        <label class="text-xs font-bold text-slate-500 uppercase tracking-widest">Estado</label>
                        <Dropdown v-model="form.estado" :options="estados" optionLabel="label" optionValue="value"
                            class="w-full !bg-[#0f111a] !border-white/10" />
                    </div>
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div class="flex flex-col gap-2">
                        <label class="text-xs font-bold text-slate-500 uppercase tracking-widest">Fecha Salida</label>
                        <input type="date" v-model="form.fecha_salida"
                            class="w-full !bg-[#0f111a] !border-white/10 !text-white rounded-lg p-2 outline-none" />
                    </div>
                    <div class="flex flex-col gap-2">
                        <label class="text-xs font-bold text-slate-500 uppercase tracking-widest">Hora Salida</label>
                        <input type="time" v-model="form.hora_salida"
                            class="w-full !bg-[#0f111a] !border-white/10 !text-white rounded-lg p-2 outline-none" />
                    </div>
                </div>

                <div class="flex justify-end gap-3 mt-4">
                    <Button label="Cancelar" text severity="secondary" @click="displayModal = false"
                        class="!text-slate-400" />
                    <Button :label="editMode ? 'Actualizar' : 'Guardar'" type="submit" icon="pi pi-check"
                        :loading="form.processing" class="!bg-indigo-600 !border-none !rounded-xl" />
                </div>
            </form>
        </Dialog>
    </Layout>
</template>

<style scoped>
:deep(.p-datatable-atlantis) {
    background: transparent;
}

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
}

:deep(.p-paginator button) {
    color: #64748b !important;
}
</style>