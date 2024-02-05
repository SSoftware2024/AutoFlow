<template>
    <AppLayout title="Empresa" title_page="Nova empresa">
        <template #center>
            <div class="flex justify-end mb-2">
                <SplitButton label="Recarregar" icon="pi pi-refresh" severity="info" @click="reload" :model="options" />
            </div>
            <Panel header="Cadastro">
                <company.Create></company.Create>
            </Panel>


            <Dialog v-model:visible="visible" modal header="Cadastrar novo plano" :style="{ width: '50%' }" position="top">
                <payment_plan.Create @close:modal="reload"></payment_plan.Create>
            </Dialog>
        </template>
    </AppLayout>
</template>
<script setup>
import { ref } from 'vue';
import { usePage, router } from '@inertiajs/vue3';
import { useToast } from "primevue/usetoast";
import * as company from '@/ComponentsPage/js/company';
import * as payment_plan from '@/ComponentsPage/js/payment_plan';
const page = usePage();
const toast = useToast();
const visible = ref(false);
const options = [
    {
        label: 'Novo plano pagamento',
        icon: 'pi pi-plus',
        command: () => {
            visible.value = true;
        }
    },
];
function reload() {
    visible.value = false;
    router.visit(page.url, {
        method: 'GET',
        preserveState: true,
        onSuccess: () => toast.add({ severity: 'success', summary: 'Sucesso', detail: 'Página atualizada com sucesso', life: page.props.toast.time })
    });
}
</script>
