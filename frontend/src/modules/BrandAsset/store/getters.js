export default {
  GET_BRANDASSETS: (state) => state.assets,
  GET_FOLDERS: (state) => state.folders,
  GET_CATEGORIES: (state) => state.categories,
  GET_ACTIVE_CATEGORIES: (state) => state.categories.filter((category) => category.status),
  GET_STORAGE: (state) => state.storage,
  GET_UPLOADFOLDERS: (state) => state.uploadFolders,
  GET_ACTIVE_UPLOADFOLDERS: (state) => state.uploadFolders.filter((folder) => folder.status),
};
