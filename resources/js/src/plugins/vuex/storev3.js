import { createStore } from "vuex";
import Swal from "sweetalert2";
import { round } from "lodash";

const store = createStore({
    state: {
        config: {
            adjunto_limite_maximo: 5388608,
            environment:
                document.getElementById("environment") == null
                    ? null
                    : document.getElementById("environment").value,
        },
        //5Mb
        sweetAlertBlocked: {},
        swal: Swal,
        dialogSimple: {
            bodycard: "",
            buttons: "",
            dialog: false,
            titulo: "",
            maxwidth: "",
            data: ""
        },
        dialogSimple2: {
            bodycard: "",
            buttons: "",
            dialog: false,
            titulo: "",
            maxwidth: "",
            data: ""
        },
        dialogSimple3: {
            bodycard: "",
            buttons: "",
            dialog: false,
            titulo: "",
            maxwidth: "",
            data: ""
        },
        dialogSimple4: {
            bodycard: "",
            buttons: "",
            dialog: false,
            titulo: "",
            maxwidth: "",
            data: ""
        },
        usuario: {
            id:
                document.getElementById("usuario_id") == null
                    ? null
                    : document
                        .getElementById("usuario_id")
                        .getAttribute("data-id"),
            perfil_id:
                document.getElementById("usuario_id") == null
                    ? null
                    : document
                        .getElementById("usuario_id")
                        .getAttribute("data-perfil_id"),
            nivel:
                document.getElementById("usuario_id") == null
                    ? null
                    : document
                        .getElementById("usuario_id")
                        .getAttribute("data-nivel"),
            email:
                document.getElementById("usuario_id") == null
                    ? null
                    : document
                        .getElementById("usuario_id")
                        .getAttribute("data-email"),
        },
        menu_ruta:
            document.getElementById("menu_ruta") == null
                ? null
                : document.getElementById("menu_ruta").value,
        mensaje:
            document.getElementById("mensaje") == null
                ? null
                : document.getElementById("mensaje").value,
        estado_mensaje:
            document.getElementById("estado_mensaje") == null
                ? null
                : document.getElementById("estado_mensaje").value,
        windowSize: {
            x: 0,
            y: 0
        },
        vsocket: null,
        soloImagenes(str){
            return ["jpg", "jpeg", "bmp", "gif", "png"].includes(str)
        },
        soloLetras(input) {
            let char = String.fromCharCode(input); // Get the character
            return /^[a-zA-Z\s]+$/.test(char);
        },
        soloNumeros(input) {
            let char = String.fromCharCode(input); // Get the character
            return /^\d+$/.test(char);
        },
        formatNumber(num) {
            return num != "" && num != null
                ? num.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, "$1,")
                : num;
        },
        esVacio(str) {
            switch (str) {
                case "":
                case 0:
                case "0":
                case null:
                case false:
                case typeof e == "undefined":
                    return true;
                default:
                    return false;
            }
        },
        validEmail: function(email) {
            var re = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
            return re.test(email);
        },
        ruta(ruta) {
            window.location.href = ruta;
        },
        getQueryParam(param) {
            location.search.substr(1)
                .split('&')
                .some(function (item) { // returns first occurence and stops
                    return item.split('=')[0] == param && (param = item.split('=')[1])
                })
            return param
        }
    },
    mutations: {
        openSweetAlertBlocked(state, data) {
            let timerInterval;
            Swal.fire({
                title: data.mensajeLoading,
                html: data.mensaje,
                timer: data.time,
                allowOutsideClick: false,
                allowEscapeKey: false,
                allowEnterKey: false,
                didOpen: () => {
                    Swal.showLoading();
                    timerInterval = setInterval(() => {
                        const content = Swal.getContent();
                        if (content) {
                            const b = content.querySelector("b");
                            if (b) {
                                b.textContent = round(
                                    Swal.getTimerLeft() / 1000
                                );
                            }
                        }
                    }, 100);
                },
                willClose: () => {
                    clearInterval(timerInterval);
                }
            }).then(result => {});
        },
        openDialogSimple(state, data) {
            state.dialogSimple.bodycard = data.bodycard;
            state.dialogSimple.buttons = data.buttons;
            state.dialogSimple.optionsbuttonstop = data.optionsbuttonstop;
            state.dialogSimple.dialog = data.openDialog;
            state.dialogSimple.titulo = data.titulo;
            state.dialogSimple.maxwidth = data.maxwidth;
            state.dialogSimple.data = data.data;
        },
        openDialogSimple2(state, data) {
            state.dialogSimple2.bodycard = data.bodycard;
            state.dialogSimple2.buttons = data.buttons;
            state.dialogSimple2.optionsbuttonstop = data.optionsbuttonstop;
            state.dialogSimple2.dialog = data.openDialog;
            state.dialogSimple2.titulo = data.titulo;
            state.dialogSimple2.maxwidth = data.maxwidth;
            state.dialogSimple2.data = data.data;
        },
        openDialogSimple3(state, data) {
            state.dialogSimple3.bodycard = data.bodycard;
            state.dialogSimple3.buttons = data.buttons;
            state.dialogSimple3.optionsbuttonstop = data.optionsbuttonstop;
            state.dialogSimple3.dialog = data.openDialog;
            state.dialogSimple3.titulo = data.titulo;
            state.dialogSimple3.maxwidth = data.maxwidth;
            state.dialogSimple3.data = data.data;
        },
        openDialogSimple4(state, data) {
            state.dialogSimple4.bodycard = data.bodycard;
            state.dialogSimple4.buttons = data.buttons;
            state.dialogSimple4.optionsbuttonstop = data.optionsbuttonstop;
            state.dialogSimple4.dialog = data.openDialog;
            state.dialogSimple4.titulo = data.titulo;
            state.dialogSimple4.maxwidth = data.maxwidth;
            state.dialogSimple4.data = data.data;
        },
        onResize(state) {
            state.windowSize = { x: window.innerWidth, y: window.innerHeight };
        },
        buscadorPrincipal(state) {
            state.buscadorprincipal = !state.buscadorprincipal;
        },
    },
    getters: {
        getSwal(state) {
            return state.swal;
        },
        getToastDefault(state) {
            return state.swal.mixin({
                toast: true,
                position: "bottom-end",
                showConfirmButton: false,
                timer: 5000,
                timerProgressBar: true,
                onOpen: toast => {
                    toast.addEventListener("mouseenter", state.swal.stopTimer);
                    toast.addEventListener(
                        "mouseleave",
                        state.swal.resumeTimer
                    );
                }
            });
        },
        isExtraSmall(state) {
            return state.windowSize.x <= 600;
        },
        isSmall(state) {
            return state.windowSize.x > 600 && state.windowSize.x <= 960;
        },
        isMedium(state) {
            return state.windowSize.x > 960 && state.windowSize.x <= 1250;
        },
        isMediumMayor(state) {
            return state.windowSize.x > 1250 && state.windowSize.x <= 1900;
        },
        isLarge(state) {
            return state.windowSize.x > 1900;
        }
    }
});
export default store;
