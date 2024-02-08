<template>
    <AppLayout title="Plano Pagamento" title_page="Editar plano de pagamento">
        <template #center>
            <Panel :header="`Plano: ` + page.props.payment_plan.title">
                <payment_plan.Edit></payment_plan.Edit>
            </Panel>
        </template>
    </AppLayout>
</template>
<script setup>
import { usePage } from '@inertiajs/vue3';
import * as payment_plan from '@/ComponentsPage/js/payment_plan.js';
const page = usePage();
</script>
