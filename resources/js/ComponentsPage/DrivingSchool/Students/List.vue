<template>
    <div>
        <div class="flex flex-col flex-wrap justify-center items-center
        sm:flex-row sm:justify-start">
            <CardProfile :title="value.name" :thumbmail="value.profile_photo_path ?? $page.props.images.user_profile"
                class="m-1" v-for="value in $page.props.students.data">
                <LinkDropdown title="Editar"></LinkDropdown>
                <LinkDropdown title="Deletar" icon="fa-solid fa-trash"></LinkDropdown>
                <LinkDropdown title="Ver"></LinkDropdown>
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
import {router, usePage } from '@inertiajs/vue3';

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
</script>
