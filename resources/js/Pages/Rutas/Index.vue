<script setup>
import { ref } from 'vue';
import { useForm, Head } from '@inertiajs/vue3';
import Layout from '@/Layouts/Layout.vue';

// PrimeVue
import DataTable from 'primevue/datatable';
import Column from 'primevue/column';
import Button from 'primevue/button';
import Dialog from 'primevue/dialog';
import InputNumber from 'primevue/inputnumber';
import Dropdown from 'primevue/dropdown';
import Tag from 'primevue/tag';

const props = defineProps({
    rutas: Array,
    terminales: Array
});

const displayModal = ref(false);
const editMode = ref(false);

const form = useForm({
    id_ruta: null,
    id_origen: null,
    id_destino: null,
    distancia: null,
    duracion_estimada: null,
});

const openNew = () => {
    form.reset();
    editMode.value = false;
    displayModal.value = true;
};

const editRuta = (data) => {
    form.id_ruta = data.id_ruta;
    form.id_origen = data.id_origen;
    form.id_destino = data.id_destino;
    form.distancia = data.distancia;
    form.duracion_estimada = data.duracion_estimada;
    editMode.value = true;
    displayModal.value = true;
};

const submit = () => {
    if (editMode.value) {
        form.put(route('rutas.update', form.id_ruta), {
            onSuccess: () => displayModal.value = false
        });
    } else {
        form.post(route('rutas.store'), {
            onSuccess: () => displayModal.value = false
        });
    }
};

const deleteRuta = (id) => {
    if (confirm('¿Deseas eliminar esta ruta?')) {
        form.delete(route('rutas.destroy', id));
    }
};
</script>

<template>
    <Head title="Gestión de Rutas" />
    <Layout>
        <div class="bg-[#1a1d2b] p-8 rounded-[2rem] border border-white/5 shadow-2xl min-h-[70vh]">
            
            <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 mb-8">
                <div>
                    <h1 class="text-2xl font-bold text-white tracking-tight flex items-center gap-3">
                        <i class="pi pi-map text-indigo-500"></i>
                        Itinerarios de Ruta
                    </h1>
                    <p class="text-slate-500 text-sm mt-1">Definición de trayectos, distancias y tiempos de viaje.</p>
                </div>
                <Button label="Nueva Ruta" icon="pi pi-plus" @click="openNew" 
                    class="!bg-indigo-600 !border-none !rounded-xl !px-6 !py-3 shadow-lg shadow-indigo-500/20 hover:!bg-indigo-500 transition-all" />
            </div>

            <DataTable :value="rutas" paginator :rows="10" class="p-datatable-atlantis" responsiveLayout="stack">
                <Column header="ID" class="w-16 text-slate-500 text-xs font-mono">
                    <template #body="{ data }">
                        {{ data.id_ruta }}
                    </template>
                </Column>
                
                <Column header="TRAYECTO (ORIGEN ➔ DESTINO)">
                    <template #body="{ data }">
                        <div class="flex items-center gap-4">
                            <div class="flex flex-col">
                                <span class="font-bold text-white">{{ data.origen?.nombre }}</span>
                                <span class="text-[10px] text-slate-500 uppercase tracking-widest">Salida</span>
                            </div>
                            <i class="pi pi-arrow-right text-indigo-500 text-xs"></i>
                            <div class="flex flex-col">
                                <span class="font-bold text-white">{{ data.destino?.nombre }}</span>
                                <span class="text-[10px] text-slate-500 uppercase tracking-widest">Llegada</span>
                            </div>
                        </div>
                    </template>
                </Column>

                <Column header="DISTANCIA">
                    <template #body="{ data }">
                        <div class="flex items-center gap-2">
                            <i class="pi pi-directions text-slate-500 text-sm"></i>
                            <span class="text-slate-300 font-mono">{{ data.distancia }} <small class="text-slate-500 text-[10px]">KM</small></span>
                        </div>
                    </template>
                </Column>

                <Column header="DURACIÓN">
                    <template #body="{ data }">
                        <Tag :value="data.duracion_estimada + ' Horas'" 
                            class="!bg-emerald-500/10 !text-emerald-400 !border !border-emerald-500/20 !font-mono" />
                    </template>
                </Column>

                <Column header="ACCIONES" class="text-right w-32">
                    <template #body="{ data }">
                        <div class="flex justify-end gap-1">
                            <Button icon="pi pi-pencil" text rounded severity="secondary" @click="editRuta(data)" />
                            <Button icon="pi pi-trash" text rounded severity="danger" @click="deleteRuta(data.id_ruta)" />
                        </div>
                    </template>
                </Column>
            </DataTable>
        </div>

        <Dialog v-model:visible="displayModal" :header="editMode ? 'Editar Ruta' : 'Crear Nueva Ruta'" modal 
            class="p-dark w-full max-w-lg" 
            :pt="{ 
                root: { class: 'bg-[#1a1d2b] border border-white/10 shadow-2xl' },
                header: { class: 'bg-[#1a1d2b] text-white border-b border-white/5 p-6' },
                content: { class: 'bg-[#1a1d2b] text-white p-6' }
            }">
            
            <form @submit.prevent="submit" class="grid grid-cols-1 gap-6 pt-2">
                
                <div class="grid grid-cols-2 gap-4">
                    <div class="flex flex-col gap-2">
                        <label class="text-xs font-bold text-slate-500 uppercase tracking-widest">Terminal Origen</label>
                        <Dropdown v-model="form.id_origen" :options="terminales" optionLabel="nombre" optionValue="id_terminal" 
                            filter placeholder="Origen" class="w-full !bg-[#0f111a] !border-white/10" />
                        <small v-if="form.errors.id_origen" class="text-red-400 text-[10px]">{{ form.errors.id_origen }}</small>
                    </div>

                    <div class="flex flex-col gap-2">
                        <label class="text-xs font-bold text-slate-500 uppercase tracking-widest">Terminal Destino</label>
                        <Dropdown v-model="form.id_destino" :options="terminales" optionLabel="nombre" optionValue="id_terminal" 
                            filter placeholder="Destino" class="w-full !bg-[#0f111a] !border-white/10" />
                        <small v-if="form.errors.id_destino" class="text-red-400 text-[10px]">{{ form.errors.id_destino }}</small>
                    </div>
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div class="flex flex-col gap-2">
                        <label class="text-xs font-bold text-slate-500 uppercase tracking-widest">Distancia (Km)</label>
                        <InputNumber v-model="form.distancia" mode="decimal" :minFractionDigits="2" 
                            class="w-full" inputClass="!bg-[#0f111a] !border-white/10 !text-white" />
                    </div>

                    <div class="flex flex-col gap-2">
                        <label class="text-xs font-bold text-slate-500 uppercase tracking-widest">Duración (Hrs)</label>
                        <InputNumber v-model="form.duracion_estimada" mode="decimal" :minFractionDigits="1" 
                            class="w-full" inputClass="!bg-[#0f111a] !border-white/10 !text-white" />
                    </div>
                </div>

                <div class="flex justify-end gap-3 mt-4">
                    <Button label="Cerrar" text severity="secondary" @click="displayModal = false" class="!text-slate-400" />
                    <Button :label="editMode ? 'Actualizar Ruta' : 'Guardar Trayecto'" type="submit" 
                        icon="pi pi-check" :loading="form.processing" class="!bg-indigo-600 !border-none !rounded-xl shadow-lg shadow-indigo-500/20" />
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