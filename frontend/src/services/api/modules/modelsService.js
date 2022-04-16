import api from "@/services/api/baseService";

class apiModelsService {
  list(page, per_page, q) {
    return api
      .get("/models", {
        headers: {
          Authorization: `Bearer ${localStorage.token}`,
        },
        params: {
          page,
          per_page,
          q
        }
      })
      .then((response) => response)
      .catch((error) => error.response);
  }
  getModel(id) {
    return api
      .get(`/models/${id}`, {
        headers: {
          Authorization: `Bearer ${localStorage.token}`,
        },
      })
      .then((response) => response)
      .catch((error) => error.response);
  }
  create(model) {
    return api
      .post("/models", model, {
        headers: {
          Authorization: `Bearer ${localStorage.token}`,
        },
      })
      .then((response) => response)
      .catch((error) => error.response);
  }
  update(model, id) {
    return api
      .put(`/models/${id}`, model, {
        headers: {
          Authorization: `Bearer ${localStorage.token}`,
        },
      })
      .then((response) => response)
      .catch((error) => error.response);
  }
  delete(id) {
    return api
      .delete(`/models/${id}`, {
        headers: {
          Authorization: `Bearer ${localStorage.token}`,
        },
      })
      .then((response) => response)
      .catch((error) => error.response);
  }
}

export default new apiModelsService();
