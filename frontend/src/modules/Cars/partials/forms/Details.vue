<template>
  <v-card>
    <v-card-title>Car Information</v-card-title>
    <v-card-text>
      <v-form
        ref="form"
        v-model="valid"
        lazy-validation
      >
        <v-row>
          <v-col cols="12">
            <v-text-field
              label="Name"
              class="dt-text-field"
              outlined
              required
              :rules="rules.name"
              v-model="form.name"
            ></v-text-field>
          </v-col>
          <v-col cols="12">
            <v-text-field
              label="Code"
              class="dt-text-field"
              outlined
              required
              :rules="rules.code"
              v-model="form.code"
            ></v-text-field>
          </v-col>
          <v-col cols="12">
            <v-select
              append-icon="mdi-chevron-down"
              :items="models"
              item-text="name"
              item-value="id"
              label="Model"
              outlined
              clearable
              required
              :rules="rules.model"
              clear-icon="mdi-close-circle-outline"
              background-color="selects"
              v-model="form.model_id"
            ></v-select>
          </v-col>
          <v-col cols="12">
            <v-select
              append-icon="mdi-chevron-down"
              :items="years"
              item-text="name"
              item-value="id"
              label="Year Model"
              outlined
              clearable
              required
              :rules="rules.year_model"
              clear-icon="mdi-close-circle-outline"
              background-color="selects"
              v-model="form.year_id"
            ></v-select>
          </v-col>
          <v-col cols="12">
            <v-text-field
              label="Price"
              class="dt-text-field"
              outlined
              required
              :rules="rules.price"
              v-model="form.price"
            ></v-text-field>
          </v-col>
          <v-col cols="12">
            <v-switch label="Status" v-model="form.status"></v-switch>
          </v-col>
        </v-row>
      </v-form>
      <div class="d-flex justify-end mb-6" flat tile>
        <v-btn 
          large
          exact
          color="green darken-1"
          class="ma-1 white--text"
          @click="validate(false)"
          :loading="loadingSave"
          :disabled="loadingSave || loadingSaveAndExit"
        >
          <v-icon left>mdi-content-save</v-icon>
          Save
        </v-btn>
        <v-btn
          large
          exact
          color="green lighten-1"
          class="ma-1 white--text"
          @click="validate(true)"
          :loading="loadingSaveAndExit"
          :disabled="loadingSave || loadingSaveAndExit"
        >
          <v-icon left>mdi-content-save</v-icon>
          Save and Exit
        </v-btn>
        <v-btn
          large
          exact
          color="warning"
          class="ma-1 white--text" 
          :disabled="loadingSave || loadingSaveAndExit"
          :to="{ name: 'cars.index' }"
        >
          <v-icon left>mdi-close</v-icon>
          Cancel
        </v-btn>
      </div>
    </v-card-text>
  </v-card>
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
          code: null,
          model: null,
          year: null,
          name: null,
          price: null,
          status: false,
        };
      },
    },
  },
  data() {
    return {
      form: {
        code: null,
        name: null,
        model_id: null,
        year_id: null,
        price: null,
        status: false,
      },
      valid: true,
      loadingSave: false,
      loadingSaveAndExit: false,
      rules: {
        name: [value => !!value || 'Name is required'],
        code: [value => !!value || 'Code is required'],
        model: [value => !!value || 'Model is required'],
        year_model: [value => !!value || 'Year Model is required'],
        price: [value => !!value || 'Price is required'],
      }
    };
  },
  computed: {
    ...mapGetters({
      models: "models/GET_MODELS",
      years: "years/GET_YEARS",
    }),
  },
  async mounted() {
    if (null !== this.details.name) {
      this.form.code = this.details.code;
      this.form.name = this.details.name;
      this.form.status = this.details.status;
      this.form.price = this.details.price;
      this.form.model_id = this.details.model ? this.details.model.id : null;
      this.form.year_id = this.details.year ? this.details.year.id : null;
    }
    await this.listModels();
    await this.listYears();
  },
  methods: {
    ...mapActions({
      save: "cars/save",
      listModels: "models/list",
      listYears: "years/list",
    }),

    async validate(isExit) {
      const isValid = this.$refs.form.validate();
      if (!isValid) {
        return;
      }

      if (isExit) {
        this.loadingSaveAndExit = true;
      }
      else {
        this.loadingSave = true;
      }

      await this.saveVariant(isExit);
    },

    async saveVariant(isExit) {
      const id = this.$route.params.id ? this.$route.params.id : null;
      const data = {
        code: this.form.code,
        status: this.form.status,
        price: this.form.price,
        name: this.form.name,
        model_id: this.form.model_id,
        year_id: this.form.year_id,
      };
      await this.save({
        id,
        data
      }).then((data) => {
        this.loadingSaveAndExit = false;
        this.loadingSave = false;
      });

      if (!id) {
        this.$refs.form.reset();
        this.form.status = false;
      }

      if (isExit) {
        this.$router.push({ name: "cars.index"})
      }
    }
  }
};
</script>

<style></style>
