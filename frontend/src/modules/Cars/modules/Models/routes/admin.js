export default [
  {
    path: "/admin/cars/models",
    name: "admin.cars.models",
    redirect: { name: "cars.models.index" },
    component: () => import("@/App.vue"),
    meta: {
      title: "Cars",
      sort: 6,
      authenticatable: false,
      icon: "mdi-book-multiple-variant",
    },
    children: [
      {
        path: "/admin/cars/models",
        name: "cars.models.index",
        component: () => import("../Index.vue"),
        meta: {
          title: "Models",
          description: "Models",
          sort: 0,
          authenticatable: true,
          permission: false,
          icon: "models",
        },
      },
      {
        path: "create",
        name: "cars.models.create",
        component: () => import("../Create.vue"),
        meta: {
          title: "Add new Car",
          description: "Create new model",
          sort: 0,
          authenticatable: true,
          permission: false,
          icon: "models",
        },
      },
      {
        path: ":id/edit",
        name: "cars.models.edit",
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
