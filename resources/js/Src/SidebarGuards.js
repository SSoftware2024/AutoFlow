import { router } from '@inertiajs/vue3';
let common = [
    {
        label: 'Dashboard',
        icon: 'fa-solid fa-gauge',
        command: () => {
            router.get('/dashboard');
        }
    },
    {
        label: 'Files',
        icon: 'fa-solid fa-money-bill',
        items: [
            {
                label: 'Documents',
                icon: 'pi pi-file',
                items: [
                    {
                        label: 'Invoices',
                        icon: 'pi pi-file-pdf',
                        items: [
                            {
                                label: 'Pending',
                                icon: 'pi pi-stop',
                                command: () => {
                                    alert('item pending');
                                }
                            },
                            {
                                label: 'Paid',
                                icon: 'pi pi-check-circle'
                            }
                        ]
                    },
                ]
            },
            {
                label: 'Images',
                icon: 'pi pi-image',
                items: [
                    {
                        label: 'Logos',
                        icon: 'pi pi-image'
                    }
                ]
            }
        ]
    },
    {
        label: 'Cloud',
        icon: 'pi pi-cloud',
        items: [
            {
                label: 'Upload',
                icon: 'pi pi-cloud-upload'
            },
            {
                label: 'Download',
                icon: 'pi pi-cloud-download'
            },
            {
                label: 'Sync',
                icon: 'pi pi-refresh'
            }
        ]
    },
    {
        label: 'Devices',
        icon: 'pi pi-desktop',
        items: [
            {
                label: 'Phone',
                icon: 'pi pi-mobile'
            },
            {
                label: 'Desktop',
                icon: 'pi pi-desktop'
            },
            {
                label: 'Tablet',
                icon: 'pi pi-tablet'
            }
        ]
    }
];
let web = [
    {
        label: 'web guard',
        icon: 'fa-solid fa-money-bill',
    }
];

let guard = {
    generateForGuard: (guard) => {
        switch (guard) {
            case 'web':
                return [...common, ...web];
                break;
        }
    }
}
export default guard;
