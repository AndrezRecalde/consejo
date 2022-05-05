export default () => ({
    user: null,
    token: null,
    headers: null,
    config: {
        adjunto_limite_maximo: 5388608,
    },
    user: {
        roles: {
            administrador: "Administrador",
            supervisor: "Supervisor",
            coordinador: "Coordinador",
        },
    },
    //5Mb
    sweetAlertBlocked: {},
    dialogSimple: {
        bodycard: "",
        buttons: "",
        dialog: false,
        titulo: "",
        maxwidth: "",
        data: "",
    },
    dialogSimple2: {
        bodycard: "",
        buttons: "",
        dialog: false,
        titulo: "",
        maxwidth: "",
        data: "",
    },
    dialogSimple3: {
        bodycard: "",
        buttons: "",
        dialog: false,
        titulo: "",
        maxwidth: "",
        data: "",
    },
    dialogSimple4: {
        bodycard: "",
        buttons: "",
        dialog: false,
        titulo: "",
        maxwidth: "",
        data: "",
    },
    usuario: {},
    windowSize: {
        x: 0,
        y: 0,
    },
    vsocket: "",
    validEmail: function (email) {
        var re =
            /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
        return re.test(email);
    },
});
