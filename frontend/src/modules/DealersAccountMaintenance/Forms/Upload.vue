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

    <v-card class="my-4">
      <v-card-title class="justify-center">
        <v-icon large class="mr-4">mdi-upload</v-icon>
        <h2 class="text-center">Upload via Excel</h2>
      </v-card-title>
      <v-card-text>
        <v-data-table
          :headers="resources.headers"
          :items="resources.data"
          :loading="resources.loading"
          color="primary"
          item-key="id"
        >
          <template v-slot:progress><span></span></template>

          <template v-slot:loading>
            <v-slide-y-transition mode="out-in">
              <skeleton-avatar-table></skeleton-avatar-table>
            </v-slide-y-transition>
          </template>
        </v-data-table>
      </v-card-text>
    </v-card>
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
