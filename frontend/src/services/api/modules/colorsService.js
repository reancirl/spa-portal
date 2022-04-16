import api from "@/services/api/baseService";

class apiColorsService {
  list(page, per_page, q) {
    return api
      .get("/colors", {
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
  getColor(id) {
    return api
      .get(`/colors/${id}`, {
        headers: {
          Authorization: `Bearer ${localStorage.token}`,
        },
      })
      .then((response) => response)
      .catch((error) => error.response);
  }
  create(color) {
    return api
      .post("/colors", color, {
        headers: {
          Authorization: `Bearer ${localStorage.token}`,
        },
      })
      .then((response) => response)
      .catch((error) => error.response);
  }
  update(color, id) {
    return api
      .put(`/colors/${id}`, color, {
        headers: {
          Authorization: `Bearer ${localStorage.token}`,
        },
      })
      .then((response) => response)
      .catch((error) => error.response);
  }
  delete(id) {
    return api
      .delete(`/colors/${id}`, {
        headers: {
          Authorization: `Bearer ${localStorage.token}`,
        },
      })
      .then((response) => response)
      .catch((error) => error.response);
  }
}

export default new apiColorsService();
