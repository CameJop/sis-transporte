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
    empleados: Array
});

const displayModal = ref(false);
const editMode = ref(false);

const roles = [
    { label: 'Administrativo', value: 'EMPLEADO' },
    { label: 'Conductor', value: 'CONDUCTOR' }
];

const estados = [
    { label: 'Activo', value: 'ACTIVO' },
    { label: 'Inactivo', value: 'INACTIVO' }
];

const form = useForm({
    id_empleado: null,
    nombre: '',
    telefono: '',
    licencia: '',
    rol: 'EMPLEADO',
    estado: 'ACTIVO',
});

const openNew = () => {
    form.reset();
    editMode.value = false;
    displayModal.value = true;
};

const editEmpleado = (data) => {
    form.id_empleado = data.id_empleado;
    form.nombre = data.nombre;
    form.telefono = data.telefono;
    form.licencia = data.licencia;
    form.rol = data.rol;
    form.estado = data.estado;
    editMode.value = true;
    displayModal.value = true;
};

const submit = () => {
    if (editMode.value) {
        form.put(route('empleados.update', form.id_empleado), {
            onSuccess: () => displayModal.value = false
        });
    } else {
        form.post(route('empleados.store'), {
            onSuccess: () => displayModal.value = false
        });
    }
};

const deleteEmpleado = (id) => {
    if (confirm('¿Confirmas la eliminación de este empleado?')) {
        form.delete(route('empleados.destroy', id));
    }
};
</script>

<template>
    <Head title="Gestión de Personal" />
    <Layout>
        <div class="bg-[#1a1d2b] p-8 rounded-[2rem] border border-white/5 shadow-2xl min-h-[70vh]">
            
            <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 mb-8">
                <div>
                    <h1 class="text-2xl font-bold text-white tracking-tight flex items-center gap-3">
                        <i class="pi pi-users text-indigo-500"></i>
                        Gestión de Personal
                    </h1>
                    <p class="text-slate-500 text-sm mt-1">Control de conductores y personal administrativo.</p>
                </div>
                <Button label="Nuevo Registro" icon="pi pi-plus" @click="openNew" 
                    class="!bg-indigo-600 !border-none !rounded-xl !px-6 !py-3 shadow-lg shadow-indigo-500/20 hover:!bg-indigo-500 transition-all" />
            </div>

            <DataTable :value="empleados" paginator :rows="10" class="p-datatable-atlantis" responsiveLayout="stack">
                <Column field="id_empleado" header="ID" class="w-16 text-slate-500 text-xs font-mono"></Column>
                
                <Column header="EMPLEADO / STAFF">
                    <template #body="{ data }">
                        <div class="flex flex-col">
                            <span class="font-semibold text-white">{{ data.nombre }}</span>
                            <span class="text-xs text-slate-500 flex items-center gap-1">
                                <i class="pi pi-phone text-[10px]"></i> {{ data.telefono || 'Sin número' }}
                            </span>
                        </div>
                    </template>
                </Column>

                <Column header="ROL Y LICENCIA">
                    <template #body="{ data }">
                        <div class="flex flex-col gap-1">
                            <div>
                                <Tag :value="data.rol" :severity="data.rol === 'CONDUCTOR' ? 'info' : 'secondary'" 
                                    class="!bg-indigo-500/10 !text-indigo-300 !border !border-indigo-500/20 !px-3" />
                            </div>
                            <span v-if="data.licencia" class="text-[10px] text-slate-400 font-mono tracking-wider">
                                <i class="pi pi-id-card mr-1"></i>{{ data.licencia }}
                            </span>
                        </div>
                    </template>
                </Column>

                <Column header="ESTADO">
                    <template #body="{ data }">
                        <Tag :value="data.estado" 
                            :class="data.estado === 'ACTIVO' ? '!bg-emerald-500/10 !text-emerald-400 !border-emerald-500/20' : '!bg-red-500/10 !text-red-400 !border-red-500/20'" 
                            class="!border" rounded />
                    </template>
                </Column>

                <Column header="ACCIONES" class="text-right w-32">
                    <template #body="{ data }">
                        <div class="flex justify-end gap-1">
                            <Button icon="pi pi-pencil" text rounded severity="secondary" @click="editEmpleado(data)" />
                            <Button icon="pi pi-trash" text rounded severity="danger" @click="deleteEmpleado(data.id_empleado)" />
                        </div>
                    </template>
                </Column>
            </DataTable>
        </div>

        <Dialog v-model:visible="displayModal" :header="editMode ? 'Editar Personal' : 'Registrar Nuevo Staff'" modal 
            class="p-dark w-full max-w-lg" 
            :pt="{ 
                root: { class: 'bg-[#1a1d2b] border border-white/10' },
                header: { class: 'bg-[#1a1d2b] text-white border-b border-white/5 p-6' },
                content: { class: 'bg-[#1a1d2b] text-white p-6' }
            }">
            
            <form @submit.prevent="submit" class="grid grid-cols-1 gap-6 pt-2">
                
                <div class="flex flex-col gap-2">
                    <label class="text-xs font-bold text-slate-500 uppercase tracking-widest">Nombre Completo</label>
                    <InputText v-model="form.nombre" placeholder="Nombre del empleado" 
                        class="w-full !bg-[#0f111a] !border-white/10 !text-white focus:!border-indigo-500" />
                    <small v-if="form.errors.nombre" class="text-red-400">{{ form.errors.nombre }}</small>
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div class="flex flex-col gap-2">
                        <label class="text-xs font-bold text-slate-500 uppercase tracking-widest">Teléfono</label>
                        <InputText v-model="form.telefono" placeholder="Ej. 77712345" 
                            class="w-full !bg-[#0f111a] !border-white/10 !text-white focus:!border-indigo-500" />
                    </div>

                    <div class="flex flex-col gap-2">
                        <label class="text-xs font-bold text-slate-500 uppercase tracking-widest">Rol / Función</label>
                        <Dropdown v-model="form.rol" :options="roles" optionLabel="label" optionValue="value" 
                            class="w-full !bg-[#0f111a] !border-white/10 !text-white" />
                    </div>
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div class="flex flex-col gap-2">
                        <label class="text-xs font-bold text-slate-500 uppercase tracking-widest">Nº Licencia</label>
                        <InputText v-model="form.licencia" placeholder="Opcional" 
                            :disabled="form.rol !== 'CONDUCTOR'" 
                            class="w-full !bg-[#0f111a] !border-white/10 !text-white focus:!border-indigo-500 font-mono uppercase" />
                    </div>

                    <div class="flex flex-col gap-2">
                        <label class="text-xs font-bold text-slate-500 uppercase tracking-widest">Estado</label>
                        <Dropdown v-model="form.estado" :options="estados" optionLabel="label" optionValue="value" 
                            class="w-full !bg-[#0f111a] !border-white/10 !text-white" />
                    </div>
                </div>

                <div class="flex justify-end gap-3 mt-4">
                    <Button label="Cerrar" text severity="secondary" @click="displayModal = false" class="!text-slate-400" />
                    <Button :label="editMode ? 'Actualizar' : 'Guardar Registro'" type="submit" 
                        icon="pi pi-check" :loading="form.processing" class="!bg-indigo-600 !border-none !rounded-xl" />
                </div>
            </form>
        </Dialog>
    </Layout>
