import axios from "axios";

const state = {
    allInstructors: [],
    instructor: []
}

const getters = {
    getAllInstructors: state => state.allInstructors,
    getInstructor: state => state.instructor
}

const actions = {
    async addInstructor({ commit}, instructor) {
        const response = await axios.post('api/instructor', instructor);
        commit('newInstructor', response.data)
    },

    async fetchAllInstructors({commit}) {
        const response =  await axios.get('api/instructor');
        commit('setAllInstructors', response.data)
    },

    async fetchInstructor({commit}, id) {
        const response =  await axios.get('api/instructor/' + id);
        commit('setInstructor', response.data)
    }
}

const mutations = {
    setAllInstructors: (state, instructors) => state.allInstructors = instructors,
    newInstructor: (state, instructor) => state.allInstructors.unshift(instructor),
    setInstructor: (state, instructor) => state.instructor = instructor
}

export default {
    state,
    getters,
    actions,
    mutations
};
