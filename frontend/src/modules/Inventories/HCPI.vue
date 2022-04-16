<template>
  <div>
    <v-card class="my-4">
      <toolbar-menu></toolbar-menu>
      <v-card-text class="pa-0">
        <v-data-table
          :headers="resources.headers"
          :items="resources.data"
          :loading="resources.loading"
          color="primary"
          item-key="id"
        >
          <template v-slot:progress><span></span></template>

          <template v-slot:item.dealer_name="{ item }"> {{ item.dealer_name }} <br /> </template>

          <template v-slot:item.vehicle="{ item }">
            <small>{{ item.model }}</small> <br />
            <small>{{ item.variant }}</small> <br />
            <small>{{ item.color_name }}</small> <br />
          </template>

          <template v-slot:item.quantity="{ item }">
            <strong>{{ item.quantity }}</strong>
          </template>

          <template v-slot:item.actions="{ item }">
            <div class="text-no-wrap">
              <!-- Edit -->
              <v-tooltip bottom>
                <template v-slot:activator="{ on }">
                  <v-btn
                    :to="{ name: 'inventories.edit', params: { id: '1' } }"
                    text
                    icon
                    v-on="on"
                  >
                    <v-icon small>mdi-pencil</v-icon>
                  </v-btn>
                </template>
                <span v-text="'Edit'"></span>
              </v-tooltip>
              <!-- Edit -->
            </div>
          </template>

          <template v-slot:loading>
            <v-slide-y-transition mode="out-in">
              <skeleton-avatar-table></skeleton-avatar-table>
            </v-slide-y-transition>
          </template>
        </v-data-table>
      </v-card-text>
    </v-card>
  </div>
</template>

<script>
export default {
  data() {
    return {
      resources: {
        loading: true,
        headers: [
          { text: "Dealer Name", align: "left", value: "dealer_name", class: "text-no-wrap" },
          { text: "Vehicle", align: "center", value: "vehicle", class: "text-no-wrap" },
          { text: "Year Model", align: "center", value: "year_model", class: "text-no-wrap" },
          { text: "Vehicle ID", align: "center", value: "vehicle_id", class: "text-no-wrap" },
          { text: "Inventory", align: "center", value: "quantity", class: "text-no-wrap" },
          { text: "Price", align: "center", value: "price", class: "text-no-wrap" },
          { text: "Date updated", align: "center", value: "date_updated", class: "text-no-wrap" },
          {
            text: "Actions",
            value: "actions",
            class: "muted--text text-no-wrap",
            align: "center",
            sortable: false,
          },
        ],
        data: [
          {
            dealer_name: "HONDA CARS BATANGAS",
            dealer_code: "D606",
            model: "BRIO",
            variant: "BTIO 1.2RS CVT",
            year_model: "2020",
            vehicle_id: "DD189LL",
            color_name: "MODERN STEEL METALLIC",
            color_code: "NH-797M",
            quantity: "1",
            price: "XX",
            date_updated: "Nov 26, 2021",
          },
          {
            dealer_name: "HONDA CARS MAKATI, INC.",
            dealer_code: "B307",
            model: "HR-V",
            variant: "HR-V 1.8E CVT",
            year_model: "2021",
            vehicle_id: "RU583ML",
            color_name: "LUNAR SILVER METALLIC",
            color_code: "NH-830M",
            quantity: "1",
            price: "XX",
            date_updated: "Nov 26, 2021",
          },
          {
            dealer_name: "HONDA CARS MANILA",
            dealer_code: "D506",
            model: "BR-V",
            variant: "BR-B 1.5V CVT",
            year_model: "2021",
            vehicle_id: "DG184ML",
            color_name: "MODERN STEEL METALLIC",
            color_code: "NH-797M",
            quantity: "1",
            price: "XX",
            date_updated: "Nov 26, 2021",
          },
        ],
      },
    };
  },
};
</script>
