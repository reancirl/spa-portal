<template>
  <admin>
    <page-header :back="{ to: { name: 'dealer-zones' }, text: trans('Dealer Zones') }">
      <template v-slot:title><span v-text="trans('Edit Dealer Zones')"></span></template>
    </page-header>

    <div class="row">
      <div class="col-lg-9 col-12">
        <Details v-if="details" :details="details" />
      </div>
    </div>
  </admin>
</template>

<script>
import { mapGetters, mapActions } from "vuex";
import Details from "./partials/forms/Details.vue";

export default {
  components: {
    Details,
  },
  computed: {
    ...mapGetters({
      details: "zones/GET_ZONE",
    }),
  },
  methods: {
    ...mapActions({
      getZone: "zones/getZone",
    }),
  },
  async mounted() {
    await this.getZone(this.$route.params.id);
  },
};
</script>

<style></style>
