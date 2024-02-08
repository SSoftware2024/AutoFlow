<template>
    <!-- Usando TW-elements -->
    <Link
        class="block w-full px-8 py-2 text-sm font-normal bg-transparent whitespace-nowrap text-neutral-700 hover:bg-neutral-100 active:text-neutral-800 active:no-underline disabled:pointer-events-none disabled:bg-transparent disabled:text-neutral-400 dark:text-neutral-200 dark:hover:bg-neutral-600"
        :href="href" data-te-dropdown-item-ref>
    <i :class="icon"></i>
    {{ title }}
    </Link>
</template>
<script setup>
defineProps({
    title: {
        type: String,
        required: true,
    },
    href: {
        type: String,
        default: '#'
    },
    icon: {
        type: String,
        default:'',
    },
});
</script>
