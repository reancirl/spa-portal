import app from "@/config/app";

export const state = () => ({
  theme: {
    dark: (app.theme && app.theme.dark == "true") || false,
  },
});

export const getters = {
  isDark: (state) => state.theme.dark,
  dark: (state) => state.theme.dark,
};

export const mutations = {
  TOGGLE_THEME(state, payload) {
    state.theme.dark = payload.dark;
    state.theme.isDark = payload.dark;
    localStorage.setItem("theme:dark", JSON.stringify(payload));
  },
};

export const actions = {
  toggle: ({ commit }, payload) => {
    commit("TOGGLE_THEME", payload);
  },
};

export default {
  namespaced: true,
  state,
  getters,
  mutations,
  actions,
};
