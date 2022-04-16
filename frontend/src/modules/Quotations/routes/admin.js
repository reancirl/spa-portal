export default [
  {
    path: "quotations",
    name: "quotations",
    component: () => import("../Quotations.vue"),
    meta: {
      title: "Quotations",
      description: "Quotations",
      sort: 0,
      authenticatable: true,
      permission: false,
      icon: "quotations",
    },
  },
];
