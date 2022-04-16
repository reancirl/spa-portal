<template>
  <admin>
    <page-header
      :back="{
        to: {
          name: 'dealers-account-maintenance.dealers.sales-consultants.index',
          params: { name: '1' },
        },
        text: trans('Sales Consultants'),
      }"
    >
      <template v-slot:title>
        <span v-text="trans('Edit Juan Dela Cruz')"></span>
      </template>
    </page-header>

    <div class="row">
      <div class="col-lg-9 col-12">
        <DetailsForm :details="sales_consultant" />
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
      sales_consultant: {
        first_name: "John",
        last_name: "Cruz",
        email: "JC@gmail.com",
        crm_id: "123456",
      },
    };
  },
};
</script>

<style></style>
