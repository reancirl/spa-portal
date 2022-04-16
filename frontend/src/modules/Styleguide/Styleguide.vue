<template>
  <admin>
    <section>
      <v-card class="mb-4">
        <v-card-title>
          {{ "Typography" }}
        </v-card-title>
        <v-divider></v-divider>
        <v-card-text>
          <h1 class="mb-3">h1. Vuetify heading</h1>
          <h2 class="mb-3">h2. Vuetify heading</h2>
          <h3 class="mb-3">h3. Vuetify heading</h3>
          <h4 class="mb-3">h4. Vuetify heading</h4>
          <h5 class="mb-3">h5. Vuetify heading</h5>
          <h6 class="mb-3">h6. Vuetify heading</h6>

          <div class="mb-3 subtitle-1">
            {{ "subtitle-1" }}
          </div>
          <div class="mb-3 subtitle-2">
            {{ "subtitle-2" }}
          </div>
          <div class="mb-3 body-1">
            {{ "body-1" }}
          </div>
          <div class="mb-3 body-2">
            {{ "body-2" }}
          </div>
          <div class="mb-3 text-button">
            {{ "button" }}
          </div>

          <div class="mb-3">
            <span class="overline"> overline </span>
            for timestamps on a single page.
          </div>
        </v-card-text>
      </v-card>

      <v-card class="mb-4">
        <v-card-title>
          {{ "Buttons" }}
        </v-card-title>
        <v-divider></v-divider>
        <v-card-text>
          <v-row>
            <v-col cols="auto">
              <v-btn color="primary" large>
                {{ "Primary button" }}
              </v-btn>
            </v-col>
            <v-col cols="auto">
              <v-btn color="secondary" large>
                {{ "secondary button" }}
              </v-btn>
            </v-col>
          </v-row>
        </v-card-text>

        <v-card-text>
          <v-row justify="start" align="center">
            <v-col cols="auto">
              <v-btn color="success" large>
                {{ "success" }}
              </v-btn>
            </v-col>
            <v-col cols="auto">
              <v-btn color="info" large>
                {{ "info" }}
              </v-btn>
            </v-col>
            <v-col cols="auto">
              <v-btn large>
                {{ "muted" }}
              </v-btn>
            </v-col>
            <v-col cols="auto">
              <v-btn color="error" large>
                {{ "error" }}
              </v-btn>
            </v-col>
            <v-col cols="auto">
              <v-btn color="warning" large>
                {{ "warning" }}
              </v-btn>
            </v-col>
          </v-row>
        </v-card-text>

        <v-card-text>
          <v-row>
            <v-col cols="auto">
              <v-btn color="primary" large>
                <v-icon small left>mdi-account-plus-outline</v-icon>
                {{ "With left icon" }}
              </v-btn>
            </v-col>
            <v-col>
              <v-btn color="primary" large>
                {{ "With right icon" }}
                <v-icon small right>mdi-account-plus-outline</v-icon>
              </v-btn>
            </v-col>
          </v-row>
        </v-card-text>

        <v-card-title>
          {{ "Outlined Buttons" }}
        </v-card-title>
        <v-card-text>
          <v-row>
            <v-col cols="auto">
              <v-btn color="primary" outlined large>
                {{ "primary" }}
              </v-btn>
            </v-col>
            <v-col cols="auto">
              <v-btn color="secondary" outlined large>
                {{ "secondary" }}
              </v-btn>
            </v-col>
          </v-row>
        </v-card-text>

        <v-card-text>
          <v-row>
            <v-col cols="auto">
              <v-btn color="success" outlined large>
                {{ "success" }}
              </v-btn>
            </v-col>
            <v-col cols="auto">
              <v-btn color="info" outlined large>
                {{ "info" }}
              </v-btn>
            </v-col>
            <v-col cols="auto">
              <v-btn color="error" outlined large>
                {{ "error" }}
              </v-btn>
            </v-col>
            <v-col cols="auto">
              <v-btn color="warning" outlined large>
                {{ "warning" }}
              </v-btn>
            </v-col>
            <v-col cols="auto">
              <v-btn outlined large>
                {{ "dark" }}
              </v-btn>
            </v-col>
          </v-row>
        </v-card-text>

        <v-card-title>
          {{ "Icon Button" }}
        </v-card-title>
        <v-card-text>
          <v-btn icon>
            <v-icon small>mdi-close</v-icon>
          </v-btn>
        </v-card-text>
      </v-card>

      <v-card class="mb-4">
        <v-card-title>
          {{ "Fields" }}
        </v-card-title>
        <v-divider></v-divider>
        <v-card-text>
          <v-row>
            <v-col cols="12" md="6">
              <v-text-field
                label="Name"
                class="dt-text-field"
                outlined
                prepend-inner-icon="mdi-account-outline"
              ></v-text-field>
            </v-col>
          </v-row>
          <v-row>
            <v-col cols="12" md="6">
              <v-text-field
                label="Email"
                class="dt-text-field"
                outlined
                type="email"
              ></v-text-field>
            </v-col>
          </v-row>
          <v-row>
            <v-col cols="12" md="6">
              <v-text-field
                label="Password"
                class="dt-text-field"
                outlined
                type="password"
              ></v-text-field>
            </v-col>
          </v-row>
          <v-row>
            <v-col cols="12" md="6">
              <v-select
                append-icon="mdi-chevron-down"
                :items="['Foo', 'Bar']"
                item-text="title"
                label="Selects"
                outlined
                clearable
                clear-icon="mdi-close-circle-outline"
                background-color="selects"
              ></v-select>

              <v-autocomplete
                :items="['Foo', 'Bar']"
                append-icon="mdi-chevron-down"
                outlined
                clearable
                clear-icon="mdi-close-circle-outline"
                background-color="selects"
                label="Autocomplete"
              >
                <template v-slot:no-data>
                  <v-card-text class="pa-2">
                    {{ "No data found" }}
                  </v-card-text>
                </template>
              </v-autocomplete>
            </v-col>
          </v-row>
        </v-card-text>
      </v-card>

      <v-card class="mb-4">
        <v-card-title>
          {{ "Table" }}
        </v-card-title>
        <v-divider></v-divider>
        <v-card-text class="pa-0">
          <toolbar-menu></toolbar-menu>
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
          </v-data-table>
        </v-card-text>
      </v-card>

      <v-card class="mb-4" color="transparent" flat>
        <v-card-title>
          {{ "Cards" }}
        </v-card-title>
        <v-divider></v-divider>
        <v-card-text class="pa-0">
          <v-row>
            <v-col v-for="(n, i) in 4" cols="12" md="3" :key="i">
              <v-card>
                <v-img
                  src="https://cdn.vuetifyjs.com/images/cards/sunshine.jpg"
                  height="200px"
                ></v-img>

                <v-card-title> Top western road trips </v-card-title>

                <v-card-subtitle> 1,000 miles of wonder </v-card-subtitle>

                <v-card-actions>
                  <v-btn color="secondary" text> Explore </v-btn>
                </v-card-actions>
              </v-card>
            </v-col>
          </v-row>
        </v-card-text>
      </v-card>
    </section>
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
