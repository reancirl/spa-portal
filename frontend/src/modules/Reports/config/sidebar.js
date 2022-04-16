import units from "../routes/children";

export default [
  {
    name: "reports",
    meta: {
      title: "Reports",
      sort: 0,
      authenticatable: true,
      description: "Inquiry",
      icon: "mdi-account-details",
      permission: false,
    },
    children: [].concat(units),
  },
];
