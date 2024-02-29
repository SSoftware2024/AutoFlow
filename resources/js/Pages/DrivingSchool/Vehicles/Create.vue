<template>
    <AppLayout title="Veículos" title_page="Novo veículo">
        <template #center>
            <Panel header="Cadastro">
                <driving_school.vehicles.VehicleCreate></driving_school.vehicles.VehicleCreate>
            </Panel>
        </template>
    </AppLayout>
</template>
<script setup>
import * as driving_school from '@/ComponentsPage/js/driving_school.js';
</script>

