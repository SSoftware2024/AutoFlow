<template>
    <AppLayout title="Plano Pagamento" title_page="Lista de planos de pagamento">
        <template #center>
            <Panel header="Listagem">
                <payment_plan.List></payment_plan.List>
            </Panel>
        </template>
    </AppLayout>
</template>
<script setup>
import * as payment_plan from '@/ComponentsPage/js/payment_plan.js';
</script>
