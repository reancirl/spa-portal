<template>
  <v-card>
    <v-card-title>Color Information</v-card-title>
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
              v-model="form.name"
              :rules="[value => !!value || 'Name is required']"
              required
            ></v-text-field>
          </v-col>
          <v-col cols="12">
            <v-text-field
              label="Code"
              class="dt-text-field"
              outlined
              required
              :rules="[value => !!value || 'Code is required']"
              v-model="form.code"
            ></v-text-field>
          </v-col>
          <v-col cols="12">
            <v-switch label="Status" v-model="form.status"></v-switch>
          </v-col>
        </v-row>
      </v-form>
      <div class="d-flex justify-end my-6" flat tile>
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
          :to="{ name: 'cars.models.index' }"
          :disabled="loadingSave || loadingSaveAndExit"
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
          name: null,
          code: null,
          status: null,
        };
      },
    },
  },
  data() {
    return {
      form: {
        name: null,
        code: null,
        status: false,
      },
      valid: true,
      loadingSave: false,
      loadingSaveAndExit: false,
    };
  },
  mounted() {
    if (null !== this.details.name) {
      this.form.name = this.details.name;
      this.form.code = this.details.code;
      this.form.status = this.details.status;
    }
  },
  methods: {
    ...mapActions({
      save: "colors/save",
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

      await this.saveColor(isExit);
    },

    async saveColor(isExit) {
      const id = this.$route.params.id ? this.$route.params.id : null;
      await this.save({
        id,
        data: this.form
      }).then((data) => {
        this.loadingSaveAndExit = false;
        this.loadingSave = false;
      });

      if (!id) {
        this.$refs.form.reset();
        this.form.status = false;
      }

      if (isExit) {
        this.$router.push({ name: "cars.colors.index"})
      }
    }
  }
};
</script>

<style></style>
