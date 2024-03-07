<template>
    <form @submit.prevent="create">
        <Fieldset legend="Login" class="mb-3">
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
                    <span class="text-danger-500" v-if="form.errors.password_confirmation">{{
                        form.errors.password_confirmation
                    }}</span>
                </div>
            </div>
        </Fieldset>
        <Fieldset legend="Dados do funcionário" class="mb-3">
            <div class="row sm:space-x-1">
                <div class="row-col">
                    <label for="minmaxfraction" class="block">
                        Salário mensal
                        <sup><i class="fa-solid fa-asterisk fa-sm"></i></sup>
                    </label>
                    <InputNumber v-model="form.wage" inputId="minmaxfraction" :minFractionDigits="2"
                        :maxFractionDigits="2" mode="currency" currency="BRL" :class="{
                            'p-invalid': form.errors.wage
                        }" />
                    <span v-if="form.errors.wage" class="text-danger-600">
                        {{ form.errors.wage }}
                    </span>
                </div>
                <div class="row-col">
                    <label for="minmaxfraction" class="block">
                        Carteira de habilitação
                        <sup><i class="fa-solid fa-asterisk fa-sm"></i></sup>
                    </label>
                    <MultiSelect v-model="form.driving_wallet" :options="$page.props.driving_wallet_options"
                        optionLabel="name" placeholder="Selecione" :maxSelectedLabels="3"
                        selectedItemsLabel="{0} itens selecionados" display="chip" class="w-full md:w-20rem" :class="{
                            'p-invalid': form.errors.driving_wallet
                        }" />
                    <span v-if="form.errors.driving_wallet" class="text-danger-600">
                        {{ form.errors.driving_wallet }}
                    </span>
                    <span v-for="(error, key) in form.errors" v-if="form.errors" class="text-danger-600">
                        <span v-if="key.startsWith('driving_wallet.')">
                            {{ error }}
                        </span>
                    </span>
                </div>
            </div>
            <div class="row sm:space-x-1">
                <div class="row-col">
                    <label for="minmaxfraction" class="block">
                        Dia do pagamento
                        <sup><i class="fa-solid fa-asterisk fa-sm"></i></sup>
                    </label>
                    <InputNumber v-model="form.day_payment" inputId="day_pament" :min="1" :max="31" showButtons :class="{
                            'p-invalid': form.errors.day_payment
                        }" />
                    <span v-if="form.errors.day_payment" class="text-danger-600">
                        {{ form.errors.day_payment }}
                    </span>
                </div>
            </div>
        </Fieldset>
        <Fieldset legend="Dados pessoais">
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

            <!-- Descrição -->
            <div class="row-lg sm:space-x-1 mt-2">
                <div class="row-col">
                    <label for="">Descrição</label>
                    <Textarea v-model="form.description" rows="5" cols="30" />
                </div>
            </div>
        </Fieldset>

        <div class="justify-end mt-2 row">
            <Button label="Cadastrar" type="submit" icon="fa-solid fa-plus" iconPos="right" severity="success"
                :loading="form.processing" />
        </div>
    </form>
</template>
<script setup>
import { ref } from 'vue';
import { useForm, router, usePage } from '@inertiajs/vue3';
import { date_js } from '@/Src/Utils/functions.js';
const page = usePage();

const form = useForm({
    name: page.props.client.value.name,
    email: page.props.client.value.email,
    password: '',
    password_confirmation: '',
    cpf: page.props.client.value.cpf,
    rg: page.props.client.value.rg,
    street: page.props.client.value.street,
    neighborhood: page.props.client.value.neighborhood,
    number_house: page.props.client.value.number_house,
    cellphone: page.props.client.value.cellphone,
    birth_date: date_js.format_date(page.props.client.value.birth_date),
    description: page.props.client.value.description,
    //client_teacher
    wage: page.props.client.teacher.wage,
    driving_wallet: page.props.client.teacher.driving_wallet,
    day_payment:page.props.client.teacher.day_payment
});

function create() {
    // form.post(route('user.driving_school.teacher.update'), {
    //     onSuccess: () => {
    //         form.reset();
    //     }
    // });
}
</script>
