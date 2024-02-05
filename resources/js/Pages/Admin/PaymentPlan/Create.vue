<template>
    <AppLayout title="Plano Pagamento" title_page="Novo plano de pagamento">
        <template #center>
            <Panel header="Cadastro">
                <PaymentPlanCreate></PaymentPlanCreate>
            </Panel>
        </template>
    </AppLayout>
</template>
<script setup>
    import { PaymentPlanCreate } from '@/ComponentsPage/Admin/PaymentPlan/pages.js';
</script>
