<template>
    <AppLayout title="Administrador" title_page="Novo administrador">
        <template #center>
            <Panel header="Cadastro">
                <admin.Create></admin.Create>
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

</script>
