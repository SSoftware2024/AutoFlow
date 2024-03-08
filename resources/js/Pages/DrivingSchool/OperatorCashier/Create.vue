<template>
    <AppLayout title="Balconista" title_page="Novo Balconista">
        <template #center>
            <Panel header="Cadastro">
                <operator_cashier.OperatorCashierCreate></operator_cashier.OperatorCashierCreate>
            </Panel>
        </template>
    </AppLayout>
</template>
<script setup>
import { operator_cashier } from '@/ComponentsPage/js/driving_school.js';
</script>
