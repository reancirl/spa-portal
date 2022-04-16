export default [
  {
    path: "/admin/dealers-account-maintenance/dealers/:id/sales-consultants",
    name: "dealers-account-maintenance.dealers.sales-consultants.index",
    component: () => import("../Index.vue"),
    meta: {
      title: "Sales Consultants",
      description: "Sales Consultants",
      sort: 0,
      authenticatable: true,
      permission: false,
      icon: "colors",
    },
  },
  {
    path: "/admin/dealers-account-maintenance/dealers/:id/sales-consultants/create",
    name: "dealers-account-maintenance.dealers.sales-consultants.create",
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
    path: "/admin/dealers-account-maintenance/dealers/:id/sales-consultants/upload",
    name: "dealers-account-maintenance.dealers.sales-consultants.upload",
    component: () => import("../Upload.vue"),
    meta: {
      title: "Upload Sales Consultants",
      description: "Upload Sales Consultants via Excel",
      sort: 0,
      authenticatable: true,
      permission: false,
      icon: "colors",
    },
  },
  {
    path: "/admin/dealers-account-maintenance/dealers/:id/sales-consultants/:salesconsultantid",
    name: "dealers-account-maintenance.dealers.sales-consultants.edit",
    component: () => import("../Edit.vue"),
    meta: {
      title: "Edit Car",
      sort: 0,
      authenticatable: false,
    },
  },
];
