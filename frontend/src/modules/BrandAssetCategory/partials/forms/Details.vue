<template>
  <div>
    <v-card>
      <v-card-title>Category</v-card-title>
      <v-card-text>
        <v-row>
          <v-col cols="12">
            <v-text-field
              label="Name"
              class="dt-text-field"
              outlined
              hide-details
              v-model="name"
            ></v-text-field>
          </v-col>
          <v-col cols="12">
            <v-textarea
              type="textarea"
              label="Description"
              outlined
              hide-details
              v-model="description"
              rows="3"
              row-height="30"
              auto-grow
            ></v-textarea>
          </v-col>
          <v-col cols="12">
            <v-switch label="Status" hide-details v-model="status"></v-switch>
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
          description: null,
          status: null,
        };
      },
    },
  },
  data() {
    return {
      name: null,
      description: null,
      status: null,
    };
  },
  mounted() {
    this.name = this.details.name;
    this.description = this.details.description;
    this.status = this.details.status;
  },
};
</script>

<style></style>
