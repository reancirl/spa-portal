import Vue from "vue";
import store from "@/store";
import includes from "lodash/includes";

window.auth = require("./core/Auth/auth.js");

/**
 * We'll load the axios HTTP library which allows us to easily issue requests
 * to our Laravel back-end. This library automatically handles sending the
 * CSRF token as a header based on the value of the "XSRF" token cookie.
 */

window.axios = require("axios");

const config = {
  baseURL: process.env.VUE_APP_API_BASE_URL || process.env.baseURL || process.env.apiUrl || "",
  // timeout: 60 * 1000, // Timeout
  // withCredentials: true, // Check cross-site Access-Control
};

window.axios = window.axios.create(config);

window.axios.defaults.headers.common["X-Requested-With"] = "XMLHttpRequest";

/**
 * Next we will register the CSRF Token as a common header with Axios so that
 * all outgoing HTTP requests automatically have it attached. This is just
 * a simple convenience so we don't have to attach every token manually.
 */

// let token = document.head.querySelector('meta[name="csrf-token"]');

// if (token) {
//   window.axios.defaults.headers.common['X-CSRF-TOKEN'] = token.content;
// } else {
//   console.error('CSRF token not found: https://laravel.com/docs/csrf#csrf-x-csrf-token');
// }

/**
 * Next we will register the access token as a common header with Axios so that
 * all outgoing HTTP requests automatically have it attached. This is just
 * a simple convenience so we don't have to attach every token manually.
 */
let accessToken = localStorage.getItem("token");

/**
 * Request interceptor.
 */
window.axios.interceptors.request.use(
  (requestConfig) => {
    if (store.getters["auth/isAuthenticated"]) {
      requestConfig.headers.Authorization = `Bearer ${store.state.auth.token}`;
    }
    return requestConfig;
  },
  (requestError) => Promise.reject(requestError)
);

/**
 * Response interceptor.
 */
window.axios.interceptors.response.use(
  (response) => response,
  (error) => {
    if (error.response.status === 401) {
      // Clear token and redirect
      store.commit("auth/SET_TOKEN", null);
      localStorage.removeItem("token");
      window.location.replace(`${window.location.origin}/login`);
    }
    return Promise.reject(error);
  }
);
// if (accessToken) {
//   window.axios.defaults.headers.common['Authorization'] = `Bearer ${accessToken}`;
// }

/**
 * Echo exposes an expressive API for subscribing to channels and listening
 * for events that are broadcast by Laravel. Echo and event broadcasting
 * allows your team to easily build robust real-time web applications.
 */

// import Echo from 'laravel-echo'

// window.Pusher = require('pusher-js');

// window.Echo = new Echo({
//     broadcaster: 'pusher',
//     key: process.env.MIX_PUSHER_APP_KEY,
//     cluster: process.env.MIX_PUSHER_APP_CLUSTER,
//     encrypted: true
// });

window.is_rtl = function (lang) {
  const rtl = ["ar"];
  return includes(rtl, lang);
};

window.Response = {
  HTTP_OK: 200,
  HTTP_CREATED: 201,
  HTTP_UNAUTHORIZED: 401,
  HTTP_FORBIDDEN: 403,
  HTTP_NOT_FOUND: 404,
  HTTP_UNPROCESSABLE_ENTITY: 422,
  HTTP_PAYLOAD_TOO_LARGE: 413,
  HTTP_INTERNAL_SERVER_ERROR: 500,
};

export const _axios = window.axios;

Plugin.install = function (Vue) {
  Vue.axios = _axios;
  window.axios = _axios;
  Object.defineProperties(Vue.prototype, {
    axios: {
      get() {
        return _axios;
      },
    },
    $axios: {
      get() {
        return _axios;
      },
    },
  });
};

Vue.use(Plugin);

export default Plugin;
