<template>
    <AppLayout title="Veículos" title_page="Editar veículo">
        <template #center>
            <Panel header="Editar">
                <driving_school.vehicles.Edit></driving_school.vehicles.Edit>
            </Panel>
        </template>
    </AppLayout>
</template>
<script setup>
import * as driving_school from '@/ComponentsPage/js/driving_school.js';
</script>
