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

const props = defineProps({
    roles: Array
});

const displayModal = ref(false);
const editMode = ref(false);

const form = useForm({
    id: null,
    name: '',
    guard_name: 'web', // Valor por defecto común en Laravel
});

const openNew = () => {
    form.reset();
    form.guard_name = 'web';
    editMode.value = false;
    displayModal.value = true;
};

const editRole = (data) => {
    form.id = data.id;
    form.name = data.name;
    form.guard_name = data.guard_name;
    editMode.value = true;
    displayModal.value = true;
};

const submit = () => {
    if (editMode.value) {
        form.put(route('roles.update', form.id), {
            onSuccess: () => displayModal.value = false
        });
    } else {
        form.post(route('roles.store'), {
            onSuccess: () => displayModal.value = false
        });
    }
};

const deleteRole = (id) => {
    if (confirm('¿Estás seguro de eliminar este rol? Esta acción podría afectar los permisos de los usuarios.')) {
        form.delete(route('roles.destroy', id));
    }
};
</script>

<template>
    <Head title="Gestión de Roles" />
    <Layout>
        <div class="bg-[#1a1d2b] p-8 rounded-[2rem] border border-white/5 shadow-2xl min-h-[70vh]">
            
            <!-- Encabezado -->
            <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 mb-8">
                <div>
                    <h1 class="text-2xl font-bold text-white tracking-tight flex items-center gap-3">
                        <i class="pi pi-shield text-indigo-500"></i>
                        Roles del Sistema
                    </h1>
                    <p class="text-slate-500 text-sm mt-1">Configuración de niveles de acceso y guardias.</p>
                </div>
                <Button label="Nuevo Rol" icon="pi pi-plus" @click="openNew" 
                    class="!bg-indigo-600 !border-none !rounded-xl !px-6 !py-3 shadow-lg shadow-indigo-500/20 hover:!bg-indigo-500 transition-all" />
            </div>

            <!-- Tabla de Datos -->
            <DataTable :value="roles" paginator :rows="10" class="p-datatable-atlantis" responsiveLayout="stack">
                <Column header="ID" class="w-16 text-slate-500 text-xs font-mono">
                    <template #body="{ data }">
                        {{ data.id }}
                    </template>
                </Column>
                
                <Column header="NOMBRE DEL ROL">
                    <template #body="{ data }">
                        <div class="flex items-center gap-3">
                            <div class="w-9 h-9 rounded-lg bg-indigo-500/10 flex items-center justify-center border border-indigo-500/20">
                                <i class="pi pi-lock text-indigo-400"></i>
                            </div>
                            <div class="flex flex-col">
                                <span class="font-semibold text-white tracking-wide uppercase">{{ data.name }}</span>
                                <span class="text-[10px] text-indigo-400 font-bold tracking-wider">Identificador Único</span>
                            </div>
                        </div>
                    </template>
                </Column>

                <Column header="GUARD (SISTEMA)">
                    <template #body="{ data }">
                        <div class="flex items-center gap-2">
                            <i class="pi pi-server text-slate-600"></i>
                            <span class="text-slate-300 font-mono bg-white/5 px-2 py-1 rounded text-xs">{{ data.guard_name }}</span>
                        </div>
                    </template>
                </Column>

                <Column header="FECHA DE CREACIÓN">
                    <template #body="{ data }">
                        <div class="text-xs text-slate-400">
                            <i class="pi pi-calendar-plus mr-2 text-slate-600"></i>
                            {{ new Date(data.created_at).toLocaleDateString() }}
                        </div>
                    </template>
                </Column>

                <Column header="ACCIONES" class="text-right w-32">
                    <template #body="{ data }">
                        <div class="flex justify-end gap-1">
                            <Button icon="pi pi-pencil" text rounded severity="secondary" @click="editRole(data)" />
                            <Button icon="pi pi-trash" text rounded severity="danger" @click="deleteRole(data.id)" />
                        </div>
                    </template>
                </Column>
            </DataTable>
        </div>

        <!-- Modal de Formulario -->
        <Dialog v-model:visible="displayModal" :header="editMode ? 'Editar Rol' : 'Crear Nuevo Rol'" modal 
            class="p-dark w-full max-w-md" 
            :pt="{ 
                root: { class: 'bg-[#1a1d2b] border border-white/10 shadow-2xl rounded-[1.5rem]' },
                header: { class: 'bg-[#1a1d2b] text-white border-b border-white/5 p-6' },
                content: { class: 'bg-[#1a1d2b] text-white p-6' }
            }">
            
            <form @submit.prevent="submit" class="grid grid-cols-1 gap-6 pt-2">
                <div class="flex flex-col gap-2">
                    <label class="text-xs font-bold text-slate-500 uppercase tracking-widest px-1">Nombre del Rol</label>
                    <InputText v-model="form.name" placeholder="Ej. administrador, editor, etc." 
                        class="w-full !bg-[#0f111a] !border-white/10 !text-white focus:!border-indigo-500 !py-3 !px-4 !rounded-xl" />
                    <small v-if="form.errors.name" class="text-red-400 font-medium">{{ form.errors.name }}</small>
                </div>

                <div class="flex flex-col gap-2">
                    <label class="text-xs font-bold text-slate-500 uppercase tracking-widest px-1">Guard Name (API/Web)</label>
                    <InputText v-model="form.guard_name" placeholder="Normalmente 'web'" 
                        class="w-full !bg-[#0f111a] !border-white/10 !text-white font-mono !py-3 !px-4 !rounded-xl" />
                    <small v-if="form.errors.guard_name" class="text-red-400 font-medium">{{ form.errors.guard_name }}</small>
                </div>

                <div class="flex justify-end gap-3 mt-4">
                    <Button label="Cancelar" text severity="secondary" @click="displayModal = false" class="!text-slate-400" />
                    <Button :label="editMode ? 'Actualizar Rol' : 'Crear Rol'" type="submit" 
                        icon="pi pi-check" :loading="form.processing" class="!bg-indigo-600 !border-none !rounded-xl !px-6 shadow-lg shadow-indigo-500/20" />
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
</style>