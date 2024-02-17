<template>
    <form @submit.prevent="update">
        <div class="sm:space-x-1 row">
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
        <div class="sm:space-x-1 row">
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
                    <Checkbox v-model="form.responsible" inputId="responsible" :binary="true" disabled @click="_alertGoControlResponsive" />
                    <label for="responsible" class="ml-2 cursor-pointer" @click="_alertGoControlResponsive" > Responsável </label>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="row-col">
                <label for="">Empresas com responsável</label>
                <Dropdown v-model="form.company_id" :options="page.props.companies" optionLabel="name" optionValue="id"
                    placeholder="Selecione" class="w-full" filter :disabled="form.responsible" :class="{
                        'p-invalid': false
                    }" />
                <span v-if="form.errors.company_id" class="text-danger-600">
                    {{ form.errors.company_id }}
                </span>
            </div>
        </div>
        <div class="flex justify-end mt-2">
            <Button label="Salvar" type="submit" icon="fa-solid fa-save" iconPos="right" severity="success"
                :loading="form.processing" />
        </div>
    </form>
</template>
<script setup>
import { onMounted, ref } from 'vue';
import { router, useForm, usePage } from '@inertiajs/vue3';
import { useToast } from "primevue/usetoast";
const page = usePage();
const toast = useToast();
const form = useForm({
    company_id: page.props.user.company_id,
    name: page.props.user.name,
    email: page.props.user.email,
    password: '',
    password_confirmation: '',
    responsible: page.props.user.responsible,
});


function update() {
    form.transform((data) => ({
        ...data,
        id: page.props.user.id,
    })).patch(route('adm.user.update'));
}

function _alertGoControlResponsive(){
    toast.add({ severity: 'warn', summary: 'Atenção', detail: 'Para mudar responsável vá para controle de responsável', life: page.props.toast.time });
}
onMounted(() => {
});
</script>

