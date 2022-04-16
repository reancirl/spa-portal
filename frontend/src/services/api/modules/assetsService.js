import api from "@/services/api/baseService";

class apiAssetsService {
  upload(param) {
    return api
      .post("/assets", param, {
        headers: {
          Authorization: `Bearer ${localStorage.token}`,
          "Content-Type": "multipart/form-data",
        },
      })
      .then((response) => response)
      .catch((error) => error.response);
  }
  updateAsset(id, data) {
    return api
      .post(`/assets/${id}`, data, {
        headers: {
          Authorization: `Bearer ${localStorage.token}`,
          "Content-Type": "multipart/form-data",
        },
      })
      .then((response) => response)
      .catch((error) => error.response);
  }
  getStorage() {
    return api
      .get("/assets/storage", {
        headers: {
          Authorization: `Bearer ${localStorage.token}`,
        },
      })
      .then((response) => response)
      .catch((error) => error.response);
  }
  getCategoryFolders(id) {
    return api
      .get(`/assets/categories/${id}/folders`, {
        headers: {
          Authorization: `Bearer ${localStorage.token}`,
        },
      })
      .then((response) => response)
      .catch((error) => error.response);
  }
  getFolderAssets(id, page, per_page) {
    return api
      .get(`/assets/folders/${id}/assets`, {
        headers: {
          Authorization: `Bearer ${localStorage.token}`,
        },
        params: {
          per_page,
          page,
        },
      })
      .then((response) => response)
      .catch((error) => error.response);
  }
  getCategories(page, per_page, q) {
    return api
      .get("/assets/categories", {
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
  createCategory(data) {
    return api
      .post(`/assets/categories`, data, {
        headers: {
          Authorization: `Bearer ${localStorage.token}`,
        },
      })
      .then((response) => response)
      .catch((error) => error.response);
  }
  updateCategory(id, data) {
    return api
      .put(`/assets/categories/${id}`, data, {
        headers: {
          Authorization: `Bearer ${localStorage.token}`,
        },
      })
      .then((response) => response)
      .catch((error) => error.response);
  }
  delete(id) {
    return api
      .delete(`/assets/${id}`, {
        headers: {
          Authorization: `Bearer ${localStorage.token}`,
        },
      })
      .then((response) => response)
      .catch((error) => error.response);
  }
  getFolders(page, per_page, q) {
    return api
      .get("/assets/folders", {
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
  getFolder(id) {
    return api
      .get(`/assets/folders/${id}`, {
        headers: {
          Authorization: `Bearer ${localStorage.token}`,
        },
      })
      .then((response) => response)
      .catch((error) => error.response);
  }
  deleteFolder(id) {
    return api
      .delete(`/assets/folders/${id}`, {
        headers: {
          Authorization: `Bearer ${localStorage.token}`,
        },
      })
      .then((response) => response)
      .catch((error) => error.response);
  }
  getCategory(id) {
    return api
      .get(`/assets/categories/${id}`, {
        headers: {
          Authorization: `Bearer ${localStorage.token}`,
        },
      })
      .then((response) => response)
      .catch((error) => error.response);
  }
  createFolder(data) {
    return api
      .post(`/assets/folders`, data, {
        headers: {
          Authorization: `Bearer ${localStorage.token}`,
        },
      })
      .then((response) => response)
      .catch((error) => error.response);
  }
  updateFolder(id, data) {
    return api
      .put(`/assets/folders/${id}`, data, {
        headers: {
          Authorization: `Bearer ${localStorage.token}`,
        },
      })
      .then((response) => response)
      .catch((error) => error.response);
  }
  uploadGuidelines(data) {
    return api
      .post(`/assets/branding-guidelines`, data, {
        headers: {
          Authorization: `Bearer ${localStorage.token}`,
          "Content-Type": "multipart/form-data",
        },
      })
      .then((response) => response)
      .catch((error) => error.response);
  }
}

export default new apiAssetsService();
