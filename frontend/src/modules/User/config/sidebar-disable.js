export default [
  {
    code: "users.index", // 'users',
    name: "users.index", // 'users',
    meta: {
      title: "Users",
      icon: "mdi-account-multiple-outline",
      authenticatable: false,
      description: "Manage users",
      sort: 6,
      permission: "users.index",
      children: ["users.index", "users.create", "users.edit", "users.show", "users.trashed"],
    },
    // children: [
    //   {
    //     code: 'users.index',
    //     name: 'users.index',
    //     meta: {
    //       title: 'All Users',
    //       authenticatable: false,
    //       description: 'View the list of all users',
    //       sort: 5,
    //       permission: 'users.index',
    //       children: ['users.index', 'users.edit', 'users.show'],
    //     },
    //   },
    //   {
    //     code: 'users.create',
    //     name: 'users.create',
    //     meta: {
    //       title: 'Add User',
    //       authenticatable: false,
    //       description: 'Add a new user',
    //       sort: 6,
    //       permission: 'users.create',
    //     },
    //   },
    // ],
  },
];
