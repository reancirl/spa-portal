export default [
  {
    path: "/admin/brand-asset-category",
    name: "brand-asset-category",
    component: () => import("../BrandAssetCategory.vue"),
    meta: {
      title: "Categories",
      description: "Categories",
      sort: 0,
      authenticatable: true,
      permission: false,
      icon: "news",
    },
  },
  {
    path: "/admin/brand-asset-category/create",
    name: "brand-asset-category.create",
    component: () => import("../Create.vue"),
    meta: {
      title: "Add Category",
      description: "Create Category",
      sort: 0,
      authenticatable: true,
      permission: false,
      icon: "colors",
    },
  },
  {
    path: "/admin/brand-asset-category/:id/edit",
    name: "brand-asset-category.edit",
    component: () => import("../Edit.vue"),
    meta: {
      title: "Edit Category",
      sort: 0,
      authenticatable: false,
    },
  },
];
