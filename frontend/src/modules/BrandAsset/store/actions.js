import apiAssetsService from "@/services/api/modules/assetsService";

export default {
  async getCategoryFolders({ commit }, id) {
    commit("SET_FOLDERS", []);
    const { status, data } = await apiAssetsService.getCategoryFolders(id);

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
      commit("SET_FOLDERS", data.data);
    }
  },
  async getFolderAssets({ commit }, asset) {
    commit("SET_BRANDASSETS", []);
    const { status, data } = await apiAssetsService.getFolderAssets(
      asset.id,
      asset.page,
      asset.limit
    );

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
      commit("SET_BRANDASSETS", data);
    }
  },
  async getUploadCategoryFolders({ commit }, id) {
    commit("SET_UPLOADFOLDERS", []);
    const { status, data } = await apiAssetsService.getCategoryFolders(id);

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
      commit("SET_UPLOADFOLDERS", data.data);
    }
  },
  async getStorage({ commit }, id) {
    commit("SET_STORAGE", []);
    const { status, data } = await apiAssetsService.getStorage(id);

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
      commit("SET_STORAGE", data.data);
    }
  },
  async getCategories({ commit }, id) {
    commit("SET_CATEGORIES", []);
    const { status, data } = await apiAssetsService.getCategories(id);

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
      commit("SET_CATEGORIES", data.data);
    }
  },
};
