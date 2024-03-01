<template>
    <AppLayout title="Veículos" title_page="Listagem de veículos">
        <template #center>
            <Panel header="Lista">
                <driving_school.vehicles.List></driving_school.vehicles.List>
            </Panel>
        </template>
    </AppLayout>
</template>
<script setup>
import * as driving_school from '@/ComponentsPage/js/driving_school.js';
</script>
