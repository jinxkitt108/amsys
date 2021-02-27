import axios from "axios";

const state = {
    allColleges: [],
    allDegrees: [],
    degree: []
};

const getters = {
    getAllColleges: state => state.allColleges,
    getAllDegrees: state => state.allDegrees,
    getDegree: state => state.degree
};

const actions = {
    async addCollege({ commit }, college) {
        const response = await axios.post("api/college", college);
        commit("newCollege", response.data);
    },

    async fetchAllColleges({ commit }) {
        const response = await axios.get("api/college");
        commit("setAllColleges", response.data);
    },

    async fetchAllDegrees({ commit }) {
        const response = await axios.get("api/degree");
        commit("setAllDegrees", response.data);
    },

    async fetchDegree({ commit }, id) {
        const response = await axios.get("api/degree/" + id);
        commit("setDegree", response.data);
    },

    async addDegree({ commit }, degree) {
        const response = await axios.post("api/degree", degree);
        commit("newDegree", response.data);
    },

    async deleteDegree({ commit }, degree) {
        const response = await axios.delete("api/degree/" + degree.id);
        commit("removeDegree", response.data);
    },

    async addCourse({ commit }, course) {
        const response = await axios.post("api/course", course);
        commit("newCourse", response.data);
    }
};

const mutations = {
    newCollege: (state, college) => state.allColleges.unshift(college),

    newDegree: (state, degree) => {
        const index = state.allColleges.findIndex(
            college => college.id === degree.college_id
        );
        if (index !== -1) {
            state.allColleges[index].degrees.push(degree);
            state.allColleges[index].no_of_degrees =
                state.allColleges[index].no_of_degrees + 1;
        }
    },

    newCourse: (state, course) => {
        state.degree.courses.push(course);
    },

    setDegree: (state, degree) => (state.degree = degree),

    removeDegree: (state, degree) => {
        const index = state.allColleges.findIndex(
            college => college.id === degree.college_id
        );
        if (index !== -1) {
            state.allColleges[index].degrees = state.allColleges[
                index
            ].degrees.filter(item => item.id !== degree.id);
        }
    },

    setAllColleges: (state, colleges) => (state.allColleges = colleges),
    setAllDegrees: (state, degrees) => (state.allDegrees = degrees)
};

export default {
    state,
    getters,
    actions,
    mutations
};
