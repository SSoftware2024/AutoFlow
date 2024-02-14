<template>
    <AppLayout title="Usuário" title_page="Listagem de usuários(clientes)">
        <template #center>
            <div class="flex justify-end">
                <Button label="Novo" link icon="fa-solid fa-plus" iconPos="right"
                    @click="$toRoute(route('adm.user.createView'))" />
            </div>
            <Panel header="Listagem">
                <user.AdminList></user.AdminList>
            </Panel>
        </template>
    </AppLayout>
</template>
<script setup>
import * as user from '@/ComponentsPage/js/user.js';
</script>
