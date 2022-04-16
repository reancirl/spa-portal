import units from "../routes/children";

export default [
  {
    name: "dealers-account-maintenance.dealers.index",
    meta: {
      title: "Dealers",
      sort: 0,
      authenticatable: true,
      description: "Manage dealer's account",
      icon: "mdi-account-details",
      permission: false,
    },
    children: [].concat(units),
  },
];
