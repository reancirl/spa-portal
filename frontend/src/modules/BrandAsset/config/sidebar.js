let children = [
  {
    name: "brand-asset",
    meta: {
      title: "Brand Assets",
      sort: 0,
      authenticatable: true,
      description: "Manage Brand Assets",
      icon: "mdi-folder-multiple-image",
      permission: false,
    },
  },
];

if (localStorage.user) {
  const user = JSON.parse(localStorage.user);

  if (user.is_admin) {
    children = [
      {
        name: "brand-asset",
        meta: {
          title: "Brand Assets",
          sort: 0,
          authenticatable: true,
          description: "Manage Brand Assets",
          icon: "mdi-folder-multiple-image",
          permission: false,
        },
      },
      {
        name: "brand-asset.categories.index",
        meta: {
          title: "Categories",
          sort: 0,
          authenticatable: true,
          description: "Manage Brand Asset Categories",
          icon: "mdi-format-list-bulleted",
          permission: false,
        },
      },
      {
        name: "brand-asset.folders.index",
        meta: {
          title: "Folders",
          sort: 0,
          authenticatable: true,
          description: "Manage Brand Asset Folders",
          icon: "mdi-folder-multiple",
          permission: false,
        },
      },
    ];
  }
}

export default [
  {
    name: "brand-asset",
    meta: {
      title: "Brand Assets",
      sort: 2,
      authenticatable: true,
      description: "",
      icon: "mdi-folder",
      permission: false,
    },
    children: children,
  },
];
