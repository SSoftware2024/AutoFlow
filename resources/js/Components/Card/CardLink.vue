<template>
    <div class="flex justify-center flex-col items-center
        pt-2 pb-1 px-2 min-w-[200px]  my-1
        rounded-md cursor-pointer
        bg-[#e0e0e0] border border-[#cecece] transform
        dark:bg-transparent dark:border-white
        sm:mx-1"
        @click="toRoute">
        <h1>
            <i :class="`${props.icon} fa-5x`"></i>
        </h1>
        <h1 class="mt-2 text-4xl text-center">{{ props.title }}</h1>
    </div>
</template>
<script setup>
import { getCurrentInstance  } from 'vue'
const { appContext } = getCurrentInstance();

const props = defineProps({
    icon: String,
    title: String,
    url: String,
});

function toRoute() {
    appContext.config.globalProperties.$toRoute(props.url);
}
</script>
<style scoped  lang="scss">
.transform {
    transition: .3s;
    position: relative;
    &:hover {
        transform: scale(1.05);
        transition: all .3s;
        margin: 0 10px;
    }
}
</style>
