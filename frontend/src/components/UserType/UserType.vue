<template>
  <v-tooltip bottom>
    <template v-slot:activator="{ on, attrs }">
      <div v-bind="attrs" v-on="on" no-gutter>
        <v-select
          append-icon="mdi-chevron-down"
          :items="userList"
          item-text="text"
          item-value="value"
          label="View as"
          outlined
          clearable
          clear-icon="mdi-close-circle-outline"
          background-color="selects"
          v-model="userType"
          @change="updateUser"
        ></v-select>
      </div>
    </template>
    <span>This will be removed after integration</span>
  </v-tooltip>
</template>

<script>
export default {
  props: {
    userList: {
      type: Array,
      required: true,
    },
  },
  data() {
    return {
      userType: null,
    };
  },
  methods: {
    updateUser() {
      this.$store.dispatch("setUserType", this.userType);
    },
  },
};
</script>

<style></style>
