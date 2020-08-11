/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');

import { EventBus }    from "./helpers/event-bus.js";
import VeeValidate from 'vee-validate';

const veeconfig = {
    aria: true,
    classNames: {
        touched: 'touched',
        untouched: 'untouched',
        valid: 'is-success',
        invalid: 'is-danger',
        pristine: 'pristine',
        dirty: 'dirty'
    },
    classes: true,
    delay: 5,
    dictionary: null,
    errorBagName: 'errors',
    events: 'blur',
    fieldsBagName: 'fields',
    i18n: null,
    i18nRootKey: 'validations',
    inject: true,
    locale: 'en',
    validity: false
};

Vue.use(VeeValidate, veeconfig);

VeeValidate.Validator.extend('verify_password', {
    getMessage: (field) => `The password must contain at least: 1 uppercase letter, 1 lowercase letter, 1 number, and one special character (E.g. , . _ & ? etc)`,
    validate: value => {
        var strongRegex = new RegExp("^(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*[!@#\$%\^&\*])(?=.{8,})");
        return strongRegex.test(value);
    }
});

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

Vue.component('alerts', require("./components/alerts.vue").default);
Vue.component('auth-login', require('./components/login.vue').default);
Vue.component('invite', require('./components/invite.vue').default);
Vue.component('navbar', require('./components/navbar.vue').default);
Vue.component('register', require('./components/register.vue').default);
Vue.component('user-dashboard', require('./components/dashboard.vue').default);
Vue.component('user-module', require('./components/module.vue').default);
Vue.component('user-modules', require('./components/modules.vue').default);
Vue.component('modal', require('./components/modal.vue').default);

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

const app = new Vue({
    el: '#app',
    data() {
        return {
            grades: [],
            modal: null,
            permissions: []
        }
    },
    mounted() {
        this.grades = window.grades;
        this.permissions = window.permissions;
    },
    methods: {
        hasCompleted(assignment) {
            return this.grades.filter((grade) => {
                return grade.assignment_id === assignment;
            }).length > 0;
        },
        hasPermission(name) {
            return this.permissions.filter((permission) => {
                return permission.name === name;
            }).length > 0;
        },
        openModal(name, data = null) {
            this.modal = name;
            if (data) {
                EventBus.$emit("modal-add-data", data);
            }
        },
        showAlert(type, message) {
            window.scrollTo(0, 0);
            EventBus.$emit("alert-add-data", {
                type,
                message
            });
        }
    }
});
