<template>
  <v-card>
    <v-card-title>Year Information</v-card-title>
    <v-card-text>
      <v-form
        ref="form"
        v-model="valid"
        lazy-validation
      >
        <v-row>
          <v-col cols="12">
            <v-text-field
              label="Label*"
              class="dt-text-field"
              outlined
              v-model="form.name"
              required
              :rules="[value => !!value || 'Label is required']"
            ></v-text-field>
          </v-col>
          <v-col cols="12">
            <v-text-field
              label="Code"
              class="dt-text-field"
              outlined
              v-model="form.code"
              required
              :rules="[value => !!value || 'Code is required']"
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
          :loading="loadingSave"
          :disabled="loadingSave || loadingSaveAndExit"
          @click="validate(false)"
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
          :to="{ name: 'cars.years.index' }"
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
          id: null,
          code: null,
          name: null,
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
        code: null,
        name: null,
        status: false
      }
    };
  },
  mounted() {
    if (null !== this.details.code) {
      this.form.code = this.details.code;
      this.form.name = this.details.name;
      this.form.status = this.details.status;
    }
  },
  methods: {
    ...mapActions({
      save: "years/save",
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

      await this.saveYearModel(isExit);
    },

    async saveYearModel(isExit) {
      const id = this.$route.params.id ? this.$route.params.id : null;
      await this.save({
        id,
        data: this.form
      }).then((data) => {
        this.loadingSaveAndExit = false;
        this.loadingSave = false;
      }).error((error) => {
        this.loadingSaveAndExit = false;
        this.loadingSave = false;
      });

      if (!id) {
        this.$refs.form.reset();
        this.form.status = false;
      }

      if (isExit) {
        this.$router.push({ name: "cars.years.index"})
      }
    }
  }
};
</script>

<style></style>
