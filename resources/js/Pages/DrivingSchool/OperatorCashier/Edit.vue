<template>
    <AppLayout title="Balconista" title_page="Editar Balconista">
        <template #center>
            <Panel header="Edição">
                <operator_cashier.OperatorCashierEdit></operator_cashier.OperatorCashierEdit>
            </Panel>
        </template>
    </AppLayout>
</template>
<script setup>
import { operator_cashier } from '@/ComponentsPage/js/driving_school.js';
</script>
