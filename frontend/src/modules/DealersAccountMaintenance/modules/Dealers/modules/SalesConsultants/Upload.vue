<template>
  <admin>
    <page-header
      :back="{
        to: {
          name: 'dealers-account-maintenance.dealers.sales-consultants.index',
          params: { id: 1 },
        },
        text: trans('Sales Consultants'),
      }"
    >
      <template v-slot:title><span v-text="trans('Upload Sales Consultants')"></span></template>
    </page-header>

    <div class="row">
      <div class="col-lg-9 col-12">
        <v-card>
          <v-card-title>File Information</v-card-title>
          <v-card-text>
            <v-row>
              <v-col cols="12">
                <v-file-input
                  label="Upload File"
                  accept=".csv, application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, application/vnd.ms-excel"
                  outlined
                  hide-details
                  v-model="first_name"
                ></v-file-input>
              </v-col>
            </v-row>
            <div class="d-flex justify-end my-6" flat tile>
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
    </div>
  </admin>
</template>

<script>
export default {
  data() {
    return {
      resources: {
        loading: true,
        headers: [
          { text: "First Name", align: "left", value: "first_name", class: "text-no-wrap" },
          { text: "Last Name", align: "left", value: "last_name", class: "text-no-wrap" },
          { text: "Email", value: "email", class: "text-no-wrap" },
          { text: "CRM ID", value: "crm_id", class: "text-no-wrap" },
        ],
        data: [
          {
            first_name: "John",
            last_name: "Cruz",
            email: "JC@gmail.com",
            crm_id: "123456",
          },
          {
            first_name: "Mark",
            last_name: "Joson",
            email: "MJ@gmail.com",
            crm_id: "123456",
          },
          {
            first_name: "Lexie",
            last_name: "Santos",
            email: "LS@gmail.com",
            crm_id: "123456",
          },
        ],
      },
    };
  },
};
</script>

<style></style>
