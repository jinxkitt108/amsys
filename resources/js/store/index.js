import Vue from "vue";
import Vuex from "vuex";

//Modules
import users from "./modules/users";
import instructors from "./modules/instructors";
import job_orders from "./modules/job_orders";
import classes from "./modules/classes";
import attendance from "./modules/attendance";
import managements from "./modules/managements";

//Load Vuex
Vue.use(Vuex);

//Create the Store
export default new Vuex.Store({
    modules: {
        users,
        instructors,
        job_orders,
        classes,
        attendance,
        managements
    }
});
