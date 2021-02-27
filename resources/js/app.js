/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require("./bootstrap");

window.Vue = require("vue");
window.Swal = require("sweetalert2");
window.Fire = new Vue();
window.Form = Form;
import Vuetify from "vuetify";
import Routes from "@/js/routes.js";
import App from "@/js/views/App";
import { Form, HasError, AlertError } from "vform";
import moment from "moment";
import store from "./store/";
import { Ripple } from "vuetify/lib/directives";
import Swal from "sweetalert2";
import adapter from "webrtc-adapter";
import VueQrcode from "@chenfengyuan/vue-qrcode";
import { WebCam } from "vue-cam-vision";
import { QrcodeStream, QrcodeDropZone, QrcodeCapture } from "vue-qrcode-reader";
import interceptorsSetup from "./interceptor";
import VueClock from "@dangvanthanh/vue-clock";

// INTERCEPTOR AXIOS
interceptorsSetup();

//Plugin Components
Vue.component("vue-clock", VueClock);
Vue.component(VueQrcode.name, VueQrcode);
Vue.component("WebCam", WebCam);

Vue.component(QrcodeStream.name, QrcodeStream);
Vue.component(QrcodeDropZone.name, QrcodeDropZone);
Vue.component(QrcodeCapture.name, QrcodeCapture);

// Front-end Access Control
import Gate from "./Gate";

//Window Plug in

// VUETIFY
Vue.use(Vuetify, {
    // other stuff
    directives: {
        Ripple
    }
});

Vue.prototype.$gate = new Gate(window.user);
Vue.filter("longDate", function(created) {
    return moment(created).format("MMMM D, YYYY");
});
Vue.filter("dayDate", function(created) {
    return moment(created).format("MMMM D, YYYY");;
});
Vue.filter("shortDate", function(created) {
    return moment(created).format("lll");
});
Vue.filter("sinceDate", function(created) {
    return moment(created).fromNow();
});
Vue.filter("timeLong", function(created) {
    return moment(created).format("LTS");
});

Vue.filter("timeShort", function(created) {
    return moment(created).format("LT");
});

//Toast
const Toast = Swal.mixin({
    toast: true,
    position: "top-end",
    showConfirmButton: false,
    timer: 3000,
    timerProgressBar: true,
    onOpen: toast => {
        toast.addEventListener("mouseenter", Swal.stopTimer);
        toast.addEventListener("mouseleave", Swal.resumeTimer);
    }
});
window.Toast = Toast;
window.moment = moment;

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))

Vue.component(
    "example-component",
    require("./components/ExampleComponent.vue").default
);

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

const app = new Vue({
    el: "#app",
    router: Routes,
    store,
    render: h => h(App),
    vuetify: new Vuetify({
        theme: {
            themes: {
                light: {},
                dark: {}
            }
        }
    })
});

export default app;
