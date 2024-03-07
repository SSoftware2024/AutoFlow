<template>
    <AppLayout title="Professores" title_page="Listagem">
        <template #center>
            <div class="flex justify-end">
                <div class="flex justify-end mb-2">
                    <SplitButton label="Recarregar" icon="pi pi-refresh" severity="info" @click="reload" :model="options" />
                </div>
            </div>
            <Panel header="Lista">
                <teachers.TeacherList></teachers.TeacherList>
            </Panel>
        </template>
    </AppLayout>
</template>
<script setup>
import { router, usePage } from '@inertiajs/vue3';
import { useToast } from "primevue/usetoast";
import { teachers } from '@/ComponentsPage/js/driving_school.js';

const page = usePage();
const toast = useToast();
const options = [
    {
        label: 'Novo',
        icon: 'fa-solid fa-plus',
        command: () => {
            router.get(route('user.driving_school.teacher.createView'));
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

