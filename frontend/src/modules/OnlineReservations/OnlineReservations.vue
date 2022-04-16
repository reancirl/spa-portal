<template>
  <admin>
    <v-row>
      <v-col md="3">
        <UserType :user-list="userList" />
      </v-col>
    </v-row>
    <metatag title="Online Reservations"></metatag>

    <page-header>
      <template v-slot:action>
        <v-btn
          v-if="userType == 'dealer'"
          :block="$vuetify.breakpoint.smAndDown"
          large
          color="info"
          exact
        >
          <v-icon small left>mdi-cloud-upload</v-icon>
          <span v-text="'Upload'"></span>
        </v-btn>
        <v-btn
          v-if="userType == 'hcpi'"
          :block="$vuetify.breakpoint.smAndDown"
          large
          color="grey"
          class="white--text"
          exact
        >
          <v-icon small left>mdi-cloud-download</v-icon>
          <span v-text="'Download'"></span>
        </v-btn>
      </template>
    </page-header>

    <v-row v-if="userType">
      <v-col>
        <v-card class="my-4">
          <toolbar-menu
            :filter-model="true"
            :filter-dealer="true"
            :filter-status="true"
            :filter-action="true"
          ></toolbar-menu>
          <v-card-text class="pa-0">
            <v-data-table
              :headers="resources.headers"
              :items="resources.data"
              :loading="resources.loading"
              color="primary"
              item-key="id"
              class="text-no-wrap"
            >
              <template v-slot:progress><span></span></template>

              <template v-slot:item.name="{ item }">
                <small>{{ item.title }} {{ item.cust_name }} </small> <br />
                <small>{{ item.mobile }}</small> <br />
                <small>{{ item.email }}</small>
              </template>

              <template v-slot:item.vehicle="{ item }">
                <small>{{ item.model }}</small> <br />
                <small>{{ item.variant }}</small> <br />
                <small>{{ item.color }}</small>
              </template>

              <template v-slot:item.status="{ item }">
                <v-chip label>
                  {{ item.status }}
                </v-chip>
              </template>

              <template v-slot:item.action="{ item }">
                <v-chip label>
                  {{ item.action }}
                </v-chip>
              </template>
              <template v-slot:item.editAction="{ item }">
                <div class="text-no-wrap">
                  <!-- Edit -->
                  <v-tooltip bottom>
                    <template v-slot:activator="{ on }">
                      <v-btn @click="editItem(item)" text icon v-on="on">
                        <v-icon small>mdi-pencil</v-icon>
                      </v-btn>
                    </template>
                    <span v-text="'Edit'"></span>
                  </v-tooltip>
                  <!-- Edit -->
                </div>
              </template>
              <template v-slot:loading>
                <v-slide-y-transition mode="out-in">
                  <skeleton-avatar-table></skeleton-avatar-table>
                </v-slide-y-transition>
              </template>
            </v-data-table>
          </v-card-text>
        </v-card>
      </v-col>
    </v-row>
    <v-dialog v-model="actionDialog" max-width="600px" class="overflow-hidden">
      <v-card class="pa-4">
        <v-card-title>
          <h2 title="Edit" class="mb-1">Edit #001</h2>
        </v-card-title>
        <v-card-text class="overflow-y-auto">
          <v-row>
            <v-col cols="12">
              <SalesConsultant />
            </v-col>
          </v-row>
          <v-row>
            <v-col cols="12">
              <v-select
                append-icon="mdi-chevron-down"
                :items="statusList"
                item-text="text"
                item-value="value"
                label="Status"
                outlined
                clearable
                hide-details
                clear-icon="mdi-close-circle-outline"
                background-color="selects"
              ></v-select>
            </v-col>
          </v-row>
          <v-row>
            <v-col cols="12">
              <v-select
                append-icon="mdi-chevron-down"
                :items="actionList"
                item-text="text"
                item-value="value"
                label="Action"
                outlined
                clearable
                hide-details
                clear-icon="mdi-close-circle-outline"
                background-color="selects"
                v-model="action"
              ></v-select>
            </v-col>
          </v-row>
        </v-card-text>
        <v-card-actions>
          <v-spacer></v-spacer>
          <v-btn large color="grey" exact class="ma-1 white--text px-5"> Cancel </v-btn>

          <v-btn large exact color="green darken-1" class="ma-1 white--text px-5">
            <v-icon left>mdi-content-save</v-icon>
            Submit
          </v-btn>
        </v-card-actions>
      </v-card>
    </v-dialog>
  </admin>
