<template>
  <admin>
    <v-row>
      <v-col md="3">
        <UserType :user-list="userList" />
      </v-col>
    </v-row>

    <metatag title="Test Drive Units"></metatag>

    <page-header>
      <template v-slot:action>
        <v-btn
          v-if="userType == 'hcpi'"
          :block="$vuetify.breakpoint.smAndDown"
          large
          color="info"
          exact
        >
          <v-icon small left>mdi-cloud-upload</v-icon>
          <span v-text="'Upload'"></span>
        </v-btn>
      </template>
    </page-header>

    <v-row v-if="userType">
      <v-col>
        <v-card>
          <toolbar-menu
            v-if="userType == 'hcpi'"
            :filter-model="true"
            :filter-dealer="true"
          ></toolbar-menu>
          <v-card-text class="pa-0">
            <v-data-table
              :headers="available_units.headers"
              :items="available_units.data"
              :loading="available_units.loading"
              color="primary"
              item-key="id"
              class="text-no-wrap"
            >
              <template v-slot:progress><span></span></template>

              <template v-slot:item.quantity="{ item }">
                <strong>{{ item.quantity }}</strong>
              </template>

              <template v-slot:loading>
                <v-slide-y-transition mode="out-in">
                  <skeleton-avatar-table></skeleton-avatar-table>
                </v-slide-y-transition>
              </template>
            </v-data-table>
          </v-card-text>
        </v-card>
      </v-col>
    </v-row>
  </admin>
</template>

<script>
import UserType from "@/components/UserType/UserType";

export default {
  data() {
    return {
      userList: [
        {
          text: "HCPI",
          value: "hcpi",
        },
        {
          text: "Dealer",
          value: "dealer",
        },
      ],
      available_units: {
        loading: true,
        headers: [
          { text: "Vehicle Model", align: "center", value: "vehicle_model", class: "text-no-wrap" },
          {
            text: "Vehicle Description",
            align: "center",
            value: "vehicle_desc",
            class: "text-no-wrap",
          },
          {
            text: "Color Description",
            align: "center",
            value: "color_desc",
            class: "text-no-wrap",
          },
          { text: "Dealer Name", align: "center", value: "dealer_name", class: "text-no-wrap" },
          { text: "Inventory", align: "center", value: "quantity", class: "text-no-wrap" },
          {
            text: "Date Updated",
            align: "start",
            sortable: true,
            value: "updated_at",
          },
        ],
        data: [
          {
            vehicle_model: "BRIO",
            vehicle_desc: "BRIO 1.2RS BLACK TOP CVT",
            color_desc: "TAFFETA WHITE",
            dealer_name: "HCZM",
            quantity: "1",
            updated_at: "Dec 25, 2021",
          },
          {
            vehicle_model: "CIVIC",
            vehicle_desc: "CIVIC RS Turbo CVT Honda Sensing",
            color_desc: "PLATINUM WHITE PEARL",
            dealer_name: "HCZM",
            quantity: "1",
            updated_at: "Dec 25, 2021",
          },
        ],
      },
    };
  },
  components: {
    UserType,
  },
  computed: {
    userType() {
      return this.$store.getters.GET_USER_TYPE;
    },
  },
  methods: {
    showTip(e) {
      document.querySelector(".tooltip-message").classList.remove("d-none");
    },
  },
};
</script>

<style></style>
