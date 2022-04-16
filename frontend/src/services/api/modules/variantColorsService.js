import api from "@/services/api/baseService";

class apiVariantColorsService {
  list(page, per_page, q, variant_id) {
    return api
      .get("/variant/colors", {
        headers: {
          Authorization: `Bearer ${localStorage.token}`,
        },
        params: {
          page,
          per_page,
          q,
          variant_id
        }
      })
      .then((response) => response)
      .catch((error) => error.response);
  }
  getVariantColor(id) {
    return api
      .get(`/variant/colors/${id}`, {
        headers: {
          Authorization: `Bearer ${localStorage.token}`,
        },
      })
      .then((response) => response)
      .catch((error) => error.response);
  }
  create(variantColor) {
    return api
      .post("/variant/colors", variantColor, {
        headers: {
          Authorization: `Bearer ${localStorage.token}`,
        },
      })
      .then((response) => response)
      .catch((error) => error.response);
  }
  update(variantColor, id) {
    return api
      .put(`/variant/colors/${id}`, variantColor, {
        headers: {
          Authorization: `Bearer ${localStorage.token}`,
        },
      })
      .then((response) => response)
      .catch((error) => error.response);
  }
  delete(id) {
    return api
      .delete(`/variant/colors/${id}`, {
        headers: {
          Authorization: `Bearer ${localStorage.token}`,
        },
      })
      .then((response) => response)
      .catch((error) => error.response);
  }
}

export default new apiVariantColorsService();
