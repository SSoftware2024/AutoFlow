<template>
    <AppLayout title="Plano Pagamento" title_page="Lista de planos de pagamento">
        <template #center>
            <Panel header="Listagem">
                <div class="flex justify-end">
                    <Button label="Novo" link icon="fa-solid fa-plus" iconPos="right"
                        @click="$toRoute(route('payment_plan.create'))" />
                </div>
                <div class="overflow-x-auto">
                    <DataTable :value="page.props.payment_plan" tableStyle="min-width: 50rem">
                        <Column field="title" header="Título"></Column>
                        <Column field="price" header="Valor"></Column>
                        <Column header="Ações">
                            <template #body="slotProps">
                                <Button label="Editar" class="mr-2" severity="warning" icon="fa-solid fa-edit"
                                    iconPos="left" />
                                <Button label="Deletar" severity="danger" icon="fa-solid fa-trash" iconPos="left" @click="excludeQuestion" />
                            </template>
                        </Column>
                    </DataTable>
                </div>
            </Panel>
        </template>
    </AppLayout>
</template>
<script setup>
import { onMounted, inject } from 'vue';
import { useForm, usePage, router } from '@inertiajs/vue3';
import { useToast } from "primevue/usetoast";
import { useConfirm } from "primevue/useconfirm";
const toast = useToast();
const confirm = useConfirm();
const page = usePage();


function exclude() {

}
function excludeQuestion() {
    confirm.require({
        message: 'Deseja deletar o registro?',
        header: 'Confirmação Exclusão',
        icon: 'pi pi-question-circle',
        rejectClass: 'p-button-text p-button-text',
        acceptClass: 'p-button-danger p-button-text',
        accept: () => {
            toast.add({ severity: 'info', summary: 'Confirmed', detail: 'Record deleted', life: 3000 });
        },
        reject: () => {
            toast.add({ severity: 'error', summary: 'Rejected', detail: 'You have rejected', life: 3000 });
        }
    });
}

onMounted(() => {

});
</script>
