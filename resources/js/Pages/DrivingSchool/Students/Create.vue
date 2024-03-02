<template>
    <AppLayout title="Alunos" title_page="Novo aluno">
        <template #center>
            <Panel header="Cadastro">
                <driving_school.students.StudentCreate></driving_school.students.StudentCreate>
            </Panel>
        </template>
    </AppLayout>
</template>
<script setup>
import * as driving_school from '@/ComponentsPage/js/driving_school.js';
</script>
