<template>
  <admin>
    <metatag title="Reports"></metatag>
    <page-header></page-header>
    <v-row>
      <v-col md="3">
        <v-select
          append-icon="mdi-chevron-down"
          :items="[]"
          item-text="text"
          item-value="value"
          label="Dealer Zone"
          outlined
          clearable
          hide-details
          clear-icon="mdi-close-circle-outline"
          background-color="selects"
        ></v-select>
      </v-col>
      <v-col md="3">
        <v-select
          append-icon="mdi-chevron-down"
          :items="[]"
          item-text="text"
          item-value="value"
          label="Dealer Group"
          outlined
          clearable
          hide-details
          clear-icon="mdi-close-circle-outline"
          background-color="selects"
        ></v-select>
      </v-col>
      <v-col md="3">
        <Dealer />
      </v-col>
      <v-col md="3">
        <v-text-field
          label="Date range"
          class="dt-text-field"
          type="date"
          outlined
          :disabled="disabled"
          hide-details
        ></v-text-field>
      </v-col>
    </v-row>
    <v-row>
      <v-col cols="4">
        <v-card class="my-4">
          <v-card-title>
            <h3 title="Sales Funnel Summary" class="mb-1">Sales Funnel Summary</h3>
          </v-card-title>
          <v-card-text>
            <pie-chart :data="salesFunnelSummary"></pie-chart>
          </v-card-text>
        </v-card>
      </v-col>
      <v-col cols="4">
        <v-card class="my-4">
          <v-card-title>
            <h3 title="Sales Funnel Summary" class="mb-1">Converted Leads</h3>
          </v-card-title>
          <v-card-text>
            <column-chart :data="convertedLeads" :stacked="true"></column-chart>
          </v-card-text>
        </v-card>
      </v-col>
      <v-col cols="4">
        <v-card class="my-4">
          <v-card-title>
            <h3 title="Sales Funnel Summary" class="mb-1">Status</h3>
          </v-card-title>
          <v-card-text>
            <pie-chart :donut="true" :data="status"></pie-chart>
          </v-card-text>
        </v-card>
      </v-col>
    </v-row>
  </admin>
</template>

<script>
import Dealer from "@/components/Dealer/Dealer";

import Vue from "vue";
import Chartkick from "vue-chartkick";
import Chart from "chart.js";

Vue.use(Chartkick.use(Chart));

export default {
  data() {
    return {
      salesFunnelSummary: [
        ["Inquiries", 235],
        ["Quotations", 66],
        ["Test Drives", 43],
        ["Reservations", 65],
      ],
      convertedLeads: [
        ["HCPA", 7],
        ["HCCL", 7],
        ["HCCP", 5],
        ["HCSW", 8],
      ],
      status: [
        ["Paid", 50],
        ["Unpaid", 25],
        ["Cancelled", 5],
        ["Delivered", 10],
      ],
    };
  },
  components: {
    Dealer,
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
    editItem(item) {
      (this.editedItem.upload_date = item.upload_date), (this.inquiryDialog = true);
    },
  },
};
</script>

<style></style>
