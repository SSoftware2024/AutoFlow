<script setup>
import { computed } from 'vue';
import { Head, Link, useForm } from '@inertiajs/vue3';
import AuthenticationCard from '@/Components/AuthenticationCard.vue';
import AuthenticationCardLogo from '@/Components/AuthenticationCardLogo.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';

const props = defineProps({
    status: String,
});

const form = useForm({});

const submit = () => {
    form.post(route('verification.send'));
};

const verificationLinkSent = computed(() => props.status === 'verification-link-sent');
</script>

<template>
    <Head title="Email Verficação" />

    <AuthenticationCard>
        <template #logo>
            <AuthenticationCardLogo />
        </template>

        <div class="mb-4 text-sm text-gray-600 dark:text-neutral-50">
            Antes de continuar, você poderia verificar seu endereço de e -mail clicando no link que acabamos de enviar por e
            -mail para você? Se você não recebeu o e -mail, teremos o prazer de enviar outro.
        </div>

        <div v-if="verificationLinkSent" class="mb-4 text-sm font-medium text-green-600">
            Um novo link de verificação foi enviado para o endereço de e -mail que você forneceu nas configurações do seu
            perfil.
        </div>

        <form @submit.prevent="submit">
            <div class="flex items-center justify-between mt-4">
                <PrimaryButton :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                    Reenviar email de verificação
                </PrimaryButton>

                <div>
                    <Link :href="route('profile.show')"
                        class="text-sm text-gray-600 underline rounded-md dark:text-neutral-50 hover:text-gray-900 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    Editar Perfil</Link>

                    <Link :href="route('logout')" method="post" as="button"
                        class="text-sm text-gray-600 underline rounded-md dark:text-neutral-50 hover:text-gray-900 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 ms-2">
                    Sair
                    </Link>
                </div>
            </div>
        </form>
    </AuthenticationCard>
</template>
