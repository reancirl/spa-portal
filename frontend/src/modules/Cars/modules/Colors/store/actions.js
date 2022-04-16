import apiColorsService from "@/services/api/modules/colorsService";

export default {
  async list({ commit, dispatch }, page = {}) {
    commit("SET_COLORS", []);
    const { status, data } = await apiColorsService.list(page.page, page.per_page, page.q);

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
      commit("SET_COLORS", responseData);
    }
  },
  async getColor({ commit, dispatch }, id) {
    commit("SET_COLOR", null);
    const { status, data } = await apiColorsService.getColor(id);

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
        commit("SET_COLOR", data.data);
    }
  },
  async save({ commit, dispatch }, payload) {
    if (payload.id) {
      var { status, data } = await apiColorsService.update(payload.data, payload.id);
    } else {
      var { status, data } = await apiColorsService.create(payload.data);
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

      commit("SET_COLOR", data.data[0]);
    }
  },
  async delete({ commit, dispatch }, payload) {
    const { status, data } = await apiColorsService.delete(payload);
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
