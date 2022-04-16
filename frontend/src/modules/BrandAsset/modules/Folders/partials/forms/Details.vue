<template>
  <div>
    <v-card>
      <v-card-title>Brand Asset Folder</v-card-title>
      <v-card-text>
        <v-form ref="form" v-model="valid" lazy-validation>
          <v-row>
            <v-col cols="12">
              <v-text-field
                label="Name*"
                class="dt-text-field"
                outlined
                hide-details
                v-model="form.name"
                :rules="[(v) => !!v || 'Name is required']"
              ></v-text-field>
            </v-col>
            <v-col>
              <v-select
                v-if="categoriesList"
                append-icon="mdi-chevron-down"
                :items="categoriesList"
                item-text="name"
                item-value="id"
                label="Categories*"
                outlined
                clearable
                hide-details
                clear-icon="mdi-close-circle-outline"
                background-color="selects"
                v-model="form.categoryId"
                :rules="[(v) => !!v || 'Category is required']"
              ></v-select>
            </v-col>
            <v-col cols="12">
              <v-textarea
                type="textarea"
                label="Description"
                outlined
                hide-details
                v-model="form.description"
                rows="3"
                row-height="30"
                auto-grow
              ></v-textarea>
            </v-col>
            <v-col cols="12">
              <v-switch label="Status" hide-details v-model="form.status"></v-switch>
            </v-col>
          </v-row>
          <div class="d-flex justify-end mb-6" flat tile>
            <v-btn
              :loading="loadingSave"
              :disabled="loadingSave || loadingSaveAndExit"
              large
              exact
              color="green darken-1"
              class="ma-1 white--text"
              @click="saveOnly"
            >
              <v-icon left>mdi-content-save</v-icon>
              Save
            </v-btn>
            <v-btn
              :loading="loadingSaveAndExit"
              :disabled="loadingSave || loadingSaveAndExit"
              large
              exact
              color="green"
              class="ma-1 white--text"
              @click="saveAndExit"
            >
              <v-icon left>mdi-content-save</v-icon>
              Save and Exit
            </v-btn>
            <v-btn
              large
              exact
              color="warning"
              class="ma-1 white--text"
              :to="{ name: 'brand-asset.folders.index' }"
            >
              <v-icon left>mdi-close</v-icon>
              Cancel
            </v-btn>
          </div>
        </v-form>
      </v-card-text>
    </v-card>
  </div>
</template>

<script>
import { mapActions, mapGetters } from "vuex";

export default {
  props: {
    details: {
      required: false,
      type: Object,
      default() {
        return {
          name: null,
          description: null,
          category: null,
          status: false,
        };
      },
    },
  },
  data() {
    return {
      valid: true,
      loadingSave: false,
      loadingSaveAndExit: false,
      form: {
        name: null,
        description: null,
        status: null,
        categoryId: null,
      },
    };
  },
  computed: {
    ...mapGetters({
      categoriesList: "categories/GET_CATEGORIES",
    }),
  },
  mounted() {
    if (null !== this.details.name) {
      this.form.name = this.details.name;
      this.form.description = this.details.description;
      this.form.status = this.details.status;
      this.form.categoryId = this.details.category.id;
    }

    this.getCategories();
  },
  methods: {
    ...mapActions({
      getCategories: "categories/getCategories",
      save: "folders/save",
    }),
    async submit() {
      var data = {
        name: this.form.name,
        description: this.form.description,
        status: this.form.status,
        category_id: this.form.categoryId,
      };

      const id = this.$route.params.id ? this.$route.params.id : null;

      await this.save({
        id,
        data,
      }).then((data) => {
        this.loadingSave = false;
        this.loadingSaveAndExit = false;
      });
    },
    async saveOnly() {
      if (!this.$refs.form.validate()) {
        return;
      }

      this.loadingSave = true;

      await this.submit();

      if (!this.$route.params.id) {
        this.$refs.form.reset();
      }
    },
    async saveAndExit() {
      if (!this.$refs.form.validate()) {
        return;
      }

      this.loadingSaveAndExit = true;

      await this.submit();

      this.$router.push({ name: "brand-asset.folders.index" });
    },
  },
};
</script>

<style></style>
