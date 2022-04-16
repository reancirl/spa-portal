<template>
  <admin>
    <metatag title="Download Reports"></metatag>
    <page-header></page-header>
    <section>
      <v-card class="mb-4">
        <v-card-title>
          {{ "Generate & download reports" }}
        </v-card-title>
        <v-divider></v-divider>
        <v-card-text>
          <v-row>
            <v-col cols="4">
              <ReportType />
            </v-col>
            <v-col cols="4">
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
            <v-col cols="4">
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
            <v-col cols="4">
              <Dealer />
            </v-col>
            <v-col cols="4">
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
            <v-col cols="auto">
              <br />
              <v-btn large exact color="primary">
                <v-icon left>mdi-download-box-outline</v-icon>
                {{ "Download" }}
              </v-btn>
            </v-col>
          </v-row>
        </v-card-text>
      </v-card>
    </section>
  </admin>
</template>

<script>
import ReportType from "@/components/ReportType/ReportType";
import Dealer from "@/components/Dealer/Dealer";

export default {
  components: {
    ReportType,
    Dealer,
  },
  computed: {
    reportType() {
      return this.$store.getters.GET_REPORT_TYPE;
    },
    dealer() {
      return this.$store.getters.GET_DEALER;
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
