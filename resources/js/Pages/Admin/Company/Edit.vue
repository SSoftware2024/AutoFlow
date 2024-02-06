<template>
    <AppLayout title="Empresa" title_page="Editar empresa">
        <template #center>
            <Panel header="Editar">
                <EditCompany></EditCompany>
            </Panel>
        </template>
    </AppLayout>
</template>
<script setup>
    import { Edit as EditCompany } from '@/ComponentsPage/js/company';
</script>
