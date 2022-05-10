<template>
    <div>
        <div class="card mb-5 mb-xxl-8">
            <div class="card-body pt-9 pb-0">
                <v-row>
                    <h2>Users</h2>
                    <v-col cols="12">
                        <v-btn class="info mb-5" @click="nuevo"
                            ><v-icon left dark>add</v-icon>Nuevo</v-btn
                        >
                        <v-btn class="success mb-5" @click="descargar"
                            ><v-icon left dark>cloud_download</v-icon
                            >Exportar</v-btn
                        >
                        <v-btn v-if="$store.getters.getUser.roles == $store.state.user.roles.administrador" class="success mb-5" @click="descargarVeedores"
                            ><v-icon left dark>cloud_download</v-icon
                            >Exportar veedores</v-btn
                        >
                    </v-col>
                </v-row>
                <TableContent
                    :headers="headers"
                    :items="items"
                    :loading="loadingTable"
                >
                    <template v-slot:btnAcciones="{ item }">
                        <Menu
                            :small="true"
                            :icon="true"
                            :clase="'fourth'"
                            :color="'white'"
                            :_item="item"
                            :icon_name="'more_vert'"
                            :list_menu="listar_menu_tabla(item)"
                        ></Menu>
                    </template>
                </TableContent>
            </div>
        </div>
        <DialogSimple>
            <template v-slot:bodycardNuevo>
                <v-form ref="form" class="pt-5" v-model="valid" lazy-validation>
                    <v-row>
                        <v-col cols="12" md="12" class="pb-0">
                            <v-text-field
                                :rules="validations.first_name"
                                label="Nombre"
                                v-model="input.first_name"
                                required
                                outlined
                                dense
                            ></v-text-field>
                            <v-text-field
                                :rules="validations.last_name"
                                label="Apellido"
                                v-model="input.last_name"
                                required
                                outlined
                                dense
                            ></v-text-field>
                        </v-col>
                        <v-col cols="12" lg="6" md="6" class="pt-0">
                            <v-text-field
                                :rules="validations.dni"
                                label="Dni"
                                v-model="input.dni"
                                required
                                outlined
                                dense
                            ></v-text-field>
                        </v-col>
                        <v-col cols="12" lg="6" md="6" class="pt-0">
                            <v-text-field
                                :rules="validations.phone"
                                label="Teléfono"
                                v-model="input.phone"
                                required
                                outlined
                                dense
                            ></v-text-field>
                        </v-col>
                        <v-col cols="12" class="pt-0">
                            <v-text-field
                                :rules="validations.email"
                                label="Email"
                                v-model="input.email"
                                required
                                outlined
                                dense
                            ></v-text-field>
                        </v-col>
                        <v-col cols="12" md="6" class="pt-0">
                            <v-select
                                :rules="validations.rol_id"
                                outlined
                                v-model="input.rol_id"
                                required
                                :items="itemsRoles"
                                item-text="name"
                                item-value="id"
                                label="Rol"
                                dense
                            ></v-select>
                        </v-col>
                        <v-col cols="12" md="6" class="pt-0">
                            <v-select
                                :rules="validations.canton_id"
                                outlined
                                v-model="input.canton_id"
                                required
                                :items="itemsCanton"
                                item-text="nombre_canton"
                                item-value="id"
                                label="Canton"
                                @change="cargarParroquias"
                                dense
                            ></v-select>
                        </v-col>
                        <v-col cols="12" md="6" class="pt-0">
                            <v-select
                                :rules="validations.parroquia_id"
                                outlined
                                v-model="input.parroquia_id"
                                required
                                :items="itemsParroquia"
                                item-text="nombre_parroquia"
                                item-value="id"
                                label="Parroquia"
                                dense
                            ></v-select>
                        </v-col>
                        
                        <v-col cols="12" v-if="modificando">
                            <template v-for="(item, index) in files">
                                <div :key="index">
                                    <v-text-field
                                        dense
                                        outlined
                                        label="Imagen"
                                        readonly
                                        required
                                        :rules="
                                            validations[
                                                'adjunto_nombre' + index
                                            ]
                                        "
                                        @click="
                                            selectAdjunto('adjunto' + index)
                                        "
                                        v-model="item.adjunto_nombre"
                                        prepend-inner-icon="attach_file"
                                    ></v-text-field>
                                    <span
                                        class="error--text"
                                        v-if="
                                            item.adjunto_size >
                                            $store.state.config
                                                .adjunto_limite_maximo
                                        "
                                        >{{
                                            item.loadingFile
                                                ? "Cargando Archivo..."
                                                : "El tamaño del documento debe ser menor o igual a 5Mb"
                                        }}</span
                                    >
                                    <input
                                        :id="'adjunto_file' + index"
                                        type="file"
                                        style="display: none"
                                        :ref="'adjunto' + index"
                                        accept="image/*"
                                        @change="
                                            guardarAdjunto($event, item, index)
                                        "
                                    />
                                </div>
                            </template>
                        </v-col>
                    </v-row>
                </v-form>
            </template>
            <template v-slot:buttonsNuevo>
                <v-btn
                    color="primary"
                    :loading="loading"
                    :disabled="loading"
                    @click="modificando ? editar() : guardar()"
                    >{{ modificando ? "Modificar" : "Guardar" }}</v-btn
                >
                <v-btn @click="dialogClose('dialogSimple')">Cancelar</v-btn>
            </template>
        </DialogSimple>
    </div>
