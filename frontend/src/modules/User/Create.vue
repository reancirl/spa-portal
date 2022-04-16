<template>
  <admin>
    <metatag :title="'Add User'"></metatag>

    <template v-slot:appbar>
      <v-container class="py-0 px-0">
        <v-row justify="space-between" align="center">
          <v-fade-transition>
            <v-col v-if="isNotFormPrestine" class="py-0" cols="auto">
              <v-toolbar-title class="muted--text" v-text="'Unsaved changes'"></v-toolbar-title>
            </v-col>
          </v-fade-transition>

          <v-spacer></v-spacer>

          <v-col class="py-0" cols="auto">
            <div class="d-flex justify-end">
              <v-spacer></v-spacer>
              <v-btn
                @click="askUserToDiscardUnsavedChanges"
                text
                class="ml-3 mr-0"
                large
                v-text="'Discard'"
              ></v-btn>
              <v-badge
                bordered
                bottom
                class="dt-badge"
                color="dark"
                content="s"
                offset-x="20"
                offset-y="20"
                tile
                transition="fade-transition"
                v-model="shortkeyCtrlIsPressed"
              >
                <v-btn
                  :disabled="isFormDisabled"
                  :loading="isLoading"
                  class="ml-3 mr-0"
                  color="primary"
                  large
                  ref="submit-button-main"
                  type="submit"
                  v-shortkey.once="['ctrl', 's']"
                >
                  <v-icon left>mdi-content-save-outline</v-icon>
                  <span v-text="'Save'"></span>
                </v-btn>
              </v-badge>
            </div>
          </v-col>
        </v-row>
      </v-container>
    </template>

    <validation-observer ref="addform" v-slot="{ handleSubmit, errors, invalid, passed }">
      <v-form
        :disabled="isLoading"
        ref="addform-form"
        autocomplete="false"
        v-on:submit.prevent="handleSubmit(submit)"
        enctype="multipart/form-data"
      >
        <button ref="submit-button" type="submit" class="d-none"></button>

        <page-header :back="{ to: { name: 'users.index' }, text: trans('Users') }">
          <template v-slot:title><span v-text="trans('Add User')"></span></template>
        </page-header>

        <!-- Alertbox -->
        <alertbox></alertbox>
        <!-- Alertbox -->

        <v-row>
          <v-col cols="12" lg="9">
            <v-card class="mb-6">
              <v-card-title v-text="trans('Account Information')"></v-card-title>
              <v-card-text>
                <v-row>
                  <v-col cols="12">
                    <validation-provider
                      vid="name"
                      :name="trans('name')"
                      rules="required"
                      v-slot="{ errors }"
                    >
                      <v-text-field
                        :dense="isDense"
                        :disabled="isLoading"
                        :error-messages="errors"
                        :label="trans('Name')"
                        autofocus
                        class="dt-text-field"
                        name="name"
                        outlined
                        prepend-inner-icon="mdi-account-outline"
                        v-model="resource.data.name"
                      >
                      </v-text-field>
                    </validation-provider>
                  </v-col>
                </v-row>
              </v-card-text>
            </v-card>
          </v-col>
        </v-row>
      </v-form>
    </validation-observer>
  </admin>
</template>

<script>
import User from "./Models/User";
import { mapActions, mapGetters } from "vuex";

export default {
  beforeRouteLeave(to, from, next) {
    if (this.isFormPrestine) {
      next();
    } else {
      this.askUserBeforeNavigatingAway(next);
    }
  },

  computed: {
    ...mapGetters({
      isDense: "settings/fieldIsDense",
      shortkeyCtrlIsPressed: "shortkey/ctrlIsPressed",
      progressbar: "progressbar/progressbar",
    }),
    isDesktop() {
      return this.$vuetify.breakpoint.mdAndUp;
    },
    isLoading() {
      return this.progressbar.loading;
    },
    isFormDisabled() {
      return this.isInvalid || this.resource.isPrestine;
    },
    isNotFormDisabled() {
      return !this.isFormDisabled;
    },
    isFormPrestine() {
      return this.resource.isPrestine;
    },
    isNotFormPrestine() {
      return !this.isFormPrestine;
    },
    form() {
      return this.$refs["addform"];
    },
  },

  data: () => ({
    resource: new User(),
  }),

  methods: {
    ...mapActions({
      hideAlertbox: "alertbox/hide",
      showDialog: "dialog/show",
      hideDialog: "dialog/hide",
      showSnackbar: "snackbar/show",
      showProgressbar: "progressbar/showProgressbar",
      hideProgressbar: "progressbar/hideProgressbar",
    }),

    askUserBeforeNavigatingAway(next) {
      this.showDialog({
        illustration: () => import("@/components/Icons/WorkingDeveloperIcon.vue"),
        title: "Unsaved changes will be lost",
        text: "You have unsaved changes on this page. If you navigate away from this page, data will not be recovered.",
        buttons: {
          cancel: {
            text: "Go Back",
            callback: () => {
              this.hideDialog();
            },
          },
          action: {
            text: "Discard",
            callback: () => {
              next();
              this.hideDialog();
            },
          },
        },
      });
    },

    askUserToDiscardUnsavedChanges() {
      this.showDialog({
        illustration: () => import("@/components/Icons/WorkingDeveloperIcon.vue"),
        title: "Discard changes?",
        text: "You have unsaved changes on this page. If you navigate away from this page, data will not be recovered.",
        buttons: {
          cancel: {
            text: "Cancel",
            callback: () => {
              this.hideDialog();
            },
          },
          action: {
            text: "Discard",
            callback: () => {
              this.resource.isPrestine = true;
              this.hideDialog();
              this.$router.replace({ name: "users.index" });
            },
          },
        },
      });
    },

    submit() {
      this.showProgressbar();
      this.hideAlertbox();

      // axios POST

      this.resource.isPrestine = true;

      this.showSnackbar({
        text: "User updated successfully",
      });

      this.hideProgressbar();
    },
  },
};
</script>
