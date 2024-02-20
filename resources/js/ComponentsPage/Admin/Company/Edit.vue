<template>
    <div class="w-full">
        <form @submit.prevent="update" enctype="multipart/form-data">
            <div class="row-col">
                <div class="mb-3 center-col row-col">
                    <div class="relative">
                        <img v-if="!page.props.company.logo && !image" :src="page.props.images.company"
                            class="max-w-[94px]" />
                        <Image alt="Image" preview v-else-if="image">
                            <template #image>
                                <img :src="image" alt="image" class="w-[100px]" />
                            </template>
                            <template #preview="slotProps">
                                <img :src="image" alt="preview" :style="slotProps.style"
                                    @click="slotProps.previewCallback" />
                            </template>
                        </Image>
                        <Image alt="Image" preview v-else-if="!image && page.props.company.logo">
                            <template #image>
                                <img :src="page.props.company.logo_url.thumbmail" alt="image" class="w-[100px]" />
                            </template>
                            <template #preview="slotProps">
                                <img :src="page.props.company.logo_url.default" alt="preview" :style="slotProps.style"
                                    @click="slotProps.previewCallback" />
                            </template>
                        </Image>
                        <div class="flex flex-row justify-end w-full">
                            <a v-if="page.props.company.logo || image"
                                class="underline cursor-pointer text-danger-600 hover:font-bold" v-tooltip="'Remover foto'"
                                @click="deleteImage">
                                <i class="fa-solid fa-trash-can"></i>
                            </a>
                        </div>
                    </div>
                </div>
                <div class="row-col">
                    <SimpleFile ref="inputFile" v-model="form.photo" :containPreview="true" @preview="(url) => image = url"
                        :is-in-valid="form.errors.photo"></SimpleFile>
                    <span v-if="form.errors.photo" class="text-danger-600">
                        {{ form.errors.photo }}
                    </span>
                </div>
            </div>
            <div class="my-1 row">
                <div class="row-col">
                    <div class="flex cursor-pointer align-items-center">
                        <Checkbox v-model="form.active"  inputId="responsible" :binary="true" />
                        <label for="responsible" class="ml-2 cursor-pointer"> Ativa</label>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="row-col">
                    <label for="cnpj">CNPJ</label>
                    <InputMask id="cnpj" v-model="form.cnpj" mask="99.999.999/9999-99" placeholder="99.999.999/9999-99"
                        :class="{
                            'p-invalid': form.errors.cnpj
                        }" />
                    <span v-if="form.errors.cnpj" class="text-danger-600">
                        {{ form.errors.cnpj }}
                    </span>
                </div>
            </div>
            <div class="row sm:space-x-3">
                <div class="row-col">
                    <label for="razao">Razão</label>
                    <InputText id="razao" aria-describedby="razao-help" v-model="form.name" :class="{
                        'p-invalid': form.errors.name
                    }" />
                    <span v-if="form.errors.name" class="text-danger-600">
                        {{ form.errors.name }}
                    </span>
                </div>
                <div class="row-col">
                    <label for="surname">Apelido</label>
                    <InputText id="surname" aria-describedby="surname-help" v-model="form.surname" :class="{
                        'p-invalid': form.errors.surname
                    }" />
                    <span v-if="form.errors.surname" class="text-danger-600">
                        {{ form.errors.surname }}
                    </span>
                </div>
            </div>
            <div class="row">
                <div class="row-col">
                    <label for="">Plano de pagamento</label>
                    <Dropdown v-model="form.payment_plan" :options="page.props.payment_plans" optionLabel="title"
                        optionValue="id" placeholder="Selecione" class="w-full" :class="{
                            'p-invalid': form.errors.payment_plan
                        }" />
                    <span v-if="form.errors.payment_plan" class="text-danger-600">
                        {{ form.errors.payment_plan }}
                    </span>
                </div>
            </div>
            <div class="justify-end mt-2 row">
                <Button label="Salvar" type="submit" icon="fa-solid fa-save" iconPos="right" severity="success"
                    :loading="form.processing" />
            </div>
        </form>
    </div>
</template>
<script setup>
import { ref } from 'vue';
import { useForm, usePage, router } from '@inertiajs/vue3';
import { useToast } from "primevue/usetoast";
import { useConfirm } from "primevue/useconfirm";
import SimpleFile from '@/Components/FileUpload/Simple.vue';
const toast = useToast();
const page = usePage();
const confirm = useConfirm();
const image = ref(null);
//refs
const inputFile = ref(null);

const form = useForm({
    name: page.props.company.name,
    surname: page.props.company.surname,
    cnpj: page.props.company.cnpj,
    payment_plan: page.props.company.payment_plan_id,
    active: page.props.company.active,
    photo: null,
});

function update() {
    form.transform((data) => ({
        ...data,
        _method: 'put',
        id: page.props.company.id,
    })).post(route('adm.company.update'));
}

function deleteImage() {
    if (image.value) {
        inputFile.value.deleteImage();
        toast.add({ severity: 'info', summary: 'Informação', detail: 'Foto temporaria removida', life: page.props.toast.time });
    } else if (page.props.company.logo) {
        confirm.require({
            message: 'Deseja deletar sua foto atual?',
            header: 'Exclusão',
            icon: 'pi pi-question-circle',
            rejectClass: 'p-button-danger p-button-text',
            acceptClass: 'p-button-text p-button-text',
            rejectLabel: 'Aceitar',
            acceptLabel: 'Rejeitar',
            accept: () => {

            },
            reject: () => {
                router.patch(route('adm.company.deleteImage', { id: page.props.company.id }));
            }
        });

    }
}
</script>
