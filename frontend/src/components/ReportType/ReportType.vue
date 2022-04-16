<template v-slot:activator="{ on, attrs }">
  <div v-bind="attrs" v-on="on" no-gutter>
    <v-select
      append-icon="mdi-chevron-down"
      :items="reportList"
      item-text="text"
      item-value="value"
      label="Report"
      outlined
      clearable
      clear-icon="mdi-close-circle-outline"
      background-color="selects"
      v-model="reportType"
      @change="updateReport"
    ></v-select>
  </div>
</template>

<script>
export default {
  data() {
    return {
      reportType: null,
      reportList: [
        {
          text: "Leads progress report",
          value: "leads-progress-report",
        },
        {
          text: "Reservation",
          value: "reservation",
        },
        {
          text: "Inquiries",
          value: "inquiries",
        },
        {
          text: "Test Drives",
          value: "test-drives",
        },
        {
          text: "Quotations",
          value: "quotations",
        },
        {
          text: "Brand assets usage",
          value: "brand-assets-usage",
        },
        {
          text: "User Activity",
          value: "user-activity",
        },
        {
          text: "Sales Consultant List",
          value: "sales-consultant-list",
        },
      ],
    };
  },
  methods: {
    updateReport() {
      this.$store.dispatch("setReportType", this.reportType);
    },
  },
};
</script>

<style></style>
