<template>
  <div>
    <div class="chat-wrapper d-lg-flex gap-1 mx-n4 mt-n4 p-1">
      <div class="chat-leftsidebar minimal-border">
        <div class="px-4 py-3 mb-0 border-bottom">
          <div class="d-flex align-items-center">
            <div class="flex-grow-1 overflow-hidden">
              <h5 class="mb-0 text-truncate">Categories</h5>
            </div>
            <div style="height: 27.063px;">
              <!-- <div class="flex-shrink-0">
                <button type="button" class="btn btn-soft-info btn-icon btn-sm material-shadow-none">
                  <i class="ri-add-line align-bottom"></i>
                </button>
              </div> -->
            </div>
          </div>
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
                        <li v-for="(item, index) in categories" :key="index" @click="cateSelected(item.category, index)" :id="'category-' + index">
                          <a href="javascript: void(0)" class="py-2">
                            <div class="d-flex align-items-center">
                              <!-- <div class="flex-shrink-0 chat-user-img align-self-center me-2 ms-0">
                                <div class="avatar-xxs">
                                  <div class="avatar-title bg-light rounded-circle text-body">#</div>
                                </div>
                              </div> -->
                              <div class="flex-grow-1 overflow-hidden">
                                <p class="text-truncate mb-0 fs-13">{{ item.category }}</p>
                              </div>
                              <!-- <div>
                                <div class="flex-shrink-0 ms-2"><span class="badge bg-dark-subtle text-body rounded p-1">2</span></div>
                              </div> -->
                            </div>
                          </a>
                        </li>
                      </ul>
                    </div>

                  </div>
                </div>
              </div>
            </div>
            <div class="simplebar-placeholder" style="width: 300px; height: calc(100vh - 13.125rem);"></div>
          </div>
        </div>
      </div>

      <div class="user-chat w-100 overflow-hidden minimal-border user-chat-show" id="code-detail">
        <!-- <div class="user-chat w-100 overflow-hidden minimal-border"> -->
        <div class="chat-content d-lg-flex">
          <div class="w-100 overflow-hidden position-relative">
            <div class="position-relative">

              <div class="position-relative" id="channel-chat" style="display: block;">
                <div class="p-3 user-chat-topbar border-bottom">
                  <div class="row align-items-center">
                    <div class="col-sm-4 col-8">
                      <div class="d-flex align-items-center">
                        <div class="flex-shrink-0 d-block d-lg-none me-3" @click="backToMain">
                          <a href="javascript: void(0);" class="user-chat-remove fs-18 p-1"><i class="ri-arrow-left-s-line align-bottom"></i></a>
                        </div>
                        <div class="flex-grow-1 overflow-hidden">
                          <div class="d-flex align-items-center">
                            <!-- <div class="flex-shrink-0 chat-user-img online user-own-img align-self-center me-3 ms-0">
                              <img src="/public/assets/images/users/multi-user.jpg" class="rounded-circle avatar-xs" alt="">
                            </div> -->
                            <div class="flex-grow-1 overflow-hidden">
                              <h5 class="text-truncate mb-0 fs-16" id="code-title">
                                <!-- <a class="text-reset username" data-bs-toggle="offcanvas" href="#userProfileCanvasExample" aria-controls="userProfileCanvasExample">Project Tasks</a> -->
                              </h5>
                              <!-- <p class="text-truncate text-muted fs-14 mb-0 userStatus"><small>24 Members</small></p> -->
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>

                    <div class="col-sm-8 col-4">
                      <ul class="list-inline user-chat-nav text-end mb-0">
                        <li class="list-inline-item m-0">
                          <div class="d-flex gap-sm-1 email-topbar-link">
                            <button type="button" class="btn btn-ghost-secondary btn-icon btn-sm material-shadow-none" title="Add new code" @click="newCode">
                              <i class="bx bx-plus-circle align-bottom fs-18"></i>
                            </button>
                            <button type="button" class="btn btn-ghost-secondary btn-icon btn-sm material-shadow-none" title="Edit code" @click="editCode">
                              <i class="bx bx-edit align-bottom fs-18"></i>
                            </button>
                            <button type="button" class="btn btn-ghost-secondary btn-icon btn-sm material-shadow-none" title="Delete code" @click="delCode">
                              <i class="bx bx-trash align-bottom fs-18"></i>
                            </button>
                          </div>
                        </li>
                      </ul>
                    </div>
                  </div>

                </div>

                <!-- <div class="chat-conversation p-3 p-lg-3"> -->
                <div class="chat-conversation d-block">
                  <ag-grid-vue style="height: calc(100vh - 13.125rem);" class="ag-theme-material" :columnDefs="columnDefs" :rowData="codeFilter" :defaultColDef="defaultColDef" :rowHeight="36" :headerHeight="44" :suppressMenuHide="false" :suppressCellFocus="true" animateRows="false" rowSelection="single" @rowClicked="cellCicked" @cell-double-clicked="editCode"></ag-grid-vue>
                </div>
              </div>

            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Code Modal -->
    <div class="modal fade zoomIn" id="code-modal" data-bs-keyboard="false" tabindex="-1" aria-modal="true" role="dialog" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
          <div class="modal-header bg-light p-3">
            <h5 v-if="actMode == 'add'" class="modal-title">Add {{ codeForm.category }}</h5>
            <h5 v-if="actMode == 'edit'" class="modal-title">Edit {{ codeForm.category }}</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" id="close-modal"></button>
          </div>
          <div class="modal-body">
            <div class="mb-3">
              <label class="form-label">Code <span class="text-danger">*</span></label>
              <input type="text" class="form-control" placeholder="Enter name" v-model="codeForm.code">
            </div>
            <div class="mb-3">
              <label class="form-label">Description Eng <span class="text-danger">*</span></label>
              <textarea type="text" class="form-control" placeholder="Enter description" v-model="codeForm.descr_eng"></textarea>
            </div>
            <div class="mb-3">
              <label class="form-label">Description Lao <span class="text-danger">*</span></label>
              <textarea type="text" class="form-control" placeholder="Enter description" v-model="codeForm.descr_lao"></textarea>
            </div>
            <div>
              <label class="form-label">Active <span class="text-danger">*</span></label>
              <multiselect placeholder="Select" v-model="codeForm.active" :options="lkActive" />
            </div>
          </div>
          <div class="modal-footer" style="display: block;">
            <div class="hstack gap-2 justify-content-end">
              <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
              <button v-if="actMode == 'add'" type="button" class="btn btn-success" :class="codeFormDis" @click="addCode">Add Code</button>
              <button v-if="actMode == 'edit'" type="button" class="btn btn-success" :class="codeFormDis" @click="updCode">Save Change</button>
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
              <h4 class="fs-semibold">You are about to delete a code ?</h4>
              <p class="text-muted fs-14 mb-4 pt-1">Deleting your code will remove all of your information from our database.</p>
              <div class="hstack gap-2 justify-content-center remove">
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
import { useToastr } from '../toastr.js';
const toastr = useToastr();

