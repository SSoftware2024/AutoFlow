<template>
    <AppLayout title="Plano Pagamento" title_page="Lista de planos de pagamento">
        <template #center>
            <Panel header="Listagem">
                <payment_plan.AdminList></payment_plan.AdminList>
            </Panel>
        </template>
    </AppLayout>
</template>
<script setup>
import * as payment_plan from '@/ComponentsPage/js/payment_plan.js';
</script>
