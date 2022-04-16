export default [
  {
    name: "cars.index",
    meta: {
      title: "Cars",
      sort: 1,
      authenticatable: true,
      description: "Manage cars",
      icon: "mdi-car-sports",
      permission: false,
    },
    children: [
      {
        name: "cars.index",
        meta: {
          title: "Cars",
          sort: 0,
          authenticatable: true,
          description: "Manage cars",
          icon: "mdi-car-sports",
          permission: false,
        },
      },
      {
        name: "cars.models.index",
        meta: {
          title: "Models",
          sort: 0,
          authenticatable: true,
          description: "Manage cars",
          icon: "mdi-car-estate",
          permission: false,
        },
      },
      {
        name: "cars.colors.index",
        meta: {
          title: "Colors",
          sort: 0,
          authenticatable: true,
          description: "Manage cars",
          icon: "mdi-brush",
          permission: false,
        },
      },
      {
        name: "cars.years.index",
        meta: {
          title: "Years",
          sort: 0,
          authenticatable: true,
          description: "Manage cars",
          icon: "mdi-calendar",
          permission: false,
        },
      },
    ],
  },
];
