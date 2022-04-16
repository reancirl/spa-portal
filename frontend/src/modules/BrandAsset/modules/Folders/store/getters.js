export default {
  GET_FOLDERS: (state) => state.folders,
  GET_ACTIVE_FOLDERS: (state) => state.folders.filter((folder) => folder.status),
  GET_FOLDER: (state) => state.folder,
};
