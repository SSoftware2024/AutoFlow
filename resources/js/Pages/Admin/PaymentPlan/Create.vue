<template>
    <AppLayout title="Plano Pagamento" title_page="Novo plano de pagamento">
        <template #center>
            <Panel header="Cadastro">
                <payment_plan.Create></payment_plan.Create>
            </Panel>
        </template>
    </AppLayout>
</template>
<script setup>
    import * as payment_plan from '@/ComponentsPage/js/payment_plan.js';
</script>
