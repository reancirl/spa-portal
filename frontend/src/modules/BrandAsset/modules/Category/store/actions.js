import apiAssetsService from "@/services/api/modules/assetsService";

export default {
  async getCategories({ commit }, page = {}) {
    commit("SET_CATEGORIES", []);
    const { status, data } = await apiAssetsService.getCategories(page.page, page.per_page, page.q);

    if (status !== 200) {
      dispatch(
        "snackbar/show",
        {
          text: data.message,
          timeout: 10000,
        },
        {
          root: true,
        }
      );
    } else {
      let responseData = Object.keys(page).length === 0 ? data.data : data;

      commit("SET_CATEGORIES", responseData);
    }
  },
  async getCategory({ commit }, id) {
    commit("SET_CATEGORY", null);
    const { status, data } = await apiAssetsService.getCategory(id);

    if (status !== 200) {
      dispatch(
        "snackbar/show",
        {
          text: data.message,
          timeout: 10000,
        },
        {
          root: true,
        }
      );
    } else {
      commit("SET_CATEGORY", data.data);
    }
  },
  async save({ dispatch, commit }, details) {
    if (details.id) {
      var { status, data } = await apiAssetsService.updateCategory(details.id, details.data);
    } else {
      var { status, data } = await apiAssetsService.createCategory(details.data);
    }

    if (status !== 200) {
      dispatch(
        "snackbar/show",
        {
          text: data.message,
          timeout: 10000,
        },
        {
          root: true,
        }
      );
    } else {
      dispatch(
        "snackbar/show",
        {
          text: data.message,
          timeout: 10000,
        },
        {
          root: true,
        }
      );

      commit("SET_CATEGORY", data.data);
    }
  },
};
