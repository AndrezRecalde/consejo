/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */
require("./bootstrap");
import $ from "jquery";
//window.Vue = require('vue')
import Vue from "vue";
// var moment = require('moment')
// require("moment-duration-format");
// import 'moment/locale/es'
// Vue.prototype.moment = moment
import VueRouter from "vue-router";
import Vuetify from "vuetify";
import "vuetify/dist/vuetify.min.css";
// import '@sass/appvue.scss'

import store from "./src/plugins/vuex/store/index";
import routes from "./src/plugins/router/index";
import vuetify from "./src/plugins/vuetify/index";

Vue.use(VueRouter);
Vue.use(Vuetify);

const router = new VueRouter({
    base: "",
    routes: routes,
    mode: "history",
});

const app = new Vue({
    router,
    store,
    vuetify,
    data() {
        return {
            drawer: false,
        };
    },
    created(){
        window.axios.defaults.headers.common['Authorization'] = store.getters.getUser.token; 
    },
    mounted: function () {
        $(".v-application").css("display", "");
    },
    methods: {
        logout() {
            window.location.href = "/logout";
        },
    },
}).$mount("#app");
