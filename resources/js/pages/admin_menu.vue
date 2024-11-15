<template>
  <div>
    <div class="row g-xl-3 g-lg-3">
      <div class="col-xl-3 col-lg-4">
        <div class="card">
          <div class="card-header align-items-center d-flex">
            <h4 class="card-title mb-0 flex-grow-1">Menu</h4>
            <div>
              <!-- <button type="button" class="btn btn-soft-secondary btn-sm btn-icon material-shadow-none btn-link" @click="newMenu">
                <i class="ri-add-line align-bottom"></i>
              </button> -->
              <button class="btn btn-sm btn-soft-info" id="btn-new" @click="newMenu"><i class="ri-add-fill me-1 align-bottom"></i>Add Menu</button>
            </div>
          </div>
          <div class="accordion accordion-flush filter-accordion">
            <div class="card-body border-bottom">
              <div>
                <ul class="list-unstyled mb-0 filter-list">
                  <li v-for="(item, index) in menus" :key="index">
                    <a href="#" class="d-flex py-1 align-items-center" :id="index">
                      <div class="flex-grow-1" @click="menuSelected(index, item.menu_code, item.menu_name)">
                        <h5 class="fs-13 mb-0 listname">{{ item.menu_name }}</h5>
                      </div>
                      <button class="btn btn-soft-success btn-icon btn-sm material-shadow-none dropdown" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="ri-more-fill bx bx-dots-horizontal align-middle"></i>
                      </button>
                      <ul class="dropdown-menu dropdown-menu-end" style="">
                        <li><a class="dropdown-item" href="javascript:void(0);" @click="editMenu(item.menu_id)"><i class="ri-pencil-fill align-bottom me-2 text-muted"></i>Edit</a></li>
                        <li><a class="dropdown-item" href="javascript:void(0);" @click="delMenu(item.menu_code)"><i class="ri-delete-bin-fill align-bottom me-2 text-muted"></i>Delete</a></li>
                      </ul>

                      <!-- <div class="dropdown">
                        <button class="btn btn-icon btn-sm fs-16 text-muted dropdown material-shadow-none" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                          <i class="ri-more-fill"></i>
                        </button>
                        <ul class="dropdown-menu" style="">
                          <li><a class="dropdown-item" href="javascript:void(0);"><i class="ri-eye-fill text-muted me-2 align-bottom"></i>View</a></li>
                          <li><a class="dropdown-item" href="javascript:void(0);"><i class="ri-star-fill text-muted me-2 align-bottom"></i>Favourite</a></li>
                          <li><a class="dropdown-item" href="javascript:void(0);"><i class="ri-delete-bin-5-fill text-muted me-2 align-bottom"></i>Delete</a></li>
                        </ul>
                      </div> -->
                    </a>
                  </li>
                </ul>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- Submenu -->
      <div class="col-xl-9 col-lg-8">
        <div class="card">
          <div class="card-header align-items-center d-flex">
            <h4 class="card-title mb-0 flex-grow-1">{{ menuName }}</h4>
            <div style="height: 27.063px;">
              <button v-if="subForm.menu_code" class="btn btn-sm btn-soft-info" id="btn-new" @click="newMenusub"><i class="ri-add-fill me-1 align-bottom"></i>Add Submenu</button>
              <!-- <button v-if="subForm.menu_code" type="button" class="btn btn-soft-secondary btn-sm btn-icon material-shadow-none" @click="newMenusub">
                <i class="ri-add-line align-bottom"></i>
              </button> -->
            </div>
          </div>
          <div class="card-body">
            <div class="table-responsive table-card">
              <table class="table align-middle table-nowrap mb-0">
                <thead class="table-light">
                  <tr>
                    <th>Menu</th>
                    <th>Sub ID</th>
                    <th>Submenu</th>
                    <th>Name</th>
                    <th>Description</th>
                    <th>Action</th>
                  </tr>
                </thead>
                <tbody>
                  <tr v-for="item in filtered" :key="item.sub_id">
                    <td>{{ item.menu_code }}</td>
                    <td>{{ item.sub_id }}</td>
                    <td>{{ item.sub_code }}</td>
                    <td>{{ item.sub_name }}</td>
                    <td>{{ item.descr }}</td>
                    <td>
                      <button class="btn btn-soft-success btn-icon btn-sm material-shadow-none dropdown" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="ri-more-fill bx bx-dots-horizontal align-middle"></i>
                      </button>
                      <ul class="dropdown-menu dropdown-menu-end" style="">
                        <li><a class="dropdown-item" href="javascript:void(0)" @click="editMenusub(item.sub_code)"><i class="ri-pencil-fill align-bottom me-2 text-muted"></i>Edit</a></li>
                        <li><a class="dropdown-item" href="javascript:void(0)" @click="delMenusub(item.sub_code)"><i class="ri-delete-bin-fill align-bottom me-2 text-muted"></i>Delete</a></li>
                      </ul>
                    </td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Menu Modal -->
    <div class="modal fade zoomIn" id="menu-modal" data-bs-keyboard="false" tabindex="-1" aria-modal="true" role="dialog" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered modal-sm" role="document">
        <div class="modal-content">
          <div class="modal-header bg-light p-3">
            <h5 v-if="actMode == 'add'" class="modal-title" id="menuLabel">Add Menu</h5>
            <h5 v-if="actMode == 'edit'" class="modal-title" id="menuLabel">Edit Menu</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" id="close-modal"></button>
          </div>
          <div class="modal-body">
            <div class="mb-3">
              <label class="form-label">Menu Name <span class="text-danger">*</span></label>
              <input type="text" class="form-control" placeholder="Enter name" v-model="menuForm.menu_name">
            </div>
            <div class="mb-3">
              <label class="form-label">Description <span class="text-danger">*</span></label>
              <textarea type="text" class="form-control" placeholder="Enter description" v-model="menuForm.descr"></textarea>
            </div>
          </div>
          <div class="modal-footer" style="display: block;">
            <div class="hstack gap-2 justify-content-end">
              <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
              <button v-if="actMode === 'add'" type="button" class="btn btn-success" :class="addMenuDis" @click="addMenu">Add Menu</button>
              <button v-if="actMode === 'edit'" type="button" class="btn btn-success" :class="addMenuDis" @click="updMenu">Save Change</button>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Submenu Modal -->
    <div class="modal fade zoomIn" id="menusub-modal" data-bs-keyboard="false" tabindex="-1" aria-modal="true" role="dialog" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered modal-sm" role="document">
        <div class="modal-content">
          <div class="modal-header bg-light p-3">
            <h5 v-if="actMode == 'add'" class="modal-title" id="exampleModalLabel">Add Submenu</h5>
            <h5 v-if="actMode == 'edit'" class="modal-title" id="exampleModalLabel">Edit Submenu</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" id="close-modal"></button>
          </div>
          <div class="modal-body">
            <div class="mb-3">
              <label class="form-label">Submenu Name <span class="text-danger">*</span></label>
              <input type="text" class="form-control" placeholder="Enter name" v-model="subForm.sub_name">
            </div>
            <div class="mb-3">
              <label class="form-label">Description <span class="text-danger">*</span></label>
              <textarea type="text" class="form-control" placeholder="Enter description" v-model="subForm.descr"></textarea>
            </div>
          </div>
          <div class="modal-footer" style="display: block;">
            <div class="hstack gap-2 justify-content-end">
              <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
              <button v-if="actMode == 'add'" type="button" class="btn btn-success" :class="addMenusubDis" @click="addMenusub">Add Submenu</button>
              <button v-if="actMode == 'edit'" type="button" class="btn btn-success" :class="addMenusubDis" @click="updMenusub">Save Change</button>
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
import { useToastr } from "../toastr.js";
import { useAuthStore } from '../stores/auth.js';
const toastr = useToastr();

