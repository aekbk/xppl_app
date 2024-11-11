<template>
  <div>
    <div v-if="loading">
      <loading />
    </div>
    <div v-else>
      <!-- User list -->
      <div v-if="display == 'users'">
        <div class="card">
          <div class="card-header d-flex align-items-lg-center flex-lg-row flex-column">
            <div class="flex-grow-1">
              <h4 class="card-title mb-0">Users</h4>
              <p class="text-muted mb-0">User register lists</p>
            </div>
            <div class="mt-3 mt-lg-0">
              <div class="row g-3 mb-0 align-items-center">
                <div class="col-sm-auto">
                  <form class="app-search d-md-block py-0 ps-0">
                    <div class="position-relative">
                      <input type="text" class="form-control" placeholder="Search..." v-model="search" @input="onSearch()">
                      <span class="ri-search-line search-icon search-widget-icon fs-14"></span>
                      <span class="mdi mdi-close-circle search-widget-icon search-widget-icon-close cursor-pointer d-none" id="search-close" @click="searchClear()"></span>
                    </div>
                  </form>
                </div>
              </div>
            </div>
          </div>
          <div class="card-body">
            <div class="table-responsive table-card">
              <table class="table align-middle table-nowrap mb-0">
                <thead class="table-light">
                  <tr>
                    <th>Username</th>
                    <th>Name</th>
                    <th>Surname</th>
                    <th>Company</th>
                    <th>Department</th>
                    <th>Position</th>
                    <th>Email</th>
                    <th>Phone</th>
                    <th>Action</th>
                  </tr>
                </thead>
                <tbody>
                  <tr v-for="item in userData.data" :key="item.id">
                    <td>
                      <div class="d-flex gap-2 align-items-center">
                        <div v-if="item.avatar" class="flex-shrink-0">
                          <img :src="'assets/images/users/' + item.avatar" alt="" class="avatar-xs rounded-circle">
                        </div>
                        <div v-else class="avatar-xs">
                          <div class="avatar-title rounded bg-success-subtle text-muted rounded-circle text-capitalize fw-medium">{{ avatarText(item.username, item.surname) }}</div>
                        </div>
                        <div class="flex-grow-1">
                          <a class="link-secondary text-body text-lowercase" href="javascript:void(0)" @click="userSelected(item.username, item.id)">{{ item.username }}</a>
                        </div>
                      </div>
                    </td>
                    <td>{{ item.name }}</td>
                    <td>{{ item.surname }}</td>
                    <td>{{ item.company }}</td>
                    <td>{{ item.department }}</td>
                    <td>{{ item.position }}</td>
                    <td>{{ item.email }}</td>
                    <td>{{ item.phone }}</td>
                    <td>
                      <button class="btn btn-soft-success btn-icon btn-sm material-shadow-none dropdown" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="ri-more-fill bx bx-dots-horizontal align-middle"></i>
                      </button>
                      <ul class="dropdown-menu dropdown-menu-end" style="">
                        <li><a class="dropdown-item" href="javascript:void(0);" @click="userSelected(item.username, item.id)"><i class="ri-lock-unlock-fill align-bottom me-2 text-muted"></i> Authorise</a></li>
                        <li><a class="dropdown-item disabled" href="javascript:void(0);"><i class="ri-pencil-fill align-bottom me-2 text-muted"></i> Edit User</a></li>
                        <li><a class="dropdown-item disabled" href="javascript:void(0);"><i class="ri-delete-bin-fill align-bottom me-2 text-muted"></i> Delete</a></li>
                      </ul>
                    </td>
                  </tr>
                </tbody>
              </table>
            </div>
            <div class="mt-4">
              <pagination :pagination="userData" @paginate="getUsers($event)" :offset="4"></pagination>
            </div>
          </div>
        </div>
      </div>

      <!-- Authorise -->
      <div v-if="display == 'auth'">
        <div class="row mb-3 pb-1">
          <div class="col-12">
            <div class="d-flex align-items-lg-center flex-lg-row flex-column">
              <div class="flex-grow-1">
                <h4 id="authorise-header" class="fs-16 mb-1 text-capitalize"> Authorise for {{ authFor }} </h4>
                <p class="text-muted mb-0">Authorise menu and submenu.</p>
              </div>
              <div class="mt-3 mt-lg-0">
                <form action="javascript:void(0);">
                  <div class="row g-2 mb-0 align-items-center">
                    <!-- <div class="col-auto">
                      <button type="button" class="btn btn-soft-info material-shadow-none" @click="authSave()"><i class="ri-save-3-line me-1 align-bottom"></i> Save</button>
                    </div> -->
                    <div class="col-auto">
                      <button type="button" class="btn btn-soft-success btn-icon waves-effect material-shadow-none waves-light layout-rightside-btn" @click="display = 'users'" title="Back to users"><i class="ri-arrow-go-back-line fs-16"></i></button>
                    </div>
                  </div>
                </form>
              </div>
            </div>
          </div>
        </div>

        <div class="row g-xl-3 g-lg-3">
          <div class="col-xl-3 col-lg-4">
            <div class="card">
              <div class="card-header align-items-center d-flex">
                <h4 class="card-title mb-0 flex-grow-1">Menu</h4>
                <div>
                  <button type="button" class="btn btn-soft-secondary btn-sm btn-icon material-shadow-none btn-link" @click="menuListOpen()">
                    <i class="ri-add-line align-bottom"></i>
                  </button>
                </div>
              </div>
              <div class="accordion accordion-flush filter-accordion">
                <div class="card-body border-bottom">
                  <div>
                    <ul class="list-unstyled mb-0 filter-list">
                      <li v-for="(item, index) in authMenuFilter" :key="index">
                        <a href="#" class="d-flex py-1 align-items-center" :id="index">
                          <div class="flex-grow-1" @click="menuSelected(index, item.menu)">
                            <h5 class="fs-13 mb-0 listname">{{ item.name }}</h5>
                          </div>
                          <!-- <div class="form-check form-switch p-0">
                            <input class="form-check-input" type="checkbox" role="switch" :id="'switch-' + inx" v-model="item.acc" @change='$emit("input", $event.target.checked)'>
                            <label class="form-check-label" :for="'switch-' + inx"></label>
                          </div> -->
                          <div class="form-check p-0">
                            <input class="form-check-input" type="checkbox" name="formCheckboxRight" :id="'check-' + index" v-model="item.acc" @change='$emit("input", $event.target.checked), updateMenu(item.menu)'>
                            <label class="form-check-label" :for="'check-' + index"></label>
                          </div>
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
                <h4 class="card-title mb-0 flex-grow-1">Submenu</h4>
                <div style="height: 27.063px;">
                  <button v-if="menu" type="button" class="btn btn-soft-secondary btn-sm btn-icon material-shadow-none" @click="subListOpen()">
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
                        <th>Submenu</th>
                        <th>Name</th>
                        <th>Access</th>
                        <th>Add</th>
                        <th>Edit</th>
                        <th>Delete</th>
                        <!-- <th scope="col" style="width: 150px;">Action</th> -->
                      </tr>
                    </thead>
                    <tbody>
                      <tr v-for="(item, index) in authSubFilter" :key="index">
                        <td>{{ item.menu }}</td>
                        <td>{{ item.sub }}</td>
                        <td>{{ item.name }}</td>
                        <td>
                          <div class="form-check p-0">
                            <input class="form-check-input" type="checkbox" name="formCheckboxRight" :id="'check-' + index" v-model="item.acc" @change='$emit("input", $event.target.checked), updateSub(item.sub)'>
                            <label class="form-check-label" :for="'check-' + index"></label>
                          </div>
                        </td>
                        <td>
                          <div class="form-check p-0">
                            <input class="form-check-input" type="checkbox" name="formCheckboxRight" :id="'check-' + index" v-model="item.new" @change='$emit("input", $event.target.checked), updateSub(item.sub)'>
                            <label class="form-check-label" :for="'check-' + index"></label>
                          </div>
                        </td>
                        <td>
                          <div class="form-check p-0">
                            <input class="form-check-input" type="checkbox" name="formCheckboxRight" :id="'check-' + index" v-model="item.edit" @change='$emit("input", $event.target.checked), updateSub(item.sub)'>
                            <label class="form-check-label" :for="'check-' + index"></label>
                          </div>
                        </td>
                        <td>
                          <div class="form-check p-0">
                            <input class="form-check-input" type="checkbox" name="formCheckboxRight" :id="'check-' + index" v-model="item.del" @change='$emit("input", $event.target.checked), updateSub(item.sub)'>
                            <label class="form-check-label" :for="'check-' + index"></label>
                          </div>
                        </td>
                        <!-- <td>
                          <button class="btn btn-soft-secondary btn-sm dropdown" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="ri-more-fill bx bx-dots-horizontal align-middle"></i>
                          </button>
                          <ul class="dropdown-menu dropdown-menu-end" style="">
                            <li><a class="dropdown-item" href="javascript:void(0);" @click="permission(item.id)"><i class="ri-lock-unlock-fill align-bottom me-2 text-muted"></i>Permission</a></li>
                            <li><a class="dropdown-item" href="javascript:void(0);" @click="editUser(item.id)"><i class="ri-pencil-fill align-bottom me-2 text-muted"></i>Edit User</a></li>
                            <li><a class="dropdown-item" href="javascript:void(0);" @click="resetPassword(item.id)"><i class="mdi mdi-lock-reset align-bottom me-2 text-muted"></i>Reset</a></li>
                            <div class="dropdown-divider"></div>
                            <li><a class="dropdown-item" data-bs-toggle="modal" href="#deleteUser"><i class="ri-delete-bin-fill align-bottom me-2 text-muted"></i>Delete</a></li>
                          </ul>
                        </td> -->
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

    <!-- Menu list Modal -->
    <div class="modal fade zoomIn" id="modal-item-list" data-bs-keyboard="false" tabindex="-1" aria-modal="true" role="dialog" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered modal-sm" role="document">
        <div class="modal-content">
          <div class="modal-header bg-light p-3">
            <h5 v-if="addMode == 'menu'" class="modal-title" id="exampleModalLabel">Menu</h5>
            <h5 v-else class="modal-title" id="exampleModalLabel">Submenu</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" id="close-modal"></button>
          </div>
          <div class="modal-body pb-0">
            <label v-if="itemList.length > 0" class="list-group-item">
              <input class="form-check-input" type="checkbox" v-model="selectAll" @click="selectAllItems()">
              <span v-if="selectAll" class="ms-2 cursor-pointer mg-t-2 text-danger tx-hover" title="Select/Unselect">Unselect All</span>
              <span v-else class="ms-2 cursor-pointer mg-t-2 text-primary tx-hover" title="Select/Unselect all">Select All</span>
            </label>
            <div v-else>
              <div v-if="addMode == 'menu'" class="mg-t-2 text-danger">There's no menu left.</div>
              <div v-else class="mg-t-2 text-danger">There's no submenu left.</div>
            </div>
            <ul class="ps-0" data-simplebar style="min-height: 100px; max-height: 300px">
              <li v-for="(item, index) in itemList" :key="index" class="text-capitalize" style="list-style: none">
                <label class="list-group-item pt-1" style="font-weight: 400;">
                  <input class="form-check-input" type="checkbox" :value="item.value" v-model="itemSelected">
                  <span class="ms-2 cursor-pointer tx-14 tx-hover">{{ item.name }}</span>
                </label>
              </li>
            </ul>
          </div>
          <div class="modal-footer" style="display: block;">
            <div class="hstack gap-2 justify-content-end">
              <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
              <button v-if="addMode == 'menu'" type="button" class="btn btn-success" :class="menuListDis" @click="addMenu()">Add Menu</button>
              <button v-else type="button" class="btn btn-success" :class="menuListDis" @click="addSubmenu()">Add Submenu</button>
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
import { useStore } from '../stores/store.js';
import { useAuthStore } from '../stores/auth.js';

