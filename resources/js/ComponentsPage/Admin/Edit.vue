<template>
    <div>
        <form @submit.prevent="save">
            <div class="sm:space-x-1 row">
                <div class="row-col">
                    <label>Nome:</label>
                    <InputText v-model="form.name" id="username" :class="{
                        'p-invalid': form.errors.name
                    }" />
                    <span v-if="form.errors.name" class="text-danger-600">
                        {{ form.errors.name }}
                    </span>
                </div>
                <div class="row-col">
                    <label>Email:</label>
                    <InputText v-model="form.email" :class="{
                        'p-invalid': form.errors.email
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
                        'p-invalid': form.errors.password
                    }" />
                    <span v-if="form.errors.password" class="text-danger-600">
                        {{ form.errors.password }}
                    </span>
                </div>
                <div class="row-col">
                    <label>Confirmar senha:</label>
                    <Password v-model="form.password_confirmation" :feedback="false" toggleMask :class="{
                        'p-invalid': form.errors.password_confirmation
                    }" />
                    <span v-if="form.errors.password_confirmation" class="text-danger-600">
                        {{ form.errors.password_confirmation }}
                    </span>
                </div>
            </div>
            <div class="row">
                <div class="row-col">
                    <label>Nível de acesso:</label>
                    <Dropdown v-model="form.level_access" :options="options_level" optionLabel="name" optionValue="value"
                        placeholder="Selecione" class="w-full md:w-14rem" :invalid="!!form.errors.level_access" />
                    <span v-if="form.errors.level_access" class="text-danger-600">
                        {{ form.errors.level_access }}
                    </span>
                </div>
            </div>
            <div class="flex justify-end mt-2">
                <Button label="Salvar" type="submit" icon="fa-solid fa-save" iconPos="right" severity="success"
                    :loading="form.processing" />
            </div>
        </form>
    </div>
</template>

<script setup>
import { ref } from "vue";
import { useForm, usePage } from '@inertiajs/vue3';
const page = usePage();
const form = useForm({
    name: page.props.administrator.name,
    email: page.props.administrator.email,
    level_access: page.props.administrator.level_access,
    password: '',
    password_confirmation: '',
});
const options_level = ref([
    { name: 'PRIMÁRIO', value: page.props.level_access_admin.FIRST },
    { name: 'SECUNDÁRIO', value: page.props.level_access_admin.SECOND },
]);

function save() {
    form.transform((data) => ({
        ...data,
        id: page.props.administrator.id
    })).put(route('admin.update'), {
        onSuccess: () => {
            form.reset('password','password_confirmation');
        }
    });
}
</script>
