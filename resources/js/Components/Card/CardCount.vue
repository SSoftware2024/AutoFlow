<template>
    <div :class='["flex justify-center flex-row",
        "min-w-[200px] max-w-[320px] my-1",
        "rounded-md border border-[#cecece] transform",
        props.link ? "cursor-pointer":"",  props.count ? "pt-2 pb-1 px-2":"pt-4 pb-3 px-4",
        "dark:bg-transparent dark:border-white",
        "sm:mx-1"]' @click="toRoute">
        <div>
            <h1 class="relative top-[5px] text-5xl">
                <i :class="props.icon"></i>
            </h1>
        </div>
        <div class="ml-2">
            <h2 class="text-center text-4xl">{{ props.count }}</h2>
            <h2 :class='["font-bold", props.count ? "":"relative top-[12px]"]'>{{ props.title }}</h2>
        </div>
    </div>
</template>
<script setup>
import { getCurrentInstance, onMounted  } from 'vue'
const { appContext } = getCurrentInstance();
const instance = getCurrentInstance();
const props = defineProps({
    title: String,
    icon: String,
    count: [Number, String],
    link: {
        type: Boolean,
        default: false
    },
    url: {
        type: String,
        default: ''
    }
});

function toRoute() {
    if(props.link && props.url){
        appContext.config.globalProperties.$toRoute(props.url);
    }
}
function _valdiateComponent() {
    if(props.link && props.url == ''){
        console.warn(`Props 'links' is true, but 'url' value not found!`,instance.proxy.$el);
    }
}
onMounted(() => {
    _valdiateComponent();
});
</script>
<style scoped lang="scss"></style>
