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
  </div>
</template>

<script>
export default {
  data() {
    return {
      resources: {
        loading: true,
        headers: [
          { text: "Vehicle Model", align: "center", value: "vehicle_model", class: "text-no-wrap" },
          { text: "Vehicle Desc", align: "center", value: "vehicle_desc", class: "text-no-wrap" },
          {
            text: "Color Description",
            align: "center",
            value: "color_description",
            class: "text-no-wrap",
          },
          { text: "Inventory", align: "center", value: "quantity", class: "text-no-wrap" },
        ],
        data: [
          {
            vehicle_model: "BRIO",
            vehicle_desc: "BRIO 1.2RS BLACK TOP CVT",
            color_description: "TAFFETA WHITE",
            quantity: "3",
          },
          {
            vehicle_model: "CIVIC",
            vehicle_desc: "CIVIC TS Turbo CVT Honda Sensing",
            color_description: "PLATINUM WHITE PEARL",
            quantity: "1",
          },
          {
            vehicle_model: "CITY",
            vehicle_desc: "CITY 1.5RS CVT",
            color_description: "IGNITE RED METALLIC",
            quantity: "1",
          },
        ],
      },
    };
  },
};
</script>
