<template></template>

<script setup>
import { onMounted } from 'vue';
import { usePage } from '@inertiajs/vue3';
import { emitter } from '@/Src/Utils/globalEvents';
import { alert } from '@/Src/Utils/functions.js';

const page = usePage();
onMounted(() => {
    emitter.on('sw-alert-generic-question', (callback) => {
        if (page.props.flash.alert_swal?.question.type == 'delete_question') {
            alert[page.props.flash.alert_swal.question.type](page.props.flash.alert_swal.question.title, page.props.flash.alert_swal.question.text, callback);
        }
    });
})
</script>
