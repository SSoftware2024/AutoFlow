<template>
    <AppLayout title="Professores" title_page="Novo professor">
        <template #center>
            <Panel header="Cadastro">
                <teachers.TeacherCreate></teachers.TeacherCreate>
            </Panel>
        </template>
    </AppLayout>
</template>
<script setup>
import { teachers } from '@/ComponentsPage/js/driving_school.js';
</script>
