<template>
  <div>
    <div class="chat-wrapper d-lg-flex gap-1 mx-n4 mt-n4 p-1">
      <div class="chat-leftsidebar minimal-border">
        <div class="px-3 pt-3 pb-3 mb-0">
          <div class="d-flex align-items-center">
            <div class="flex-grow-1 overflow-hidden">
              <h5 class="mb-0 mt-1 text-truncate">Categories</h5>
            </div>
            <div style="height: 27.063px">
              <div class="flex-shrink-0">
                <!-- <button type="button" class="btn btn-soft-success btn-sm material-shadow-none">
                  <i class="ri-add-line align-bottom"></i>
                </button> -->
              </div>
            </div>
          </div>
          <form class="app-search d-md-block pt-4 mt-1 pb-0 ps-0">
            <div class="position-relative">
              <input
                type="text"
                class="form-control bg-light border-0"
                placeholder="Search here..."
                v-model="search"
                @input="onSearch"
              />
              <span
                class="ri-search-line search-icon search-widget-icon fs-14"
              ></span>
              <span
                class="mdi mdi-close-circle search-widget-icon search-widget-icon-close cursor-pointer d-none"
                id="search-close"
                @click="searchClear"
              ></span>
            </div>
          </form>
        </div>

        <div
          class="chat-room-list simplebar-scrollable-y"
          data-simplebar="init"
        >
          <div class="simplebar-wrapper" style="margin: -16px 0px 0px">
            <div class="simplebar-height-auto-observer-wrapper">
              <div class="simplebar-height-auto-observer"></div>
            </div>
            <div class="simplebar-mask">
              <div class="simplebar-offset" style="right: 0px; bottom: 0px">
                <div
                  class="simplebar-content-wrapper"
                  tabindex="0"
                  role="region"
                  aria-label="scrollable content"
                  style="height: auto; overflow: hidden scroll"
                >
                  <div class="simplebar-content" style="padding: 0px 0px 0px">
                    <div class="chat-message-list">
                      <ul class="list-unstyled chat-list chat-user-list">
                        <li
                          v-for="(item, index) in categoryList"
                          :key="index"
                          @click="selectCategory(item.category, index)"
                          :id="'category-' + index"
                        >
                          <a href="javascript: void(0)" class="py-2">
                            <div class="d-flex align-items-center">
                              <!-- <div class="flex-shrink-0 chat-user-img align-self-center me-2 ms-0">
                                <div class="avatar-xxs">
                                  <div class="avatar-title bg-light rounded-circle text-body">#</div>
                                </div>
                              </div> -->
                              <div class="flex-grow-1 overflow-hidden">
                                <p class="text-truncate mb-0 fs-13">
                                  {{ item.category }}
                                </p>
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
            <div
              class="simplebar-placeholder"
              style="width: 300px; height: calc(100vh - 18rem)"
            ></div>
          </div>
        </div>
      </div>

      <div
        class="user-chat w-100 overflow-hidden minimal-border user-chat-show"
        id="code-detail"
      >
        <!-- <div class="user-chat w-100 overflow-hidden minimal-border"> -->
        <div class="chat-content d-lg-flex">
          <div class="w-100 overflow-hidden position-relative">
            <div class="position-relative">
              <div
                class="position-relative"
                id="channel-chat"
                style="display: block"
              >
                <div class="p-3 user-chat-topbar">
                  <div class="row align-items-center">
                    <div class="col-sm-4 col-8">
                      <div class="d-flex align-items-center">
                        <div
                          class="flex-shrink-0 d-block d-lg-none me-3"
                          @click="backToMain"
                        >
                          <a
                            href="javascript: void(0);"
                            class="user-chat-remove fs-18 p-1"
                            ><i class="ri-arrow-left-s-line align-bottom"></i
                          ></a>
                        </div>
                        <div class="flex-grow-1 overflow-hidden">
                          <div class="d-flex align-items-center">
                            <!-- <div class="flex-shrink-0 chat-user-img online user-own-img align-self-center me-3 ms-0">
                              <img src="/public/assets/images/users/multi-user.jpg" class="rounded-circle avatar-xs" alt="">
                            </div> -->
                            <div class="flex-grow-1 overflow-hidden">
                              <h5
                                class="text-truncate mb-0 fs-16"
                                id="code-title"
                              >
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
                          <div
                            v-if="codeForm.category !== 'Medicines'"
                            class="d-flex gap-sm-0 email-topbar-link"
                          >
                            <button
                              type="button"
                              class="btn btn-ghost-secondary btn-icon material-shadow-none"
                              title="Add new code"
                              @click="newCode"
                            >
                              <i
                                class="bx bx-plus-circle align-bottom fs-18"
                              ></i>
                            </button>
                            <button
                              type="button"
                              class="btn btn-ghost-secondary btn-icon material-shadow-none"
                              title="Edit code"
                              @click="editCode"
                            >
                              <i class="bx bx-edit align-bottom fs-18"></i>
                            </button>
                            <button
                              type="button"
                              class="btn btn-ghost-secondary btn-icon material-shadow-none"
                              title="Delete code"
                              @click="deleteCode"
                            >
                              <i class="bx bx-trash align-bottom fs-18"></i>
                            </button>
                          </div>
                          <div
                            v-if="codeForm.category === 'Medicines'"
                            class="d-flex gap-sm-0 email-topbar-link"
                          >
                            <button
                              type="button"
                              class="btn btn-ghost-secondary btn-icon material-shadow-none"
                              title="Add new medicine"
                              @click="newMedicine"
                            >
                              <i
                                class="bx bx-plus-circle align-bottom fs-18"
                              ></i>
                            </button>
                            <button
                              type="button"
                              class="btn btn-ghost-secondary btn-icon material-shadow-none"
                              title="Edit medicine"
                              @click="editMedicine"
                            >
                              <i class="bx bx-edit align-bottom fs-18"></i>
                            </button>
                            <button
                              type="button"
                              class="btn btn-ghost-secondary btn-icon material-shadow-none"
                              title="Delete medicine"
                              @click="deleteMedicine"
                            >
                              <i class="bx bx-trash align-bottom fs-18"></i>
                            </button>
                          </div>
                        </li>
                      </ul>
                    </div>
                  </div>
                </div>

                <div
                  v-if="codeForm.category !== 'Medicines'"
                  class="chat-conversation d-block px-3 px-lg-3 mt-lg-0"
                  style="margin-top: 12px"
                >
                  <div class="custom-grid">
                    <ag-grid-vue
                      style="height: calc(100vh - 14.2rem)"
                      class="ag-theme-quartz"
                      :columnDefs="columnDefs"
                      :rowData="codeFilter"
                      :defaultColDef="defaultColDef"
                      :suppressMenuHide="false"
                      :suppressCellFocus="true"
                      animateRows="false"
                      rowSelection="single"
                      @rowClicked="cellCicked"
                      @cell-double-clicked="editCode"
                    ></ag-grid-vue>
                  </div>
                </div>
                <div
                  v-if="codeForm.category === 'Medicines'"
                  class="chat-conversation d-block px-3 px-lg-3 mt-lg-0"
                  style="margin-top: 12px"
                >
                  <div class="custom-grid">
                    <ag-grid-vue
                      style="height: calc(100vh - 14.2rem)"
                      class="ag-theme-quartz"
                      :columnDefs="columnMedicines"
                      :rowData="medicines"
                      :defaultColDef="defaultColDef"
                      :rowHeight="36"
                      :headerHeight="44"
                      :suppressMenuHide="false"
                      :suppressCellFocus="true"
                      animateRows="false"
                      rowSelection="single"
                      @rowClicked="cellCicked2"
                      @cell-double-clicked="editMedicine"
                    ></ag-grid-vue>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Add Code modal -->
    <div
      class="modal fade zoomIn"
      id="code-modal"
      data-bs-keyboard="false"
      tabindex="-1"
      aria-modal="true"
      role="dialog"
      aria-hidden="true"
    >
      <div class="modal-dialog modal-dialog-centered modal-md" role="document">
        <div class="modal-content">
          <div class="modal-header bg-light p-3">
            <h5 v-if="actMode === 'add'" class="modal-title">
              Add {{ codeForm.category }}
            </h5>
            <h5 v-if="actMode === 'edit'" class="modal-title">
              Edit {{ codeForm.category }}
            </h5>
            <button
              type="button"
              class="btn-close"
              data-bs-dismiss="modal"
              aria-label="Close"
              id="close-modal"
            ></button>
          </div>
          <div class="modal-body">
            <div class="mb-3">
              <label class="form-label"
                >Code <span class="text-danger">*</span></label
              >
              <input
                type="text"
                class="form-control"
                placeholder="Enter code"
                v-model="codeForm.code"
              />
            </div>
            <div class="mb-3">
              <label class="form-label"
                >Description Eng <span class="text-danger">*</span></label
              >
              <input
                type="text"
                class="form-control"
                placeholder="Enter description english"
                v-model="codeForm.descr_eng"
              />
            </div>
            <div class="mb-3">
              <label class="form-label"
                >Description Lao <span class="text-danger">*</span></label
              >
              <input
                type="text"
                class="form-control"
                placeholder="Enter description lao"
                v-model="codeForm.descr_lao"
              />
            </div>
            <div>
              <label class="form-label"
                >Active <span class="text-danger">*</span></label
              >
              <multiselect
                placeholder="Enter phone no."
                v-model="codeForm.active"
                :options="lkActive"
              />
            </div>
          </div>
          <div class="modal-footer" style="display: block">
            <div class="hstack gap-2 justify-content-end">
              <button
                type="button"
                class="btn btn-light"
                data-bs-dismiss="modal"
              >
                Cancel
              </button>
              <button
                v-if="actMode === 'add'"
                type="button"
                class="btn btn-success"
                :class="codeFormDis"
                @click="addCode"
              >
                Add Code
              </button>
              <button
                v-if="actMode === 'edit'"
                type="button"
                class="btn btn-success"
                :class="codeFormDis"
                @click="updateCode"
              >
                Save Change
              </button>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Medicines Modal -->
    <div
      class="modal fade zoomIn"
      id="medicine-modal"
      data-bs-keyboard="false"
      tabindex="-1"
      aria-modal="true"
      role="dialog"
      aria-hidden="true"
    >
      <div class="modal-dialog modal-dialog-centered modal-md" role="document">
        <div class="modal-content">
          <div class="modal-header bg-light p-3">
            <h5 v-if="actMode === 'add'" class="modal-title">
              Add {{ codeForm.category }}
            </h5>
            <h5 v-if="actMode === 'edit'" class="modal-title">
              Edit {{ codeForm.category }}
            </h5>
            <button
              type="button"
              class="btn-close"
              data-bs-dismiss="modal"
              aria-label="Close"
              id="close-modal"
            ></button>
          </div>
          <div class="modal-body">
            <div class="mb-3">
              <label class="form-label"
                >Medicine Name <span class="text-danger">*</span></label
              >
              <input
                type="text"
                class="form-control"
                placeholder="Enter medicine name"
                v-model="medicineForm.medicine_eng"
              />
            </div>
            <div class="mb-3">
              <label class="form-label"
                >ຊື່ຢາ <span class="text-danger">*</span></label
              >
              <input
                type="text"
                class="form-control"
                placeholder="ປ້ອນຊື່ຢາພາສາລາວ"
                v-model="medicineForm.medicine_lao"
              />
            </div>
            <div class="row g-3">
              <div class="col-lg-4 mb-3">
                <label class="form-label"
                  >Unit <span class="text-danger">*</span></label
                >
                <multiselect
                  :searchable="true"
                  :searchStart="false"
                  placeholder="Select unit"
                  v-model="medicineForm.unit_id"
                  :options="lkUnit"
                />
              </div>
              <div class="col-lg-4 mb-3">
                <label class="form-label">Unit Price </label>
                <input
                  type="number"
                  class="form-control"
                  placeholder="Unit price"
                  v-model="medicineForm.unit_price"
                />
              </div>
              <div class="col-lg-4 mb-3">
                <label class="form-label">Remind Number </label>
                <input
                  type="number"
                  class="form-control"
                  placeholder="Reminder"
                  v-model="medicineForm.min_remind"
                />
              </div>
            </div>
            <div class="mb-0">
              <label class="form-label"
                >Description <span class="text-danger">*</span></label
              >
              <textarea
                class="form-control"
                rows="3"
                placeholder="Enter description"
                v-model="medicineForm.descr"
              ></textarea>
            </div>
          </div>
          <div class="modal-footer" style="display: block">
            <div class="hstack gap-2 justify-content-end">
              <button
                type="button"
                class="btn btn-light"
                data-bs-dismiss="modal"
              >
                Cancel
              </button>
              <button
                v-if="actMode === 'add'"
                type="button"
                class="btn btn-success"
                :class="medicineFormDis"
                @click="addMedicine"
              >
                Add Medicine
              </button>
              <button
                v-if="actMode === 'edit'"
                type="button"
                class="btn btn-success"
                :class="medicineFormDis"
                @click="updateMedicine"
              >
                Save Change
              </button>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Delete Modal -->
    <div
      class="modal fade zoomIn"
      id="delete-modal"
      data-bs-keyboard="false"
      tabindex="-1"
      aria-modal="true"
      role="dialog"
      aria-hidden="true"
    >
      <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
          <div class="modal-body text-center p-5">
            <lord-icon
              src="https://cdn.lordicon.com/gsqxdxog.json"
              trigger="loop"
              colors="primary:#405189,secondary:#f06548"
              style="width: 90px; height: 90px"
            ></lord-icon>
            <div class="text-center">
              <h4 class="fs-semibold">You are about to delete a record ?</h4>
              <p class="text-muted fs-14 mb-4 pt-1">
                Deleting your record will remove all of your information from
                our database.
              </p>
              <div class="hstack gap-2 justify-content-center remove">
                <button class="btn btn-light" data-bs-dismiss="modal">
                  Cancel
                </button>
                <button class="btn btn-soft-danger" @click="confirmDelete">
                  Yes, Delete It
                </button>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import axios from "axios";
