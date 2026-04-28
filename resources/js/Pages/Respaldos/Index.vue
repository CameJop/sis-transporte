<script setup>
import { ref } from 'vue';
import { useForm, Head } from '@inertiajs/vue3';
import Layout from '@/Layouts/Layout.vue';

// PrimeVue
import DataTable from 'primevue/datatable';
import Column from 'primevue/column';
import Button from 'primevue/button';
import Dialog from 'primevue/dialog';
import Tag from 'primevue/tag';

const props = defineProps({
    respaldos: Array
});

const displayModal = ref(false);

const form = useForm({
    descripcion: '',
});

const openNew = () => {
    form.reset();
    displayModal.value = true;
};

const submit = () => {
    form.post(route('respaldos.store'), {
        onSuccess: () => displayModal.value = false
    });
};

const deleteRespaldo = (id) => {
    if (confirm('¿Deseas eliminar este registro de respaldo? (Nota: Esto no borra el archivo físico, solo el registro)')) {
        form.delete(route('respaldos.destroy', id));
    }
};

const formatDateTime = (value) => {
    if (!value) return '';
    return new Date(value).toLocaleString('es-BO', {
        year: 'numeric',
        month: '2-digit',
        day: '2-digit',
        hour: '2-digit',
        minute: '2-digit'
    });
};
</script>

<template>
    <Head title="Respaldos del Sistema" />
    <Layout>
        <div class="bg-[#1a1d2b] p-8 rounded-[2rem] border border-white/5 shadow-2xl min-h-[70vh]">
            
            <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 mb-8">
                <div>
                    <h1 class="text-2xl font-bold text-white tracking-tight flex items-center gap-3">
                        <div class="w-10 h-10 bg-emerald-500/20 rounded-xl flex items-center justify-center border border-emerald-500/30">
                            <i class="pi pi-database text-emerald-400"></i>
                        </div>
                        Historial de Respaldos
                    </h1>
                    <p class="text-slate-500 text-sm mt-1">Gestión y control de copias de seguridad de la base de datos.</p>
                </div>
                <Button label="Generar Respaldo" icon="pi pi-cloud-upload" @click="openNew" 
                    class="!bg-emerald-600 !border-none !rounded-xl !px-6 !py-3 shadow-lg shadow-emerald-500/20 hover:!bg-emerald-500 transition-all" />
            </div>

            <DataTable :value="respaldos" paginator :rows="10" class="p-datatable-atlantis" responsiveLayout="stack">
                <Column header="ID" class="w-16 text-slate-500 text-xs font-mono">
                    <template #body="{ data }">
                        {{ data.id_respaldo }}
                    </template>
                </Column>
                
                <Column header="FECHA Y HORA">
                    <template #body="{ data }">
                        <div class="flex items-center gap-3 text-white font-mono text-sm">
                            <i class="pi pi-calendar-plus text-emerald-500 text-xs"></i>
                            {{ formatDateTime(data.fecha) }}
                        </div>
                    </template>
                </Column>

                <Column header="OBSERVACIONES / DESCRIPCIÓN">
                    <template #body="{ data }">
                        <div class="text-slate-300 text-sm bg-white/5 p-3 rounded-lg border border-white/5 max-w-md">
                            {{ data.descripcion }}
                        </div>
                    </template>
                </Column>

                <Column header="ESTADO">
                    <template #body>
                        <Tag value="COMPLETADO" severity="success" class="!bg-emerald-500/10 !text-emerald-400 !border-emerald-500/20" />
                    </template>
                </Column>

                <Column header="ACCIONES" class="text-right w-32">
                    <template #body="{ data }">
                        <div class="flex justify-end gap-1">
                            <Button icon="pi pi-trash" text rounded severity="danger" @click="deleteRespaldo(data.id_respaldo)" />
                        </div>
                    </template>
                </Column>
            </DataTable>
        </div>

        <Dialog v-model:visible="displayModal" header="Generar Punto de Restauración" modal 
            class="p-dark w-full max-w-md" 
            :pt="{ 
                root: { class: 'bg-[#1a1d2b] border border-white/10 shadow-2xl rounded-[1.5rem]' },
                header: { class: 'bg-[#1a1d2b] text-white border-b border-white/5 p-6' },
                content: { class: 'bg-[#1a1d2b] text-white p-6' }
            }">
            
            <form @submit.prevent="submit" class="grid grid-cols-1 gap-6 pt-2">
                <div class="flex flex-col gap-2">
                    <label class="text-xs font-bold text-slate-500 uppercase tracking-widest px-1">Motivo del Respaldo</label>
                    <textarea v-model="form.descripcion" rows="4" 
                        placeholder="Ej. Respaldo semanal, previo a actualización de rutas..."
                        class="w-full bg-[#0f111a] border border-white/10 text-white focus:border-emerald-500 rounded-xl p-4 outline-none transition-all placeholder:text-slate-700"></textarea>
                    <small v-if="form.errors.descripcion" class="text-red-400 px-1">{{ form.errors.descripcion }}</small>
                </div>

                <div class="bg-emerald-500/5 border border-emerald-500/10 p-4 rounded-xl flex gap-3">
                    <i class="pi pi-info-circle text-emerald-500 mt-1"></i>
                    <p class="text-xs text-emerald-200/60 leading-relaxed">
                        Esta acción registrará el punto actual de la base de datos. Asegúrese de que no haya procesos de escritura críticos activos.
                    </p>
                </div>

                <div class="flex justify-end gap-3 mt-4 border-t border-white/5 pt-6">
                    <Button label="Cancelar" text severity="secondary" @click="displayModal = false" class="!text-slate-400" />
                    <Button label="Iniciar Respaldo" type="submit" 
                        icon="pi pi-check-circle" :loading="form.processing" class="!bg-emerald-600 !border-none !rounded-xl !px-6" />
                </div>
            </form>
        </Dialog>
    </Layout>
</template>

<style scoped>
:deep(.p-datatable-atlantis) { background: transparent; }
:deep(.p-datatable-thead > tr > th) {
    background: rgba(255, 255, 255, 0.02) !important;
    color: #10b981 !important; /* Color Emerald */
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
    background: rgba(16, 185, 129, 0.1) !important;
    color: #10b981 !important;
    border-radius: 10px;
}
</style>