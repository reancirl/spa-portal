<template>
  <admin>
    <metatag title="Models"></metatag>

    <page-header>
      <template v-slot:action>
        <v-btn
          :block="$vuetify.breakpoint.smAndDown"
          large
          color="primary"
          exact
          :to="{ name: 'cars.models.create' }"
        >
          <v-icon small left>mdi-plus-circle</v-icon>
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
          :headers="cars.headers"
          :items="items"
          :options.sync="options"
          :server-items-length="total"
          :loading="loading"
          :items-per-page="5"
          color="primary"
          item-key="id"
          class="text-no-wrap"
        >
          <template v-slot:item.updated_at="{ item }">
            <span>{{ formatDate(item.updated_at) }}</span>
          </template>
          <template v-slot:item.status="{ item }">
            <v-chip v-if="item.status == true" class="ma-2" color="green" text-color="white">
              active
            </v-chip>
            <v-chip v-else class="ma-2" color="red" text-color="white"> inactive </v-chip>
          </template>
          <!-- Action buttons -->
          <template v-slot:item.actions="{ item }">
            <div class="text-no-wrap">
              <!-- Edit -->
              <v-tooltip bottom>
                <template v-slot:activator="{ on }">
                  <v-btn
                    text
                    icon
                    v-on="on"
                    :to="{ 
                      name: 'cars.models.edit',
                      params: { id: item.id }
                    }"
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
                  <v-btn text icon @click="handleDeleteModel(item.id)">
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
import * as helpers from "@/core/helpers";
import { debounce } from "lodash";

export default {
  data() {
    return {
      filters: [
        { text: "Name", value: "name" },
        { text: "Status", value: "status" },
        { text: "Date Updated", value: "updated_at" },
      ],
      tabletoolbar: {
        isSearching: false,
        search: null,
      },
      loading: true,
      options: {},
      items: [],
      total: 0,
      cars: {
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
            text: "Date Updated",
            align: "start",
            sortable: true,
            value: "updated_at",
          },
          {
            text: "Actions",
            align: "center",
            value: "actions",
            class: "muted--text text-no-wrap",
          },
        ],
        data: [],
      },
    };
  },
  computed: {
    ...mapGetters({
      data: "models/GET_MODELS",
    }),
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
  methods: {
    ...mapActions({
      getModels: "models/list",
      deleteModel: "models/delete",
    }),

    setSearch: debounce(async function (e) {
      const { sortBy, sortDesc, page, itemsPerPage } = this.options;

      this.getItems(1, itemsPerPage, e.target.value);
    }, 300),

    getItems(page, itemsPerPage, q = "") {
      this.getModels({
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

    formatDate(item) {
      return helpers.format_date(item);
    },

    async handleDeleteModel(id) {
      this.loading = true;
      await this.deleteModel(id);
      await this.getItems(1, 5, '');
      this.loading = false;
    }
  }
};
</script>

<style></style>
