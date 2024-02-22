<template>
    <AppLayout title="Empresa" title_page="Responsáveis">
        <template #center>
            <company.AdminListResponsible></company.AdminListResponsible>
        </template>
    </AppLayout>
</template>
<script setup>
import * as company from '@/ComponentsPage/js/company';
</script>
