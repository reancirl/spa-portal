import apiNewsService from "@/services/api/modules/newsService";

export default {
  async list({ commit, dispatch }, auth) {
    const { status, data } = await apiNewsService.list();

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
      commit("SET_NEWS", data.data);
    }
  },
};
