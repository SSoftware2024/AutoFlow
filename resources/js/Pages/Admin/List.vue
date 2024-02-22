<template>
    <AppLayout title="Usuário" title_page="Listagem de administradores">
        <template #center>
            <div class="flex justify-end">
                <Button label="Novo" link icon="fa-solid fa-plus" iconPos="right"
                    @click="$toRoute(route('adm.user.createView'))" />
                <div class="flex justify-end mb-2">
                    <SplitButton label="Recarregar" icon="pi pi-refresh" severity="info" @click="reload" :model="options" />
                </div>
            </div>
            <Panel header="Listagem">
                <admin.List></admin.List>
            </Panel>
        </template>
    </AppLayout>
</template>
<script setup>
import * as admin from '@/ComponentsPage/js/admin.js';
import { router, usePage } from '@inertiajs/vue3';
import { useToast } from "primevue/usetoast";

const toast = useToast();
const page = usePage();
const options = [
    {
        label: 'Resetar filtro',
        icon: 'pi pi-close',
        command: () => {
            resetFilter();
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
function resetFilter() {
    router.visit(route('adm.user.index'), {
        method: 'GET',
        preserveState: false,
    });
}
</script>
