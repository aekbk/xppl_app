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

        <form class="app-search d-md-block py-0 ps-0 border-bottom">
          <div class="position-relative">
            <input type="text" class="form-control border-0" placeholder="Search..." v-model="search" @input="onSearch">
            <span class="ri-search-line search-icon search-widget-icon fs-14"></span>
            <span class="mdi mdi-close-circle search-widget-icon search-widget-icon-close cursor-pointer d-none" id="search-close" @click="searchClear"></span>
          </div>
        </form>

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
                        <li v-for="(item, index) in categoryList" :key="index" @click="cateSelected(item.category, index)" :id="'category-' + index">
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
            <div class="simplebar-placeholder" style="width: 300px; height: calc(100vh - 14rem);"></div>
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

    <!-- Add Code Modal -->
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

    <!-- Add Department Modal -->
    <div class="modal fade zoomIn" id="department-modal" data-bs-keyboard="false" tabindex="-1" aria-modal="true" role="dialog" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
          <div class="modal-header bg-light p-3">
            <h5 v-if="actMode == 'add'" class="modal-title">Add {{ codeForm.category }}</h5>
            <h5 v-if="actMode == 'edit'" class="modal-title">Edit {{ codeForm.category }}</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" id="close-modal"></button>
          </div>
          <div class="modal-body">
            <div class="mb-3">
              <label class="form-label">Company <span class="text-danger">*</span></label>
              <multiselect :searchable="true" :searchStart="false" placeholder="Select company" v-model="deptForm.company_id" :options="lkCompany" />
            </div>
            <div class="mb-3">
              <label class="form-label">Department Eng <span class="text-danger">*</span></label>
              <input type="text" class="form-control" placeholder="Enter department in english" v-model="deptForm.department_eng">
            </div>
            <div class="mb-3">
              <label class="form-label">Department Lao <span class="text-danger">*</span></label>
              <input type="text" class="form-control" placeholder="Enter department in lao" v-model="deptForm.department_lao">
            </div>
            <div>
              <label class="form-label">Active <span class="text-danger">*</span></label>
              <multiselect placeholder="Select" v-model="deptForm.active" :options="lkActive" />
            </div>
          </div>
          <div class="modal-footer" style="display: block;">
            <div class="hstack gap-2 justify-content-end">
              <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
              <button v-if="actMode == 'add'" type="button" class="btn btn-success" :class="deptFormDis" @click="addDepartment">Add Department</button>
              <button v-if="actMode == 'edit'" type="button" class="btn btn-success" :class="deptFormDis" @click="updDepartment">Save Change</button>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Add Province Modal -->
    <div class="modal fade zoomIn" id="province-modal" data-bs-keyboard="false" tabindex="-1" aria-modal="true" role="dialog" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
          <div class="modal-header bg-light p-3">
            <h5 v-if="actMode == 'add'" class="modal-title">Add {{ codeForm.category }} s</h5>
            <h5 v-if="actMode == 'edit'" class="modal-title">Edit {{ codeForm.category }}</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" id="close-modal"></button>
          </div>
          <div class="modal-body">
            <div class="mb-3">
              <label class="form-label">Country <span class="text-danger">*</span></label>
              <multiselect :searchable="true" :searchStart="true" placeholder="Select country" v-model="provForm.country_id" :options="lkCountry" />
            </div>
            <div class="mb-3">
              <label class="form-label">Province Eng <span class="text-danger">*</span></label>
              <input type="text" class="form-control" placeholder="Enter province in english" v-model="provForm.province_eng">
            </div>
            <div class="mb-3">
              <label class="form-label">Province Lao <span class="text-danger">*</span></label>
              <input type="text" class="form-control" placeholder="Enter province in lao" v-model="provForm.province_lao">
            </div>
            <div>
              <label class="form-label">Active <span class="text-danger">*</span></label>
              <multiselect placeholder="Select" v-model="provForm.active" :options="lkActive" />
            </div>
          </div>
          <div class="modal-footer" style="display: block;">
            <div class="hstack gap-2 justify-content-end">
              <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
              <button v-if="actMode == 'add'" type="button" class="btn btn-success" :class="provFormDis" @click="addProvince">Add Province</button>
              <button v-if="actMode == 'edit'" type="button" class="btn btn-success" :class="provFormDis" @click="updProvince">Save Change</button>
            </div>
          </div>
        </div>
      </div>


    </div>

    <!-- Add District Modal -->
    <div class="modal fade zoomIn" id="district-modal" data-bs-keyboard="false" tabindex="-1" aria-modal="true" role="dialog" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
          <div class="modal-header bg-light p-3">
            <h5 v-if="actMode == 'add'" class="modal-title">Add {{ codeForm.category }}</h5>
            <h5 v-if="actMode == 'edit'" class="modal-title">Edit {{ codeForm.category }}</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" id="close-modal"></button>
          </div>
          <div class="modal-body">
            <div class="mb-3">
              <label class="form-label">Country <span class="text-danger">*</span></label>
              <multiselect :searchable="true" :searchStart="true" placeholder="Select country" v-model="distForm.country_id" :options="lkCountry" @select="getLKProvince" />
            </div>
            <div class="mb-3">
              <label class="form-label">Province <span class="text-danger">*</span></label>
              <multiselect :searchable="true" :searchStart="false" placeholder="Select province" v-model="distForm.province_id" :options="lkProvince" />
            </div>
            <div class="mb-3">
              <label class="form-label">District Eng <span class="text-danger">*</span></label>
              <input type="text" class="form-control" placeholder="Enter district in english" v-model="distForm.district_eng">
            </div>
            <div class="mb-3">
              <label class="form-label">District Lao <span class="text-danger">*</span></label>
              <input type="text" class="form-control" placeholder="Enter district in lao" v-model="distForm.district_lao">
            </div>
            <div>
              <label class="form-label">Active <span class="text-danger">*</span></label>
              <multiselect placeholder="Select" v-model="distForm.active" :options="lkActive" />
            </div>
          </div>
          <div class="modal-footer" style="display: block;">
            <div class="hstack gap-2 justify-content-end">
              <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
              <button v-if="actMode == 'add'" type="button" class="btn btn-success" :class="distFormDis" @click="addDistrict">Add District</button>
              <button v-if="actMode == 'edit'" type="button" class="btn btn-success" :class="distFormDis" @click="updDistrict">Save Change</button>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Add Village Modal -->
    <div class="modal fade zoomIn" id="village-modal" data-bs-keyboard="false" tabindex="-1" aria-modal="true" role="dialog" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
          <div class="modal-header bg-light p-3">
            <h5 v-if="actMode == 'add'" class="modal-title">Add {{ codeForm.category }}</h5>
            <h5 v-if="actMode == 'edit'" class="modal-title">Edit {{ codeForm.category }}</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" id="close-modal"></button>
          </div>
          <div class="modal-body">
            <div class="mb-3">
              <label class="form-label">Country <span class="text-danger">*</span></label>
              <multiselect :searchable="true" :searchStart="true" placeholder="Select country" v-model="villForm.country_id" :options="lkCountry" @select="getLKProvince" />
            </div>
            <div class="mb-3">
              <label class="form-label">Province <span class="text-danger">*</span></label>
              <multiselect :searchable="true" :searchStart="false" placeholder="Select province" v-model="villForm.province_id" :options="lkProvince" @select="getLKDistrict" />
            </div>
            <div class="mb-3">
              <label class="form-label">District <span class="text-danger">*</span></label>
              <multiselect :searchable="true" :searchStart="false" placeholder="Select district" v-model="villForm.district_id" :options="lkDistrict" />
            </div>
            <div class="mb-3">
              <label class="form-label">Village Eng <span class="text-danger">*</span></label>
              <input type="text" class="form-control" placeholder="Enter village in english" v-model="villForm.village_eng">
            </div>
            <div class="mb-3">
              <label class="form-label">Village Lao <span class="text-danger">*</span></label>
              <input v-if="actMode == 'add'" type="text" class="form-control" placeholder="Enter village in lao" v-model="villForm.village_lao" @keydown.enter="addVillage">
              <input v-if="actMode == 'edit'" type="text" class="form-control" placeholder="Enter village in lao" v-model="villForm.village_lao" @keydown.enter="updVillage">
            </div>
            <div>
              <label class="form-label">Active <span class="text-danger">*</span></label>
              <multiselect placeholder="Select" v-model="villForm.active" :options="lkActive" />
            </div>
          </div>
          <div class="modal-footer" style="display: block;">
            <div class="hstack gap-2 justify-content-end">
              <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
              <button v-if="actMode == 'add'" type="button" class="btn btn-success" :class="villFormDis" @click="addVillage">Add Village</button>
              <button v-if="actMode == 'edit'" type="button" class="btn btn-success" :class="villFormDis" @click="updVillage">Save Change</button>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Room Number Modal -->
    <div class="modal fade zoomIn" id="room-modal" data-bs-keyboard="false" tabindex="-1" aria-modal="true" role="dialog" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
          <div class="modal-header bg-light p-3">
            <h5 v-if="actMode == 'add'" class="modal-title">Add {{ codeForm.category }}</h5>
            <h5 v-if="actMode == 'edit'" class="modal-title">Edit {{ codeForm.category }}</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" id="close-modal"></button>
          </div>
          <div class="modal-body">
            <div class="mb-3">
              <label class="form-label">Camp <span class="text-danger">*</span></label>
              <multiselect :searchable="true" :searchStart="true" placeholder="Select camp" v-model="roomForm.camp_id" :options="lkCamp" />
            </div>
            <div class="mb-3">
              <label class="form-label">Room Number <span class="text-danger">*</span></label>
              <input type="text" class="form-control" placeholder="Enter room number" v-model="roomForm.room_no">
            </div>
            <div class="mb-3">
              <label class="form-label">Room Type <span class="text-danger">*</span></label>
              <multiselect :searchable="true" :searchStart="false" placeholder="Select room type" v-model="roomForm.room_type" :options="lkRoomType" />
            </div>
            <div class="row">
              <div class="mb-3 col-6">
                <label class="form-label">Room Capacity <span class="text-danger">*</span></label>
                <input type="number" class="form-control" placeholder="Enter capacity" v-model="roomForm.capacity">
              </div>
              <div class="mb-3 col-6">
                <label class="form-label">Number of Bed <span class="text-danger">*</span></label>
                <input type="number" class="form-control" placeholder="Enter no of bed" v-model="roomForm.no_bed">
              </div>
            </div>
            <div class="mb-3">
              <label class="form-label">Room Condition <span class="text-danger">*</span></label>
              <multiselect :searchable="true" :searchStart="false" placeholder="Select room type" v-model="roomForm.room_condition" :options="lkRoomCondition" />
            </div>
            <div>
              <label class="form-label">Remarks </label>
              <textarea type="text" class="form-control" placeholder="Enter remarks" v-model="roomForm.remark"></textarea>
            </div>
          </div>
          <div class="modal-footer" style="display: block;">
            <div class="hstack gap-2 justify-content-end">
              <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
              <button v-if="actMode == 'add'" type="button" class="btn btn-success" :class="roomFormDis" @click="addRoom">Add Room</button>
              <button v-if="actMode == 'edit'" type="button" class="btn btn-success" :class="roomFormDis" @click="updRoom">Save Change</button>
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
  name: 'XpplAppEmpCode',
  components: { AgGridVue },
  setup() {
    const authStore = useAuthStore();
    return { authStore };
  },

  data() {
    return {

      columnDefs: [],

      columnGene: [
        { headerName: '#', maxWidth: 50, valueGetter: (params) => { return params.node.rowIndex + 1 } },
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

      columnComp: [
        { headerName: '#', maxWidth: 50, valueGetter: (params) => { return params.node.rowIndex + 1 } },
        { headerName: 'Company ID', field: 'company_id', minWidth: 80, maxWidth: 100, hide: true },
        { headerName: 'Code', field: 'company_code', maxWidth: 100, filter: 'agSetColumnFilter' },
        { headerName: 'Company', field: 'company_eng', filter: 'agSetColumnFilter' },
        { headerName: 'ບໍລິສັດ', field: 'company_lao', filter: 'agSetColumnFilter' },
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

      columnCont: [
        { headerName: '#', maxWidth: 50, valueGetter: (params) => { return params.node.rowIndex + 1 } },
        { headerName: 'Country ID', field: 'country_id', minWidth: 80, maxWidth: 100, hide: true },
        { headerName: 'Code', field: 'country_code', maxWidth: 100, filter: 'agSetColumnFilter' },
        { headerName: 'Country', field: 'country_eng', filter: 'agSetColumnFilter' },
        { headerName: 'ປະເທດ', field: 'country_lao', filter: 'agSetColumnFilter' },
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

      columnDept: [
        { headerName: '#', maxWidth: 50, valueGetter: (params) => { return params.node.rowIndex + 1 } },
        { headerName: 'Dept ID', field: 'department_id', minWidth: 80, maxWidth: 100, hide: true },
        { headerName: 'Company', field: 'company_code', maxWidth: 150, filter: 'agSetColumnFilter' },
        { headerName: 'Company Eng', field: 'company_eng', hide: true, filter: 'agSetColumnFilter' },
        { headerName: 'Department', field: 'department_eng', filter: 'agSetColumnFilter' },
        { headerName: 'ພະແນກ', field: 'department_lao', filter: 'agSetColumnFilter' },
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

      columnProv: [
        { headerName: '#', maxWidth: 50, valueGetter: (params) => { return params.node.rowIndex + 1 } },
        { headerName: 'Province ID', field: 'province_id', minWidth: 80, maxWidth: 100, hide: true },
        { headerName: 'Country', field: 'country_eng', maxWidth: 150, filter: 'agSetColumnFilter' },
        { headerName: 'Province', field: 'province_eng', filter: 'agSetColumnFilter' },
        { headerName: 'ແຂວງ', field: 'province_lao', filter: 'agSetColumnFilter' },
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

      columnDist: [
        { headerName: '#', maxWidth: 50, valueGetter: (params) => { return params.node.rowIndex + 1 } },
        { headerName: 'District ID', field: 'district_id', minWidth: 80, maxWidth: 100, hide: true },
        { headerName: 'Country', field: 'country_eng', maxWidth: 150, filter: 'agSetColumnFilter' },
        { headerName: 'Province', field: 'province_eng', maxWidth: 200, filter: 'agSetColumnFilter' },
        { headerName: 'District', field: 'district_eng', filter: 'agSetColumnFilter' },
        { headerName: 'ເມືອງ', field: 'district_lao', filter: 'agSetColumnFilter' },
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

      columnVill: [
        { headerName: '#', maxWidth: 80, valueGetter: (params) => { return params.node.rowIndex + 1 } },
        { headerName: 'Village ID', field: 'village_id', minWidth: 80, maxWidth: 100, hide: true },
        { headerName: 'Country', field: 'country_eng', maxWidth: 150, filter: 'agSetColumnFilter' },
        { headerName: 'Province', field: 'province_eng', maxWidth: 200, filter: 'agSetColumnFilter' },
        { headerName: 'District', field: 'district_eng', filter: 'agSetColumnFilter' },
        { headerName: 'Village', field: 'village_eng', filter: 'agSetColumnFilter' },
        { headerName: 'ໍບ້ານ', field: 'village_lao', filter: 'agSetColumnFilter' },
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

      columnCamp: [
        { headerName: '#', maxWidth: 50, valueGetter: (params) => { return params.node.rowIndex + 1 } },
        { headerName: 'Code ID', field: 'camp_id', minWidth: 80, maxWidth: 100, hide: true },
        { headerName: 'Code', field: 'camp_code', filter: 'agSetColumnFilter' },
        { headerName: 'Camp', field: 'camp_eng', filter: 'agSetColumnFilter' },
        { headerName: 'ແຄ້ມ', field: 'camp_lao', filter: 'agSetColumnFilter' },
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

      columnRoom: [
        { headerName: '#', maxWidth: 50, valueGetter: (params) => { return params.node.rowIndex + 1 } },
        { headerName: 'Room ID', field: 'room_id', minWidth: 80, maxWidth: 100, hide: true },
        { headerName: 'Camp Code', field: 'camp_code', filter: 'agSetColumnFilter' },
        { headerName: 'Room No.', field: 'room_no', filter: 'agSetColumnFilter' },
        { headerName: 'Room Type', field: 'room_type', filter: 'agSetColumnFilter' },
        { headerName: 'Capacity', field: 'capacity', filter: 'agSetColumnFilter' },
        { headerName: 'No of Bed', field: 'no_bed', filter: 'agSetColumnFilter' },
        { headerName: 'Room Condition', field: 'room_condition', filter: 'agSetColumnFilter' },
        { headerName: 'Remark', field: 'remark', filter: 'agSetColumnFilter' },
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
      },

      auth: [],
      category: [],
      code: [],
      company: [],
      department: [],
      country: [],
      province: [],
      district: [],
      village: [],
      camps: [],
      rooms: [],

      codeFilter: [],
      lkActive: [{ value: 1, label: 'Yes' }, { value: 0, label: 'No' }],

      codeForm: { code_id: '', category: '', code: '', code_ori: '', descr_eng: '', descr_lao: '', active: null, tbl_name: '', col_name: '' },
      deptForm: { department_id: '', company_id: null, department_eng: '', department_lao: '', active: null },
      provForm: { province_id: '', country_id: null, province_eng: '', province_lao: '', active: null },
      distForm: { district_id: '', country_id: null, province_id: null, district_eng: '', district_lao: '', active: null },
      villForm: { village_id: '', country_id: null, province_id: null, district_id: null, village_eng: '', village_lao: '', active: null },
      roomForm: { room_id: '', camp_id: '', room_no: '', room_type: null, capacity: '', no_bed: '', remark: '', room_condition: null },



      lkCompany: [],
      lkCountry: [],
      lkProvince: [],
      lkDistrict: [],
      lkCamp: [],
      lkRoomType: [],
      lkRoomCondition: [],

      search: '',

      actMode: '',
      rowSelect: ''

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

    deptFormDis() {
      if (this.deptForm.company_id == null || this.deptForm.department_eng == '' || this.deptForm.department_lao == '' || this.deptForm.department_lao == null || this.deptForm.active == null) {
        return 'disabled';
      } else {
        return '';
      }
    },

    provFormDis() {
      if (this.provForm.country_id == null || this.provForm.province_eng == '' || this.provForm.province_lao == '' || this.provForm.province_lao == null || this.provForm.active == null) {
        return 'disabled';
      } else {
        return '';
      }
    },

    distFormDis() {
      if (this.distForm.country_id == null || this.distForm.province_id == null || this.distForm.district_eng == '' || this.distForm.district_lao == '' || this.distForm.district_lao == null || this.distForm.active == null) {
        return 'disabled';
      } else {
        return '';
      }
    },

    villFormDis() {
      if (this.villForm.country_id == null || this.villForm.province_id == null || this.villForm.district_id == null || this.villForm.village_eng == '' || this.villForm.village_lao == '' || this.villForm.village_lao == null || this.villForm.active == null) {
        return 'disabled';
      } else {
        return '';
      }
    },

    roomFormDis() {
      if (this.roomForm.camp_id == null || this.roomForm.room_no == '' || this.roomForm.room_type == null || this.roomForm.capacity == '' || this.roomForm.no_bed == '' || this.roomForm.room_condition == null) {
        return 'disabled';
      } else {
        return '';
      }
    },

    categoryList() {
      if (this.search.trim().length > 0) {
        return this.category.filter(e =>
          e.category.substring(0, this.search.trim().length).toLowerCase() == this.search.trim().toLowerCase()
        );
      };
      return this.category;
    },
  },

  methods: {
    async onLoad() {
      const submenu = 'M02S07';
      const authorise = await axios.get(`api/auth/auth-action?submenu=${submenu}`, { headers: { Authorization: 'Bearer ' + this.authStore.getToken } });
      this.auth = authorise.data[0];

      const cate = await axios.get('api/employee/categories', { headers: { Authorization: 'Bearer ' + this.authStore.getToken } });
      this.category = cate.data;

      const code = await this.getCode();
      const select = await this.cateSelected('Account Status', 0);

      const comp = await this.getCompany();
      const dept = await this.getDepartment();
      const cont = await this.getCountry();
      const prov = await this.getProvince();
      const dist = await this.getDistrict();
      const vill = await this.getVillage();
      const camp = await this.getCamp();
      const room = await this.getRoom();

      // console.log(this.department);

    },

    async getCode() {
      const result = await axios.get('api/employee/codes', { headers: { Authorization: 'Bearer ' + this.authStore.getToken } });
      this.code = result.data;

      const category = [
        { cate: 'Room Type', lk: 'lkRoomType', lb: 'descr_eng' },
        { cate: 'Room Condition', lk: 'lkRoomCondition', lb: 'descr_eng' },
      ];
      for (let j = 0; j < category.length; j++) {
        let cateName = category[j].cate;
        let lkName = category[j].lk;
        let labelCol = category[j].lb;

        let item = this.code.filter((e) => e.category == [cateName] && e.active == 1);
        this[lkName] = [];
        for (let i = 0; i < item.length; i++) {
          this[lkName].push({
            value: item[i].code,
            label: item[i][labelCol]
          });
        };
      };
    },

    async getCompany() {
      const comp = await axios.get('/api/employee/company', { headers: { Authorization: 'Bearer ' + this.authStore.getToken } });
      this.company = comp.data;
      this.lkCompany = [];
      this.company.forEach(e => {
        this.lkCompany.push({
          value: e.company_id,
          label: e.company_eng
        })
      })
    },

    async getDepartment() {
      const dept = await axios.get('/api/employee/departments', { headers: { Authorization: 'Bearer ' + this.authStore.getToken } });
      this.department = dept.data;
    },

    async getCountry() {
      const count = await axios.get('/api/employee/country', { headers: { Authorization: 'Bearer ' + this.authStore.getToken } });
      this.country = count.data;
      this.lkCountry = [];
      this.country.forEach(e => {
        this.lkCountry.push({
          value: e.country_id,
          label: e.country_eng
        })
      })
    },

    async getProvince() {
      const prov = await axios.get('/api/employee/provinces', { headers: { Authorization: 'Bearer ' + this.authStore.getToken } });
      this.province = prov.data;
    },

    async getDistrict() {
      const dist = await axios.get('/api/employee/districts', { headers: { Authorization: 'Bearer ' + this.authStore.getToken } });
      this.district = dist.data;
    },

    async getVillage() {
      const vill = await axios.get('/api/employee/villages', { headers: { Authorization: 'Bearer ' + this.authStore.getToken } });
      this.village = vill.data;
    },

    async getCamp() {
      const camp = await axios.get('/api/employee/camps', { headers: { Authorization: 'Bearer ' + this.authStore.getToken } });
      this.camps = camp.data;

      this.camps.forEach(e => {
        this.lkCamp.push({
          value: e.camp_id,
          label: e.camp_code
        });
      });
    },

    async getRoom() {
      const room = await axios.get('/api/employee/rooms', { headers: { Authorization: 'Bearer ' + this.authStore.getToken } });
      this.rooms = room.data;
    },

    async cateSelected(cate, inx) {
      this.codeForm.category = cate;
      this.rowSelect = '';

      document.getElementById('code-detail').classList.add('user-chat-show');
      const elements = document.querySelectorAll('[id^="category-"]');
      elements.forEach((e) => e.classList.remove('active'));

      let indx = 'category-' + inx;
      document.getElementById(indx).classList.add('active')
      document.getElementById('code-title').textContent = cate;

      switch (cate) {
        case 'Company':
          this.columnDefs = this.columnComp;
          this.codeFilter = this.company;
          break;
        case 'Country':
          this.columnDefs = this.columnCont;
          this.codeFilter = this.country;
          break;
        case 'Department':
          this.columnDefs = this.columnDept;
          this.codeFilter = this.department;
          break;
        case 'Province':
          this.columnDefs = this.columnProv;
          this.codeFilter = this.province;
          break;
        case 'District':
          this.columnDefs = this.columnDist;
          this.codeFilter = this.district;
          break;
        case 'Village':
          this.columnDefs = this.columnVill;
          this.codeFilter = this.village;
          break;
        case 'Camp':
          this.columnDefs = this.columnCamp;
          this.codeFilter = this.camps;
          break;
        case 'Room Number':
          this.columnDefs = this.columnRoom;
          this.codeFilter = this.rooms;
          break;
        default:
          this.columnDefs = this.columnGene;
          let items = this.code.filter((e) => e.category == cate);
          this.codeFilter = items;
      }

      let c = this.category.find((e) => e.category == cate);
      this.codeForm.tbl_name = c.tbl_name;
      this.codeForm.col_name = c.col_name;
    },

    newCode() {
      if (this.auth.new == 0) {
        toastr.warning("You're not authorized to add!");
      } else {
        this.actMode = 'add';
        this.rowSelect = ''

        switch (this.codeForm.category) {
          case 'Company': case 'Country': case 'Camp':
            this.codeForm.code = '';
            this.codeForm.descr_eng = '';
            this.codeForm.descr_lao = '';
            this.codeForm.active = 1;
            $('#code-modal').modal('show');
            break;
          case 'Department':
            this.deptForm = {};
            this.deptForm.active = 1;
            $('#department-modal').modal('show');
            break;
          case 'Province':
            this.provForm = {};
            this.provForm.active = 1;
            $('#province-modal').modal('show');
            break;
          case 'District':
            this.distForm = {};
            this.distForm.active = 1;
            $('#district-modal').modal('show');
            break;
          case 'Village':
            this.villForm = {};
            this.villForm.active = 1;
            $('#village-modal').modal('show');
            break;
          case 'Room Number':
            this.roomForm = {};
            $('#room-modal').modal('show');
            break;
          default:
            this.codeForm.code = '';
            this.codeForm.descr_eng = '';
            this.codeForm.descr_lao = '';
            this.codeForm.active = 1;
            $('#code-modal').modal('show');
        }
      }
    },

    async addCode() {
      switch (this.codeForm.category) {
        case 'Company':
          const companies = await axios.post('api/employee/add-company', this.codeForm, { headers: { Authorization: 'Bearer ' + this.authStore.getToken } });
          if (companies.data.success) {
            const code = await this.getCompany();
            this.codeFilter = this.company;
            this.rowSelect = '';
            toastr.success('Add successfully.');
            $('#code-modal').modal('hide');
          } else {
            toastr.error(`${companies.data.message}`);
          };
          break;
        case 'Country':
          const countries = await axios.post('api/employee/add-country', this.codeForm, { headers: { Authorization: 'Bearer ' + this.authStore.getToken } });
          if (countries.data.success) {
            const code = await this.getCountry();
            this.codeFilter = this.country;
            this.rowSelect = '';
            toastr.success('Add successfully.');
            $('#code-modal').modal('hide');
          } else {
            toastr.error(`${countries.data.message}`);
          };
          break;
        case 'Camp':
          const camp = await axios.post('api/employee/add-camp', this.codeForm, { headers: { Authorization: 'Bearer ' + this.authStore.getToken } });
          if (camp.data.success) {
            const code = await this.getCamp();
            this.codeFilter = this.camps;
            this.rowSelect = '';
            toastr.success('Add successfully.');
            $('#code-modal').modal('hide');
          } else {
            toastr.error(`${camp.data.message}`);
          };
          break;
        default:
          const response = await axios.post('api/employee/add-code', this.codeForm, { headers: { Authorization: 'Bearer ' + this.authStore.getToken } });
          if (response.data.success) {
            const code = await this.getCode();
            let item = this.code.filter((e) => e.category == this.codeForm.category);
            this.codeFilter = item;
            this.rowSelect = '';
            toastr.success('Add successfully.');
            $('#code-modal').modal('hide');
          } else {
            toastr.error(`${response.data.message}`);
          };
      };
    },

    cellCicked(e) {
      this.rowSelect = e.rowIndex + 1;
      switch (this.codeForm.category) {
        case 'Company':
          this.codeForm.code_id = e.data.company_id;
          this.codeForm.code = e.data.company_code;
          this.codeForm.code_ori = e.data.company_eng;
          this.codeForm.descr_eng = e.data.company_eng;
          this.codeForm.descr_lao = e.data.company_lao;
          this.codeForm.active = e.data.active;
          break;
        case 'Country':
          this.codeForm.code_id = e.data.country_id;
          this.codeForm.code = e.data.country_code;
          this.codeForm.code_ori = e.data.country_eng;
          this.codeForm.descr_eng = e.data.country_eng;
          this.codeForm.descr_lao = e.data.country_lao;
          this.codeForm.active = e.data.active;
          break;
        case 'Department':
          this.deptForm.department_id = e.data.department_id;
          this.deptForm.company_id = e.data.company_id;
          this.deptForm.department_eng = e.data.department_eng;
          this.deptForm.department_lao = e.data.department_lao;
          this.deptForm.active = e.data.active;
          break;
        case 'Province':
          this.provForm.province_id = e.data.province_id;
          this.provForm.country_id = e.data.country_id;
          this.provForm.province_eng = e.data.province_eng;
          this.provForm.province_lao = e.data.province_lao;
          this.provForm.active = e.data.active;
          break;
        case 'District':
          this.distForm.district_id = e.data.district_id;
          this.distForm.country_id = e.data.country_id;
          this.distForm.province_id = e.data.province_id;
          this.distForm.district_eng = e.data.district_eng;
          this.distForm.district_lao = e.data.district_lao;
          this.distForm.active = e.data.active;
          break;
        case 'Village':
          this.villForm.village_id = e.data.village_id;
          this.villForm.country_id = e.data.country_id;
          this.villForm.province_id = e.data.province_id;
          this.villForm.district_id = e.data.district_id;
          this.villForm.village_eng = e.data.village_eng;
          this.villForm.village_lao = e.data.village_lao;
          this.villForm.active = e.data.active;
          break;
        case 'Camp':
          this.codeForm.code_id = e.data.camp_id;
          this.codeForm.code = e.data.camp_code;
          this.codeForm.code_ori = e.data.camp_code;
          this.codeForm.descr_eng = e.data.camp_eng;
          this.codeForm.descr_lao = e.data.camp_lao;
          this.codeForm.active = e.data.active;
          break;
        case 'Room Number':
          this.roomForm.room_id = e.data.room_id;
          this.roomForm.camp_id = e.data.camp_id;
          this.roomForm.room_no = e.data.room_no;
          this.roomForm.room_type = e.data.room_type;
          this.roomForm.capacity = e.data.capacity;
          this.roomForm.no_bed = e.data.no_bed;
          this.roomForm.room_condition = e.data.room_condition;
          this.roomForm.remark = e.data.remark;
          break;
        default:
          this.rowSelect = e.data.code_id;
          this.codeForm.code_id = e.data.code_id;
          this.codeForm.category = e.data.category;
          this.codeForm.code = e.data.code;
          this.codeForm.code_ori = e.data.code;
          this.codeForm.descr_eng = e.data.descr_eng;
          this.codeForm.descr_lao = e.data.descr_lao;
          this.codeForm.active = e.data.active;
      }
    },

    editCode() {
      if (this.auth.edit == 0) {
        toastr.warning("You're not authorized to edit!");
      } else if (!this.rowSelect) {
        toastr.info("Select a row to edit.");
      } else {
        this.actMode = 'edit';
        switch (this.codeForm.category) {
          case 'Department':
            $('#department-modal').modal('show');
            break;
          case 'Province':
            $('#province-modal').modal('show');
            break;
          case 'District':
            this.getLKProvince();
            $('#district-modal').modal('show');
            break;
          case 'Village':
            this.getLKProvince();
            this.getLKDistrict();
            $('#village-modal').modal('show');
            break;
          case 'Room Number':
            $('#room-modal').modal('show');
            break;
          default:
            $('#code-modal').modal('show');
        };
      };
    },

    async updCode() {
      switch (this.codeForm.category) {
        case 'Company':
          try {
            const res = await axios.post('api/employee/upd-company', this.codeForm, { headers: { Authorization: 'Bearer ' + this.authStore.getToken } });
            const code = await this.getCompany();
            this.codeFilter = this.company;
            this.rowSelect = '';
            toastr.success('Update Successfully.');
            $('#code-modal').modal('hide');
          } catch (error) {
            toastr.error('This code already exists in the database.');
          };
          break;
        case 'Country':
          try {
            const res = await axios.post('api/employee/upd-country', this.codeForm, { headers: { Authorization: 'Bearer ' + this.authStore.getToken } });
            const code = await this.getCountry();
            this.codeFilter = this.country;
            this.rowSelect = '';
            toastr.success('Update Successfully.');
            $('#code-modal').modal('hide');
          } catch (error) {
            toastr.error('This code already exists in the database.');
          };
          break;
        case 'Camp':
          try {
            const response = await axios.post('api/employee/upd-camp', this.codeForm, { headers: { Authorization: 'Bearer ' + this.authStore.getToken } });
            const code = await this.getCamp();
            this.codeFilter = this.camps;
            this.rowSelect = '';
            toastr.success('Update Successfully.');
            $('#code-modal').modal('hide');
          } catch (error) {
            toastr.error('This code already exists in the database.');
          };
          break;
        default:
          try {
            const res = await axios.post('api/employee/upd-code', this.codeForm, { headers: { Authorization: 'Bearer ' + this.authStore.getToken } });
            const code = await this.getCode();
            let item = this.code.filter((e) => e.category == this.codeForm.category);
            this.codeFilter = item;
            this.rowSelect = '';
            toastr.success('Update Successfully.');
            $('#code-modal').modal('hide');
          } catch (error) {
            toastr.error('This code already exists in the database.');
          };
      }
    },

    delCode() {
      if (this.auth.del == 0) {
        toastr.warning("You're not authorized to delete!");
      } else if (!this.rowSelect) {
        toastr.info("Select a row to delete.");
      } else {
        $('#delete-modal').modal('show');
      }
    },

    async delConfirm() {
      switch (this.codeForm.category) {
        case 'Company':
          try {
            const comp = await axios.post('api/employee/del-company', this.codeForm, { headers: { Authorization: 'Bearer ' + this.authStore.getToken } });
            const code = await this.getCompany();
            this.codeFilter = this.company;
            this.rowSelect = '';
            toastr.success('Delete Successfully.');
            $('#delete-modal').modal('hide');
          } catch (error) {
            toastr.error('This code has already been used; it cannot be deleted.');
          };
          break;
        case 'Country':
          try {
            const count = await axios.post('api/employee/del-country', this.codeForm, { headers: { Authorization: 'Bearer ' + this.authStore.getToken } });
            const code = await this.getCountry();
            this.codeFilter = this.country;
            this.rowSelect = '';
            toastr.success('Delete Successfully.');
            $('#delete-modal').modal('hide');
          } catch (error) {
            toastr.error('This code has already been used; it cannot be deleted.');
          };
          break;
        case 'Department':
          try {
            const dept = await axios.post('api/employee/del-department', this.deptForm, { headers: { Authorization: 'Bearer ' + this.authStore.getToken } });
            const code = await this.getDepartment();
            this.codeFilter = this.department;
            this.rowSelect = '';
            toastr.success('Delete Successfully.');
            $('#delete-modal').modal('hide');
          } catch (error) {
            toastr.error('This code has already been used; it cannot be deleted.');
          };
          break;
        case 'Province':
          try {
            const prov = await axios.post('api/employee/del-province', this.provForm, { headers: { Authorization: 'Bearer ' + this.authStore.getToken } });
            const code = await this.getProvince();
            this.codeFilter = this.province;
            this.rowSelect = '';
            toastr.success('Delete Successfully.');
            $('#delete-modal').modal('hide');
          } catch (error) {
            toastr.error('This code has already been used; it cannot be deleted.');
          };
          break;
        case 'District':
          try {
            const response = await axios.post('api/employee/del-district', this.distForm, { headers: { Authorization: 'Bearer ' + this.authStore.getToken } });
            const code = await this.getDistrict();
            this.codeFilter = this.district;
            this.rowSelect = '';
            const vill = await this.getVillage();
            toastr.success('Delete Successfully.');
            $('#delete-modal').modal('hide');
          } catch (error) {
            toastr.error('This code has already been used; it cannot be deleted.');
          };
          break;
        case 'Village':
          try {
            const response = await axios.post('api/employee/del-village', this.villForm, { headers: { Authorization: 'Bearer ' + this.authStore.getToken } });
            const code = await this.getVillage();
            this.codeFilter = this.village;
            this.rowSelect = '';
            toastr.success('Delete Successfully.');
            $('#delete-modal').modal('hide');
          } catch (error) {
            toastr.error('This code has already been used; it cannot be deleted.');
          };
          break;
        case 'Camp':
          try {
            const response = await axios.post('api/employee/del-camp', this.codeForm, { headers: { Authorization: 'Bearer ' + this.authStore.getToken } });
            const code = await this.getCamp();
            this.codeFilter = this.camps;
            this.rowSelect = '';
            toastr.success('Delete Successfully.');
            $('#delete-modal').modal('hide');
          } catch (error) {
            toastr.error('This code has already been used; it cannot be deleted.');
          };
          break;
        case 'Room Number':
          try {
            const response = await axios.post('api/employee/del-room', this.roomForm, { headers: { Authorization: 'Bearer ' + this.authStore.getToken } });
            const code = await this.getRoom();
            this.codeFilter = this.rooms;
            this.rowSelect = '';
            toastr.success('Delete Successfully.');
            $('#delete-modal').modal('hide');
          } catch (error) {
            toastr.error('This code has already been used; it cannot be deleted.');
          };
          break;
        default:
          const response = await axios.post('api/employee/del-code', {
            code_id: this.codeForm.code_id,
            code: this.codeForm.code,
            tbl_name: this.codeForm.tbl_name,
            col_name: this.codeForm.col_name,
          }, { headers: { Authorization: 'Bearer ' + this.authStore.getToken } });
          if (response.data.success) {
            const code = await this.getCode();
            let item = this.code.filter((e) => e.category == this.codeForm.category);
            this.codeFilter = item;
            this.codeForm.code_id = '';
            toastr.success('Delete Successfully.');
            $('#delete-modal').modal('hide');
          } else {
            toastr.error(`${response.data.message}`);
          };
      };
    },

    async addDepartment() {
      const dept = await axios.post('api/employee/add-department', this.deptForm, { headers: { Authorization: 'Bearer ' + this.authStore.getToken } });
      if (dept.data.success) {
        const code = await this.getDepartment();
        this.codeFilter = this.department;
        this.rowSelect = '';
        toastr.success('Add successfully.');
        $('#department-modal').modal('hide');
      } else {
        toastr.error(`${dept.data.message}`);
      };
    },

    async updDepartment() {
      try {
        const dept = await axios.post('api/employee/upd-department', this.deptForm, { headers: { Authorization: 'Bearer ' + this.authStore.getToken } });
        const code = await this.getDepartment();
        this.codeFilter = this.department;
        this.rowSelect = '';
        toastr.success('Update Successfully.');
        $('#department-modal').modal('hide');
      } catch (error) {
        toastr.error('This code already exists in the database.');
      };
    },

    async addProvince() {
      const prov = await axios.post('api/employee/add-province', this.provForm, { headers: { Authorization: 'Bearer ' + this.authStore.getToken } });
      if (prov.data.success) {
        const code = await this.getProvince();
        this.codeFilter = this.province;
        this.rowSelect = '';
        const dist = await this.getDistrict();
        const vill = await this.getVillage();
        toastr.success('Add successfully.');
        $('#province-modal').modal('hide');
      } else {
        toastr.error(`${prov.data.message}`);
      };
    },

    async updProvince() {
      try {
        const prov = await axios.post('api/employee/upd-province', this.provForm, { headers: { Authorization: 'Bearer ' + this.authStore.getToken } });
        const code = await this.getProvince();
        this.codeFilter = this.province;
        this.rowSelect = '';
        const dist = await this.getDistrict();
        const vill = await this.getVillage();
        toastr.success('Update Successfully.');
        $('#province-modal').modal('hide');
      } catch (error) {
        toastr.error('This code already exists in the database.');
      };
    },

    async addDistrict() {
      const response = await axios.post('api/employee/add-district', this.distForm, { headers: { Authorization: 'Bearer ' + this.authStore.getToken } });
      if (response.data.success) {
        const dist = await this.getDistrict();
        this.codeFilter = this.district;
        this.rowSelect = '';
        const vill = await this.getVillage();
        toastr.success('Add successfully.');
        $('#district-modal').modal('hide');
      } else {
        toastr.error(`${response.data.message}`);
      };
    },

    async updDistrict() {
      try {
        const response = await axios.post('api/employee/upd-district', this.distForm, { headers: { Authorization: 'Bearer ' + this.authStore.getToken } });
        const code = await this.getDistrict();
        this.codeFilter = this.district;
        this.rowSelect = '';
        const vill = await this.getVillage();
        toastr.success('Update Successfully.');
        $('#district-modal').modal('hide');
      } catch (error) {
        toastr.error('This code already exists in the database.');
      };
    },

    async addVillage() {
      const response = await axios.post('api/employee/add-village', this.villForm, { headers: { Authorization: 'Bearer ' + this.authStore.getToken } });
      if (response.data.success) {
        const code = await this.getVillage();
        this.codeFilter = this.village;
        this.rowSelect = '';
        toastr.success('Add successfully.');
        $('#village-modal').modal('hide');
      } else {
        toastr.error(`${response.data.message}`);
      };
    },

    async updVillage() {
      try {
        const response = await axios.post('api/employee/upd-village', this.villForm, { headers: { Authorization: 'Bearer ' + this.authStore.getToken } });
        const code = await this.getVillage();
        this.codeFilter = this.village;
        this.rowSelect = '';
        toastr.success('Update Successfully.');
        $('#village-modal').modal('hide');
      } catch (error) {
        toastr.error('This code already exists in the database.');
      };
    },

    async addRoom() {
      const response = await axios.post('api/employee/add-room', this.roomForm, { headers: { Authorization: 'Bearer ' + this.authStore.getToken } });
      if (response.data.success) {
        const code = await this.getRoom();
        this.codeFilter = this.rooms;
        this.rowSelect = '';
        toastr.success('Add successfully.');
        $('#room-modal').modal('hide');
      } else {
        toastr.error(`${response.data.message}`);
      };
    },

    async updRoom() {
      try {
        const response = await axios.post('api/employee/upd-room', this.roomForm, { headers: { Authorization: 'Bearer ' + this.authStore.getToken } });
        const code = await this.getRoom();
        this.codeFilter = this.rooms;
        this.rowSelect = '';
        toastr.success('Update Successfully.');
        $('#room-modal').modal('hide');
      } catch (error) {
        toastr.error('This code already exists in the database.');
      };
    },

    getLKProvince() {
      if (this.codeForm.category === 'District') {
        let items = this.province.filter(e => e.country_id === this.distForm.country_id);
        this.lkProvince = [];
        items.forEach(e => {
          this.lkProvince.push({
            value: e.province_id,
            label: e.province_eng
          });
        });
      } else {
        let items = this.province.filter(e => e.country_id === this.villForm.country_id);
        this.lkProvince = [];
        items.forEach(e => {
          this.lkProvince.push({
            value: e.province_id,
            label: e.province_eng
          });
        });
      };
    },

    getLKDistrict() {
      let items = this.district.filter(e => e.country_id === this.villForm.country_id && e.province_id === this.villForm.province_id);
      this.lkDistrict = [];
      items.forEach(e => {
        this.lkDistrict.push({
          value: e.district_id,
          label: e.district_eng
        });
      });
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

    backToMain() {
      document.getElementById('code-detail').classList.remove('user-chat-show');
    },
  },

  created() {
    this.onLoad();
  }
};
</script>