export default {
  name: 'XpplAppAdminMenu',
  setup() {
    const authStore = useAuthStore();
    return { authStore };
  },

  data() {
    return {
      menus: [],
      menusubs: [],
      filtered: [],
      menuForm: { menu_id: '', menu_code: '', menu_name: '', descr: '' },
      subForm: { sub_id: '', menu_code: '', sub_code: '', sub_name: '', descr: '' },
      menuName: '',
      actMode: '',
      delMode: ''
    };
  },

  mounted() {

  },

  computed: {
    addMenuDis() {
      if (this.menuForm.menu_name === '' || this.menuForm.descr === '') {
        return 'disabled';
      } else {
        return '';
      }
    },

    addMenusubDis() {
      if (this.subForm.menu_code == '' || this.subForm.sub_name == '' || this.subForm.descr == '') {
        return 'disabled';
      } else {
        return '';
      }
    },
  },

  methods: {
    async onLoad() {
      const menu = await this.getMenu();

      const sub = await axios.get('api/admin/menu-sub', { headers: { Authorization: 'Bearer ' + this.authStore.getToken } });
      this.menusubs = sub.data;
      this.menuSelected(0, 'M01', 'Dashboards')

    },

    async getMenu() {
      try {
        const menu = await axios.get('api/admin/menu', { headers: { Authorization: 'Bearer ' + this.authStore.getToken } });
        this.menus = menu.data;
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

    async getMenusub() {
      const submenus = await axios.get('api/admin/menu-sub', { headers: { Authorization: 'Bearer ' + this.authStore.getToken } });
      this.menusubs = submenus.data;
    },

    newMenu() {
      this.actMode = 'add';
      this.menuForm.menu_name = '';
      this.menuForm.descr = '';
      $('#menu-modal').modal('show');
    },

    async addMenu() {
      const response = await axios.post('api/admin/add-menu', this.menuForm, { headers: { Authorization: 'Bearer ' + this.authStore.getToken } })
      if (response.data.success) {
        const data = await this.getMenu();
        $('#menu-modal').modal('hide');
        toastr.success('Successfully!');
      } else {
        toastr.error(`${response.data.message}`);
      }
    },

    editMenu(menuId) {
      this.actMode = 'edit'
      let item = this.menus.find(e => e.menu_id == menuId);
      this.menuForm.menu_id = item.menu_id;
      this.menuForm.menu_name = item.menu_name;
      this.menuForm.descr = item.descr;
      $('#menu-modal').modal('show');
    },

    async updMenu() {
      try {
        const response = await axios.post('api/admin/upd-menu', this.menuForm, { headers: { Authorization: 'Bearer ' + this.authStore.getToken } });
        const code = await this.getMenu();
        toastr.success('Update Successfully.');
        $('#menu-modal').modal('hide');
      } catch (error) {
        toastr.error('This menu already exists in the database.');
      };
    },

    delMenu(menu) {
      this.menuForm.menu_code = menu;
      this.delMode = 'menu';
      $('#delete-modal').modal('show');
    },

    async delConfirm() {
      if (this.delMode == 'menu') {
        const response = await axios.post('api/admin/del-menu', this.menuForm, { headers: { Authorization: 'Bearer ' + this.authStore.getToken } });
        if (response.data.success) {
          const code = await this.getMenu();
          toastr.success('Delete Successfully.');
          $('#delete-modal').modal('hide');
        } else {
          toastr.error(`${response.data.message}`);
        };
      } else {
        const response = await axios.post('api/admin/del-menu-sub', this.subForm, { headers: { Authorization: 'Bearer ' + this.authStore.getToken } });
        if (response.data.success) {
          const code = await this.getMenusub();
          let item = this.menusubs.filter(e => e.menu_code == this.subForm.menu_code);
          this.filtered = item;
          toastr.success('Delete Successfully.');
          $('#delete-modal').modal('hide');
        } else {
          toastr.error(`${response.data.message}`);
        };
      };
    },

    async menuSelected(index, menu, name) {
      this.menuName = name;
      this.subForm.menu_code = menu;
      const elements = document.querySelectorAll('.filter-list, .active');
      elements.forEach(e => {
        e.classList.remove('active');
      });

      document.getElementById(index).classList.add('active');
      let items = this.menusubs.filter((i) => i.menu_code == menu);
      this.filtered = items;
    },

    newMenusub() {
      this.actMode = 'add';
      this.subForm.sub_name = '';
      this.subForm.descr = '';
      $('#menusub-modal').modal('show');
    },

    async addMenusub() {
      const response = await axios.post('api/admin/add-menu-sub', this.subForm, { headers: { Authorization: 'Bearer ' + this.authStore.getToken } })
      if (response.data.success) {
        const data = await this.getMenusub();
        let items = this.menusubs.filter((i) => i.menu_code == this.subForm.menu_code);
        this.filtered = items;
        this.subForm.name = '';
        this.subForm.descr = '';
        $('#menusub-modal').modal('hide');
        toastr.success('Successfully!');
      } else {
        toastr.error(`${response.data.message}`);
      };
    },

    editMenusub(sub) {
      this.actMode = 'edit';
      let item = this.menusubs.find(e => e.sub_code == sub);
      this.subForm.sub_code = item.sub_code;
      this.subForm.sub_name = item.sub_name;
      this.subForm.descr = item.descr;
      $('#menusub-modal').modal('show');
    },

    async updMenusub() {
      try {
        const response = await axios.post('api/admin/upd-menu-sub', this.subForm, { headers: { Authorization: 'Bearer ' + this.authStore.getToken } });
        const code = await this.getMenusub();
        let item = this.menusubs.filter(e => e.menu_code == this.subForm.menu_code);
        this.filtered = item;
        toastr.success('Update Successfully.');
        $('#menusub-modal').modal('hide');
      } catch (error) {
        toastr.error('This menu already exists in the database.');
      };
    },

    delMenusub(sub) {
      this.subForm.sub_code = sub;
      this.delMode = 'sub';
      $('#delete-modal').modal('show');
    },

  },

  created() {
    this.onLoad();
  },
};
</script>