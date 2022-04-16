<template>
  <admin>
    <metatag title="Cars"></metatag>

    <page-header>
      <template v-slot:action>
        <v-btn
          :block="$vuetify.breakpoint.smAndDown"
          large
          color="primary"
          exact
          :to="{ name: 'cars.create' }"
        >
          <v-icon small left>mdi-plus-circle</v-icon>
          <span v-text="'Add new'"></span>
        </v-btn>
      </template>
    </page-header>
    <v-card>
      <toolbar-menu
        ref="toolbar"
        :filter-model="true" 
        :items.sync="tabletoolbar"
        :isfilterModelColsAuto="false"
        @update:search="setSearch"
        @filter:model="handleFilterModel"
      ></toolbar-menu>
      <v-card-text class="pa-0">
        <v-data-table
          :headers="cars.headers"
          :items="items"
          :options.sync="options"
          :sever-items-length="total"
          :loading="loading"
          :items-per-page="5"
          color="primary"
          item-key="id"
          class="text-no-wrap"
        >
          <template v-slot:item.year="{ item }">
            <span>{{ item.year.name }}</span>
          </template>
          <template v-slot:item.price="{ item }">
            <span>{{ formatPrice(item.price) }}</span>
          </template>
          <template v-slot:item.updated_at="{ item }">
            <span>{{ formatDate(item.update_at) }}</span>
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
              <!-- Preview -->
              <v-tooltip bottom>
                <template v-slot:activator="{ on }">
                  <v-btn
                    text
                    icon
                    v-on="on"
                    :to="{
                      name: 'cars.variant-colors.index',
                      params: { id: item.id }
                    }"
                  >
                    <v-icon small>mdi-car-estate</v-icon>
                  </v-btn>
                </template>
                <span v-text="'View Colors'"></span>
              </v-tooltip>
              <!-- Preview -->
              <!-- Edit -->
              <v-tooltip bottom>
                <template v-slot:activator="{ on }">
                  <v-btn 
                    text 
                    icon
                    v-on="on"
                    :to="{
                      name: 'cars.edit',
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
                  <v-btn text icon @click="handleDeleteVariant(item.id)">
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
        { text: "Model Code", value: "code" },
        { text: "Model Variant", value: "name" },
        { text: "Year", value: "year" },
        { text: "Status", value: "status" },
        { text: "Price", value: "price" },
        { text: "Date updated", value: "updated_at" },
      ],
      tabletoolbar: {
        isSearching: false,
        search: null,
        models: [],
      },
      loading: true,
      options: {},
      items: [],
      total: 0,
      cars: {
        headers: [
          {
            text: "Model Code",
            align: "start",
            sortable: true,
            value: "code",
          },
          {
            text: "Model Variant",
            align: "start",
            sortable: true,
            value: "name",
          },
          {
            text: "Year",
            align: "start",
            sortable: true,
            value: "year",
          },
          {
            text: "Status",
            align: "start",
            sortable: true,
            value: "status",
          },
          {
            text: "Price",
            align: "start",
            sortable: true,
            value: "price",
          },
          {
            text: "Date updated",
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
      data: "cars/GET_VARIANTS",
      models: "models/GET_MODELS",
    }),
  },
  async mounted() {
    await this.listModels();
    this.tabletoolbar.models = this.models;
  },
  methods: {
    ...mapActions({
      getVariants: "cars/list",
      deleteVariant: "cars/delete",
      listModels: "models/list",
      listYears: "years/list",
    }),

    setSearch: debounce(async function (e) {
      const { sortBy, sortDesc, page, itemsPerPage } = this.options;

      this.getItems(page, itemsPerPage, e.target.value);
    }, 300),

    getItems(page, itemsPerPage, q = "", model = "") {
      let data = {
        page,
        per_page: itemsPerPage,
        q,
      }
      if (model) {
        data.model = model;
      }
      this.getVariants(data).then((data) => {
        this.items = this.data.data;
        this.total = this.data.meta.total;
        this.loading = false;
        this.$refs.toolbar.items.isSearching = false;
      });
    },

    formatDate(item) {
      return helpers.format_date(item);
    },

    formatPrice(item) {
      return helpers.format_price(item);
    },

    async handleDeleteVariant(id) {
      this.loading = true;
      await this.deleteVariant(id);
      await this.getItems(1, 5, '');
      this.loading = false;
    },

    async handleFilterModel(val) {
      await this.getItems(1, 5, '', val);
    }
  }
};
</script>

<style></style>
