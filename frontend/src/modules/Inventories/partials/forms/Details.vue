<template>
  <div>
    <v-card>
      <v-card-title>Inventory Information</v-card-title>
      <v-card-text>
        <v-row>
          <v-col cols="12">
            <v-select
              append-icon="mdi-chevron-down"
              :items="variants"
              item-text="name"
              item-value="value"
              label="Variant"
              outlined
              clearable
              hide-details
              clear-icon="mdi-close-circle-outline"
              background-color="selects"
              v-model="variant"
            ></v-select>
          </v-col>
          <v-col cols="12">
            <v-select
              append-icon="mdi-chevron-down"
              :items="dealers"
              item-text="name"
              item-value="value"
              label="Dealer"
              outlined
              clearable
              hide-details
              clear-icon="mdi-close-circle-outline"
              background-color="selects"
              v-model="dealer"
            ></v-select>
          </v-col>
          <v-col cols="12">
            <v-text-field
              label="Quantity"
              class="dt-text-field"
              outlined
              prepend-inner-icon="mdi-format-list-numbered-rtl"
              hide-details
              v-model="quantity"
            ></v-text-field>
          </v-col>
        </v-row>
        <div class="d-flex justify-end mb-6 mt-10" flat tile>
          <v-btn large exact color="green darken-1" class="ma-1 white--text">
            <v-icon left>mdi-content-save</v-icon>
            Save
          </v-btn>
          <v-btn large exact color="green" class="ma-1 white--text">
            <v-icon left>mdi-content-save</v-icon>
            Save and Exit
          </v-btn>
          <v-btn large exact color="warning" class="ma-1 white--text">
            <v-icon left>mdi-close</v-icon>
            Cancel
          </v-btn>
        </div>
      </v-card-text>
    </v-card>
  </div>
</template>

<script>
export default {
  props: {
    details: {
      required: false,
      type: Object,
      default() {
        return {
          variant: null,
          dealer: null,
          quantity: null,
        };
      },
    },
  },
  data() {
    return {
      variant: null,
      dealer: null,
      quantity: null,
      variants: [
        {
          name: "BRIO 1.2 RS CVT Ruby Red Pear",
          value: "BRIO 1.2 RS CVT Ruby Red Pear",
        },
        {
          name: "HR-V 1.8 E CVT Modern Steal Metallic",
          value: "HR-V 1.8 E CVT Modern Steal Metallic",
        },
      ],
      dealers: [
        {
          name: "Honda Cars Batangas",
          value: "Honda Cars Batangas",
        },
        {
          name: "Honda Cars Bulacan",
          value: "Honda Cars Bulacan",
        },
        {
          name: "Honda Cars Manila",
          value: "Honda Cars Manila",
        },
      ],
    };
  },
  mounted() {
    this.variant = this.details.variant;
    this.dealer = this.details.dealer;
    this.quantity = this.details.quantity;
  },
};
</script>

<style></style>
