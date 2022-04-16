export default [
  {
    path: "download-reports",
    name: "download-reports",
    component: () => import("../DownloadReports.vue"),
    meta: {
      title: "Download Reports",
      description: "Download Reports",
      sort: 0,
      authenticatable: true,
      permission: false,
      icon: "mdi-clipboard-text-outline",
    },
  },
];
