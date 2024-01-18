<template>
    <div class="absolute z-50 w-[300px] bg-white border-2 border-gray-500 shadow-3 px-3 py-1 animate__animated animate__faster
    overflow-y-auto max-h-[100%] dark:bg-black" id="sidebar" :class="{
        'animate__zoomIn': isOpen,
        'animate__zoomOutLeft': !isOpen,
    }">
        <PanelMenu :model="links" class="mt-5" :pt="{
            root: { class: '' },
            header: { class: 'border-none bg-transparent' },
            headerContent: { class: 'border-none bg-transparent' },
            headerAction: { class: 'border-none bg-transparent dark:text-neutral-50' },
            toggleableContent: { class: 'border-none bg-gray-100 dark:bg-zinc-900 rounded-md' },
            menuContent: { class: 'border-none bg-transparent' },
            action: { class: 'hover:bg-gray-200 dark:hover:bg-zinc-600' },
            icon: { class: 'dark:text-neutral-50' },
            label: { class: 'dark:text-neutral-50' },
        }">
        </PanelMenu>
        <div class="absolute top-[2px] right-[2px]" @click="$emit('click:close')">
            <i class="text-4xl text-red-600 cursor-pointer fa-solid fa-circle-xmark"></i>
        </div>
    </div>
</template>
<script setup>
import { ref, watch } from 'vue';
const props = defineProps({
    links: {
        type: [Array, Object],
        required: true
    },
    isOpen: {
        type: Boolean,
        default: false
    },
});
defineEmits(['click:close']);

</script>
<style scoped lang="scss"></style>
