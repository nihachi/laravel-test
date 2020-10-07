/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */
require("./bootstrap");

import Vue from "vue";
import VueRouter from "vue-router";
import Vuex from "vuex";
import { routes } from "./routes";
import StoreData from "./store/index";
import { initialize } from "./helpers/general";
import MainApp from "./Main";

// Vue Select
import vSelect from "vue-select";
import "vue-select/dist/vue-select.css";
Vue.component("v-select", vSelect);

Vue.use(VueRouter);
Vue.use(Vuex);

Vue.prototype.$http = window.axios;

const store = new Vuex.Store(StoreData);
const router = new VueRouter({
    mode: "history",
    routes
});

initialize(store, router);

const app = new Vue({
    el: "#app",
    router,
    store,
    components: {
        MainApp
    }
});
