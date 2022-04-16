export default [
  {
    path: "inquiries",
    name: "inquiries",
    component: () => import("../Inquiries.vue"),
    meta: {
      title: "Inquiries",
      description: "Inquiries",
      sort: 0,
      authenticatable: true,
      permission: false,
      icon: "inquiries",
    },
  },
  {
    path: "/admin/inquiries/upload",
    name: "inquiries.upload",
    component: () => import("../Upload.vue"),
    meta: {
      title: "Upload Inquiry",
      description: "Upload Inquiry",
      sort: 0,
      authenticatable: true,
      permission: false,
      icon: "inquiries",
    },
  },
];
