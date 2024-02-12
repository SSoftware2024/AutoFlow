<template>
    <AppLayout title="Usuário" title_page="Novo usuário">
        <template #center>
            <Panel header="Novo cliente">
                <user.AdminCreate></user.AdminCreate>
            </Panel>
        </template>
    </AppLayout>
</template>
<script setup>
import * as user from '@/ComponentsPage/js/user.js';
</script>
