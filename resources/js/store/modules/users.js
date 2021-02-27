import axios from "axios";

const state = {
    auth_user: []
}

const getters = {
    getAuthUser: (state) => state.auth_user
}

const actions = {
    async fetchAuthUser({commit}) {
        const response =  await axios.get('api/auth_user');
        commit('setAuthUser', response.data)
    }
}

const mutations = {
    setAuthUser: (state, user) => state.auth_user = user
}

export default {
    state,
    getters,
    actions,
    mutations
};
