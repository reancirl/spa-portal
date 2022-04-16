<template>
  <admin>
    <metatag :title="resource.data.name"></metatag>

    <page-header :back="{ to: { name: 'users.index' }, text: 'Users' }">
      <template v-slot:title>
        <span v-text="resource.data.name"></span>
      </template>
      <template v-slot:utilities>
        <router-link class="dt-link text-decoration-none mr-6" exact :to="{ name: 'users.edit' }">
          <v-icon small class="mb-1">mdi-pencil-outline</v-icon>
          <span class="ml-2" v-text="'Edit'"></span>
        </router-link>
      </template>
    </page-header>

    <template v-if="resource.loading">
      <skeleton-show></skeleton-show>
    </template>

    <template v-else>
      <v-card>
        <!-- Summary Details -->
        <v-card-text>
          <user-account-detail-card v-model="resource.data"> </user-account-detail-card>
        </v-card-text>
        <!-- Summary Details -->

        <v-divider></v-divider>

        <!-- Background Details -->
        <v-simple-table>
          <template v-slot:default>
            <thead>
              <tr>
                <th colspan="100%" class="text-left" v-text="trans('Background Details')"></th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td class="font-weight-bold">{{ "Email" }}</td>
                <td v-text="resource.data.email"></td>
              </tr>
              <tr>
                <td class="font-weight-bold">{{ "Status" }}</td>
                <td>
                  <v-chip color="soft-success" text-color="success">
                    {{ resource.data.status }}
                  </v-chip>
                </td>
              </tr>
              <tr>
                <td class="font-weight-bold">{{ "Created" }}</td>
                <td v-text="resource.data.created_at"></td>
              </tr>
              <tr>
                <td class="font-weight-bold">{{ "Last modified" }}</td>
                <td v-text="resource.data.updated_at"></td>
              </tr>
            </tbody>
          </template>
        </v-simple-table>
        <!-- Background Details -->
      </v-card>
    </template>
  </admin>
</template>

<script>
import User from "./Models/User";

export default {
  components: {
    SkeletonShow: () => import("./cards/SkeletonShow"),
    UserAccountDetailCard: () => import("@/components/Cards/UserAccountDetailCard"),
  },

  data: () => ({
    resource: new User(),
  }),
};
</script>
