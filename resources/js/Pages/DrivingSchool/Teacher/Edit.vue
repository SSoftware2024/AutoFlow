<template>
    <AppLayout title="Professores" title_page="Editar professor">
        <template #center>
            <Panel header="Editar">
                <teachers.TeacherEdit></teachers.TeacherEdit>
            </Panel>
        </template>
    </AppLayout>
</template>
<script setup>
import { teachers } from '@/ComponentsPage/js/driving_school.js';
</script>
