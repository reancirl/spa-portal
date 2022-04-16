import api from "@/services/api/baseService";

class apiVariantsService {
  list(page, per_page, q, model) {
    return api
      .get("/variants", {
        headers: {
          Authorization: `Bearer ${localStorage.token}`,
        },
        params: {
          page,
          per_page,
          q,
          model
        }
      })
      .then((response) => response)
      .catch((error) => error.response);
  }
  getVariant(id) {
    return api
      .get(`/variants/${id}`, {
        headers: {
          Authorization: `Bearer ${localStorage.token}`,
        },
      })
      .then((response) => response)
      .catch((error) => error.response);
  }
  create(variant) {
    return api
      .post("/variants", variant, {
        headers: {
          Authorization: `Bearer ${localStorage.token}`,
        },
      })
      .then((response) => response)
      .catch((error) => error.response);
  }
  update(variant, id) {
    return api
      .put(`/variants/${id}`, variant, {
        headers: {
          Authorization: `Bearer ${localStorage.token}`,
        },
      })
      .then((response) => response)
      .catch((error) => error.response);
  }
  delete(id) {
    return api
      .delete(`/variants/${id}`, {
        headers: {
          Authorization: `Bearer ${localStorage.token}`,
        },
      })
      .then((response) => response)
      .catch((error) => error.response);
  }
}

export default new apiVariantsService();
