import { router } from '@inertiajs/vue3';
let common = [
    {
        label: 'Dashboard',
        icon: 'fa-solid fa-gauge',
        command: () => {
            router.get('/dashboard');
        }
    },

];
let web_responsible = [
    {
        label: 'Integrantes',
        icon: 'fa-solid fa-users',
    },
];
let web = [
    {
        label: 'Financeiro',
        icon: 'fa-solid fa-money-bill-1',
        items: [
            {
                label: 'Dashboard',
                icon: 'fa-solid fa-gauge',
                command: () => {

                }
            },
            {
                label: 'Fazer links',
                icon: 'fa-solid fa-user',
                items: [
                    {
                        label: 'Novo',
                        icon: 'fa-solid fa-user-plus',
                        command: () => null
                    },
                    {
                        label: 'Lista',
                        icon: 'fa-solid fa-list',
                        command: () => null
                    },
                ]
            }
        ]
    },
    {
        label: 'ERP',
        icon: 'fa-solid fa-store',
        items: [
            {
                label: 'Dashboard',
                icon: 'fa-solid fa-gauge',
                command: () => {

                }
            },
            {
                label: 'Operador de caixa',
                icon: 'fa-solid fa-user',
                items: [
                    {
                        label: 'Novo',
                        icon: 'fa-solid fa-user-plus',
                        command: () => null
                    },
                    {
                        label: 'Lista',
                        icon: 'fa-solid fa-list',
                        command: () => null
                    },
                ]
            },
            {
                label: 'Clientes',
                icon: 'fa-solid fa-users',
                items: [
                    {
                        label: 'Novo',
                        icon: 'fa-solid fa-user-plus',
                        command: () => null
                    },
                    {
                        label: 'Lista',
                        icon: 'fa-solid fa-list',
                        command: () => null
                    },
                ]
            },
        ]
    },
    {
        label: 'PDV',
        icon: 'fa-solid fa-cash-register',
        items: [
            {
                label: 'Dashboard',
                icon: 'fa-solid fa-gauge',
                command: () => {

                }
            },
            {
                label: 'Fazer ainda',
                icon: 'fa-solid fa-user',
                items: [
                    {
                        label: 'Novo',
                        icon: 'fa-solid fa-user-plus',
                        command: () => null
                    },
                    {
                        label: 'Lista',
                        icon: 'fa-solid fa-list',
                        command: () => null
                    },
                ]
            }
        ]
    },
    {
        label: 'Agendamentos',
        icon: 'fa-solid fa-calendar-days',
        items: [
            {
                label: 'Dashboard',
                icon: 'fa-solid fa-gauge',
                command: () => {

                }
            },
            {
                label: 'Fazer ainda',
                icon: 'fa-solid fa-user',
                items: [
                    {
                        label: 'Novo',
                        icon: 'fa-solid fa-user-plus',
                        command: () => null
                    },
                    {
                        label: 'Lista',
                        icon: 'fa-solid fa-list',
                        command: () => null
                    },
                ]
            }
        ]
    },
    {
        label: 'Auto Escola',
        icon: 'fa-solid fa-car',
        items: [
            {
                label: 'Dashboard',
                icon: 'fa-solid fa-gauge',
                command: () => {

                }
            },
            {
                label: 'Agendamentos',
                icon: 'fa-solid fa-calendar',
                items: [
                    {
                        label: 'Novo',
                        icon: 'fa-solid fa-user-plus',
                        command: () => null
                    },
                    {
                        label: 'Lista',
                        icon: 'fa-solid fa-list',
                        command: () => null
                    },
                ]
            },
            {
                label: 'Veículos',
                icon: 'fa-solid fa-car',
                items: [
                    {
                        label: 'Novo',
                        icon: 'fa-solid fa-user-plus',
                        command: () => null
                    },
                    {
                        label: 'Lista',
                        icon: 'fa-solid fa-list',
                        command: () => null
                    },
                ]
            },
            {
                label: 'Alunos',
                icon: 'fa-solid fa-users',
                items: [
                    {
                        label: 'Novo',
                        icon: 'fa-solid fa-user-plus',
                        command: () => null
                    },
                    {
                        label: 'Lista',
                        icon: 'fa-solid fa-list',
                        command: () => null
                    },
                ]
            },
            {
                label: 'Professores',
                icon: 'fa-solid fa-users',
                items: [
                    {
                        label: 'Novo',
                        icon: 'fa-solid fa-user-plus',
                        command: () => null
                    },
                    {
                        label: 'Lista',
                        icon: 'fa-solid fa-list',
                        command: () => null
                    },
                ]
            },
            {
                label: 'Balconista', //mesmo operador de caixa
                icon: 'fa-solid fa-user',
                items: [
                    {
                        label: 'Novo',
                        icon: 'fa-solid fa-user-plus',
                        command: () => null
                    },
                    {
                        label: 'Lista',
                        icon: 'fa-solid fa-list',
                        command: () => null
                    },
                ]
            }
        ]
    },


];

let admin_first = [
    {
        label: 'Administrdores',
        icon: 'fa-solid fa-user-tie',
        items: [
            {
                label: 'Novo',
                icon: 'fa-solid fa-user-plus',
                command: () => router.get(window.route('admin.createView'))
            },
            {
                label: 'Lista',
                icon: 'fa-solid fa-list',
                command: () => router.get(window.route('admin.index'))
            },
        ]
    },
];
let admin = [
    {
        label: 'Plano de pagamento',
        icon: 'fa-solid fa-credit-card',
        items: [
            {
                label: 'Novo',
                icon: 'fa-solid fa-plus',
                command: () => {
                    router.get(window.route('payment_plan.createView'));
                }
            },
            {
                label: 'Lista',
                icon: 'fa-solid fa-list',
                command: () => router.get(window.route('payment_plan.index'))
            },
        ]
    },
    {
        label: 'Empresas',
        icon: 'fa-solid fa-building',
        items: [
            {
                label: 'Nova',
                icon: 'fa-solid fa-plus',
                command: () => {
                    router.get(window.route('adm.company.createView'));
                }
            },
            {
                label: 'Lista',
                icon: 'fa-solid fa-list',
                command: () => router.get(window.route('adm.company.index'))
            },
            {
                label: 'Históricos de pagamento',
                icon: 'fa-solid fa-timeline',
            },
            {
                label: 'Controle responsável',
                icon: 'fa-solid fa-users-gear',
                command: () => router.get(window.route('adm.company.listResponsibleView'))
            }
        ]
    },
    {
        label: 'Usuários',
        icon: 'fa-solid fa-user',
        items: [
            {
                label: 'Novo',
                icon: 'fa-solid fa-user-plus',
                command: () => router.get(window.route('adm.user.createView'))
            },
            {
                label: 'Lista',
                icon: 'fa-solid fa-list',
                command: () => router.get(window.route('adm.user.index'))
            },
        ]
    },
];

let guard = {
    generateForGuard: (guard, level = null) => {
        switch (guard) {
            case 'web':
                if(level){
                    return [...common, ...web_responsible,...web]
                }
                return [...common, ...web];
            case 'admin':
                if (level == 'first') {
                    return [...common, ...admin_first, ...admin];
                } else {
                    return [...common, ...admin];
                }
            case 'operator_cashier':
                return [];
        }
    }
}
export default guard;
