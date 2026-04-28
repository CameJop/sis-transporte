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
import Tag from 'primevue/tag';

const props = defineProps({
    roles: Array
});

const displayModal = ref(false);
const editMode = ref(false);

const form = useForm({
    id_rol: null,
    nombre: '',
});

const openNew = () => {
    form.reset();
    editMode.value = false;
    displayModal.value = true;
};

const editRol = (data) => {
    form.id_rol = data.id_rol;
    form.nombre = data.nombre;
    editMode.value = true;
    displayModal.value = true;
};

const submit = () => {
    if (editMode.value) {
        form.put(route('roles.update', form.id_rol), {
            onSuccess: () => displayModal.value = false
        });
    } else {
        form.post(route('roles.store'), {
            onSuccess: () => displayModal.value = false
        });
    }
};

const deleteRol = (id) => {
    if (confirm('¿Confirmas la eliminación de este rol de usuario?')) {
        form.delete(route('roles.destroy', id));
    }
};
</script>

<template>
    <Head title="Gestión de Roles" />
    <Layout>
        <div class="bg-[#1a1d2b] p-8 rounded-[2rem] border border-white/5 shadow-2xl min-h-[70vh]">
            
            <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 mb-8">
                <div>
                    <h1 class="text-2xl font-bold text-white tracking-tight flex items-center gap-3">
                        <i class="pi pi-shield text-indigo-500"></i>
                        Roles del Sistema
                    </h1>
                    <p class="text-slate-500 text-sm mt-1">Definición de jerarquías y niveles de acceso.</p>
                </div>
                <Button label="Nuevo Rol" icon="pi pi-plus" @click="openNew" 
                    class="!bg-indigo-600 !border-none !rounded-xl !px-6 !py-3 shadow-lg shadow-indigo-500/20 hover:!bg-indigo-500 transition-all" />
            </div>

            <DataTable :value="roles" paginator :rows="10" class="p-datatable-atlantis" responsiveLayout="stack">
                <Column field="id_rol" header="ID" class="w-20 text-slate-500 font-mono text-xs"></Column>
                
                <Column header="NOMBRE DEL ROL">
                    <template #body="{ data }">
                        <div class="flex items-center gap-3">
                            <div class="w-8 h-8 rounded-lg bg-indigo-500/10 flex items-center justify-center">
                                <i class="pi pi-lock text-indigo-400 text-sm"></i>
                            </div>
                            <span class="font-bold text-white tracking-wide uppercase text-sm">{{ data.nombre }}</span>
                        </div>
                    </template>
                </Column>

                <Column header="NIVEL">
                    <template #body>
                        <Tag value="ACCESO" class="!bg-white/5 !text-indigo-300 !border !border-indigo-500/20" />
                    </template>
                </Column>

                <Column header="ACCIONES" class="text-right w-32">
                    <template #body="{ data }">
                        <div class="flex justify-end gap-1">
                            <Button icon="pi pi-pencil" text rounded severity="secondary" @click="editRol(data)" />
                            <Button icon="pi pi-trash" text rounded severity="danger" @click="deleteRol(data.id_rol)" />
                        </div>
                    </template>
                </Column>
            </DataTable>
        </div>

        <Dialog v-model:visible="displayModal" :header="editMode ? 'Editar Rol' : 'Crear Nuevo Rol'" modal 
            class="p-dark w-full max-w-md" 
            :pt="{ 
                root: { class: 'bg-[#1a1d2b] border border-white/10 shadow-3xl' },
                header: { class: 'bg-[#1a1d2b] text-white border-b border-white/5 p-6' },
                content: { class: 'bg-[#1a1d2b] text-white p-6' }
            }">
            
            <form @submit.prevent="submit" class="grid grid-cols-1 gap-6 pt-2">
                <div class="flex flex-col gap-2">
                    <label class="text-xs font-bold text-slate-500 uppercase tracking-widest">Nombre del Rol</label>
                    <InputText v-model="form.nombre" placeholder="Ej. ADMIN, CAJERO, SOPORTE" 
                        class="w-full !bg-[#0f111a] !border-white/10 !text-white focus:!border-indigo-500 uppercase font-mono" />
                    <small v-if="form.errors.nombre" class="text-red-400">{{ form.errors.nombre }}</small>
                </div>

                <div class="flex justify-end gap-3 mt-4">
                    <Button label="Cerrar" text severity="secondary" @click="displayModal = false" class="!text-slate-400" />
                    <Button :label="editMode ? 'Actualizar' : 'Guardar'" type="submit" 
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
    padding: 1rem 0;
}
:deep(.p-paginator button) { color: #64748b !important; }
:deep(.p-paginator .p-paginator-pages .p-paginator-page.p-highlight) {
    background: rgba(99, 102, 241, 0.1) !important;
    color: #818cf8 !important;
}
</style>