<template>
    <Panel header="Lista">
        <div class="flex justify-end">
            <Button label="Nova" link icon="fa-solid fa-plus" iconPos="right"
                @click="$toRoute(route('adm.company.createView'))" />
        </div>
        <Accordion :activeIndex="0">
            <AccordionTab v-for="value in  page.props.companys.data " :key="value.id">
                <template #header>
                    <span class="flex w-full gap-2 align-items-center">

                        <span class="font-bold white-space-nowrap">{{ value.name }}</span>
                        <div class="ml-auto mr-2">
                            <Badge value="INATIVA" severity="danger" class="mr-2" v-if="!value.active"/>
                            <Badge value="05/02 - PAGO"  />
                        </div>
                    </span>
                </template>
                <div class="flex justify-start w-full">
                    <Image alt="Image" preview v-if="value.logo">
                        <template #image>
                            <img :src="value.logo_url.thumbmail" alt="image" class="w-[100px]" />
                        </template>
                        <template #preview="slotProps">
                            <img :src="value.logo_url.default" alt="preview" :style="slotProps.style"
                                @click="slotProps.previewCallback" />
                        </template>
                    </Image>
                </div>
                <div>
                    <ul class="list-none">
                        <li>
                            <span class="font-bold">Razão:</span> {{ value.name }}
                        </li>
                        <li>
                            <span class="font-bold">Apelido:</span> {{ value.surname }}
                        </li>
                        <li>
                            <span class="font-bold">CNPJ:</span> {{ value.cnpj }}
                        </li>
                        <li>
                            <span class="font-bold">Plano de pagamento:</span> {{ value.payment_plan.title }}
                        </li>
                        <li>
                            <span class="font-bold">Clientes:</span> {{ value.users_count }}
                        </li>
                    </ul>
                </div>
                <div class="relative flex flex-col justify-between p-3 border rounded-md sm:flex-row border-slate-300">
                    <div class="flex justify-start">
                        <icon-button-dropdown id="company-options" class="bg-[#0EA5E9] w-auto text-white p-2 rounded-md"
                            :default-icon="true">
                            <template #icon>
                                <i class="mr-2 fa-solid fa-gear"></i>
                            </template>
                            <link-dropdown title="Editar" icon="fa fa-edit"
                                :href="route('adm.company.editView', { company: value.id })"></link-dropdown>
                            <link-button-dropdown title="Deletar" icon="fa fa-trash" @click="toDelete(value.id, value.name)"></link-button-dropdown>
                        </icon-button-dropdown>
                    </div>
                    <div class="flex flex-wrap relative sm:top-[5px]">
                        <Link :href="route('adm.user.index', {company_id: value.id})"
                            class="transition duration-150 ease-in-out text-success hover:text-success-600 hover:underline focus:text-success-600 active:text-success-700">
                        Clientes
                        </Link>
                        <span class="mx-3 font-bold"> / </span>
                        <Link :href="route('adm.company.listResponsibleView', {company: value.id})"
                            class="transition duration-150 ease-in-out text-success hover:text-success-600 hover:underline focus:text-success-600 active:text-success-700">
                        Controle Responsável
                        </Link>
                        <span class="mx-3 font-bold"> / </span>
                        <Link href="#"
                            class="transition duration-150 ease-in-out text-success hover:text-success-600 hover:underline focus:text-success-600 active:text-success-700">
                        Histórico de pagamentos
                        </Link>
                    </div>
                </div>
            </AccordionTab>
        </Accordion>
        <div>
            <Pagination :pagination="page.props.companys" @paginate="paginate"></Pagination>
        </div>
    </Panel>
</template>
<script setup>
import { onMounted } from 'vue';
import { usePage, router } from '@inertiajs/vue3';
import { useConfirm } from "primevue/useconfirm";
const confirm = useConfirm();
const page = usePage();
//refs
//data
function toDelete(id, company_name) {
    confirm.require({
        message: `Deseja deletar o registro: ${company_name}`,
        header: 'Exclusão',
        icon: 'pi pi-question-circle',
        rejectClass: 'p-button-danger p-button-text',
        acceptClass: 'p-button-text p-button-text',
        rejectLabel: 'Aceitar',
        acceptLabel: 'Rejeitar',
        accept: () => {

        },
        reject: () => {
            router.delete(route('adm.company.delete', [id]));
        }
    });
}

function paginate(page_link) {
    router.visit(page.url, {
        data: {
            page: page_link
        },
        only: ['companys'],
        preserveState: true
    });
}
onMounted(() => {
});
</script>
