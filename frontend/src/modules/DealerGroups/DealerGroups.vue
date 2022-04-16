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
          :to="{ name: 'dealer-groups.create' }"
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
                    :to="{ name: 'dealer-groups.edit', params: { id: '1' } }"
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
export default {
  data() {
    return {
      filters: [
        { text: "Name", value: "name" },
        { text: "Status", value: "status" },
      ],
      dealerZones: {
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
        data: [
          {
            name: "PANGASINAN GRP",
            status: true,
          },
          {
            name: "INDEPENDENT",
            status: false,
          },
          {
            name: "PAMPANGA GRP",
            status: true,
          },
          {
            name: "ANC GROUP",
            status: true,
          },
          {
            name: "YGC QC GROUP",
            status: true,
          },
        ],
      },
    };
  },
};
</script>

<style></style>
