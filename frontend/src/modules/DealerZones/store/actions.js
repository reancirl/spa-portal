import apiDealerZonesService from "@/services/api/modules/dealerZonesService";

export default {
  async getZones({ commit }, page = {}) {
    commit("SET_ZONES", []);

    const { status, data } = await apiDealerZonesService.getZones(page.per_page);

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

      commit("SET_ZONES", responseData);
    }
  },
  async getZone({ commit }, id) {
    commit("SET_ZONE", null);
    const { status, data } = await apiDealerZonesService.getZone(id);

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
      commit("SET_ZONE", data.data);
    }
  },
  async save({ dispatch, commit }, details) {
    if (details.id) {
      var { status, data } = await apiDealerZonesService.update(details.id, details.data);
    } else {
      var { status, data } = await apiDealerZonesService.create(details.data);
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

      commit("SET_ZONE", data.data);
    }
  },
  async delete({ dispatch }, id) {
    const { status, data } = await apiDealerZonesService.delete(id);

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
      dispatch("getItems");
    }
  },
};
