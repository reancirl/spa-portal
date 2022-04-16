export default [
  {
    path: "online-reservations",
    name: "online-reservations",
    component: () => import("../OnlineReservations.vue"),
    meta: {
      title: "Online Reservations",
      description: "Online Reservations",
      sort: 0,
      authenticatable: true,
      permission: false,
      icon: "mdi-clipboard-text-outline",
    },
  },
];
