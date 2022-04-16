<template>
  <admin>
    <page-header
      :back="{ to: { name: 'dealers-account-maintenance.dealers.index' }, text: trans('Dealers') }"
    >
      <template v-slot:title><span v-text="trans('Edit Juan Dela Cruz')"></span></template>
    </page-header>

    <div class="row">
      <div class="col-lg-9 col-12">
        <DetailsForm :details="dealer" />
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
      dealer: {
        name: "Juan Dela Cruz",
        code: "HCBL",
        status: true,
        email: "sample@sample.com",
        address: "sample@sample.com",
        contact_information: "09171234567",
        bank: "Local Bank",
        bank_account_name: "Juan Dela Cruz",
        bank_account_number: "1234567891011",
        group: null,
        zone: null,
        dealer_pic_name: "Juan Dela Cruz II",
        pic_email_address: "sample@sample2.com",
        status: false,
      },
    };
  },
};
</script>

<style></style>
