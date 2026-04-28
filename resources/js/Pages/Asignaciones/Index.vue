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
import Message from 'primevue/message';

const props = defineProps({
    asignaciones: Array,
    viajes: Array,
    empleados: Array
});

const displayModal = ref(false);
const editMode = ref(false);

const form = useForm({
    id_asignacion: null,
    id_viaje: null,
    id_empleado: null,
    fecha_asignacion: new Date().toISOString().slice(0, 10),
});

const openNew = () => {
    form.reset();
    form.fecha_asignacion = new Date().toISOString().slice(0, 10);
    editMode.value = false;
    displayModal.value = true;
};

const editAsignacion = (data) => {
    form.id_asignacion = data.id_asignacion;
    form.id_viaje = data.id_viaje;
    form.id_empleado = data.id_empleado;
    form.fecha_asignacion = data.fecha_asignacion;
    editMode.value = true;
    displayModal.value = true;
};

const submit = () => {
    if (editMode.value) {
        form.put(route('asignaciones.update', form.id_asignacion), {
            onSuccess: () => displayModal.value = false
        });
    } else {
        form.post(route('asignaciones.store'), {
            onSuccess: () => displayModal.value = false
        });
    }
};
</script>

<template>
    <Head title="Asignación de Personal" />
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
                        <i class="pi pi-users text-indigo-500"></i>
                        Asignaciones de Personal
                    </h1>
                    <p class="text-slate-500 text-sm mt-1">Vinculación de conductores y personal a viajes programados.</p>
                </div>
                <Button label="Asignar Personal" icon="pi pi-plus" @click="openNew" 
                    class="!bg-indigo-600 !border-none !rounded-xl shadow-lg shadow-indigo-500/20 hover:!bg-indigo-500 transition-all" />
            </div>

            <DataTable :value="asignaciones" paginator :rows="10" class="p-datatable-atlantis" responsiveLayout="stack">
                <Column header="ID" class="w-16 text-slate-500 text-xs font-mono">
                    <template #body="{ data }">
                        {{ data.id_asignacion }}
                    </template>
                </Column>
                
                <Column header="PERSONAL / EMPLEADO">
                    <template #body="{ data }">
                        <div class="flex items-center gap-3">
                            <div class="w-9 h-9 rounded-lg bg-indigo-500/10 flex items-center justify-center text-indigo-400 border border-indigo-500/20 shadow-inner">
                                <i class="pi pi-user text-xs"></i>
                            </div>
                            <div class="flex flex-col">
                                <span class="text-white font-semibold tracking-wide">{{ data.empleado?.nombre }}</span>
                                <span class="text-[10px] text-indigo-400 font-bold uppercase tracking-widest">Personal de Ruta</span>
                            </div>
                        </div>
                    </template>
                </Column>

                <Column header="VIAJE ASIGNADO">
                    <template #body="{ data }">
                        <div class="flex flex-col">
                            <div class="text-sm text-slate-200 font-medium flex items-center gap-2">
                                <span>{{ data.viaje?.ruta?.origen?.nombre }}</span>
                                <i class="pi pi-arrow-right text-[10px] text-indigo-500"></i>
                                <span>{{ data.viaje?.ruta?.destino?.nombre }}</span>
                            </div>
                            <div class="text-[10px] text-slate-500 font-mono mt-1 uppercase">
                                <i class="pi pi-calendar text-[9px] mr-1"></i> Salida: {{ data.viaje?.fecha_salida }}
                            </div>
                        </div>
                    </template>
                </Column>

                <Column header="FECHA REGISTRO">
                    <template #body="{ data }">
                        <span class="text-slate-500 font-mono text-xs">{{ data.fecha_asignacion }}</span>
                    </template>
                </Column>

                <Column header="ACCIONES" class="text-right w-32">
                    <template #body="{ data }">
                        <div class="flex justify-end gap-1">
                            <Button icon="pi pi-pencil" text rounded severity="secondary" @click="editAsignacion(data)" />
                            <Button icon="pi pi-trash" text rounded severity="danger" 
                                @click="() => { if(confirm('¿Eliminar esta asignación?')) $inertia.delete(route('asignaciones.destroy', data.id_asignacion)) }" />
                        </div>
                    </template>
                </Column>
            </DataTable>
        </div>

        <Dialog v-model:visible="displayModal" :header="editMode ? 'Modificar Asignación' : 'Vincular Personal a Viaje'" modal 
            class="p-dark w-full max-w-lg"
            :pt="{ 
                root: { class: 'bg-[#1a1d2b] border border-white/10 shadow-2xl rounded-[1.5rem]' },
                header: { class: 'bg-[#1a1d2b] text-white border-b border-white/5 p-6' },
                content: { class: 'bg-[#1a1d2b] text-white p-6' }
            }">
            
            <form @submit.prevent="submit" class="grid grid-cols-1 gap-6 pt-2">
                <div class="flex flex-col gap-2">
                    <label class="text-xs font-bold text-slate-500 uppercase tracking-widest px-1">Seleccionar Personal</label>
                    <Dropdown v-model="form.id_empleado" :options="empleados" optionLabel="nombre" optionValue="id_empleado" 
                        filter placeholder="Buscar empleado..." 
                        class="w-full !bg-[#0f111a] !border-white/10 !rounded-xl !py-1"
                        panelClass="p-dark-panel" />
                    <small v-if="form.errors.id_empleado" class="text-red-400 text-[10px]">{{ form.errors.id_empleado }}</small>
                </div>

                <div class="flex flex-col gap-2">
                    <label class="text-xs font-bold text-slate-500 uppercase tracking-widest px-1">Seleccionar Viaje Programado</label>
                    <Dropdown v-model="form.id_viaje" :options="viajes" 
                        :optionLabel="(v) => `${v.ruta?.origen?.nombre} ➔ ${v.ruta?.destino?.nombre} [${v.fecha_salida}]`" 
                        optionValue="id_viaje" filter placeholder="Buscar viaje por destino o fecha..." 
                        class="w-full !bg-[#0f111a] !border-white/10 !rounded-xl !py-1"
                        panelClass="p-dark-panel" />
                    <small v-if="form.errors.id_viaje" class="text-red-400 text-[10px]">{{ form.errors.id_viaje }}</small>
                </div>

                <div class="flex flex-col gap-2">
                    <label class="text-xs font-bold text-slate-500 uppercase tracking-widest px-1">Fecha de la Operación</label>
                    <input type="date" v-model="form.fecha_asignacion" 
                        class="w-full bg-[#0f111a] border border-white/10 text-white rounded-xl p-3 outline-none focus:border-indigo-500 transition-all font-mono" />
                    <small v-if="form.errors.fecha_asignacion" class="text-red-400 text-[10px]">{{ form.errors.fecha_asignacion }}</small>
                </div>

                <div class="flex justify-end gap-3 mt-4 border-t border-white/5 pt-6">
                    <Button label="Cancelar" text severity="secondary" @click="displayModal = false" class="!text-slate-400" />
                    <Button :label="editMode ? 'Actualizar Registro' : 'Confirmar Asignación'" type="submit" 
                        icon="pi pi-check" :loading="form.processing" 
                        class="!bg-indigo-600 !border-none !rounded-xl !px-6 shadow-lg shadow-indigo-500/20" />
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
    border-radius: 10px;
}

/* Estilo para el panel del dropdown en modo oscuro */
:deep(.p-dark-panel) {
    background: #1a1d2b !important;
    border: 1px solid rgba(255,255,255,0.1) !important;
    color: white !important;
}
:deep(.p-dropdown-item) {
    color: #cbd5e1 !important;
}
:deep(.p-dropdown-item:hover) {
    background: rgba(99, 102, 241, 0.1) !important;
    color: #818cf8 !important;
}
</style>