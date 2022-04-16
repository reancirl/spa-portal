<template>
  <div>
    <v-card class="mb-6">
      <v-card-title>{{ trans("Account Information") }}</v-card-title>
      <v-card-text>
        <v-row>
          <v-col cols="12" md="6">
            <v-skeleton-loader class="mb-6" height="56" type="image"></v-skeleton-loader>
          </v-col>
          <v-col cols="12" md="6">
            <v-skeleton-loader class="mb-6" height="56" type="image"></v-skeleton-loader>
          </v-col>
          <v-col cols="12">
            <v-skeleton-loader class="mb-6" height="56" type="image"></v-skeleton-loader>
          </v-col>
        </v-row>
      </v-card-text>

      <v-card-title class="py-0">{{ trans("Account Status") }}</v-card-title>
      <v-card-text>
        <v-row>
          <v-col cols="12">
            <v-skeleton-loader class="mb-6" height="56" type="image"></v-skeleton-loader>
          </v-col>
        </v-row>
      </v-card-text>
    </v-card>

    <v-card class="mb-6">
      <v-card-title class="pb-0">{{ trans("Account Details") }}</v-card-title>
      <v-card-text>
        <v-row>
          <v-col cols="12">
            <v-skeleton-loader class="mb-6" height="56" type="image"></v-skeleton-loader>
          </v-col>
        </v-row>
      </v-card-text>
    </v-card>

    <v-card class="mb-6">
      <v-card-title class="pb-0">{{ trans("Change Password") }}</v-card-title>
      <v-card-text>
        <v-row>
          <v-col cols="12">
            <v-skeleton-loader class="mb-6" height="56" type="image"></v-skeleton-loader>
          </v-col>
        </v-row>
      </v-card-text>
    </v-card>
  </div>
</template>
