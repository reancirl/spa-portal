export default [
  {
    path: "reports",
    name: "reports",
    component: () => import("../Reports.vue"),
    meta: {
      title: "Reports",
      description: "Reports",
      sort: 0,
      authenticatable: true,
      permission: false,
      icon: "inquiries",
    },
  },
];
