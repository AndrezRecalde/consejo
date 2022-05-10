<template>
    <div>
        <div class="card mb-5 mb-xxl-8">
            <div class="card-header">
                <div class="card-title m-0">
                    <h3 class="fw-bolder m-0">
                        Veedor: {{ veedor.first_name }}
                    </h3>
                </div>
            </div>
            <div class="card-body pt-9 pb-8">
                <div class="card mb-5 mb-xxl-8">
                    <v-row>
                        <v-col cols="12">
                            <label style="width: 200px">Nombre</label>
                            <strong>{{ veedor.first_name }}</strong>
                        </v-col>
                        <v-col cols="12">
                            <label style="width: 200px">Apellido</label>
                            <strong>{{ veedor.last_name }}</strong>
                        </v-col>
                        <v-col cols="12">
                            <label style="width: 200px">Dni</label>
                            <strong>{{ veedor.dni }}</strong>
                        </v-col>
                        <v-col cols="12">
                            <label style="width: 200px">Teléfono</label>
                            <strong>{{ veedor.phone }}</strong>
                        </v-col>
                        <v-col cols="12">
                            <label style="width: 200px">Email</label>
                            <strong>{{ veedor.email }}</strong>
                        </v-col>
                        <v-col v-if="veedor.nombre_parroquia" cols="12">
                            <label style="width: 200px">Parroquia</label>
                            <strong>{{ veedor.nombre_parroquia }}</strong>
                        </v-col>
                        <v-col v-if="veedor.nombre_recinto" cols="12">
                            <label style="width: 200px">Recinto</label>
                            <strong>{{ veedor.nombre_recinto }}</strong>
                        </v-col>
                    </v-row>
                </div>
            </div>
        </div>
        <v-row>
            <v-col cols="12" lg="6" md="6" sm="12">
                <div class="card mb-5 mb-xxl-8">
                    <div class="card-header">
                        <div class="card-title m-0">
                            <h3 class="fw-bolder m-0">Imagen frontal</h3>
                        </div>
                    </div>
                    <div class="card-body pt-9 pb-8">
                        <div class="card mb-5 mb-xxl-8">
                            <img width="200" class="ma-auto" style="background-size: cover;"
                                :src="'/storage' + veedor.imagen_frontal"
                            />
                        </div>
                    </div>
                </div>
            </v-col>
            <v-col cols="12" lg="6" md="6" sm="12">
                <div class="card mb-5 mb-xxl-8">
                    <div class="card-header">
                        <div class="card-title m-0">
                            <h3 class="fw-bolder m-0">Imagen reverso</h3>
                        </div>
                    </div>
                    <div class="card-body pt-9 pb-8">
                        <div class="card mb-5 mb-xxl-8">
                            <img width="200" class="ma-auto" style="background-size: cover;"
                                :src="'/storage' + veedor.imagen_reverso"
                            />
                        </div>
                    </div>
                </div>
            </v-col>
        </v-row>
    </div>
</template>

<script>
export default {
    data() {
        return {
            veedor: {},
            urls: {
                cargar: "/api/show/veedor",
            },
        };
    },
    created() {
        this.cargar();
    },
    methods: {
        cargar() {
            let valores = { id: this.$route.params.id };
            axios
                .post(this.urls.cargar, valores)
                .then(async (response) => {
                    var data = response.data;
                    this.veedor = data.veedor;
                })
                .catch((errors) => {});
        },
    },
};
</script>

<style></style>
