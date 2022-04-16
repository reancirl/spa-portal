<template>
  <admin>
    <v-row>
      <v-col md="3">
        <UserType :user-list="userList" />
      </v-col>
    </v-row>
    <metatag title="Quotations"></metatag>

    <page-header></page-header>

    <v-row v-if="userType">
      <v-col>
        <v-card>
          <toolbar-menu
            :filter-model="true"
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

              <template v-slot:loading>
                <v-slide-y-transition mode="out-in">
                  <skeleton-avatar-table></skeleton-avatar-table>
                </v-slide-y-transition>
              </template>

              <template v-slot:item.name="{ item }">
                <small>{{ item.title }} {{ item.cust_name }}</small> <br />
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
                  <!-- Upload -->
                  <v-tooltip bottom v-if="userType == 'dealer'">
                    <template v-slot:activator="{ on }">
                      <v-btn text icon v-on="on">
                        <v-icon small>mdi-upload</v-icon>
                      </v-btn>
                    </template>
                    <span v-text="'Upload'"></span>
                  </v-tooltip>
                  <!-- Upload -->
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
            </v-data-table>
          </v-card-text>
        </v-card>
      </v-col>
    </v-row>
    <v-dialog
      v-model="inquiryDialog"
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
                  <td class="font-weight-bold">{{ "Date or Birth" }}</td>
                  <td v-text="'Nov 11, 1994'"></td>
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
                  <td class="font-weight-bold">{{ "Color" }}</td>
                  <td v-text="'Taffeta white'"></td>
                </tr>
                <tr>
                  <td class="font-weight-bold">{{ "Inquiry Date" }}</td>
                  <td v-text="'Nov 11, 2021'"></td>
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
                  <td class="font-weight-bold">{{ "Action" }}</td>
                  <td>
                    <v-chip label> SC to Contact </v-chip>
                  </td>
                </tr>
                <tr>
                  <td class="font-weight-bold">{{ "Assigned Date" }}</td>
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
import SalesConsultant from "@/components/SalesConsultant/SalesConsultant";

export default {
  data() {
    return {
      inquiryDialog: false,
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
          text: "Quotation Sent",
          value: "Quotation sent",
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
      actionList: [
        {
          text: "SC to contact",
          value: "SC to contact",
        },
        {
          text: "Follow up",
          value: "Follow up",
        },
      ],
      resources: {
        loading: true,
        headers: [
          { text: "Cust. #", align: "left", value: "cust_number", class: "text-no-wrap" },
          { text: "Name", align: "left", value: "name", class: "text-no-wrap" },
          { text: "Date of Birth", value: "date_of_birth", class: "text-no-wrap" },
          { text: "Vehicle", value: "vehicle", class: "text-no-wrap" },
          { text: "Sales Consultant", value: "sales_consultant", class: "text-no-wrap" },
          { text: "Status", value: "status", class: "text-no-wrap" },
          { text: "Action", value: "action", class: "text-no-wrap" },
          { text: "Date Created", value: "date_created", class: "text-no-wrap" },
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
            province: "Davao Del Sur",
            barangay: "Brgy Duterte",
            zip_code: "8000",
            municipality: "Davao City",
            house_number: "Blk 1",
            mobile: "09171234567",
            email: "delacruz@yahoo.com",
            model: "Jazz",
            variant: "1.5 V MT",
            color: "Taffeta White",
            sales_consultant: "Jane Doe",
            status: "Pending",
            action: "SC to Contact",
            date_created: "Nov 11, 2021",
          },
          {
            cust_number: "0002",
            title: "Mr",
            cust_name: "John Doe",
            date_of_birth: "Nov 11, 1995",
            province: "xxx",
            barangay: "xxx",
            zip_code: "xxx",
            municipality: "xxx",
            house_number: "xxx",
            mobile: "09213456789",
            email: "johndoe@test.com",
            model: "City",
            variant: "1.5 S CVT",
            color: "Taffeta White",
            sales_consultant: "Jem Doe",
            status: "Details sent",
            action: "Follow up",
            date_created: "Nov 11, 2021",
          },
        ],
      },
      editedItem: {
        sales_consultant: null,
        status: null,
        action: null,
      },
    };
  },
  components: {
    UserType,
    SalesConsultant,
  },
  computed: {
    userType() {
      return this.$store.getters.GET_USER_TYPE;
    },
  },
  methods: {
    previewItem(item) {
      this.previewDialog = true;
    },
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