export default {
  name: 'XpplAppAuthorise',
  setup() {
    const store = useStore();
    const authStore = useAuthStore();
    return { store, authStore };
  },

  data() {
    return {
      userData: [],
      lkpMenu: [],
      lkpSub: [],
      authMenuData: [],
      authSubData: [],
      authMenuFilter: [],
      authSubFilter: [],
      lkpSubFilter: [],

      selectAll: false,
      itemList: [],
      itemSelected: [],

      userId: '',
      username: '',
      menu: '',
      addMode: '',
      search: '',
      authFor: '',
      display: 'users',
      loading: false
    };
  },

  mounted() {

  },

  computed: {
    menuListDis() {
      if (this.itemSelected.length == 0) {
        return 'disabled';
      } else {
        return '';
      }
    }
  },

  methods: {
    async onLoad() {
      this.loading = true;

      const user = await this.getUsers();
      const menus = await axios.get('api/auth/code-menu', { headers: { Authorization: 'Bearer ' + this.authStore.getToken } });
      this.lkpMenu = menus.data;

      const subs = await axios.get('api/auth/code-submenu', { headers: { Authorization: 'Bearer ' + this.authStore.getToken } });
      this.lkpSub = subs.data;

      const autMenus = await this.getAuthMenu();
      const autSubs = await this.getAuthSub();

      this.loading = false;
    },

    async getUsers(page) {
      try {
        const users = await axios.get(`api/auth/users?page=${page}&search=${this.search}`, { headers: { Authorization: 'Bearer ' + this.authStore.getToken } });
        this.userData = users.data;
      } catch (error) {
        console.log(error);
        if (error.response.status == 401) {
          this.authStore.removeToken();
          this.authStore.removeUser();
          localStorage.removeItem('token');
          localStorage.removeItem('user');
          this.$router.push('/login');
        }
      }
    },

    async getAuthMenu() {
      const autMenu = await axios.get('api/auth/auth-menu', { headers: { Authorization: 'Bearer ' + this.authStore.getToken } });
      this.authMenuData = autMenu.data;
    },

    async getAuthSub() {
      const autSub = await axios.get('api/auth/auth-submenu', { headers: { Authorization: 'Bearer ' + this.authStore.getToken } });
      this.authSubData = autSub.data;
    },

    selectAllItems() {
      this.itemSelected = [];
      if (!this.selectAll) {
        for (let i in this.itemList) {
          this.itemSelected.push(this.itemList[i].value);
        }
      }
    },

    async userSelected(user, id) {
      this.display = 'auth';
      this.username = user;
      this.authMenuFilter = [];
      this.authSubFilter = [];
      this.userId = id;
      this.menu = '';

      let items = this.authMenuData.filter((i) => i.user_id == id);
      items.forEach((e) => {
        this.authMenuFilter.push({
          menu: e.menu,
          name: e.name,
          acc: !!parseInt(e.acc)
        })
      })

      let name = this.userData.data.find((e) => e.id == id);
      this.authFor = name.name + ' ' + name.surname
    },

    menuListOpen() {
      this.addMode = 'menu';
      this.selectAll = false;
      this.itemSelected = [];
      this.itemList = [];

      //get menu list to compare
      let tmp = [];
      this.authMenuFilter.forEach((e) => {
        tmp.push({
          value: e.menu,
          name: e.name
        })
      });

      function filterUniqueObjects(objectArray, compareArray) {
        const uniqueValues = new Set(compareArray.map(obj => JSON.stringify(obj)));
        return objectArray.filter(object => !uniqueValues.has(JSON.stringify(object)));
      };

      const filteredObjects = filterUniqueObjects(this.lkpMenu, tmp);
      filteredObjects.forEach(e => {
        this.itemList.push({
          value: e.value,
          name: e.name
        });
      });
      $('#modal-item-list').modal('show');
    },


    addMenu() {
      $('#modal-item-list').modal('hide');
      this.itemSelected.forEach((e) => {
        let n = this.lkpMenu.find((i) => i.value == e); //get menu name from lookup code
        this.authMenuFilter.push({
          menu: e,
          name: n.name,
          acc: true
        })
      })

      // save into sql database
      axios.post('api/auth/add-auth-menu', {
        user_id: this.userId,
        menuList: this.itemSelected
      }, { headers: { Authorization: 'Bearer ' + this.authStore.getToken } }).then((response) => {
        this.getAuthMenu();
      }).catch((error) => {
        console.log(error);
      });
    },

    updateMenu(menu) {
      let item = this.authMenuFilter.find(i => i.menu == menu);
      axios.post('api/auth/upd-auth-menu', {
        user_id: this.userId,
        menu: item.menu,
        acc: item.acc
      }, { headers: { Authorization: 'Bearer ' + this.authStore.getToken } }).then((response) => {
        this.getAuthMenu();
      }).catch((error) => {
        console.log(error);
      });
    },

    async menuSelected(index, menu) {
      const elements = document.querySelectorAll('.filter-list, .active');
      elements.forEach(e => {
        e.classList.remove('active');
      })
      document.getElementById(index).classList.add('active');

      this.menu = menu;
      this.authSubFilter = [];

      let item = this.authSubData.filter((i) => i.user_id == this.userId && i.menu == menu);
      item.forEach((e) => {
        this.authSubFilter.push({
          menu: e.menu,
          sub: e.sub,
          name: e.name,
          acc: !!parseInt(e.acc),
          new: !!parseInt(e.new),
          edit: !!parseInt(e.edit),
          del: !!parseInt(e.del)
        })
      })

      //get the submenu to compare
      this.lkpSubFilter = [];
      let lkpSub = this.lkpSub.filter((i) => i.menu == menu);
      lkpSub.forEach((e) => {
        this.lkpSubFilter.push({
          value: e.sub,
          name: e.name
        })
      })
    },

    subListOpen() {
      this.addMode = 'sub';
      this.selectAll = false;
      this.itemSelected = [];
      this.itemList = [];

      let tmp = [];
      this.authSubFilter.forEach((e) => {
        tmp.push({
          value: e.sub,
          name: e.name
        })
      })

      function filterUniqueObjects(objectArray, compareArray) {
        const uniqueValues = new Set(compareArray.map(obj => JSON.stringify(obj))); // Create set of stringified objects for efficient lookups
        return objectArray.filter(object => !uniqueValues.has(JSON.stringify(object)));
      }
      const filteredObjects = filterUniqueObjects(this.lkpSubFilter, tmp);
      filteredObjects.forEach(e => {
        this.itemList.push({
          value: e.value,
          name: e.name
        })
      })
      $('#modal-item-list').modal('show');
    },

    addSubmenu() {
      $('#modal-item-list').modal('hide');
      this.itemSelected.forEach((e) => {

        let n = this.lkpSub.find((i) => i.sub == e); //get menu name from lookup code
        this.authSubFilter.push({
          menu: n.menu,
          sub: e,
          name: n.name,
          acc: true,
          new: false,
          edit: false,
          del: false
        })
      })

      // save into sql database
      axios.post('api/auth/add-auth-submenu', {
        user_id: this.userId,
        subList: this.authSubFilter
      }, { headers: { Authorization: 'Bearer ' + this.authStore.getToken } }).then((response) => {
        this.getAuthSub();
      }).catch((error) => {
        console.log(error);
      });
    },

    updateSub(sub) {
      let item = this.authSubFilter.find((i) => i.sub == sub);
      axios.post('/api/auth/upd-auth-submenu', {
        user_id: this.userId,
        menu: item.menu,
        sub: item.sub,
        acc: item.acc,
        new: item.new,
        edit: item.edit,
        del: item.del
      }, { headers: { Authorization: 'Bearer ' + this.authStore.getToken } }).then((response) => {
        this.getAuthSub();
      }).catch((error) => {
        console.log(error);
      });
    },

    async onSearch() {
      if (this.search.length > 0) {
        const user = await this.getUsers();
        document.getElementById('search-close').classList.remove('d-none');
      } else {
        this.getUsers();
        document.getElementById('search-close').classList.add('d-none');
      }
    },

    async searchClear() {
      this.search = '';
      const user = await this.getUsers();
      document.getElementById('search-close').classList.add('d-none');
    },

    avatarText(n, s) {
      if (s) {
        return n.substring(0, 1) + s.substring(0, 1);
      } else {
        return n.substring(0, 2);
      }
    },
  },

  created() {
    this.onLoad();
  },
};
</script>