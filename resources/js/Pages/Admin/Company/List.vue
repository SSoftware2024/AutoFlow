<template>
    <AppLayout title="Empresa" title_page="Lista empresas">
        <template #center>
            <company.AdminList></company.AdminList>
        </template>
    </AppLayout>
</template>
<script setup>
import * as company from '@/ComponentsPage/js/company';
</script>
