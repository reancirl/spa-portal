<template>
  <div>
    <v-card>
      <v-card-title>Account Information</v-card-title>
      <v-card-text>
        <v-row>
          <v-col cols="12">
            <v-text-field
              label="Code"
              class="dt-text-field"
              outlined
              prepend-inner-icon="mdi-barcode-scan"
              hide-details
              v-model="code"
            ></v-text-field>
          </v-col>
          <v-col cols="12">
            <v-text-field
              type="email"
              label="Email"
              class="dt-text-field"
              outlined
              prepend-inner-icon="mdi-at"
              hide-details
              v-model="email"
            ></v-text-field>
          </v-col>
          <v-col cols="12">
            <v-text-field
              label="Dealer Name"
              class="dt-text-field"
              outlined
              prepend-inner-icon="mdi-account-outline"
              hide-details
              v-model="name"
            ></v-text-field>
          </v-col>
          <v-col cols="12">
            <v-text-field
              label="Address"
              class="dt-text-field"
              outlined
              prepend-inner-icon="mdi-map-marker"
              hide-details
              v-model="address"
            ></v-text-field>
          </v-col>
          <v-col cols="12">
            <v-text-field
              label="Contact Information"
              class="dt-text-field"
              outlined
              prepend-inner-icon="mdi-card-account-phone-outline"
              hide-details
              v-model="contact_information"
            ></v-text-field>
          </v-col>
          <v-col cols="12">
            <v-card class="mx-auto" outlined>
              <v-card-title class="pb-0"> <v-icon left>mdi-bank</v-icon>Bank Details</v-card-title>
              <v-card-text class="py-0">
                <v-col cols="12">
                  <v-text-field
                    label="Bank"
                    class="dt-text-field"
                    outlined
                    hide-details
                    v-model="bank"
                  ></v-text-field>
                </v-col>
                <v-col cols="12">
                  <v-text-field
                    label="Bank Account Name"
                    class="dt-text-field"
                    outlined
                    hide-details
                    v-model="bank_account_name"
                  ></v-text-field>
                </v-col>
                <v-col cols="12">
                  <v-text-field
                    label="Bank Account Number"
                    class="dt-text-field"
                    outlined
                    hide-details
                    v-model="bank_account_number"
                  ></v-text-field>
                </v-col>
              </v-card-text>
            </v-card>
          </v-col>
          <v-col cols="12">
            <v-text-field
              label="Dealer PIC Name"
              class="dt-text-field"
              outlined
              prepend-inner-icon="mdi-account-outline"
              hide-details
              v-model="dealer_pic_name"
            ></v-text-field>
          </v-col>
          <v-col cols="12">
            <v-text-field
              label="Dealer PIC Email"
              class="dt-text-field"
              outlined
              prepend-inner-icon="mdi-at"
              hide-details
              v-model="pic_email_address"
            ></v-text-field>
          </v-col>
          <v-col cols="12">
            <v-select
              append-icon="mdi-chevron-down"
              :items="zoneList"
              item-text="text"
              item-value="value"
              label="Zone"
              outlined
              clearable
              hide-details
              v-model="zone"
              clear-icon="mdi-close-circle-outline"
              background-color="selects"
            ></v-select>
          </v-col>
          <v-col cols="12">
            <v-select
              append-icon="mdi-chevron-down"
              :items="groupList"
              item-text="text"
              item-value="value"
              label="Group"
              outlined
              clearable
              hide-details
              v-model="group"
              clear-icon="mdi-close-circle-outline"
              background-color="selects"
            ></v-select>
          </v-col>
          <v-col cols="12">
            <v-switch label="Status" v-model="status"></v-switch>
          </v-col>
        </v-row>
        <div class="d-flex justify-end mb-6" flat tile>
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
          name: null,
          code: null,
          email: null,
          address: null,
          contact_information: null,
          bank: null,
          bank_account_name: null,
          bank_account_number: null,
          dealer_pic_name: null,
          pic_email_address: null,
          status: null,
        };
      },
    },
  },
  data() {
    return {
      name: null,
      code: null,
      email: null,
      address: null,
      contact_information: null,
      bank_details: null,
      dealer_pic_name: null,
      pic_email_address: null,
      status: null,
      zoneList: [
        {
          text: "Zone 1",
          value: "zone_1",
        },
        {
          text: "Zone 2",
          value: "zone_2",
        },
      ],
      groupList: [
        {
          text: "Group 1",
          value: "group_1",
        },
        {
          text: "Group 2",
          value: "group_2",
        },
      ],
    };
  },
  mounted() {
    this.name = this.details.name;
    this.code = this.details.code;
    this.email = this.details.email;
    this.address = this.details.address;
    this.contact_information = this.details.contact_information;
    this.bank = this.details.bank;
    this.bank_account_name = this.details.bank_account_name;
    this.bank_account_number = this.details.bank_account_number;
    this.dealer_pic_name = this.details.dealer_pic_name;
    this.pic_email_address = this.details.pic_email_address;
    this.status = this.details.status;
  },
};
</script>

<style></style>
