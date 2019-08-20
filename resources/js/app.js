/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require("./bootstrap");
require("./env");

$.ajaxSetup({
    headers: {
        "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
    }
});

$(function () {
    $('[data-toggle="tooltip"]').tooltip()
});


window.moment = require('moment');
window.Vue = require("vue");

import Notifications from 'vue-notification';
Vue.use(Notifications)

import Datetime from 'vue-datetime';
import 'vue-datetime/dist/vue-datetime.css';
Vue.use(Datetime);

import money from 'v-money'
Vue.use(money, {precision: 2})

import VueBootstrapTypeahead from 'vue-bootstrap-typeahead';
Vue.component('vue-bootstrap-typeahead', VueBootstrapTypeahead);

Vue.component("diary-table", require("./components/DiaryTable.vue").default);

Vue.component("modal-clients", require("./components/ModalClients.vue").default);

Vue.component("modal-services-pet", require("./components/ModalServicesPet.vue").default);

Vue.component("modal-services-vet", require("./components/ModalServicesVet.vue").default);

Vue.component("modal-observation", require("./components/ModalObservation.vue").default);

Vue.component("modal-pets-by-owner", require("./components/ModalPetsByOwner.vue").default);

Vue.component("modal-finish-pay", require("./components/ModalFinishPay.vue").default);

Vue.component("modal-open-cashdesk", require("./components/ModalOpenCashdesk.vue").default);

