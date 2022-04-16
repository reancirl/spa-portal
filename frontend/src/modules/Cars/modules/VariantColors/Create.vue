<template>
  <admin>
    <page-header
      :back="{ to: { name: 'cars.variant-colors.index' }, text: trans('Variant Colors') }"
    >
      <template v-slot:title><span v-text="trans('Add new Variant color')"></span></template>
    </page-header>

    <div class="row">
      <div class="col-lg-9 col-12">
        <DetailsForm />
      </div>
    </div>
  </admin>
</template>

<script>
import DetailsForm from "./partials/forms/Details.vue";

export default {
  components: {
    DetailsForm,
  },
};
</script>

<style></style>
