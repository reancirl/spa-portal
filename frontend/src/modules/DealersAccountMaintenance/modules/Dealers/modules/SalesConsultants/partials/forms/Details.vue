<template>
  <v-card>
    <v-card-title>Account Information</v-card-title>
    <v-card-text>
      <v-row>
        <v-col cols="12">
          <v-text-field
            label="First Name"
            class="dt-text-field"
            outlined
            hide-details
            v-model="first_name"
          ></v-text-field>
        </v-col>
        <v-col cols="12">
          <v-text-field
            label="Last Name"
            class="dt-text-field"
            outlined
            hide-details
            v-model="last_name"
          ></v-text-field>
        </v-col>
        <v-col cols="12">
          <v-text-field
            label="Email"
            class="dt-text-field"
            outlined
            hide-details
            v-model="email"
          ></v-text-field>
        </v-col>
        <v-col cols="12">
          <v-text-field
            label="CRM ID"
            class="dt-text-field"
            outlined
            hide-details
            v-model="crm_id"
          ></v-text-field>
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
</template>

<script>
export default {
  props: {
    details: {
      required: false,
      type: Object,
      default() {
        return {
          first_name: "John",
          last_name: "Cruz",
          email: "JC@gmail.com",
          crm_id: "123456",
        };
      },
    },
  },
  data() {
    return {
      first_name: "John",
      last_name: "Cruz",
      email: "JC@gmail.com",
      crm_id: "123456",
    };
  },
  mounted() {
    this.first_name = this.details.first_name;
    this.last_name = this.details.last_name;
    this.email = this.details.email;
    this.crm_id = this.details.crm_id;
  },
};
</script>

<style></style>
