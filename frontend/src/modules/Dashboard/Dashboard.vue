<template>
  <admin>
    <v-carousel
      cycle
      hide-delimiter-background
      delimiter-icon="mdi-circle"
      height="auto"
      light
      @change="setContent(news[$event])"
    >
      <v-carousel-item v-for="(item, i) in news" :key="i" :src="item.image"></v-carousel-item>
    </v-carousel>
    <br />
    <h2 class="py-2">{{ currentTitle }}</h2>
    <p class="pb-2" v-html="currentDescription"></p>
    <v-btn
      v-if="null !== currentContentUrl"
      :href="currentContentUrl"
      target="_blank"
      large
      exact
      color="#de182e"
      class="mt-8 ma-1 white--text"
      style="opacity: 1"
    >
      READ MORE
      <v-icon small right>mdi-arrow-right</v-icon>
    </v-btn>
  </admin>
</template>

<script>
import { mapActions, mapGetters } from "vuex";

export default {
  data() {
    return {
      currentTitle: null,
      currentDescription: null,
      currentReadMore: false,
      currentContentUrl: null,
    };
  },
  computed: {
    ...mapGetters({
      news: "news/GET_NEWS",
    }),
  },
  mounted() {
    this.listNews();
  },
  methods: {
    ...mapActions({
      listNews: "news/list",
    }),
    setContent(news) {
      this.currentTitle = news.title;
      this.currentDescription = news.summary;
      this.currentContentUrl = news.content_url;
    },
  },
};
</script>

<style lang="scss" scoped>
.v-btn {
  opacity: 0.6;
}
</style>
