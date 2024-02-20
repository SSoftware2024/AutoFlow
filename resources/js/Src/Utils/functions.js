import Swal from 'sweetalert2';
const navigation = {
    openWindow: (url) => {
        let width = window.innerWidth * 0.5;
        let height = window.innerHeight * 0.5;
        window.open(url, "", `width=${width},height=${height}`);
    }
};

const pv_question = {
    confirms: (header, question, accept_callback, reject_callback) => {
        confirm.require({
            message: question,
            header: header,
            icon: 'pi pi-question-circle',
            rejectClass: 'p-button-danger p-button-text',
            acceptClass: 'p-button-text p-button-text',
            rejectLabel: 'Aceitar',
            acceptLabel: 'Rejeitar',
            accept: () => {
                reject_callback();
            },
            reject: () => {
                accept_callback();

            }
        });
    }
}

const alert = {
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
    }
};

export {
    navigation,
    alert
}
