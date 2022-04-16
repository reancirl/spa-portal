<template>
  <admin>
    <page-header :back="{ to: { name: 'cars.colors.index' }, text: trans('Colors') }">
      <template v-slot:title
        ><span v-text="trans(`Edit ${details ? details.name : ''}`)"></span
      ></template>
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
      details: "colors/GET_COLOR",
    }),
  },
  methods: {
    ...mapActions({
      getColor: "colors/getColor",
    }),
  },
  async mounted() {
    await this.getColor(this.$route.params.id);
  },
};
</script>

<style></style>
