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
    terminales: Array
});

const displayModal = ref(false);
const editMode = ref(false);

const form = useForm({
    id_terminal: null,
    nombre: '',
    ciudad: '',
});

const openNew = () => {
    form.reset();
    editMode.value = false;
    displayModal.value = true;
};

const editTerminal = (data) => {
    form.id_terminal = data.id_terminal;
    form.nombre = data.nombre;
    form.ciudad = data.ciudad;
    editMode.value = true;
    displayModal.value = true;
};

const submit = () => {
    if (editMode.value) {
        form.put(route('terminales.update', form.id_terminal), {
            onSuccess: () => displayModal.value = false
        });
    } else {
        form.post(route('terminales.store'), {
            onSuccess: () => displayModal.value = false
        });
    }
};

const deleteTerminal = (id) => {
    if (confirm('¿Confirmas la eliminación de esta terminal?')) {
        form.delete(route('terminales.destroy', id));
    }
};
</script>

<template>
    <Head title="Terminales" />
    <Layout>
        <div class="bg-[#1a1d2b] p-8 rounded-[2rem] border border-white/5 shadow-2xl min-h-[70vh]">
            
            <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 mb-8">
                <div>
                    <h1 class="text-2xl font-bold text-white tracking-tight flex items-center gap-3">
                        <div class="w-10 h-10 bg-indigo-500/20 rounded-xl flex items-center justify-center border border-indigo-500/30">
                            <i class="pi pi-building text-indigo-400"></i>
                        </div>
                        Terminales Terrestres
                    </h1>
                    <p class="text-slate-500 text-sm mt-1">Gestión de puntos de origen y destino para la flota.</p>
                </div>
                <Button label="Registrar Terminal" icon="pi pi-plus" @click="openNew" 
                    class="!bg-indigo-600 !border-none !rounded-xl !px-6 !py-3 shadow-lg shadow-indigo-500/20 hover:!bg-indigo-500 transition-all" />
            </div>

            <DataTable :value="terminales" paginator :rows="10" class="p-datatable-atlantis" responsiveLayout="stack">
                <Column header="ID" class="w-16 text-slate-500 text-xs font-mono">
                    <template #body="{ data }">
                        {{ data.id_terminal }}
                    </template>
                </Column>
                
                <Column header="NOMBRE DE TERMINAL">
                    <template #body="{ data }">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-xl bg-indigo-500/10 flex items-center justify-center border border-indigo-500/10">
                                <i class="pi pi-map-marker text-indigo-400"></i>
                            </div>
                            <span class="font-semibold text-white tracking-wide">{{ data.nombre }}</span>
                        </div>
                    </template>
                </Column>

                <Column header="UBICACIÓN / CIUDAD">
                    <template #body="{ data }">
                        <div class="flex items-center gap-2">
                            <Tag :value="data.ciudad" 
                                class="!bg-slate-800 !text-slate-300 !border !border-white/5 !px-4 !py-1 text-xs uppercase tracking-widest" />
                        </div>
                    </template>
                </Column>

                <Column header="ACCIONES" class="text-right w-32">
                    <template #body="{ data }">
                        <div class="flex justify-end gap-1">
                            <Button icon="pi pi-pencil" text rounded severity="secondary" @click="editTerminal(data)" />
                            <Button icon="pi pi-trash" text rounded severity="danger" @click="deleteTerminal(data.id_terminal)" />
                        </div>
                    </template>
                </Column>
            </DataTable>
        </div>

        <Dialog v-model:visible="displayModal" :header="editMode ? 'Editar Terminal' : 'Nueva Terminal'" modal 
            class="p-dark w-full max-w-md" 
            :pt="{ 
                root: { class: 'bg-[#1a1d2b] border border-white/10 shadow-2xl rounded-[1.5rem]' },
                header: { class: 'bg-[#1a1d2b] text-white border-b border-white/5 p-6' },
                content: { class: 'bg-[#1a1d2b] text-white p-6' }
            }">
            
            <form @submit.prevent="submit" class="grid grid-cols-1 gap-6 pt-2">
                <div class="flex flex-col gap-2">
                    <label class="text-xs font-bold text-slate-500 uppercase tracking-widest px-1">Nombre del Establecimiento</label>
                    <InputText v-model="form.nombre" placeholder="Ej. Terminal Bimodal" 
                        class="w-full !bg-[#0f111a] !border-white/10 !text-white focus:!border-indigo-500 !rounded-xl !py-3" />
                    <small v-if="form.errors.nombre" class="text-red-400 px-1">{{ form.errors.nombre }}</small>
                </div>

                <div class="flex flex-col gap-2">
                    <label class="text-xs font-bold text-slate-500 uppercase tracking-widest px-1">Ciudad</label>
                    <InputText v-model="form.ciudad" placeholder="Ej. Santa Cruz de la Sierra" 
                        class="w-full !bg-[#0f111a] !border-white/10 !text-white focus:!border-indigo-500 !rounded-xl !py-3" />
                    <small v-if="form.errors.ciudad" class="text-red-400 px-1">{{ form.errors.ciudad }}</small>
                </div>

                <div class="flex justify-end gap-3 mt-4 border-t border-white/5 pt-6">
                    <Button label="Cerrar" text severity="secondary" @click="displayModal = false" class="!text-slate-400" />
                    <Button :label="editMode ? 'Actualizar' : 'Guardar Terminal'" type="submit" 
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
    font-size: 0.75rem;
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