</template>

<style scoped>
/* Estilos específicos para forzar el modo oscuro en la tabla */
:deep(.p-datatable-atlantis) { 
    background: transparent; 
}

:deep(.p-datatable-thead > tr > th) {
    background: rgba(255, 255, 255, 0.02) !important;
    color: #818cf8 !important; /* Indigo 400 */
    font-size: 0.75rem;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 0.05em;
    padding: 1.25rem 1rem;
    border-bottom: 1px solid rgba(255, 255, 255, 0.05);
}

:deep(.p-datatable-tbody > tr) {
    background: transparent !important;
    color: #cbd5e1; /* Slate 300 */
    border-bottom: 1px solid rgba(255, 255, 255, 0.02);
    transition: background 0.2s;
}

:deep(.p-datatable-tbody > tr:hover) {
    background: rgba(255, 255, 255, 0.01) !important;
}

/* Estilos de paginación oscuros */
:deep(.p-paginator) {
    background: transparent !important;
    border: none;
    padding: 1rem 0;
}

:deep(.p-paginator .p-paginator-pages .p-paginator-page.p-highlight) {
    background: rgba(99, 102, 241, 0.1) !important;
    color: #818cf8 !important;
}

/* Forzar dropdowns oscuros */
:deep(.p-dropdown-panel) {
    background: #1a1d2b !important;
    border: 1px solid rgba(255, 255, 255, 0.1) !important;
}

:deep(.p-dropdown-items-wrapper) {
    color: white !important;
}

:deep(.p-dropdown-item) {
    color: #cbd5e1 !important;
}

:deep(.p-dropdown-item:hover) {
    background: rgba(99, 102, 241, 0.1) !important;
    color: white !important;
}
</style>