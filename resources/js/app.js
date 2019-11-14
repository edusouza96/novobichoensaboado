/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require("./bootstrap");
require("./env");
require("./loading");

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

import VuejsDialog from 'vuejs-dialog';
import 'vuejs-dialog/dist/vuejs-dialog.min.css';
Vue.use(VuejsDialog);

Vue.component("diary-table", require("./components/diary-table.vue").default);

Vue.component("modal-clients", require("./components/ModalClients.vue").default);

Vue.component("modal-services-pet", require("./components/ModalServicesPet.vue").default);

Vue.component("modal-services-vet", require("./components/ModalServicesVet.vue").default);

Vue.component("modal-observation", require("./components/ModalObservation.vue").default);

Vue.component("modal-pets-by-owner", require("./components/modal-pets-by-owner.vue").default);

Vue.component("modal-finish-pay", require("./components/modal-finish-pay.vue").default);

Vue.component("modal-open-cashdesk", require("./components/ModalOpenCashdesk.vue").default);

Vue.component("modal-close-cashdesk", require("./components/ModalCloseCashdesk.vue").default);

Vue.component("modal-extract-day", require("./components/ModalExtractDay.vue").default);

Vue.component("alert-message", require("./components/alert-message.vue").default);

Vue.component("modal-contribute", require("./components/modal-contribute.vue").default);

Vue.component("modal-bleed", require("./components/modal-bleed.vue").default);

Vue.component("modal-money-transfer", require("./components/modal-money-transfer.vue").default);

Vue.component("table-outlay-to-pay", require("./components/table-outlay-to-pay.vue").default);

Vue.component("modal-pay-outlay", require("./components/modal-pay-outlay.vue").default);