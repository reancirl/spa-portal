import api from "@/services/api/baseService";

class apiNewsService {
  list() {
    return api
      .get("/news", {
        headers: {
          Authorization: `Bearer ${localStorage.token}`,
        },
      })
      .then((response) => response)
      .catch((error) => error.response);
  }
}

export default new apiNewsService();
