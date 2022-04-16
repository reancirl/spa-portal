<template>
  <div>
    <v-card>
      <v-card-title>News</v-card-title>
      <v-card-text>
        <v-row>
          <v-col cols="12">
            <v-text-field
              label="Title"
              class="dt-text-field"
              outlined
              hide-details
              v-model="title"
            ></v-text-field>
          </v-col>
          <v-col cols="12">
            <v-text-field
              label="Slug"
              class="dt-text-field"
              outlined
              hide-details
              v-model="slug"
            ></v-text-field>
          </v-col>
          <v-col cols="12">
            <v-text-field
              type="file"
              label="Image"
              class="dt-text-field"
              outlined
              hide-details
              v-model="emage"
            ></v-text-field>
          </v-col>
          <v-col cols="12">
            <v-textarea
              type="textarea"
              label="Summary"
              outlined
              hide-details
              v-model="summary"
              rows="3"
              row-height="30"
              auto-grow
            ></v-textarea>
          </v-col>
          <v-col cols="12">
            <v-textarea
              type="textarea"
              label="Content"
              outlined
              hide-details
              v-model="content"
              rows="3"
              row-height="30"
              auto-grow
            ></v-textarea>
          </v-col>
          <v-col cols="12">
            <v-text-field
              label="Content URL"
              class="dt-text-field"
              outlined
              hide-details
              v-model="content_url"
            ></v-text-field>
          </v-col>
          <v-col cols="12">
            <Dealer />
          </v-col>
          <v-col cols="12">
            <v-text-field
              label="Presedence"
              class="dt-text-field"
              outlined
              hide-details
              v-model="presedence"
            ></v-text-field>
          </v-col>
          <v-col cols="12">
            <v-text-field
              type="date"
              label="Published Date"
              class="dt-text-field"
              outlined
              hide-details
              v-model="published_date"
            ></v-text-field>
          </v-col>
          <v-col cols="12">
            <v-switch label="Featured" hide-details v-model="featured"></v-switch>
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
import Dealer from "@/components/Dealer/Dealer";

export default {
  components: {
    Dealer,
  },
  props: {
    details: {
      required: false,
      type: Object,
      default() {
        return {
          title: null,
          slug: null,
          image: null,
          summary: null,
          content: null,
          content_url: null,
          dealers: null,
          presedence: null,
          featured: null,
          status: null,
          published_date: null,
        };
      },
    },
  },
  data() {
    return {
      title: null,
      slug: null,
      image: null,
      summary: null,
      content: null,
      content_url: null,
      dealers: this.$store.getters.GET_DEALER,
      presedence: null,
      featured: null,
      status: null,
      published_date: null,
    };
  },
  mounted() {
    this.title = this.details.title;
    this.slug = this.details.slug;
    this.image = this.details.image;
    this.summary = this.details.summary;
    this.content = this.details.content;
    this.content_url = this.details.content_url;
    this.dealers = this.details.dealers;
    this.presedence = this.details.presedence;
    this.featured = this.details.featured;
    this.status = this.details.status;
    this.published_date = this.details.published_date;
  },
};
</script>

<style></style>
