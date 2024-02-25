<template>
    <!-- Usando TW-elements -->
    <div class="relative" data-te-dropdown-ref  data-te-dropdown-position="dropstart" >
        <button type="button" :id="id ?? 'dropdown'" data-te-dropdown-toggle-ref aria-expanded="false" data-te-ripple-init
            data-te-ripple-color="light">
            <slot name="icon"></slot>
            <i class="fa-solid fa-chevron-down" v-if="defaultIcon"></i>
        </button>
        <ul class="absolute z-[1000] float-left m-0 hidden min-w-max list-none overflow-hidden rounded-lg border-none bg-white bg-clip-padding text-left text-base shadow-lg dark:bg-neutral-700 [&[data-te-dropdown-show]]:block"
            :aria-labelledby="id ?? 'dropdown'" data-te-dropdown-menu-ref>

            <slot></slot>
        </ul>
    </div>
</template>
<script setup>
import { onMounted } from "vue";
import { Ripple, Dropdown, initTE } from "tw-elements";

defineProps({
    id: {
        type: String,
        required: true,
    },
    defaultIcon:{
        type: Boolean,
        default: false,
    }
});

onMounted(() => {
    initTE({ Dropdown, Ripple });
});
</script>
