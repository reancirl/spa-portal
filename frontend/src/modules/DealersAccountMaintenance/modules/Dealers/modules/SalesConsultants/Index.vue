<template>
  <admin>
    <metatag title="Sales Consultants"></metatag>

    <page-header>
      <template v-slot:action>
        <v-menu bottom offset-y class="pointer">
          <template v-slot:activator="{ on, attrs }">
            <v-btn
              :block="$vuetify.breakpoint.smAndDown"
              large
              color="primary"
              exact
              v-bind="attrs"
              v-on="on"
              class="mx-5 mx-md-2 mt-2 mt-md-0 white--text"
            >
              <v-icon small left>mdi-account-plus-outline</v-icon>
              Add new
            </v-btn>
          </template>
          <v-list>
            <v-list-item
              :to="{ name: 'dealers-account-maintenance.dealers.sales-consultants.create' }"
            >
              <v-list-item-title>
                <v-icon small left>mdi-account-plus-outline</v-icon>
                <span class="text-center px-8 py-1">Individual</span>
              </v-list-item-title>
            </v-list-item>
            <v-list-item
              :to="{ name: 'dealers-account-maintenance.dealers.sales-consultants.upload' }"
            >
              <v-list-item-title>
                <v-icon small left>mdi-cloud-upload</v-icon>
                <span class="text-center px-8 py-1">Upload via excel</span>
              </v-list-item-title>
            </v-list-item>
          </v-list>
        </v-menu>
      </template>
    </page-header>
    <v-card>
      <toolbar-menu></toolbar-menu>
      <v-card-text class="pa-0">
        <v-data-table
          :headers="sales_consultants.headers"
          :items="sales_consultants.data"
          color="primary"
          item-key="id"
          class="text-no-wrap"
        >
          <template v-slot:item.status="{ item }">
            <v-chip v-if="item.status == true" class="ma-2" color="green" text-color="white">
              live
            </v-chip>
            <v-chip v-else class="ma-2" color="red" text-color="white"> inactive </v-chip>
          </template>
          <template v-slot:item.actions="{ item }">
            <div class="text-no-wrap">
              <!-- Edit -->
              <v-tooltip bottom>
                <template v-slot:activator="{ on }">
                  <v-btn
                    text
                    :to="{
                      name: 'dealers-account-maintenance.dealers.sales-consultants.edit',
                      params: { id: '1', salesconsultantid: '1' },
                    }"
                    icon
                    v-on="on"
                  >
                    <v-icon small>mdi-pencil</v-icon>
                  </v-btn>
                </template>
                <span v-text="'Edit'"></span>
              </v-tooltip>
              <!-- Edit -->
              <!-- Delete -->
              <v-tooltip bottom>
                <template v-slot:activator="{ on }">
                  <v-btn text icon v-on="on">
                    <v-icon small>mdi-trash-can</v-icon>
                  </v-btn>
                </template>
                <span v-text="'Delete'"></span>
              </v-tooltip>
              <!-- Delete -->
            </div>
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
      filters: [
        { text: "Name", value: "name" },
        { text: "Status", value: "status" },
        { text: "Date Updated", value: "year" },
      ],
      sales_consultants: {
        headers: [
          { text: "First Name", align: "left", value: "first_name", class: "text-no-wrap" },
          { text: "Last Name", align: "left", value: "last_name", class: "text-no-wrap" },
          { text: "Email", value: "email", class: "text-no-wrap" },
          { text: "CRM ID", value: "crm_id", class: "text-no-wrap" },
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
