import Button from 'primevue/button';
import PanelMenu from 'primevue/panelmenu';
import Badge from 'primevue/badge';
import Breadcrumb from 'primevue/breadcrumb';

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
    Breadcrumb
}

export {
    custom,
    primevue
}
