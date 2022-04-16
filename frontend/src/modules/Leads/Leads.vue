<template>
  <admin>
    <v-row>
      <v-col md="3">
        <UserType :user-list="userList" />
      </v-col>
    </v-row>

    <metatag title="Leads"></metatag>

    <page-header>
      <template v-slot:action>
        <v-btn
          v-if="userType == 'hcpi'"
          :block="$vuetify.breakpoint.smAndDown"
          large
          color="info"
          exact
        >
          <v-icon small left>mdi-cloud-upload</v-icon>
          <span v-text="'Upload'"></span>
        </v-btn>

        <v-btn
          v-if="userType == 'dealer'"
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

    <v-card class="my-0">
      <toolbar-menu :filter-status="true"></toolbar-menu>
      <v-card-text class="pa-0">
        <v-data-table
          :headers="leads.headers"
          :items="leads.data"
          :loading="loading"
          color="primary"
          item-key="id"
          class="py-0 text-no-wrap"
        >
          <template v-slot:progress><span></span></template>

          <template v-slot:item.full_name="{ item }">
            <small>{{ item.first_name }} {{ item.last_name }} </small> <br />
            <small>{{ item.email }} </small> <br />
            <small>{{ item.mobile_number }} </small> <br />
          </template>

          <template v-slot:item.vehicle="{ item }">
            <small>{{ item.model }}</small> <br />
            <small>{{ item.variant }}</small> <br />
          </template>

          <template v-slot:item.status="{ item }">
            <v-chip label>
              {{ item.status }}
            </v-chip>
          </template>

          <template v-slot:item.editAction="{ item }">
            <div class="text-no-wrap">
              <!-- Preview -->
              <v-tooltip bottom>
                <template v-slot:activator="{ on }">
                  <v-btn @click="previewItem(item)" text icon v-on="on">
                    <v-icon small>mdi-eye</v-icon>
                  </v-btn>
                </template>
                <span v-text="'Preview'"></span>
              </v-tooltip>
              <!-- Preview -->
              <!-- Edit -->
              <v-tooltip bottom v-if="userType == 'dealer'">
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
    <v-dialog
      v-model="leadDialog"
      max-width="600px"
      class="overflow-hidden"
      v-if="userType == 'dealer'"
    >
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
                :items="[]"
                item-text="text"
                item-value="value"
                label="Variant"
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
              <v-text-field
                label="Street / House Number"
                outlined
                clearable
                hide-details
                background-color="selects"
              ></v-text-field>
            </v-col>
          </v-row>
          <v-row>
            <v-col cols="12">
              <v-select
                append-icon="mdi-chevron-down"
                :items="[]"
                item-text="text"
                item-value="value"
                label="Province"
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
                :items="[]"
                item-text="text"
                item-value="value"
                label="Municipality"
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
                :items="[]"
                item-text="text"
                item-value="value"
                label="Barangay"
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
              <v-text-field
                label="Zipcode"
                outlined
                clearable
                hide-details
                background-color="selects"
              ></v-text-field>
            </v-col>
          </v-row>
          <v-row>
            <v-col cols="12">
              <v-text-field
                label="Preferred Communication"
                outlined
                clearable
                hide-details
                background-color="selects"
              ></v-text-field>
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
    <v-dialog v-model="previewDialog" max-width="600px" class="overflow-hidden">
      <v-card class="pa-4">
        <v-card-title>
          <h2 title="Edit" class="mb-1">#001</h2>
        </v-card-title>
        <v-card-text class="overflow-y-auto">
          <!-- Background Details -->
          <v-simple-table>
            <template v-slot:default>
              <tbody>
                <tr>
                  <td class="font-weight-bold">{{ "Customer" }}</td>
                  <td v-text="'Mr. Juan De La Cruz'"></td>
                </tr>
                <tr>
                  <td class="font-weight-bold">{{ "Province" }}</td>
                  <td v-text="'Bulacan'"></td>
                </tr>
                <tr>
                  <td class="font-weight-bold">{{ "Municipality" }}</td>
                  <td v-text="'Baliuag'"></td>
                </tr>
                <tr>
                  <td class="font-weight-bold">{{ "Zip Code" }}</td>
                  <td v-text="'3006'"></td>
                </tr>
                <tr>
                  <td class="font-weight-bold">{{ "Barangay" }}</td>
                  <td v-text="'Tarcan'"></td>
                </tr>
                <tr>
                  <td class="font-weight-bold">{{ "Street" }}</td>
                  <td v-text="'103'"></td>
                </tr>
                <tr>
                  <td class="font-weight-bold">{{ "Mobile" }}</td>
                  <td v-text="'09261234567'"></td>
                </tr>
                <tr>
                  <td class="font-weight-bold">
                    {{ "Preferred Communication" }}
                  </td>
                  <td v-text="'Email'"></td>
                </tr>
                <tr>
                  <td class="font-weight-bold">
                    {{ "Activity Source" }}
                  </td>
                  <td v-text="'FB Page'"></td>
                </tr>
                <tr>
                  <td class="font-weight-bold">{{ "Email" }}</td>
                  <td v-text="'jcruz.21@gmail.com'"></td>
                </tr>
                <tr>
                  <td class="font-weight-bold">{{ "Model" }}</td>
                  <td v-text="'Jazz'"></td>
                </tr>
                <tr>
                  <td class="font-weight-bold">{{ "Variant" }}</td>
                  <td v-text="'1.5 V MT'"></td>
                </tr>
                <tr>
                  <td class="font-weight-bold">{{ "Inquiry Date" }}</td>
                  <td v-text="'Nov 11, 2021'"></td>
                </tr>
                <tr>
                  <td class="font-weight-bold">{{ "Preferred Dealer" }}</td>
                  <td v-text="'HCMA'"></td>
                </tr>
                <tr>
                  <td class="font-weight-bold">{{ "Sales Consultant" }}</td>
                  <td v-text="'Jane Doe'"></td>
                </tr>
                <tr>
                  <td class="font-weight-bold">{{ "Status" }}</td>
                  <td>
                    <v-chip label> Pending </v-chip>
                  </td>
                </tr>
                <tr>
                  <td class="font-weight-bold">{{ "Assigned Date" }}</td>
                  <td v-text="'Nov 11, 2021'"></td>
                </tr>
                <tr>
                  <td class="font-weight-bold">{{ "Acceptance Date" }}</td>
                  <td v-text="'Nov 11, 2021'"></td>
                </tr>
                <tr>
                  <td class="font-weight-bold">{{ "Date Uploaded" }}</td>
                  <td v-text="'Nov 11, 2021'"></td>
                </tr>
                <tr>
                  <td class="font-weight-bold">{{ "Date Created" }}</td>
                  <td v-text="'Nov 11, 2021'"></td>
                </tr>
                <tr>
                  <td class="font-weight-bold">{{ "Date Updated" }}</td>
                  <td v-text="'Nov 11, 2021'"></td>
                </tr>
              </tbody>
            </template>
          </v-simple-table>
          <!-- Background Details -->
        </v-card-text>
        <v-card-actions>
          <v-spacer></v-spacer>
          <v-btn large color="grey" exact class="ma-1 white--text px-5"> Close </v-btn>
        </v-card-actions>
      </v-card>
    </v-dialog>
  </admin>
