<template>
  <admin>
    <metatag title="News"></metatag>

    <page-header>
      <template v-slot:action>
        <v-btn
          :block="$vuetify.breakpoint.smAndDown"
          large
          color="primary"
          exact
          :to="{ name: 'dealer-zones.create' }"
        >
          <v-icon small left>mdi-account-plus-outline</v-icon>
          <span v-text="'Add new'"></span>
        </v-btn>
      </template>
    </page-header>
    <v-card>
      <toolbar-menu></toolbar-menu>
      <v-card-text class="pa-0">
        <v-data-table
          :headers="dealerZones.headers"
          :items="dealerZones.data"
          :options.sync="options"
          :loading="loading"
          :items-per-page="10"
          color="primary"
          item-key="id"
          class="text-no-wrap"
        >
          <template v-slot:item.status="{ item }">
            <v-chip v-if="item.status == '1'" class="ma-2" color="green" text-color="white">
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
                    :to="{ name: 'dealer-zones.edit', params: { id: item.id } }"
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
                  <v-btn text icon v-on="on" @click="deleteZone(item.id)">
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
      loading: true,
      tabletoolbar: {
        isSearching: false,
        search: null,
      },
      options: {},
      total: 0,
      filters: [
        { text: "Name", value: "name" },
        { text: "Status", value: "status" },
      ],
      dealerZones: {
        per_page: 10,
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
        data: [],
      },
    };
  },
  watch: {
    options: {
      handler() {
        const { sortBy, sortDesc, page, itemsPerPage } = this.options;

        this.getItems(this.dealerZones.per_page);
      },
      deep: true,
    },
  },
  computed: {
    ...mapGetters({
      data: "zones/GET_ZONES",
    }),
  },
  methods: {
    ...mapActions({
      getZones: "zones/getZones",
      deleteZone: "zones/delete",
    }),

    setSearch: debounce(async function (e) {
      const { sortBy, sortDesc, page, itemsPerPage } = this.options;

      this.getItems(1, itemsPerPage, e.target.value);
    }, 300),

    getItems(page, itemsPerPage, q = "") {
      this.getZones({
        page: page,
        per_page: itemsPerPage,
        q: q,
      }).then((data) => {
        this.dealerZones.data = this.data.data;
        this.loading = false;
        this.$refs.toolbar.items.isSearching = false;
      });
    },
  },
};
</script>

<style></style>
