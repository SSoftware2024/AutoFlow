//primevue
import Button from 'primevue/button';
import PanelMenu from 'primevue/panelmenu';
import Badge from 'primevue/badge';
import Breadcrumb from 'primevue/breadcrumb';
import Panel from 'primevue/panel';
import InputText from 'primevue/inputtext';
import InputNumber from 'primevue/inputnumber';
import Tooltip from 'primevue/tooltip';
import Toast from 'primevue/toast';
import ToastService from 'primevue/toastservice';
import DataTable from 'primevue/datatable';
import Column from 'primevue/column';
import ColumnGroup from 'primevue/columngroup';   // optional
import Row from 'primevue/row';                   // optional
import ConfirmDialog from 'primevue/confirmdialog';
import ConfirmationService from 'primevue/confirmationservice';
//layouts
import AppLayout from '@/Layouts/AppLayout.vue';
//custom

//directives
import BadgeDirective from 'primevue/badgedirective';
let custom = {

}
let primevue = {
    directive: {
        BadgeDirective: BadgeDirective,
        Tooltip,
    },
    misc: {
        Badge,
    },
    data: {
        table:{
            DataTable,
            Column,
            ColumnGroup,
            Row,
        }
    },
    panel: {
        Panel,
    },
    button: {
        Button,
    },
    form: {
        InputText,
        InputNumber
    },
    menu: {
        PanelMenu,
        Breadcrumb,
    },
    messages: {
        ToastService, //use
        Toast
    },
    overlay: {
        ConfirmDialog,
        ConfirmationService, //use
    }

};

let layouts = {
    AppLayout,
}

export {
    custom,
    primevue,
    layouts
}
