<template>
  <admin>
    <page-header :back="{ to: { name: 'inventories' }, text: trans('Inventories') }">
      <template v-slot:title><span v-text="trans('Edit #001')"></span></template>
    </page-header>

    <div class="row">
      <div class="col-lg-9 col-12">
        <DetailsForm :details="inventory" />
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
  data() {
    return {
      inventory: {
        variant: "BRIO 1.2 RS CVT Ruby Red Pear",
        dealer: "Honda Cars Batangas",
        quantity: "5",
      },
    };
  },
};
</script>

<style></style>
