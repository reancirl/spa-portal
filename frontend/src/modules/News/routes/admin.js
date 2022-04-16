export default [
  {
    path: "/admin/news",
    name: "news",
    component: () => import("../News.vue"),
    meta: {
      title: "News",
      description: "Quotations",
      sort: 0,
      authenticatable: true,
      permission: false,
      icon: "news",
    },
  },
  {
    path: "/admin/news/create",
    name: "news.create",
    component: () => import("../Create.vue"),
    meta: {
      title: "Add News",
      description: "Create News",
      sort: 0,
      authenticatable: true,
      permission: false,
      icon: "colors",
    },
  },
  {
    path: "/admin/news/:id/edit",
    name: "news.edit",
    component: () => import("../Edit.vue"),
    meta: {
      title: "Edit News",
      sort: 0,
      authenticatable: false,
    },
  },
];
