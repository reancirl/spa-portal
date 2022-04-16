<template>
  <v-row justify="center" align="center">
    <v-col cols="12" md="3">
      <div class="dt-avatar-preview d-block mx-auto">
        <v-avatar size="160">
          <img :src="dataset.avatar" :alt="dataset.name" />
        </v-avatar>
      </div>
    </v-col>

    <v-col cols="12" md="9">
      <h2 class="mb-3">
        {{ dataset.name }}
      </h2>
      <div class="mb-2">
        <v-icon small class="mr-2 muted--text">mdi-at</v-icon>
        <span class="muted--text">{{ dataset.email }}</span>
      </div>
      <div class="muted--text mb-2">
        <v-icon small class="mr-2 muted--text">mdi-email-outline</v-icon>
        <span class="muted--text">{{ dataset.email }}</span>
      </div>
    </v-col>
  </v-row>
</template>

<script>
export default {
  name: "UserAccountDetailCard",

  props: ["value"],

  computed: {
    dataset: {
      get() {
        return this.value;
      },
      set(val) {
        this.$emit("input", val);
      },
    },
  },
};
</script>
