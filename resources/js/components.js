//primevue
import Button from 'primevue/button';
import PanelMenu from 'primevue/panelmenu';
import Badge from 'primevue/badge';
import Breadcrumb from 'primevue/breadcrumb';
import Panel from 'primevue/panel';
import InputText from 'primevue/inputtext';
//layouts
import AppLayout from '@/Layouts/AppLayout.vue';
//custom

//directives
import BadgeDirective from 'primevue/badgedirective';
let custom = {

}
let primevue = {
    directive: {
        BadgeDirective: BadgeDirective
    },
    Badge,
    Button,
    PanelMenu,
    Breadcrumb,
    Panel,
    InputText
};

let layouts = {
    AppLayout,
}

export {
    custom,
    primevue,
    layouts
}
