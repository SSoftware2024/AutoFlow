<template>
    <AppLayout title="Veículos" title_page="Listagem de veículos">
        <template #center>
            <div class="flex justify-end">
                <div class="flex justify-end mb-2">
                    <SplitButton label="Recarregar" icon="pi pi-refresh" severity="info" @click="reload" :model="options" />
                </div>
            </div>
            <Panel header="Lista">
                <driving_school.vehicles.List></driving_school.vehicles.List>
            </Panel>
        </template>
    </AppLayout>
</template>
<script setup>
import * as driving_school from '@/ComponentsPage/js/driving_school.js';
import { router, usePage } from '@inertiajs/vue3';
import { useToast } from "primevue/usetoast";

const toast = useToast();
const page = usePage();
const options = [
    {
        label: 'Novo',
        icon: 'fa-solid fa-plus',
        command: () => {
            router.get(route('user.driving_school.vehicles.createView'));
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
