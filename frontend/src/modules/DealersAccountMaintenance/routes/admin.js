export default [
  {
    path: "/admin/dealers-account-maintenance",
    redirect: { name: "dealers-account-maintenance.dealers.index" },
    component: () => import("@/App.vue"),
    meta: {
      title: "Dealers Account Maintenance",
      sort: 6,
      authenticatable: false,
      icon: "mdi-book-multiple-variant",
    },
  },
];
