import api from "@/services/api/baseService";

class apiDealerGroupsService {
  list() {
    return api
      .get("/dealers", {
        headers: {
          Authorization: `Bearer ${localStorage.token}`,
        },
      })
      .then((response) => response)
      .catch((error) => error.response);
  }
}

export default new apiDealerGroupsService();
