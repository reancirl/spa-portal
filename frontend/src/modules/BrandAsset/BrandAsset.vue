<template>
  <admin>
    <v-row>
      <v-col md="3">
        <!-- <UserType :user-list="userList" /> -->
      </v-col>
    </v-row>

    <metatag title="Brand Assets"></metatag>

    <page-header>
      <template v-slot:action>
        <div
          v-if="user.is_admin && storage"
          class="d-flex flex-column flex-md-row"
        >
          <div class="mr-8">
            <v-progress-linear
              height="8"
              rounded
              :value="storage.percentage"
              class="mt-2"
            ></v-progress-linear>
            <small class="muted--text"
              >{{ storage.used }} of {{ storage.available }} used
            </small>
          </div>
          <v-btn
            @click="uploadFile()"
            :block="$vuetify.breakpoint.smAndDown"
            large
            color="info"
            exact
          >
            <v-icon small left>mdi-cloud-upload</v-icon>
            <span v-text="'Upload'"></span>
          </v-btn>
        </div>
      </template>
    </page-header>

    <v-row>
      <v-col>
        <v-card>
          <div class="sticky sheet">
            <v-toolbar flat height="auto">
              <div class="d-flex flex-column flex-md-row" style="width: 100%">
                <v-select
                  v-model="category"
                  append-icon="mdi-chevron-down"
                  :items="activeCategories"
                  label="Filter by category"
                  item-text="name"
                  item-value="id"
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
                <v-menu v-if="user.is_admin" offset-y>
                  <template v-slot:activator="{ on, attrs }">
                    <v-btn
                      class="white--text ma-md-3 mr-md-auto"
                      color="#de182e"
                      x-large
                      exact
                      v-bind="attrs"
                      :disabled="uploadGuidelinesLoading"
                      v-on="on"
                    >
                      <v-icon v-if="!uploadGuidelinesLoading" class="mr-1"
                        >mdi-playlist-check</v-icon
                      >
                      <v-progress-circular
                        v-else
                        small
                        :size="23"
                        indeterminate
                        class="mr-1"
                      ></v-progress-circular>
                      <span
                        class=""
                        v-text="'Honda Branding Guidelines'"
                      ></span>
                    </v-btn>
                  </template>

                  <v-list class="pointer" style="background-color: #f4f5f8">
                    <v-list-item>
                      <v-list-item-title class="d-flex justify-space-between">
                        <v-file-input
                          label="Upload Guidelines"
                          @change="uploadBrochure($event)"
                        ></v-file-input>
                      </v-list-item-title>
                    </v-list-item>
                    <v-list-item>
                      <v-list-item-title
                        class="d-flex justify-space-between"
                        @click="downloadBrochure"
                      >
                        <!-- <v-icon>mdi-cloud-download</v-icon>
                        <div class="text-center">Download</div>
                        <div class="text-center"></div> -->
                        <v-btn
                          block
                          large
                          color="grey darken-1"
                          class="white--text"
                          exact
                        >
                          <v-icon small left>mdi-cloud-download</v-icon>
                          <span v-text="'Download Guidelines'"></span>
                        </v-btn>
                      </v-list-item-title>
                    </v-list-item>
                  </v-list>
                </v-menu>
                <v-btn
                  v-else
                  class="white--text ma-md-3 mr-md-auto"
                  color="#de182e"
                  x-large
                  exact
                  @click="downloadBrochure"
                >
                  <v-icon class="mr-2">mdi-cloud-download</v-icon>
                  <span class="" v-text="'Honda Branding Guidelines'"></span>
                </v-btn>
              </div>
            </v-toolbar>
            <v-divider></v-divider>
          </div>
          <v-card-text class="">
            <v-row>
              <v-col>
                <v-tabs
                  class="dt-tabs"
                  v-model="activeTab"
                  background-color="transparent"
                  active-class="primary--text"
                  slider-color="primary"
                  color="primary"
                >
                  <v-tab
                    v-for="(folder, i) in folders"
                    :key="i"
                    @click="
                      assetPage = 1;
                      actionGetFolderAssets(folder.id);
                    "
                  >
                    <v-icon left small>mdi-folder</v-icon>
                    <span class="overline">{{ folder.name }}</span>
                  </v-tab>

                  <v-tab-item v-for="n in 8" :key="n">
                    <v-container class="mt-5 px-0" fluid>
                      <v-card v-show="loading">
                        <v-row justify="space-around" align="center">
                          <v-col cols="4">
                            <skeleton-asset></skeleton-asset>
                          </v-col>
                          <v-col cols="4">
                            <skeleton-asset></skeleton-asset>
                          </v-col>
                          <v-col cols="4">
                            <skeleton-asset></skeleton-asset>
                          </v-col>
                        </v-row>
                      </v-card>

                      <v-row v-if="assets.data && !loading">
                        <v-col cols="12" md="6">
                          <v-alert
                            v-if="assets.data.length <= 0"
                            prominent
                            type="error"
                          >
                            <v-row align="center">
                              <v-col class="grow">
                                No available files for this category and folder.
                              </v-col>
                              <v-col class="shrink">
                                <v-btn @click="uploadFile()" color="black"
                                  >Add files</v-btn
                                >
                              </v-col>
                            </v-row>
                          </v-alert>
                        </v-col>
                      </v-row>

                      <v-row>
                        <v-col
                          v-for="(list, i) in assets.data"
                          :key="i"
                          cols="12"
                          md="4"
                        >
                          <v-card style="height: 100%">
                            <v-img
                              :src="list.preview_url"
                              :lazy-src="list.preview_url"
                              aspect-ratio="1"
                              height="200px"
                              class="pointer"
                              @click="zoomImage(list)"
                            ></v-img>
                            <v-card-title class="pb-3 px-4">{{
                              list.name
                            }}</v-card-title>
                            <v-card-subtitle class="pb-0">
                              <small>{{ list.description }}</small>
                              <v-list dense disabled>
                                <v-list-item-group color="primary">
                                  <v-list-item>
                                    <v-list-item-icon>
                                      <v-icon small>mdi-calendar</v-icon>
                                    </v-list-item-icon>
                                    <v-list-item-content>
                                      <v-list-item-title
                                        class="muted--text text-wrap"
                                        >Expiry
                                        {{
                                          list.expired_at | formatExpiryDate
                                        }}</v-list-item-title
                                      >
                                    </v-list-item-content>
                                  </v-list-item>
                                  <v-list-item>
                                    <v-list-item-icon>
                                      <v-icon small>mdi-image</v-icon>
                                    </v-list-item-icon>
                                    <v-list-item-content>
                                      <v-list-item-title
                                        class="muted--text text-wrap"
                                      >
                                        <span v-if="list.width && list.height"
                                          >{{ list.width }} x
                                          {{ list.height }}
                                          &nbsp;&bull;&nbsp;</span
                                        >
                                        {{ list.size_display }}
                                      </v-list-item-title>
                                    </v-list-item-content>
                                  </v-list-item>
                                  <v-list-item>
                                    <v-chip
                                      v-if="checkAssetExpiration(list)"
                                      color="red"
                                      text-color="white"
                                      small
                                      class="mx-1"
                                    >
                                      EXPIRED
                                    </v-chip>
                                    <v-chip
                                      v-if="!list.status"
                                      color="warning"
                                      text-color="white"
                                      small
                                      class="mx-1"
                                    >
                                      INACTIVE
                                    </v-chip>
                                  </v-list-item>
                                </v-list-item-group>
                              </v-list>
                            </v-card-subtitle>

                            <v-card-actions>
                              <v-btn
                                @click="download(list)"
                                color="primary"
                                depressed
                                text
                              >
                                <small>DOWNLOAD</small>
                              </v-btn>
                              <v-spacer></v-spacer>
                              <v-btn
                                v-if="user.is_admin"
                                @click="edit(list)"
                                color="warning"
                                depressed
                                text
                              >
                                <small>EDIT</small>
                              </v-btn>
                              <v-btn
                                v-if="user.is_admin"
                                @click="remove(list)"
                                color="error"
                                depressed
                                text
                              >
                                <small>DELETE</small>
                              </v-btn>
                            </v-card-actions>
                          </v-card>
                        </v-col>
                      </v-row>
                      <div v-if="totalAssetPage > 1" class="text-center">
                        <v-pagination
                          v-model="assetPage"
                          :length="totalAssetPage"
                          class="mt-8 mx-2"
                          @input="assetsPaginate"
                        ></v-pagination>
                      </div>
                    </v-container>
                  </v-tab-item>
                </v-tabs>
              </v-col>
            </v-row>
          </v-card-text>
        </v-card>
      </v-col>
    </v-row>

    <v-dialog
      v-model="uploadDialog"
      max-width="1200px"
      class="overflow-hidden"
      v-if="user.is_admin"
    >
      <v-card class="pa-4">
        <v-card-title>
          <h2 title="Edit" class="mb-1">Upload File</h2>
        </v-card-title>

        <v-card-text class="overflow-y-auto">
          <v-alert v-if="success" type="success"
            >Files successfully uploaded.</v-alert
          >
          <v-alert v-if="error" type="error">{{ error }}</v-alert>
        </v-card-text>

        <v-form ref="form" v-model="valid" lazy-validation>
          <v-card-text class="overflow-y-auto">
            <v-row>
              <v-col cols="12" md="4">
                <v-select
                  append-icon="mdi-chevron-down"
                  :items="activeCategories"
                  item-text="name"
                  item-value="id"
                  label="Category*"
                  outlined
                  clearable
                  hide-details
                  clear-icon="mdi-close-circle-outline"
                  background-color="selects"
                  :rules="[(v) => !!v || 'Category is required']"
                  v-model="uploadCategoryId"
                ></v-select>
              </v-col>
              <v-col cols="12" md="4">
                <v-select
                  append-icon="mdi-chevron-down"
                  :items="uploadFolders"
                  item-text="name"
                  item-value="id"
                  label="Folder*"
                  outlined
                  clearable
                  hide-details
                  clear-icon="mdi-close-circle-outline"
                  background-color="selects"
                  v-model="uploadFolderId"
                  :rules="[(v) => !!v || 'Folder is required']"
                ></v-select>
              </v-col>
              <v-col cols="12" md="4">
                <v-select
                  append-icon="mdi-chevron-down"
                  :items="dlrList"
                  item-text="name"
                  item-value="id"
                  label="Dealers"
                  outlined
                  clearable
                  hide-details
                  multiple
                  clear-icon="mdi-close-circle-outline"
                  background-color="selects"
                  v-model="uploadDealers"
                >
                  <template v-slot:prepend-item>
                    <v-list-item ripple @mousedown.prevent @click="toggle">
                      <v-list-item-action>
                        <v-icon
                          :color="
                            uploadDealers.length > 0 ? 'indigo darken-4' : ''
                          "
                        >
                          {{ icon }}
                        </v-icon>
                      </v-list-item-action>
                      <v-list-item-content>
                        <v-list-item-title> Select All </v-list-item-title>
                      </v-list-item-content>
                    </v-list-item>
                    <v-divider class="mt-2"></v-divider>
                  </template>
                  <template v-slot:selection="{ item, index }">
                    <span v-if="index === 0">{{ item.name }},&nbsp;</span>
                    <span v-if="index === 1" class="grey--text text-caption">
                      (+{{ uploadDealers.length - 1 }} others)
                    </span>
                  </template>
                </v-select>
              </v-col>
            </v-row>
          </v-card-text>

          <v-card-text class="overflow-y-auto">
            <div v-for="(uploadFile, index) in uploadFiles" :key="index">
              <v-row>
                <v-col cols="12" md="4">
                  <div
                    class="
                      d-flex-culumn
                      justify-center
                      align-center
                      myDropzone-wrapper
                    "
                  >
                    <v-text-field
                      v-model="uploadFiles[index].file"
                      label="Title"
                      class="dt-text-field mt-2 d-none"
                      outlined
                      hide-details
                    ></v-text-field>
                    <div
                      :ref="`myDrop${index}`"
                      :id="'myDrop-' + index"
                      :class="'myDropzone-' + index"
                      class="myDropzone"
                    >
                      <p
                        :class="'myDropzone-message-' + index"
                        class="myDropzone-message"
                      >
                        Click or drag file here
                      </p>
                    </div>
                    <!-- <div class="text-center text-caption" id="myDrop">Drop file here</div> -->
                  </div>
                </v-col>

                <v-col cols="12" md="4">
                  <v-text-field
                    v-model="uploadFiles[index].title"
                    label="Title"
                    class="dt-text-field mt-2"
                    outlined
                    hide-details
                    :rules="[(v) => !!v || 'Title is required']"
                  ></v-text-field>
                </v-col>

                <v-col cols="12" md="3">
                  <v-menu
                    v-model="uploadFiles[index].datepickerMenu"
                    :close-on-content-click="false"
                    :nudge-right="40"
                    transition="scale-transition"
                    offset-y
                    min-width="auto"
                  >
                    <template v-slot:activator="{ on, attrs }">
                      <v-text-field
                        label="Expiry Date"
                        class="dt-text-field dt-brand-asset mt-2"
                        type="date"
                        outlined
                        hide-details
                        v-model="uploadFiles[index].expired_at"
                        v-bind="attrs"
                        v-on="on"
                        :rules="[(v) => !!v || 'Expiry date is required']"
                      ></v-text-field>
                    </template>
                    <v-date-picker
                      v-model="uploadFiles[index].expired_at"
                      @input="menu2 = false"
                    ></v-date-picker>
                  </v-menu>
                </v-col>

                <v-col class="delete-brand-asset-row" cols="12" md="1">
                  <v-btn @click="deleteRow(index)" icon>
                    <v-icon>mdi-trash-can</v-icon>
                  </v-btn>
                </v-col>
                <v-divider></v-divider>
              </v-row>
              <v-row>
                <v-col cols="12" md="12">
                  <v-divider></v-divider>
                </v-col>
              </v-row>
            </div>
            <v-row>
              <v-col cols="12" md="12">
                <v-btn
                  color="info"
                  large
                  v-if="user.is_admin"
                  @click="addRow()"
                >
                  <v-icon small left>mdi-plus</v-icon>
                  Add file
                </v-btn>
              </v-col>
            </v-row>
          </v-card-text>
          <v-card-actions>
            <v-spacer></v-spacer>
            <v-btn
              :disabled="loadingSubmit"
              @click="uploadDialog = false"
              large
              color="grey"
              exact
              class="ma-1 white--text px-5 mr-3"
            >
              Close
            </v-btn>

            <v-btn
              large
              exact
              color="green darken-1"
              class="ma-1 white--text px-5"
              @click="submit"
              :loading="loadingSubmit"
              :disabled="loadingSubmit"
            >
              <v-icon left>mdi-content-save</v-icon>
              Submit
            </v-btn>
          </v-card-actions>
        </v-form>
      </v-card>
    </v-dialog>

    <v-dialog
      v-model="editDialog"
      max-width="1200px"
      class="overflow-hidden"
      v-if="user.is_admin && editFile"
    >
      <v-card class="pa-4">
        <v-card-title>
          <h2 title="Edit" class="mb-1">Edit File</h2>
        </v-card-title>

        <v-card-text v-if="success || error" class="overflow-y-auto">
          <v-alert v-if="success" type="success"
            >File successfully updated.</v-alert
          >
          <v-alert v-if="error" type="error">{{ error }}</v-alert>
        </v-card-text>

        <v-form ref="form" v-model="valid" lazy-validation>
          <v-card-text class="overflow-y-auto">
            <v-row>
              <v-col cols="12" md="4">
                <v-select
                  append-icon="mdi-chevron-down"
                  :items="activeCategories"
                  item-text="name"
                  item-value="id"
                  label="Category*"
                  outlined
                  clearable
                  hide-details
                  clear-icon="mdi-close-circle-outline"
                  background-color="selects"
                  :rules="[(v) => !!v || 'Category is required']"
                  v-model="editFile.category_id"
                ></v-select>
              </v-col>
              <v-col cols="12" md="4">
                <v-select
                  append-icon="mdi-chevron-down"
                  :items="uploadFolders"
                  item-text="name"
                  item-value="id"
                  label="Folder*"
                  outlined
                  clearable
                  hide-details
                  clear-icon="mdi-close-circle-outline"
                  background-color="selects"
                  v-model="editFile.folder_id"
                  :rules="[(v) => !!v || 'Folder is required']"
                ></v-select>
              </v-col>
              <v-col cols="12" md="4">
                <v-select
                  append-icon="mdi-chevron-down"
                  :items="dlrList"
                  item-text="name"
                  item-value="id"
                  label="Dealers"
                  outlined
                  clearable
                  hide-details
                  multiple
                  clear-icon="mdi-close-circle-outline"
                  background-color="selects"
                  v-model="editFile.dealers"
                >
                  <template v-slot:prepend-item>
                    <v-list-item ripple @mousedown.prevent @click="toggleEdit">
                      <v-list-item-action>
                        <v-icon
                          :color="
                            editFile.dealers.length > 0 ? 'indigo darken-4' : ''
                          "
                        >
                          {{ iconEdit }}
                        </v-icon>
                      </v-list-item-action>
                      <v-list-item-content>
                        <v-list-item-title> Select All </v-list-item-title>
                      </v-list-item-content>
                    </v-list-item>
                    <v-divider class="mt-2"></v-divider>
                  </template>
                  <template v-slot:selection="{ item, index }">
                    <span v-if="index === 0">{{ item.name }},&nbsp;</span>
                    <span v-if="index === 1" class="grey--text text-caption">
                      (+{{ editFile.dealers.length - 1 }} others)
                    </span>
                  </template>
                </v-select>
              </v-col>
            </v-row>
          </v-card-text>

          <v-card-text class="overflow-y-auto">
            <v-row>
              <!-- <v-col cols="12" md="4">
                <div
                  class="d-flex-culumn justify-center align-center"
                  style="height: 100% !important"
                  @drop.prevent="addDropfile($event, index)"
                  @dragover.prevent="dragOver($event)"
                  @dragleave.prevent="dragLeave($event)"
                >
                  <v-file-input
                    label="Click or drag file here"
                    hide-details
                    outlined
                    class="ma-2"
                    v-model="editFile.file"
                  ></v-file-input>
                </div>
              </v-col> -->

              <v-col cols="12" md="4">
                <div
                  class="
                    d-flex-culumn
                    justify-center
                    align-center
                    myDropzone-wrapper
                  "
                >
                  <div
                    :ref="`myDropEdit${editFile.id}`"
                    :id="'myDropEdit-' + editFile.id"
                    :class="'myDropzone-' + editFile.id"
                    class="myDropzone"
                  >
                    <p
                      :class="'myDropzone-message-' + editFile.id"
                      class="myDropzone-message"
                    >
                      Click or drag file here
                    </p>
                  </div>
                  <!-- <div class="text-center text-caption" id="myDrop">Drop file here</div> -->
                </div>
              </v-col>

              <v-col cols="12" md="4">
                <v-text-field
                  v-model="editFile.name"
                  label="Title"
                  class="dt-text-field mt-2"
                  outlined
                  hide-details
                  :rules="[(v) => !!v || 'Title is required']"
                ></v-text-field>
              </v-col>

              <v-col cols="12" md="4">
                <v-menu
                  v-model="editFile.datepickerMenu"
                  :close-on-content-click="false"
                  :nudge-right="40"
                  transition="scale-transition"
                  offset-y
                  min-width="auto"
                >
                  <template v-slot:activator="{ on, attrs }">
                    <v-text-field
                      label="Expiry Date"
                      class="dt-text-field dt-brand-asset mt-2"
                      type="date"
                      outlined
                      hide-details
                      v-model="editFile.expired_at"
                      v-bind="attrs"
                      v-on="on"
                      :rules="[(v) => !!v || 'Expiry date is required']"
                    ></v-text-field>
                  </template>
                  <v-date-picker
                    v-model="editFile.expired_at"
                    @input="menu3 = false"
                  ></v-date-picker>
                </v-menu>
              </v-col>

              <v-col cols="12" md="8">
                <v-textarea
                  type="textarea"
                  label="Description"
                  outlined
                  hide-details
                  v-model="editFile.description"
                  rows="3"
                  row-height="30"
                  auto-grow
                ></v-textarea>
              </v-col>
              <v-col cols="12">
                <v-switch
                  label="Status"
                  hide-details
                  v-model="editFile.status"
                ></v-switch>
              </v-col>
            </v-row>
            <v-row>
              <v-col cols="12" md="12">
                <v-divider></v-divider>
              </v-col>
            </v-row>
          </v-card-text>
          <v-card-actions>
            <v-spacer></v-spacer>
            <v-btn
              :disabled="loadingSubmit"
              @click="editDialog = false"
              large
              color="grey"
              exact
              class="ma-1 white--text px-5 mr-3"
            >
              Close
            </v-btn>

            <v-btn
              large
              exact
              color="green darken-1"
              class="ma-1 white--text px-5"
              @click="update"
              :loading="loadingSubmit"
              :disabled="loadingSubmit"
            >
              <v-icon left>mdi-content-save</v-icon>
              Submit
            </v-btn>
          </v-card-actions>
        </v-form>
      </v-card>
    </v-dialog>

    <v-overlay
      :value="imageZoom.overlay"
      @click="imageZoom.overlay = false"
      z-index="99999"
      :opacity="0.9"
    >
      <v-img
        v-if="imageZoom.src && imageZoom.type == 'image'"
        :src="imageZoom.src"
        style="max-width: 100% !important"
        @click="imageZoom.overlay = false"
      ></v-img>

      <video v-if="imageZoom.src && imageZoom.type == 'video'" class="video-preview" controls>
        <source :src="imageZoom.src" type="video/mp4" />
        Your browser does not support the video tag.
      </video>
    </v-overlay>

    <div id="dropzone-container">
      <div class="dz-preview dz-file-preview">
        <div class="dz-details">
          <div class="dz-filename">
            <small data-dz-name></small>
          </div>
        </div>
        <div class="dz-progress">
          <v-progress-linear
            value="0"
            data-dz-uploadprogress
            height="8"
            class="mt-2"
          ></v-progress-linear>
        </div>
        <div class="dz-error-message"><small data-dz-errormessage></small></div>
      </div>
    </div>
  </admin>
