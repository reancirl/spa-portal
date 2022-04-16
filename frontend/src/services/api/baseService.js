import axios from "axios";

axios.defaults.headers.common["X-Requested-With"] = "XMLHttpRequest";

export default axios.create({
  baseURL: process.env.VUE_APP_API_BASE_URL + process.env.VUE_APP_API_VERSION + "/",
  timeout: 5000,
});
