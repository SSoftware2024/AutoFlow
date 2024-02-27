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
let web = {
    financial: [
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
                    label: 'Contas a pagar',
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
    ],
    erp: [
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
    ],
    pdv: [
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
    ],
    schedulling: [
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
    ],
    driving_school: [
        {
            label: 'Auto Escola',
            icon: 'fa-solid fa-car',
            items: [
                {
                    label: 'Dashboard',
                    icon: 'fa-solid fa-gauge',
                    command: () => router.get(window.route('user.driving_school.dashboard'))
                },
                {
                    label: 'Agendamentos',
                    icon: 'fa-solid fa-calendar-days',
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
    ]


};

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
    generateForAdmin: (level = null) => {
        if (level == 'first') {
            return [...common, ...admin_first, ...admin];
        } else {
            return [...common, ...admin];
        }
    },
    generateForWeb: (responsible = false, permissions_payment_plan) => {//users
        const sale = permissions_payment_plan?.sale;
        const schedulling = permissions_payment_plan?.schedulling;
        let links = [];
        if(sale && sale.erp.value){
            links.push(...web.erp);
        }
        if(sale && sale.pdv.value){
            links.push(...web.pdv);
        }
        if(sale && sale.financial.value){
            links.push(...web.financial);
        }
        if(schedulling && schedulling.common.value){
            links.push(...web.schedulling);
        }
        if(schedulling && schedulling.driving_school.value){
            links.push(...web.driving_school);
        }
        if (responsible) {
            return [...common, ...web_responsible, ...links]
        }
        return [...common, ...links];
    }
}
export default guard;
