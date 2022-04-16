import units from "../routes/children";

export default [
  {
    name: "test-drives",
    meta: {
      title: "Test Drives",
      sort: 0,
      authenticatable: true,
      description: "Test Drives",
      icon: "mdi-car",
      permission: false,
    },
    children: [].concat(units),
  },
];
