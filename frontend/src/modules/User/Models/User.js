class User {
  constructor() {
    this.loading = false;
    this.isPrestine = true;
    this.isValid = true;
    this.errors = [];
    this.password = null;

    this.data = {
      name: "Jane Smith",
      email: "janesmith@dummy.io",
      status: "active",
      updated_at: "Jan 13, 2022",
      created_at: "Jan 13, 2022",
      avatar:
        "https://images.unsplash.com/photo-1580489944761-15a19d654956?ixlib=rb-1.2.1&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=761&q=80",
    };
  }
}

export default User;
