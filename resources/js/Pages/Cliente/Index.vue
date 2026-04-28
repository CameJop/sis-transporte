<template>
    <AtlantisLayout>
        <div class="bg-[#1a1d2b] p-8 rounded-[2rem] border border-white/5 shadow-2xl">
            <div class="flex justify-between items-center mb-6">
                <h1 class="text-2xl font-bold text-white">Clientes</h1>
                <Button label="Nuevo Pasajero" icon="pi pi-plus" @click="openModal" class="!rounded-xl" />
            </div>

            <DataTable :value="clientes" class="p-datatable-atlantis">
                <Column field="documento_identidad" header="CI / NIT"></Column>
                <Column field="nombre" header="NOMBRE"></Column>
                <Column field="telefono" header="TELÉFONO"></Column>
                <Column header="ACCIONES">
                    <template #body="slotProps">
                        <Button icon="pi pi-pencil" text severity="secondary" @click="edit(slotProps.data)" />
                        <Button icon="pi pi-trash" text severity="danger" @click="del(slotProps.data.id_pasajero)" />
                    </template>
                </Column>
            </DataTable>
        </div>
    </AtlantisLayout>
</template>