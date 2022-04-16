<template>
  <v-app-bar
    app
    class="workspace elevation-1"
    :hide-on-scroll="$vuetify.breakpoint.mdAndUp"
    :clipped-left="sidebar.clipped"
    v-if="appbar.model"
    :height="$vuetify.breakpoint.mdAndUp ? 83 : null"
  >
    <v-badge
      bordered
      bottom
      class="dt-badge"
      color="dark"
      content="k"
      offset-x="20"
      offset-y="20"
      tile
      transition="fade-transition"
      v-model="$store.getters['shortkey/ctrlIsPressed']"
    >
      <v-app-bar-nav-icon
        color="muted"
        @click="toggle({ model: !sidebar.model })"
        v-shortkey.once="['ctrl', 'k']"
        @shortkey="toggle({ model: !sidebar.model })"
      ></v-app-bar-nav-icon>
    </v-badge>

    <slot>
      <v-spacer></v-spacer>

      <v-menu
        class="justify-end d-flex"
        min-width="200px"
        transition="slide-y-transition"
        offset-y
        nudge-bottom
      >
        <template v-slot:activator="{ on: menu }">
          <div v-on="{ ...menu }" role="button">
            <div class="d-flex justify-space-between align-center">
              <v-badge color="red" dot overlap class="mr-5">
                <v-icon color="grey lighten-1" large> mdi-bell </v-icon>
              </v-badge>
              <h4 v-if="user !== null">
                {{ user.first_name + " " + user.last_name }}
                <v-icon small right>mdi-chevron-down</v-icon>
              </h4>
            </div>
          </div>
        </template>

        <v-list max-width="250">
          <v-list-item :to="{ name: 'profile' }" exact>
            <v-list-item-action>
              <v-icon small class="text--muted">mdi-account-outline</v-icon>
            </v-list-item-action>
            <v-list-item-content>
              <v-list-item-title v-text="trans('Profile')"></v-list-item-title>
            </v-list-item-content>
          </v-list-item>

          <v-list-item :to="{ name: 'settings.general' }" exact>
            <v-list-item-action>
              <v-icon small>mdi-tune</v-icon>
            </v-list-item-action>
            <v-list-item-content>
              <v-list-item-title v-text="trans('Settings')"></v-list-item-title>
            </v-list-item-content>
          </v-list-item>

          <v-list-item exact @click="logout">
            <v-list-item-action>
              <v-icon small>mdi-power</v-icon>
            </v-list-item-action>
            <v-list-item-content>
              <v-list-item-title v-text="trans('Logout')"></v-list-item-title>
            </v-list-item-content>
          </v-list-item>
        </v-list>
      </v-menu>
    </slot>
  </v-app-bar>
</template>

<script>
import { mapGetters, mapActions } from "vuex";

export default {
  name: "Appbar",
  data() {
    return {
      user: null,
    };
  },
  computed: {
    ...mapGetters({
      appbar: "appbar/appbar",
      sidebar: "sidebar/sidebar",
      err: "auth/GET_ERR",
    }),
  },
  created() {
    if (!localStorage.user) {
      this.$router.push({ name: "login" });
    } else {
      this.user = JSON.parse(localStorage.user);
    }
  },
  methods: {
    ...mapActions({
      toggle: "sidebar/toggle",
      snackbarShow: "snackbar/show",
      authLogout: "auth/logout",
    }),
    async logout() {
      await this.authLogout();

      if (this.err.message) {
        this.snackbarShow({
          text: this.err.message,
        });
      } else {
        this.$router.push({ name: "login" });
      }
    },
  },
};
</script>
