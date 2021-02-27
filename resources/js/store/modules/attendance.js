import axios from "axios";

const state = {
    allAttendance: [],
    allEmployee: [],
    logs: []
};

const getters = {
    getAllAttendance: state => state.allAttendance,
    getAllEmployee: state => state.allEmployee,
    getLogs: state => state.logs
};

const actions = {
    async fetchAllAttendance({ commit }) {
        const response = await axios.get("api/attendance");
        commit("setAllAttendance", response.data);
    },

    async fetchAllEmployee({ commit }) {
        const response = await axios.get("api/employee");
        commit("setAllEmployee", response.data);
    },

    async fetchLogs({ commit }) {
        const response = await axios.get("api/logs");
        commit("setLogs", response.data);
    },

    async addAttendance({ commit }, attendance) {
        await axios
            .post("api/attendance", attendance)
            .then(response => {
                commit("newAttendance", response.data);
                if (attendance.time_out) {
                    Swal.fire(
                        "Good job!",
                        "You successfully TIMED OUT!",
                        "success"
                    );
                } else {
                    Swal.fire(
                        "Good job!",
                        "You successfully TIMED IN!",
                        "success"
                    );
                }
            })
            .catch(err => {
                console.log(err.response.data);
                if (err.response.data.errors.status) {
                }
                Swal.fire({
                    icon: "question",
                    title: "Oops...",
                    text: err.response.data.errors.status[0]
                });
            });
    },

    async fetchLogSet({ commit }, date) {
        const response = await axios.post("api/logset", {
            date: date
        });
        commit("setLogs", response.data);
    }
};

const mutations = {
    setAllAttendance: (state, attendance) => {
        attendance.forEach(item => {
            state.allAttendance.push({
                id: item.id,
                employee_id: item.employee_id,
                name: item.employee.name,
                position: item.employee.position_title,
                in: item.time_in,
                out: item.time_out,
                status: item.status,
                hours: item.total_hours
            });
        });
    },
    setAllEmployee: (state, employees) => (state.allEmployee = employees),
    setLogs: (state, logs) => (state.logs = logs),
    newAttendance: (state, attendance) => {
        state.allAttendance.unshift({
            id: attendance.id,
            employee_id: attendance.employee_id,
            name: attendance.employee.name,
            position: attendance.employee.position_title,
            in: attendance.time_in,
            out: attendance.time_out,
            status: attendance.status
        });
        state.logs.push(attendance.log);
    }
};

export default {
    state,
    getters,
    actions,
    mutations
};
