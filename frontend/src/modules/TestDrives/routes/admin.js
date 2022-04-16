export default [
  {
    path: "test-drives",
    name: "test-drives",
    component: () => import("../TestDrives.vue"),
    meta: {
      title: "Test Drives",
      description: "Test Drives",
      sort: 0,
      authenticatable: true,
      permission: false,
      icon: "test-drives",
    },
  },
  {
    path: "test-drives-units",
    name: "test-drives-units",
    component: () => import("../TestDrivesUnits.vue"),
    meta: {
      title: "Test Drive Units",
      description: "Test Drives Units",
      sort: 0,
      authenticatable: true,
      permission: false,
      icon: "test-drives",
    },
  },
];
