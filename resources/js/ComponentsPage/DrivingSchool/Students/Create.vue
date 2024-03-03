<template>
    <form @submit.prevent="create">
        <div class="row sm:space-x-1">
            <div class="row-col">
                <label>
                    Nome
                    <sup><i class="fa-solid fa-asterisk fa-sm"></i></sup>
                </label>
                <InputText v-model="form.name" id="username" :class="{
                    'p-invalid': form.errors.name
                }" />
                <span class="text-danger-500" v-if="form.errors.name">{{ form.errors.name }}</span>
            </div>
            <div class="row-col">
                <label>
                    Email
                    <sup><i class="fa-solid fa-asterisk fa-sm"></i></sup>
                </label>
                <InputText v-model="form.email" id="email" :class="{
                    'p-invalid': form.errors.email
                }" />
                <span class="text-danger-500" v-if="form.errors.email">{{ form.errors.email }}</span>
            </div>
        </div>
        <div class="row sm:space-x-1">
            <div class="row-col">
                <label>
                    Senha
                    <sup><i class="fa-solid fa-asterisk fa-sm"></i></sup>
                </label>
                <Password v-model="form.password" :feedback="false" :class="{
                    'p-invalid': form.errors.password
                }" />
                <span class="text-danger-500" v-if="form.errors.password">{{ form.errors.password }}</span>
            </div>
            <div class="row-col">
                <label>
                    Confirmar senha
                    <sup><i class="fa-solid fa-asterisk fa-sm"></i></sup>
                </label>
                <Password v-model="form.password_confirmation" :feedback="false" :class="{
                    'p-invalid': form.errors.password_confirmation
                }" />
                <span class="text-danger-500" v-if="form.errors.password_confirmation">{{ form.errors.password_confirmation
                }}</span>
            </div>
        </div>
        <div class="row sm:space-x-1">
            <div class="row-col">
                <label>
                    CPF
                    <sup><i class="fa-solid fa-asterisk fa-sm"></i></sup>
                </label>
                <InputMask  v-model="form.cpf" mask="999.999.999-99" placeholder="999.999.999-99" :class="{
                    'p-invalid': form.errors.cpf
                }" />
                <span class="text-danger-500" v-if="form.errors.cpf">{{ form.errors.cpf }}</span>
            </div>
            <div class="row-col">
                <label>
                    RG
                    <sup><i class="fa-solid fa-asterisk fa-sm"></i></sup>
                </label>
                <InputText v-model="form.rg" :class="{
                    'p-invalid': form.errors.rg
                }" />
                <span class="text-danger-500" v-if="form.errors.rg">{{ form.errors.rg }}</span>
            </div>
        </div>
        <div class="row sm:space-x-1">
            <div class="row-col">
                <label>
                    Rua
                </label>
                <InputText v-model="form.street" :class="{
                    'p-invalid': form.errors.street
                }" />
                <span class="text-danger-500" v-if="form.errors.street">{{ form.errors.street }}</span>
            </div>
            <div class="row-col">
                <label>
                    Bairro
                </label>
                <InputText v-model="form.neighborhood" :class="{
                    'p-invalid': form.errors.neighborhood
                }" />
                <span class="text-danger-500" v-if="form.errors.neighborhood">{{ form.errors.neighborhood }}</span>
            </div>
        </div>
        <div class="row-lg sm:space-x-1">
            <div class="row-col">
                <label>
                    Número(casa)
                </label>
                <InputText v-model="form.number_house" :class="{
                    'p-invalid': form.errors.number_house
                }" />
                <span class="text-danger-500" v-if="form.errors.number_house">{{ form.errors.number_house }}</span>
            </div>
            <div class="row-col">
                <label>
                    Celular
                </label>
                <InputText v-model="form.cellphone" :class="{
                    'p-invalid': form.errors.cellphone
                }" />
                <span class="text-danger-500" v-if="form.errors.cellphone">{{ form.errors.cellphone }}</span>
            </div>
            <div class="row-col">
                <label>
                    Data de nascimento
                </label>
                <Calendar v-model="form.birth_date" dateFormat="dd/mm/yy" showIcon iconDisplay="input" :class="{
                    'p-invalid': form.errors.birth_date
                }" />
                <span class="text-danger-500" v-if="form.errors.birth_date">{{ form.errors.birth_date }}</span>
            </div>
        </div>
        <div class="justify-end mt-2 row">
            <Button label="Cadastrar" type="submit" icon="fa-solid fa-plus" iconPos="right" severity="success"
                :loading="form.processing" />
        </div>
    </form>
</template>
<script setup>
import { useForm, router, usePage } from '@inertiajs/vue3';

const form = useForm({
    name: '',
    email: '',
    password: '',
    password_confirmation: '',
    cpf: '',
    rg: '',
    street: '',
    neighborhood: '',
    number_house: '',
    cellphone:'',
    birth_date: null
});

function create(){
    form.post(route('user.driving_school.students.create'));
}
</script>
