export default [
  {
    path: "/admin/cars/years",
    name: "admin.cars.years",
    redirect: { name: "cars.years.index" },
    component: () => import("@/App.vue"),
    meta: {
      title: "Cars",
      sort: 6,
      authenticatable: false,
      icon: "mdi-book-multiple-variant",
    },
    children: [
      {
        path: "/admin/cars/years",
        name: "cars.years.index",
        component: () => import("../Index.vue"),
        meta: {
          title: "Years",
          description: "Years",
          sort: 0,
          authenticatable: true,
          permission: false,
          icon: "years",
        },
      },
      {
        path: "create",
        name: "cars.years.create",
        component: () => import("../Create.vue"),
        meta: {
          title: "Add new Year",
          description: "Create new year",
          sort: 0,
          authenticatable: true,
          permission: false,
          icon: "years",
        },
      },
      {
        path: ":id/edit",
        name: "cars.years.edit",
        component: () => import("../Edit.vue"),
        meta: {
          title: "Edit Year",
          sort: 0,
          authenticatable: false,
        },
      },
    ],
  },
];
