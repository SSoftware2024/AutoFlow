<template>
    <div>
        <DataTable :value="page.props.administrators.data" tableStyle="min-width: 50rem">
            <Column field="id" header="ID">
                <template #body="slotProps">
                    <span class="font-medium">{{ slotProps.data.id }}</span>
                </template>
            </Column>
            <Column field="name" header="Nome"></Column>
            <Column field="email" header="Email"></Column>
            <Column field="level_access" header="Responsavel">
                <template #body="slotProps">
                    <Badge value="PRIMÁRIO" severity="success" v-if="slotProps.data.level_access == 'first'"></Badge>
                    <Badge value="SECUNDÁRIO" severity="secondary" v-else></Badge>
                </template>
            </Column>
            <Column header="Ações">
                <template #body="slotProps">
                    <div class="flex justify-start">
                        <icon-button-dropdown id="company-options" class="text-xl" :default-icon="false">
                            <template #icon>
                                <i class="mr-2 fa-solid fa-ellipsis-vertical"></i>
                            </template>
                            <link-dropdown title="Editar" icon="fa fa-edit"
                                :href="route('adm.user.editView', { user: slotProps.data.id })"></link-dropdown>
                            <link-button-dropdown title="Ver foto" icon="fa-solid fa-image"
                                @click=""></link-button-dropdown>
                            <link-button-dropdown title="Revogar 2FA" icon="fa fa-lock-open" class="text-yellow-500"
                                @click=""></link-button-dropdown>
                            <link-button-dropdown title="Deletar foto" icon="fa fa-trash" @click=""></link-button-dropdown>
                            <link-button-dropdown title="Deletar usuário" icon="fa fa-trash" class="text-red-500"
                                @click=""></link-button-dropdown>
                        </icon-button-dropdown>
                    </div>
                </template>
            </Column>
        </DataTable>
    </div>
    <div>
        <Pagination :pagination="page.props.administrators" :onEachSize="3" @paginate="paginate" />
    </div>
</template>
<script setup>
import { onMounted, ref } from 'vue';
import { router, usePage } from '@inertiajs/vue3';
import { useToast } from "primevue/usetoast";
import { alert } from '@/Src/Utils/functions';
import { emitter } from '@/Src/Utils/globalEvents';

const page = usePage();
function paginate(page_link) {
    router.visit(page.url, {
        data: {
            page: page_link
        },
        preserveState: true
    });
}
</script>
