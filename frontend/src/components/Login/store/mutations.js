export default {
  SET_AUTH: (state, data) => {
    state.auth = {
      ...data,
    };
  },
  SET_ERR: (state, data) => {
    state.err = {
      message: data,
    };
  },
};
