<template>
    <DataTable :value="page.props.users" tableStyle="min-width: 50rem">
        <Column field="id" header="ID"></Column>
        <Column field="name" header="Nome"></Column>
        <Column field="company.name" header="Empresa"></Column>
        <Column field="responsible" header="Responsavel">
            <template #body="slotProps">
                <Badge value="RESPONSÁVEL" severity="success" v-if="slotProps.data.responsible"></Badge>
                <Badge value="INTEGRANTE" severity="secondary" v-else></Badge>
            </template>
        </Column>
        <Column header="Ações">
            <template #body="slotProps">
                <div class="flex justify-start">
                    <icon-button-dropdown id="company-options" class="bg-[#0EA5E9] w-auto text-white p-2 rounded-md"
                        :default-icon="true">
                        <template #icon>
                            <i class="mr-2 fa-solid fa-gear"></i>
                        </template>
                        <link-dropdown title="Editar" icon="fa fa-edit" :href="route('adm.user.editView', {user: slotProps.data.id})"></link-dropdown>
                        <link-button-dropdown title="Ver foto" icon="fa-solid fa-image" @click=""></link-button-dropdown>
                        <link-button-dropdown title="Revogar 2FA" icon="fa fa-lock-open" class="text-yellow-500" @click=""></link-button-dropdown>
                        <link-button-dropdown title="Deletar foto" icon="fa fa-trash" @click=""></link-button-dropdown>
                        <link-button-dropdown title="Deletar usuário" icon="fa fa-trash" class="text-red-500" @click=""></link-button-dropdown>
                    </icon-button-dropdown>
                </div>
            </template>
        </Column>
    </DataTable>
</template>
<script setup>
import { usePage } from '@inertiajs/vue3';
const page = usePage();
</script>
