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
import Message from 'primevue/message';

const props = defineProps({
    metodos: Array
});

const displayModal = ref(false);
const editMode = ref(false);

const form = useForm({
    id_metodo_pago: null,
    descripcion: '',
});

const openNew = () => {
    form.reset();
    editMode.value = false;
    displayModal.value = true;
};

const editMetodo = (data) => {
    form.id_metodo_pago = data.id_metodo_pago;
    form.descripcion = data.descripcion;
    editMode.value = true;
    displayModal.value = true;
};

const submit = () => {
    if (editMode.value) {
        form.put(route('metodos-pago.update', form.id_metodo_pago), {
            onSuccess: () => displayModal.value = false
        });
    } else {
        form.post(route('metodos-pago.store'), {
            onSuccess: () => displayModal.value = false
        });
    }
};

const deleteMetodo = (id) => {
    if (confirm('¿Confirmas la eliminación de este método de pago?')) {
        form.delete(route('metodos-pago.destroy', id));
    }
};
</script>

<template>
    <Head title="Métodos de Pago" />
    <Layout>
        <div class="bg-[#1a1d2b] p-8 rounded-[2rem] border border-white/5 shadow-2xl min-h-[70vh]">
            
            <Message v-if="$page.props.errors.error" severity="error" class="mb-6 !bg-red-500/10 !border-red-500/20 !text-red-400">
                {{ $page.props.errors.error }}
            </Message>

            <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 mb-8">
                <div>
                    <h1 class="text-2xl font-bold text-white tracking-tight flex items-center gap-3">
                        <i class="pi pi-credit-card text-indigo-500"></i>
                        Métodos de Pago
                    </h1>
                    <p class="text-slate-500 text-sm mt-1">Configuración de formas de cobro para boletos y encomiendas.</p>
                </div>
                <Button label="Nuevo Método" icon="pi pi-plus" @click="openNew" 
                    class="!bg-indigo-600 !border-none !rounded-xl !px-6 !py-3 shadow-lg shadow-indigo-500/20 hover:!bg-indigo-500 transition-all" />
            </div>

            <DataTable :value="metodos" paginator :rows="10" class="p-datatable-atlantis" responsiveLayout="stack">
                <Column header="ID" class="w-16 text-slate-500 text-xs font-mono">
                    <template #body="{ data }">
                        {{ data.id_metodo_pago }}
                    </template>
                </Column>
                
                <Column header="DESCRIPCIÓN">
                    <template #body="{ data }">
                        <div class="flex items-center gap-3">
                            <div class="w-9 h-9 rounded-lg bg-indigo-500/10 flex items-center justify-center border border-indigo-500/20">
                                <i class="pi pi-wallet text-indigo-400 text-sm"></i>
                            </div>
                            <span class="font-semibold text-white tracking-wide">{{ data.descripcion }}</span>
                        </div>
                    </template>
                </Column>

                <Column header="ESTADO">
                    <template #body>
                        <Tag value="ACTIVO" class="!bg-emerald-500/10 !text-emerald-400 !border !border-emerald-500/20 !text-[9px] !px-3" />
                    </template>
                </Column>

                <Column header="ACCIONES" class="text-right w-32">
                    <template #body="{ data }">
                        <div class="flex justify-end gap-1">
                            <Button icon="pi pi-pencil" text rounded severity="secondary" @click="editMetodo(data)" />
                            <Button icon="pi pi-trash" text rounded severity="danger" @click="deleteMetodo(data.id_metodo_pago)" />
                        </div>
                    </template>
                </Column>
            </DataTable>
        </div>

        <Dialog v-model:visible="displayModal" :header="editMode ? 'Editar Información' : 'Nuevo Método de Pago'" modal 
            class="p-dark w-full max-w-md" 
            :pt="{ 
                root: { class: 'bg-[#1a1d2b] border border-white/10 shadow-2xl rounded-[1.5rem]' },
                header: { class: 'bg-[#1a1d2b] text-white border-b border-white/5 p-6' },
                content: { class: 'bg-[#1a1d2b] text-white p-6' }
            }">
            
            <form @submit.prevent="submit" class="grid grid-cols-1 gap-6 pt-2">
                <div class="flex flex-col gap-2">
                    <label class="text-xs font-bold text-slate-500 uppercase tracking-widest px-1">Nombre del Método</label>
                    <InputText v-model="form.descripcion" placeholder="Ej. Efectivo, QR, Transferencia" 
                        class="w-full !bg-[#0f111a] !border-white/10 !text-white focus:!border-indigo-500 !py-3 !px-4 !rounded-xl" />
                    <small v-if="form.errors.descripcion" class="text-red-400">{{ form.errors.descripcion }}</small>
                </div>

                <div class="flex justify-end gap-3 mt-4">
                    <Button label="Cancelar" text severity="secondary" @click="displayModal = false" class="!text-slate-400" />
                    <Button :label="editMode ? 'Actualizar' : 'Guardar Método'" type="submit" 
                        icon="pi pi-check" :loading="form.processing" class="!bg-indigo-600 !border-none !rounded-xl !px-6" />
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