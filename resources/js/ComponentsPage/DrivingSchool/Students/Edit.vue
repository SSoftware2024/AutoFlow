<template>
    <form @submit.prevent="save">
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
        <Fieldset legend="Habilitação" class="mb-3">
            <div class="row sm:space-x-1">
                <div class="row-col">
                    <label for="minmaxfraction" class="block">
                        Valor mensal
                        <sup><i class="fa-solid fa-asterisk fa-sm"></i></sup>
                    </label>
                    <InputNumber v-model="form.course_price" inputId="minmaxfraction" :minFractionDigits="2"
                        :maxFractionDigits="2" mode="currency" currency="BRL" :class="{
                            'p-invalid': form.errors.course_price
                        }" />
                    <span v-if="form.errors.course_price" class="text-danger-600">
                        {{ form.errors.course_price }}
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

            <!-- Responsavel -->
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
                            <Dropdown v-model="form.responsible_id" :options="responsible_list" optionLabel="name"
                                optionValue="code" placeholder="Nome ou código" editable class="w-full md:w-14rem"
                                @change="searchResponsible" />
                        </div>
                    </div>
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
            <Button label="Salvar" type="submit" icon="fa-solid fa-save" iconPos="right" severity="success"
                :loading="form.processing" />
        </div>
    </form>
</template>
<script setup>
import { onMounted, ref } from 'vue';
import { useForm, router, usePage } from '@inertiajs/vue3';
import { date_js } from '@/Src/Utils/functions.js';
const responsible_isRegistered = ref(false);
const responsible_list = ref(null);

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
    responsible_anonymous: page.props.client.value.responsible_anonymous,
    responsible_id: page.props.client.value.responsible_id,
    description: page.props.client.value.description,
    //client_student
    course_price: page.props.client.student.course_price,
    driving_wallet: page.props.client.student.driving_wallet
});

function searchResponsible(event) {
    axios({
        method: 'GET',
        url: route('user.driving_school.students.ax.getResponsibles'),
        params: {
            responsible: event.value
        }
    }).then((result) => {
        responsible_list.value = result.data;
    });
}


function save() {
    form.transform((data) => ({
        id: page.props.client.value.id,
        ...data
    })).put(route('user.driving_school.students.update'), {
        onSuccess: () => {
            form.reset('password','password_confirmation')
        }
    });
}

function _startFields() {
    if (page.props.client.value.responsible_id) {
        responsible_isRegistered.value = true;
        searchResponsible({ value: page.props.client.value.responsible_id });
    }
}

onMounted(() => {
    _startFields();
});
</script>
