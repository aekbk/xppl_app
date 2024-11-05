<template>
  <div>
    <div class="row g-xl-3 g-lg-3">
      <div class="col-xl-3 col-lg-4">
        <div class="card">
          <div class="card-header align-items-center d-flex">
            <h4 class="card-title mb-0 flex-grow-1">Categories</h4>
            <div style="height: 27.063px;">
              <!-- <button type="button" class="btn btn-soft-secondary btn-sm btn-icon material-shadow-none btn-link" data-bs-toggle="modal" data-bs-target="#menu-modal">
                    <i class="ri-add-line align-bottom"></i>
                  </button> -->
            </div>
          </div>
          <div class="accordion accordion-flush filter-accordion">
            <div class="card-body border-bottom">
              <div>
                <ul class="list-unstyled mb-0 filter-list">
                  <li v-for="(item, index) in lkCategory" :key="index" @click="cateSelected(index, item)">
                    <a href="#" class="d-flex py-1 align-items-center" :id="index">
                      <div class="flex-grow-1">
                        <h5 class="fs-13 mb-2 listname">{{ item }}</h5>
                      </div>
                    </a>
                  </li>
                </ul>
              </div>
            </div>
          </div>
        </div>
      </div>

      <div class="col-xl-9 col-lg-8">
        <div class="card">
          <div class="card-header align-items-center d-flex gap-1">
            <h4 class="card-title mb-0 flex-grow-1">{{ codeForm.category }}</h4>
            <button class="btn btn-sm btn-soft-info d-none" id="btn-new" @click="newCode"><i class="ri-add-fill me-1 align-bottom"></i> Add Code</button>
            <button class="btn btn-sm btn-soft-info btn-icon" id="btn-tool" type="button" data-bs-toggle="dropdown" aria-expanded="false">
              <i class="ri-more-2-fill fs-14"></i>
            </button>
            <ul class="dropdown-menu dropdown-menu-end dropdownmenu-secondary">
              <li><a class="dropdown-item disabled" id="btn-tool-1" href="javascript:void(0);" @click="editCode"><i class="ri-pencil-fill align-bottom me-1 text-muted"></i> Edit</a></li>
              <li><a class="dropdown-item disabled" id="btn-tool-2" href="javascript:void(0);" @click="delCode"><i class="ri-delete-bin-fill align-bottom me-1 text-muted"></i> Delete</a></li>
            </ul>

            <!-- <button class="btn btn-sm btn-soft-info btn-icon"><i class="ri-add-fill me-1 align-bottom"></i></button> -->
          </div>

          <ag-grid-vue style="height: 70vh" class="ag-theme-material" :columnDefs="columnDefs" :rowData="codeFilter" :defaultColDef="defaultColDef" :rowHeight="36" :headerHeight="44" :suppressMenuHide="false" :suppressCellFocus="true" animateRows="false" rowSelection="single" @rowClicked="cellCicked" @cell-double-clicked="editCode"></ag-grid-vue>

          <div class="mt-2"></div>

        </div>

      </div>
    </div>


    <!-- Add modal -->
    <div class="modal fade zoomIn" id="code-modal" data-bs-keyboard="false" tabindex="-1" aria-modal="true" role="dialog" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered modal-md" role="document">
        <div class="modal-content">
          <div class="modal-header bg-light p-3">
            <h5 v-if="mode == 'add'" class="modal-title">Add {{ codeForm.category }}</h5>
            <h5 v-if="mode == 'edit'" class="modal-title">Edit {{ codeForm.category }}</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" id="close-modal"></button>
          </div>
          <div class="modal-body">
            <div class="mb-3">
              <label class="form-label">Code <span class="text-danger">*</span></label>
              <input type="text" class="form-control" placeholder="Enter code" v-model="codeForm.code">
            </div>
            <div class="mb-3">
              <label class="form-label">Description Eng <span class="text-danger">*</span></label>
              <input type="text" class="form-control" placeholder="Enter description english" v-model="codeForm.descr_eng">
            </div>
            <div class="mb-3">
              <label class="form-label">Description Lao</label>
              <input type="text" class="form-control" placeholder="Enter description lao" v-model="codeForm.descr_lao">
            </div>
            <div>
              <label class="form-label">Active <span class="text-danger">*</span></label>
              <multiselect placeholder="Enter phone no." v-model="codeForm.active" :options="lkActive" />
            </div>
          </div>
          <div class="modal-footer" style="display: block;">
            <div class="hstack gap-2 justify-content-end">
              <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
              <button v-if="mode == 'add'" type="button" class="btn btn-success" :class="codeFormDis" @click="addCode">Add Code</button>
              <button v-if="mode == 'edit'" type="button" class="btn btn-success" :class="codeFormDis" @click="updCode">Save Change</button>
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
  name: 'XpplAppClinicCode',
  components: { AgGridVue },
  setup() {
    const authStore = useAuthStore();
    return { authStore };
  },

  data() {
    return {
      columnDefs: [
        { headerName: "ID", field: 'id', hide: true },
        { headerName: 'Code', field: 'code', minWidth: 160, filter: 'agSetColumnFilter' },
        { headerName: 'Description Eng', field: 'descr_eng', minWidth: 200, filter: 'agSetColumnFilter' },
        { headerName: 'Description Lao', field: 'descr_lao', minWidth: 150, filter: 'agSetColumnFilter' },
        {
          headerName: 'Active', field: 'active', minWidth: 150, filter: 'agSetColumnFilter',
          cellRenderer: (p) => {
            if (p.value == false) {
              return 'No';
            } else {
              return 'Yes';
            }
          }
        },
        { headerName: 'Created at', field: 'created_at', valueFormatter: p => p.value ? moment(p.value).format('DD-MM-YYYY HH:mm:ss') : '' },
        { headerName: 'Created by', field: 'created_by', filter: 'agSetColumnFilter' },
        { headerName: 'Updated at', field: 'updated_at', valueFormatter: p => p.value ? moment(p.value).format('DD-MM-YYYY HH:mm:ss') : '' },
        { headerName: 'Updated by', field: 'updated_by', filter: 'agSetColumnFilter' },
      ],

      defaultColDef: {
        sortable: true,
        resizable: true,
        flex: 1,
        filterParams: { buttons: ['reset'] },
        minWidth: 80,
        cellClassRules: { 'pointer': 'true' },
        menuTabs: ['filterMenuTab', 'generalMenuTab', 'columnsMenuTab']
      },

      lkCategory: ['Blood Group', 'Company', 'Diagnosis', 'Hospital', 'Injury Part', 'Injury Type', 'Medic', 'Medical Type', 'Patient Type', 'Sex', 'Transfer', 'Work Related'],
      lkActive: [{ value: 1, label: 'Yes' }, { value: 0, label: 'No' }],

      codeData: [],
      codeFilter: [],

      codeForm: { row_index: '', code_id: '', category: '', code: '', descr_eng: '', descr_lao: '', active: 1 },
      auth: [],
      mode: '',

    };
  },

  mounted() {

  },

  computed: {
    codeFormDis() {
      if (this.codeForm.code == '' || this.codeForm.descr_eng == '' || this.codeForm.active == null) {
        return 'disabled';
      } else {
        return '';
      }
    }
  },

  methods: {
    async onLoad() {

      const codes = await this.getCodes();
      const active = await this.cateSelected(0, 'Blood Group');

      const submenu = 'M09S03';
      const subData = await axios.get(`api/auth/auth-action?submenu=${submenu}`, { headers: { Authorization: 'Bearer ' + this.authStore.getToken } });
      this.auth = subData.data[0];


    },

    async getCodes() {
      const code = await axios.get('api/clinic/codes', { headers: { Authorization: 'Bearer ' + this.authStore.getToken } });
      this.codeData = code.data;
    },

    async cateSelected(index, cate) {
      document.getElementById('btn-new').classList.remove('d-none');
      const elements = document.querySelectorAll('.filter-list, .active');
      elements.forEach(e => {
        e.classList.remove('active');
      })
      document.getElementById(index).classList.add('active');

      this.codeFilter = [];
      this.codeForm.category = cate;

      // if (cate == 'Coal Grade') {
      //   this.category = 'grade'
      // } else {
      // this.category = 'general'
      let item = this.codeData.filter((e) => e.category == cate);
      this.codeFilter = item;
      // }
    },

    newCode() {
      if (this.auth.new == 0) {
        toastr.warning("You're not authorized to add!");
      } else {
        this.mode = 'add';
        this.codeForm.code = '';
        this.codeForm.descr_eng = '';
        this.codeForm.descr_lao = '';
        this.codeForm.active = 1;
        $('#code-modal').modal('show');
      }
    },

    async addCode() {
      const response = await axios.post('api/clinic/add-code', this.codeForm, { headers: { Authorization: 'Bearer ' + this.authStore.getToken } });
      if (response.data.success) {
        $('#code-modal').modal('hide');
        toastr.success('Successfully!');

        const code = await this.getCodes();
        let item = this.codeData.filter((e) => e.category == this.codeForm.category);
        this.codeFilter = item;
        this.disableTool();

      } else {
        toastr.error(`${response.data.message}`);
      }
    },

    cellCicked(e) {
      this.enableTool();
      let f = this.codeForm;

      f.row_index = e.rowIndex;
      f.category = e.data.category;
      f.code_id = e.data.id
      f.code = e.data.code
      f.descr_eng = e.data.descr_eng
      f.descr_lao = e.data.descr_lao
      f.active = e.data.active

    },

    editCode() {
      if (this.auth.edit == 0) {
        toastr.warning("You're not authorized to edit!");
      } else {
        this.mode = 'edit';
        $('#code-modal').modal('show');
      }
    },

    async updCode() {
      const update = await axios.post('api/clinic/upd-code', this.codeForm, { headers: { Authorization: 'Bearer ' + this.authStore.getToken } });
      $('#code-modal').modal('hide');
      toastr.success('Successfully!');
      const code = await this.getCodes();
      let item = this.codeData.filter((e) => e.category == this.codeForm.category);
      this.codeFilter = item;
      this.disableTool();
    },

    delCode() {
      if (this.auth.del == 0) {
        toastr.warning("You're not authorized to delete!");
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
            axios.post('api/clinic/del-code', {
              code_id: this.codeForm.code_id,
              code: this.codeForm.code
            }, { headers: { Authorization: 'Bearer ' + this.authStore.getToken } }).then((response) => {
              // if (response.data.success) {

              this.codeFilter.splice(this.codeForm.row_index, 1);
              this.getCodes();
              this.disableTool();

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

    enableTool() {
      const elements = document.querySelectorAll('[id^="btn-tool-"]');
      elements.forEach((e) => {
        e.classList.remove('disabled');
      });
    },

    disableTool() {
      const elements = document.querySelectorAll('[id^="btn-tool-"]');
      elements.forEach((e) => {
        e.classList.add('disabled');
      });
    },




  },

  created() {
    this.onLoad();
  }
};
</script>