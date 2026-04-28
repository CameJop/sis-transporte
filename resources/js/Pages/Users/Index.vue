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

// Recibimos los usuarios desde Laravel
defineProps({ users: Array });

const displayModal = ref(false);
const editMode = ref(false);

const form = useForm({
    id: null,
    name: '',
    email: '',
    password: '',
});

const openModal = () => {
    form.reset();
    editMode.value = false;
    displayModal.value = true;
};

const editUser = (user) => {
    form.id = user.id;
    form.name = user.name;
    form.email = user.email;
    form.password = ''; // No cargar la contraseña por seguridad
    editMode.value = true;
    displayModal.value = true;
};

const submit = () => {
    if (editMode.value) {
        form.put(route('users.update', form.id), {
            onSuccess: () => displayModal.value = false,
        });
    } else {
        form.post(route('users.store'), {
            onSuccess: () => displayModal.value = false,
        });
    }
};

const deleteUser = (id) => {
    if (confirm('¿Estás seguro de eliminar este acceso?')) {
        form.delete(route('users.destroy', id));
    }
};
</script>

<template>
    <Head title="Gestión de Usuarios" />
    <Layout>
        <div class="bg-[#1a1d2b] p-8 rounded-[2rem] border border-white/5 shadow-2xl min-h-[70vh]">
            
            <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 mb-8">
                <div>
                    <h1 class="text-2xl font-bold text-white tracking-tight flex items-center gap-3">
                        <i class="pi pi-shield text-indigo-500"></i>
                        Cuentas de Usuario
                    </h1>
                    <p class="text-slate-500 text-sm mt-1">Administración de credenciales y acceso al sistema.</p>
                </div>
                <Button label="Nuevo Usuario" icon="pi pi-user-plus" @click="openModal" 
                    class="!bg-indigo-600 !border-none !rounded-xl !px-6 !py-3 shadow-lg shadow-indigo-500/20 hover:!bg-indigo-500 transition-all" />
            </div>

            <DataTable :value="users" paginator :rows="10" class="p-datatable-atlantis" responsiveLayout="stack">
                <Column header="ID" class="w-16 text-slate-500 text-xs font-mono">
                    <template #body="{ data }">
                        {{ data.id }}
                    </template>
                </Column>
                
                <Column header="USUARIO / PERFIL">
                    <template #body="{ data }">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-xl bg-indigo-500/10 flex items-center justify-center text-indigo-400 border border-indigo-500/20 shadow-inner">
                                <span class="font-bold text-sm">{{ data.name.charAt(0).toUpperCase() }}</span>
                            </div>
                            <div class="flex flex-col">
                                <span class="font-semibold text-white tracking-wide">{{ data.name }}</span>
                                <span class="text-[10px] text-slate-500 uppercase tracking-widest font-medium">Acceso Autorizado</span>
                            </div>
                        </div>
                    </template>
                </Column>

                <Column header="CORREO ELECTRÓNICO">
                    <template #body="{ data }">
                        <div class="flex items-center gap-2">
                            <i class="pi pi-envelope text-slate-600 text-xs"></i>
                            <span class="text-slate-300 font-mono text-sm">{{ data.email }}</span>
                        </div>
                    </template>
                </Column>

                <Column header="ESTADO">
                    <template #body>
                        <Tag value="ACTIVO" class="!bg-emerald-500/10 !text-emerald-400 !border !border-emerald-500/20 !px-3 !py-1" rounded />
                    </template>
                </Column>

                <Column header="ACCIONES" class="text-right w-32">
                    <template #body="{ data }">
                        <div class="flex justify-end gap-1">
                            <Button icon="pi pi-pencil" text rounded severity="secondary" @click="editUser(data)" 
                                class="hover:!bg-white/5 transition-colors" />
                            <Button icon="pi pi-trash" text rounded severity="danger" @click="deleteUser(data.id)"
                                class="hover:!bg-red-500/5 transition-colors" />
                        </div>
                    </template>
                </Column>
            </DataTable>
        </div>

        <Dialog v-model:visible="displayModal" :header="editMode ? 'Editar Perfil de Usuario' : 'Registrar Nuevo Acceso'" modal 
            class="p-dark w-full max-w-md"
            :pt="{ 
                root: { class: 'bg-[#1a1d2b] border border-white/10 shadow-2xl rounded-[1.5rem] overflow-hidden' },
                header: { class: 'bg-[#1a1d2b] text-white border-b border-white/5 p-6' },
                content: { class: 'bg-[#1a1d2b] text-white p-6' }
            }">
            
            <form @submit.prevent="submit" class="grid grid-cols-1 gap-6 pt-2">
                <div class="flex flex-col gap-2">
                    <label class="text-xs font-bold text-slate-500 uppercase tracking-widest">Nombre Completo</label>
                    <div class="relative">
                        <i class="pi pi-user absolute left-4 top-1/2 -translate-y-1/2 text-slate-500"></i>
                        <InputText v-model="form.name" placeholder="Ej. Juan Perez" 
                            class="w-full !bg-[#0f111a] !border-white/10 !text-white focus:!border-indigo-500 !pl-11 !py-3 !rounded-xl" />
                    </div>
                    <small v-if="form.errors.name" class="text-red-400 text-[10px]">{{ form.errors.name }}</small>
                </div>

                <div class="flex flex-col gap-2">
                    <label class="text-xs font-bold text-slate-500 uppercase tracking-widest">Correo Institucional</label>
                    <div class="relative">
                        <i class="pi pi-envelope absolute left-4 top-1/2 -translate-y-1/2 text-slate-500"></i>
                        <InputText v-model="form.email" type="email" placeholder="usuario@empresa.com"
                            class="w-full !bg-[#0f111a] !border-white/10 !text-white focus:!border-indigo-500 !pl-11 !py-3 !rounded-xl" />
                    </div>
                    <small v-if="form.errors.email" class="text-red-400 text-[10px]">{{ form.errors.email }}</small>
                </div>

                <div class="flex flex-col gap-2">
                    <label class="text-xs font-bold text-slate-500 uppercase tracking-widest">
                        {{ editMode ? 'Nueva Contraseña (Opcional)' : 'Contraseña de Acceso' }}
                    </label>
                    <div class="relative">
                        <i class="pi pi-lock absolute left-4 top-1/2 -translate-y-1/2 text-slate-500"></i>
                        <InputText v-model="form.password" type="password" 
                            placeholder="••••••••"
                            class="w-full !bg-[#0f111a] !border-white/10 !text-white focus:!border-indigo-500 !pl-11 !py-3 !rounded-xl" />
                    </div>
                    <small v-if="form.errors.password" class="text-red-400 text-[10px]">{{ form.errors.password }}</small>
                    <p v-if="editMode" class="text-[10px] text-slate-500 italic px-1">Dejar vacío para conservar la contraseña actual.</p>
                </div>

                <div class="flex justify-end gap-3 mt-4">
                    <Button label="Cancelar" text severity="secondary" @click="displayModal = false" class="!text-slate-400" />
                    <Button :label="editMode ? 'Actualizar Datos' : 'Crear Cuenta'" type="submit" 
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
    transition: all 0.2s;
}

:deep(.p-datatable-tbody > tr:hover) {
    background: rgba(255, 255, 255, 0.01) !important;
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