<template>
  <admin>
    <page-header :back="{ to: { name: 'news' }, text: trans('News') }">
      <template v-slot:title><span v-text="trans('Create News')"></span></template>
    </page-header>

    <div class="row">
      <div class="col-lg-9 col-12">
        <NewsForm />
      </div>
    </div>
  </admin>
</template>

<script>
import NewsForm from "./partials/forms/News.vue";

export default {
  components: {
    NewsForm,
  },
};
</script>

<style></style>
