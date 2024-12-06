<template>
  <div>

    <div v-if="loading">
      <loading />
    </div>
    <div v-else>

      <div class="chat-wrapper d-lg-flex gap-1 mx-n4 mt-n4 p-1">
        <div class="chat-leftsidebar minimal-border">
          <div class="px-3 pt-3 pb-3 mb-0">
            <div class="d-flex align-items-center">
              <div class="flex-grow-1 overflow-hidden">
                <h5 class="mb-0 mt-1 text-truncate">File Categories</h5>
              </div>
              <div style="height: 27.063px;">
                <div class="flex-shrink-0" v-if="auth.new == 1">
                  <!-- <button type="button" class="btn btn-soft-success btn-sm material-shadow-none" @click="newCategory">
                  <i class="ri-add-line align-bottom"></i>
                </button> -->
                  <button class="btn btn-soft-success btn-sm material-shadow-none dropdown" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                    <i class="ri-more-fill bx bx-dots-horizontal align-middle"></i>
                  </button>
                  <ul class="dropdown-menu dropdown-menu-end" style="">
                    <li><a class="dropdown-item" href="javascript:void(0)" @click="newCategory"><i class="ri-add-fill align-bottom me-2 text-muted"></i> Add</a></li>
                    <li v-if="auth.edit == 1"><a class="dropdown-item" href="javascript:void(0)" @click="editCategory"><i class="ri-pencil-fill align-bottom me-2 text-muted"></i> Rename</a></li>
                    <li v-if="auth.del == 1"><a class="dropdown-item" href="javascript:void(0)" @click="delCategory"><i class="ri-delete-bin-fill align-bottom me-2 text-muted"></i> Delete</a></li>
                  </ul>
                </div>
              </div>
            </div>
            <form class="app-search d-md-block pt-4 mt-1 pb-0 ps-0">
              <div class="position-relative">
                <input type="text" class="form-control bg-light border-0" placeholder="Search file category..." v-model="search" @input="onSearch">
                <span class="ri-search-line search-icon search-widget-icon fs-14"></span>
                <span class="mdi mdi-close-circle search-widget-icon search-widget-icon-close cursor-pointer d-none" id="search-close" @click="searchClear"></span>
              </div>
            </form>
          </div>

          <div class="chat-room-list simplebar-scrollable-y" data-simplebar="init">
            <div class="simplebar-wrapper" style="margin: -16px 0px 0px;">
              <div class="simplebar-height-auto-observer-wrapper">
                <div class="simplebar-height-auto-observer"></div>
              </div>
              <div class="simplebar-mask">
                <div class="simplebar-offset" style="right: 0px; bottom: 0px;">
                  <div class="simplebar-content-wrapper" tabindex="0" role="region" aria-label="scrollable content" style="height: auto; overflow: hidden scroll;">
                    <div class="simplebar-content" style="padding: 0px 0px 0px;">

                      <div class="chat-message-list">
                        <ul class="list-unstyled chat-list chat-user-list">
                          <li v-for="(item, index) in categoryList" :key="index" @click="cateSelected(item.file_category, index)" :id="'category-' + index" :title="item.descr">
                            <a href="javascript: void(0)" class="py-2">
                              <div class="d-flex align-items-center">
                                <div class="flex-grow-1 overflow-hidden">
                                  <p class="text-truncate mb-0 fs-13">{{ item.file_category }}</p>
                                </div>
                              </div>
                            </a>
                          </li>
                        </ul>
                      </div>

                    </div>
                  </div>
                </div>
              </div>
              <div class="simplebar-placeholder" style="width: 300px; height: calc(100vh - 18rem);"></div>
              <!-- <div class="simplebar-placeholder" style="width: 300px; height: calc(100vh - 13.125rem);"></div> -->
            </div>
          </div>
        </div>

        <div class="user-chat w-100 overflow-hidden minimal-border user-chat-show" id="code-detail">
          <!-- <div class="user-chat w-100 overflow-hidden minimal-border"> -->

          <div class="chat-content d-lg-flex">
            <div class="w-100 overflow-hidden position-relative">
              <div class="position-relative">

                <div class="position-relative" id="channel-chat" style="display: block;">
                  <div class="p-3 user-chat-topbar">
                    <div class="row align-items-center">
                      <div class="col-sm-4 col-8">
                        <div class="d-flex align-items-center">
                          <div class="flex-shrink-0 d-block d-lg-none me-3" @click="backToMain">
                            <a href="javascript: void(0);" class="user-chat-remove fs-18 p-1"><i class="ri-arrow-left-s-line align-bottom"></i></a>
                          </div>
                          <form class="app-search d-md-block p-0">
                            <div class="position-relative">
                              <input type="text" class="form-control bg-light border-0" placeholder="Search file..." v-model="searchFile" @input="onSearchFile">
                              <span class="ri-search-line search-icon search-widget-icon fs-14"></span>
                              <span class="mdi mdi-close-circle search-widget-icon search-widget-icon-close cursor-pointer d-none" id="search-file-x" @click="searchFileClear"></span>
                            </div>
                          </form>
                        </div>
                      </div>
                      <div class="col-sm-8 col-4">
                        <ul class="list-inline user-chat-nav text-end mb-0">
                          <li class="list-inline-item m-0">
                            <div class="d-flex gap-sm-0 email-topbar-link">
                              <button type="button" class="btn btn-soft-info add-btn" id="create-btn" @click="newFile"><i class="ri-add-line align-bottom me-1"></i> Add File</button>
                            </div>
                          </li>
                        </ul>
                      </div>
                    </div>
                  </div>

                  <div class="chat-conversation d-block px-3 px-lg-3 mt-lg-0" style="margin-top: 12px;">
                    <div class="table-responsive" style="max-height: calc(100vh - 15.0rem);">
                      <table class="table align-middle table-nowrap mb-0">
                        <thead class="table-light position-sticky" style="top: 0px;">
                          <tr>
                            <!-- <th class="ps-3" style="width: 40px">#</th> -->
                            <th>Name</th>
                            <th>Description</th>
                            <th>Type</th>
                            <th>Size</th>
                            <th>Created at</th>
                            <th>Created by</th>
                            <th>Actions</th>
                          </tr>
                        </thead>
                        <tbody>
                          <tr v-for="(item, index) in fileFilterList" :key="index">
                            <!-- <td class="ps-3">{{ index + 1 }}</td> -->
                            <td>
                              <div class="d-flex align-items-center">
                                <div class="flex-shrink-0 fs-17 me-2 filelist-icon text-secondary">
                                  <i v-if="item.file_type == 'txt'" class="ri-file-text-fill text-info"></i>
                                  <i v-else-if="item.file_type == 'docx'" class="ri-file-word-fill"></i>
                                  <i v-else-if="item.file_type == 'xlsx'" class="ri-file-excel-fill text-success"></i>
                                  <i v-else-if="item.file_type == 'pptx'" class="ri-file-ppt-fill text-danger"></i>
                                  <i v-else-if="item.file_type == 'pdf'" class="ri-file-pdf-fill text-danger"></i>
                                  <i v-else-if="item.file_type == 'jpg'" class="ri-image-fill text-success"></i>
                                  <i v-else-if="item.file_type == 'jpeg'" class="ri-image-fill text-success"></i>
                                  <i v-else-if="item.file_type == 'png'" class="ri-image-fill text-success"></i>
                                  <i v-else-if="item.file_type == 'zip'" class="ri-folder-zip-line"></i>
                                  <i v-else-if="item.file_type == 'mp4'" class="ri-video-line"></i>
                                  <i v-else class="ri-file-unknow-fill text-warning"></i>
                                </div>
                                <div class="flex-grow-1 filelist-name">{{ item.file_name }}</div>
                              </div>
                            </td>
                            <td>{{ item.file_descr }}</td>
                            <td>{{ item.file_type }}</td>
                            <td>{{ item.size }}</td>
                            <td>{{ store.dateTime(item.created_at) }}</td>
                            <td>{{ item.created_by }}</td>
                            <td>
                              <div class="d-flex gap-2 justify-content-start">
                                <a v-if="item.file_type == 'jpg' || item.file_type == 'txt' || item.file_type == 'pdf' || item.file_type == 'jpeg' || item.file_type == 'png' || item.file_type == 'mp4'" href="#" class="link-success text-decoration-none fs-14 pt-1" @click="viewFile(item.new_name)" title="View"><i class="ri-eye-line"></i></a>
                                <a v-else href="#" class="link-success text-decoration-none fs-14 pt-1" title="Not available to view" @click="notView"><i class="ri-eye-off-line"></i></a>
                                <a href="#" class="link-success text-decoration-none fs-16" @click="downloadFile(item.new_name)" title="Download"><i class="ri-download-2-line"></i></a>
                                <button class="btn btn-soft-info btn-icon btn-sm material-shadow-none dropdown" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                  <i class="ri-more-fill bx bx-dots-horizontal align-middle"></i>
                                </button>
                                <ul class="dropdown-menu dropdown-menu-end" style="">
                                  <li><a class="dropdown-item" href="javascript:void(0)" @click="editFile(item.file_id)"><i class="ri-pencil-fill align-bottom me-2 text-muted"></i> Rename</a></li>
                                  <li><a class="dropdown-item" href="javascript:void(0)" @click="delFile(item.file_id, item.new_name)"><i class="ri-delete-bin-fill align-bottom me-2 text-muted"></i> Delete</a></li>
                                </ul>
                              </div>
                            </td>
                          </tr>
                        </tbody>
                      </table>
                    </div>
                  </div>
                </div>

              </div>
            </div>
          </div>
        </div>
      </div>

    </div>


    <!-- Add File Category Modal -->
    <div class="modal fade zoomIn" id="cate-modal" data-bs-keyboard="false" tabindex="-1" aria-modal="true" role="dialog" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
          <div class="modal-header bg-light p-3">
            <h5 v-if="actMode == 'add'" class="modal-title">Add File Category</h5>
            <h5 v-if="actMode == 'edit'" class="modal-title">Edit {{ cateForm.file_category }}</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" id="close-modal"></button>
          </div>
          <div class="modal-body">
            <div class="mb-3">
              <label class="form-label">File Category <span class="text-danger">*</span></label>
              <input type="text" class="form-control" placeholder="Enter name" v-model="cateForm.file_category">
            </div>
            <div class="mb-3">
              <label class="form-label">Description Eng <span class="text-danger">*</span></label>
              <textarea type="text" class="form-control" placeholder="Enter description" v-model="cateForm.descr"></textarea>
            </div>
          </div>
          <div class="modal-footer" style="display: block;">
            <div class="hstack gap-2 justify-content-end">
              <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
              <button v-if="actMode == 'add'" type="button" class="btn btn-success" :class="cateFormDis" @click="addCategory">Add Category</button>
              <button v-if="actMode == 'edit'" type="button" class="btn btn-success" :class="cateFormDis" @click="updCategory">Save Change</button>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Files Modal -->
    <div class="modal fade zoomIn" id="file-modal" data-bs-keyboard="false" tabindex="-1" aria-modal="true" role="dialog">
      <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
          <div class="modal-header bg-light p-3">
            <h5 v-if="actMode == 'add'" class="modal-title">Add {{ fileForm.file_category }} File</h5>
            <h5 v-if="actMode == 'edit'" class="modal-title">Rename</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <div class="mb-3">
              <label class="form-label">File Name <span class="text-danger">*</span></label>
              <input type="text" class="form-control" placeholder="Enter name" v-model="fileForm.file_name">
            </div>
            <div class="mb-3">
              <label class="form-label">File Description <span class="text-danger">*</span></label>
              <textarea type="text" class="form-control" placeholder="Enter description" v-model="fileForm.file_descr"></textarea>
            </div>
            <div class="mb-3" v-if="actMode == 'add'">
              <label class="form-label">File-Docs </label>
              <input type="file" class="form-control" ref="fileInput" @change="selectFile">
            </div>
          </div>
          <div class="modal-footer" style="display: block;">
            <div class="hstack gap-2 justify-content-end">
              <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
              <button v-if="actMode == 'add'" type="button" class="btn btn-success" :class="fileFormDis" @click="addFile">Add File</button>
              <button v-if="actMode == 'edit'" type="button" class="btn btn-success" :class="fileFormDis2" @click="updFile">Save Change</button>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Delete Category Modal -->
    <div class="modal fade zoomIn" id="cate-delete-modal" data-bs-keyboard="false" tabindex="-1" aria-modal="true" role="dialog" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
          <div class="modal-body text-center p-5">
            <lord-icon src="https://cdn.lordicon.com/gsqxdxog.json" trigger="loop" colors="primary:#405189,secondary:#f06548" style="width:90px;height:90px"></lord-icon>
            <div class="text-center">
              <h4 class="fs-semibold">You are about to delete a category ?</h4>
              <p class="text-muted fs-14 mb-4 pt-1">Deleting your category will remove all of your information from our database.</p>
              <div class="hstack gap-2 justify-content-center remove">
                <!-- <button class="btn btn-light" data-bs-dismiss="modal" data-bs-toggle="modal" data-bs-target="#incident-modal">Cancel</button> -->
                <button class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
                <button class="btn btn-soft-danger" @click="delCateConfirm">Yes, Delete It</button>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Delete Modal -->
    <div class="modal fade zoomIn" id="delete-modal" data-bs-keyboard="false" tabindex="-1" aria-modal="true" role="dialog" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
          <div class="modal-body text-center p-5">
            <lord-icon src="https://cdn.lordicon.com/gsqxdxog.json" trigger="loop" colors="primary:#405189,secondary:#f06548" style="width:90px;height:90px"></lord-icon>
            <div class="text-center">
              <h4 class="fs-semibold">You are about to delete a file ?</h4>
              <p class="text-muted fs-14 mb-4 pt-1">Deleting your file will remove all of your information from our database.</p>
              <div class="hstack gap-2 justify-content-center remove">
                <!-- <button class="btn btn-light" data-bs-dismiss="modal" data-bs-toggle="modal" data-bs-target="#incident-modal">Cancel</button> -->
                <button class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
                <button class="btn btn-soft-danger" @click="delConfirm">Yes, Delete It</button>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>






  </div>
