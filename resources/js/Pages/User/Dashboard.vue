<template>
    <AppLayout title="Dashboard">
        <Fieldset legend="Sistemas">
            <div class="flex flex-wrap justify-center sm:justify-start">
                <CardLink icon="fa-solid fa-cash-register" title="PDV" url="teste"></CardLink>
                <CardLink icon="fa-solid fa-store" title="ERP" url="teste"></CardLink>
                <CardLink icon="fa-solid fa-money-bill-1" title="Financeiro" url="teste"></CardLink>
                <CardLink icon="fa-solid fa-calendar-days" title="Agendamentos" url="teste"></CardLink>
                <CardLink icon="fa-solid fa-car" title="Auto Escola" url="teste"></CardLink>
            </div>
        </Fieldset>
        <div class="mt-3">
            <Fieldset legend="Seu grupo/Empresa">
                <div>
                    <ul>
                        <li class="mb-1">
                            Ativa:
                            <span :class="['text-white p-1',
                                page.props.company.active ? 'bg-green-900' : 'bg-red-900'
                            ]">
                                {{ page.props.company.active ? 'SIM' : 'Não' }}
                            </span>
                        </li>
                        <li>
                            Plano Atual:
                            <span class="font-bold">{{ page.props.payment_plan.title }}</span>
                        </li>
                        <li>CÓD:
                            <span class="font-bold">{{ page.props.company.id }}</span>
                        </li>
                        <li>Nome:
                            <span class="font-bold">{{ page.props.company.name }}</span>
                        </li>
                        <li>Integrantes(TOTAL):
                            <span class="font-bold">{{ page.props.users_members_count }}</span>
                        </li>
                        <li>Funcionários(TOTAL): </li>
                        <li>Responsável:
                            <span class="font-bold">{{ page.props.user_responsible_name }}</span>
                        </li>
                    </ul>
                </div>
            </Fieldset>
        </div>
    </AppLayout>
</template>
<script setup>
import { usePage } from '@inertiajs/vue3';
//components
import CardLink from '@/Components/Card/CardLink.vue';
//fim components

const page = usePage();
</script>
