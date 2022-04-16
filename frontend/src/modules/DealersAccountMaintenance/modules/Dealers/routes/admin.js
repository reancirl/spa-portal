export default [
  {
    path: "/admin/dealers-account-maintenance/dealers",
    name: "dealers-account-maintenance.dealers.index",
    component: () => import("../Index.vue"),
    meta: {
      title: "Dealers",
      description: "Models",
      sort: 0,
      authenticatable: true,
      permission: false,
      icon: "colors",
    },
  },
  {
    path: "/admin/dealers-account-maintenance/dealers/create",
    name: "dealers-account-maintenance.dealers.create",
    component: () => import("../Create.vue"),
    meta: {
      title: "Add new Dealer",
      description: "Create new Dealer",
      sort: 0,
      authenticatable: true,
      permission: false,
      icon: "colors",
    },
  },
  {
    path: "/admin/dealers-account-maintenance/dealers/:id/edit",
    name: "dealers-account-maintenance.dealers.edit",
    component: () => import("../Edit.vue"),
    meta: {
      title: "Edit Car",
      sort: 0,
      authenticatable: false,
    },
  },
];
