<template>
  <admin>
    <page-header
      :back="{
        to: { name: 'cars.variant-colors.index', params: { id: '1' } },
        text: trans('Variant Colors'),
      }"
    >
      <template v-slot:title><span v-text="trans(`Edit ${details ? details.name : ''}`)"></span></template>
    </page-header>

    <div class="row">
      <div class="col-lg-9 col-12">
        <DetailsForm v-if="details" :details="details" />
      </div>
    </div>
  </admin>
</template>

<script>
import { mapGetters, mapActions } from "vuex";
import DetailsForm from "./partials/forms/Details.vue";

export default {
  components: {
    DetailsForm,
  },
  computed: {
    ...mapGetters({
      details: "variantColors/GET_VARIANT_COLOR",
    }),
  },
  methods: {
    ...mapActions({
      getVariantColor: "variantColors/getVariantColor",
    }),
  },
  async mounted() {
    await this.getVariantColor(this.$route.params.variantcolorid);
  },
};
</script>

<style></style>
