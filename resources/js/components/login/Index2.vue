 
<template>
	<div>
		<center>
			<div class="login-background" style="width: 400px; padding: 60px 0">
				<v-form
					ref="form"
					v-model="valid"
					lazy-validation
					style="
						padding: 40px 45px 40px;
						background-color: #fff;
						border-radius: 20px;
					"
					v-on:keyup.13="login()"
					id="form-login"
					method="POST"
					action="/login"
				>
					<h2 style="text-align: left" class="mb-2">Login</h2>
					<div style="display: flex">
						<v-divider
							:style="{
								flex: '0.15 0 1px',
								height: '150px',
								border: '1px solid ' + $vuetify.theme.currentTheme.primary,
								'margin-top': '-1px',
							}"
						></v-divider>
						<v-divider></v-divider>
					</div>
					<br /><br />
					<v-text-field
						:color="$vuetify.theme.currentTheme.primary"
						v-model="valor.email"
						:rules="validations.email"
						name="email"
						type="email"
						outlined
						label="EMAIL"
						append-icon="alternate_email"
						required
						dense
					></v-text-field>
					<!-- $store.state.validEmail(v) -->

					<v-text-field
						:color="$vuetify.theme.currentTheme.primary"
						outlined
						name="password"
						v-model="valor.password"
						:rules="validations.password"
						:type="showPasswordLogin ? 'text' : 'password'"
						:append-icon="showPasswordLogin ? 'visibility' : 'visibility_off'"
						@click:append="showPasswordLogin = !showPasswordLogin"
						required
						label="CONTRASEÑA"
						dense
					></v-text-field>

					<v-chip
						:loading="loading"
						:disabled="loading"
						@click="login()"
						style="
							width: 100%;
							height: 54px;
							justify-content: center;
							border-radius: 70px;
						"
						:color="$vuetify.theme.currentTheme.primary"
						class="white--text mb-5"
						><span style="font-size: 18px">Iniciar Sesion</span></v-chip
					>
					<!-- <div class="mb-2">
						<NuxtLink
							:to="$store.state.routes.pages.registro"
							:style="{ color: $vuetify.theme.currentTheme.primary }"
							>Registrarse</NuxtLink
						>
					</div> -->
					<!-- <div class="mb-2">
						<a
							@click="olvidar()"
							:style="{ color: $vuetify.theme.currentTheme.primary }"
							class="mb-5"
							>Olvidé mi Contraseña</a
						>
					</div> -->
				</v-form>
			</div>
		</center>
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
			urls:{
				login:'/login'
			},
			validations: {
				email: [(v) => (v != null && v != "") || "El campo es obligatorio"],
				password: [(v) => (v != null && v != "") || "El campo es obligatorio"],
			},
			repassword: null,
			showPasswordLogin: false,
			errorConfirmedPassword: "",
		};
	},
	created() {
	},
	mounted() {
		document.querySelector(".v-application").style.backgroundImage =
			"url('https://p4.wallpaperbetter.com/wallpaper/771/657/298/wallpaper-of-road-wallpaper-preview.jpg')";
		document.querySelector(".v-application").style.backgroundSize = "cover";
		document.querySelector(".v-application").style.backgroundRepeat = "no-repeat";
		//$('.v-application').css('background','');

		self = this;
		swal__ = this.$store.getters.getSwal;
		toast__ = this.$store.getters.getToastDefault;
	},
	methods: {
		async login() {
			if (!this.$refs.form.validate()) return;
			try {
				let valores = {
					email: this.valor.email,
					password: this.valor.password,
				};
				this.loading = true;
				await axios
					.post(this.urls.login, valores)
					.then((response) => {
						let data = response.data;
						this.loading = false;

						if (data.error) {
							toast__.fire({
								icon: "error",
								title: data.error,
							});
							return;
						}
						swal__.fire(
							"Bienvenido",
							"Se ha iniciado sesión exitosamente",
							"success"
						);
						window.location.href = '/dashboard/proyectos'
					}).finally(()=>{
						this.loading = false;
					});
			} catch (errors) {
				swal__.fire(
					"ERROR!",
					errors.response.data.error || errors.message,
					"error"
				);
			}
		},
		async olvidar() {
			var inputValue = "";

			await swal__.fire({
				title: "Recuperar Contraseña",
				text: "Le llegará un correo con la nueva contraseña",
				input: "text",
				inputLabel: "Le llegará un correo con la nueva contraseña",
				inputValue: inputValue,
				showCancelButton: true,
				confirmButtonColor: this.$vuetify.theme.currentTheme.primary,
				cancelButtonColor: this.$vuetify.theme.currentTheme.cancel,
				confirmButtonText: "Enviar",
				cancelButtonText: "Cancelar",
				inputValidator: (value) => {
					if (!value) {
						return "Necesitas ingresar un email";
					} else {
						if (value == "") return "Ingrese un email";

						let valores = {
							email: value,
						};
						this.$axios
							.post(this.$store.state.routes.http.olvidoContrasena, valores)
							.then((response) => {
								var data = response.data;
								if (typeof data.error !== "undefined") {
									toast__.fire({
										icon: "error",
										title: data.error + " #" + data.code,
									});
									return;
								}
								toast__.fire({
									icon: data.response.status,
									title: data.response.message,
								});
							})
							.catch((errors) => {
								swal__.fire("ERROR!", "Ha ocurrido un error: " + errors, "error");
							})
							.finally(() => {});
					}
				},
			});
			return;
		},
	},
};
</script>
