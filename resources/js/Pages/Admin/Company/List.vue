<template>
    <AppLayout title="Empresa" title_page="Nova empresa">
        <template #center>
            <Panel header="Cadastro">
                <form @submit.prevent="create" enctype="multipart/form-data">
                    <div class="row-col">
                        <div class="mb-3 center-col row-col">
                            <div class="relative">
                                <img v-if="!image" :src="page.props.images.company" class="max-w-[94px]" />
                                <Image v-else :src="image" alt="Image" width="250" preview />
                                <div class="flex flex-row justify-end w-full">
                                    <a v-if="image" class="underline cursor-pointer text-danger-600 hover:font-bold"
                                        v-tooltip="'Remover foto'" @click="deleteImage">
                                        <i class="fa-solid fa-trash-can"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="row-col">
                            <SimpleFile ref="inputFile" v-model="form.photo" :containPreview="true"
                                @preview="(url) => image = url" :is-in-valid="form.errors.photo"></SimpleFile>
                            <span v-if="form.errors.photo" class="text-danger-600">
                                {{ form.errors.photo }}
                            </span>
                        </div>
                    </div>
                    <div class="row">
                        <div class="row-col">
                            <label for="cnpj">CNPJ</label>
                            <InputMask id="cnpj" v-model="form.cnpj" mask="99.999.999/9999-99"
                                placeholder="99.999.999/9999-99" :class="{
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
                            <Dropdown v-model="form.payment_plan" :options="page.props.payment_plans"
                                optionLabel="title" optionValue="id" placeholder="Selecione" class="w-full" :class="{
                                    'p-invalid': form.errors.payment_plan
                                }" />
                            <span v-if="form.errors.payment_plan" class="text-danger-600">
                                {{ form.errors.payment_plan }}
                            </span>
                        </div>
                    </div>
                    <div class="justify-end mt-2 row">
                        <Button label="Cadastrar" type="submit" icon="fa-solid fa-plus" iconPos="right" severity="success"
                            :loading="form.processing" />
                    </div>
                </form>
            </Panel>
        </template>
    </AppLayout>
</template>
<script setup>
import { ref, onMounted, inject } from 'vue';
import { useForm, usePage } from '@inertiajs/vue3';
import { useToast } from "primevue/usetoast";
import SimpleFile from '@/Components/FileUpload/Simple.vue';
const alert = inject('Swal');
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
onMounted(() => {
});
</script>
