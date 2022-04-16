import apiDealerGroupsService from "@/services/api/modules/dealerGroupsService";

export default {
  async list({ dispatch, commit }, id) {
    commit("SET_DEALERGROUPS", []);
    const { status, data } = await apiDealerGroupsService.list(id);

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
      let finalData = data.data;

      // finalData.unshift({
      //   id: null,
      //   name: "All DEALERS",
      //   status: true,
      // });
      commit("SET_DEALERGROUPS", data.data);
    }
  },
};
