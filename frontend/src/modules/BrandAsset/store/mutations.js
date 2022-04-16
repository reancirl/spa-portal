export default {
  SET_BRANDASSETS: (state, data) => {
    state.assets = data;
  },
  SET_FOLDERS: (state, data) => {
    state.folders = data;
  },
  SET_CATEGORIES: (state, data) => {
    state.categories = data;
  },
  SET_STORAGE: (state, data) => {
    state.storage = data;
  },
  SET_UPLOADFOLDERS: (state, data) => {
    state.uploadFolders = data;
  },
};
