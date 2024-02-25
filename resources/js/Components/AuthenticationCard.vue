<template>
    <div class="flex flex-col items-center min-h-screen pt-6 bg-gray-100 dark:dark:bg-zinc-800 sm:justify-center sm:pt-0">
        <div>
            <slot name="logo" />
        </div>

        <div class="w-full px-6 py-4 mt-6 overflow-hidden bg-white shadow-md dark:bg-zinc-600 sm:max-w-md sm:rounded-lg">
            <slot />
        </div>
    </div>
</template>

<script setup>
import { onUnmounted } from 'vue';
import { router, usePage } from '@inertiajs/vue3';
import { alert } from '@/Src/Utils/functions';

const page = usePage();

function _listenCheckSweetAlert(element, index, callback) {
    if (index < element.length) {
        alert.alert(element[index].title, element[index].text, element[index].type, () => _listenCheckSweetAlert(element, index + 1, callback));
    } else {
        callback();
    }
}
function _showSweetAlert(flash_alert) {
    if (flash_alert) {
        _listenCheckSweetAlert(flash_alert, 0, () => {
            // Código a ser executado após todos os alertas serem exibidos
        });
    }
}

onUnmounted(
    router.on('finish', (event) => {
        _showSweetAlert(page.props.flash.alert_swal);
    })
)
</script>
