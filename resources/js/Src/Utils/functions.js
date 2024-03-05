import Swal from 'sweetalert2';
const navigation = {
    openWindow: (url) => {
        let width = window.innerWidth * 0.5;
        let height = window.innerHeight * 0.5;
        window.open(url, "", `width=${width},height=${height}`);
    }
};


const alert = {
    //back-end
    delete_question: (title,text,confirm_callback) => { //sim faz função do não, não faz função do sim
        Swal.fire({
            title: title,
            text: text,
            icon: "question",
            showCancelButton: false,
            showDenyButton: true,
            confirmButtonColor: "#3085d6",
            denyButtonColor: "#d33",
            confirmButtonText: "Não",
            denyButtonText: "Sim!",
        }).then((result) => {
            if (result.isDenied) {
                confirm_callback();
            }
        });
    },
    //apenas front-end
    alert: (title,text, icon, callback) => { //sim faz função do não, não faz função do sim
        Swal.fire({
            title: title,
            text: text,
            icon: icon,
            showCancelButton: false,
            showDenyButton: false,
            confirmButtonColor: "#3085d6",
            confirmButtonText: "OK",
        }).then((result) => {
            if (result.isConfirmed) {
                callback();
            }
        });
    },
    info: (text) => {
        Swal.fire({
            title: 'Informação',
            html: text,
            icon: 'info',
            showCancelButton: false,
            showDenyButton: false,
            confirmButtonColor: "#3085d6",
            confirmButtonText: "OK",
        }).then((result) => {

        });
    },
    questionDeleteInvert: (confirm_callback) => { //sim faz função do não, não faz função do sim
        Swal.fire({
            title: "Exclusão",
            text: "Deseja prosseguir com a ação?",
            icon: "question",
            showCancelButton: false,
            showDenyButton: true,
            confirmButtonColor: "#3085d6",
            denyButtonColor: "#d33",
            confirmButtonText: "Não",
            denyButtonText: "Sim!",
        }).then((result) => {
            if (result.isDenied) {
                confirm_callback();
            }
        });
    },
};

const date_js = {
    format_date: (date) => {
        return new Date(date).toLocaleString('pt-BR', {
            timeZone: 'UTC',
            day: '2-digit',
            month: '2-digit',
            year: 'numeric'
        });
    },
}

export {
    navigation,
    alert,
    date_js
}