import { AgGridVue } from "ag-grid-vue3";
import { useAuthStore } from "../stores/auth.js";
import { useToastr } from "../toastr.js";
const toastr = useToastr();

export default {
  name: "XpplAppClinicCode",
  components: { AgGridVue },
  setup() {
    return { authStore: useAuthStore() };
  },

  data() {
    return {
      columnDefs: [
        {
          headerName: "Code ID",
          field: "code_id",
          minWidth: 80,
          maxWidth: 100,
          hide: true,
        },
        { headerName: "Category", field: "category", hide: true },
        { headerName: "Code", field: "code", filter: "agSetColumnFilter" },
        {
          headerName: "Description",
          field: "descr_eng",
          filter: "agSetColumnFilter",
        },
        {
          headerName: "ຄຳອະທິບາຍ",
          field: "descr_lao",
          filter: "agSetColumnFilter",
        },
        {
          headerName: "Use",
          field: "active",
          maxWidth: 100,
          filter: "agSetColumnFilter",
          cellRenderer: (p) => (p.value ? "Yes" : "No"),
        },
        {
          headerName: "Created at",
          field: "created_at",
          maxWidth: 150,
          valueFormatter: (p) =>
            p.value ? moment(p.value).format("DD-MM-YYYY HH:mm:ss") : "",
        },
        {
          headerName: "Created by",
          field: "created_by",
          maxWidth: 150,
          filter: "agSetColumnFilter",
        },
        {
          headerName: "Updated at",
          field: "updated_at",
          maxWidth: 150,
          hide: true,
          valueFormatter: (p) =>
            p.value ? moment(p.value).format("DD-MM-YYYY HH:mm:ss") : "",
        },
        {
          headerName: "Updated by",
          field: "updated_by",
          maxWidth: 150,
          hide: true,
          filter: "agSetColumnFilter",
        },
      ],

      columnMedicines: [
        {
          headerName: "Medicine ID",
          field: "medicine_id",
          minWidth: 80,
          maxWidth: 100,
          hide: true,
        },
        {
          headerName: "Medicine Name",
          field: "medicine_eng",
          minWidth: 300,
          filter: "agSetColumnFilter",
        },
        {
          headerName: "ຊື່ລາຍການຢາ",
          field: "medicine_lao",
          minWidth: 200,
          filter: "agSetColumnFilter",
        },
        {
          headerName: "Description",
          field: "descr",
          minWidth: 200,
          filter: "agSetColumnFilter",
        },
        { headerName: "Unit ID", field: "unit_id", hide: true },
        { headerName: "Unit", field: "unit_eng", filter: "agSetColumnFilter" },
        {
          headerName: "ຫົວໜ່ວຍ",
          field: "unit_lao",
          filter: "agSetColumnFilter",
        },
        {
          headerName: "Unit Price (Kip)",
          field: "unit_price",
          minWidth: 80,
          filter: "agNumberColumnFilter",
          valueGetter: (p) => Number(p.data.unit_price),
          valueFormatter: (p) =>
            p.value
              ? p.value.toLocaleString("en-US", {
                  minimumFractionDigits: 0,
                  maximumFractionDigits: 0,
                })
              : "",
        },
        {
          headerName: "Min Remind",
          field: "min_remind",
          minWidth: 80,
          filter: "agNumberColumnFilter",
          valueGetter: (p) => Number(p.data.min_remind),
          valueFormatter: (p) =>
            p.value
              ? p.value.toLocaleString("en-US", {
                  minimumFractionDigits: 0,
                  maximumFractionDigits: 0,
                })
              : "",
        },
        {
          headerName: "Created at",
          field: "created_at",
          maxWidth: 150,
          hide: false,
          valueFormatter: (p) =>
            p.value ? moment(p.value).format("DD-MM-YYYY HH:mm:ss") : "",
        },
        {
          headerName: "Created by",
          field: "created_by",
          maxWidth: 150,
          hide: false,
          filter: "agSetColumnFilter",
        },
        {
          headerName: "Updated at",
          field: "updated_at",
          maxWidth: 150,
          hide: true,
          valueFormatter: (p) =>
            p.value ? moment(p.value).format("DD-MM-YYYY HH:mm:ss") : "",
        },
        {
          headerName: "Updated by",
          field: "updated_by",
          maxWidth: 150,
          hide: true,
          filter: "agSetColumnFilter",
        },
      ],

      defaultColDef: {
        sortable: true,
        resizable: true,
        flex: 1,
        filterParams: { buttons: ["reset"] },
        minWidth: 120,
      },

      lkActive: [
        { value: 1, label: "Yes" },
        { value: 0, label: "No" },
      ],
      auth: [],
      categories: [],
      codes: [],
      codeFilter: [],
      medicines: [],
      lkUnit: [],

      codeForm: {
        code_id: "",
        category: "",
        code: "",
        code_old: "",
        descr_eng: "",
        descr_lao: "",
        active: 1,
        tbl_name: "",
        col_name: "",
      },
      medicineForm: {
        medicine_id: "",
        medicine_eng: "",
        medicine_lao: "",
        descr: "",
        unit_id: null,
        unit_eng: "",
        unit_lao: "",
        unit_price: "",
        min_remind: "",
      },

      search: "",
      actMode: "",
    };
  },

  mounted() {},

  computed: {
    categoryList() {
      const searchTerm = this.search.trim().toLowerCase();
      return searchTerm
        ? this.categories.filter((e) =>
            e.category.toLowerCase().startsWith(searchTerm)
          )
        : this.categories;
    },

    codeFormDis() {
      return this.codeForm.code &&
        this.codeForm.descr_eng &&
        this.codeForm.descr_lao &&
        this.codeForm.active !== null
        ? ""
        : "disabled";
    },

    medicineFormDis() {
      return this.medicineForm.medicine_eng &&
        this.medicineForm.medicine_lao &&
        this.medicineForm.unit_id &&
        this.medicineForm.descr
        ? ""
        : "disabled";
    },
  },

  methods: {
    async onLoad() {
      const submenu = "M09S03";
      const authorise = await axios.get(
        `api/auth/auth-action?submenu=${submenu}`,
        { headers: { Authorization: "Bearer " + this.authStore.getToken } }
      );
      this.auth = authorise.data[0];

      await this.getCategories();
      await this.getCodes();
      await this.getMedicines();
      await this.selectCategory("Blood Group", 0);
    },

    async getCategories() {
      const { data } = await axios.get("api/clinic/categories", {
        headers: { Authorization: "Bearer " + this.authStore.getToken },
      });
      this.categories = data;
    },

    async getCodes() {
      const { data } = await axios.get("api/clinic/codes", {
        headers: { Authorization: "Bearer " + this.authStore.getToken },
      });
      this.codes = data;

      this.lkUnit = this.codes
        .filter((e) => e.category === "Unit")
        .map(({ code_id, descr_eng }) => ({
          value: code_id,
          label: descr_eng,
        }));
    },

    async getMedicines() {
      const { data } = await axios.get("api/clinic/medicines", {
        headers: { Authorization: "Bearer " + this.authStore.getToken },
      });
      this.medicines = data;
    },

    async selectCategory(cate, inx) {
      this.codeForm.category = cate;
      this.codeForm.code_id = "";
      this.medicineForm.medicine_id = "";

      document.getElementById("code-detail").classList.add("user-chat-show");
      const elements = document.querySelectorAll('[id^="category-"]');
      elements.forEach((e) => e.classList.remove("active"));
      document.getElementById(`category-${inx}`).classList.add("active");
      document.getElementById("code-title").textContent = cate;
      this.codeFilter = this.codes.filter((e) => e.category === cate);

      const { tbl_name, col_name } = this.categories.find(
        (e) => e.category === cate
      );
      Object.assign(this.codeForm, { tbl_name, col_name });
    },

    newCode() {
      if (this.auth.new == 0)
        return toastr.warning("You're not authorized to add.");
      this.actMode = "add";
      Object.assign(this.codeForm, {
        code_id: "",
        code: "",
        descr_eng: "",
        descr_lao: "",
        active: 1,
      });
      $("#code-modal").modal("show");
    },

    async addCode() {
      try {
        const { data } = await axios.post(
          "api/clinic/add-code",
          this.codeForm,
          { headers: { Authorization: "Bearer " + this.authStore.getToken } }
        );
        if (data.success) {
          await this.getCodes();
          this.codeFilter = this.codes.filter(
            (e) => e.category == this.codeForm.category
          );
          this.codeForm.code_id = "";
          $("#code-modal").modal("hide");
          toastr.success("Successfully!");
        } else {
          toastr.error(data.message);
        }
      } catch (error) {
        console.log(error);
      }
    },

    cellCicked(e) {
      Object.assign(this.codeForm, e.data, { code_old: e.data.code });
    },

    editCode() {
      if (this.auth.edit == 0)
        return toastr.warning("You're not authorized to edit.");
      if (!this.codeForm.code_id) return toastr.info("Select a row to edit.");
      this.actMode = "edit";
      $("#code-modal").modal("show");
    },

    async updateCode() {
      try {
        await axios.post("api/clinic/upd-code", this.codeForm, {
          headers: { Authorization: "Bearer " + this.authStore.getToken },
        });
        await this.getCodes();
        this.codeFilter = this.codes.filter(
          (e) => e.category == this.codeForm.category
        );
        this.codeForm.code_id = "";
        $("#code-modal").modal("hide");
        toastr.success("Successfully!");
      } catch (error) {
        toastr.error("This code already exists in the database.");
      }
    },

    deleteCode() {
      if (this.auth.del == 0)
        return toastr.warning("You're not authorized to delete.");
      if (!this.codeForm.code_id) return toastr.info("Select a row to delete.");
      $("#delete-modal").modal("show");
    },

    async confirmDelete() {
      try {
        const url =
          this.codeForm.category == "Medicines"
            ? "api/clinic/del-medicine"
            : "api/clinic/del-code";
        const data =
          this.codeForm.category == "Medicines"
            ? this.medicineForm
            : this.codeForm;
        await axios.post(url, data, {
          headers: { Authorization: "Bearer " + this.authStore.getToken },
        });

        this.codeForm.category == "Medicines"
          ? await this.getMedicines()
          : await this.getCodes();
        this.codeFilter = this.codes.filter(
          (e) => e.category == this.codeForm.category
        );
        this.codeForm.code_id = "";
        this.medicineForm.medicine_id = "";

        $("#delete-modal").modal("hide");
        toastr.success("Delete successfully.");
      } catch (error) {
        toastr.error(`${error}`);
      }
    },

    newMedicine() {
      if (this.auth.new == 0)
        return toastr.warning("You're not authorized to add.");
      this.actMode = "add";
      Object.assign(this.medicineForm, {
        medicine_eng: "",
        medicine_lao: "",
        descr: "",
        unit_id: null,
        unit_price: "",
        min_remind: "",
      });
      $("#medicine-modal").modal("show");
    },

    async addMedicine() {
      try {
        const { data } = await axios.post(
          "api/clinic/add-medicine",
          this.medicineForm,
          { headers: { Authorization: "Bearer " + this.authStore.getToken } }
        );
        if (data.success) {
          await this.getMedicines();
          this.medicineForm.medicine_id = "";
          $("#medicine-modal").modal("hide");
          toastr.success("Successfully!");
        } else {
          toastr.error(data.message);
        }
      } catch (error) {
        console.log(error);
      }
    },

    cellCicked2(e) {
      Object.assign(this.medicineForm, e.data);
    },

    editMedicine() {
      if (this.auth.edit == 0)
        return toastr.warning("You're not authorized to edit.");
      if (!this.medicineForm.medicine_id)
        return toastr.info("Select a row to edit.");
      this.actMode = "edit";
      $("#medicine-modal").modal("show");
    },

    async updateMedicine() {
      try {
        await axios.post("api/clinic/upd-medicine", this.medicineForm, {
          headers: { Authorization: "Bearer " + this.authStore.getToken },
        });
        await this.getMedicines();
        this.medicineForm.medicine_id = "";
        $("#medicine-modal").modal("hide");
        toastr.success("Successfully!");
      } catch (error) {
        toastr.error("This medicine already exists in the database.");
      }
    },

    deleteMedicine() {
      if (this.auth.del == 0)
        return toastr.warning("You're not authorized to delete.");
      if (!this.medicineForm.medicine_id)
        return toastr.info("Select a row to delete.");
      $("#delete-modal").modal("show");
    },

    onSearch() {
      this.search
        ? document.getElementById("search-close").classList.remove("d-none")
        : document.getElementById("search-close").classList.add("d-none");
    },

    searchClear() {
      this.search = "";
      document.getElementById("search-close").classList.add("d-none");
    },

    backToMain() {
      document.getElementById("code-detail").classList.remove("user-chat-show");
    },
  },

  created() {
    this.onLoad();
  },
};
</script>