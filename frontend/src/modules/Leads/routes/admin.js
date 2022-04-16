export default [
  {
    path: "leads",
    name: "leads",
    component: () => import("../Leads.vue"),
    meta: {
      title: "Leads",
      description: "Leads",
      sort: 0,
      authenticatable: true,
      permission: false,
      icon: "leads",
    },
  },
];
