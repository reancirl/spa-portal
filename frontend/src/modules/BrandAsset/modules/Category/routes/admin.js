export default [
  {
    path: "/admin/brand-asset/categories",
    name: "brand-asset.categories.index",
    redirect: { name: "brand-asset.categories.index" },
    component: () => import("@/App.vue"),
    meta: {
      title: "Brand Asset Category",
      description: "Brand Asset Category",
      sort: 0,
      authenticatable: true,
      permission: false,
      icon: "news",
    },
    children: [
      {
        path: "/admin/brand-asset/categories",
        name: "brand-asset.categories.index",
        component: () => import("../Index.vue"),
        meta: {
          title: "Categories",
          description: "Categories",
          sort: 0,
          authenticatable: true,
          permission: false,
          icon: "mdi-format-list-bulleted",
        },
      },
      {
        path: "create",
        name: "brand-asset.categories.create",
        component: () => import("../Create.vue"),
        meta: {
          title: "Add New Category",
          description: "Create New Category",
          sort: 0,
          authenticatable: true,
          permission: false,
          icon: "mdi-folder-multiple",
        },
      },
      {
        path: ":id/edit",
        name: "brand-asset.categories.edit",
        component: () => import("../Edit.vue"),
        meta: {
          title: "Edit Category",
          sort: 0,
          authenticatable: false,
        },
      },
    ],
  },
];
