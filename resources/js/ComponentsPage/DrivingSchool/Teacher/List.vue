<template>
    <div>
        <!-- Filtros -->
        <div class="flex flex-col mb-3 sm:flex-row">
            <InputText v-model="search_data.value" class="mr-2" placeholder="Código ou nome" @keyup.enter="search" />
            <Button icon="pi pi-search" severity="info" :loading="loads.filter" :pt="{
                root: 'w-full mt-2 sm:w-[3rem] sm:mt-0'
            }" v-tooltip.top="'Buscar'" @click="search" />
        </div>
        <!-- FIM FILTROS -->

        <div class="flex flex-col flex-wrap justify-center items-center
        sm:flex-row sm:justify-start">
            <CardProfile :title="value.name" :thumbmail="value.profile_photo_path ?? $page.props.images.user_profile"
                class="m-1" v-for="value in $page.props.teachers.data">
                <LinkDropdown title="Editar" icon="fa-solid fa-pen-to-square"
                    :href="route('user.driving_school.teacher.editView', [value.id])"></LinkDropdown>
                <LinkButtonDropdown title="Deletar" icon="fa-solid fa-trash-can" class="text-red-500"
                    @click="questionDelete(value.id)"></LinkButtonDropdown>
            </CardProfile>
        </div>
        <div>
            <div>
                <Pagination :pagination="page.props.teachers" :onEachSize="3" @paginate="paginate" />
            </div>
        </div>
    </div>
</template>

<script setup>
import { reactive, ref } from 'vue';
import { router, usePage } from '@inertiajs/vue3';
import { alert } from '@/Src/Utils/functions.js';
//components
import CardProfile from '@/Components/Card/CardProfile.vue';
//end components

const page = usePage();
const search_data = reactive({
    value: ''
});
const loads = reactive({
    filter: false
});
function paginate(page_link) {
    router.get(page.url, {
        page: page_link
    }, {
        preserveState: true
    });
}

function search() {
    loads.filter = true;
    router.get(page.url, {
        filter: search_data
    }, {
        only: ['teachers'],
        preserveState: true,
        onFinish: () => loads.filter = false,
    });
}

function questionDelete(id) {
    alert.questionDeleteInvert(() => {
        // router.delete(route('user.driving_school.teachers.delete', [id]));
    });
}
</script>
