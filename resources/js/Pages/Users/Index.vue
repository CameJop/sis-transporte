<script setup>
import Layout from '@/Layouts/Layout.vue';
import { useForm } from '@inertiajs/vue3';
import DataTable from 'primevue/datatable';
import Column from 'primevue/column';
import Button from 'primevue/button';
import Dialog from 'primevue/dialog';
import InputText from 'primevue/inputtext';
import { ref } from 'vue';

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
    if (confirm('¿Estás seguro?')) {
        form.delete(route('users.destroy', id));
    }
};
</script>

<template>
    <Layout>
        <div class="bg-[#1a1d2b] p-8 rounded-[2rem] border border-white/5 shadow-xl">
            <div class="flex justify-between items-center mb-6">
                <h1 class="text-2xl font-bold text-white">Gestión de Usuarios</h1>
                <Button label="Nuevo Usuario" icon="pi pi-plus" @click="openModal" class="!rounded-xl" />
            </div>

            <DataTable :value="users" class="p-datatable-sm" responsiveLayout="stack">
                <Column field="name" header="Nombre" class="text-slate-300"></Column>
                <Column field="email" header="Email"></Column>
                <Column header="Acciones">
                    <template #body="slotProps">
                        <div class="flex gap-2">
                            <Button icon="pi pi-pencil" severity="warning" text @click="editUser(slotProps.data)" />
                            <Button icon="pi pi-trash" severity="danger" text @click="deleteUser(slotProps.data.id)" />
                        </div>
                    </template>
                </Column>
            </DataTable>
        </div>

        <Dialog v-model:visible="displayModal" :header="editMode ? 'Editar Usuario' : 'Nuevo Usuario'" modal class="p-dark w-full max-w-md">
            <div class="flex flex-col gap-4 pt-4">
                <div class="flex flex-col gap-2">
                    <label class="text-sm">Nombre</label>
                    <InputText v-model="form.name" class="w-full" />
                </div>
                <div class="flex flex-col gap-2">
                    <label class="text-sm">Email</label>
                    <InputText v-model="form.email" class="w-full" />
                </div>
                <div v-if="!editMode" class="flex flex-col gap-2">
                    <label class="text-sm">Contraseña</label>
                    <InputText v-model="form.password" type="password" class="w-full" />
                </div>
                <Button :label="editMode ? 'Actualizar' : 'Guardar'" @click="submit" :loading="form.processing" class="mt-4" />
            </div>
        </Dialog>
    </Layout>
</template>

<style scoped>
/* Ajuste para que la tabla combine con el modo oscuro */
:deep(.p-datatable) {
    background: transparent;
}
:deep(.p-datatable-thead > tr > th) {
    background: rgba(255, 255, 255, 0.02);
    color: #94a3b8;
    border-bottom: 1px solid rgba(255, 255, 255, 0.05);
}
:deep(.p-datatable-tbody > tr) {
    background: transparent;
    color: #cbd5e1;
    border-bottom: 1px solid rgba(255, 255, 255, 0.02);
}
</style>