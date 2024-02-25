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
        label: 'Alunos',
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
                return [...common, ...web];
            case 'admin':
                if(level == 'first'){
                    return [...common,...admin_first, ...admin];
                }else{
                    return [...common, ...admin];
                }
            case 'operator_cashier':
                return [];
        }
    }
}
export default guard;
