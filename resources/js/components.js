/*==========PRIMEVUE==========*/
import Button from 'primevue/button';
import SplitButton from 'primevue/splitbutton';
import PanelMenu from 'primevue/panelmenu';
import Badge from 'primevue/badge';
import Breadcrumb from 'primevue/breadcrumb';
import Tooltip from 'primevue/tooltip';
import Toast from 'primevue/toast';
import ToastService from 'primevue/toastservice';          // optional
import ConfirmDialog from 'primevue/confirmdialog';
import ConfirmationService from 'primevue/confirmationservice';
//panel
import Panel from 'primevue/panel';
import Accordion from 'primevue/accordion';
import AccordionTab from 'primevue/accordiontab';
//form
import InputText from 'primevue/inputtext';
import InputNumber from 'primevue/inputnumber';
import Dropdown from 'primevue/dropdown';
import InputMask from 'primevue/inputmask';
import FileUpload from 'primevue/fileupload';
//data
import DataTable from 'primevue/datatable';
import Column from 'primevue/column';
import ColumnGroup from 'primevue/columngroup';   // optional
import Row from 'primevue/row';
import Paginator from 'primevue/paginator';
//media
import Image from 'primevue/image';

/*==========END PRIMEVUE==========*/

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
    media: {
        Image
    },
    data: {
        Paginator,
        table:{
            DataTable,
            Column,
            ColumnGroup,
            Row,
        }
    },
    panel: {
        Panel,
        Accordion,
        AccordionTab

    },
    button: {
        Button,
        SplitButton
    },
    form: {
        InputText,
        InputNumber,
        Dropdown,
        InputMask,
        FileUpload,
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
