import './bootstrap';
// import '../css/app.css';
if(localStorage.getItem('theme') == 'dark'){
    import ('primevue/resources/themes/lara-dark-green/theme.css')
}else{
    import ('primevue/resources/themes/lara-light-green/theme.css')
}
import 'primeicons/primeicons.css';
import { createApp, h } from 'vue';
import { createInertiaApp, Link } from '@inertiajs/vue3';
import { resolvePageComponent } from 'laravel-vite-plugin/inertia-helpers';
import { ZiggyVue } from '../../vendor/tightenco/ziggy/dist/vue.m';
import { createPinia } from 'pinia';
import PrimeVue from 'primevue/config';
import Ripple from 'primevue/ripple';
import Swal from 'sweetalert2'
import * as Components from './components';
const appName = import.meta.env.VITE_APP_NAME || 'Laravel';
const pinia = createPinia();

createInertiaApp({
    title: (title) => `${title} - ${appName}`,
    resolve: (name) => resolvePageComponent(`./Pages/${name}.vue`, import.meta.glob('./Pages/**/*.vue')),
    setup({ el, App, props, plugin }) {
        const app =  createApp({ render: () => h(App, props) });

            app.use(plugin)
            .use(pinia)
            .use(PrimeVue)
            .use(Components.primevue.messages.ToastService)
            .use(ZiggyVue);

            app.directive('ripple',Ripple);
            app.directive('Badge',Components.primevue.directive.BadgeDirective);
            app.directive('Tooltip',Components.primevue.directive.Tooltip);
            //layout
            app.component('AppLayout', Components.layouts.AppLayout);
            //primevue
            app.
            component('Button', Components.primevue.button.Button)
            .component('PanelMenu', Components.primevue.menu.PanelMenu)
            .component('Breadcrumb', Components.primevue.menu.Breadcrumb)
            .component('Panel', Components.primevue.panel.Panel)
            .component('InputText', Components.primevue.form.InputText)
            .component('InputNumber', Components.primevue.form.InputNumber)
            .component('Toast', Components.primevue.messages.Toast)
            .component('Badge', Components.primevue.misc.Badge);
            //custom
            //inertia
            app.component('Link', Link);
            //global
            app.provide('Swal',Swal);
            return app.mount(el);
    },
    progress: {
        color: '#4B5563',
    },
});
