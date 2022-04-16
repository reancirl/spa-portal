<template>
  <div class="sticky sheet">
    <v-toolbar flat height="auto">
      <v-row align="center" justify="end">
        <template v-if="filterModel">
          <v-col

          >
            <slot name="filter-model">
              <v-select
                append-icon="mdi-chevron-down"
                :items="items.models"
                item-text="name"
                item-value="id"
                label="Filter by model"
                filled
                flat
                full-width
                hide-details
                clearable
                single-line
                solo
                clear-icon="mdi-close-circle-outline"
                background-color="bar"
                class="py-3 dt-text-field__search"
                v-on:change="emitFilterModel"
              ></v-select>
            </slot>
          </v-col>
        </template>
        <template v-if="filterDealer">
          <v-col
            :cols="isFilterDealerColsAuto ? '4' : null"
            :md="isFilterDealerColsAuto ? '4' : null"
          >
            <slot name="filter-status">
              <v-select
                append-icon="mdi-chevron-down"
                :items="['Honda Cars Batangas', 'Honda Cars Makati', 'Honda Cars Calamba']"
                label="Filter by dealer"
                filled
                flat
                full-width
                hide-details
                clearable
                single-line
                solo
                clear-icon="mdi-close-circle-outline"
                background-color="bar"
                class="py-3 dt-text-field__search"
              ></v-select>
            </slot>
          </v-col>
        </template>
        <template v-if="filterStatus">
          <v-col
            :cols="isFilterStatusColsAuto ? '4' : null"
            :md="isFilterStatusColsAuto ? '4' : null"
          >
            <slot name="filter-status">
              <v-select
                append-icon="mdi-chevron-down"
                :items="[
                  'Pending',
                  'Details Sent',
                  'Closed (booked)',
                  'Closed (sales)',
                  'Closed (did not convert)',
                ]"
                label="Filter by status"
                filled
                flat
                full-width
                hide-details
                clearable
                single-line
                solo
                clear-icon="mdi-close-circle-outline"
                background-color="bar"
                class="py-3 dt-text-field__search"
              ></v-select>
            </slot>
          </v-col>
        </template>
        <template v-if="filterAction">
          <v-col
            :cols="isFilterActionColsAuto ? '4' : null"
            :md="isFilterActionColsAuto ? '4' : null"
          >
            <slot name="filter-action">
              <v-select
                append-icon="mdi-chevron-down"
                :items="['SC to contact', 'Follow up']"
                label="Filter by action"
                filled
                flat
                full-width
                hide-details
                clearable
                single-line
                solo
                clear-icon="mdi-close-circle-outline"
                background-color="bar"
                class="py-3 dt-text-field__search"
              ></v-select>
            </slot>
          </v-col>
        </template>
        <v-col :cols="isSearchColsAuto ? '4' : null" :md="isSearchColsAuto ? '4' : null">
          <slot name="search">
            <v-badge
              bordered
              bottom
              class="dt-badge d-block"
              color="dark"
              content="/"
              offset-x="28"
              offset-y="28"
              tile
              transition="fade-transition"
              v-model="ctrlIsPressed"
            >
              <v-text-field
                background-color="bar"
                :placeholder="trans('Search...')"
                :prepend-inner-icon="items.isSearching ? 'mdi-spin mdi-loading' : 'mdi-magnify'"
                @click:clear="search"
                @keyup="search"
                @shortkey.native="focus"
                autocomplete="off"
                class="py-3 dt-text-field__search"
                clear-icon="mdi-close-circle-outline"
                clearable
                filled
                flat
                full-width
                hide-details
                ref="tablesearch"
                single-line
                solo
                v-model="items.search"
                v-shortkey="['ctrl', '/']"
              >
              </v-text-field>
            </v-badge>
          </slot>
        </v-col>
        <v-col cols="12" sm="auto">
          <div class="d-flex justify-sm-space-between justify-end align-center">
            <v-slide-x-reverse-transition>
              <div v-if="items.toggleBulkEdit && items.bulkCount" class="px-2">
                {{ $tc("{number} item selected", items.bulkCount, { number: items.bulkCount }) }}
              </div>
            </v-slide-x-reverse-transition>
            <v-slide-x-reverse-transition>
              <v-divider v-if="items.bulkCount" vertical class="mx-2"></v-divider>
            </v-slide-x-reverse-transition>
            <v-spacer v-if="items.bulkCount"></v-spacer>

            <!-- Grid List view -->
            <template v-if="switchable">
              <template v-if="toolbar.toggleview">
                <v-tooltip bottom>
                  <template v-slot:activator="{ on: grid }">
                    <v-btn @click="toggleView" class="mr-2" icon slot="activator" v-on="grid">
                      <v-icon small>mdi-format-list-bulleted</v-icon>
                    </v-btn>
                  </template>
                  <span>{{ __("Switch to List View") }}</span>
                </v-tooltip>
              </template>
              <template v-else>
                <v-tooltip bottom>
                  <template v-slot:activator="{ on: list }">
                    <v-btn @click="toggleView" class="mr-2" icon slot="activator" v-on="list">
                      <v-icon small>mdi-view-grid-outline</v-icon>
                    </v-btn>
                  </template>
                  <span>{{ __("Switch to Grid View") }}</span>
                </v-tooltip>
              </template>
            </template>
            <!-- Grid List view -->

            <!-- Import -->
            <template v-if="importable">
              <v-tooltip bottom>
                <template v-slot:activator="{ on }">
                  <v-btn class="mx-3" v-on="on" icon @click="emitImportButtonClicked()">
                    <v-icon>mdi-file-import-outline</v-icon>
                  </v-btn>
                </template>
                <span>{{ "Import" }}</span>
              </v-tooltip>
            </template>
            <!-- Import -->

            <!-- Action buttons -->
            <v-scale-transition>
              <span v-if="items.toggleBulkEdit">
                <v-tooltip bottom>
                  <template v-slot:activator="{ on }">
                    <v-btn
                      class="mr-2"
                      v-on="on"
                      v-if="downloadable"
                      icon
                      :disabled="!items.toggleBulkEdit"
                    >
                      <v-icon small>mdi-download</v-icon>
                    </v-btn>
                  </template>
                  <span>{{ trans("Export selected items") }}</span>
                </v-tooltip>
              </span>
            </v-scale-transition>
            <v-scale-transition>
              <span v-if="items.toggleBulkEdit">
                <v-tooltip bottom>
                  <template v-slot:activator="{ on }">
                    <v-btn
                      v-on="on"
                      @click="askUserToBulkRestoreResources"
                      class="mr-2"
                      v-if="restorable"
                      icon
                      :disabled="!items.toggleBulkEdit"
                    >
                      <v-icon small>mdi-restore</v-icon>
                    </v-btn>
                  </template>
                  <span>{{ trans("Restore selected items") }}</span>
                </v-tooltip>
              </span>
            </v-scale-transition>
            <v-scale-transition>
              <span v-if="items.toggleBulkEdit">
                <v-tooltip bottom>
                  <template v-slot:activator="{ on }">
                    <v-btn
                      class="mr-2"
                      @click="askUserToBulkDestroyResources"
                      v-if="trashable"
                      icon
                      v-on="on"
                      :disabled="!items.toggleBulkEdit"
                    >
                      <v-icon small>mdi-delete-outline</v-icon>
                    </v-btn>
                  </template>
                  <span>{{ trans("Move selected items to trash") }}</span>
                </v-tooltip>
              </span>
            </v-scale-transition>
            <v-scale-transition>
              <span v-if="items.toggleBulkEdit">
                <v-tooltip bottom>
                  <template v-slot:activator="{ on }">
                    <v-btn
                      class="mr-2"
                      @click="askUserToBulkPermanentlyDeleteResources"
                      v-if="deletable"
                      icon
                      v-on="on"
                      :disabled="!items.toggleBulkEdit"
                    >
                      <v-icon small>mdi-delete-forever-outline</v-icon>
                    </v-btn>
                  </template>
                  <span>{{ trans_choice("Permanently delete the selected item") }}</span>
                </v-tooltip>
              </span>
            </v-scale-transition>
            <v-scale-transition>
              <span v-if="items.toggleBulkEdit && items.bulkCount > 0">
                <v-tooltip bottom>
                  <template v-slot:activator="{ on }">
                    <v-btn
                      class="mr-2"
                      v-if="bookable"
                      icon
                      v-on="on"
                      :disabled="!items.toggleBulkEdit"
                      @click="askUserToBulkBookOrderResources"
                    >
                      <v-icon small>mdi-motorbike</v-icon>
                    </v-btn>
                  </template>
                  <span>{{ trans_choice("Book rider for selected orders.") }}</span>
                </v-tooltip>
              </span>
            </v-scale-transition>
            <!-- Action buttons -->

            <v-badge
              bordered
              bottom
              class="dt-badge d-block"
              color="dark"
              content="shift+a"
              offset-x="30"
              offset-y="20"
              tile
              transition="fade-transition"
              v-model="ctrlIsPressed"
            >
              <v-tooltip bottom>
                <template v-slot:activator="{ on }">
                  <v-btn-toggle
                    v-if="bulk"
                    v-model="items.toggleBulkEdit"
                    dense
                    rounded
                    color="primary"
                  >
                    <v-btn
                      @click="toggleBulkEdit"
                      @shortkey="toggleBulkEdit"
                      icon
                      v-on="on"
                      v-shortkey="['ctrl', 'shift', 'a']"
                      color="primary"
                      :value="true"
                      class="bar"
                    >
                      <v-icon v-if="items.toggleBulkEdit" color="primary" small>mdi-close</v-icon>
                      <v-icon v-else small>mdi-check-box-multiple-outline</v-icon>
                    </v-btn>
                  </v-btn-toggle>
                </template>
                <span>{{ trans("Toggle multiple selection") }}</span>
              </v-tooltip>
            </v-badge>

            <v-divider class="mx-2" vertical v-if="verticaldivider"></v-divider>
          </div>
        </v-col>
      </v-row>
      <slot name="filters"></slot>
    </v-toolbar>
    <v-divider v-if="bottomdivider"></v-divider>
  </div>
