<template>
    <AppLayout title="Usuário" title_page="Novo usuário">
        <template #center>
            <div class="flex justify-end mb-2">
                <SplitButton label="Recarregar" icon="pi pi-refresh" severity="info" @click="reload" :model="options" />
            </div>
            <Panel header="Novo cliente">
                <user.AdminCreate></user.AdminCreate>
            </Panel>
            <Dialog v-model:visible="visible" modal header="Cadastrar nova empresa" :style="{ width: '50%' }"
                position="top">
                <company.AdminCreate @close:modal="reload"></company.AdminCreate>
            </Dialog>
        </template>
    </AppLayout>
</template>
<script setup>
import { ref } from 'vue';
import { router, usePage } from '@inertiajs/vue3';
import { useToast } from "primevue/usetoast";
import * as user from '@/ComponentsPage/js/user.js';
import * as company from '@/ComponentsPage/js/company.js';

const toast = useToast();
const page = usePage();
const visible = ref(false);
const options = [
    {
        label: 'Nova empresa',
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
        preserveState:true,
        onSuccess: () => toast.add({ severity: 'info', summary: 'Informação', detail: 'Página atualizada com sucesso', life: page.props.toast.time })
    })
}
</script>
