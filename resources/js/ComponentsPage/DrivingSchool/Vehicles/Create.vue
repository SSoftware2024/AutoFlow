<template>
    <form @submit.prevent="create">
        <div class="row sm:space-x-1">
            <div class="row-col">
                <label>Modelo Carro</label>
                <InputText v-model="form.surname" id="username" :class="{
                    'p-invalid': form.errors.surname
                }" />
                <span class="text-danger-500" v-if="form.errors.surname">{{ form.errors.surname }}</span>
            </div>
            <div class="row-col">
                <label>Categoria</label>
                <div class="card flex justify-center">
                    <Dropdown v-model="form.category" display="chip" :options="$page.props.driving_wallet"
                        optionLabel="name" optionValue="code" placeholder="Selecione" class="w-full md:w-20rem" :class="{
                            'p-invalid': form.errors.category
                        }" />
                </div>
                <span class="text-danger-500" v-if="form.errors.category">{{ form.errors.category }}</span>
            </div>
        </div>
        <div class="row sm:space-x-1">
            <div class="row-col">
                <label>Placa</label>
                <InputMask id="cnpj" v-model="form.plate" :mask="changeMask" :placeholder="changeMask" :class="{
                    'p-invalid': form.errors.plate
                }" :pt="{ root: 'uppercase' }" />
                <span class="text-danger-500" v-if="form.errors.plate">{{ form.errors.plate }}</span>
            </div>
            <div class="row-col">
                <label>Modelo Placa</label>
                <div class="card flex justify-center">
                    <Dropdown v-model="model_plate" :options="model_plate_list" optionLabel="name" optionValue="code"
                        placeholder="Selecione o modelo" class="w-full md:w-14rem" />
                </div>
            </div>
        </div>
        <div class="row sm:space-x-1">
            <div class="row-col">
                <label>IPVA data</label>
                <Calendar v-model="form.ipva_generate" dateFormat="dd/mm" showIcon iconDisplay="input" :class="{
                    'p-invalid': form.errors.ipva_generate
                }" />
                <span class="text-danger-500" v-if="form.errors.ipva_generate">{{ form.errors.ipva_generate }}</span>
            </div>
            <div class="row-col">
                <label>IPVA valor</label>
                <InputNumber v-model="form.ipva_value" inputId="minmaxfraction" :minFractionDigits="2"
                    :maxFractionDigits="2" mode="currency" currency="BRL" :class="{
                        'p-invalid': form.errors.ipva_value
                    }" />
                <span class="text-danger-500" v-if="form.errors.ipva_value">{{ form.errors.ipva_value }}</span>
            </div>
        </div>
        <div class="justify-end mt-2 row">
            <Button label="Cadastrar" type="submit" icon="fa-solid fa-plus" iconPos="right" severity="success"
                :loading="form.processing" />
        </div>
    </form>
</template>
<script setup>
import { ref, computed } from "vue";
import { useForm } from '@inertiajs/vue3';

const form = useForm({
    surname: '',
    plate: '',
    category: '',
    ipva_value: null,
    ipva_generate: null //data ipva
});

const model_plate = ref(0);
const model_plate_list = ref([
    { name: 'ANTIGO - 1990: AAA-9999', code: 0 },
    { name: 'NOVO - 2018: AAA9A99', code: 1 },
]);


const changeMask = computed({
    get() {
        if (model_plate.value == 0) {
            return 'aaa-9999';
        } else {
            return 'aaa9a99';
        }
    },
});


function create() {
    form.post(route('user.driving_school.vehicles.create'), {
        onSuccess: () => {
            form.reset();
        }
    });
}
</script>