export default {
  name: 'XpplAppSafetyCode',
  components: { AgGridVue },
  setup() {
    const authStore = useAuthStore();
    return { authStore };
  },

  data() {
    return {
      columnDefs: [
        { headerName: '#', maxWidth: 50, sortable: false, resizable: false, suppressMovable: true, suppressMenu: true, valueGetter: (params) => { return params.node.rowIndex + 1 } },
        { headerName: 'Code ID', field: 'code_id', minWidth: 80, maxWidth: 100, hide: true },
        { headerName: 'Category', field: 'category', hide: true },
        { headerName: 'Code', field: 'code', filter: 'agSetColumnFilter' },
        { headerName: 'Description', field: 'descr_eng', filter: 'agSetColumnFilter' },
        { headerName: 'ຄຳອະທິບາຍ', field: 'descr_lao', filter: 'agSetColumnFilter' },
        {
          headerName: 'Active', field: 'active', maxWidth: 100, filter: 'agSetColumnFilter',
          cellRenderer: (p) => {
            if (p.value == false) {
              return 'No';
            } else {
              return 'Yes';
            }
          }
        },
        { headerName: 'Created at', field: 'created_at', maxWidth: 145, valueFormatter: p => p.value ? moment(p.value).format('DD-MM-YYYY HH:mm:ss') : '' },
        { headerName: 'Created by', field: 'created_by', maxWidth: 150, filter: 'agSetColumnFilter' },
        { headerName: 'Updated at', field: 'updated_at', maxWidth: 145, hide: true, valueFormatter: p => p.value ? moment(p.value).format('DD-MM-YYYY HH:mm:ss') : '' },
        { headerName: 'Updated by', field: 'updated_by', maxWidth: 150, hide: true, filter: 'agSetColumnFilter' },
      ],

      defaultColDef: {
        sortable: true,
        resizable: true,
        flex: 1,
        filterParams: { buttons: ['reset'] },
        minWidth: 100,
        cellClassRules: { 'pointer': 'true' },
        menuTabs: ['filterMenuTab', 'generalMenuTab', 'columnsMenuTab']
      },

      lkActive: [{ value: 1, label: 'Yes' }, { value: 0, label: 'No' }],
      codeForm: { code_id: '', category: '', code: '', code_ori: '', descr_eng: '', descr_lao: '', active: null, tbl_name: '', col_name: '' },

      auth: [],
      categories: [],
      codes: [],
      codeFilter: [],
      actMode: '',
    };
  },

  mounted() {

  },

  computed: {
    codeFormDis() {
      if (this.codeForm.code == '' || this.codeForm.descr_eng == '' || this.codeForm.descr_lao == '' || this.codeForm.active == null) {
        return 'disabled';
      } else {
        return '';
      }
    },
  },

  methods: {
    async onLoad() {
      const submenu = 'M08S02';
      const authorise = await axios.get(`api/auth/auth-action?submenu=${submenu}`, { headers: { Authorization: 'Bearer ' + this.authStore.getToken } });
      this.auth = authorise.data[0];

      const cate = await axios.get('api/safety/categories', { headers: { Authorization: 'Bearer ' + this.authStore.getToken } });
      this.categories = cate.data;

      const code = await this.getCode();
      const select = await this.cateSelected('Action Status', 0);
    },

    async getCode() {
      const response = await axios.get('api/safety/codes', { headers: { Authorization: 'Bearer ' + this.authStore.getToken } });
      this.codes = response.data;

      // const category = [
      //   { cate: 'Company', lk: 'lkCompany', lb: 'descr_eng' },
      //   { cate: 'Country', lk: 'lkCountry', lb: 'descr_eng' },
      // ];
      // for (let j = 0; j < category.length; j++) {
      //   let cateName = category[j].cate;
      //   let lkName = category[j].lk;
      //   let labelCol = category[j].lb;

      //   let item = this.code.filter((e) => e.category == [cateName] && e.active == 1);
      //   this[lkName] = [];
      //   for (let i = 0; i < item.length; i++) {
      //     this[lkName].push({
      //       value: item[i].code,
      //       label: item[i][labelCol]
      //     });
      //   };
      // };
    },

    async cateSelected(cate, inx) {
      this.codeForm.category = cate;
      this.codeForm.code_id = '';

      document.getElementById('code-detail').classList.add('user-chat-show');
      const elements = document.querySelectorAll('[id^="category-"]');
      elements.forEach(e => e.classList.remove('active'));

      let indx = 'category-' + inx;
      document.getElementById(indx).classList.add('active')
      document.getElementById('code-title').textContent = cate;

      let item = this.codes.filter(e => e.category == cate);
      this.codeFilter = item;

      let c = this.categories.find(e => e.category == cate);
      this.codeForm.tbl_name = c.tbl_name;
      this.codeForm.col_name = c.col_name;
    },

    newCode() {
      if (this.auth.new == 0) {
        toastr.warning("You're not authorized to add!");
      } else {
        this.actMode = 'add';
        this.codeForm.code_id = '';
        this.codeForm.code = '';
        this.codeForm.descr_eng = '';
        this.codeForm.descr_lao = '';
        this.codeForm.active = 1;
        $('#code-modal').modal('show');
      }
    },

    async addCode() {
      const response = await axios.post('api/safety/add-code', this.codeForm, { headers: { Authorization: 'Bearer ' + this.authStore.getToken } });
      if (response.data.success) {
        const code = await this.getCode();
        let item = this.codes.filter(e => e.category == this.codeForm.category);
        this.codeFilter = item;
        this.codeForm.code_id = '';
        toastr.success('Add successfully.');
        $('#code-modal').modal('hide');
      } else {
        toastr.error(`${response.data.message}`);
      };
    },

    cellCicked(e) {
      this.rowSelect = e.rowIndex + 1;
      this.codeForm.code_id = e.data.code_id;
      this.codeForm.category = e.data.category;
      this.codeForm.code = e.data.code;
      this.codeForm.code_ori = e.data.code;
      this.codeForm.descr_eng = e.data.descr_eng;
      this.codeForm.descr_lao = e.data.descr_lao;
      this.codeForm.active = e.data.active;

    },

    editCode() {
      if (this.auth.edit == 0) {
        toastr.warning("You're not authorized to edit!");
      } else if (!this.codeForm.code_id) {
        toastr.info("Select a row to edit.");
      } else {
        this.actMode = 'edit';
        $('#code-modal').modal('show');
      }
    },

    async updCode() {
      try {
        const response = await axios.post('api/safety/upd-code', this.codeForm, { headers: { Authorization: 'Bearer ' + this.authStore.getToken } });
        const code = await this.getCode();
        let item = this.codes.filter(e => e.category == this.codeForm.category);
        this.codeFilter = item;
        this.codeForm.code_id = '';
        toastr.success('Update Successfully.');
        $('#code-modal').modal('hide');
      } catch (error) {
        toastr.error('This code already exists in the database.');
      };
    },

    delCode() {
      if (this.auth.del == 0) {
        toastr.warning("You're not authorized to delete!");
      } else if (!this.codeForm.code_id) {
        toastr.info("Select a row to delete.");
      } else {
        $('#delete-modal').modal('show');
      };
    },

    async delConfirm() {
      const response = await axios.post('api/safety/del-code', this.codeForm, { headers: { Authorization: 'Bearer ' + this.authStore.getToken } });
      if (response.data.success) {
        const code = await this.getCode();
        let item = this.codes.filter(e => e.category == this.codeForm.category);
        this.codeFilter = item;
        this.codeForm.code_id = '';
        toastr.success('Delete Successfully.');
        $('#delete-modal').modal('hide');
      } else {
        toastr.error(`${response.data.message}`);
      };
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