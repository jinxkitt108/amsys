import axios from "axios";

const state = {
    allClassLevels: [],
    classLevel: []
};

const getters = {
    getAllClassLevels: state => state.allClassLevels,
    getClassLevel: state => state.classLevel
};

const actions = {
    async fetchAllClassLevels({ commit }) {
        const response = await axios.get("api/class_level");
        commit("setAllClassLevels", response.data);
    },

    async addClassLevel({ commit }, class_level) {
        const response = await axios.post("api/class_level", class_level);
        commit("newClassLevel", response.data);
    },

    async fetchClassLevel({ commit }, class_level) {
        const response = await axios.get("api/class_info/" + class_level.id);
        commit("setClassLevel", response.data);
    }
};

const mutations = {
    setAllClassLevels: (state, class_levels) =>
        (state.allClassLevels = class_levels),

    setClassLevel: (state, class_level) => (state.classLevel = class_level),

    newClassLevel: (state, class_level) =>
        state.allClassLevels.unshift(class_level)
};

export default {
    state,
    getters,
    actions,
    mutations
};
