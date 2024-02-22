<template>
    <div>
        <Panel header="Controle de responsável">
            <form>
                <div class="row">
                    <div class="row-col">
                        <label for=""></label>
                        <Dropdown v-model="form.company_id" :options="page.props.companies" optionLabel="name"
                            optionValue="id" placeholder="Selecione" class="w-full" filter @change="changeCompany" />
                        <span v-if="form.errors.company_id" class="text-danger-600">
                            {{ form.errors.company_id }}
                        </span>
                    </div>
                </div>
                <div class="mt-2 row">
                    <h4 class="font-bold">Usuário responsável:
                        <span class="text-danger-500" v-if="form.company_id && !page.props.user_responsible">Sem
                            responsável</span>
                        <span class="text-success-500" v-else>
                            {{ page.props.user_responsible?.name }}
                        </span>
                    </h4>
                </div>
            </form>

            <div class="mt-2">
                <Fieldset legend="Integrantes">
                    <div v-if="page.props.users_company?.length">
                        <form @submit.prevent="save">
                            <div v-for="value in page.props.users_company" :key="value.id" class="flex align-items-center">
                                <RadioButton v-model="form_newResponsible.new_responsible" :inputId="value.id+''"
                                    name="new_responsible" :value="value.id" />
                                <label :for="value.id" class="ml-2">{{ value.name }}</label>
                            </div>
                            <div class="flex flex-col items-start justify-start mt-2 space-y-1">
                                <Button label="Tornar responsavel" type="submit" icon="fa-solid fa-wand-magic-sparkles" iconPos="right"
                                    severity="success" :loading="form_newResponsible.processing" />
                                <Button label="Cancelar" type="button" icon="fa-solid  fa-close" iconPos="right"
                                    severity="danger" @click="cancel"/>
                            </div>
                        </form>
                    </div>
                    <h4 v-else>Nenhum usuário cadastrado</h4>
                </Fieldset>

            </div>
        </Panel>
    </div>
</template>
<script setup>
import { reactive } from 'vue';
import { useForm, usePage, router } from '@inertiajs/vue3';
const page = usePage();
const load = reactive({
    change_company: false
});
const form = useForm({
    company_id: page.props.company?.id ?? 0,
});

const form_newResponsible = useForm({
    new_responsible: 0
});

function changeCompany() {
    router.visit(route('adm.company.listResponsibleView', { company: form.company_id }), {
        preserveState: true,
    })
}

function save() {
    form_newResponsible
    .transform((data) => ({
        ...data,
        old_responsible: page.props.user_responsible?.id,
    }))
    .post(route('adm.company.newResponsible'))
}

function cancel() {
    form_newResponsible.new_responsible = 0
}
</script>
