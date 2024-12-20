/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

//import './bootstrap';
//import { BootstrapVue, IconsPlugin } from 'bootstrap-vue'
//import 'bootstrap/dist/css/bootstrap.css'
//import 'bootstrap-vue/dist/bootstrap-vue.css'
import { createApp } from 'vue';

/**
 * Next, we will create a fresh Vue application instance. You may then begin
 * registering components with the application instance so they are ready
 * to use in your application's views. An example is included for you.
 */

const app = createApp({});

import ExampleComponent from './components/ExampleComponent.vue';
import CreateEmployeeComponent from './components/CreateEmployeeComponent.vue';
import EditEmployeeComponent from './components/EditEmployeeComponent.vue';

import ListAttemptsComponent from './components/ListAttemptsComponent.vue';

import HomeComponent from './components/HomeComponent.vue';
import AttemptView from './components/AttemptView.vue';
import LoginComponent from './components/LoginComponent.vue';

app.component('example-component', ExampleComponent);
app.component('attempt-view', AttemptView);
app.component('login-component', LoginComponent);
app.component('home-component', HomeComponent);
app.component('createemployee-component', CreateEmployeeComponent);
app.component('editemployee-component', EditEmployeeComponent);

app.component('listattempts-component', ListAttemptsComponent);


/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// Object.entries(import.meta.glob('./**/*.vue', { eager: true })).forEach(([path, definition]) => {
//     app.component(path.split('/').pop().replace(/\.\w+$/, ''), definition.default);
// });

/**
 * Finally, we will attach the application instance to a HTML element with
 * an "id" attribute of "app". This element is included with the "auth"
 * scaffolding. Otherwise, you will need to add an element yourself.
 */

app.mount('#app');
