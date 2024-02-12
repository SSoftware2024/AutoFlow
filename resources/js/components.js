/*==========PRIMEVUE==========*/
import Badge from 'primevue/badge';
import Toast from 'primevue/toast';
import ToastService from 'primevue/toastservice';          // optional
import ConfirmDialog from 'primevue/confirmdialog';
import ConfirmationService from 'primevue/confirmationservice';
//overlay
import Dialog from 'primevue/dialog';
import Tooltip from 'primevue/tooltip';
//button
import Button from 'primevue/button';
import SplitButton from 'primevue/splitbutton';
import SpeedDial from 'primevue/speeddial';
//menu
import Menu from 'primevue/menu';
import Breadcrumb from 'primevue/breadcrumb';
import PanelMenu from 'primevue/panelmenu';
//panel
import Panel from 'primevue/panel';
import Accordion from 'primevue/accordion';
import AccordionTab from 'primevue/accordiontab';
import Toolbar from 'primevue/toolbar';
//form
import InputText from 'primevue/inputtext';
import InputNumber from 'primevue/inputnumber';
import Dropdown from 'primevue/dropdown';
import InputMask from 'primevue/inputmask';
import Password from 'primevue/password';
import Checkbox from 'primevue/checkbox';
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
import IconButtonDropdown from '@/Components/DropDown/IconButton.vue';
import LinkDropdown from '@/Components/DropDown/Link.vue';
import LinkButtonDropdown from '@/Components/DropDown/Button.vue';
import Pagination from '@/Components/Navigate/Paginate.vue';
//directives
import BadgeDirective from 'primevue/badgedirective';
let custom = {
    dropdown: {
        IconButtonDropdown,
        LinkDropdown,
        LinkButtonDropdown
    },
    Pagination
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
        AccordionTab,
        Toolbar

    },
    button: {
        Button,
        SplitButton,
        SpeedDial
    },
    form: {
        InputText,
        InputNumber,
        Dropdown,
        InputMask,
        FileUpload,
        Password,
        Checkbox
    },
    menu: {
        PanelMenu,
        Breadcrumb,
        Menu
    },
    messages: {
        ToastService, //use
        Toast
    },
    overlay: {
        ConfirmDialog,
        ConfirmationService, //use
        Dialog
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
