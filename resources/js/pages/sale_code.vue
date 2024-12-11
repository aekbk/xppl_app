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
                        <li v-for="(item, index) in category" :key="index" @click="cateSelected(item, index)" :id="'category-' + index">
                          <a href="javascript: void(0)" class="py-2">
                            <div class="d-flex align-items-center">
                              <!-- <div class="flex-shrink-0 chat-user-img align-self-center me-2 ms-0">
                                <div class="avatar-xxs">
                                  <div class="avatar-title bg-light rounded-circle text-body">#</div>
                                </div>
                              </div> -->
                              <div class="flex-grow-1 overflow-hidden">
                                <p class="text-truncate mb-0 fs-13">{{ item }}</p>
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
                          <div v-if="viewMode == 'general'" class="d-flex gap-sm-1 email-topbar-link">
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
                          <div v-if="viewMode == 'grade'" class="d-flex gap-sm-1 email-topbar-link">
                            <button type="button" class="btn btn-ghost-secondary btn-icon btn-sm material-shadow-none" title="Add new grade" @click="newGrade">
                              <i class="bx bx-plus-circle align-bottom fs-18"></i>
                            </button>
                            <button type="button" class="btn btn-ghost-secondary btn-icon btn-sm material-shadow-none" title="Edit grade" @click="editGrade">
                              <i class="bx bx-edit align-bottom fs-18"></i>
                            </button>
                            <button type="button" class="btn btn-ghost-secondary btn-icon btn-sm material-shadow-none" title="Delete grade" @click="delGrade">
                              <i class="bx bx-trash align-bottom fs-18"></i>
                            </button>
                          </div>
                        </li>
                      </ul>
                    </div>
                  </div>

                </div>

                <!-- <div class="chat-conversation p-3 p-lg-3"> -->
                <div class="chat-conversation">
                  <div v-if="viewMode == 'general'">
                    <ag-grid-vue style="height: calc(100vh - 13.125rem);" class="ag-theme-material" :columnDefs="columnDefs" :rowData="filtered" :defaultColDef="defaultColDef" :rowHeight="36" :headerHeight="44" :suppressMenuHide="false" :suppressCellFocus="true" animateRows="false" rowSelection="single" @rowClicked="cellCicked" @cell-double-clicked="editCode"></ag-grid-vue>
                  </div>
                  <div v-if="viewMode == 'grade'">
                    <ag-grid-vue style="height: calc(100vh - 13.125rem);" class="ag-theme-material" :columnDefs="columnDefs2" :rowData="grade" :defaultColDef="defaultColDef" :rowHeight="36" :headerHeight="44" :suppressMenuHide="false" :suppressCellFocus="true" animateRows="false" rowSelection="single" @rowClicked="cellCicked2" @cell-double-clicked="editGrade"></ag-grid-vue>
                  </div>

                </div>
              </div>

            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Form Modal -->
    <div class="modal fade zoomIn" id="code-modal" data-bs-keyboard="false" tabindex="-1" aria-modal="true" role="dialog" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered modal-sm" role="document">
        <div class="modal-content">
          <div class="modal-header bg-light p-3">
            <h5 v-if="mode == 'add'" class="modal-title">Add {{ codeForm.category }}</h5>
            <h5 v-if="mode == 'edit'" class="modal-title">Edit {{ codeForm.category }}</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" id="close-modal"></button>
          </div>
          <div class="modal-body">
            <div v-if="mode == 'add'" class="mb-3">
              <label class="form-label">Code</label>
              <input type="text" class="form-control" placeholder="Enter name" v-model="codeForm.code">
            </div>
            <div v-else class="mb-3">
              <label class="form-label">Code</label>
              <input type="text" class="form-control" placeholder="Enter name" v-model="codeForm.code" readonly>
            </div>
            <div class="mb-3">
              <label class="form-label">Description</label>
              <textarea type="text" class="form-control" placeholder="Enter description" v-model="codeForm.descr"></textarea>
            </div>
            <div>
              <label class="form-label">Active</label>
              <multiselect placeholder="Enter phone no." v-model="codeForm.active" :options="lkActive" />
            </div>
          </div>
          <div class="modal-footer" style="display: block;">
            <div class="hstack gap-2 justify-content-end">
              <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
              <button v-if="mode == 'add'" type="button" class="btn btn-success" :class="addLKCodeDis" @click="addCode">Add Code</button>
              <button v-if="mode == 'edit'" type="button" class="btn btn-success" :class="addLKCodeDis" @click="updCode">Save Change</button>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Grade Modal -->
    <div class="modal fade zoomIn" id="grade-modal" data-bs-keyboard="false" tabindex="-1" aria-modal="true" role="dialog" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered modal-md" role="document">
        <div class="modal-content">
          <div class="modal-header bg-light p-3">
            <h5 v-if="mode == 'add'" class="modal-title">Add {{ codeForm.category }}</h5>
            <h5 v-if="mode == 'edit'" class="modal-title">Edit {{ codeForm.category }}</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" id="close-modal"></button>
          </div>
          <div class="modal-body">
            <div class="mb-3">
              <label class="form-label">Grade Type <span class="text-danger">*</span></label>
              <multiselect placeholder="Select type" v-model="gradeForm.grade_type" :options="lkType" />
            </div>
            <div class="mb-3">
              <label class="form-label">Coal Grade <span class="text-danger">*</span></label>
              <input type="number" class="form-control" placeholder="Enter coal grade" v-model="gradeForm.grade">
            </div>
            <div class="mb-3">
              <label class="form-label">Grade GAR</label>
              <input type="text" class="form-control" placeholder="Auto calc to GAR" v-model="gradeForm.grade_gar" readonly>
            </div>
            <div class="mb-3">
              <label class="form-label">Description</label>
              <textarea type="text" class="form-control" placeholder="Enter description" v-model="gradeForm.descr"></textarea>
            </div>
            <div>
              <label class="form-label">Active <span class="text-danger">*</span></label>
              <multiselect placeholder="Select active" v-model="gradeForm.active" :options="lkActive" />
            </div>
            {{ calcGAR }}
          </div>
          <div class="modal-footer" style="display: block;">
            <div class="hstack gap-2 justify-content-end">
              <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
              <button v-if="mode == 'add'" type="button" class="btn btn-success" :class="addLKGradeDis" @click="addGrade()">Add Code</button>
              <button v-else type="button" class="btn btn-success" :class="addLKGradeDis" @click="updGrade()">Save Change</button>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Delete Modal -->
    <div class="modal fade" id="delete-modal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-modal="true" role="dialog" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
          <div class="modal-body text-center p-5">
            <lord-icon src="https://cdn.lordicon.com/gsqxdxog.json" trigger="loop" colors="primary:#405189,secondary:#f06548" style="width:90px;height:90px"></lord-icon>
            <div class="text-center">
              <h4 class="fs-semibold">You are about to delete a code ?</h4>
              <p class="text-muted fs-14 mb-4 pt-1">Deleting your code will remove all of your information from our database.</p>
              <div class="hstack gap-2 justify-content-center remove">
                <button class="btn btn-light link-success fw-medium" data-bs-dismiss="modal">Cancel</button>
                <button class="btn btn-danger" @click="delConfirm">Yes, Delete It</button>
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
  name: 'XpplAppSaleCode',
  components: { AgGridVue },
  setup() {
    const authStore = useAuthStore();
    return { authStore };
  },

  data() {
    return {
      columnDefs: [
        { headerName: '#', maxWidth: 50, sortable: false, resizable: false, suppressMovable: true, suppressMenu: true, valueGetter: (params) => { return params.node.rowIndex + 1 } },
        { headerName: 'Category', field: 'category', hide: true },
        { headerName: 'Code', field: 'code', filter: 'agSetColumnFilter' },
        { headerName: 'Description', field: 'descr', filter: 'agSetColumnFilter' },
        {
          headerName: 'Active', field: 'active', maxWidth: 200, filter: 'agSetColumnFilter',
          cellRenderer: (p) => {
            if (p.value == false) {
              return 'No';
            } else {
              return 'Yes';
            }
          }
        },
        { headerName: 'Created at', field: 'created_at', maxWidth: 200, valueFormatter: p => p.value ? moment(p.value).format('DD-MM-YYYY HH:mm:ss') : '' },
        { headerName: 'Created by', field: 'created_by', maxWidth: 200, filter: 'agSetColumnFilter' },
        { headerName: 'Updated at', field: 'updated_at', maxWidth: 200, valueFormatter: p => p.value ? moment(p.value).format('DD-MM-YYYY HH:mm:ss') : '' },
        { headerName: 'Updated by', field: 'updated_by', maxWidth: 200, filter: 'agSetColumnFilter' },
      ],

      columnDefs2: [
        { headerName: '#', maxWidth: 50, sortable: false, resizable: false, suppressMovable: true, suppressMenu: true, valueGetter: (params) => { return params.node.rowIndex + 1 } },
        { headerName: 'Grade ID', field: 'grade_id', minWidth: 80, maxWidth: 100, hide: true },
        { headerName: 'Grade', field: 'grade', hide: true, filter: 'agSetColumnFilter' },
        { headerName: 'Grade Name', field: 'grade_name', filter: 'agSetColumnFilter' },
        { headerName: 'Grade GAR', field: 'grade_gar', filter: 'agSetColumnFilter' },
        { headerName: 'Description', field: 'descr', filter: 'agSetColumnFilter' },
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
        { headerName: 'Created at', field: 'created_at', maxWidth: 150, valueFormatter: p => p.value ? moment(p.value).format('DD-MM-YYYY HH:mm:ss') : '' },
        { headerName: 'Created by', field: 'created_by', maxWidth: 150, filter: 'agSetColumnFilter' },
        { headerName: 'Updated at', field: 'updated_at', maxWidth: 150, valueFormatter: p => p.value ? moment(p.value).format('DD-MM-YYYY HH:mm:ss') : '' },
        { headerName: 'Updated by', field: 'updated_by', maxWidth: 150, filter: 'agSetColumnFilter' },
      ],

      defaultColDef: {
        sortable: true,
        resizable: true,
        flex: 1,
        filterParams: { buttons: ['reset'] },
        minWidth: 100,
        cellClassRules: { 'pointer': 'true' },
        // menuTabs: ['filterMenuTab', 'generalMenuTab', 'columnsMenuTab']
      },

      category: ['Country', 'Currency', 'Destination', 'Price Term', 'Status', 'VAT Remark', 'Coal Grade'],
      lkActive: [
        { value: 1, label: 'Yes' },
        { value: 0, label: 'No' }
      ],

      lkType: [
        { value: 'DB', label: 'DB' },
        { value: 'GAR', label: 'GAR' },
        { value: 'NAR', label: 'NAR' }
      ],

      code: [],
      filtered: [],
      grade: [],
      auth: [],


      codeForm: { code_id: '', category: '', code: '', descr: '', active: null },
      gradeForm: { row_index: '', grade_id: '', grade: '', grade_type: null, grade_name: '', grade_gar: '', descr: '', active: 1 },

      mode: '',
      viewMode: 'general',

    };
  },

  mounted() {

  },

  computed: {
    addLKCodeDis() {
      if (this.codeForm.category == '' || this.codeForm.code == '' || this.codeForm.descr == '' || this.codeForm.active == null) {
        return 'disabled';
      } else {
        return '';
      }
    },


    addLKGradeDis() {
      return (this.gradeForm.grade && this.gradeForm.grade_type && this.gradeForm.grade_gar && this.gradeForm.active) ? '' : 'disabled';
    },

    calcGAR() {
      let f = this.gradeForm;
      if (f.grade && f.grade_type) {
        if (f.grade_type == 'NAR') {
          f.grade_gar = Number(f.grade) + 200 + ' GAR';
          f.grade_name = Number(f.grade) + ' NAR';
        } else if (f.grade_type == 'DB') {
          f.grade_gar = Number(f.grade) - 300 + ' GAR';
          f.grade_name = Number(f.grade) + ' DB';
        } else if (f.grade_type == 'GAR') {
          f.grade_gar = Number(f.grade) + ' GAR'
          f.grade_name = Number(f.grade) + ' GAR';
        }
      } else {
        f.grade_gar = '';
      }
    },
  },

  methods: {
    async onLoad() {
      const data = await this.getCode();
      this.cateSelected('Country', 0)

      const sub = 'M07S04';
      const authorise = await axios.get(`api/auth/auth-action?submenu=${sub}`, { headers: { Authorization: 'Bearer ' + this.authStore.getToken } });
      this.auth = authorise.data[0];

      this.getGrade();
    },

    async getCode() {
      try {
        const lkcode = await axios.get('api/sales/codes', { headers: { Authorization: 'Bearer ' + this.authStore.getToken } });
        this.code = lkcode.data;
      } catch (error) {
        if (error.response.status == 401) {
          this.authStore.removeToken();
          this.authStore.removeUser();
          localStorage.removeItem('token');
          localStorage.removeItem('user');
          this.$router.push('/login');
        }
      }
    },

    async getGrade() {
      const lkgrade = await axios.get('api/sales/grades', { headers: { Authorization: 'Bearer ' + this.authStore.getToken } });
      this.grade = lkgrade.data;
    },

    async cateSelected(cate, inx) {
      this.codeForm.code_id = '';
      this.gradeForm.grade_id = '';
      this.codeForm.category = cate;

      document.getElementById('code-detail').classList.add('user-chat-show');
      const elements = document.querySelectorAll('[id^="category-"]');
      elements.forEach((e) => e.classList.remove('active'));

      let indx = 'category-' + inx;
      document.getElementById(indx).classList.add('active')
      document.getElementById('code-title').textContent = cate;

      if (cate == 'Coal Grade') {
        this.viewMode = 'grade'
      } else {
        this.viewMode = 'general'
        let items = this.code.filter((e) => e.category == cate);
        this.filtered = items;
      }
    },

    newCode() {
      if (this.auth.new == 0) {
        toastr.warning("You're not authorized to add!");
      } else {
        this.mode = 'add';
        this.codeForm.code_id = '';
        this.codeForm.code = '';
        this.codeForm.descr = '';
        this.codeForm.active = 1;
        $('#code-modal').modal('show');
      }
    },

    async addCode() {
      const response = await axios.post('api/sales/add-code', this.codeForm, { headers: { Authorization: 'Bearer ' + this.authStore.getToken } });
      if (response.data.success) {
        $('#code-modal').modal('hide');
        toastr.success('Successfully!');
        const getData = await this.getCode();
        let items = this.code.filter((i) => i.category == this.codeForm.category);
        this.filtered = items;
        this.codeForm.code_id = '';
      } else {
        toastr.error(`${response.data.message}`);
      }
    },

    cellCicked(e) {
      let f = this.codeForm;
      f.code_id = e.data.code_id;
      f.category = e.data.category;
      f.code = e.data.code;
      f.descr = e.data.descr;
      f.active = e.data.active;
    },

    editCode() {
      if (this.auth.edit == 0) {
        toastr.warning("You're not authorized to edit!");
      } else if (!this.codeForm.code_id) {
        toastr.info("Select a row to edit.");
      } else {
        this.mode = 'edit';
        $('#code-modal').modal('show');
      }
    },

    async updCode() {
      const send = await axios.post('api/sales/upd-code', this.codeForm, { headers: { Authorization: 'Bearer ' + this.authStore.getToken } });
      $('#code-modal').modal('hide');
      toastr.success('Successfully!');
      const getData = await this.getCode();
      let items = this.code.filter((i) => i.category == this.codeForm.category);
      this.filtered = items;
      this.codeForm.code_id = '';
    },

    // delCode() {
    //   if (this.auth.del == 0) {
    //     toastr.warning("You're not authorized to delete!");
    //   } else if (!this.codeForm.code_id) {
    //     toastr.info("Select a row to delete.");
    //   } else {
    //     $('#delete-modal').modal('show');
    //   }
    // },

    // async delConfirm() {
    //   const response = await axios.post('api/sales/del-code', {
    //     id: this.codeForm.code_id,
    //     code: this.codeForm.code
    //   }, { headers: { Authorization: 'Bearer ' + this.authStore.getToken } });
    //   if (response.data.success) {

    //     $('#delete-modal').modal('hide');
    //     const code = await this.getCode();
    //     let item = this.code.filter((e) => e.category == this.codeForm.category);
    //     this.filtered = item;
    //     this.codeForm.code_id = '';
    //     toastr.success('Delete Successfully.');

    //   } else {
    //     toastr.error(`${response.data.message}`);
    //   }
    // },

    delCode() {
      if (this.auth.del == 0) {
        toastr.warning("You're not authorized to delete!");
      } else if (!this.codeForm.code_id) {
        toastr.info("Select a row to delete.");
      } else {
        this.$swal.fire({
          text: 'Do you want to delete this record?',
          icon: 'question',
          showCancelButton: true,
          confirmButtonText: '<i class="fe fe-trash-2"></i> <span class="fs-14 fw-light">Delete</span>',
          cancelButtonText: '<i class="fe fe-x"></i> <span class="fs-14 fw-light">Cancel</span>',
          confirmButtonColor: '#d33',
          allowEnterKey: false,
          allowOutsideClick: false,
        }).then((result) => {
          if (result.isConfirmed) {
            axios.post('api/sales/del-code', {
              id: this.codeForm.code_id,
              code: this.codeForm.code
            }, { headers: { Authorization: 'Bearer ' + this.authStore.getToken } }).then((response) => {
              // if (response.data.success) {
              toastr.success('Successfully!');
              this.filtered.splice(this.codeForm.row_index, 1);
              this.getCode();
              this.codeForm.code_id = '';

              // } else {
              //   toastr.error(`${response.data.message}`);
              // }
            }).catch((error) => {
              console.log(error);
            })
          }
        });
      }
    },

    newGrade() {
      if (this.auth.new == 0) {
        toastr.warning("You're not authorized to add!");
      } else {
        this.mode = 'add';
        this.gradeForm.grade_id = '';
        this.gradeForm.grade = '';
        this.gradeForm.grade_type = null;
        this.gradeForm.descr = '';
        this.gradeForm.active = 1;
        $('#grade-modal').modal('show');
      }
    },

    async addGrade() {
      const response = await axios.post('api/sales/add-grade', this.gradeForm, { headers: { Authorization: 'Bearer ' + this.authStore.getToken } });
      if (response.data.success) {
        $('#grade-modal').modal('hide');
        toastr.success('Successfully!');
        const getData = await this.getGrade();
      } else {
        toastr.error(`${response.data.message}`);
      }
    },

    cellCicked2(e) {
      let f = this.gradeForm;
      f.row_index = e.rowIndex;
      f.grade_id = e.data.grade_id;
      f.grade = e.data.grade;
      f.grade_name = e.data.grade_name;
      f.grade_gar = e.data.grade_gar;
      f.grade_type = e.data.grade_type;
      f.descr = e.data.descr;
      f.active = e.data.active;
    },

    editGrade() {
      if (this.auth.edit == 0) {
        toastr.warning("You're not authorized to edit!");
      } else if (!this.gradeForm.grade_id) {
        toastr.info("Select a row to edit.");
      } else {
        this.mode = 'edit';
        $('#grade-modal').modal('show');
      }
    },

    async updGrade() {
      const response = await axios.post('api/sales/upd-grade', this.gradeForm, { headers: { Authorization: 'Bearer ' + this.authStore.getToken } });
      // if (response.data.success) {
      $("#grade-modal").modal("hide");
      toastr.success('Successfully!');
      this.getGrade();
      // } else {
      //   toastr.error(`${response.data.message}`);
      // }
    },

    delGrade() {
      if (this.auth.del == 0) {
        toastr.warning("You're not authorized to delete!");
      } else if (!this.gradeForm.grade_id) {
        toastr.info("Select a row to delete.");
      } else {
        this.$swal.fire({
          text: 'Do you want to delete this record?',
          icon: 'question',
          showCancelButton: true,
          confirmButtonText: '<i class="fe fe-trash-2"></i> <span class="fs-14 fw-light">Delete</span>',
          cancelButtonText: '<i class="fe fe-x"></i> <span class="fs-14 fw-light">Cancel</span>',
          confirmButtonColor: '#d33',
          allowEnterKey: false,
          allowOutsideClick: false,
        }).then((result) => {
          if (result.isConfirmed) {
            axios.post('api/sales/del-grade', {
              gradeName: this.gradeForm.grade_name
            }, { headers: { Authorization: 'Bearer ' + this.authStore.getToken } }).then((response) => {
              // if (response.data.success) {
              toastr.success('Successfully!');
              this.grade.splice(this.gradeForm.row_index, 1);
              this.getGrade();

              // } else {
              //   toastr.error(`${response.data.message}`);
              // }
            }).catch((error) => {
              console.log(error);
            })
          }
        });
      }
    },
  },

  created() {
    this.onLoad();
  }
};
</script>