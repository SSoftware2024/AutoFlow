<template>
    <AppLayout title="Empresa" title_page="Lista empresas">
        <template #center>
            <company.List></company.List>
        </template>
    </AppLayout>
</template>
<script setup>
import * as company from '@/ComponentsPage/js/company';
</script>
