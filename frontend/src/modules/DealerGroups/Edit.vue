<template>
  <admin>
    <page-header :back="{ to: { name: 'dealer-groups' }, text: trans('Dealer Groups') }">
      <template v-slot:title><span v-text="trans('Edit Dealer Groups')"></span></template>
    </page-header>

    <div class="row">
      <div class="col-lg-9 col-12">
        <DetailsForm :details="news" />
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
      news: {
        name: "New Cars",
        description: "This is new Cars",
        status: true,
      },
    };
  },
};
</script>

<style></style>
