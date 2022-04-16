export default [
  {
    path: "/admin/cars/:id/variant-colors",
    name: "admin.cars.variant-colors",
    redirect: { name: "cars.variant-colors.index" },
    component: () => import("@/App.vue"),
    meta: {
      title: "Cars",
      sort: 6,
      authenticatable: false,
      icon: "mdi-book-multiple-variant",
    },
    children: [
      {
        path: "/admin/cars/:id/variant-colors",
        name: "cars.variant-colors.index",
        component: () => import("../Index.vue"),
        meta: {
          title: "Variant Colors",
          description: "Variant Colors",
          sort: 0,
          authenticatable: true,
          permission: false,
          icon: "variant-colors",
        },
      },
      {
        path: "/admin/cars/:id/variant-colors/create",
        name: "cars.variant-colors.create",
        component: () => import("../Create.vue"),
        meta: {
          title: "Add new Car",
          description: "Create new model",
          sort: 0,
          authenticatable: true,
          permission: false,
          icon: "variant-colors",
        },
      },
      {
        path: "/admin/cars/:id/variant-colors/:variantcolorid/edit",
        name: "cars.variant-colors.edit",
        component: () => import("../Edit.vue"),
        meta: {
          title: "Edit Car",
          sort: 0,
          authenticatable: false,
        },
      },
    ],
  },
];
