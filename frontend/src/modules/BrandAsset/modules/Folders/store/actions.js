import apiAssetsService from "@/services/api/modules/assetsService";

export default {
  async getFolders({ commit }, page = {}) {
    commit("SET_FOLDERS", []);
    const { status, data } = await apiAssetsService.getFolders(page.page, page.per_page, page.q);

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

      commit("SET_FOLDERS", responseData);
    }
  },
  async getFolder({ commit }, id) {
    commit("SET_FOLDER", null);
    const { status, data } = await apiAssetsService.getFolder(id);

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
      commit("SET_FOLDER", data.data);
    }
  },
  async save({ dispatch, commit }, details) {
    commit("SET_FOLDER", null);
    if (details.id) {
      var { status, data } = await apiAssetsService.updateFolder(details.id, details.data);
    } else {
      var { status, data } = await apiAssetsService.createFolder(details.data);
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

      commit("SET_FOLDER", data.data);
    }
  },
  async deleteFolder({ dispatch }, id) {
    const { status, data } = await apiAssetsService.deleteFolder(id);

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
      dispatch("getFolders");
    }
  },
};
