import axios from "axios";

const state = {
    allStaffs: []
}

const getters = {
    getAllStaffs: state => state.allStaffs
}

const actions = {
    async addStaff({ commit}, staff) {
        const response = await axios.post('api/job_order', staff);
        commit('newStaf', response.data)
    },

    async fetchAllStaffs({commit}) {
        const response =  await axios.get('api/job_order');
        commit('setAllStaffs', response.data)
    }
}

const mutations = {
    setAllStaffs: (state, staffs) => state.allStaffs = staffs,
    newStaf: (state, staff) => state.allStaffs.unshift(staff)
}

export default {
    state,
    getters,
    actions,
    mutations
};
