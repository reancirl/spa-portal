import apiModelsService from "@/services/api/modules/modelsService";

export default {
  async list({ commit, dispatch }, page = {}) {
    commit("SET_MODELS", []);
    const { status, data } = await apiModelsService.list(page.page, page.per_page, page.q);

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
      let responseData = (Object.keys(page).length === 0) ? data.data : data;
      commit("SET_MODELS", responseData);
    }
  },
  async getModel({ commit, dispatch }, id) {
    commit("SET_MODEL", null);
    const { status, data } = await apiModelsService.getModel(id);

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
        commit("SET_MODEL", data.data);
    }
  },
  async save({ commit, dispatch }, payload) {
    if (payload.id) {
      var { status, data } = await apiModelsService.update(payload.data, payload.id);
    } else {
      var { status, data } = await apiModelsService.create(payload.data);
    }
    const errorMessage = data.errors ? Object.values(data.errors).join(' ') : data.message;
    if (status !== 200) {
      dispatch(
        "snackbar/show",
        {
          text: errorMessage,
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
        },
        {
          root: true,
        }
      );

      commit("SET_MODEL", data.data[0]);
    }
  },
  async delete({ commit, dispatch }, payload) {
    const { status, data } = await apiModelsService.delete(payload);
    if (status !== 200) {
      const errorMessage = data.errors ? Object.values(data.errors).join(' ') : data.message;
      dispatch(
        "snackbar/show",
        {
          text: errorMessage,
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
        },
        {
          root: true,
        }
      );
    }
  },
};
