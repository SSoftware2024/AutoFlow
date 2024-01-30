<template>
    <!-- Usando TW-elements -->
    <div class="w-full mb-3">
        <label v-if="label" for="formFileDisabled" class="inline-block mb-2 text-neutral-700 dark:text-neutral-200">{{ label
        }}</label>
        <input @change="change"
            class="relative m-0 block w-full min-w-0 flex-auto rounded border border-solid border-neutral-300 bg-clip-padding px-3 py-[0.32rem] text-base font-normal text-neutral-700 transition duration-300 ease-in-out file:-mx-3 file:-my-[0.32rem] file:overflow-hidden file:rounded-none file:border-0 file:border-solid file:border-inherit file:bg-neutral-100 file:px-3 file:py-[0.32rem] file:text-neutral-700 file:transition file:duration-150 file:ease-in-out file:[border-inline-end-width:1px] file:[margin-inline-end:0.75rem] hover:file:bg-neutral-200 focus:border-primary focus:text-neutral-700 focus:shadow-te-primary focus:outline-none disabled:opacity-60 dark:border-neutral-600 dark:text-neutral-200 dark:file:bg-neutral-700 dark:file:text-neutral-100 dark:focus:border-primary"
            type="file" :disabled="disabled" :accept="accept" />
    </div>
</template>
<script setup>
import { ref, defineExpose } from 'vue';
import { useToast } from "primevue/usetoast";
import {usePage} from '@inertiajs/vue3';
const file = ref(null);
const toast = useToast();
const page = usePage();
const emits = defineEmits([
    'update:modelValue',
    'preview',
]);
const props = defineProps({
    modelValue: {
        type: [String, File],
        default: null,
    },
    label: {
        type: String,
        default: ''
    },
    disabled: {
        type: Boolean,
        default: false
    },
    containPreview: {
        type: Boolean,
        default: false
    },
    accept: {
        type: String,
        default: 'image/*'
    },
});

function change(event) {
    file.value = event.target.files[0];
    emits('update:modelValue', file.value);
    if(props.containPreview){
        _previewImage(event.target.files[0]);
    }
}
const deleteImage = () => {
    file.value = null
    emits('update:modelValue', null);
    emits('preview', null);
}


const _previewImage = (event) => {
    if (event.type.startsWith('image/')) {
        const reader = new FileReader();
        reader.onload = (e) => {
            emits('preview', e.target.result);
        };
        reader.readAsDataURL(file.value);
    } else {
        toast.add({ severity: 'warn', summary: 'Atenção', detail: 'Por favor, selecione um arquivo de imagem.', life: page.props.toast.time });
        file.value = null;
    }
}
defineExpose({ deleteImage });
</script>
