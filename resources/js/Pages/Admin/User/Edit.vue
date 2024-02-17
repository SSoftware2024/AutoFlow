<template>
    <AppLayout title="Usuário" title_page="Editar usuário">
        <template #center>
            <Panel header="Editar cliente">
                <user.AdminEdit></user.AdminEdit>
            </Panel>
        </template>
    </AppLayout>
</template>
<script setup>
import * as user from '@/ComponentsPage/js/user.js';
</script>
