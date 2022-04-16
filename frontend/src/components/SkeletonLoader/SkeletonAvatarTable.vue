<template>
  <div>
    <div v-for="i in 5" :key="i">
      <div class="d-flex">
        <v-skeleton-loader class="px-4 py-3 mr-4" type="avatar"></v-skeleton-loader>
        <v-skeleton-loader class="px-4 py-3" width="100%" type="table-row"></v-skeleton-loader>
      </div>
    </div>
  </div>
</template>
