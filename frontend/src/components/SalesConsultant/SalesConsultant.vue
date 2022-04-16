<template v-slot:activator="{ on, attrs }">
  <div v-bind="attrs" v-on="on" no-gutter>
    <v-autocomplete
      append-icon="mdi-chevron-down"
      :items="salesConsultantList"
      item-text="text"
      item-value="value"
      label="Sales Consultant"
      outlined
      clearable
      hide-details
      clear-icon="mdi-close-circle-outline"
      background-color="selects"
      prepend-inner-icon="mdi-account-outline"
      v-model="salesConsultant"
      @change="updateSalesConsultant"
    >
      <template v-slot:no-data>
        <v-card-text class="pa-2">
          {{ "No data found" }}
        </v-card-text>
      </template>
    </v-autocomplete>
  </div>
</template>

<script>
export default {
  data() {
    return {
      salesConsultant: null,
      salesConsultantList: [
        {
          text: "Jane Doe",
          value: "Jane Doe",
        },
        {
          text: "John Doe",
          value: "John Doe",
        },
      ],
    };
  },
  methods: {
    updateSalesConsultant() {
      this.$store.dispatch("setSalesConsultant", this.salesConsultant);
    },
  },
};
</script>

<style></style>