</template>

<script>
import { mapGetters, mapActions } from "vuex";
import ManIcon from "@/components/Icons/ManThrowingAwayPaperIcon.vue";
import EmptyIcon from "@/components/Icons/EmptyIcon.vue";
import ProjectManager from "@/components/Icons/ProjectManager.vue";

export default {
  name: "ToolbarMenu",
  props: {
    items: {
      type: [Object, Array],
      default: () => {
        return {};
      },
    },
    isSearchColsAuto: {
      type: Boolean,
      default: true,
    },
    isFilterStatusColsAuto: {
      type: Boolean,
      default: true,
    },
    isFilterActionColsAuto: {
      type: Boolean,
      default: true,
    },
    isFilterDealerColsAuto: {
      type: Boolean,
      default: true,
    },
    isFilterModelColsAuto: {
      type: Boolean,
      default: true,
    },
    size: {
      type: [Number, String],
      default: 0,
    },
    bookableCallback: {
      type: [Function],
      default: () => {
        return {};
      },
    },
    bookable: {
      type: [Boolean],
    },
    bulk: {
      type: [Boolean],
    },
    downloadable: {
      type: [Boolean],
    },
    trashable: {
      type: [Boolean],
    },
    switchable: {
      type: [Boolean],
    },
    importable: {
      type: [Boolean],
      default: false,
    },
    restorable: {
      type: [Boolean],
    },
    deletable: {
      type: [Boolean],
    },
    verticaldivider: {
      type: [Boolean],
    },
    bottomdivider: {
      type: [Boolean],
      default: true,
    },
    filterStatus: {
      type: [Boolean],
      default: false,
    },
    filterAction: {
      type: [Boolean],
      default: false,
    },
    filterModel: {
      type: [Boolean],
      default: false,
    },
    filterDealer: {
      type: [Boolean],
      default: false,
    },
  },
  data: () => ({
    dataset: {},
    trashButtonIsLoading: false,
    deleteButtonIsLoading: false,
    isSearching: false,
  }),

  methods: {
    ...mapActions({
      update: "toolbar/update",
    }),
    search(val) {
      this.items.isSearching = true;
      this.$emit("update:search", val);
    },
    focus() {
      this.$refs["tablesearch"].focus();
    },
    toggleView() {
      this.update({ toggleview: !this.toolbar.toggleview });
    },
    toggleBulkEdit() {
      this.items.toggleBulkEdit = !this.items.toggleBulkEdit;
    },
    askUserToBulkRestoreResources() {
      if (this.items.bulkCount) {
        this.$store.dispatch("dialog/prompt", {
          show: true,
          width: 420,
          illustration: this.items.bulkCount ? ProjectManager : EmptyIcon,
          illustrationWidth: 240,
          illustrationHeight: 240,
          loading: this.restoreButtonIsLoading,
          color: "primary",
          title: trans_choice("Restore Selected Item", this.items.bulkCount),
          text: trans_choice(
            "Are you sure you want to restore the selected item?",
            this.items.bulkCount
          ),
          buttons: {
            cancel: { show: this.items.bulkCount, color: "link" },
            action: {
              color: this.items.bulkCount ? "primary" : null,
              text: this.items.bulkCount ? "Restore" : "Okay",
              callback: () => {
                this.$store.dispatch("dialog/loading", true);
                if (!this.items.bulkCount) {
                  this.$store.dispatch("dialog/loading", false);
                  this.$store.dispatch("dialog/close");
                } else {
                  this.emitRestoreButtonClicked();
                }
              },
            },
          },
        });
      } else {
        this.$store.dispatch("snackbar/show", {
          text: trans("Select an item from the list first"),
          button: {
            text: trans("Okay"),
          },
        });
      }
    },
    askUserToBulkDestroyResources() {
      if (this.items.bulkCount) {
        this.$store.dispatch("dialog/prompt", {
          show: true,
          width: 420,
          illustration: this.items.bulkCount ? ManIcon : EmptyIcon,
          illustrationWidth: 240,
          illustrationHeight: 240,
          loading: this.trashButtonIsLoading,
          color: "warning",
          title: trans_choice("Move the selected item to trash", this.items.bulkCount),
          text: trans_choice(
            "Are you sure you want to move the selected item to trash?",
            this.items.bulkCount
          ),
          buttons: {
            cancel: { show: this.items.bulkCount, color: "link" },
            action: {
              color: this.items.bulkCount ? "warning" : null,
              text: this.items.bulkCount ? "Move to Trash" : "Okay",
              callback: () => {
                this.$store.dispatch("dialog/loading", true);
                if (!this.items.bulkCount) {
                  this.$store.dispatch("dialog/loading", false);
                  this.$store.dispatch("dialog/close");
                } else {
                  this.emitTrashButtonClicked();
                }
              },
            },
          },
        });
      } else {
        this.$store.dispatch("snackbar/show", {
          text: trans_choice("Select an item from the list first", this.items.bulkCount),
          button: {
            text: trans("Okay"),
          },
        });
      }
    },
    askUserToBulkBookOrderResources() {
      if (this.items.bulkCount === 0) {
        this.$store.dispatch("snackbar/show", {
          text: trans_choice("Select an item from the list first", this.items.bulkCount),
          button: {
            text: trans("Okay"),
          },
        });
        return;
      }

      this.bookableCallback();
    },
    askUserToBulkPermanentlyDeleteResources() {
      if (this.items.bulkCount) {
        this.$store.dispatch("dialog/prompt", {
          show: true,
          width: 420,
          illustration: this.items.bulkCount ? ManIcon : EmptyIcon,
          illustrationWidth: 240,
          illustrationHeight: 240,
          loading: this.deleteButtonIsLoading,
          color: "error",
          title: trans_choice("Permanently delete the selected item", this.items.bulkCount),
          text: trans_choice(
            "Are you sure you want to permanently delete the selected item?",
            this.items.bulkCount
          ),
          buttons: {
            cancel: { show: this.items.bulkCount, color: "link" },
            action: {
              color: this.items.bulkCount ? "error" : null,
              text: this.items.bulkCount ? "Permanently delete" : "Okay",
              callback: () => {
                this.$store.dispatch("dialog/loading", true);
                if (!this.items.bulkCount) {
                  this.$store.dispatch("dialog/loading", false);
                  this.$store.dispatch("dialog/close");
                } else {
                  this.emitDeleteButtonClicked();
                }
              },
            },
          },
        });
      } else {
        this.$store.dispatch("snackbar/show", {
          text: trans_choice("Select an item from the list first", this.items.bulkCount),
          button: {
            text: trans("Okay"),
          },
        });
      }
    },
    emitRestoreButtonClicked() {
      this.$emit("update:restore");
    },
    emitTrashButtonClicked() {
      this.$emit("update:trash");
    },
    emitDeleteButtonClicked() {
      this.$emit("update:delete");
    },
    toggleLoadingStateOnClick() {
      this.trashButtonIsLoading = !this.trashButtonIsLoading;
    },
    emitImportButtonClicked() {
      this.$emit("click:import");
    },
    emitFilterModel(val) {
      this.$emit("filter:model", val);
    }
  },
  mounted() {
    this.dataset = Object.assign({}, this.toolbar, this.items);
  },
  computed: {
    ...mapGetters({
      ctrlIsPressed: "shortkey/ctrlIsPressed",
      toolbar: "toolbar/toolbar",
      app: "app/app",
    }),
  },
  watch: {
    "items.toggleBulkEdit": function (val) {
      if (!val) {
        this.trashButtonIsLoading = false;
      }
    },

    size: function (val) {
      this.items.bulkCount = val;
    },
  },
};
</script>
