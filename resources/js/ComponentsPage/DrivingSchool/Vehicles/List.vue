<template>
    <div>
        <div>
            <DataTable :value="page.props.vehicles.data" tableStyle="min-width: 50rem">
                <Column field="id" header="ID">
                    <template #body="slotProps">
                        <span class="font-medium">{{ slotProps.data.id }}</span>
                    </template>
                </Column>
                <Column field="surname" header="Nome"></Column>
                <Column field="plate" header="Placa"></Column>
                <Column field="category" header="Categoria"></Column>
                <Column field="ipva_value" header="IPVA valor"></Column>
                <Column field="ipva_generate" header="IPVA data"></Column>
                <Column header="Ações">
                    <template #body="slotProps">
                        <div class="flex justify-start">
                            <cs-dropdown id="company-options" class="text-xl" :default-icon="false">
                                <template #icon>
                                    <i class="mr-2 fa-solid fa-ellipsis-vertical"></i>
                                </template>
                                <link-dropdown title="Editar" icon="fa fa-edit"
                                    :href="route('user.driving_school.vehicles.editView', { vehicle: slotProps.data.id })"></link-dropdown>
                                <link-button-dropdown title="Deletar" class="text-red-500" icon="fa fa-trash"
                                    @click="deleteVehicle(slotProps.data.id)"></link-button-dropdown>

                            </cs-dropdown>
                        </div>
                    </template>
                </Column>
            </DataTable>
        </div>
        <div>
            <Pagination :pagination="page.props.vehicles" :onEachSize="3" @paginate="paginate" />
        </div>
    </div>
</template>
<script setup>
import { router, usePage } from '@inertiajs/vue3';
import { alert } from '@/Src/Utils/functions.js';
const page = usePage();
function paginate(page_link) {
    router.visit(page.url, {
        data: {
            page: page_link
        },
        preserveState: true
    });
}

function deleteVehicle(id){
    alert.questionDeleteInvert(() => {
        router.delete(route('user.driving_school.vehicles.delete',[id]));
    });
}
</script>