</template>

<script>
import UserType from "@/components/UserType/UserType";
import apiAssetsService from "@/services/api/modules/assetsService";
import { mapActions, mapGetters } from "vuex";
import moment from "moment";
import { Dropzone } from "dropzone";

export default {
  data() {
    return {
      imageZoom: {
        overlay: false,
        src: null,
        width: 0,
        type: null,
      },
      apiEndpoint: null,
      valid: true,
      assetPage: 1,
      assetPageLimit: 6,
      totalAssetPage: 0,
      activeTab: 0,
      activeFolderId: null,
      uploadDialog: false,
      editDialog: false,
      editFile: null,
      loading: false,
      loadingSubmit: false,
      model: "",
      uploadCategoryId: null,
      uploadFolderId: null,
      uploadDealers: [],
      uploadGuidelinesLoading: false,
      success: false,
      error: false,
      category: null,
      listAssets: [],
      activeCategories: [],
      user: null,
      userList: [
        {
          text: "HCPI",
          value: "hcpi",
        },
        {
          text: "Dealer",
          value: "dealer",
        },
      ],
      uploadedFilesCount: 0,
      uploadFiles: [
        {
          file: "",
          title: "",
          expired_at: "",
          datepickerMenu: false,
        },
      ],
      defaultUploadFile: {
        file: "",
        title: "",
        expired_at: "",
      },
      previewExtensions: [
        "png",
        "jpg",
        "jpeg",
        "gif",
        "svg",
        "webp",
        "jfif",
        "pjpeg",
        "pjp",
      ],
      videoPlayExtensions: ["mp4"],
      dropzone: null,
      dropzoneEdit: null,
    };
  },
  filters: {
    formatExpiryDate: function (value) {
      if (!value) return "";
      return moment(value).format("MMMM D, YYYY");
    },
  },
  computed: {
    ...mapGetters({
      folders: "assets/GET_FOLDERS",
      assets: "assets/GET_BRANDASSETS",
      uploadFolders: "assets/GET_ACTIVE_UPLOADFOLDERS",
      storage: "assets/GET_STORAGE",
      categories: "categories/GET_ACTIVE_CATEGORIES",
      dlrList: "dealerGroups/GET_ACTIVE_DEALERGROUPS",
    }),
    userType() {
      return this.$store.getters.GET_USER_TYPE;
    },
    allDealersSelected() {
      return this.uploadDealers.length === this.dlrList.length;
    },
    someDealersSelected() {
      return this.uploadDealers.length > 0 && !this.allDealersSelected;
    },
    icon() {
      if (this.allDealersSelected) return "mdi-close-box";
      if (this.someDealersSelected) return "mdi-minus-box";
      return "mdi-checkbox-blank-outline";
    },
    allDealersSelectedEdit() {
      return this.editFile.dealers.length === this.dlrList.length;
    },
    someDealersSelectedEdit() {
      return this.editFile.dealers.length > 0 && !this.allDealersSelectedEdit;
    },
    iconEdit() {
      if (this.allDealersSelectedEdit) return "mdi-close-box";
      if (this.someDealersSelectedEdit) return "mdi-minus-box";
      return "mdi-checkbox-blank-outline";
    },
  },
  components: {
    UserType,
    SkeletonAsset: () => import("./cards/SkeletonAsset"),
  },
  created() {
    if (!localStorage.user) {
      this.$router.push({ name: "login" });
    } else {
      this.user = JSON.parse(localStorage.user);
    }
  },
  async mounted() {
    this.getStorage();
    await this.getActiveCategories();
    await this.getDealerGroups();
  },
  watch: {
    category: async function (val) {
      if (val) {
        await this.getCategoryFolders(val);
        if (this.folders.length > 0) {
          this.activeTab = 0;
          await this.actionGetFolderAssets(this.folders[0].id);
        }
      }
    },
    uploadCategoryId: function (val) {
      if (val) {
        this.getUploadCategoryFolders(val);
      }
    },
    uploadDialog(val) {
      if (val == true) {
        this.addDropZone();
      }
    },
  },
  methods: {
    ...mapActions({
      getCategoryFolders: "assets/getCategoryFolders",
      getFolderAssets: "assets/getFolderAssets",
      getUploadCategoryFolders: "assets/getUploadCategoryFolders",
      getStorage: "assets/getStorage",
      getCategories: "categories/getCategories",
      getDealerGroups: "dealerGroups/list",
    }),
    addDropZone() {
      let vm = this;
      setTimeout(() => {
        Dropzone.autoDiscover = false;

        const dpIndex = vm.uploadFiles.length - 1;

        var uploader = vm.$refs[`myDrop${dpIndex}`][0]; //document.querySelector("#myDrop-" + uploadedFilesCount);

        vm.dropzone = new Dropzone(uploader, {
          url:
            process.env.VUE_APP_API_BASE_URL +
            process.env.VUE_APP_API_VERSION +
            "/assets/upload",
          paramName: "file", // The name that will be used to transfer the file
          chunking: true,
          retryChunks: true,
          chunkSize: 1000000,
          clickable: [
            ".myDropzone-message-" + dpIndex,
            ".myDropzone-" + dpIndex,
          ],
          // dictDefaultMessage: "Drop files here to upload",
          previewTemplate: document.querySelector("#dropzone-container")
            .innerHTML,
          sending: function (file, xhr, formData) {
            formData.append("uploadIndex", dpIndex);
          },
          accept: function (file, done) {
            done();
          },
          chunksUploaded: function (file, done) {
            done();
          },
          success: (file, response) => {
            vm.uploadFiles[response.data.index].file = response.data.name;
          },
        });
      }, 500);
    },
    async getActiveCategories() {
      await apiAssetsService.getCategories().then((res) => {
        this.activeCategories = res.data.data.filter(
          (category) => category.status
        );
      });
    },
    async submit() {
      if (!this.$refs.form.validate()) {
        return;
      }

      this.success = false;
      this.error = false;
      this.loadingSubmit = true;

      let fd = new FormData();

      fd.append("category_id", this.uploadCategoryId);
      fd.append("folder_id", this.uploadFolderId);
      let dealers = [];

      if (this.someDealersSelected) {
        this.uploadDealers.forEach((dealer) => {
          dealers.push(dealer);
        });
      }

      if (this.allDealersSelected) {
        dealers = null;
      }

      fd.append("dealers", JSON.stringify(dealers));

      this.uploadFiles.forEach((file, index) => {
        fd.append(`files[${index}][file]`, this.uploadFiles[index].file);
        fd.append(`files[${index}][name]`, this.uploadFiles[index].title);
        fd.append(
          `files[${index}][expired_at]`,
          this.uploadFiles[index].expired_at
        );
      });

      const { status, data } = await apiAssetsService.upload(fd);

      this.loadingSubmit = false;

      if (status === 200) {
        this.success = true;
        this.error = false;

        this.$refs.form.reset();

        this.uploadDealers = [];

        if (Dropzone.instances.length > 0)
          Dropzone.instances.forEach((bz) => bz.destroy());

        this.uploadFiles = [
          {
            file: "",
            title: "",
            expired_at: "",
            datepickerMenu: false,
          },
        ];

        this.addDropZone();

        this.getStorage();
        this.assetPage = 1;
        this.actionGetFolderAssets(this.uploadFolderId);
      } else {
        this.success = false;
        this.error = data.message;
      }
    },
    async update() {
      if (!this.$refs.form.validate()) {
        return;
      }

      this.success = false;
      this.error = false;
      this.loadingSubmit = true;

      let fd = new FormData();

      fd.append("category_id", this.editFile.category_id);
      fd.append("folder_id", this.editFile.folder_id);
      fd.append("name", this.editFile.name);
      fd.append("description", this.editFile.description);
      fd.append("expired_at", this.editFile.expired_at);
      fd.append("status", this.editFile.status ? 1 : 0);

      if (this.editFile.file) {
        fd.append("file", this.editFile.file);
      }

      let dealers = [];

      if (this.someDealersSelectedEdit) {
        this.editFile.dealers.forEach((dealer) => {
          dealers.push(dealer);
        });
      }

      if (this.allDealersSelectedEdit) {
        dealers = null;
      }

      // if (this.editFile.dealers) {
      //   this.editFile.dealers.forEach((dealer) => {
      //     dealers.push(dealer);
      //   });

      //   this.editFile.dealers.find((dealer) => {
      //     if (null == dealer) {
      //       dealers = null;
      //     }
      //   });
      // }

      fd.append("dealers", JSON.stringify(dealers));

      const { status, data } = await apiAssetsService.updateAsset(
        this.editFile.id,
        fd
      );

      this.loadingSubmit = false;

      if (status === 200) {
        this.success = true;
        this.error = false;

        this.uploadDealers = [];

        if (Dropzone.instances.length > 0)
          Dropzone.instances.forEach((bz) => bz.destroy());

        this.getStorage();
        this.assetPage = 1;
        this.actionGetFolderAssets(this.editFile.folder_id);
      } else {
        this.success = false;
        this.error = data.message;
      }
    },
    download(asset) {
      var redirect = window.open(asset.download_url, "_blank");
      redirect.location;
    },
    async uploadBrochure(e) {
      this.uploadGuidelinesLoading = true;
      let fd = new FormData();

      fd.append(`file`, e);

      await apiAssetsService.uploadGuidelines(fd);
      this.uploadGuidelinesLoading = false;
    },
    downloadBrochure() {
      var redirect = window.open(
        "http://hondadealerportalapi.sdisend.com/assets/branding-guidelines/download?v=" +
          moment().unix(),
        "_blank"
      );
      redirect.location;
    },
    async remove(asset) {
      await apiAssetsService.delete(asset.id);
      this.assetPage = 1;
      this.actionGetFolderAssets(asset.folder_id);
    },
    async edit(asset) {
      this.getUploadCategoryFolders(asset.category_id);

      let dealerIds = asset.dealers;

      if (!asset.dealers) {
        dealerIds = [];
        this.dlrList.forEach(function (item) {
          dealerIds.push(item.id);
        });
      }

      this.editFile = {
        id: asset.id,
        category_id: asset.category_id,
        folder_id: asset.folder_id,
        dealers: dealerIds,
        name: asset.name,
        description: asset.description,
        status: asset.status,
        file: asset.file,
        expired_at: moment(asset.expired_at).format("YYYY-MM-DD"),
        datepickerMenu: false,
      };

      this.success = false;
      this.error = false;
      this.editDialog = true;

      //Clear Dropzone
      if (Dropzone.instances.length > 0)
        Dropzone.instances.forEach((bz) => bz.destroy());

      //Dropzone
      let vm = this;

      setTimeout(() => {
        Dropzone.autoDiscover = false;

        const dpIndex = asset.id;

        var uploader = document.querySelector("#myDropEdit-" + dpIndex); //vm.$refs[`myDropEdit${dpIndex}`][0];

        vm.dropzoneEdit = new Dropzone(uploader, {
          url:
            process.env.VUE_APP_API_BASE_URL +
            process.env.VUE_APP_API_VERSION +
            "/assets/upload",
          paramName: "file", // The name that will be used to transfer the file
          chunking: true,
          retryChunks: true,
          chunkSize: 1000000,
          clickable: [
            ".myDropzone-message-" + dpIndex,
            ".myDropzone-" + dpIndex,
          ],
          // dictDefaultMessage: "Drop files here to upload",
          previewTemplate: document.querySelector("#dropzone-container")
            .innerHTML,
          accept: function (file, done) {
            done();
          },
          chunksUploaded: function (file, done) {
            done();
          },
          success: (file, response) => {
            vm.editFile.file = response.data.name;
          },
        });
      }, 500);
    },
    showTip(e) {
      document.querySelector(".tooltip-message").classList.remove("d-none");
    },
    uploadFile() {
      this.success = false;
      this.error = false;
      this.uploadDialog = true;
    },
    addRow() {
      this.uploadFiles.push({
        file: "",
        title: "",
        expired_at: "",
        datepickerMenu: false,
      });
      this.uploadedFilesCount++;

      console.log("TESTESt");

      this.addDropZone();
    },
    deleteRow(index) {
      this.uploadFiles.splice(index, 1);
      var uploader = document.querySelector("#myDrop-" + index);

      uploader.dropzone.destroy();

      uploader.remove();
    },
    closeDialog() {
      this.uploadDialog = false;
    },
    zoomImage(asset) {
      if (this.previewExtensions.includes(asset.extension)) {
        this.imageZoom.src = null;
        this.imageZoom.overlay = !this.imageZoom.overlay;
        this.imageZoom.src = asset.preview_url;
        this.imageZoom.type = "image";
      }

      if (this.videoPlayExtensions.includes(asset.extension)) {
        this.imageZoom.src = null;
        this.imageZoom.overlay = !this.imageZoom.overlay;
        this.imageZoom.src = asset.download_url;
        this.imageZoom.type = "video";
      }
    },
    checkAssetExpiration(asset) {
      return moment(asset.expired_at).diff(moment()) <= 0 ? true : false;
    },
    async actionGetFolderAssets(id) {
      this.loading = true;
      await this.getFolderAssets({
        id,
        page: this.assetPage,
        limit: this.assetPageLimit,
      });

      this.activeFolderId = id;
      this.totalAssetPage = Math.ceil(
        this.assets.meta.total / this.assetPageLimit
      );

      this.loading = false;
    },
    async assetsPaginate() {
      this.loading = true;

      await this.getFolderAssets({
        id: this.activeFolderId,
        page: this.assetPage,
        limit: this.assetPageLimit,
      });

      this.loading = false;
    },
    addDropfile(e, i) {
      this.uploadFiles[i].file = e.dataTransfer.files[0];

      e.currentTarget.classList.remove("green");
      e.currentTarget.classList.remove("lighten-4");
    },
    dragOver(e) {
      e.currentTarget.classList.add("green");
      e.currentTarget.classList.add("lighten-4");
    },
    dragLeave(e) {
      e.currentTarget.classList.remove("green");
      e.currentTarget.classList.remove("lighten-4");
    },
    toggle() {
      this.$nextTick(() => {
        if (this.allDealersSelected) {
          this.uploadDealers = [];
        } else {
          this.uploadDealers = this.dlrList.slice();
        }
      });
    },
    toggleEdit() {
      this.$nextTick(() => {
        if (this.allDealersSelectedEdit) {
          this.editFile.dealers = [];
        } else {
          this.editFile.dealers = this.dlrList.slice();
        }
      });
    },
  },
};
</script>
<style scoped>
.dt-brand-asset input[type="date"]::-webkit-inner-spin-button,
.dt-brand-asset input[type="date"]::-webkit-calendar-picker-indicator {
  display: none;
  -webkit-appearance: none;
  opacity: 0;
  background: red;
}
.delete-brand-asset-row {
  align-items: start;
  justify-content: center;
  display: flex;
  margin-top: 15px;
}

.pointer {
  cursor: pointer;
}

.v-overlay__content {
  max-width: 100%;
}

.myDropzone {
  border: 1px solid #d2ddec;
  background: transparent;
  transition: 0.3s cubic-bezier(0.25, 0.8, 0.5, 1);
  border-radius: 8px;
  height: 100%;
  width: 100%;
  margin-top: 8px !important;
  position: relative;
}

.myDropzone-wrapper {
  height: 100% !important;
  padding-bottom: 7px;
}

.dz-progress {
  position: absolute;
  width: 100%;
  bottom: 0;
}

.dz-filename {
  padding: 12px 12px 0px;
}

.dz-error-message {
  padding: 0px 12px 5px;
  color: #f44336 !important;
}

.myDropzone-message {
  color: rgba(0, 0, 0, 0.6);
  text-align: center;
  margin: 0;
  margin-top: 13px;
  font-size: 16px !important;
}

.myDropzone.dz-started .myDropzone-message {
  display: none !important;
}

.video-preview {
  width: 100%;
  height: auto;
  max-height: 400px;
  max-width: 600px;
}
</style>
