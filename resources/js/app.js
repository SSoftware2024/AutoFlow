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
            .use(ZiggyVue);

            app.directive('ripple',Ripple);
            app.directive('Badge',Components.primevue.directive.BadgeDirective);
            //layout
            app.component('AppLayout', Components.layouts.AppLayout);
            //primevue
            app.
            component('Button', Components.primevue.Button)
            .component('PanelMenu', Components.primevue.PanelMenu)
            .component('Breadcrumb', Components.primevue.Breadcrumb)
            .component('Panel', Components.primevue.Panel)
            .component('InputText', Components.primevue.InputText)
            .component('Badge', Components.primevue.Badge);
            //custom
            //inertia
            app.component('Link', Link);
            return app.mount(el);
    },
    progress: {
        color: '#4B5563',
    },
});
