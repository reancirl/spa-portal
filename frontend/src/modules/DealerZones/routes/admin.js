export default [
  {
    path: "/admin/dealer-zones",
    name: "dealer-zones",
    component: () => import("../DealerZones.vue"),
    meta: {
      title: "Dealer Zones",
      description: "Dealer Zones",
      sort: 0,
      authenticatable: true,
      permission: false,
      icon: "news",
    },
  },
  {
    path: "/admin/dealer-zones/create",
    name: "dealer-zones.create",
    component: () => import("../Create.vue"),
    meta: {
      title: "Add Dealer Zone",
      description: "Create New Dealer Zone",
      sort: 0,
      authenticatable: true,
      permission: false,
      icon: "colors",
    },
  },
  {
    path: "/admin/dealer-zones/:id/edit",
    name: "dealer-zones.edit",
    component: () => import("../Edit.vue"),
    meta: {
      title: "Edit Dealer Zones",
      sort: 0,
      authenticatable: false,
    },
  },
];
