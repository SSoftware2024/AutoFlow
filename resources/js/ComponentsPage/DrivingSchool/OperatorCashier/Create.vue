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

        <div class="justify-end mt-2 row">
            <Button label="Cadastrar" type="submit" icon="fa-solid fa-plus" iconPos="right" severity="success"
                :loading="form.processing" />
        </div>
    </form>
</template>
<script setup>
import { ref } from 'vue';
import { useForm, router, usePage } from '@inertiajs/vue3';

const form = useForm({
    name: '',
    email: '',
    password: '',
    password_confirmation: '',
    //client_teacher
    wage: null,
    day_payment:1
});

function create() {
    form.post(route('user.driving_school.operator_cashier.create'), {
        onSuccess: () => {
            form.reset();
        }
    });
}
</script>
