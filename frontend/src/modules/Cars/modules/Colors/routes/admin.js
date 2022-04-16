export default [
  {
    path: "/admin/cars/colors",
    name: "admin.cars.colors",
    redirect: { name: "cars.colors.index" },
    component: () => import("@/App.vue"),
    meta: {
      title: "Cars",
      sort: 6,
      authenticatable: false,
      icon: "mdi-book-multiple-variant",
    },
    children: [
      {
        path: "/admin/cars/colors",
        name: "cars.colors.index",
        component: () => import("../Index.vue"),
        meta: {
          title: "Colors",
          description: "Colors",
          sort: 0,
          authenticatable: true,
          permission: false,
          icon: "colors",
        },
      },
      {
        path: "create",
        name: "cars.colors.create",
        component: () => import("../Create.vue"),
        meta: {
          title: "Add new Color",
          description: "Create new color",
          sort: 0,
          authenticatable: true,
          permission: false,
          icon: "colors",
        },
      },
      {
        path: ":id/edit",
        name: "cars.colors.edit",
        component: () => import("../Edit.vue"),
        meta: {
          title: "Edit Color",
          sort: 0,
          authenticatable: false,
        },
      },
    ],
  },
];
