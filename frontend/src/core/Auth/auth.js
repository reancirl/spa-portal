import includes from "lodash/includes";

class Auth {
  constructor() {
    this.token = null;
    this.user = null;
    this.id = null;
  }

  authorize(token) {
    window.localStorage.setItem("token", token);
    window.axios.defaults.headers.common["Authorization"] = `Bearer ${token}`;

    this.token = token;
  }

  setUser(user) {
    this.user = user;
    window.localStorage.setItem("user", JSON.stringify(user));
  }

  getUser() {
    return JSON.parse(window.localStorage.getItem("user") || "{}");
  }

  getId() {
    return this.getUser().id;
  }

  check() {
    return !!this.token;
  }

  hasPermission(permission) {
    return permission === false || includes(this.getUser().permissions || [], permission);
  }

  isSuperAdmin() {
    return this.getUser()["is:superadmin"] || false;
  }

  isNotSuperAdmin() {
    return !this.isSuperAdmin();
  }
}

export default new Auth();
