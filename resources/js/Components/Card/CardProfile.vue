<template>
    <div class="relative flex flex-col justify-center items-center box-border
        border border-gray-500 w-[230px] h-[200px] max-h-[300px]">
        <div class="absolute top-[2px] right-[12px]">
            <cs-dropdown id="optionsStudent">
                <template #icon>
                    <i class="fa-solid fa-ellipsis-vertical fa-lg"></i>
                </template>
                <slot></slot>
            </cs-dropdown>
        </div>
        <div>
            <img :src="thumbmail" alt="" class="w-[150px] rounded-full">
        </div>
        <div>
            <h1 class="text-xl font-bold text-center">{{ title }}</h1>
        </div>
    </div>
</template>
<script setup>

defineProps({
    thumbmail:{
        type:String,
        required:true
    },
    title:{
        type:String,
        required:true
    }
});
</script>
