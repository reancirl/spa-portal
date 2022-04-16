export default {
  GET_CATEGORIES: (state) => state.categories,
  GET_ACTIVE_CATEGORIES: (state) => state.categories.filter((category) => category.status),
  GET_CATEGORY: (state) => state.category,
};
