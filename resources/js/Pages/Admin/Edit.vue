<template>
    <AppLayout title="Administrador" title_page="Editar administrador">
        <template #center>
            <Panel header="Editar">
                <admin.Edit></admin.Edit>
            </Panel>
        </template>
    </AppLayout>
</template>
<script setup>
import * as admin from '@/ComponentsPage/js/admin.js';
</script>
