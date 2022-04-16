<template v-slot:activator="{ on, attrs }">
  <div v-bind="attrs" v-on="on" no-gutter>
    <v-select
      append-icon="mdi-chevron-down"
      :items="dealerList"
      item-text="text"
      item-value="value"
      label="Dealer"
      outlined
      clearable
      hide-details
      multiple
      clear-icon="mdi-close-circle-outline"
      background-color="selects"
      v-model="dealer"
      @change="updateDealer"
    ></v-select>
  </div>
</template>

<script>
export default {
  data() {
    return {
      dealer: null,
      dealerList: [
        {
          text: "All",
          value: "all",
        },
        {
          text: "Honda Cars Bulacan",
          value: "honda-cars-bulacan",
        },
        {
          text: "Honda Cars Baliuag",
          value: "honda-cars-baliuag",
        },
        {
          text: "Honda Cars Calamba",
          value: "honda-cars",
        },
      ],
    };
  },
  methods: {
    updateDealer() {
      this.$store.dispatch("setDealer", this.dealer);
    },
  },
};
</script>

<style></style>
