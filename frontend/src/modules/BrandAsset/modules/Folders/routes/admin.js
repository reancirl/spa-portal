export default [
  {
    path: "/admin/brand-asset/folders",
    name: "admin.brand-asset.folders",
    redirect: { name: "brand-asset.folders.index" },
    component: () => import("@/App.vue"),
    meta: {
      title: "Brand Asset",
      sort: 6,
      authenticatable: false,
      icon: "mdi-folder-multiple",
    },
    children: [
      {
        path: "/admin/brand-asset/folders",
        name: "brand-asset.folders.index",
        component: () => import("../Index.vue"),
        meta: {
          title: "Folders",
          description: "Folders",
          sort: 0,
          authenticatable: true,
          permission: false,
          icon: "mdi-folder-multiple",
        },
      },
      {
        path: "create",
        name: "brand-asset.folders.create",
        component: () => import("../Create.vue"),
        meta: {
          title: "Add New Folder",
          description: "Create new folder",
          sort: 0,
          authenticatable: true,
          permission: false,
          icon: "mdi-folder-multiple",
        },
      },
      {
        path: ":id/edit",
        name: "brand-asset.folders.edit",
        component: () => import("../Edit.vue"),
        meta: {
          title: "Edit Folder",
          sort: 0,
          authenticatable: false,
        },
      },
    ],
  },
];
