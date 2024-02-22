<template>
    <div class="navbar">
        <div class="menu-hamburger">
            <i :class="[icon]" @click="$emit('click:icon')"></i>
        </div>
        <div class="options">
            <slot></slot>
        </div>

    </div>
</template>

<script setup>
defineProps({
    icon: {
        type: String,
        required: true,
    },
});


const emit = defineEmits(['click:icon']);
</script>
<style scoped lang="scss"></style>
