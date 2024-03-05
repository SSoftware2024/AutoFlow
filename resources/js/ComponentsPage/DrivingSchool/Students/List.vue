<template>
    <div>
        <div class="flex flex-col flex-wrap justify-center items-center
        sm:flex-row sm:justify-start">
            <CardProfile :title="value.name" :thumbmail="value.profile_photo_path ?? $page.props.images.user_profile"
                class="m-1" v-for="value in $page.props.students.data">
                <LinkDropdown title="Editar" icon="fa-solid fa-pen-to-square"
                    :href="route('user.driving_school.students.editView', [value.id])"></LinkDropdown>
                <LinkButtonDropdown title="Deletar" icon="fa-solid fa-trash-can" class="text-red-500" @click="questionDelete(value.id)"></LinkButtonDropdown>
            </CardProfile>
        </div>
        <div>
            <div>
                <Pagination :pagination="page.props.students" :onEachSize="3" @paginate="paginate" />
            </div>
        </div>
    </div>
</template>

<script setup>
import { router, usePage } from '@inertiajs/vue3';
import { alert } from '@/Src/Utils/functions.js';
//components
import CardProfile from '@/Components/Card/CardProfile.vue';
//end components

const page = usePage();

function paginate(page_link) {
    router.visit(page.url, {
        data: {
            page: page_link
        },
        preserveState: true
    });
}

function questionDelete(id) {
    alert.questionDeleteInvert(() => {
        router.delete(route('user.driving_school.students.delete', [id]));
    });
}
</script>
