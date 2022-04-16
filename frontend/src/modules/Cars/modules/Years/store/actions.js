import apiModelYearsService from "@/services/api/modules/modelYearsService";

export default {
  async list({ commit, dispatch }, page = {}) {
    commit("SET_YEARS", []);
    const { status, data } = await apiModelYearsService.list(page.page, page.per_page, page.q);

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

      commit("SET_YEARS", responseData);
    }
  },
  async getYearModel({ commit, dispatch }, id) {
    commit("SET_YEAR", null);
    const { status, data } = await apiModelYearsService.getYear(id);

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
      commit("SET_YEAR", data.data);
    }
  },
  async save({ commit, dispatch }, payload) {
    if (payload.id) {
      var { status, data } = await apiModelYearsService.update(payload.data, payload.id);
    } else {
      var { status, data } = await apiModelYearsService.create(payload.data);
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

      commit("SET_YEAR", data.data[0]);
    }
  },
  async delete({ commit, dispatch }, payload) {
    const { status, data } = await apiModelYearsService.delete(payload);
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
