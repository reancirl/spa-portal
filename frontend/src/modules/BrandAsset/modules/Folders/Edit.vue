<template>
  <admin>
    <page-header :back="{ to: { name: 'brand-asset.folders.index' }, text: trans('Folder') }">
      <template v-slot:title><span v-text="trans('Edit Folder')"></span></template>
    </page-header>

    <div class="row">
      <div class="col-lg-9 col-12">
        <Details v-show="show" :details="details" />
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
  data() {
    return {
      show: false,
    };
  },
  computed: {
    ...mapGetters({
      details: "folders/GET_FOLDER",
    }),
  },
  async mounted() {
    await this.getFolder(this.$route.params.id);
    this.show = true;
    // console.log(undefined !== this.details)
  },
  methods: {
    ...mapActions({
      getFolder: "folders/getFolder",
    }),
  },
};
</script>

<style></style>
