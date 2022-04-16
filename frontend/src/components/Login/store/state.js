export default {
  auth: {
    access_token: undefined !== localStorage.token ? localStorage.token : false,
    user: undefined !== localStorage.user ? JSON.parse(localStorage.user) : null,
  },
  err: {
    message: null,
  },
};
