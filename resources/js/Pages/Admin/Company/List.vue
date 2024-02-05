<template>
    <AppLayout title="Empresa" title_page="Lista empresas">
        <template #center>
            <Panel header="Lista">
                <Accordion :activeIndex="0">
                    <AccordionTab v-for="value in page.props.companys.data" :key="value.id">
                        <template #header>
                            <span class="flex w-full gap-2 align-items-center">

                                <span class="font-bold white-space-nowrap">{{ value.name }}</span>
                                <Badge value="05/02 - PAGO" class="ml-auto mr-2" />
                            </span>
                        </template>
                        <div class="flex justify-start w-full">
                            <Image alt="Image" preview v-if="value.logo">
                                <template #image>
                                    <img :src="`/storage/company/brand_logo/thumbmail/` + value.logo" alt="image"
                                        class="w-[100px]" />
                                </template>
                                <template #preview="slotProps">
                                    <img :src="`/storage/company/brand_logo/` + value.logo" alt="preview"
                                        :style="slotProps.style" @click="slotProps.previewCallback" />
                                </template>
                            </Image>
                        </div>
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
                                <span class="font-bold">Clientes:</span> 0
                            </li>
                        </ul>
                    </AccordionTab>
                </Accordion>
                <div>
                    <Pagination :pagination="page.props.companys" @paginate="paginate"></Pagination>
                </div>
            </Panel>
        </template>
    </AppLayout>
</template>
<script setup>
import { ref, onMounted, inject } from 'vue';
import { useForm, usePage, router } from '@inertiajs/vue3';
import { useToast } from "primevue/usetoast";
import Pagination from '@/Components/Navigate/Paginate.vue';
const toast = useToast();
const page = usePage();

const image = ref(null);
//refs
const inputFile = ref(null);

const form = useForm({
    photo: null,
    name: '',
    surname: '',
    cnpj: '',
    payment_plan: 0
});

function create() {
    form.post(route('company.create'), {
        onSuccess: () => {
            toast.add({ severity: 'success', summary: 'Sucesso', detail: 'Cadastro realizado com sucesso', life: page.props.toast.time });
            form.reset();
            deleteImage();
        },
    });
}
function deleteImage() {
    inputFile.value.deleteImage();

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
