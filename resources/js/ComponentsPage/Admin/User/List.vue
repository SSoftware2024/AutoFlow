<template>
    <div>
        <div class="mb-2">
            <div class="row">
                <div class="row-col">
                    <label for="">Empresas</label>
                    <Dropdown v-model="company_id" :options="page.props.companies" optionLabel="name" optionValue="id"
                        placeholder="Selecione" class="w-full" filter @change="filter" />
                </div>
            </div>
        </div>
        <div>
            <DataTable :value="page.props.users.data" tableStyle="min-width: 50rem">
                <Column field="id" header="ID">
                    <template #body="slotProps">
                        <span class="font-medium">{{ slotProps.data.id }}</span>
                    </template>
                </Column>
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
                                <link-button-dropdown title="Deletar foto" icon="fa fa-trash"
                                    @click=""></link-button-dropdown>
                                <link-button-dropdown title="Deletar usuário" icon="fa fa-trash" class="text-red-500"
                                    @click=""></link-button-dropdown>
                            </icon-button-dropdown>
                        </div>
                    </template>
                </Column>
            </DataTable>
        </div>
        <div>
            <Pagination :pagination="page.props.users" :onEachSize="3" @paginate="paginate" />
        </div>
    </div>
</template>
<script setup>
import { onMounted, ref } from 'vue';
import { router, usePage } from '@inertiajs/vue3';
import { useToast } from "primevue/usetoast";
const props = defineProps({
    filter_method: {
        type: String,
        default: 'get',
    }
});
const page = usePage();
const toast = useToast();
const company_id = ref(0);

function filter() {
    router.visit(page.url, {
        method: props.filter_method,
        preserveState: true,
        data: {
            company_id: company_id.value
        }
    });
}

function paginate(page_link) {
    router.visit(page.url, {
        data: {
            page: page_link
        },
        preserveState: true
    });
}

onMounted(() => {
    const url = new URL(window.location.href);
    company_id.value = parseInt(url.searchParams.get('company_id')) ?? 0;
});
</script>
