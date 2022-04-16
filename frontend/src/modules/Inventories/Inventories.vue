<template>
  <admin>
    <v-row>
      <v-col md="3">
        <UserType :user-list="userList" />
      </v-col>
    </v-row>
    <metatag title="Sales Consultants"></metatag>

    <page-header>
      <template v-if="userType == 'hcpi'" v-slot:action>
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
              <v-icon small left>mdi-plus-circle</v-icon>
              Add new
            </v-btn>
          </template>
          <v-list>
            <v-list-item :to="{ name: 'inventories.create' }">
              <v-list-item-title>
                <v-icon small left>mdi-plus-circle</v-icon>
                <span class="text-center px-8 py-1">Individual</span>
              </v-list-item-title>
            </v-list-item>
            <v-list-item :to="{ name: 'inventories.upload' }">
              <v-list-item-title>
                <v-icon small left>mdi-cloud-upload</v-icon>
                <span class="text-center px-8 py-1">Upload via excel</span>
              </v-list-item-title>
            </v-list-item>
          </v-list>
        </v-menu>
      </template>
    </page-header>
    <v-row v-if="userType">
      <v-col :class="userType == 'hcpi' ? '' : 'd-none'">
        <HCPI />
      </v-col>
      <v-col :class="userType == 'dealer' ? '' : 'd-none'">
        <Dealer />
      </v-col>
    </v-row>
  </admin>
</template>

<script>
import UserType from "@/components/UserType/UserType";
import HCPI from "./HCPI";
import Dealer from "./Dealer";

export default {
  data() {
    return {
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
    };
  },
  components: {
    UserType,
    HCPI,
    Dealer,
  },
  computed: {
    userType() {
      return this.$store.getters.GET_USER_TYPE;
    },
  },
  methods: {
    showTip() {
      document.querySelector(".tooltip-message").classList.remove("d-none");
    },
  },
};
</script>

<style></style>
