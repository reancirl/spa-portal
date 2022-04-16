const BASE_URL = "/api/v1";

export default {
  list: function () {
    return `${BASE_URL}/users`;
  },

  store: function () {
    return `${BASE_URL}/users`;
  },

  show: function (id = null) {
    return `${BASE_URL}/users/${id}`;
  },

  update: function (id = null) {
    return `${BASE_URL}/users/${id}`;
  },
};
