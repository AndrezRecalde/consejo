<template>
    <div style="height: 100%">
        <div class="d-flex flex-column flex-root" style="height: 100%">
            <!--begin::Authentication - Sign-in -->
            <div
                class="d-flex flex-column flex-column-fluid bgi-position-y-bottom position-x-center bgi-no-repeat bgi-size-contain bgi-attachment-fixed"
                style="
                    background-image: url(assets/media/illustrations/sketchy-1/23.jpg;;;;
                "
            >
                <!--begin::Content-->
                <div
                    class="d-flex flex-center flex-column flex-column-fluid p-10 pb-lg-20"
                >
                    <!--begin::Logo-->
                    <!--<a href="../../demo1/dist/index.html" class="mb-12">
                        <img
                            alt="Logo"
                            src="assets/media/logos/logo-1.svg"
                            class="h-40px"
                        />
                    </a>-->
                    <!--end::Logo-->
                    <!--begin::Wrapper-->
                    <div
                        class="w-lg-500px bg-body rounded shadow-sm p-10"
                        style="width: 400px; padding: 60px 0"
                    >
                        <!--begin::Form-->
                        <v-form
                            ref="form"
                            v-model="valid"
                            lazy-validation
                            v-on:keyup.13="login()"
                            id="kt_sign_in_form"
                            class="form w-100"
                        >
                            <!--begin::Heading-->
                            <div class="text-center mb-10">
                                <!--begin::Title-->
                                <h1 class="text-dark mb-3">
                                    Acceder
                                </h1>
                                <!--end::Title-->
                                <!--begin::Link-->
                                <!-- <div class="text-gray-400 fw-bold fs-4">
                                    New Here?
                                    <a
                                        href="../../demo1/dist/authentication/layouts/basic/sign-up.html"
                                        class="link-primary fw-bolder"
                                        >Create an Account</a
                                    >
                                </div> -->
                                <!--end::Link-->
                            </div>
                            <!--begin::Heading-->
                            <!--begin::Input group-->
                            <div class="fv-row mb-2">
                                <!--begin::Label-->
                                <label
                                    class="form-label fs-6 fw-bolder text-dark"
                                    >Email</label
                                >
                                <!--end::Label-->
                                <!--begin::Input-->
                                <v-text-field
                                    v-model="valor.email"
                                    :rules="validations.email"
                                    type="email"
                                    outlined
                                    append-icon="alternate_email"
                                    required
                                    dense
                                ></v-text-field>
                                <!--end::Input-->
                            </div>
                            <!--end::Input group-->
                            <!--begin::Input group-->
                            <div class="fv-row mb-2">
                                <!--begin::Wrapper-->
                                <div class="d-flex flex-stack mb-2">
                                    <!--begin::Label-->
                                    <label
                                        class="form-label fw-bolder text-dark fs-6 mb-0"
                                        >Password</label
                                    >
                                    <!--end::Label-->
                                    <!--begin::Link-->
                                </div>
                                <!--end::Wrapper-->
                                <!--begin::Input-->
                                <v-text-field
                                    outlined
                                    v-model="valor.password"
                                    :rules="validations.password"
                                    :type="
                                        showPasswordLogin ? 'text' : 'password'
                                    "
                                    :append-icon="
                                        showPasswordLogin
                                            ? 'visibility'
                                            : 'visibility_off'
                                    "
                                    @click:append="
                                        showPasswordLogin = !showPasswordLogin
                                    "
                                    dense
                                ></v-text-field>
                                <!--end::Input-->
                            </div>
                            <!--end::Input group-->
                            <!--begin::Actions-->
                            <div class="text-center">
                                <v-btn
                                    :loading="loading"
                                    :disabled="loading"
                                    @click="login()"
                                    depressed
                                    style="
                                        width: 90%;
                                        height: 50px;
                                        justify-content: center;
                                        border-radius: 70px;
                                    "
                                    color="primary"
                                    class="white--text mb-5"
                                    ><span style="font-size: 18px"
                                        >Iniciar Sesion</span
                                    ></v-btn
                                >
                            </div>
                            <!--end::Actions-->
                        </v-form>
                        <!--end::Form-->
                    </div>
                    <!--end::Wrapper-->
                </div>
                <!--end::Content-->
                <!--begin::Footer-->

                <!--end::Footer-->
            </div>
            <!--end::Authentication - Sign-in-->
        </div>
    </div>
</template>

<script>
var swal__;
var toast__;
export default {
    components: {},
    data() {
        return {
            valid: false,
            loading: false,
            valor: { email: "", password: "" },
            urls: {
                login: "/login",
            },
            validations: {
                email: [
                    (v) => (v != null && v != "") || "El campo es obligatorio",
                ],
                password: [
                    (v) => (v != null && v != "") || "El campo es obligatorio",
                ],
            },
            repassword: null,
            showPasswordLogin: false,
            errorConfirmedPassword: "",
        };
    },
    created() {
        this.cargarValidaciones();
    },
    mounted() {
        self = this;
        swal__ = this.$store.getters.getSwal;
        toast__ = this.$store.getters.getToastDefault;
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
        login() {
            if (!this.$refs.form.validate()) return;
            try {
                let valores = {
                    email: this.valor.email,
                    password: this.valor.password,
                };
                this.loading = true;
                axios
                    .post("/login", valores)
                    .then((response) => {
                        console.log('response',response);
                        let data = response.data;
                        this.loading = false;

                        if (data.error) {
                            toast__.fire({
                                icon: "error",
                                title: data.error,
                            });
                            return;
                        }
                        this.$store.commit("setUser", data);
                        this.$store.commit("setToken", data.token);
                        this.$store.commit("setHeaders", data.token);
                        swal__.fire(
                            "Bienvenido",
                            "Se ha iniciado sesión exitosamente",
                            "success"
                        );
                        setTimeout(() => {
                            window.location.href = "/perfil";
                        }, 1000);
                    })
                    .catch(function (error) {
                        if (error.response) {
                            console.log(error.response.data);
                            console.log(error.response.status);
                            console.log(error.response.headers);
                            swal__.fire(
                                "Hubo un error",
                                error.response.data.error,
                                "error"
                            );
                        }
                    })
                    .finally(() => {
                        this.loading = false;
                    });
            } catch (errors) {
                console.log(errors);
                swal__.fire(
                    "ERROR!",
                    errors.response.data.error || errors.message,
                    "error"
                );
            }
        },
    },
};
</script>

<style></style>
