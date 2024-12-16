<template>
  <div>
    <div class="row">
      <div class="col-12">
        <div
          class="page-title-box d-sm-flex align-items-center justify-content-between bg-galaxy-transparent"
        >
          <h4 class="mb-sm-0" id="starter">Patient Lists</h4>
          <div class="page-title-right">
            <ol class="breadcrumb m-0">
              <li class="breadcrumb-item">
                <a href="javascript: void(0);">Clinic</a>
              </li>
              <li class="breadcrumb-item active">Treatments</li>
            </ol>
          </div>
        </div>
      </div>
    </div>
    <div v-if="loading">
      <loading />
    </div>
    <div v-else>
      <div class="card" v-if="viewMode == 'name-list'">
        <div class="card-header border-0 pb-0">
          <div class="row g-4 align-items-center">
            <div class="col-sm-3">
              <form class="app-search d-md-block py-0 ps-0">
                <div class="position-relative">
                  <input
                    type="text"
                    class="form-control"
                    placeholder="Search..."
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
            <div class="col-sm-auto ms-auto">
              <div class="hstack gap-2">
                <button
                  type="button"
                  class="btn btn-soft-info add-btn"
                  id="create-btn"
                  @click="newPatient"
                >
                  <i class="ri-add-line align-bottom me-1"></i>
                  Add Patient
                </button>
                <button
                  class="btn btn-soft-info btn-icon"
                  type="button"
                  data-bs-toggle="dropdown"
                  aria-expanded="false"
                >
                  <i class="ri-more-2-fill"></i>
                </button>
                <ul
                  class="dropdown-menu dropdown-menu-end dropdownmenu-secondary"
                >
                  <li>
                    <a
                      class="dropdown-item disabled"
                      id="menu-1"
                      href="javascript:void(0);"
                      @click="viewTreatment"
                      ><i class="ri-eye-fill align-bottom me-2 text-muted"></i
                      >Treatments</a
                    >
                  </li>
                  <li>
                    <a
                      class="dropdown-item disabled"
                      id="menu-2"
                      href="javascript:void(0);"
                      @click="editPatient"
                      ><i
                        class="ri-pencil-fill align-bottom me-2 text-muted"
                      ></i
                      >Edit</a
                    >
                  </li>
                  <li>
                    <a
                      class="dropdown-item disabled"
                      id="menu-3"
                      href="javascript:void(0);"
                      @click="deleteRecord('patient')"
                      ><i
                        class="ri-delete-bin-fill align-bottom me-2 text-muted"
                      ></i
                      >Delete</a
                    >
                  </li>
                  <!-- <div class="dropdown-divider"></div> -->
                  <!-- <li><a class="dropdown-item disabled" id="menu-4" href="javascript:void(0);" @click="orderOpen()"><i class="ri-todo-fill align-bottom me-2 text-muted"></i>Orders</a></li> -->
                  <!-- <li><a class="dropdown-item disabled" id="menu-5" href="javascript:void(0);" @click="editAttachment()"><i class="ri-attachment-line align-bottom me-2 text-muted"></i>Attachments</a></li> -->
                </ul>
              </div>
            </div>
          </div>
        </div>

        <div class="custom-grid p-3">
          <ag-grid-vue
            style="height: calc(100vh - 15.5rem)"
            class="ag-theme-quartz"
            :columnDefs="columnDefs"
            :rowData="patientList"
            :defaultColDef="defaultColDef"
            :suppressMenuHide="false"
            :suppressCellFocus="true"
            animateRows="false"
            rowSelection="single"
            @rowClicked="cellCicked"
            @cell-double-clicked="viewTreatment"
          ></ag-grid-vue>
        </div>
      </div>

      <!-- Treatment Details -->
      <div v-if="viewMode == 'detail'">
        <div class="row">
          <div class="col-xxl-3">
            <div class="card card-height-100">
              <div class="card-body pb-0">
                <div class="d-flex align-items-center mb-5">
                  <div class="flex-grow-1">
                    <h5 class="card-title mb-0">Patient Info.</h5>
                  </div>
                  <div class="flex-shrink-0">
                    <button
                      type="button"
                      class="btn btn-soft-success material-shadow-none"
                      @click="backToList"
                    >
                      <i class="ri-arrow-left-s-line me-1 align-bottom"></i>Back
                      to List
                    </button>
                    <!-- <a href="javascript:void(0);" class="badge bg-light text-primary fs-12" @click="viewMode = 'name-list'">
                      <i class="ri-arrow-left-s-line align-bottom me-1"></i>Back to List
                    </a> -->
                  </div>
                </div>
                <!-- <div class="progress animated-progress custom-progress progress-label">
                  <div class="progress-bar bg-danger" role="progressbar" style="width: 30%" aria-valuenow="30" aria-valuemin="0" aria-valuemax="100">
                    <div class="label">3</div>
                  </div>
                </div> -->

                <div class="table-responsive">
                  <table class="table table-borderless mb-0 table-sm">
                    <tbody>
                      <tr>
                        <th class="ps-0 fw-medium" style="width: 100px">
                          Sex :
                        </th>
                        <td class="text-muted">
                          {{ patientForm.sex }}
                        </td>
                      </tr>
                      <tr>
                        <th class="ps-0 fw-medium">Name :</th>
                        <td class="text-muted">
                          {{ patientForm.fullname }}
                        </td>
                      </tr>
                      <tr>
                        <th class="ps-0 fw-medium">Company :</th>
                        <td class="text-muted">
                          {{ patientForm.company }}
                        </td>
                      </tr>
                      <tr>
                        <th class="ps-0 fw-medium">Department :</th>
                        <td class="text-muted">
                          {{ patientForm.department }}
                        </td>
                      </tr>
                      <tr>
                        <th class="ps-0 fw-medium">Position :</th>
                        <td class="text-muted">
                          {{ patientForm.position }}
                        </td>
                      </tr>
                      <tr>
                        <th class="ps-0 fw-medium">Mobile :</th>
                        <td class="text-muted">
                          {{ patientForm.phone }}
                        </td>
                      </tr>
                      <tr>
                        <th class="ps-0 fw-medium">Age :</th>
                        <td class="text-muted">
                          {{ patientForm.age }}
                        </td>
                      </tr>
                      <tr>
                        <th class="ps-0 fw-medium">Blood Group :</th>
                        <td class="text-muted">
                          {{ patientForm.blood_group }}
                        </td>
                      </tr>
                      <tr>
                        <th class="ps-0 fw-medium">Congenital Disease :</th>
                        <td class="text-muted">
                          {{ patientForm.disease }}
                        </td>
                      </tr>
                      <tr>
                        <th class="ps-0 fw-medium">Drug Allergy :</th>
                        <td class="text-muted">
                          {{ patientForm.drug_allergy }}
                        </td>
                      </tr>
                      <tr>
                        <th class="ps-0 fw-medium">Note :</th>
                        <td class="text-muted">
                          {{ patientForm.note }}
                        </td>
                      </tr>
                    </tbody>
                  </table>
                </div>
              </div>

              <!-- <div class="card-body pb-0">
                <div class="d-flex align-items-center mb-4">
                  <div class="flex-grow-1">
                    <h5 class="card-title mb-0">Patient Info.</h5>
                  </div>
                  <div class="flex-shrink-0">
                    <div class="dropdown">
                      <a href="#" role="button" id="dropdownMenuLink2" data-bs-toggle="dropdown" aria-expanded="false" class="">
                        <i class="ri-more-2-fill fs-14"></i>
                      </a>
                      <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownMenuLink2" style="">
                        <li><a class="dropdown-item" href="#">View</a></li>
                        <li><a class="dropdown-item" href="#" @click="editPatient">Edit</a></li>
                        <li><a class="dropdown-item" href="#">Delete</a></li>
                      </ul>
                    </div>
                  </div>
                </div>
              </div> -->

              <!-- <div class="card-body pt-0"> -->
              <!-- <h6 class="text-muted text-uppercase fw-semibold mb-3">Personal Information</h6> -->

              <!-- </div> -->
            </div>
          </div>

          <div class="col-xxl-9">
            <div class="card">
              <!-- <div class="card-header align-items-center d-flex">
                <h4 class="card-title mb-0 flex-grow-1">{{ patientForm.fullname }}</h4>
                <div>
                  <button class="btn btn-soft-info" id="btn-new" @click="newMenusub"><i class="ri-add-fill me-1 align-bottom"></i>Add Submenu</button>
                  <button type="button" class="btn btn-soft-secondary btn-icon material-shadow-none ms-2" @click="newMenusub">
                    <i class="ri-add-line align-bottom"></i>
                  </button>
                </div>
              </div> -->

              <div class="card-header border-0">
                <div class="row g-4 align-items-center">
                  <div class="col-sm-3">
                    <h5 class="card-title mb-0 flex-grow-1">
                      {{ patientForm.fullname }}
                    </h5>
                  </div>
                  <div class="col-sm-auto ms-auto">
                    <div class="hstack gap-2" v-if="activeTab == 'treatment'">
                      <button
                        type="button"
                        class="btn btn-soft-info add-btn"
                        id="create-btn"
                        @click="newTreatment"
                      >
                        <i class="ri-add-line align-bottom me-1"></i>
                        Add Treatment
                      </button>
                      <button
                        class="btn btn-soft-info btn-icon"
                        type="button"
                        data-bs-toggle="dropdown"
                        aria-expanded="false"
                      >
                        <i class="ri-more-2-fill"></i>
                      </button>
                      <ul
                        class="dropdown-menu dropdown-menu-end dropdownmenu-secondary"
                      >
                        <li>
                          <a
                            class="dropdown-item disabled"
                            id="menu-4"
                            href="javascript:void(0);"
                            @click="viewMedication"
                            ><i
                              class="ri-eye-fill align-bottom me-2 text-muted"
                            ></i
                            >Medications</a
                          >
                        </li>
                        <li>
                          <a
                            class="dropdown-item disabled"
                            id="menu-5"
                            href="javascript:void(0);"
                            @click="editTreatment"
                            ><i
                              class="ri-pencil-fill align-bottom me-2 text-muted"
                            ></i
                            >Edit</a
                          >
                        </li>
                        <li>
                          <a
                            class="dropdown-item disabled"
                            id="menu-6"
                            href="javascript:void(0);"
                            @click="deleteRecord('treatment')"
                            ><i
                              class="ri-delete-bin-fill align-bottom me-2 text-muted"
                            ></i
                            >Delete</a
                          >
                        </li>
                      </ul>
                    </div>

                    <div class="hstack gap-2" v-if="activeTab == 'medication'">
                      <button
                        type="button"
                        class="btn btn-soft-info add-btn"
                        id="create-btn"
                        @click="newMedication"
                      >
                        <i class="ri-add-line align-bottom me-1"></i>
                        Add Medication
                      </button>
                      <button
                        class="btn btn-soft-info btn-icon"
                        type="button"
                        data-bs-toggle="dropdown"
                        aria-expanded="false"
                      >
                        <i class="ri-more-2-fill"></i>
                      </button>
                      <ul
                        class="dropdown-menu dropdown-menu-end dropdownmenu-secondary"
                      >
                        <!-- <li><a class="dropdown-item disabled" id="menu-7" href="javascript:void(0);" @click="viewDetail"><i class="ri-eye-fill align-bottom me-2 text-muted"></i>View</a></li> -->
                        <li>
                          <a
                            class="dropdown-item disabled"
                            id="menu-8"
                            href="javascript:void(0);"
                            @click="editMedication"
                            ><i
                              class="ri-pencil-fill align-bottom me-2 text-muted"
                            ></i
                            >Edit</a
                          >
                        </li>
                        <li>
                          <a
                            class="dropdown-item disabled"
                            id="menu-9"
                            href="javascript:void(0);"
                            @click="deleteRecord('medication')"
                            ><i
                              class="ri-delete-bin-fill align-bottom me-2 text-muted"
                            ></i
                            >Delete</a
                          >
                        </li>
                      </ul>
                    </div>
                  </div>
                </div>
              </div>

              <div class="card-body p-0">
                <!-- <div>
                  <ul class="nav nav-tabs nav-tabs-custom nav-success" role="tablist">
                    <li class="nav-item" role="presentation" @click="activeTab = 'treatment'">
                      <a class="nav-link active py-3" data-bs-toggle="tab" id="treatment-tab" href="#treatment" role="tab" aria-selected="true">
                        <i class="ri-todo-line me-1 align-bottom"></i> Treatments
                      </a>
                    </li>
                    <li class="nav-item" role="presentation" @click="activeTab = 'medication'">
                      <a class="nav-link py-3" data-bs-toggle="tab" id="medication-tab" href="#medication" role="tab" aria-selected="false" tabindex="-1">
                        <i class="ri-heart-2-line me-1 align-bottom"></i> Medications
                      </a>
                    </li>
                  </ul>
                </div> -->

                <ul class="nav nav-tabs ps-3" role="tablist" id="tabs">
                  <li
                    class="nav-item"
                    role="presentation"
                    @click="activeTab = 'treatment'"
                  >
                    <a
                      class="nav-link active"
                      id="treatment-tab"
                      data-bs-toggle="tab"
                      href="#treatment"
                      role="tab"
                      aria-selected="true"
                    >
                      Treatments
                    </a>
                  </li>
                  <li
                    class="nav-item"
                    role="presentation"
                    @click="activeTab = 'medication'"
                  >
                    <a
                      class="nav-link"
                      id="medication-tab"
                      data-bs-toggle="tab"
                      href="#medication"
                      role="tab"
                      aria-selected="false"
                      tabindex="-1"
                    >
                      Medications
                    </a>
                  </li>
                </ul>
              </div>
              <div class="tab-content">
                <div
                  class="tab-pane active show"
                  id="treatment"
                  role="tabpanel"
                >
                  <div class="custom-grid p-3">
                    <ag-grid-vue
                      style="height: calc(100vh - 19rem)"
                      class="ag-theme-quartz"
                      :columnDefs="columnTreatment"
                      :rowData="treatments"
                      :defaultColDef="defaultColDef"
                      :suppressMenuHide="false"
                      :suppressCellFocus="true"
                      animateRows="false"
                      rowSelection="single"
                      @rowClicked="cellClickTreatment"
                      @cell-double-clicked="viewMedication"
                    ></ag-grid-vue>
                  </div>
                </div>
                <div class="tab-pane" id="medication" role="tabpanel">
                  <div class="custom-grid p-3">
                    <ag-grid-vue
                      style="height: calc(100vh - 19rem)"
                      class="ag-theme-quartz"
                      :columnDefs="columnMedication"
                      :rowData="medicationFilter"
                      :defaultColDef="defaultColDef"
                      :suppressMenuHide="false"
                      :suppressCellFocus="true"
                      animateRows="false"
                      rowSelection="single"
                      @rowClicked="cellClickMedication"
                      @cell-double-clicked="editMedication"
                    ></ag-grid-vue>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Forms Modal -->
    <div
      class="modal fade"
      id="form-modal"
      data-bs-backdrop="static"
      data-bs-keyboard="false"
      tabindex="-1"
      aria-modal="true"
      role="dialog"
    >
      <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
          <div class="modal-header p-3" id="form-header">
            <h5 class="modal-title" id="form-title">Title</h5>
            <button
              type="button"
              class="btn-close"
              data-bs-dismiss="modal"
              aria-label="Close"
              id="close-modal"
            ></button>
          </div>

          <ul class="nav nav-tabs" role="tablist" id="all-tabs">
            <li class="nav-item ps-3" role="presentation" id="tab-1">
              <a
                class="nav-link active"
                id="link-1"
                data-bs-toggle="tab"
                href="#content-1"
                role="tab"
                aria-selected="true"
              >
                Patient Details
              </a>
            </li>
            <li class="nav-item" role="presentation" id="tab-2">
              <a
                class="nav-link"
                id="link-2"
                data-bs-toggle="tab"
                href="#content-2"
                role="tab"
                aria-selected="false"
                tabindex="-1"
              >
                Treatments
              </a>
            </li>
            <li class="nav-item" role="presentation" id="tab-3">
              <a
                class="nav-link"
                id="link-3"
                data-bs-toggle="tab"
                href="#content-3"
                role="tab"
                aria-selected="false"
                tabindex="-1"
              >
                Medications
              </a>
            </li>
          </ul>

          <div class="modal-body">
            <div class="tab-content">
              <div class="tab-pane active show" id="content-1" role="tabpanel">
                <div class="row">
                  <div class="col-lg-6">
                    <div class="mb-3">
                      <label class="form-label"
                        >Gender & Name <span class="text-danger">*</span></label
                      >
                      <div class="input-group">
                        <button
                          class="btn dropdown-toggle"
                          type="button"
                          style="border-color: var(--vz-input-border-custom)"
                          data-bs-toggle="dropdown"
                          aria-expanded="false"
                        >
                          {{ patientForm.sex }}
                        </button>
                        <ul class="dropdown-menu dropdownmenu-secondary">
                          <li v-for="(i, index) in lkSex" :key="index">
                            <a
                              class="dropdown-item"
                              href="#"
                              @click="patientForm.sex = i.value"
                              >{{ i.value }}</a
                            >
                          </li>
                        </ul>
                        <input
                          type="text"
                          class="form-control"
                          placeholder="Enter name"
                          aria-label="Text input with 2 dropdown buttons"
                          v-model="patientForm.name"
                        />
                        <!-- <button type="button" class="btn btn-icon" style="height: 37.5px; border-color: var(--vz-input-border-custom);" @click="newPhoto">
                          <i class="bx bxs-camera align-middle fs-16"></i>
                        </button> -->
                      </div>
                      <!-- <input class="d-none" ref="photo" type="file" accept="image/*" @change="selectPhoto"> -->
                    </div>
                  </div>
                  <div class="col-lg-6">
                    <div class="mb-3">
                      <label class="form-label">Surname </label>
                      <input
                        type="text"
                        class="form-control"
                        placeholder="Enter surname"
                        v-model="patientForm.surname"
                      />
                    </div>
                  </div>
                  <div class="col-lg-6">
                    <div class="mb-3">
                      <label class="form-label"
                        >Company <span class="text-danger">*</span></label
                      >
                      <multiselect
                        :searchable="true"
                        :searchStart="true"
                        placeholder="Select company"
                        :options="lkCompany"
                        v-model="patientForm.company"
                        @select="patientForm.department = ''"
                      />
                    </div>
                  </div>
                  <div class="col-lg-6">
                    <div class="mb-3" v-if="patientForm.company == 'XPPL'">
                      <label class="form-label"
                        >Department <span class="text-danger">*</span></label
                      >
                      <multiselect
                        :searchable="true"
                        :searchStart="true"
                        placeholder="Select department"
                        :options="lkDepartment"
                        v-model="patientForm.department"
                      />
                    </div>
                    <div class="mb-3" v-else>
                      <label class="form-label">Subcontractor </label>
                      <input
                        type="text"
                        class="form-control"
                        placeholder="Enter subcontractor"
                        v-model="patientForm.department"
                      />
                    </div>
                  </div>
                  <div class="col-lg-3">
                    <div class="mb-3">
                      <label class="form-label">Employee ID</label>
                      <input
                        type="text"
                        class="form-control"
                        placeholder="Enter employee id"
                        v-model="patientForm.employee_id"
                      />
                    </div>
                  </div>
                  <div class="col-lg-9">
                    <div class="mb-3">
                      <label class="form-label">Position </label>
                      <multiselect
                        :searchable="true"
                        :searchStart="true"
                        placeholder="Select position"
                        :options="lkPosition"
                        v-model="patientForm.position"
                      />
                    </div>
                  </div>
                  <div class="col-lg-3">
                    <div class="mb-3">
                      <label class="form-label">Age</label>
                      <input
                        type="number"
                        class="form-control"
                        placeholder="Enter age"
                        v-model="patientForm.age"
                      />
                    </div>
                  </div>
                  <div class="col-lg-3">
                    <div class="mb-3">
                      <label class="form-label">Blood Group </label>
                      <multiselect
                        :searchable="false"
                        :searchStart="true"
                        placeholder="Select"
                        :options="lkBloodGroup"
                        v-model="patientForm.blood_group"
                      />
                    </div>
                  </div>
                  <div class="col-lg-6">
                    <div class="mb-3">
                      <label class="form-label">Phone</label>
                      <input
                        type="text"
                        class="form-control"
                        placeholder="Enter contact number"
                        v-model="patientForm.phone"
                      />
                    </div>
                  </div>
                  <div class="col-lg-6">
                    <div class="mb-3">
                      <label class="form-label">Congenital Disease</label>
                      <input
                        type="text"
                        class="form-control"
                        placeholder="Enter congenital disease"
                        v-model="patientForm.disease"
                      />
                    </div>
                  </div>
                  <div class="col-lg-6">
                    <div class="mb-3">
                      <label class="form-label">Drug Allergy</label>
                      <input
                        type="text"
                        class="form-control"
                        placeholder="Enter drug allergy"
                        v-model="patientForm.drug_allergy"
                      />
                    </div>
                  </div>
                  <div class="col-lg-12">
                    <label class="form-label">Note</label>
                    <textarea
                      class="form-control"
                      rows="2"
                      placeholder="Enter note"
                      v-model="patientForm.note"
                    ></textarea>
                  </div>
                </div>
              </div>

              <!-- Treatments tab -->
              <div class="tab-pane" id="content-2" role="tabpanel">
                <div class="row">
                  <div class="col-lg-4">
                    <div class="mb-3">
                      <label class="form-label"
                        >Date Time <span class="text-danger">*</span></label
                      >
                      <input
                        type="text"
                        class="form-control flatpickr-input flatpickr-single cursor-pointer"
                        placeholder="Select date"
                        v-model="treatmentForm.date_time"
                      />
                    </div>
                  </div>
                  <div class="col-lg-4">
                    <div class="mb-3">
                      <label class="form-label"
                        >Medical Type <span class="text-danger">*</span></label
                      >
                      <multiselect
                        placeholder="Select medical type"
                        :options="lkMedicalType"
                        v-model="treatmentForm.medical_type"
                        @select="treatmentForm.injury_type = ''"
                      />
                    </div>
                  </div>
                  <div class="col-lg-4">
                    <div
                      class="mb-3"
                      v-if="treatmentForm.medical_type == 'Accident'"
                    >
                      <label class="form-label"
                        >Injury Type <span class="text-danger">*</span></label
                      >
                      <multiselect
                        @select="treatmentForm.injury_part = null"
                        placeholder="Select injury type"
                        :options="lkInjuryType"
                        v-model="treatmentForm.injury_type"
                      />
                    </div>
                    <div class="mb-3" v-else>
                      <label class="form-label">Injury Type </label>
                      <input
                        type="text"
                        class="form-control"
                        placeholder="Not required"
                        readonly
                      />
                    </div>
                  </div>
                  <div class="col-lg-8">
                    <div class="mb-3">
                      <label class="form-label">Injury Part </label>
                      <multiselect
                        v-if="treatmentForm.injury_type"
                        mode="tags"
                        placeholder="Select injury parts"
                        :searchable="true"
                        :searchStart="true"
                        :close-on-select="false"
                        :options="lkInjuryPart"
                        v-model="treatmentForm.injury_part"
                      />
                      <input
                        v-else
                        type="text"
                        class="form-control"
                        placeholder="Not required"
                        readonly
                      />
                    </div>
                  </div>
                  <div class="col-lg-4">
                    <div class="mb-3">
                      <label class="form-label"
                        >Work Related <span class="text-danger">*</span></label
                      >
                      <multiselect
                        :searchable="false"
                        :searchStart="true"
                        :options="lkWorkRelated"
                        placeholder="Select work related"
                        v-model="treatmentForm.work_related"
                      />
                    </div>
                  </div>
                  <div class="col-lg-2 col-6">
                    <div class="mb-3">
                      <label class="form-label">Temp C</label>
                      <input
                        type="text"
                        class="form-control"
                        placeholder="Temp c"
                        v-model="treatmentForm.temp_c"
                      />
                    </div>
                  </div>
                  <div class="col-lg-2 col-6">
                    <div class="mb-3">
                      <label class="form-label">BP </label>
                      <input
                        type="text"
                        class="form-control"
                        placeholder="Blood press"
                        v-model="treatmentForm.blood_press"
                      />
                    </div>
                  </div>
                  <div class="col-lg-2 col-6">
                    <div class="mb-3">
                      <label class="form-label">Puls </label>
                      <input
                        type="text"
                        class="form-control"
                        placeholder="Puls"
                        v-model="treatmentForm.puls"
                      />
                    </div>
                  </div>
                  <div class="col-lg-2 col-6">
                    <div class="mb-3">
                      <label class="form-label">Oxigen </label>
                      <input
                        type="number"
                        class="form-control"
                        placeholder="Oxigen"
                        v-model="treatmentForm.oxigen"
                      />
                    </div>
                  </div>
                  <div class="col-lg-4">
                    <div class="mb-3">
                      <label class="form-label">Weight </label>
                      <input
                        type="number"
                        class="form-control"
                        placeholder="Weight"
                        v-model="treatmentForm.weight"
                      />
                    </div>
                  </div>
                  <div class="col-lg-12">
                    <div class="mb-3">
                      <label class="form-label"
                        >Syndrome <span class="text-danger">*</span></label
                      >
                      <textarea
                        class="form-control"
                        rows="2"
                        placeholder="Enter syndrome"
                        v-model="treatmentForm.syndrome"
                      ></textarea>
                    </div>
                  </div>
                  <div class="col-lg-8">
                    <div class="mb-3">
                      <label class="form-label"
                        >Diagnosis <span class="text-danger">*</span></label
                      >
                      <multiselect
                        :searchable="true"
                        :searchStart="true"
                        placeholder="Select diagnosis"
                        :options="lkDiagnosis"
                        v-model="treatmentForm.diagnosis"
                      />
                    </div>
                  </div>
                  <div class="col-lg-4">
                    <div class="mb-3">
                      <label class="form-label"
                        >Patient Type <span class="text-danger">*</span></label
                      >
                      <multiselect
                        :searchable="false"
                        :searchStart="true"
                        placeholder="Select patient type"
                        :options="lkPatientType"
                        v-model="treatmentForm.patient_type"
                        @select="treatmentForm.transfer = ''"
                      />
                    </div>
                  </div>
                  <div class="col-lg-4">
                    <div
                      class="mb-lg-0 mb-3"
                      v-if="treatmentForm.patient_type == 'In Patient'"
                    >
                      <label class="form-label"
                        >Transfer <span class="text-danger">*</span></label
                      >
                      <multiselect
                        :searchable="false"
                        :searchStart="true"
                        placeholder="Select transfer"
                        :options="lkTransfer"
                        v-model="treatmentForm.transfer"
                        @select="treatmentForm.hospital = ''"
                      />
                    </div>
                    <div class="mb-lg-0 mb-3" v-else>
                      <label class="form-label">Transfer </label>
                      <input
                        type="text"
                        class="form-control"
                        placeholder="Not required"
                        readonly
                      />
                    </div>
                  </div>
                  <div class="col-lg-4">
                    <div
                      class="mb-lg-0 mb-3"
                      v-if="treatmentForm.patient_type == 'In Patient'"
                    >
                      <label class="form-label"
                        >Hospital <span class="text-danger">*</span></label
                      >
                      <multiselect
                        :searchable="false"
                        :searchStart="true"
                        placeholder="Select hospital"
                        :options="lkHospital"
                        v-model="treatmentForm.hospital"
                      />
                    </div>
                    <div class="mb-lg-0 mb-3" v-else>
                      <label class="form-label">Hospital </label>
                      <input
                        type="text"
                        class="form-control"
                        placeholder="Not required"
                        readonly
                      />
                    </div>
                  </div>
                  <div class="col-lg-4">
                    <div class="mb-lg-0 mb-3">
                      <label class="form-label"
                        >Medic <span class="text-danger">*</span></label
                      >
                      <multiselect
                        :searchable="false"
                        :searchStart="true"
                        placeholder="Select medic"
                        :options="lkMedic"
                        v-model="treatmentForm.medic"
                      />
                    </div>
                  </div>
                </div>
              </div>

              <!-- Medication Tab -->
              <div class="tab-pane" id="content-3" role="tabpanel">
                <div class="row g-2">
                  <div class="col-lg-8">
                    <div class="mb-3">
                      <label class="form-label"
                        >Medicine Name <span class="text-danger">*</span></label
                      >
                      <multiselect
                        id="medicine-name"
                        :searchable="true"
                        :searchStart="true"
                        placeholder="Select medicine name"
                        :options="lkMedicine"
                        v-model="medicationForm.medicine_id"
                        @select="qtyFocus"
                      />
                    </div>
                  </div>
                  <div class="col-lg-2 col-6">
                    <div class="mb-3">
                      <label class="form-label">Unit</label>
                      <input
                        type="text"
                        class="form-control"
                        placeholder="Auto filled"
                        v-model="medicationForm.unit_eng"
                        readonly
                      />
                    </div>
                  </div>
                  <div class="col-lg-2 col-6">
                    <label class="form-label"
                      >Qty <span class="text-danger">*</span></label
                    >
                    <div
                      v-if="
                        action == 'add-patient' || action == 'add-treatment'
                      "
                      class="input-group"
                    >
                      <input
                        type="number"
                        id="medication-qty"
                        class="form-control"
                        placeholder="Qty"
                        v-model="medicationForm.qty"
                        @keydown.enter="addMedicationTemp"
                      />
                      <button
                        type="button"
                        class="btn btn-success btn-icon"
                        :class="medicationBtnDis"
                        @click="addMedicationTemp"
                      >
                        <i class="ri-add-line align-middle fs-18"></i>
                      </button>
                    </div>
                    <div v-if="action == 'add-medication'" class="input-group">
                      <input
                        type="number"
                        id="medication-qty"
                        class="form-control"
                        placeholder="Qty"
                        v-model="medicationForm.qty"
                        @keydown.enter="addMedicationTemp2"
                      />
                      <button
                        type="button"
                        class="btn btn-success btn-icon"
                        :class="medicationBtnDis"
                        @click="addMedicationTemp2"
                      >
                        <i class="ri-add-line align-middle fs-18"></i>
                      </button>
                    </div>
                    <div class="input-group" v-if="action == 'upd-medication'">
                      <input
                        type="number"
                        id="medication-qty"
                        class="form-control"
                        placeholder="Qty"
                        v-model="medicationForm.qty"
                      />
                    </div>
                  </div>
                  {{ unit }}
                </div>

                <!-- Medication Temp -->
                <div class="card-body mt-2" v-if="medicationTemp.length > 0">
                  <div class="table-responsive">
                    <table
                      class="table align-middle border table-nowrap mb-0 table-sm"
                    >
                      <thead class="table-active">
                        <tr>
                          <th style="width: 30px">#</th>
                          <th class="w-75">Medicine</th>
                          <th>Qty</th>
                          <th>Unit</th>
                          <th>Actions</th>
                        </tr>
                      </thead>
                      <tbody>
                        <tr
                          v-for="(item, index) in medicationTemp"
                          :key="index"
                        >
                          <td>{{ index + 1 }}</td>
                          <td>{{ item.medicine }}</td>
                          <td>{{ item.qty }}</td>
                          <td>{{ item.unit_eng }}</td>
                          <td>
                            <div>
                              <button
                                type="button"
                                class="btn btn-sm btn-icon text-muted btn-sm material-shadow-none"
                                @click="delMedicationTemp(index)"
                              >
                                <i
                                  class="ri-delete-bin-line text-danger fs-16"
                                ></i>
                              </button>
                            </div>
                            <!-- <div class="d-flex gap-1">
                              <a href="javascript:void(0);" class="btn btn-soft-success btn-sm btn-icon dropdown" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="ri-more-fill"></i>
                              </a>
                              <ul class="dropdown-menu dropdown-menu-end dropdownmenu-secondary">
                                <li><a class="dropdown-item" href="javascript:void(0);" @click="editOrder(item.order_id)"><i class="ri-pencil-fill me-2 align-bottom text-muted"></i>Edit</a></li>
                                <li><a class="dropdown-item" href="javascript:void(0);" @click="delOrder(item.order_id, index)"><i class="ri-delete-bin-5-fill me-2 align-bottom text-muted"></i>Delete</a></li>
                              </ul>
                            </div> -->
                          </td>
                        </tr>
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="modal-footer" style="display: block">
            <div class="hstack gap-2 justify-content-end">
              <button
                type="button"
                class="btn btn-light"
                data-bs-dismiss="modal"
              >
                {{ $t("close-btn") }}
              </button>
              <button
                id="action-btn"
                type="button"
                class="btn btn-success"
                :class="formValidation"
                @click="formButtonEvent"
              >
                name
              </button>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Patient Delete Modal -->
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
                <button class="btn btn-soft-danger" @click="deleteConfirm">
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
import { useStore } from "../stores/store.js";
import { useAuthStore } from "../stores/auth.js";
import { useToastr } from "../toastr.js";
const toastr = useToastr();

