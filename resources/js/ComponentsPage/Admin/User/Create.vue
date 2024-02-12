<template>
    <form @submit.prevent="create">
        <div class="space-x-1 row">
            <div class="row-col">
                <label>Nome:</label>
                <InputText v-model="form.name" id="username" :class="{
                    'p-invalid': false
                }" />
                <span v-if="form.errors.name" class="text-danger-600">
                    {{ form.errors.name }}
                </span>
            </div>
            <div class="row-col">
                <label>Email:</label>
                <InputText v-model="form.email" :class="{
                    'p-invalid': false
                }" />
                <span v-if="form.errors.email" class="text-danger-600">
                    {{ form.errors.email }}
                </span>
            </div>
        </div>
        <div class="space-x-1 row">
            <div class="row-col">
                <label>Senha:</label>
                <Password v-model="form.password" :feedback="false" toggleMask :class="{
                    'p-invalid': false
                }" />
                <span v-if="form.errors.password" class="text-danger-600">
                    {{ form.errors.password }}
                </span>
            </div>
            <div class="row-col">
                <label>Confirmar senha:</label>
                <Password v-model="form.password_confirmation" :feedback="false" toggleMask :class="{
                    'p-invalid': false
                }" />
                <span v-if="form.errors.password_confirmation" class="text-danger-600">
                    {{ form.errors.password_confirmation }}
                </span>
            </div>
        </div>
        <div class="my-1 row">
            <div class="row-col">
                <div class="flex cursor-pointer align-items-center">
                    <Checkbox v-model="form.responsible" inputId="responsible" :binary="true" @change="companyForUser" />
                    <label for="responsible" class="ml-2 cursor-pointer"> Responsável </label>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="row-col">
                <label for="" v-html="textSelectCompany"></label>
                <Dropdown v-model="form.company_id" :options="page.props.companies" optionLabel="name" optionValue="id"
                    placeholder="Selecione" class="w-full" filter :class="{
                        'p-invalid': false
                    }" />
                <span v-if="form.errors.company_id" class="text-danger-600">
                    {{ form.errors.company_id }}
                </span>
            </div>
        </div>
        <div class="justify-end mt-2 row">
            <Button label="Cadastrar" type="submit" icon="fa-solid fa-plus" iconPos="right" severity="success"
                :loading="form.processing" />
        </div>
    </form>
</template>
<script setup>
import { onMounted, ref } from 'vue';
import { router, useForm, usePage } from '@inertiajs/vue3';
const page = usePage();

const textSelectCompany = ref("");
const form = useForm({
    company_id: 0,
    name: '',
    email: '',
    password: '',
    password_confirmation: '',
    responsible: page.props.filter.responsible ?? false,
});
function _nameSelectCompany() {
    textSelectCompany.value = form.responsible ? "<span>Empresas <span class='font-bold text-danger-700'>SEM</span> responsável</span>" : "<span>Empresas <span class='font-bold text-green-700'>COM</span> responsável </span>";
}
function companyForUser() {
    router.visit(route('adm.user.createView'), {
        method: 'get',
        only: ['companies','filter','errors'],
        data: {
            responsible: form.responsible,
        },
        preserveState: true,
        onSuccess: () => {
            _nameSelectCompany();
            form.company_id = 0;
        },
    });
}

function create() {
    form.post(route('adm.user.create'), {
        onSuccess: () => form.reset(),
    });

}
onMounted(() => {
    _nameSelectCompany();
});
</script>

