<template>
  <admin>
    <metatag title="'All Users"></metatag>

    <page-header>
      <template v-slot:action>
        <v-btn
          :block="$vuetify.breakpoint.smAndDown"
          large
          color="primary"
          exact
          :to="{ name: 'users.create' }"
        >
          <v-icon small left>mdi-account-plus-outline</v-icon>
          <span v-text="'Add User'"></span>
        </v-btn>
      </template>
    </page-header>

    <!-- Data table -->
    <v-card>
      <toolbar-menu></toolbar-menu>
      <v-slide-y-reverse-transition mode="out-in">
        <template v-if="resourcesIsNotEmpty">
          <v-data-table
            :headers="resources.headers"
            :items="resources.data"
            :loading="resources.loading"
            color="primary"
            item-key="id"
          >
            <template v-slot:progress><span></span></template>

            <template v-slot:loading>
              <v-slide-y-transition mode="out-in">
                <skeleton-avatar-table></skeleton-avatar-table>
              </v-slide-y-transition>
            </template>

            <!-- Avatar and Displayname -->
            <template v-slot:item.name="{ item }">
              <div class="d-flex align-items-center">
                <v-avatar class="mr-6" size="32" color="workspace">
                  <v-img :src="item.avatar"></v-img>
                </v-avatar>

                <v-tooltip bottom>
                  <template v-slot:activator="{ on }">
                    <span class="mt-1" v-on="on">
                      <router-link
                        exact
                        :to="{ name: 'users.edit', params: { id: '1' } }"
                        v-text="item.name"
                        class="text-no-wrap t-d-hover-lined t-d-none"
                      ></router-link>
                    </span>
                  </template>
                  <span v-text="'Edit this user'"></span>
                </v-tooltip>
              </div>
            </template>
            <!-- Avatar and Displayname -->

            <!-- Action buttons -->
            <template v-slot:item.action="{ item }">
              <div class="text-no-wrap">
                <!-- Preview -->
                <v-tooltip bottom>
                  <template v-slot:activator="{ on }">
                    <v-btn text :to="{ name: 'users.show', params: { id: '1' } }" icon v-on="on">
                      <v-icon small>mdi-open-in-new</v-icon>
                    </v-btn>
                  </template>
                  <span v-text="'View details'"></span>
                </v-tooltip>
                <!-- Preview -->
              </div>
            </template>
            <!-- Action buttons -->
          </v-data-table>
        </template>

        <template v-else>
          <empty-state class="mb-10">
            <template v-slot:actions>
              <v-btn large color="primary" exact :to="{ name: 'users.create' }">
                <v-icon small left>mdi-account-plus-outline</v-icon>
                <span v-text="'Add user'"></span>
              </v-btn>
            </template>
          </empty-state>
        </template>
      </v-slide-y-reverse-transition>
    </v-card>
    <!-- Data table -->
  </admin>
</template>

<script>
import { isEmpty } from "lodash";

export default {
  data: () => ({
    resources: {
      loading: true,
      headers: [
        { text: "Account Name", align: "left", value: "name", class: "text-no-wrap" },
        { text: "Email", value: "email", class: "text-no-wrap" },
        { text: "Status", align: "left", value: "status", class: "text-no-wrap" },
        { text: "Last Modified", align: "left", value: "updated_at", class: "text-no-wrap" },
        {
          text: "Actions",
          align: "center",
          value: "action",
          sortable: false,
          class: "muted--text text-no-wrap",
        },
      ],
      data: [
        {
          avatar:
            "https://images.unsplash.com/photo-1580489944761-15a19d654956?ixlib=rb-1.2.1&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=761&q=80",
          name: "Jane Smith",
          email: "janesmith@dummy.io",
          updated_at: "Jan 13, 2022",
          status: "active",
        },
      ],
    },
  }),

  computed: {
    resourcesIsEmpty() {
      return isEmpty(this.resources.data) && !this.resources.loading;
    },

    resourcesIsNotEmpty() {
      return !this.resourcesIsEmpty;
    },
  },
};
</script>
