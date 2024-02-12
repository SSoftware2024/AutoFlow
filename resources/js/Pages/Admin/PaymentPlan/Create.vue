<template>
    <AppLayout title="Plano Pagamento" title_page="Novo plano de pagamento">
        <template #center>
            <Panel header="Cadastro">
                <payment_plan.AdminCreate></payment_plan.AdminCreate>
            </Panel>
        </template>
    </AppLayout>
</template>
<script setup>
    import * as payment_plan from '@/ComponentsPage/js/payment_plan.js';
</script>
