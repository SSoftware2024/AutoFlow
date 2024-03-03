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
                <InputMask v-model="form.cpf" mask="999.999.999-99" placeholder="999.999.999-99" :class="{
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
                <InputMask v-model="form.cellphone" mask="(99) 9 9999-9999" placeholder="(99) 9 9999-9999" :class="{
                    'p-invalid': form.errors.cellphone
                }" />
                <span class="text-danger-500" v-if="form.errors.cellphone">{{ form.errors.cellphone }}</span>
            </div>
            <div class="row-col">
                <label>
                    Data de nascimento
                    <sup><i class="fa-solid fa-asterisk fa-sm"></i></sup>
                </label>
                <Calendar v-model="form.birth_date" dateFormat="dd/mm/yy" showIcon iconDisplay="input" :class="{
                    'p-invalid': form.errors.birth_date
                }" />
                <span class="text-danger-500" v-if="form.errors.birth_date">{{ form.errors.birth_date }}</span>
            </div>
        </div>
        <div class="row-lg sm:space-x-1 mt-2">
            <div class="row-col">
                <div class="flex align-items-center">
                    <Checkbox v-model="responsible_isRegistered" inputId="c1" :binary="true" />
                    <label for="c1" class="ml-2 cursor-pointer"> Responsável cadastrado </label>
                </div>
            </div>
        </div>
        <div>
            <div class="row-lg sm:space-x-1">
                <div class="row-col" v-if="!responsible_isRegistered">
                    <label>
                        Responsável
                    </label>
                    <InputText v-model="form.responsible_anonymous" :class="{
                        'p-invalid': form.errors.responsible_anonymous
                    }" />
                    <span class="text-danger-500" v-if="form.errors.responsible_anonymous">{{
                        form.errors.responsible_anonymous
                    }}</span>
                </div>
                <div class="row-col" v-else>
                    <label>Responsável</label>
                    <div class="card flex justify-center">
                        <Dropdown v-model="form.responsible_id" :options="model_plate_list" optionLabel="name" optionValue="code"
                            placeholder="Selecione o modelo" editable class="w-full md:w-14rem" />
                    </div>
                </div>
            </div>
        </div>
        <div class="row-lg sm:space-x-1 mt-2">
            <div class="row-col">
                <label for="">Descrição</label>
                <Textarea v-model="form.description" rows="5" cols="30" />
            </div>
        </div>
        <div class="justify-end mt-2 row">
            <Button label="Cadastrar" type="submit" icon="fa-solid fa-plus" iconPos="right" severity="success"
                :loading="form.processing" />
        </div>
    </form>
</template>
<script setup>
import { ref } from 'vue';
import { useForm, router, usePage } from '@inertiajs/vue3';

const responsible_isRegistered = ref(false);
const model_plate_list = ref([
    { name: 'ANTIGO - 1990: AAA-9999', code: 0 },
    { name: 'NOVO - 2018: AAA9A99', code: 1 },
]);

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
    cellphone: '',
    birth_date: null,
    responsible_anonymous: '',
    responsible_id: null,
    description: ''
});

function create() {
    form.post(route('user.driving_school.students.create'), {
        onSuccess: () => {
            form.reset();
        }
    });
}
</script>
