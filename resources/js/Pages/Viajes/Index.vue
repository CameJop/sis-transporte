<template>
    <AtlantisLayout>
        <div class="bg-[#1a1d2b] p-8 rounded-[2rem] border border-white/5">
            <div class="flex justify-between items-center mb-6">
                <h1 class="text-2xl font-bold text-white">Próximos Viajes</h1>
                <Button label="Programar Viaje" icon="pi pi-calendar-plus" @click="openModal" class="!bg-indigo-600" />
            </div>

            <DataTable :value="viajes" class="p-datatable-atlantis">
                <Column header="RUTA">
                    <template #body="slotProps">
                        {{ slotProps.data.ruta?.nombre || 'Ruta #' + slotProps.data.id_ruta }}
                    </template>
                </Column>
                <Column field="fecha_salida" header="FECHA"></Column>
                <Column field="hora_salida" header="HORA"></Column>
                <Column field="estado" header="ESTADO">
                    <template #body="slotProps">
                        <span :class="slotProps.data.estado === 'Activo' ? 'text-green-400' : 'text-yellow-400'">
                            {{ slotProps.data.estado }}
                        </span>
                    </template>
                </Column>
                <Column header="ACCIONES">
                    <template #body="slotProps">
                        <Button icon="pi pi-trash" text severity="danger" @click="del(slotProps.data.id_viaje)" />
                    </template>
                </Column>
            </DataTable>
        </div>
    </AtlantisLayout>
</template>