</template>

<script>
import TableContent from "@/components/components/TableContent";
import Menu from "@/components/components/Menu";
import DialogSimple from "@/components/components/DialogSimple";
var swal__;
var toast__;
var self;
export default {
    components: {
        TableContent,
        Menu,
        DialogSimple,
    },
    created() {
        self = this;
        swal__ = this.$store.getters.getSwal;
        toast__ = this.$store.getters.getToastDefault;
        this.cargarValidaciones();
        this.cargarAll();
        this.cargarCantones();
        this.cargarRoles();
    },
    mounted() {},
    data() {
        return {
            valid: false,
            loading: false,
            modificando: false,
            itemsCanton: [],
            itemsParroquia: [],
            itemsRoles: [],
            input: {
                dni: "",
                first_name: "",
                last_name: "",
                phone: "",
                email: "",
                canton_id: "",
                parroquia_id: "",
                rol_id: "",
            },
            urls: {
                cargarAll: "/api/users-all",
                cargarCantones: "/api/cantones",
                cargarParroquias: "/api/parroquias",
                guardar: "/api/store/user",
                cargar: "/api/show/user",
                eliminar: "/api/delete/user",
                editar: "/api/update/user",
                cargarRoles: "/api/roles",
            },
            validations: {
                dni: [
                    (v) => (v != null && v != "") || "El campo es obligatorio",
                ],
                first_name: [
                    (v) => (v != null && v != "") || "El campo es obligatorio",
                ],
                last_name: [
                    (v) => (v != null && v != "") || "El campo es obligatorio",
                ],
                phone: [
                    (v) => (v != null && v != "") || "El campo es obligatorio",
                ],
                email: [
                    (v) => (v != null && v != "") || "El campo es obligatorio",
                ],
                canton_id: [
                    (v) => (v != null && v != "") || "El campo es obligatorio",
                ],
                parroquia_id: [
                    (v) => (v != null && v != "") || "El campo es obligatorio",
                ],
                rol_id: [
                    (v) => (v != null && v != "") || "El campo es obligatorio",
                ],
            },
            headers: [
                { text: "Acciones", value: "action", sortable: false },
                { text: "Dni", align: "left", value: "dni" },
                { text: "Nombre", align: "left", value: "first_name" },
                { text: "Apellido", align: "left", value: "last_name" },
                { text: "Teléfono", align: "left", value: "phone" },
                { text: "Email", align: "left", value: "email" },
                { text: "Rol", align: "left", value: "name" },
                { text: "Canton", align: "left", value: "nombre_canton" },
            ],
            items: [],
            files: [
                {
                    adjunto_nombre: null,
                    adjunto_url: null,
                    adjunto_file: null,
                    adjunto_size: null,
                    loadingFile: false,
                },
            ],
        };
    },
    methods: {
        cargarValidaciones() {
            this.validations.email.push(
                (v) =>
                    (v != null && v != ""
                        ? this.$store.state.validEmail(v)
                        : true) || "El email es inválido"
            );
        },
        listar_menu_tabla(item) {
            return [
                {
                    click: this.cargar,
                    icono: "edit",
                    class: "edit",
                    nombre: "Modificar",
                },
                {
                    click: this.eliminar,
                    icono: "cancel",
                    class: "delete",
                    nombre: "Eliminar",
                },
            ];
        },
        dialogClose(tipo) {
            this.$store.commit("closeDialog", { tipo: tipo, value: false });
        },
        cargarAll() {
            this.loadingTable = true;
            axios
                .get(this.urls.cargarAll)
                .then((response) => {
                    var data = response.data;
                    console.log("data", data);
                    this.items = data.users;
                    this.loadingTable = false;
                })
                .catch((errors) => {});
        },
        cargarRoles() {
            axios
                .get(this.urls.cargarRoles)
                .then((response) => {
                    var data = response.data;
                    this.itemsRoles = data;
                })
                .catch((errors) => {});
        },
        cargarCantones() {
            axios
                .get(this.urls.cargarCantones)
                .then((response) => {
                    var data = response.data;
                    if (data.status == "success") {
                        this.itemsCanton = data.cantones;
                    }
                })
                .catch((errors) => {});
        },
        cargarParroquias() {
            let valor = {
                canton_id: this.input.canton_id,
            };
            axios
                .post(this.urls.cargarParroquias, valor)
                .then((response) => {
                    var data = response.data;
                    console.log("data.estado", data.estado);
                    if (data.status == "success") {
                        this.itemsParroquia = data.parroquias;
                    }
                })
                .catch((errors) => {});
        },
        nuevo() {
            this.resetValues();
            this.$store.commit("openDialogSimple", {
                openDialog: true,
                bodycard: "bodycardNuevo",
                buttons: "buttonsNuevo",
                titulo: "User",
                maxwidth: "500px",
            });
            setTimeout(() => {
                if (!this.$refs.form.validate()) return;
            }, 250);
        },
        cargar(item) {
            this.resetValues();
            let valores = { id: item.id };
            this.modificando = true;
            axios
                .post(this.urls.cargar, valores)
                .then(async (response) => {
                    var data = response.data;
                    this.input = data.user;
                    if (this.input.avatar) {
                        this.files[0].adjunto_nombre = this.input.avatar
                            .split("/")
                            .pop();
                    }
                    await this.cargarParroquias();

                    this.$store.commit("openDialogSimple", {
                        openDialog: true,
                        bodycard: "bodycardNuevo",
                        buttons: "buttonsNuevo",
                        titulo: "Modificar",
                        maxwidth: "500px",
                    });
                    setTimeout(function () {
                        if (!this.$refs.form.validate()) return;
                    }, 250);
                })
                .catch((errors) => {});
        },
        guardar() {
            if (!this.$refs.form.validate()) return;
            var formData = new FormData();
            formData.append("canton_id", this.input.canton_id);
            formData.append("parroquia_id", this.input.parroquia_id);
            formData.append("first_name", this.input.first_name);
            formData.append("last_name", this.input.last_name);
            formData.append("phone", this.input.phone);
            formData.append("email", this.input.email);
            formData.append("dni", this.input.dni);
            formData.append("parroquia_id", this.input.parroquia_id);
            formData.append("roles", this.input.rol_id);

            this.loading = true;
            axios
                .post(this.urls.guardar, formData)
                .then((response) => {
                    var data = response.data;
                    toast__.fire({
                        icon: data.status,
                        title: data.message,
                    });
                    if(data.status=="success"){
                        this.dialogClose("dialogSimple");
                    }
                })
                .catch((errors) => {
                    if(errors.response.data){
                        let arr = Object.values(errors.response.data);
                        swal__.fire(
                            "ERROR!",
                            "ha ocurrido un error: " + arr[0],
                            "error"
                        );
                    }else{
                        swal__.fire(
                            "ERROR!",
                            "ha ocurrido un error: " + errors,
                            "error"
                        );

                    }
                })
                .finally(() => {
                    this.cargarAll();
                    this.loading = false;
                });
        },
        editar() {
            if (!this.$refs.form.validate()) return;
            var formData = new FormData();
            this.files.some((item) => {
                if (item.adjunto_file != null && item.adjunto_file != "") {
                    formData.append("avatar", item.adjunto_file);
                }
            });
            formData.append("canton_id", this.input.canton_id);
            formData.append("parroquia_id", this.input.parroquia_id);
            formData.append("first_name", this.input.first_name);
            formData.append("last_name", this.input.last_name);
            formData.append("phone", this.input.phone);
            formData.append("email", this.input.email);
            formData.append("dni", this.input.dni);
            formData.append("parroquia_id", this.input.parroquia_id);
            formData.append("roles", this.input.rol_id);

            this.loading = true;
            axios
                .post(this.urls.editar + "/" + this.input.id, formData)
                .then((response) => {
                    var data = response.data;
                    toast__.fire({
                        icon: data.status,
                        title: data.message,
                    });
                    if(data.status=="success"){
                        this.dialogClose("dialogSimple");
                    }
                })
                .catch((errors) => {
                    if(errors.response.data){
                        let arr = Object.values(errors.response.data);
                        swal__.fire(
                            "ERROR!",
                            "ha ocurrido un error: " + arr[0],
                            "error"
                        );
                    }else{
                        swal__.fire(
                            "ERROR!",
                            "ha ocurrido un error: " + errors,
                            "error"
                        );
                    }
                })
                .finally(() => {
                    this.cargarAll();
                    this.loading = false;
                });
        },
        eliminar(item) {
            let valores = {
                id: item.id,
            };
            swal__
                .fire({
                    title:
                        "¿Desea eliminar al usuario: " + item.first_name + "?",
                    type: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#18abb8",
                    cancelButtonColor: "#ED303C",
                    confirmButtonText: "Si",
                    cancelButtonText: "No",
                })
                .then((result) => {
                    if (result.value) {
                        axios
                            .post(this.urls.eliminar, valores)
                            .then((response) => {
                                var data = response.data;

                                toast__.fire({
                                    icon: data.status,
                                    title: data.message,
                                });
                            })
                            .catch((errors) => {
                                swal__.fire(
                                    "ERROR!",
                                    "ha ocurrido un error: " + errors,
                                    "error"
                                );
                            })
                            .finally(() => {
                                this.cargarAll();
                            });
                    }
                });
        },
        descargar(){
            window.open('/users-pdf','_blank');
        },
        descargarVeedores(){
            window.open('/veedores-pdf','_blank');
        },
        selectAdjunto(adjunto) {
            this.$refs[adjunto][0].click();
        },
        guardarAdjunto(e, item, index) {
            item.loadingFile = true;
            item.loading = true;
            const files = e.target.files;

            if (files[0] !== undefined) {
                item.adjunto_size = files[0].size; //bytes
                if (
                    item.adjunto_size >
                    this.$store.state.config.adjunto_limite_maximo
                ) {
                    return;
                }
                item.adjunto_nombre = files[0].name;

                if (item.adjunto_nombre.lastIndexOf(".") <= 0) {
                    return;
                }

                if (
                    !this.$store.state.soloImagenes(
                        item.adjunto_nombre.split(".")[
                            item.adjunto_nombre.split(".").length - 1
                        ]
                    )
                ) {
                    this.resetAdjunto(item, index);
                    return;
                }
                const fr = new FileReader();
                fr.readAsDataURL(files[0]);
                fr.addEventListener("load", (e) => {
                    item.adjunto_url = fr.result;
                    item.adjunto_file = files[0]; // this is an image file that can be sent to server...
                    item.loadingFile = false;
                    self.loading = false;
                });
            } else {
                item.adjunto_nombre = "";
                item.adjunto_file = null;
                item.adjunto_url = null;
                item.loadingFile = false;
                item.loading = false;
            }
        },
        resetAdjunto(item, index) {
            item.adjunto_nombre = "";
            item.adjunto_file = null;
            item.adjunto_url = null;
            item.loadingFile = false;
            item.adjunto_size = 0;
            this.loading = false;
            if (document.querySelector("#adjunto_file" + index) != null) {
                document.querySelector("#adjunto_file" + index).value = "";
            }
        },
        resetAdjuntos() {
            this.files.some((item, index) => {
                item.adjunto_nombre = "";
                item.adjunto_file = null;
                item.adjunto_url = null;
                item.loadingFile = false;
                item.adjunto_size = 0;
                this.loading = false;
                if (document.querySelector("#adjunto_file" + index) != null) {
                    document.querySelector("#adjunto_file" + index).value = "";
                }
            });
        },
        resetValues() {
            this.input = {};
            this.modificando = false;
            this.resetAdjuntos();
        },
    },
};
</script>

<style></style>
