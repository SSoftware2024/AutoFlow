<template>
    <div class="flex justify-center flex-col items-center
        pt-2 pb-1 min-w-[100px] max-w-[200px] my-1
        rounded-md cursor-pointer
        bg-[#e0e0e0] border border-[#cecece] transform
        sm:mx-1">
        <h1>
            <i class="fa-solid fa-store fa-5x"></i>
        </h1>
        <h1 class="mt-2 text-4xl text-center">Caixa Eletrônico</h1>
    </div>
</template>
<script setup>
</script>
<style scoped  lang="scss">
.transform {
    transition: .3s;
    position: relative;
    &:hover {
        transform: scale(1.1);
        transition: all .3s;
        margin: 0 15px;
    }
}
</style>
