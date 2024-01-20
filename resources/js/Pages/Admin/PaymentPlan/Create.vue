<template>
    <AppLayout title="Plano Pagamento" title_page="Novo plano de pagamento">
        <template #center>
            <Panel header="Cadastro">
                <form @submit.prevent="create">
                    <div class="flex flex-col sm:space-x-3 sm:flex-row">
                        <div class="flex flex-col w-full">
                            <label for="username">Nome</label>
                            <InputText id="username" v-model="form.title"/>
                            {{ form.errors.title }}
                        </div>
                        <div class="flex flex-col w-full">
                            <label for="minmaxfraction" class="block"> Valor mensal </label>
                            <InputNumber v-model="form.money" inputId="minmaxfraction" :minFractionDigits="2"
                                :maxFractionDigits="2" mode="currency" currency="BRL" />
                        </div>
                    </div>
                    <div class="flex justify-end mt-2">
                        <Button label="Cadastrar" type="submit" icon="fa-solid fa-plus" iconPos="right"
                            severity="success" />
                    </div>
                </form>
            </Panel>
        </template>
    </AppLayout>
</template>
<script setup>
import { ref, onMounted, inject  } from 'vue';
import { useForm } from '@inertiajs/vue3';
const alert = inject('Swal');

const form = useForm({
    title: '',
    money: 0
});

function create() {
    form.post(route('payment_plan.create'));
}

onMounted(() => {

});
</script>