export default {
  name: "XpplAppClinicTreatment",
  components: { AgGridVue },
  setup() {
    return {
      store: useStore(),
      authStore: useAuthStore(),
    };
  },

  data() {
    return {
      columnDefs: [
        {
          headerName: "#",
          maxWidth: 50,
          sortable: false,
          resizable: false,
          suppressMovable: true,
          suppressMenu: true,
          valueGetter: (params) => {
            return params.node.rowIndex + 1;
          },
        },
        {
          headerName: "Patient ID",
          field: "patient_id",
          minWidth: 80,
          maxWidth: 100,
          hide: true,
        },
        {
          headerName: "Sex",
          field: "sex",
          minWidth: 70,
          filter: "agSetColumnFilter",
        },
        {
          headerName: "Name",
          field: "fullname",
          minWidth: 200,
          filter: "agSetColumnFilter",
        },
        {
          headerName: "Company",
          field: "company",
          minWidth: 150,
          filter: "agSetColumnFilter",
        },
        {
          headerName: "Department",
          field: "department",
          minWidth: 150,
          filter: "agSetColumnFilter",
        },
        {
          headerName: "Position",
          field: "position",
          minWidth: 200,
          filter: "agSetColumnFilter",
        },
        {
          headerName: "Employee ID",
          field: "employee_id",
          filter: "agSetColumnFilter",
        },
        {
          headerName: "Age",
          field: "age",
          minWidth: 60,
          filter: "agNumberColumnFilter",
          valueGetter: (p) => Number(p.data.age),
          valueFormatter: (p) =>
            p.value
              ? p.value.toLocaleString("en-US", {
                  minimumFractionDigits: 0,
                  maximumFractionDigits: 0,
                })
              : "",
        },
        {
          headerName: "Phone",
          field: "phone",
          filter: "agSetColumnFilter",
        },
        {
          headerName: "Blood Group",
          field: "blood_group",
          filter: "agSetColumnFilter",
        },
        {
          headerName: "Congenital Disease",
          field: "disease",
          filter: "agSetColumnFilter",
        },
        {
          headerName: "Drug Allergy",
          field: "drug_allergy",
          filter: "agSetColumnFilter",
        },
        { headerName: "Note", field: "note" },

        {
          headerName: "Created at",
          field: "created_at",
          maxWidth: 150,
          hide: true,
          valueFormatter: (p) =>
            p.value ? moment(p.value).format("DD-MM-YYYY HH:mm:ss") : "",
        },
        {
          headerName: "Created by",
          field: "created_by",
          maxWidth: 150,
          hide: true,
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

      columnTreatment: [
        {
          headerName: "#",
          maxWidth: 50,
          sortable: false,
          resizable: false,
          suppressMovable: true,
          suppressMenu: true,
          valueGetter: (params) => {
            return params.node.rowIndex + 1;
          },
        },
        { headerName: "Patient ID", field: "patient_id", hide: true },
        {
          headerName: "Treatment ID",
          field: "treatment_id",
          hide: true,
        },
        {
          headerName: "Date Time",
          field: "date_time",
          minWidth: 150,
          filter: "agDateColumnFilter",
          valueFormatter: (p) =>
            p.value ? moment(p.value).format("DD-MM-YYYY HH:mm") : "",
        },
        {
          headerName: "Syndrome",
          field: "syndrome",
          minWidth: 250,
        },
        {
          headerName: "Diagnosis",
          field: "diagnosis",
          minWidth: 150,
          filter: "agSetColumnFilter",
        },
        {
          headerName: "Medical Type",
          field: "medical_type",
          filter: "agSetColumnFilter",
        },
        {
          headerName: "Injury Type",
          field: "injury_type",
          filter: "agSetColumnFilter",
        },
        {
          headerName: "Injury Part",
          field: "injury_part",
          filter: "agSetColumnFilter",
        },
        {
          headerName: "Work",
          field: "work_related",
          filter: "agSetColumnFilter",
        },
        {
          headerName: "Temp",
          field: "temp_c",
        },
        {
          headerName: "BP",
          field: "blood_press",
        },
        {
          headerName: "Puls",
          field: "puls",
        },
        {
          headerName: "Oxigen",
          field: "oxigen",
        },
        {
          headerName: "Weight",
          field: "weight",
        },
        {
          headerName: "Patient Type",
          field: "patient_type",
          filter: "agSetColumnFilter",
        },
        {
          headerName: "Transfer",
          field: "transfer",
          filter: "agSetColumnFilter",
        },
        {
          headerName: "Hospital",
          field: "hospital",
          filter: "agSetColumnFilter",
        },
        {
          headerName: "Medic",
          field: "medic",
          filter: "agSetColumnFilter",
        },
        {
          headerName: "Created at",
          field: "created_at",
          maxWidth: 150,
          hide: true,
          valueFormatter: (p) =>
            p.value ? moment(p.value).format("DD-MM-YYYY HH:mm:ss") : "",
        },
        {
          headerName: "Created by",
          field: "created_by",
          maxWidth: 150,
          hide: true,
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

      columnMedication: [
        {
          headerName: "#",
          maxWidth: 50,
          sortable: false,
          resizable: false,
          suppressMovable: true,
          suppressMenu: true,
          valueGetter: (params) => {
            return params.node.rowIndex + 1;
          },
        },
        {
          headerName: "Treatment ID",
          field: "treatment_id",
          hide: true,
        },
        {
          headerName: "Mediccine Eng",
          field: "medicine_eng",
          // minWidth: 250,
          filter: "agSetColumnFilter",
        },
        {
          headerName: "Mediccine Lao",
          field: "medicine_lao",
          // minWidth: 250,
          filter: "agSetColumnFilter",
        },
        {
          headerName: "Unit Eng",
          field: "unit_eng",
          maxWidth: 150,
          filter: "agSetColumnFilter",
        },
        {
          headerName: "Qty",
          field: "qty",
          maxWidth: 150,
        },
        {
          headerName: "Created at",
          field: "created_at",
          hide: true,
          valueFormatter: (p) =>
            p.value ? moment(p.value).format("DD-MM-YYYY HH:mm:ss") : "",
        },
        {
          headerName: "Created by",
          field: "created_by",
          hide: true,
          filter: "agSetColumnFilter",
        },
        {
          headerName: "Updated at",
          field: "updated_at",
          hide: true,
          valueFormatter: (p) =>
            p.value ? moment(p.value).format("DD-MM-YYYY HH:mm:ss") : "",
        },
        {
          headerName: "Updated by",
          field: "updated_by",
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

      auth: {},
      lkCompany: [],
      lkDepartment: [],
      lkPosition: [],
      lkDiagnosis: [],
      lkPatientType: [],
      lkMedicalType: [],
      lkHospital: [],
      lkTransfer: [],
      lkBloodGroup: [],
      lkMedicine: [],
      lkMedic: [],
      lkInjuryPart: [],
      lkInjuryType: [],
      lkWorkRelated: [],
      lkSex: [],

      codes: [],
      medicines: [],
      patients: [],
      medicationTemp: [],
      treatments: [],
      medications: [],
      medicationFilter: [],

      patientForm: {
        patient_id: "",
        sex: "Male",
        name: "",
        surname: "",
        fullname: "",
        company: null,
        department: null,
        position: "",
        employee_id: "",
        age: "",
        phone: "",
        blood_group: "",
        disease: "",
        drug_allergy: "",
        note: "",
      },
      treatmentForm: {
        treatment_id: "",
        date_time: "",
        medical_type: null,
        injury_type: null,
        injury_part: null,
        work_related: null,
        temp_c: "",
        blood_press: "",
        puls: "",
        oxigen: "",
        weight: "",
        syndrome: "",
        diagnosis: null,
        patient_type: null,
        transfer: null,
        hospital: null,
        medic: null,
      },
      medicationForm: {
        treatment_id: "",
        medication_id: "",
        medicine_id: "",
        qty: "",
        unit_eng: "",
      },

      search: "",
      viewMode: "name-list",
      activeTab: "treatment",
      action: "",

      loading: false,
    };
  },

  mounted() {},

  computed: {
    medicationBtnDis() {
      return this.medicationForm.medicine_id &&
        this.medicationForm.qty &&
        this.medicationForm.unit_eng
        ? ""
        : "disabled";
    },

    patientList() {
      const searchTerm = this.search.trim().toLowerCase();
      if (!searchTerm) return this.patients;
      const searchFields = ["fullname", "company", "sex"];
      return this.patients.filter((e) =>
        searchFields.some((field) =>
          e[field]?.toLowerCase().startsWith(searchTerm)
        )
      );
    },

    unit() {
      if (this.medicationForm.medicine_id) {
        let item = this.medicines.find(
          (e) => e.medicine_id == this.medicationForm.medicine_id
        );
        this.medicationForm.unit_eng = item.unit_eng;
      } else {
        this.medicationForm.unit_eng = "";
      }
    },

    formValidation() {
      if (this.action == "add-patient") {
        return this.patientForm.name &&
          this.patientForm.company &&
          this.treatmentForm.date_time &&
          this.treatmentForm.medical_type &&
          this.treatmentForm.work_related &&
          this.treatmentForm.syndrome &&
          this.treatmentForm.diagnosis &&
          this.treatmentForm.patient_type &&
          this.treatmentForm.medic &&
          (this.patientForm.company !== "XPPL" ||
            this.patientForm.department) &&
          (this.treatmentForm.medical_type !== "Accident" ||
            this.treatmentForm.injury_type) &&
          (this.treatmentForm.patient_type !== "In Patient" ||
            (this.treatmentForm.transfer && this.treatmentForm.hospital))
          ? ""
          : "disabled";
      } else if (this.action == "upd-patient") {
        return this.patientForm.name &&
          this.patientForm.company &&
          (this.patientForm.company !== "XPPL" || this.patientForm.department)
          ? ""
          : "disabled";
      } else if (
        this.action == "add-treatment" ||
        this.action == "upd-treatment"
      ) {
        return this.treatmentForm.date_time &&
          this.treatmentForm.medical_type &&
          this.treatmentForm.work_related &&
          this.treatmentForm.syndrome &&
          this.treatmentForm.diagnosis &&
          this.treatmentForm.patient_type &&
          this.treatmentForm.medic &&
          (this.treatmentForm.medical_type !== "Accident" ||
            this.treatmentForm.injury_type) &&
          (this.treatmentForm.patient_type !== "In Patient" ||
            (this.treatmentForm.transfer && this.treatmentForm.hospital))
          ? ""
          : "disabled";
      } else if (this.action == "add-medication") {
        return this.medicationTemp.length ? "" : "disabled";
      } else if (this.action == "upd-medication") {
        return this.medicationForm.medicine_id &&
          this.medicationForm.qty &&
          this.medicationForm.unit_eng
          ? ""
          : "disabled";
      }
    },
  },

  methods: {
    async onLoad() {
      this.loading = true;

      const { data: authorise } = await axios.get(
        `api/auth/auth-action?submenu=M09S01`,
        {
          headers: {
            Authorization: "Bearer " + this.authStore.getToken,
          },
        }
      );
      this.auth = authorise[0];
      await this.getCodes();
      await this.getMedicines();
      await this.getPatients();

      this.loading = false;
    },

    async getPatients() {
      try {
        const { data: patient } = await axios.get("api/clinic/patients", {
          headers: {
            Authorization: "Bearer " + this.authStore.getToken,
          },
        });
        this.patients = patient;
      } catch (error) {
        console.log(error);
      }
    },

    async getMedicines() {
      const { data } = await axios.get("api/clinic/medicines", {
        headers: { Authorization: "Bearer " + this.authStore.getToken },
      });
      this.medicines = data;
      this.lkMedicine = data.map((m) => ({
        value: m.medicine_id,
        label: m.medicine_eng,
      }));
    },

    async getTreatments() {
      try {
        const { data } = await axios.get(
          `api/clinic/treatments/${this.patientForm.patient_id}`,
          {
            headers: {
              Authorization: "Bearer " + this.authStore.getToken,
            },
          }
        );
        this.treatments = data;
      } catch (error) {
        console.log(error);
      }
    },

    async getMedications() {
      try {
        const { data } = await axios.get(
          `api/clinic/medications/${this.patientForm.patient_id}`,
          {
            headers: {
              Authorization: "Bearer " + this.authStore.getToken,
            },
          }
        );
        this.medications = data;
      } catch (error) {
        console.log(error);
      }
    },

    async formButtonEvent() {
      const actions = {
        "add-patient": this.addPatient,
        "add-treatment": this.addTreatment,
        "add-medication": this.addMedication,
        "upd-patient": this.updateRecord,
        "upd-treatment": this.updateRecord,
        "upd-medication": this.updateRecord,
      };

      if (actions[this.action]) {
        await actions[this.action]();
      }
    },

    newPatient() {
      if (this.auth.new == 0)
        return toastr.warning("You're not authorized to add.");

      this.action = "add-patient";
      document.getElementById("action-btn").textContent = "Add Patient";
      document.getElementById("form-header").classList.remove("bg-light");
      document.getElementById("form-title").textContent = "Add Patient";
      document.getElementById("all-tabs").classList.remove("d-none");
      document
        .querySelectorAll('[id^="tab-"]')
        .forEach((e) => e.classList.remove("d-none"));
      document.getElementById("tab-2").classList.remove("ps-3");

      document.querySelectorAll('[id^="link-"]').forEach((e) => {
        e.id == "link-1"
          ? e.classList.add("active")
          : e.classList.remove("active");
      });

      document.querySelectorAll('[id^="content-"]').forEach((e) => {
        e.id == "content-1"
          ? e.classList.add("active", "show")
          : e.classList.remove("active", "show");
      });

      for (const key in this.patientForm) {
        this.patientForm[key] = null;
      }
      for (const key in this.treatmentForm) {
        this.treatmentForm[key] = null;
      }
      this.patientForm.sex = "Male";
      this.medicationTemp = [];

      const currentDate = new Date();
      const formattedDate = currentDate.toISOString();
      this.treatmentForm.date_time =
        moment(currentDate).format("YYYY-MM-DD HH:mm");

      flatpickr(".flatpickr-single", {
        altInput: true,
        altFormat: "d-m-Y H:i",
        enableTime: true,
        time_24hr: true,
        enableSeconds: false,
        minuteIncrement: 5,
        hourIncrement: 1,
        defaultDate: formattedDate,
        time_disabled: ["00:00"],
      });

      $("#form-modal").modal("show");
      this.disableMenu();
    },

    async addPatient() {
      try {
        const { data } = await axios.post(
          "api/clinic/add-patient",
          {
            patient: this.patientForm,
            treatment: this.treatmentForm,
            medicationList: this.medicationTemp,
          },
          {
            headers: {
              Authorization: "Bearer " + this.authStore.getToken,
            },
          }
        );

        if (!data.success) return toastr.error(data.message);
        await this.getPatients();
        $("#form-modal").modal("hide");
        toastr.success("Successfully!");
      } catch (error) {
        console.error("Error adding patient:", error);
      }
    },

    addMedicationTemp() {
      if (!this.medicationForm.qty) return toastr.info("Please enter quantity");

      let found = this.medicationTemp.find(
        (e) => e.medicine_id === this.medicationForm.medicine_id
      );
      if (found) {
        found.qty += this.medicationForm.qty;
      } else {
        let medicine = this.medicines.find(
          (e) => e.medicine_id === this.medicationForm.medicine_id
        );
        this.medicationTemp.push({
          medicine_id: this.medicationForm.medicine_id,
          medicine: medicine.medicine_eng,
          qty: this.medicationForm.qty,
          unit_eng: this.medicationForm.unit_eng,
          note: "new",
        });
      }

      for (const key in this.medicationForm) {
        this.medicationForm[key] = null;
      }
      document.getElementById("medicine-name").focus();
    },

    addMedicationTemp2() {
      if (!this.medicationForm.qty) return toastr.info("Please enter quantity");

      // check if aleady exist in the medication list
      if (
        this.medications.some(
          (e) =>
            e.treatment_id === this.treatmentForm.treatment_id &&
            e.medicine_id === this.medicationForm.medicine_id
        )
      ) {
        return toastr.error(
          "This medicine already exists in the medication list."
        );
      }

      // check if aleady exist in the medication temp
      let found = this.medicationTemp.find(
        (e) => e.medicine_id === this.medicationForm.medicine_id
      );
      if (found) {
        found.qty += this.medicationForm.qty;
      } else {
        let medicine = this.medicines.find(
          (e) => e.medicine_id === this.medicationForm.medicine_id
        );
        this.medicationTemp.push({
          medicine_id: this.medicationForm.medicine_id,
          medicine: medicine.medicine_eng,
          qty: this.medicationForm.qty,
          unit_eng: this.medicationForm.unit_eng,
          note: "new",
        });
      }

      for (const key in this.medicationForm) {
        this.medicationForm[key] = null;
      }
      document.getElementById("medicine-name").focus();
    },

    delMedicationTemp(index) {
      this.medicationTemp.splice(index, 1);
    },

    cellCicked(e) {
      this.enableMenu();
      for (const key in this.patientForm) {
        this.patientForm[key] = e.data[key];
      }
    },

    editPatient() {
      if (this.auth.edit == 0)
        return toastr.warning("You're not authorized to edit.");

      this.action = "upd-patient";
      document.getElementById("action-btn").textContent = "Save Changes";
      document.getElementById("form-header").classList.add("bg-light");
      document.getElementById("form-title").textContent = "Edit Patient";
      document.getElementById("all-tabs").classList.add("d-none");
      document
        .querySelectorAll('[id^="tab-"]')
        .forEach((e) => e.classList.add("d-none"));
      document.querySelectorAll('[id^="content-"]').forEach((e) => {
        e.id == "content-1"
          ? e.classList.add("active", "show")
          : e.classList.remove("active", "show");
      });

      $("#form-modal").modal("show");
    },

    async viewTreatment() {
      this.loading = true;
      this.viewMode = "detail";
      this.activeTab = "treatment";
      await this.getTreatments();
      await this.getMedications();
      const maxId = Math.max(
        ...this.medications.map((obj) => obj.treatment_id)
      );
      this.medicationFilter = this.medications.filter(
        (m) => m.treatment_id == maxId
      );
      document.getElementById("starter").textContent = "Treatment Details";
      this.loading = false;
    },

    cellClickTreatment(e) {
      this.enableMenu();
      this.medicationFilter = this.medications.filter(
        (m) => m.treatment_id == e.data.treatment_id
      );
      for (const key in this.treatmentForm) {
        if (key !== "injury_part") {
          this.treatmentForm[key] = e.data[key];
        }
      }
      // Split the 'injury_part' string from the event data into an array and assign it to 'treatmentForm.injury_part'
      this.treatmentForm.injury_part = e.data.injury_part
        ? e.data.injury_part.split(", ")
        : null;
    },

    newTreatment() {
      if (this.auth.add == 0)
        return toastr.warning("You're not authorized to add.");

      this.action = "add-treatment";
      for (const key in this.treatmentForm) {
        this.treatmentForm[key] = null;
      }
      for (const key in this.medicationForm) {
        this.medicationForm[key] = null;
      }
      this.medicationTemp = [];

      document.getElementById("action-btn").textContent = "Add Treatment";
      document.getElementById("all-tabs").classList.remove("d-none");
      document.getElementById("form-header").classList.remove("bg-light");
      document.getElementById("form-title").textContent = "Add Treatment";
      document.querySelectorAll('[id^="tab-"]').forEach((e) => {
        e.id == "tab-1"
          ? e.classList.add("d-none")
          : e.classList.remove("d-none");
      });
      document.getElementById("tab-2").classList.add("ps-3");
      document.querySelectorAll('[id^="link-"]').forEach((e) => {
        e.id == "link-2"
          ? e.classList.add("active")
          : e.classList.remove("active");
      });
      document.querySelectorAll('[id^="content-"]').forEach((e) => {
        e.id == "content-2"
          ? e.classList.add("active", "show")
          : e.classList.remove("active", "show");
      });

      const currentDate = new Date();
      const formattedDate = currentDate.toISOString();
      this.treatmentForm.date_time =
        moment(currentDate).format("YYYY-MM-DD HH:mm");

      flatpickr(".flatpickr-single", {
        altInput: true,
        altFormat: "d-m-Y H:i",
        enableTime: true,
        time_24hr: true,
        enableSeconds: false,
        minuteIncrement: 5,
        hourIncrement: 1,
        defaultDate: formattedDate,
        time_disabled: ["00:00"],
      });

      this.disableMenu();
      $("#form-modal").modal("show");
    },

    async addTreatment() {
      try {
        const { data } = await axios.post(
          "api/clinic/add-treatment",
          {
            treatment: this.treatmentForm,
            patient_id: this.patientForm.patient_id,
            medicationList: this.medicationTemp,
          },
          {
            headers: {
              Authorization: "Bearer " + this.authStore.getToken,
            },
          }
        );

        if (!data.success) return toastr.error(data.message);
        await this.getTreatments();
        await this.getMedications();

        $("#form-modal").modal("hide");
        toastr.success("Added successfully!");
      } catch (error) {
        console.log(error);
      }
    },

    editTreatment() {
      if (this.auth.edit == 0)
        return toastr.warning("You're not authorized to edit.");

      this.action = "upd-treatment";
      document.getElementById("action-btn").textContent = "Save Changes";
      document.getElementById("form-header").classList.add("bg-light");
      document.getElementById("form-title").textContent = "Edit Teatment";
      document.getElementById("all-tabs").classList.add("d-none");
      document
        .querySelectorAll('[id^="tab-"]')
        .forEach((e) => e.classList.add("d-none"));
      document.querySelectorAll('[id^="content-"]').forEach((e) => {
        e.id == "content-2"
          ? e.classList.add("active", "show")
          : e.classList.remove("active", "show");
      });
      $("#form-modal").modal("show");
    },

    viewMedication() {
      this.activeTab = "medication";
      document.getElementById("treatment-tab").classList.remove("active");
      document.getElementById("treatment").classList.remove("active", "show");
      document.getElementById("medication-tab").classList.add("active");
      document.getElementById("medication").classList.add("active", "show");
    },

    newMedication() {
      if (this.auth.new == 0)
        return toastr.warning("You're not authorized to add.");

      this.action = "add-medication";
      for (const key in this.medicationForm) {
        this.medicationForm[key] = null;
      }
      this.medicationTemp = [];

      document.getElementById("action-btn").textContent = "Add Medication";
      document.getElementById("form-header").classList.add("bg-light");
      document.getElementById("form-title").textContent = "Add Medication";
      document.getElementById("all-tabs").classList.add("d-none");
      document
        .querySelectorAll('[id^="tab-"]')
        .forEach((e) => e.classList.add("d-none"));
      document.querySelectorAll('[id^="content-"]').forEach((e) => {
        e.id == "content-3"
          ? e.classList.add("active", "show")
          : e.classList.remove("active", "show");
      });
      $("#form-modal").modal("show");
    },

    async addMedication() {
      try {
        const { data } = await axios.post(
          "api/clinic/add-medication",
          {
            treatment_id: this.treatmentForm.treatment_id,
            medicationList: this.medicationTemp,
          },
          {
            headers: {
              Authorization: "Bearer " + this.authStore.getToken,
            },
          }
        );
        if (!data.success) return toastr.error(data.message);
        await this.getMedications();

        // Filter medications based on treatment_id
        this.medicationFilter = this.medications.filter(
          (m) => m.treatment_id === this.treatmentForm.treatment_id
        );

        $("#form-modal").modal("hide");
        toastr.success("Added successfully!");
      } catch (error) {
        console.log(error);
      }
    },

    cellClickMedication(e) {
      this.enableMenu();
      for (const key in this.medicationForm) {
        this.medicationForm[key] = e.data[key];
      }
    },

    editMedication() {
      if (this.auth.edit == 0)
        return toastr.warning("You're not authorized to edit.");

      this.action = "upd-medication";
      document.getElementById("action-btn").textContent = "Save Changes";
      document.getElementById("form-header").classList.add("bg-light");
      document.getElementById("form-title").textContent = "Edit Medication";
      document.getElementById("all-tabs").classList.add("d-none");
      document
        .querySelectorAll('[id^="tab-"]')
        .forEach((e) => e.classList.add("d-none"));
      document.querySelectorAll('[id^="content-"]').forEach((e) => {
        e.id == "content-3"
          ? e.classList.add("active", "show")
          : e.classList.remove("active", "show");
      });
      $("#form-modal").modal("show");
    },

    async updateRecord() {
      try {
        const act = this.action.slice(4);
        await axios.post(`/api/clinic/${this.action}`, this[act + "Form"], {
          headers: {
            Authorization: "Bearer " + this.authStore.getToken,
          },
        });

        await this[`get${act.charAt(0).toUpperCase() + act.slice(1)}s`]();

        // Filter medications based on treatment_id
        this.medicationFilter = this.medications.filter(
          (m) => m.treatment_id === this.treatmentForm.treatment_id
        );

        $("#form-modal").modal("hide");
        toastr.success("Updated successfully!");
      } catch (error) {
        toastr.error("This record already exists in the database.");
      } finally {
        this.disableMenu();
      }
    },

    deleteRecord(act) {
      if (this.auth.del == 0)
        return toastr.warning("You're not authorized to delete.");

      this.action = act;
      $("#delete-modal").modal("show");
    },

    async deleteConfirm() {
      try {
        const { data } = await axios.post(
          `/api/clinic/del-${this.action}`,
          this[this.action + "Form"],
          {
            headers: {
              Authorization: "Bearer " + this.authStore.getToken,
            },
          }
        );

        if (!data.success) return toastr.error(data.message); // Check if success

        // Refresh data
        await this[
          `get${this.action.charAt(0).toUpperCase()}${this.action.slice(1)}s`
        ]();

        // Filter medications based on treatment_id
        if (this.action === "medication") {
          this.medicationFilter = this.medications.filter(
            (m) => m.treatment_id === this.treatmentForm.treatment_id
          );
        }

        $("#delete-modal").modal("hide");
        toastr.success("Deleted successfully!");
      } catch (error) {
        console.log(error);
      } finally {
        this.disableMenu();
      }
    },

    async getCodes() {
      try {
        const { data: code } = await axios.get("api/clinic/codes", {
          headers: {
            Authorization: "Bearer " + this.authStore.getToken,
          },
        });
        this.codes = code;
        const temp = [
          "Blood Group",
          "Company",
          "Diagnosis",
          "Hospital",
          "Injury Part",
          "Injury Type",
          "Medic",
          "Medical Type",
          "Patient Type",
          "Transfer",
          "Work Related",
          "Sex",
        ].map((cate) => ({
          cate,
          val: "code",
          lbl:
            cate === "Injury Type" ||
            cate === "Patient Type" ||
            cate === "Medic"
              ? "descr_eng"
              : "code",
          lkp: `lk${cate.replace(" ", "")}`,
        }));

        temp.forEach(({ cate, val, lbl, lkp }) => {
          this[lkp] = this.codes
            .filter((e) => e.category == cate && e.active == 1)
            .map(({ [val]: value, [lbl]: label }) => ({
              value,
              label: cate == "Injury Type" ? `${value} | ${label}` : label,
            }));
        });

        // Get employee codes
        const { data: empCode } = await axios.get("api/employee/codes", {
          headers: {
            Authorization: "Bearer " + this.authStore.getToken,
          },
        });
        const empCate = ["Position", "Department"].map((cate) => ({
          cate,
          val: "code",
          lbl: "code",
          lkp: `lk${cate.replace(" ", "")}`,
        }));

        empCate.forEach(({ cate, val, lbl, lkp }) => {
          this[lkp] = empCode
            .filter((e) => e.category == cate && e.active == 1)
            .map(({ [val]: value, [lbl]: label }) => ({
              value,
              label,
            }));
        });
      } catch (error) {
        console.error("Error fetching codes:", error);
      }
    },

    enableMenu() {
      document
        .querySelectorAll('[id^="menu-"]')
        .forEach((e) => e.classList.remove("disabled"));
    },

    disableMenu() {
      document
        .querySelectorAll('[id^="menu-"]')
        .forEach((e) => e.classList.add("disabled"));
    },

    qtyFocus() {
      document.getElementById("medication-qty").focus();
    },

    backToList() {
      this.viewMode = "name-list";
      document.getElementById("starter").textContent = "Patient Lists";
    },

    onSearch() {
      this.search
        ? document.getElementById("search-close").classList.remove("d-none")
        : document.getElementById("search-close").classList.add("d-none");
    },

    searchClear() {
      document.getElementById("search-close").classList.add("d-none");
      this.search = "";
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
