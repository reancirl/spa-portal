<template>
  <admin>
    <metatag title="Brand Asset Category"></metatag>

    <page-header>
      <template v-slot:action>
        <v-btn
          :block="$vuetify.breakpoint.smAndDown"
          large
          color="primary"
          exact
          :to="{ name: 'brand-asset.categories.create' }"
        >
          <v-icon small left>mdi-account-plus-outline</v-icon>
          <span v-text="'Add new'"></span>
        </v-btn>
      </template>
    </page-header>
    <v-card>
      <toolbar-menu
        ref="toolbar"
        :items.sync="tabletoolbar"
        @update:search="setSearch"
      ></toolbar-menu>
      <v-card-text class="pa-0">
        <v-data-table
          :headers="categories.headers"
          :items="items"
          :options.sync="options"
          :server-items-length="total"
          :loading="loading"
          :items-per-page="5"
          color="primary"
          item-key="id"
          class="text-no-wrap"
        >
          <template v-slot:item.status="{ item }">
            <v-chip v-if="item.status == true" class="ma-2" color="green" text-color="white">
              active
            </v-chip>
            <v-chip v-else class="ma-2" color="red" text-color="white"> inactive </v-chip>
          </template>
          <!-- Action buttons -->
          <template v-slot:item.action="{ item }">
            <div class="text-no-wrap">
              <!-- Edit -->
              <v-tooltip bottom>
                <template v-slot:activator="{ on }">
                  <v-btn
                    text
                    :to="{
                      name: 'brand-asset.categories.edit',
                      params: { id: item.id },
                    }"
                    icon
                    v-on="on"
                  >
                    <v-icon small>mdi-pencil</v-icon>
                  </v-btn>
                </template>
                <span v-text="'Edit'"></span>
              </v-tooltip>
              <!-- Edit -->
              <!-- Delete -->
              <v-tooltip bottom>
                <template v-slot:activator="{ on }">
                  <v-btn text icon v-on="on">
                    <v-icon small>mdi-trash-can</v-icon>
                  </v-btn>
                </template>
                <span v-text="'Delete'"></span>
              </v-tooltip>
              <!-- Delete -->
            </div>
          </template>
          <!-- Action buttons -->
        </v-data-table>
      </v-card-text>
    </v-card>
  </admin>
</template>

<script>
import { mapActions, mapGetters } from "vuex";
import { debounce } from "lodash";

export default {
  data() {
    return {
      filters: [
        { text: "Name", value: "name" },
        { text: "Status", value: "status" },
      ],
      tabletoolbar: {
        isSearching: false,
        search: null,
      },
      loading: true,
      options: {},
      items: [],
      total: 0,
      categories: {
        headers: [
          {
            text: "Name",
            align: "start",
            sortable: true,
            value: "name",
          },
          {
            text: "Status",
            align: "start",
            sortable: true,
            value: "status",
          },
          {
            text: "Actions",
            align: "center",
            value: "action",
            sortable: false,
            class: "muted--text text-no-wrap",
          },
        ],
      },
    };
  },
  watch: {
    options: {
      handler() {
        const { sortBy, sortDesc, page, itemsPerPage } = this.options;

        this.getItems(page, itemsPerPage);
      },
      deep: true,
    },
  },
  computed: {
    ...mapGetters({
      data: "categories/GET_CATEGORIES",
    }),
  },
  methods: {
    ...mapActions({
      getCategories: "categories/getCategories",
    }),

    setSearch: debounce(async function (e) {
      const { sortBy, sortDesc, page, itemsPerPage } = this.options;

      this.getItems(1, itemsPerPage, e.target.value);
    }, 300),

    getItems(page, itemsPerPage, q = "") {
      this.getCategories({
        page: page,
        per_page: itemsPerPage,
        q: q,
      }).then((data) => {
        this.items = this.data.data;
        this.total = this.data.meta.total;
        this.loading = false;
        this.$refs.toolbar.items.isSearching = false;
      });
    },
  },
};
</script>

<style></style>