</template>

<script>
import UserType from "@/components/UserType/UserType";

export default {
  components: {
    UserType,
  },
  data() {
    return {
      loading: false,
      leadDialog: false,
      previewDialog: false,
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
          text: "Pending",
          value: "Pending",
        },
        {
          text: "Details Sent",
          value: "Details sent",
        },
        {
          text: "Closed (booked)",
          value: "closed-booked",
        },
        {
          text: "Closed (sales)",
          value: "closed-sales",
        },
        {
          text: "Closed (didn't convert)",
          value: "closed-didnt-convert",
        },
      ],
      dialog: false,
      dialogDelete: false,
      leads: {
        headers: [
          {
            text: "Uploaded date",
            align: "start",
            sortable: true,
            value: "upload_date",
          },
          {
            text: "Acceptance date",
            align: "start",
            sortable: true,
            value: "acceptance_date",
          },
          {
            text: "Full Name",
            align: "start",
            sortable: true,
            value: "full_name",
          },
          {
            text: "Preferred Dealer",
            align: "start",
            sortable: true,
            value: "preferred_dealer",
          },
          {
            text: "Vehicle",
            align: "start",
            sortable: true,
            value: "vehicle",
          },
          {
            text: "SC Assigned Date",
            align: "start",
            sortable: true,
            value: "sc_assgined_date",
          },
          {
            text: "Assigned SC",
            align: "start",
            sortable: true,
            value: "assigned_sc",
          },
          {
            text: "Status",
            align: "start",
            sortable: true,
            value: "status",
          },
          {
            text: "Date Updated",
            align: "start",
            sortable: true,
            value: "date_updated",
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
            upload_date: "Nov 23, 2021",
            acceptance_date: "Nov 25, 2021",
            activity_source: "FB Page",
            first_name: "Bob",
            last_name: "Javier",
            mobile_number: "09171234567",
            email: "b.javier@gmail.com",
            preferred_dealer: "HCCL",
            model: "BRIO",
            variant: "1.2RS BLACK TOP CVT",
            sc_assgined_date: "Nov 25, 2021",
            assigned_sc: "Kristina Uy",
            province: "Rizal",
            barangay: "Dalig",
            zip_code: "1234",
            municipality: "Antipolo",
            house_number: "1234 B Kaymito",
            preferred_communication_method: "email",
            status: "Pending",
            date_upload: "Dec 25, 2021",
          },
        ],
      },
      editedIndex: -1,
      editedItem: {
        upload_date: null,
        acceptance_date: null,
        activity_source: null,
        first_name: null,
        last_name: null,
        mobile_number: null,
        email: null,
        preferred_dealer: null,
        model: null,
        variant: null,
      },
      defaultItem: {
        upload_date: null,
        acceptance_date: null,
        activity_source: null,
        first_name: null,
        last_name: null,
        mobile_number: null,
        email: null,
        preferred_dealer: null,
        model: null,
        variant: null,
      },
    };
  },
  computed: {
    userType() {
      return this.$store.getters.GET_USER_TYPE;
    },
  },

  watch: {},
  created() {},
  methods: {
    previewItem(item) {
      this.previewDialog = true;
    },
    editItem(item) {
      (this.editedItem.upload_date = item.upload_date),
        (this.editedItem.acceptance_date = item.acceptance_date),
        (this.editedItem.activity_source = item.acceptance_date),
        (this.editedItem.first_name = item.acceptance_date),
        (this.editedItem.last_name = item.acceptance_date),
        (this.editedItem.mobile_number = item.acceptance_date),
        (this.editedItem.email = item.acceptance_date),
        (this.editedItem.preferred_dealer = item.acceptance_date),
        (this.editedItem.model = item.acceptance_date),
        (this.editedItem.variant = item.acceptance_date),
        (this.leadDialog = true);
    },
  },
};
</script>

<style></style>
