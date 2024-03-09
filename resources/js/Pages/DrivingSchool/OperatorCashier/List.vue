<template>
    <AppLayout title="Balconista" title_page="Listagem Balconista">
        <template #center>
            <div class="flex justify-end">
                <div class="flex justify-end mb-2">
                    <SplitButton label="Recarregar" icon="pi pi-refresh" severity="info" @click="reload" :model="options" />
                </div>
            </div>
            <Panel header="Lista">
                <operator_cashier.OperatorCashierList></operator_cashier.OperatorCashierList>
            </Panel>
        </template>
    </AppLayout>
</template>
<script setup>
import { router, usePage } from '@inertiajs/vue3';
import { useToast } from "primevue/usetoast";
import { operator_cashier } from '@/ComponentsPage/js/driving_school.js';

const page = usePage();
const toast = useToast();

const options = [
    {
        label: 'Novo',
        icon: 'fa-solid fa-plus',
        command: () => {
            router.get(route('user.driving_school.operator_cashier.createView'));
        }
    },
];

function reload() {
    router.visit(page.url, {
        method: 'GET',
        preserveState: false,
        onSuccess: () => toast.add({ severity: 'success', summary: 'Sucesso', detail: 'Página atualizada com sucesso', life: page.props.toast.time })
    });
}
</script>
