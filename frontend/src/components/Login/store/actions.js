import apiAuthService from "@/services/api/modules/authService";

export default {
  async login({ commit }, auth) {
    commit("SET_ERR", null);
    const { status, data } = await apiAuthService.login(auth);

    if (status !== 200) {
      commit("SET_ERR", data.message);
    } else {
      localStorage.token = data.access_token;
      localStorage.user = JSON.stringify(data.user);

      commit("SET_AUTH", {
        access_token: data.access_token,
        user: JSON.stringify(data.user),
      });

      commit("SET_ERR", null);
    }
  },
  async logout({ commit, dispatch }, auth) {
    commit("SET_ERR", null);
    const { status, data } = await apiAuthService.logout(auth);

    if (status !== 200) {
      dispatch(
        "snackbar/show",
        {
          text: data.message,
        },
        {
          root: true,
        }
      );
    } else {
      localStorage.removeItem("token");
      localStorage.removeItem("user");

      commit("SET_AUTH", {
        access_token: false,
        user: {},
      });
    }
  },
};