</template>

<script>
import UserType from "@/components/UserType/UserType";

export default {
  data() {
    return {
      actionDialog: false,
      userList: [
        {
          text: "HCPI",
          value: "hcpi",
        },
        {
          text: "Dealer",
          value: "dealer",
        },
      ],
      statusList: [
        {
          text: "Paid",
          value: "paid",
        },
        {
          text: "Unpaid",
          value: "unpaid",
        },
        {
          text: "Cancelled",
          value: "cancelled",
        },
        {
          text: "Delivered",
          value: "delivered",
        },
      ],
      actionList: [
        {
          text: "SC to contact",
          value: "SC to contact",
        },
        {
          text: "Pending",
          value: "pending",
        },
        {
          text: "Delivered",
          value: "delivered",
        },
      ],
      resources: {
        loading: true,
        headers: [
          {
            text: "Customer #",
            align: "left",
            value: "cust_number",
            class: "text-no-wrap",
          },
          { text: "Name", align: "left", value: "name", class: "text-no-wrap" },
          { text: "Vehicle", value: "vehicle", class: "text-no-wrap" },
          {
            text: "Reservation Date",
            value: "reservation_date",
            class: "text-no-wrap",
          },
          { text: "SC assigned", value: "sc_assigned", class: "text-no-wrap" },
          {
            text: "SC Assigned Date",
            value: "sc_assigned_date",
            class: "text-no-wrap",
          },
          { text: "Status", value: "status", class: "text-no-wrap" },
          { text: "Action", value: "action", class: "text-no-wrap" },
          {
            text: "Date Updated",
            value: "date_updated",
            class: "text-no-wrap",
          },
          {
            text: "Actions",
            align: "center",
            value: "editAction",
            class: "muted--text text-no-wrap",
          },
        ],
        data: [
          {
            cust_number: "0001",
            title: "Mr",
            cust_name: "Juan De La Cruz",
            date_of_birth: "Nov 11, 1994",
            province: "xxx",
            barangay: "xxx",
            zip_code: "xxx",
            municipality: "xxx",
            house_number: "xxx",
            mobile: "09561234567",
            email: "jdelacruz@test.com",
            reservation_date: "Nov 05, 2021",
            model: "Jazz",
            variant: "1.5 V MT",
            color: "Taffeta White",
            pending_since: "Nov 10, 2021",
            payment_method: "Bank Transfer",
            sc_assigned: "Jem Doe",
            sc_assigned_date: "Nov 06, 2021",
            status: "Pending",
            action: "SC to Contact",
            date_updated: "Nov 11, 2021",
          },
          {
            cust_number: "0002",
            title: "Mr",
            cust_name: "Jane Doe",
            date_of_birth: "Nov 11, 1995",
            province: "xxx",
            barangay: "xxx",
            zip_code: "xxx",
            municipality: "xxx",
            house_number: "xxx",
            mobile: "09561234567",
            email: "janedoe@test.com",
            reservation_date: "Nov 05, 2021",
            model: "City",
            variant: "1.5 S CVT",
            color: "Taffeta White",
            pending_since: "Nov 10, 2021",
            payment_method: "Bank Transfer",
            sc_assigned: "John Doe",
            sc_assigned_date: "Nov 06, 2021",
            status: "Details sent",
            action: "Follow up",
            date_updated: "Nov 11, 2021",
          },
        ],
      },
    };
  },
  components: {
    UserType,
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
      this.actionDialog = true;
    },
  },
};
</script>

<style></style>
