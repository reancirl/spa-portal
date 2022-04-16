export default [
  {
    path: "brand-asset",
    name: "brand-asset",
    component: () => import("../BrandAsset.vue"),
    meta: {
      title: "Brand Assets",
      description: "Brand Assets",
      sort: 0,
      authenticatable: true,
      permission: false,
      icon: "brand-asset",
    },
  },
];
