import api from "@/services/api/baseService";

class apiModelYearsService {
  list(page, per_page, q) {
    return api
      .get("/model/years", {
        headers: {
          Authorization: `Bearer ${localStorage.token}`,
        },
        params: {
          per_page,
          page,
          q
        }
      })
      .then((response) => response)
      .catch((error) => error.response);
  }
  getYear(id) {
    return api
      .get(`/model/years/${id}`, {
        headers: {
          Authorization: `Bearer ${localStorage.token}`,
        },
      })
      .then((response) => response)
      .catch((error) => error.response);
  }
  create(year) {
    return api
      .post("/model/years", year, {
        headers: {
          Authorization: `Bearer ${localStorage.token}`,
        },
      })
      .then((response) => response)
      .catch((error) => error.response);
  }
  update(year, id) {
    return api
      .put(`/model/years/${id}`, year, {
        headers: {
          Authorization: `Bearer ${localStorage.token}`,
        },
      })
      .then((response) => response)
      .catch((error) => error.response);
  }
  delete(id) {
    return api
      .delete(`/model/years/${id}`, {
        headers: {
          Authorization: `Bearer ${localStorage.token}`,
        },
      })
      .then((response) => response)
      .catch((error) => error.response);
  }
}

export default new apiModelYearsService();
