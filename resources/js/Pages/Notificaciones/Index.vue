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
    notificaciones: Array,
    clientes: Array
});

const displayModal = ref(false);

const form = useForm({
    id_notificacion: null,
    id_cliente: null,
    mensaje: '',
    fecha: new Date().toISOString().slice(0, 16), // Formato para datetime-local
});

const openNew = () => {
    form.reset();
    form.fecha = new Date().toISOString().slice(0, 16);
    displayModal.value = true;
};

const toggleLeido = (data) => {
    const newStatus = !data.leido;
    useForm({ leido: newStatus }).put(route('notificaciones.update', data.id_notificacion));
};

const submit = () => {
    form.post(route('notificaciones.store'), {
        onSuccess: () => displayModal.value = false
    });
};

const deleteNotificacion = (id) => {
    if (confirm('¿Eliminar esta notificación?')) {
        form.delete(route('notificaciones.destroy', id));
    }
};

const formatDate = (dateStr) => {
    return new Date(dateStr).toLocaleString('es-BO', {
        day: '2-digit', month: '2-digit', year: 'numeric',
        hour: '2-digit', minute: '2-digit'
    });
};
</script>

<template>
    <Head title="Centro de Notificaciones" />
    <Layout>
        <div class="bg-[#1a1d2b] p-8 rounded-[2rem] border border-white/5 shadow-2xl min-h-[70vh]">
            
            <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 mb-8">
                <div>
                    <h1 class="text-2xl font-bold text-white tracking-tight flex items-center gap-3">
                        <i class="pi pi-bell text-indigo-500"></i>
                        Centro de Notificaciones
                    </h1>
                    <p class="text-slate-500 text-sm mt-1">Historial de alertas y mensajes enviados a pasajeros.</p>
                </div>
                <Button label="Redactar Mensaje" icon="pi pi-send" @click="openNew" 
                    class="!bg-indigo-600 !border-none !rounded-xl !px-6 !py-3 shadow-lg shadow-indigo-500/20 hover:!bg-indigo-500 transition-all" />
            </div>

            <DataTable :value="notificaciones" paginator :rows="10" class="p-datatable-atlantis" responsiveLayout="stack">
                <Column field="id_notificacion" header="ID" class="w-16 text-slate-500 text-xs font-mono"></Column>
                
                <Column header="DESTINATARIO">
                    <template #body="{ data }">
                        <div class="flex flex-col">
                            <span class="font-semibold text-white">{{ data.cliente?.nombre || 'General' }}</span>
                            <span class="text-[10px] text-slate-500 uppercase tracking-tighter">{{ data.cliente?.documento_identidad }}</span>
                        </div>
                    </template>
                </Column>

                <Column header="MENSAJE" class="w-1/3">
                    <template #body="{ data }">
                        <span class="text-slate-300 text-sm italic">"{{ data.mensaje }}"</span>
                    </template>
                </Column>

                <Column header="FECHA Y HORA">
                    <template #body="{ data }">
                        <span class="text-xs text-slate-400 font-mono">{{ formatDate(data.fecha) }}</span>
                    </template>
                </Column>

                <Column header="ESTADO">
                    <template #body="{ data }">
                        <button @click="toggleLeido(data)">
                            <Tag :value="data.leido ? 'Leído' : 'Pendiente'" 
                                :class="data.leido ? '!bg-emerald-500/10 !text-emerald-400 !border-emerald-500/20' : '!bg-amber-500/10 !text-amber-400 !border-amber-500/20'" 
                                class="!border cursor-pointer hover:scale-105 transition-transform" rounded />
                        </button>
                    </template>
                </Column>

                <Column header="ACCIONES" class="text-right w-24">
                    <template #body="{ data }">
                        <div class="flex justify-end gap-1">
                            <Button icon="pi pi-trash" text rounded severity="danger" @click="deleteNotificacion(data.id_notificacion)" />
                        </div>
                    </template>
                </Column>
            </DataTable>
        </div>

        <Dialog v-model:visible="displayModal" header="Nueva Notificación" modal 
            class="p-dark w-full max-w-lg" 
            :pt="{ 
                root: { class: 'bg-[#1a1d2b] border border-white/10' },
                header: { class: 'bg-[#1a1d2b] text-white border-b border-white/5 p-6' },
                content: { class: 'bg-[#1a1d2b] text-white p-6' }
            }">
            
            <form @submit.prevent="submit" class="grid grid-cols-1 gap-6 pt-2">
                
                <div class="flex flex-col gap-2">
                    <label class="text-xs font-bold text-slate-500 uppercase tracking-widest">Seleccionar Cliente</label>
                    <Dropdown v-model="form.id_cliente" :options="clientes" optionLabel="nombre" optionValue="id_cliente" 
                        filter placeholder="Buscar pasajero..." class="w-full !bg-[#0f111a] !border-white/10" />
                    <small v-if="form.errors.id_cliente" class="text-red-400">{{ form.errors.id_cliente }}</small>
                </div>

                <div class="flex flex-col gap-2">
                    <label class="text-xs font-bold text-slate-500 uppercase tracking-widest">Contenido del Mensaje</label>
                    <textarea v-model="form.mensaje" rows="4" 
                        placeholder="Escriba el aviso aquí..."
                        class="w-full !bg-[#0f111a] !border-white/10 !text-white focus:!border-indigo-500 rounded-xl p-4 outline-none transition-all"></textarea>
                    <small v-if="form.errors.mensaje" class="text-red-400">{{ form.errors.mensaje }}</small>
                </div>

                <div class="flex flex-col gap-2">
                    <label class="text-xs font-bold text-slate-500 uppercase tracking-widest">Programar Fecha (Opcional)</label>
                    <input type="datetime-local" v-model="form.fecha" 
                        class="w-full !bg-[#0f111a] !border-white/10 !text-white focus:!border-indigo-500 rounded-lg p-2 outline-none" />
                </div>

                <div class="flex justify-end gap-3 mt-4">
                    <Button label="Cancelar" text severity="secondary" @click="displayModal = false" class="!text-slate-400" />
                    <Button label="Enviar Ahora" type="submit" 
                        icon="pi pi-send" :loading="form.processing" class="!bg-indigo-600 !border-none !rounded-xl" />
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