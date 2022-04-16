import api from "@/services/api/baseService";

class apiAuthService {
  login(data) {
    return api
      .post("/auth/login", {
        ...data,
      })
      .then((response) => response)
      .catch((error) => error.response);
  }

  logout() {
    return api
      .post(
        "/auth/logout",
        {},
        {
          headers: {
            "Content-Type": "application/json",
            Accept: "application/json",
            Authorization: "Bearer " + localStorage.token,
          },
        }
      )
      .then((response) => response)
      .catch((error) => error.response);
  }
}
export default new apiAuthService();
