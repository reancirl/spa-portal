<template>
  <div>
    <v-card>
      <v-card-title class="justify-center">
        <h1 class="text-center">Sales Consultants</h1>
      </v-card-title>
    </v-card>
    <v-row class="py-4">
      <v-col cols="12">
        <v-menu bottom offset-y class="pointer">
          <template v-slot:activator="{ on, attrs }">
            <v-btn color="info" large v-bind="attrs" v-on="on">
              <v-icon small left>mdi-account-plus-outline</v-icon>
              Add new SC
            </v-btn>
          </template>
          <v-list>
            <v-list-item @click="showIndividualForm">
              <v-list-item-title>
                <v-icon small left>mdi-account-plus-outline</v-icon>
                <span class="text-center px-8 py-1">Individual</span>
              </v-list-item-title>
            </v-list-item>
            <v-list-item @click="showUploadForm">
              <v-list-item-title>
                <v-icon small left>mdi-upload</v-icon>
                <span class="text-center px-8 py-1">Upload via excel</span>
              </v-list-item-title>
            </v-list-item>
          </v-list>
        </v-menu>
      </v-col>
      <v-col cols="12">
        <component v-bind:is="salesFormComponent"></component>
      </v-col>
    </v-row>
  </div>
</template>

<script>
import Individual from "./Forms/Individual";
import Upload from "./Forms/Upload";

export default {
  components: {
    Individual,
    Upload,
  },
  data() {
    return {
      salesFormComponent: null,
      loading: true,
    };
  },
  methods: {
    showIndividualForm() {
      this.salesFormComponent = Individual;
    },
    showUploadForm() {
      this.salesFormComponent = Upload;
    },
  },
};
</script>

<style lang="scss" scoped>
.v-list {
  cursor: pointer;
}
</style>
