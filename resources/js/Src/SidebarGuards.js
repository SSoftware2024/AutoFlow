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
let web = [
    {
        label: 'web guard',
        icon: 'fa-solid fa-money-bill',
    }
];
let admin = [
    {
        label: 'Administrdores',
        icon: 'fa-solid fa-user-tie',
        items: [
            {
                label: 'Novo',
                icon: 'fa-solid fa-user-plus',
            },
            {
                label: 'Lista',
                icon: 'fa-solid fa-list',
            },
        ]
    },
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
            },
        ]
    },
];

let guard = {
    generateForGuard: (guard) => {
        switch (guard) {
            case 'web':
                return [...common, ...web];
            case 'admin':
                return [...common, ...admin];
        }
    }
}
export default guard;
