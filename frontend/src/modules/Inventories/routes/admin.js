export default [
  {
    path: "inventories",
    name: "inventories",
    component: () => import("../Inventories.vue"),
    meta: {
      title: "Inventories",
      description: "Inventories",
      sort: 0,
      authenticatable: true,
      permission: false,
      icon: "inventories",
    },
  },
  {
    path: "/admin/inventories/create",
    name: "inventories.create",
    component: () => import("../Create.vue"),
    meta: {
      title: "Add new Inventory",
      description: "Create new Inventory",
      sort: 0,
      authenticatable: true,
      permission: false,
      icon: "inventories",
    },
  },
  {
    path: "/admin/inventories/:id/edit",
    name: "inventories.edit",
    component: () => import("../Edit.vue"),
    meta: {
      title: "Edit Inventory",
      description: "Edit Inventory",
      sort: 0,
      authenticatable: true,
      permission: false,
      icon: "inventories",
    },
  },
  {
    path: "/admin/inventories/upload",
    name: "inventories.upload",
    component: () => import("../Upload.vue"),
    meta: {
      title: "Upload Inventory",
      description: "Upload Inventory",
      sort: 0,
      authenticatable: true,
      permission: false,
      icon: "inventories",
    },
  },
];
