<template>
  <v-card>
    <v-card-title>Variant Color Information</v-card-title>
    <v-card-text>
      <v-form
        ref="form"
        v-model="valid"
        lazy-validation
      >
        <v-row>
          <v-col cols="12">
            <v-select
              append-icon="mdi-chevron-down"
              :items="colors"
              item-text="name"
              item-value="id"
              label="Color"
              outlined
              clearable
              clear-icon="mdi-close-circle-outline"
              background-color="selects"
              v-model="form.color_id"
              required
              :rules="[value => !!value || 'Color is required']"
            ></v-select>
          </v-col>
          <v-col cols="12">
            <v-card class="d-flex justify-start" flat tile>
              <v-text-field
                label="Price"
                class="dt-text-field"
                outlined
                type="text"
                v-model="form.price"
                :disabled="defaultPrice"
                required
                :rules="[value => !!value || 'Price is required']"
              ></v-text-field>
            </v-card>
          </v-col>
          <v-col cols="12">
            <v-switch hide-details label="Use default price" v-model="defaultPrice"></v-switch>
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
          :to="{ name: 'cars.variant-colors.index' }"
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
          color: null,
          price: null,
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
        color_id: null,
        price: null,
        status: false,
      },
      defaultPrice: false,
    };
  },
  watch: {
    defaultPrice: function (val) {
      this.form.price = this.details.price;
      if (val) {
        this.form.price = this.variant ? this.variant.price : this.details.price;
      }
    },
  },
  computed: {
    ...mapGetters({
      colors: "colors/GET_COLORS",
      variant: "cars/GET_VARIANT"
    }),
  },
  async mounted() {
    await this.listColors();
    this.form.price = this.details.price;
    this.form.status = this.details.status;
    this.form.color_id = this.details.color ? this.details.color.id : null;
    this.form.pricing = this.details.pricing === 'inherit' ? true : false;
    this.defaultPrice = this.details.pricing === 'inherit' ? true : false
    await this.getVariant(this.$route.params.id);
  },
  methods: {
    ...mapActions({
      save: "variantColors/save",
      listColors: "colors/list",
      getVariant: "cars/getVariant"
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

      await this.saveVariantColor(isExit);
    },
    
    async saveVariantColor(isExit) {
      const id = this.$route.params.variantcolorid ? this.$route.params.variantcolorid : null;
      const variantId = this.$route.params.id ? this.$route.params.id : null;
      const data = {
        color_id: this.form.color_id,
        status: this.form.status,
        price: this.form.price,
        pricing: this.defaultPrice ? 'inherit' : 'custom',
        variant_id: variantId
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
        this.$router.push({ name: "cars.variant-colors.index"})
      }
    },
  }
};
</script>

<style></style>
