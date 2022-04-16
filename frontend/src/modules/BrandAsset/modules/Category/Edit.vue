<template>
  <admin>
    <page-header
      :back="{
        to: { name: 'brand-asset.categories.index' },
        text: trans('Categories'),
      }"
    >
      <template v-slot:title><span v-text="trans('Edit Category')"></span></template>
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
      details: "categories/GET_CATEGORY",
    }),
  },
  methods: {
    ...mapActions({
      getCategory: "categories/getCategory",
    }),
  },
  async mounted() {
    await this.getCategory(this.$route.params.id);
  },
};
</script>

<style></style>
