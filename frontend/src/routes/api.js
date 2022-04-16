import { BASE_URL } from "@/config/app.js";

export default {
  login: `${BASE_URL}/oauth/token`,
  passwordReset: `${BASE_URL}/api/v1/users/password/reset`,
  forgotPassword: `${BASE_URL}/api/v1/users/password/forgot`,
  logout: `${BASE_URL}/api/v1/users/logout`,

  settings: {
    app: "/api/v1/settings/app",
    changePassword: "api/v1/users/password/change",
    locale: "/api/v1/settings/locale",
  },

  search: "/api/v1/search",

  languages: {
    supported: "/api/v1/languages/supported",
    index: "/api/v1/languages",
  },

  profile: `${BASE_URL}/api/v1/users/me`,

  validate: {
    token: "/api/v1/validate/token",
  },
};
