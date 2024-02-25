<template>
    <AppLayout title="Administrador" title_page="Novo administrador">
        <template #center>
            <Panel header="Cadastro">
                <admin.Create></admin.Create>
            </Panel>
        </template>
    </AppLayout>
</template>
<script setup>
import * as admin from '@/ComponentsPage/js/admin.js';
</script>
