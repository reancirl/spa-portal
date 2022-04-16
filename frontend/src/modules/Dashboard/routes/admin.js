export default [
  {
    path: "dashboard",
    name: "dashboard",
    component: () => import("../Dashboard.vue"),
    meta: {
      title: "Homepage",
      description: "Overview of the app.",
      sort: 0,
      authenticatable: true,
      permission: false,
      icon: "dashboard",
    },
  },
  {
    path: "dashboard",
    name: "divider:dashboard",
    meta: {
      sort: 1,
      divider: true,
      height: 2,
    },
  },
];
