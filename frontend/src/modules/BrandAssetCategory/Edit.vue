<template>
  <admin>
    <page-header :back="{ to: { name: 'brand-asset-category' }, text: trans('Category') }">
      <template v-slot:title><span v-text="trans('Edit Category')"></span></template>
    </page-header>

    <div class="row">
      <div class="col-lg-9 col-12">
        <Details :details="details" />
      </div>
    </div>
  </admin>
</template>

<script>
import Details from "./partials/forms/Details.vue";

export default {
  components: {
    Details,
  },
  data() {
    return {
      details: {
        name: "New Cars",
        description: "This is new Cars",
        status: true,
      },
    };
  },
};
</script>

<style></style>
