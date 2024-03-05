<template>
    <AppLayout title="Alunos" title_page="Editar aluno">
        <template #center>
            <Panel header="Editar">
                <driving_school.students.StudentEdit></driving_school.students.StudentEdit>
            </Panel>
        </template>
    </AppLayout>
</template>
<script setup>
import * as driving_school from '@/ComponentsPage/js/driving_school.js';
</script>