</template>

<script>
import axios from 'axios';
import { AgGridVue } from 'ag-grid-vue3';
import 'ag-grid-community/styles/ag-grid.css';
import 'ag-grid-community/styles/ag-theme-material.css';
import 'ag-grid-enterprise';
import { useAuthStore } from '../stores/auth.js';
import { useStore } from '../stores/store.js';
import { useToastr } from '../toastr.js';
const toastr = useToastr();

export default {
  name: 'XpplAppSaleFilemanager',
  components: { AgGridVue },
  setup() {
    return {
      store: useStore(),
      authStore: useAuthStore(),
    };
  },

  data() {
    return {

      categories: [],
      files: [],
      fileFilter: [],
      cateForm: { cate_id: '', file_category: '', descr: '' },
      fileForm: { file_id: '', file_category: '', file_name: '', file_descr: '', new_name: '', file_type: '', size: '', note: '', file: '' },

      search: '',
      searchFile: '',
      actMode: '',
      loading: false

    };
  },

  mounted() {

  },

  computed: {
    categoryList() {
      if (this.search.trim().length > 0) {
        return this.categories.filter(e =>
          e.file_category.substring(0, this.search.trim().length).toLowerCase() == this.search.trim().toLowerCase()
        );
      };
      return this.categories;
    },

    fileFilterList() {
      if (this.searchFile.trim().length > 0) {
        return this.fileFilter.filter(e =>
          e.file_name.substring(0, this.searchFile.trim().length).toLowerCase() == this.searchFile.trim().toLowerCase() ||
          e.file_descr.substring(0, this.searchFile.trim().length).toLowerCase() == this.searchFile.trim().toLowerCase() ||
          e.file_type.substring(0, this.searchFile.trim().length).toLowerCase() == this.searchFile.trim().toLowerCase()
        );
      };
      return this.fileFilter;
    },

    cateFormDis() {
      return (this.cateForm.file_category && this.cateForm.descr) ? '' : 'disabled';
    },

    fileFormDis() {
      return (this.fileForm.file_name && this.fileForm.file_descr && this.fileForm.file) ? '' : 'disabled';
    },

    fileFormDis2() {
      return (this.fileForm.file_name && this.fileForm.file_descr) ? '' : 'disabled';
    }
  },

  methods: {
    async onLoad() {
      this.loading = true;

      const submenu = 'M07S05';
      const authResponse = await axios.get(`api/auth/auth-action?submenu=${submenu}`, { headers: { Authorization: 'Bearer ' + this.authStore.getToken }, });
      this.auth = authResponse.data[0];

      await this.getCategory();
      await this.getFiles();

      this.fileFilter = this.files;
      this.loading = false;
    },

    async getCategory() {
      const { data } = await axios.get('api/sales/file-category', { headers: { Authorization: 'Bearer ' + this.authStore.getToken } });
      this.categories = data;
    },

    async getFiles() {
      const { data } = await axios.get('api/sales/files', { headers: { Authorization: 'Bearer ' + this.authStore.getToken } });
      this.files = data;
    },


    cateSelected(cate, inx) {
      this.fileForm.file_category = cate;
      this.fileForm.file_id = '';

      document.getElementById('code-detail').classList.add('user-chat-show');
      const elements = document.querySelectorAll('[id^="category-"]');
      elements.forEach(e => e.classList.remove('active'));
      document.getElementById(`category-${inx}`).classList.add('active');
      this.fileFilter = this.files.filter(e => e.file_category === cate);
    },

    newCategory() {
      if (this.auth.new === 0) return toastr.warning("You're not authorized to add!");
      this.actMode = 'add';
      this.cateForm = { file_category: '', descr: '' };
      $('#cate-modal').modal('show');
    },

    async addCategory() {
      const response = await axios.post('api/sales/add-filecategory', this.cateForm, { headers: { Authorization: 'Bearer ' + this.authStore.getToken } });
      if (response.data.success) {
        const code = await this.getCategory();
        this.rowSelect = '';
        toastr.success('Add successfully.');
        $('#cate-modal').modal('hide');
      } else {
        toastr.error(`${response.data.message}`);
      };
    },

    editCategory() {
      if (!this.fileForm.file_category) return toastr.info("Select a category to edit.");
      this.actMode = 'edit';
      let item = this.categories.find(e => e.file_category == this.fileForm.file_category);
      Object.assign(this.cateForm, { cate_id: item.cate_id, file_category: item.file_category, descr: item.descr });
      $('#cate-modal').modal('show');
    },

    async updCategory() {
      try {
        await axios.post('api/sales/upd-filecategory', this.cateForm, { headers: { Authorization: 'Bearer ' + this.authStore.getToken } });
        await Promise.all([this.getCategory(), this.getFiles()]);
        toastr.success('Update successfully.');
        $('#cate-modal').modal('hide');
      } catch (error) {
        toastr.error('This file category already exists in the database.');
      }
    },

    delCategory() {
      if (!this.fileForm.file_category) {
        toastr.info("Select a category to delete.");
      } else {
        let item = this.categories.find(e => e.file_category == this.fileForm.file_category);
        Object.assign(this.cateForm, { cate_id: item.cate_id, file_category: item.file_category });
        $('#cate-delete-modal').modal('show');
      };
    },

    async delCateConfirm() {
      const response = await axios.post('api/sales/del-filecategory', this.cateForm, { headers: { Authorization: 'Bearer ' + this.authStore.getToken } });
      if (response.data.success) {
        const cate = await this.getCategory();
        this.fileForm.file_category = '';
        toastr.success('Delete successfully.');
        $('#cate-delete-modal').modal('hide');
      } else {
        toastr.error(`${response.data.message}`);
      };
    },

    newFile() {
      if (this.auth.new === 0) return toastr.warning("You're not authorized to add.");
      if (!this.fileForm.file_category) return toastr.info("Select a file category first.");
      this.actMode = 'add';
      Object.assign(this.fileForm, { file_name: '', file_descr: '', file: '', file_type: '', size: '' });
      $('#file-modal').modal('show');
    },

    selectFile() {
      let file = this.$refs.fileInput.files;
      this.fileForm.file = file[0];
      this.fileForm.file_type = this.store.fileType(file[0].name);
      this.fileForm.size = (file[0].size / 1024).toFixed(0) + ' KB';
      this.fileForm.note = 'new';
    },

    async addFile() {
      const fd = new FormData();
      Object.keys(this.fileForm).forEach(key => fd.append(key, this.fileForm[key]));

      const { data } = await axios.post('api/sales/add-file', fd, { headers: { 'Content-Type': 'multipart/form-data', Authorization: 'Bearer ' + this.authStore.getToken } });
      if (data.success) {
        await this.getFiles();
        this.fileFilter = this.files.filter(e => e.file_category == this.fileForm.file_category);

        $('#file-modal').modal('hide');
        toastr.success('Add successfully!');
      } else {
        toastr.error(`${data.message}`);
      };
    },

    editFile(id) {
      this.actMode = 'edit';
      let item = this.files.find(e => e.file_id == id);
      this.fileForm.file_id = item.file_id;
      this.fileForm.file_name = item.file_name;
      this.fileForm.file_descr = item.file_descr;
      $('#file-modal').modal('show');
    },

    async updFile() {
      try {
        await axios.post('api/sales/upd-file', this.fileForm, { headers: { Authorization: 'Bearer ' + this.authStore.getToken } });
        await this.getFiles();
        this.fileFilter = this.files.filter(e => e.file_category == this.fileForm.file_category);
        toastr.success('Update successfully.');
        $('#file-modal').modal('hide');
      } catch (error) {
        toastr.error('This file name already exists in the database.');
      };
    },

    delFile(id, file) {
      if (this.auth.del == 0) {
        toastr.warning("You're not authorized to delete!");
      } else {
        this.fileForm.file_id = id;
        this.fileForm.new_name = file;
        $('#delete-modal').modal('show');
      };
    },

    async delConfirm() {
      try {
        const response = await axios.post('api/sales/del-file', this.fileForm, { headers: { Authorization: 'Bearer ' + this.authStore.getToken } });
        const file = await this.getFiles();
        let item = this.files.filter(e => e.file_category == this.fileForm.file_category);
        this.fileFilter = item;
        this.fileForm.file_id = '';
        toastr.success('Delete Successfully.');
        $('#delete-modal').modal('hide');
      } catch (error) {
        toastr.error(`${error}`);
      };
    },

    downloadFile(file) {
      const url = `/api/downloads/sale-file/${file}`;
      window.location.href = url;
    },

    viewFile(file) {
      window.open(window.location.origin + '/assets/images/sale-filemanager/' + file, '_blank')
    },

    notView() {
      toastr.info("File isn't viewable; please download instead.");
    },

    async onSearch() {
      if (this.search.length > 0) {
        document.getElementById('search-close').classList.remove('d-none');
      } else {
        document.getElementById('search-close').classList.add('d-none');
      };
    },

    async searchClear() {
      this.search = '';
      document.getElementById('search-close').classList.add('d-none');
    },

    async onSearchFile() {
      if (this.searchFile.length > 0) {
        document.getElementById('search-file-x').classList.remove('d-none');
      } else {
        document.getElementById('search-file-x').classList.add('d-none');
      };
    },

    async searchFileClear() {
      this.searchFile = '';
      document.getElementById('search-file-x').classList.add('d-none');
    },

    backToMain() {
      document.getElementById('code-detail').classList.remove('user-chat-show');
    },

  },

  created() {
    this.onLoad();
  }
};
</script>
