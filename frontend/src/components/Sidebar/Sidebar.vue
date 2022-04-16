<template>
  <v-navigation-drawer
    :clipped="sidebar.clipped"
    :mini-variant.sync="sidebar.mini"
    app
    floating
    width="290"
    fixed
    v-model="sidebarmodel"
    class="dt-sidebar workspace"
  >
    <!-- Brand -->
    <v-list height="83" class="workspace">
      <v-list-item class="mt-2">
        <v-list-item>
          <img width="100%" :src="logo" :lazy-src="logo" />
        </v-list-item>
        <v-list-item-content>
          <v-list-item-title
            class="primary--text font-weight-bold"
            v-html="app.title"
          ></v-list-item-title>
        </v-list-item-content>
      </v-list-item>
    </v-list>
    <!-- Brand -->

    <!-- Menu Items -->
    <v-list nav class="workspace">
      <template v-for="(parent, i) in menus">
        <!-- Menu with children -->
        <template v-if="parent.meta.divider">
          <v-divider :key="i" class="my-2"></v-divider>
        </template>
        <template v-else-if="parent.meta.subheader">
          <!-- <v-subheader class="text--muted text-capitalize" :key="i" v-text="$t(parent.meta.title)"></v-subheader> -->
          <v-subheader class="text--muted text-capitalize" :key="i"></v-subheader>
        </template>
        <template v-else-if="parent.children">
          <v-list-group :key="i" no-action :prepend-icon="parent.meta.icon" :value="active(parent)">
            <template v-slot:activator>
              <v-list-item-content :title="parent.meta.description">
                <v-list-item-title v-text="$t(parent.meta.title)"></v-list-item-title>
              </v-list-item-content>
            </template>
            <!-- Submenu children -->
            <template v-for="(submenu, j) in parent.children">
              <v-divider v-if="submenu.meta.divider" :key="i"></v-divider>
              <template v-else>
                <template v-if="submenu.children"></template>
                <template v-else-if="submenu.meta.divider">
                  <v-divider :key="i"></v-divider>
                </template>
                <template v-else>
                  <v-list-item
                    :key="j"
                    :target="submenu.meta.external ? '_blank' : null"
                    :to="{ name: submenu.name }"
                    :exact="inactive(submenu)"
                  >
                    <v-list-item-icon v-if="submenu.meta.icon">
                      <v-icon small v-text="submenu.meta.icon"></v-icon>
                    </v-list-item-icon>
                    <v-list-item-content :title="submenu.meta.description">
                      <v-list-item-title v-text="$t(submenu.meta.title)"></v-list-item-title>
                    </v-list-item-content>
                  </v-list-item>
                </template>
              </template>
            </template>
          </v-list-group>
        </template>
        <!-- Menu with Children -->
        <!-- Menu without Children -->
        <template v-else>
          <v-list-item color="primary" :key="i" link :to="{ name: parent.name }">
            <v-list-item-icon>
              <v-icon small v-text="parent.meta.icon"></v-icon>
            </v-list-item-icon>
            <v-list-item-content :title="parent.meta.description">
              <v-list-item-title v-text="$t(parent.meta.title)"></v-list-item-title>
            </v-list-item-content>
          </v-list-item>
        </template>
        <!-- Menu without Children -->
      </template>
    </v-list>
    <!-- Menu Items -->
  </v-navigation-drawer>
</template>

<script>
import app from "@/config/app";
import includes from "lodash/includes";
import menus from "@/config/sidebar";
import { mapGetters, mapActions } from "vuex";
import logo from "@/assets/honda_logo.png";

export default {
  name: "Sidebar",

  computed: {
    ...mapGetters({
      sidebar: "sidebar/sidebar",
      dark: "theme/dark",
      lang: "app/locale",
    }),

    app: function () {
      return app;
    },

    vuetify: function () {
      return this.$vuetify;
    },

    menus: function () {
      return menus;
    },

    sidebarmodel: {
      set(value) {
        this.toggle({ model: value });
      },
      get() {
        return this.sidebar.model;
      },
    },
  },

  data: () => ({
    logo,
  }),

  methods: {
    ...mapActions({
      toggle: "sidebar/toggle",
      clip: "sidebar/clip",
      toggleTheme: "theme/toggle",
    }),

    inactive(path) {
      return !this.active(path);
    },

    active(path) {
      return includes(path.meta.children, this.$route.name);
    },
  },
};
</script>
