import './bootstrap';
// import '../css/app.css';
if(localStorage.getItem('theme') == 'dark'){
    import ('primevue/resources/themes/lara-dark-green/theme.css')
}else{
    import ('primevue/resources/themes/lara-light-green/theme.css')
}
import 'primeicons/primeicons.css';
import { createApp, h } from 'vue';
import { createInertiaApp, Link, router } from '@inertiajs/vue3';
import { resolvePageComponent } from 'laravel-vite-plugin/inertia-helpers';
import { ZiggyVue } from '../../vendor/tightenco/ziggy/dist/vue.m';
import PrimeVue from 'primevue/config';
import * as PrimeVueLocale from '@/Src/primevue-locale.js';
import Ripple from 'primevue/ripple';
import Swal from 'sweetalert2'
import * as Components from './components';
const appName = import.meta.env.VITE_APP_NAME || 'Laravel';

createInertiaApp({
    title: (title) => `${title} - ${appName}`,
    resolve: (name) => resolvePageComponent(`./Pages/${name}.vue`, import.meta.glob('./Pages/**/*.vue')),
    setup({ el, App, props, plugin }) {
        const app =  createApp({ render: () => h(App, props) });

            app.use(plugin)
            .use(PrimeVue, {
                locale: PrimeVueLocale.pt
            })
            .use(Components.primevue.messages.ToastService)
            .use(Components.primevue.overlay.ConfirmationService)
            .use(ZiggyVue);

            app.directive('ripple',Ripple);
            app.directive('Badge',Components.primevue.directive.BadgeDirective);
            app.directive('Tooltip',Components.primevue.directive.Tooltip);
            //layout
            app.component('AppLayout', Components.layouts.AppLayout);
            //primevue
            app.
            component('Button', Components.primevue.button.Button)
            .component('SplitButton', Components.primevue.button.SplitButton)
            .component('SpeedDial', Components.primevue.button.SpeedDial)
            .component('PanelMenu', Components.primevue.menu.PanelMenu)
            .component('Breadcrumb', Components.primevue.menu.Breadcrumb)
            .component('Menu', Components.primevue.menu.Menu)
            .component('Toolbar', Components.primevue.panel.Toolbar)
            .component('Fieldset', Components.primevue.panel.Fieldset)
            .component('Panel', Components.primevue.panel.Panel)
            .component('Accordion', Components.primevue.panel.Accordion)
            .component('AccordionTab', Components.primevue.panel.AccordionTab)
            .component('InputText', Components.primevue.form.InputText)
            .component('Password', Components.primevue.form.Password)
            .component('Checkbox', Components.primevue.form.Checkbox)
            .component('InputNumber', Components.primevue.form.InputNumber)
            .component('InputMask', Components.primevue.form.InputMask)
            .component('Dropdown', Components.primevue.form.Dropdown)
            .component('FileUpload', Components.primevue.form.FileUpload)
            .component('Toast', Components.primevue.messages.Toast)
            .component('Paginator', Components.primevue.data.Paginator)
            .component('DataTable', Components.primevue.data.table.DataTable)
            .component('Column', Components.primevue.data.table.Column)
            .component('ColumnGroup', Components.primevue.data.table.ColumnGroup)
            .component('Row', Components.primevue.data.table.Row)
            .component('ConfirmDialog', Components.primevue.overlay.ConfirmDialog)
            .component('Dialog', Components.primevue.overlay.Dialog)
            .component('Image', Components.primevue.media.Image)
            .component('Badge', Components.primevue.misc.Badge);
            //custom
            app.component('IconButtonDropdown', Components.custom.dropdown.IconButtonDropdown)
            .component('LinkDropdown', Components.custom.dropdown.LinkDropdown)
            .component('LinkButtonDropdown', Components.custom.dropdown.LinkButtonDropdown)
            .component('Pagination', Components.custom.Pagination);
            //inertia
            app.component('Link', Link);
            //global
            app.provide('Swal',Swal);
            app.config.globalProperties.$toRoute = (url) => {
                router.get(url);
            };
            app.config.globalProperties.$openNewWindow = (url) => {
                let width = window.innerWidth * 0.5;
                let height = window.innerHeight * 0.5;
                window.open(url, "", `width=${width},height=${height}`);
            };
            return app.mount(el);
    },
    progress: {
        color: '#4B5563',
    },
});
