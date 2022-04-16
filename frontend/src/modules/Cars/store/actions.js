import apiVariantsService from "@/services/api/modules/variantsService";

export default {
  async list({ commit, dispatch }, page = {}) {
    commit("SET_VARIANTS", []);
    const { status, data } = await apiVariantsService.list(page.page, page.per_page, page.q, page.model);

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

      commit("SET_VARIANTS", responseData);
    }
  },
  async getVariant({ commit, dispatch }, id) {
    commit("SET_VARIANT", null);
    const { status, data } = await apiVariantsService.getVariant(id);

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
      commit("SET_VARIANT", data.data);
    }
  },
  async save({ commit, dispatch }, payload) {
    if (payload.id) {
      var { status, data } = await apiVariantsService.update(payload.data, payload.id);
    } else {
      var { status, data } = await apiVariantsService.create(payload.data);
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

      commit("SET_VARIANT", data.data);
    }
  },
  async delete({ commit, dispatch }, payload) {
    const { status, data } = await apiVariantsService.delete(payload);
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
