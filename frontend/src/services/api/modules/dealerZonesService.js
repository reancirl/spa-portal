import api from "@/services/api/baseService";

class apiDealerZonesService {
  getZones(page, per_page, q) {
    return api
      .get("/dealer/zones", {
        headers: {
          Authorization: `Bearer ${localStorage.token}`,
        },
        params: {
          per_page,
          page,
          q,
        },
      })
      .then((response) => response)
      .catch((error) => error.response);
  }
  getZone(id) {
    return api
      .get(`/dealer/zones/${id}`, {
        headers: {
          Authorization: `Bearer ${localStorage.token}`,
        },
      })
      .then((response) => response)
      .catch((error) => error.response);
  }
  create(data) {
    return api
      .post(`/dealer/zones`, data, {
        headers: {
          Authorization: `Bearer ${localStorage.token}`,
        },
      })
      .then((response) => response)
      .catch((error) => error.response);
  }
  update(id, data) {
    return api
      .put(`/dealer/zones/${id}`, data, {
        headers: {
          Authorization: `Bearer ${localStorage.token}`,
        },
      })
      .then((response) => response)
      .catch((error) => error.response);
  }
  delete(id) {
    return api
      .delete(`/dealer/zones/${id}`, {
        headers: {
          Authorization: `Bearer ${localStorage.token}`,
        },
      })
      .then((response) => response)
      .catch((error) => error.response);
  }
}

export default new apiDealerZonesService();
