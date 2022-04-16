<template>
  <section class="text-center mb-6">
    <v-row align="center" justify="center">
      <v-col><img :src="logo" :alt="app.title" height="50" /></v-col>
    </v-row>
    <!-- <h1 class="my-6" v-text="app.title"></h1> -->
    <!-- <p class="muted--text" v-text="app.tagline"></p> -->
  </section>
</template>

<script>
import app from "@/config/app";
import logo from "@/assets/logo.png";

export default {
  data: () => ({
    logo,
    app,
    brand: 80,
  }),
};
</script>
