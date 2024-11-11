<template>
  <div>
    <div class="card">
      <div class="card-header">
        <div class="row g-4 align-items-center">
          <div class="col-sm-3">
            <form class="app-search d-md-block py-0 ps-0">
              <div class="position-relative">
                <input type="text" class="form-control" placeholder="Search..." v-model="search" @input="onSearch">
                <span class="ri-search-line search-icon search-widget-icon fs-14"></span>
                <span class="mdi mdi-close-circle search-widget-icon search-widget-icon-close cursor-pointer d-none" id="search-close" @click="searchClear"></span>
              </div>
            </form>
          </div>
          <div class="col-sm-auto ms-auto">
            <div class="hstack gap-2">
              <button type="button" class="btn btn-soft-info add-btn" id="create-btn" @click="newEmail"><i class="ri-add-line align-bottom me-1"></i> Add Email</button>
              <button class="btn btn-soft-info btn-icon" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                <i class="ri-more-2-fill"></i>
              </button>
              <ul class="dropdown-menu dropdown-menu-end dropdownmenu-secondary">
                <li><a class="dropdown-item disabled" id="tool-1" href="javascript:void(0)" @click="editEmail"><i class="ri-pencil-fill align-bottom me-2 text-muted"></i> Edit</a></li>
                <li><a class="dropdown-item disabled" id="tool-2" href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#delete-modal"><i class="ri-delete-bin-fill align-bottom me-2 text-muted"></i> Delete</a></li>
              </ul>
            </div>
          </div>
        </div>
      </div>
      <ag-grid-vue style="height: calc(100vh - 16.2rem);" class="ag-theme-material" :columnDefs="columnDefs" :rowData="emailList" :defaultColDef="defaultColDef" :rowHeight="36" :headerHeight="44" :suppressMenuHide="false" :suppressCellFocus="true" animateRows="false" rowSelection="single" @rowClicked="cellCicked" @cell-double-clicked="editEmail"></ag-grid-vue>
      <div class="pt-2"></div>
    </div>

    <!-- Email Form Modal -->
    <div class="modal fade zoomIn" id="email-modal" data-bs-keyboard="false" tabindex="-1" aria-modal="true" role="dialog" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
          <div class="modal-header bg-light p-3">
            <h5 v-if="actMode == 'add'" class="modal-title">Add Email</h5>
            <h5 v-if="actMode == 'edit'" class="modal-title">Edit Email</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" id="close-modal"></button>
          </div>
          <div class="modal-body">
            <div class="row">
              <div class="mb-3 col-md-6">
                <label class="form-label">Name <span class="text-danger">*</span></label>
                <input type="text" class="form-control" placeholder="Enter name" v-model="emailForm.name">
              </div>
              <div class="mb-3 col-md-6">
                <label class="form-label">Surname </label>
                <input type="text" class="form-control" placeholder="Enter surname" v-model="emailForm.surname">
              </div>
              <div class="mb-3">
                <label class="form-label">Email <span class="text-danger">*</span></label>
                <input type="text" class="form-control" placeholder="Enter email" v-model="emailForm.email">
              </div>
              <div class="mb-3">
                <label class="form-label">Position </label>
                <input type="text" class="form-control" placeholder="Enter email" v-model="emailForm.position">
              </div>
              <div class="mb-3">
                <label class="form-label">Department </label>
                <input type="text" class="form-control" placeholder="Enter department" v-model="emailForm.dept">
              </div>
              <div class="mb-3 col-md-6">
                <label class="form-label">Company/Office <span class="text-danger">*</span></label>
                <input type="text" class="form-control" placeholder="Enter company" v-model="emailForm.office">
              </div>
              <div class="col-md-6">
                <label class="form-label">Phone </label>
                <input type="text" class="form-control" placeholder="Enter phone" v-model="emailForm.phone">
              </div>
            </div>
          </div>
          <div class="modal-footer" style="display: block;">
            <div class="hstack gap-2 justify-content-end">
              <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
              <button v-if="actMode == 'add'" type="button" class="btn btn-success" :class="emailFormDis" @click="addEmail">Add Email</button>
              <button v-if="actMode == 'edit'" type="button" class="btn btn-success" :class="emailFormDis" @click="updEmail">Save Change</button>
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
              <h4 class="fs-semibold">You are about to delete a record ?</h4>
              <p class="text-muted fs-14 mb-4 pt-1">Deleting your record will remove all of your information from our database.</p>
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
  name: 'XpplAppAdminEmailRegister',
  components: { AgGridVue },
  setup() {
    const authStore = useAuthStore();
    return { authStore };
  },

  data() {
    return {
      columnDefs: [
        { headerName: '#', maxWidth: 50, valueGetter: (params) => { return params.node.rowIndex + 1 } },
        { headerName: 'ID', field: 'id', maxWidth: 50, filter: 'agSetColumnFilter', hide: true },
        { headerName: 'Name', field: 'name', filter: 'agSetColumnFilter' },
        { headerName: 'Surname', field: 'surname', filter: 'agSetColumnFilter' },
        { headerName: 'Email', field: 'email', minWidth: 300, filter: 'agSetColumnFilter' },
        { headerName: 'Username', field: 'username', filter: 'agSetColumnFilter' },
        { headerName: 'Position', field: 'position', filter: 'agSetColumnFilter' },
        { headerName: 'Department', field: 'dept', filter: 'agSetColumnFilter' },
        { headerName: 'Office/Company', field: 'office', filter: 'agSetColumnFilter' },
        { headerName: 'Phone', field: 'phone', filter: 'agSetColumnFilter' },
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

      emailForm: { id: '', email: '', name: '', surname: '', position: '', dept: '', office: '', phone: '', email_ori: '' },
      emails: [],
      search: '',
      actMode: ''
    };
  },

  mounted() {

  },

  computed: {
    emailList() {
      if (this.search.trim().length > 0) {
        return this.emails.filter((i) =>
          i.email.substring(0, this.search.trim().length).toLowerCase() === this.search.trim().toLowerCase() ||
          i.name.substring(0, this.search.trim().length).toLowerCase() === this.search.trim().toLowerCase() ||
          i.surname.substring(0, this.search.trim().length).toLowerCase() === this.search.trim().toLowerCase() ||
          i.username.substring(0, this.search.trim().length).toLowerCase() === this.search.trim().toLowerCase()
        );
      };
      return this.emails;
    },

    emailFormDis() {
      if (this.emailForm.name === '' || this.emailForm.email === '' || this.emailForm.office === '') {
        return 'disabled';
      } else {
        return '';
      }
    }
  },

  methods: {
    async getEmail() {
      const email = await axios.get('api/admin/emails', { headers: { Authorization: 'Bearer ' + this.authStore.getToken } });
      this.emails = email.data;
    },

    newEmail() {
      this.actMode = 'add'
      this.emailForm.name = ''
      this.emailForm.surname = ''
      this.emailForm.email = ''
      this.emailForm.position = ''
      this.emailForm.dept = ''
      this.emailForm.office = ''
      this.emailForm.phone = ''
      $('#email-modal').modal('show')
      this.disableTool()
    },

    async addEmail() {
      const response = await axios.post('api/admin/add-email', this.emailForm, { headers: { Authorization: 'Bearer ' + this.authStore.getToken } });
      if (response.data.success) {
        const email = await this.getEmail();
        this.emailForm = {};
        $('#email-modal').modal('hide');
        toastr.success('Add Successfully.');
      } else {
        toastr.error(`${response.data.message}`);
      }
    },

    cellCicked(e) {
      this.enableTool();
      this.emailForm.id = e.data.id;
      this.emailForm.email = e.data.email;
      this.emailForm.email_ori = e.data.email;
      this.emailForm.name = e.data.name;
      this.emailForm.surname = e.data.surname;
      this.emailForm.position = e.data.position;
      this.emailForm.dept = e.data.dept;
      this.emailForm.office = e.data.office;
      this.emailForm.phone = e.data.phone;
    },

    editEmail() {
      this.actMode = 'edit';
      $('#email-modal').modal('show');
    },

    async updEmail() {
      try {
        const response = await axios.post('api/admin/upd-email', this.emailForm, { headers: { Authorization: 'Bearer ' + this.authStore.getToken } });
        if (response.data.success) {
          const code = await this.getEmail();
          $('#email-modal').modal('hide');
          toastr.success('Update Successfully.');
          this.disableTool();
        } else {
          toastr.error(`${response.data.message}`);
        };
      } catch (error) {
        toastr.error('This email already exists in the database.');
      };
    },

    async delConfirm() {
      const response = await axios.post('api/admin/del-email', this.emailForm, { headers: { Authorization: 'Bearer ' + this.authStore.getToken } });
      if (response.data.success) {
        const code = await this.getEmail();
        $('#delete-modal').modal('hide');
        toastr.success('Delete Successfully.');
        this.disableTool();
      } else {
        toastr.error(`${response.data.message}`);
      };
    },

    async onSearch() {
      if (this.search.length > 0) {
        document.getElementById('search-close').classList.remove('d-none');
      } else {
        document.getElementById('search-close').classList.add('d-none');
      }
    },

    async searchClear() {
      this.search = '';
      document.getElementById('search-close').classList.add('d-none');
    },

    enableTool() {
      const elements = document.querySelectorAll('[id^="tool-"]');
      elements.forEach((e) => {
        e.classList.remove('disabled');
      });
    },

    disableTool() {
      const elements = document.querySelectorAll('[id^="tool-"]');
      elements.forEach((e) => {
        e.classList.add('disabled');
      });
    },
  },

  created() {
    this.getEmail();
  }
};
</script>