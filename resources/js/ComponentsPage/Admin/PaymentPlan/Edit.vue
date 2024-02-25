<template>
    <form @submit.prevent="create">
        <div class="flex flex-col sm:space-x-3 sm:flex-row">
            <div class="flex flex-col w-full">
                <label for="username">Título</label>
                <InputText id="username" v-model="form.title" :class="{
                    'p-invalid': form.errors.title
                }" />
                <span v-if="form.errors.title" class="text-danger-600">
                    {{ form.errors.title }}
                </span>
            </div>
            <div class="flex flex-col w-full">
                <label for="minmaxfraction" class="block"> Valor mensal </label>
                <InputNumber v-model="form.money" inputId="minmaxfraction" :minFractionDigits="2" :maxFractionDigits="2"
                    mode="currency" currency="BRL" :class="{
                        'p-invalid': form.errors.money
                    }" />
                <span v-if="form.errors.money" class="text-danger-600">
                    {{ form.errors.money }}
                </span>
            </div>
        </div>
        <div class="mt-5">
            <Fieldset legend="Permissões">
                <div class="flex flex-wrap">
                    <div class="border border-gray-400 p-2 min-w-[300px]">
                        <h3 class="text-center">Agendamento</h3>
                        <div v-for="(value, key, index) in form.permissions.schedulling">
                            <div>
                                <Checkbox v-model="value.value" :binary="true" :inputId="`a${index}`"/>
                                <label :for="`a${index}`" class="ml-1 cursor-pointer">{{ value.name }}</label>
                            </div>
                        </div>
                    </div>
                    <div class="border border-gray-400 p-2 min-w-[300px]">
                        <h3 class="text-center">Vendas</h3>
                        <div v-for="(value, key, index) in form.permissions.sale">
                            <div>
                                <Checkbox v-model="value.value" :binary="true" :inputId="`b${index}`"/>
                                <label :for="`b${index}`" class="ml-1 cursor-pointer">{{ value.name }}</label>
                            </div>
                        </div>
                    </div>
                </div>
            </Fieldset>
        </div>
        <div class="flex justify-end mt-2">
            <Button label="Salvar" type="submit" icon="fa-solid fa-save" iconPos="right" severity="success"
                :loading="form.processing" />
        </div>
    </form>
</template>
<script setup>
import { onMounted, inject } from 'vue';
import { useForm, usePage } from '@inertiajs/vue3';
import { useToast } from "primevue/usetoast";
const alert = inject('Swal');
const toast = useToast();
const page = usePage();
const form = useForm({
    title: page.props.payment_plan.title,
    money: page.props.payment_plan.price,
    permissions:page.props.payment_plan.permissions
});

function create() {
    form.transform(data => ({
        ...data,
        id: page.props.payment_plan.id,
    }))
        .put(route('payment_plan.update'), {
            onSuccess: () => {
                toast.add({ severity: 'success', summary: 'Sucesso', detail: 'Atualização salva com sucesso', life: page.props.toast.time });
            },
        });

}

onMounted(() => {

});
</script>
