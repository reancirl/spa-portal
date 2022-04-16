<template>
  <admin>
    <page-header :back="{ to: { name: 'cars.index' }, text: trans('Cars') }">
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
import { mapActions, mapGetters } from "vuex";
import DetailsForm from "./partials/forms/Details.vue";

export default {
  components: {
    DetailsForm,
  },
  computed: {
    ...mapGetters({
      details: "cars/GET_VARIANT",
    }),
  },
  methods: {
    ...mapActions({
      getVariant: "cars/getVariant",
    }),
  },
  async mounted() {
    await this.getVariant(this.$route.params.id);
  },
};
</script>

<style></style>
