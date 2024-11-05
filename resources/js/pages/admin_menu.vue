<template>
  <div>
    <div class="row g-xl-3 g-lg-3">
      <div class="col-xl-3 col-lg-4">
        <div class="card">
          <div class="card-header align-items-center d-flex">
            <h4 class="card-title mb-0 flex-grow-1">Menu</h4>
            <div>
              <button type="button" class="btn btn-soft-secondary btn-sm btn-icon material-shadow-none btn-link" @click="newMenu">
                <i class="ri-add-line align-bottom"></i>
              </button>
            </div>
          </div>
          <div class="accordion accordion-flush filter-accordion">
            <div class="card-body border-bottom">
              <div>
                <ul class="list-unstyled mb-0 filter-list">
                  <li v-for="(item, index) in menuData" :key="index">
                    <a href="#" class="d-flex py-1 align-items-center" :id="index">
                      <div class="flex-grow-1" @click="menuSelected(index, item.menu, item.name)">
                        <h5 class="fs-13 mb-0 listname">{{ item.name }}</h5>
                      </div>
                      <button class="btn btn-soft-success btn-icon btn-sm material-shadow-none dropdown" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="ri-more-fill bx bx-dots-horizontal align-middle"></i>
                      </button>
                      <ul class="dropdown-menu dropdown-menu-end" style="">
                        <li><a class="dropdown-item" href="javascript:void(0);" @click="editMenu(item.menu_id)"><i class="ri-pencil-fill align-bottom me-2 text-muted"></i>Edit</a></li>
                        <li><a class="dropdown-item" href="javascript:void(0);"><i class="ri-delete-bin-fill align-bottom me-2 text-muted"></i>Delete</a></li>
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
            <h4 class="card-title mb-0 flex-grow-1">{{ menuName }} submenu</h4>
            <div style="height: 27.063px;">
              <button v-if="submenuForm.menu" type="button" class="btn btn-soft-secondary btn-sm btn-icon material-shadow-none" data-bs-toggle="modal" data-bs-target="#submenu-modal">
                <i class="ri-add-line align-bottom"></i>
              </button>
            </div>
          </div>
          <div class="card-body">
            <div class="table-responsive table-card">
              <table class="table align-middle table-nowrap mb-0">
                <thead class="table-light text-muted">
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
                  <tr v-for="item in submenuFilter" :key="item.sub_id">
                    <td>{{ item.menu }}</td>
                    <td>{{ item.sub_id }}</td>
                    <td>{{ item.sub }}</td>
                    <td>{{ item.name }}</td>
                    <td>{{ item.descr }}</td>
                    <td>
                      <button class="btn btn-soft-success btn-icon btn-sm material-shadow-none dropdown" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="ri-more-fill bx bx-dots-horizontal align-middle"></i>
                      </button>
                      <ul class="dropdown-menu dropdown-menu-end" style="">
                        <li><a class="dropdown-item" href="javascript:void(0);"><i class="ri-eye-fill align-bottom me-2 text-muted"></i>View</a></li>
                        <li><a class="dropdown-item" href="javascript:void(0);"><i class="ri-pencil-fill align-bottom me-2 text-muted"></i>Edit</a></li>
                        <li><a class="dropdown-item" href="javascript:void(0);"><i class="ri-delete-bin-fill align-bottom me-2 text-muted"></i>Delete</a></li>
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
            <h5 class="modal-title" id="menuLabel">Menu</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" id="close-modal"></button>
          </div>
          <div class="modal-body">
            <div class="mb-3">
              <label class="form-label">Menu Name</label>
              <input type="text" class="form-control" placeholder="Enter name" v-model="menuForm.name">
            </div>
            <div class="mb-3">
              <label class="form-label">Description</label>
              <textarea type="text" class="form-control" placeholder="Enter description" v-model="menuForm.descr"></textarea>
            </div>
          </div>
          <div class="modal-footer" style="display: block;">
            <div class="hstack gap-2 justify-content-end">
              <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
              <button type="button" class="btn btn-success d-none" id="add-menu" :class="addMenuDis" @click="addMenu">Add Menu</button>
              <button type="button" class="btn btn-success d-none" id="upd-menu">Update</button>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Submenu Modal -->
    <div class="modal fade zoomIn" id="submenu-modal" data-bs-keyboard="false" tabindex="-1" aria-modal="true" role="dialog" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered modal-sm" role="document">
        <div class="modal-content">
          <div class="modal-header bg-light p-3">
            <h5 class="modal-title" id="exampleModalLabel">Submenu</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" id="close-modal"></button>
          </div>
          <div class="modal-body">
            <div class="mb-3">
              <label class="form-label">Submenu Name</label>
              <input type="text" class="form-control" placeholder="Enter name" v-model="submenuForm.name">
            </div>
            <div class="mb-3">
              <label class="form-label">Description</label>
              <textarea type="text" class="form-control" placeholder="Enter description" v-model="submenuForm.descr"></textarea>
            </div>
          </div>
          <div class="modal-footer" style="display: block;">
            <div class="hstack gap-2 justify-content-end">
              <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
              <button type="button" class="btn btn-success" :class="addSubmenuDis" @click="addSubmenu">Add Submenu</button>
              <!-- <button type="button" class="btn btn-success" id="edit-btn">Update</button> -->
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
      menuData: [],
      submenuData: [],
      submenuFilter: [],
      menuForm: { name: '', descr: '' },
      submenuForm: { menu: '', name: '', descr: '' },
      menuName: '',
    };
  },

  mounted() {

  },

  computed: {
    addMenuDis() {
      if (this.menuForm.name == '' || this.menuForm.descr == '') {
        return 'disabled';
      } else {
        return '';
      }
    },

    addSubmenuDis() {
      if (this.submenuForm.menu == '' || this.submenuForm.name == '' || this.submenuForm.descr == '') {
        return 'disabled';
      } else {
        return '';
      }
    },
  },

  methods: {
    async onLoad() {
      const menu = await this.getMenus();

      const submenus = await axios.get('api/admin/submenus', { headers: { Authorization: 'Bearer ' + this.authStore.getToken } });
      this.submenuData = submenus.data;
      this.menuSelected(0, 'M01', 'Dashboards')

    },

    async getMenus() {
      try {
        const menus = await axios.get('api/admin/menus', { headers: { Authorization: 'Bearer ' + this.authStore.getToken } });
        this.menuData = menus.data;
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

    async getSubmenus() {
      const submenus = await axios.get('api/admin/submenus', { headers: { Authorization: 'Bearer ' + this.authStore.getToken } });
      this.submenuData = submenus.data;
    },

    newMenu() {
      this.menuForm = [];
      document.getElementById('menuLabel').textContent = 'Add menu';
      document.getElementById('add-menu').classList.remove('d-none');
      document.getElementById('upd-menu').classList.add('d-none');
      $('#menu-modal').modal('show');
    },

    async addMenu() {
      const response = await axios.post('api/admin/add-menu', this.menuForm, { headers: { Authorization: 'Bearer ' + this.authStore.getToken } })
      if (response.data.success) {
        $('#menu-modal').modal('hide');
        toastr.success('Successfully!');
        const data = await this.getMenus();
        this.menuForm = {};
      } else {
        toastr.error(`${response.data.message}`);
      }
    },

    editMenu(menuId) {
      let item = this.menuData.find(e => e.menu_id == menuId);
      this.menuForm.name = item.name;
      this.menuForm.descr = item.descr;
      document.getElementById('menuLabel').textContent = item.menu;
      document.getElementById('add-menu').classList.add('d-none');
      document.getElementById('upd-menu').classList.remove('d-none');
      $('#menu-modal').modal('show');
    },

    updateMenu() {
      // axios.post('api/sales/upd-contract', this.contractForm, { headers: { Authorization: 'Bearer ' + this.authStore.getToken } }).then((response) => {
      //   toastr.success('Update successfully!');
      //   $('#edit-contract-modal').modal('hide');
      //   this.getContracts();
      //   this.disableDropdown();
      // }).catch((error) => {
      //   toastr.error('This contract already exists in the database!');
      // })
    },

    async menuSelected(index, menu, name) {
      this.menuName = name;
      this.submenuForm.menu = menu;
      const elements = document.querySelectorAll('.filter-list, .active');
      elements.forEach(e => {
        e.classList.remove('active');
      })

      document.getElementById(index).classList.add('active');
      let items = this.submenuData.filter((i) => i.menu == menu);
      this.submenuFilter = items;
    },

    async addSubmenu() {
      const response = await axios.post('api/admin/add-submenu', this.submenuForm, { headers: { Authorization: 'Bearer ' + this.authStore.getToken } })
      if (response.data.success) {
        $('#submenu-modal').modal('hide');
        toastr.success('Successfully!');
        const data = await this.getSubmenus();
        let items = this.submenuData.filter((i) => i.menu == this.submenuForm.menu);
        this.submenuFilter = items;
        this.submenuForm.name = '';
        this.submenuForm.descr = '';
      } else {
        toastr.error(`${response.data.message}`);
      }
    },
  },

  created() {
    this.onLoad();
  },
};
</script>