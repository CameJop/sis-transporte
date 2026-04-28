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
    clientes: Array
});

const displayModal = ref(false);
const editMode = ref(false);

const form = useForm({
    id_cliente: null,
    nombre: '',
    documento_identidad: '',
    telefono: '',
    email: '',
});

const openNew = () => {
    form.reset();
    editMode.value = false;
    displayModal.value = true;
};

const editCliente = (data) => {
    form.id_cliente = data.id_cliente;
    form.nombre = data.nombre;
    form.documento_identidad = data.documento_identidad;
    form.telefono = data.telefono;
    form.email = data.email;
    editMode.value = true;
    displayModal.value = true;
};

const submit = () => {
    if (editMode.value) {
        form.put(route('clientes.update', form.id_cliente), {
            onSuccess: () => displayModal.value = false
        });
    } else {
        form.post(route('clientes.store'), {
            onSuccess: () => displayModal.value = false
        });
    }
};

const deleteCliente = (id) => {
    if (confirm('¿Eliminar este cliente? Se borrarán sus registros asociados.')) {
        form.delete(route('clientes.destroy', id));
    }
};
</script>

<template>
    <Head title="Base de Clientes" />
    <Layout>
        <div class="bg-[#1a1d2b] p-8 rounded-[2rem] border border-white/5 shadow-2xl min-h-[70vh]">
            
            <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 mb-8">
                <div>
                    <h1 class="text-2xl font-bold text-white tracking-tight flex items-center gap-3">
                        <i class="pi pi-address-book text-indigo-500"></i>
                        Directorio de Clientes
                    </h1>
                    <p class="text-slate-500 text-sm mt-1">Registro centralizado de pasajeros y remitentes.</p>
                </div>
                <Button label="Registrar Cliente" icon="pi pi-plus" @click="openNew" 
                    class="!bg-indigo-600 !border-none !rounded-xl !px-6 !py-3 shadow-lg shadow-indigo-500/20 hover:!bg-indigo-500 transition-all" />
            </div>

            <DataTable :value="clientes" paginator :rows="10" class="p-datatable-atlantis" responsiveLayout="stack">
                <Column header="ID" class="w-16 text-slate-500 text-xs font-mono">
                    <template #body="{ data }">
                        {{ data.id_cliente }}
                    </template>
                </Column>
                
                <Column header="NOMBRE Y APELLIDO">
                    <template #body="{ data }">
                        <div class="flex items-center gap-3">
                            <div class="w-9 h-9 rounded-lg bg-indigo-500/10 flex items-center justify-center border border-indigo-500/20">
                                <i class="pi pi-user text-indigo-400"></i>
                            </div>
                            <div class="flex flex-col">
                                <span class="font-semibold text-white tracking-wide">{{ data.nombre }}</span>
                                <span class="text-[10px] text-indigo-400 font-bold uppercase tracking-wider">Pasajero Frecuente</span>
                            </div>
                        </div>
                    </template>
                </Column>

                <Column header="DOCUMENTO / CI">
                    <template #body="{ data }">
                        <div class="flex items-center gap-2">
                            <i class="pi pi-id-card text-slate-600"></i>
                            <span class="text-slate-300 font-mono">{{ data.documento_identidad || 'N/A' }}</span>
                        </div>
                    </template>
                </Column>

                <Column header="CONTACTO">
                    <template #body="{ data }">
                        <div class="flex flex-col gap-1">
                            <span class="text-xs text-slate-300 flex items-center gap-2">
                                <i class="pi pi-phone text-[10px] text-indigo-500"></i> {{ data.telefono || 'Sin telf.' }}
                            </span>
                            <span class="text-xs text-slate-500 flex items-center gap-2">
                                <i class="pi pi-envelope text-[10px]"></i> {{ data.email || 'Sin correo' }}
                            </span>
                        </div>
                    </template>
                </Column>

                <Column header="ACCIONES" class="text-right w-32">
                    <template #body="{ data }">
                        <div class="flex justify-end gap-1">
                            <Button icon="pi pi-pencil" text rounded severity="secondary" @click="editCliente(data)" />
                            <Button icon="pi pi-trash" text rounded severity="danger" @click="deleteCliente(data.id_cliente)" />
                        </div>
                    </template>
                </Column>
            </DataTable>
        </div>

        <Dialog v-model:visible="displayModal" :header="editMode ? 'Actualizar Cliente' : 'Registrar Nuevo Pasajero'" modal 
            class="p-dark w-full max-w-lg" 
            :pt="{ 
                root: { class: 'bg-[#1a1d2b] border border-white/10 shadow-2xl rounded-[1.5rem]' },
                header: { class: 'bg-[#1a1d2b] text-white border-b border-white/5 p-6' },
                content: { class: 'bg-[#1a1d2b] text-white p-6' }
            }">
            
            <form @submit.prevent="submit" class="grid grid-cols-1 gap-6 pt-2">
                <div class="flex flex-col gap-2">
                    <label class="text-xs font-bold text-slate-500 uppercase tracking-widest px-1">Nombre Completo</label>
                    <InputText v-model="form.nombre" placeholder="Nombre completo según documento" 
                        class="w-full !bg-[#0f111a] !border-white/10 !text-white focus:!border-indigo-500 !py-3 !px-4 !rounded-xl" />
                    <small v-if="form.errors.nombre" class="text-red-400">{{ form.errors.nombre }}</small>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="flex flex-col gap-2">
                        <label class="text-xs font-bold text-slate-500 uppercase tracking-widest px-1">C.I. / Documento</label>
                        <InputText v-model="form.documento_identidad" placeholder="Ej. 1234567 LP" 
                            class="w-full !bg-[#0f111a] !border-white/10 !text-white font-mono !py-3 !px-4 !rounded-xl" />
                    </div>
                    <div class="flex flex-col gap-2">
                        <label class="text-xs font-bold text-slate-500 uppercase tracking-widest px-1">Teléfono</label>
                        <InputText v-model="form.telefono" placeholder="Ej. 70012345" 
                            class="w-full !bg-[#0f111a] !border-white/10 !text-white !py-3 !px-4 !rounded-xl" />
                    </div>
                </div>

                <div class="flex flex-col gap-2">
                    <label class="text-xs font-bold text-slate-500 uppercase tracking-widest px-1">Correo Electrónico</label>
                    <InputText v-model="form.email" type="email" placeholder="cliente@servidor.com"
                        class="w-full !bg-[#0f111a] !border-white/10 !text-white focus:!border-indigo-500 !py-3 !px-4 !rounded-xl" />
                    <small v-if="form.errors.email" class="text-red-400">{{ form.errors.email }}</small>
                </div>

                <div class="flex justify-end gap-3 mt-4">
                    <Button label="Cerrar" text severity="secondary" @click="displayModal = false" class="!text-slate-400" />
                    <Button :label="editMode ? 'Actualizar Datos' : 'Guardar Cliente'" type="submit" 
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