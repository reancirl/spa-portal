<template>
  <admin>
    <page-header
      :back="{ to: { name: 'dealers-account-maintenance.dealers.index' }, text: trans('Dealers') }"
    >
      <template v-slot:title><span v-text="trans('Create Dealer')"></span></template>
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
