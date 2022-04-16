<template>
  <div>
    <v-card>
      <v-card-title>Dealer Zones</v-card-title>
      <v-card-text>
        <v-form ref="form" v-model="valid" lazy-validation></v-form>
        <v-row>
          <v-col cols="12">
            <v-text-field
              label="Name"
              class="dt-text-field"
              outlined
              hide-details
              v-model="form.name"
            ></v-text-field>
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
            large
            exact
            color="green darken-1"
            class="ma-1 white--text"
            @click="saveOnly"
            :loading="loadingSave"
            :disabled="loadingSave || loadingSaveAndExit"
          >
            <v-icon left>mdi-content-save</v-icon>
            Save
          </v-btn>
          <v-btn
            large
            exact
            color="green"
            class="ma-1 white--text"
            @click="saveAndExit"
            :loading="loadingSaveAndExit"
            :disabled="loadingSave || loadingSaveAndExit"
          >
            <v-icon left>mdi-content-save</v-icon>
            Save and Exit
          </v-btn>
          <v-btn 
            :disabled="loadingSave || loadingSaveAndExit"
            large
            exact
            color="warning"
            class="ma-1 white--text"
            :to="{ name: 'dealer-zones' }"
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
        status: false,
      },
    };
  },
  mounted() {
    this.form.name = this.details.name;
    this.form.description = this.details.description;
    this.form.status = this.details.status;
  },
  methods: {
    ...mapActions({
      save: "zones/save",
    }),
    async submit() {
      var data = {
        name: this.form.name,
        description: this.form.description,
        status: this.form.status,
        precedence: 0,
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

      this.$router.push({ name: "dealer-zones" });
    },
  }
};
</script>

<style></style>
