export default [
  {
    path: "styleguide",
    name: "styleguide",
    component: () => import("../Styleguide.vue"),
    meta: {
      title: "Styleguide",
      description: "Component Collection.",
      sort: 0,
      authenticatable: true,
      permission: false,
      icon: "styleguide",
    },
  },
];
