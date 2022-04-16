<template>
  <admin>
    <page-header
      :back="{
        to: {
          name: 'dealers-account-maintenance.dealers.sales-consultants.index',
          params: { id: 1 },
        },
        text: trans('Sales Consultants'),
      }"
    >
      <template v-slot:title><span v-text="trans('Create Sales Consultant')"></span></template>
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
