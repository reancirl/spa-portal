export default [
  {
    path: "/admin/dealer-groups",
    name: "dealer-groups",
    component: () => import("../DealerGroups.vue"),
    meta: {
      title: "Dealer Groups",
      description: "Dealer Groups",
      sort: 0,
      authenticatable: true,
      permission: false,
      icon: "news",
    },
  },
  {
    path: "/admin/dealer-groups/create",
    name: "dealer-groups.create",
    component: () => import("../Create.vue"),
    meta: {
      title: "Add Dealer Group",
      description: "Create New Dealer Group",
      sort: 0,
      authenticatable: true,
      permission: false,
      icon: "colors",
    },
  },
  {
    path: "/admin/dealer-groups/:id/edit",
    name: "dealer-groups.edit",
    component: () => import("../Edit.vue"),
    meta: {
      title: "Edit Dealer Group",
      sort: 0,
      authenticatable: false,
    },
  },
];
