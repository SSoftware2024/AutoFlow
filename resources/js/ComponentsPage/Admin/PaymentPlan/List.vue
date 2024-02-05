<template>
    <div class="w-full">
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
                        <Button label="Editar" class="mr-2" severity="warning" icon="fa-solid fa-edit" iconPos="left"
                            @click="$toRoute(route('payment_plan.editView', [slotProps.data.id]))" />
                        <Button label="Deletar" severity="danger"
                            :loading="loads.delete.load && loads.delete.id == slotProps.data.id" icon="fa-solid fa-trash"
                            iconPos="left" @click="excludeQuestion(slotProps.data.id)" />
                    </template>
                </Column>
            </DataTable>
        </div>
    </div>
</template>
<script setup>
import { onMounted, reactive } from 'vue';
import { useForm, usePage, router } from '@inertiajs/vue3';
import { useToast } from "primevue/usetoast";
import { useConfirm } from "primevue/useconfirm";
const toast = useToast();
const confirm = useConfirm();
const page = usePage();

const loads = reactive({
    delete: {
        id: 0,
        load: false,
    }
});

function excludeQuestion(id) {
    confirm.require({
        message: 'Deseja deletar o registro?',
        header: 'Exclusão',
        icon: 'pi pi-question-circle',
        rejectClass: 'p-button-text p-button-text',
        acceptClass: 'p-button-danger p-button-text',
        accept: () => {
            router.delete(route('payment_plan.delete', { id: id }), {
                onStart: () => {
                    loads.delete.load = true;
                    loads.delete.id = id;
                },
                onSuccess: () => {
                    toast.add({ severity: 'info', summary: 'Sucesso', detail: 'Registro deletado com sucesso', life: 3000 });
                },
                onFinish: () => {
                    loads.delete.load = false;
                    loads.delete.id = 0;
                },
            })

        },
        reject: () => {
            toast.add({ severity: 'error', summary: 'Rejected', detail: 'You have rejected', life: 3000 });
        }
    });
}

onMounted(() => {

});
</script>
