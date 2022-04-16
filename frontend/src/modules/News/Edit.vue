<template>
  <admin>
    <page-header :back="{ to: { name: 'news' }, text: trans('News') }">
      <template v-slot:title><span v-text="trans('Edit News')"></span></template>
    </page-header>

    <div class="row">
      <div class="col-lg-9 col-12">
        <NewsForm :details="news" />
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
  data() {
    return {
      news: {
        title: "New Cars",
        slug: "new-cars",
        image: null,
        summary: "This is new Cars",
        content: "This is New Cars",
        content_url: null,
        dealers: null,
        presedence: null,
        featured: true,
        status: true,
        published_date: null,
      },
    };
  },
};
</script>

<style></style>
