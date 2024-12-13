<template>
  <div>
    <div class="row">
      <div class="col-12">
        <div class="page-title-box d-sm-flex align-items-center justify-content-between bg-galaxy-transparent">
          <h4 class="mb-sm-0">Incidents</h4>
          <div class="page-title-right">
            <ol class="breadcrumb m-0">
              <li class="breadcrumb-item"><a href="javascript: void(0);">Safety</a></li>
              <li class="breadcrumb-item active">Incidents</li>
            </ol>
          </div>
        </div>
      </div>
    </div>
    <div class="card" v-if="viewMode == 'main'">
      <div class="card-header border-0 pb-0">
        <div class="row g-2 align-items-center">
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
            <div class="gap-2 d-sm-flex">
              <div class="input-group" style="width: 300px;">
                <input type="month" id="mode-1" class="form-control rounded-start-2" aria-label="Text input with dropdown button" v-model="value" @input="getIncident('Month')">
                <input type="text" id="mode-3" class="form-control flatpickr-input flatpickr-range rounded-start-2 cursor-pointer d-none" placeholder="Select date range" aria-label="Text input with dropdown button" v-model="value" @input="getIncidentRange">
                <div id="mode-2" class="d-none">
                  <multiselect style="width: 223px; border-top-right-radius: 0px; border-bottom-right-radius: 0px;" aria-label="Text input with dropdown button" placeholder="Select year" :options="years" v-model="value" @select="getIncident('Year')" />
                </div>
                <button class="btn btn-success dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">{{ mode }}</button>
                <ul class="dropdown-menu dropdown-menu-end dropdownmenu-secondary" style="">
                  <li><a class="dropdown-item" id="getBy-1" href="#" @click="getMonth()">Month</a></li>
                  <li><a class="dropdown-item" id="getBy-2" href="#" @click="getYear()">Year</a></li>
                  <li><a class="dropdown-item" id="getBy-3" href="#" @click="getRange()">Range</a></li>
                </ul>
              </div>

              <button class="btn btn-info btn-icon" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                <i class="ri-more-2-fill"></i>
              </button>
              <ul class="dropdown-menu dropdown-menu-end dropdownmenu-secondary">
                <li><a class="dropdown-item" id="menu-1" href="javascript:void(0)" @click="newIncident"><i class=" ri-add-circle-fill align-bottom me-2 text-muted"></i>Add</a></li>
                <li><a class="dropdown-item disabled" id="menu-2" href="javascript:void(0)" @click="editIncident"><i class="ri-pencil-fill align-bottom me-2 text-muted"></i>Edit</a></li>
                <li><a class="dropdown-item disabled" id="menu-3" href="javascript:void(0)" @click="delIncident"><i class="ri-delete-bin-fill align-bottom me-2 text-muted"></i>Delete</a></li>
                <div class="dropdown-divider"></div>
                <li><a class="dropdown-item disabled" id="menu-4" href="javascript:void(0);" @click="viewIncident"><i class="ri-eye-fill align-bottom me-2 text-muted"></i>View</a></li>
              </ul>

            </div>
          </div>
        </div>
      </div>
      <div v-if="loading">
        <loading />
      </div>
      <div v-else>
        <div class="custom-grid p-3">
          <ag-grid-vue style="height: calc(100vh - 15.5rem);" class="ag-theme-quartz" :columnDefs="columnDefs" :rowData="incidentList" :defaultColDef="defaultColDef" :suppressMenuHide="false" :suppressCellFocus="true" animateRows="false" rowSelection="single" @rowClicked="cellCicked" @cell-double-clicked="viewIncident"></ag-grid-vue>
        </div>
      </div>
    </div>

    <!-- View Details -->
    <div class="row justify-content-center" v-if="viewMode == 'view'">
      <div class="col-xxl-8 col-lg-9">
        <div class="card" id="demo">
          <div class="row">
            <div class="col-lg-12">
              <div class="card-header border-bottom-dashed p-4">
                <div class="d-xl-flex">
                  <div class="flex-grow-1">
                    <h6 class="text-muted text-uppercase fw-semibold">Incident Title</h6>
                    <h5 class="fw-semibold">{{ incForm.incident_title }}</h5>
                    <div class="mt-xl-4 mt-4">
                      <h6 class="text-muted text-uppercase fw-semibold">Incident Infomation</h6>
                      <p class="mb-1"><span class="text-muted">Date Time: </span>{{ store.dateTime2(incForm.date_time) }}</p>
                      <p class="mb-1"><span class="text-muted">Location: </span>{{ incForm.location }}</p>
                      <p class="mb-1"><span class="text-muted">Company: </span>{{ incForm.company }}</p>
                      <p v-if="incForm.company == 'XPPL'" class="mb-1"><span class="text-muted">Department: </span>{{ incForm.department }}</p>
                      <p v-if="incForm.company != 'XPPL'" class="mb-1"><span class="text-muted">Subcontractor: </span>{{ incForm.department }}</p>
                    </div>
                  </div>
                  <div class="flex-shrink-0 mt-xl-0 mt-3">
                    <h4><span class="text-muted text-uppercase fw-semibold">Incident No: {{ incForm.incident_no }}</span></h4>
                    <h6><span class="text-muted fw-normal">Incident ID: </span><span>{{ incForm.incident_id }}</span></h6>
                    <h6><span class="text-muted fw-normal">Significant: </span><span>{{ incForm.significant }}</span></h6>
                    <h6><span class="text-muted fw-normal">Flash Alert: </span><span> {{ incForm.flash_alert }}</span></h6>
                    <h6><span class="text-muted fw-normal">Actaul Severity: </span><span>{{ store.severity(incForm.actual_severity) }}</span></h6>
                    <h6><span class="text-muted fw-normal">Potential Severity: </span><span> {{ store.severity(incForm.potential_severity) }}</span></h6>
                    <h6><span class="text-muted fw-normal">Risk Rating: </span>
                      <span v-if="Number(incForm.risk_rating) <= 3" class="badge text-white fs-12" style="background-color: #3AB249"> {{ incForm.risk_rating }} (Low)</span>
                      <span v-if="Number(incForm.actual_severity) == 2 && Number(incForm.potential_severity) == 2" class="badge text-white fs-12" style="background-color: #3AB249"> {{ incForm.risk_rating }} (Low)</span>
                      <span v-if="Number(incForm.actual_severity) !== Number(incForm.potential_severity) && Number(incForm.risk_rating) == 4" class="badge text-white fs-12" style="background-color: #F7EC0F"> {{ incForm.risk_rating }} (Medium)</span>
                      <span v-if="Number(incForm.risk_rating) >= 5 && Number(incForm.risk_rating) <= 9" class="badge text-primary fs-12" style="background-color: #F7EC0F"> {{ incForm.risk_rating }} (Medium)</span>
                      <span v-if="Number(incForm.risk_rating) >= 10 && Number(incForm.risk_rating) <= 12" class="badge text-white fs-12" style="background-color: #F89122"> {{ incForm.risk_rating }} (High)</span>
                      <span v-if="Number(incForm.risk_rating) > 12" class="badge text-white fs-12" style="background-color: #E52125"> {{ incForm.risk_rating }} (Very High)</span>
                    </h6>
                  </div>
                </div>
              </div>
            </div>

            <div class="col-lg-12">
              <div class="card-header p-4 border-0">
                <div class="d-xl-flex">
                  <div class="flex-grow-1">
                    <h6 class="text-muted text-uppercase fw-semibold">Incident & Injury Details</h6>
                    <p class="mb-1"><span class="text-muted">Incident Group: </span>{{ incForm.incident_group }}</p>
                    <p class="mb-1"><span class="text-muted">Incident Type: </span>{{ incForm.incident_type }}</p>
                    <p class="mb-1"><span class="text-muted">Injury Type: </span>{{ incForm.incident_type }}</p>
                    <p class="mb-1"><span class="text-muted">Injury Group: </span>{{ incForm.injury_group }}</p>
                    <p class="mb-1"><span class="text-muted">Injury Body Paart: </span>{{ incForm.injury_part }}</p>
                  </div>
                  <div class="flex-shrink-0 mt-xl-0 mt-3">
                    <h6 class="text-muted text-uppercase fw-semibold">Incident Status</h6>
                    <p class="mb-1"><span class="text-muted">Investigate Status: </span>{{ incForm.invest_status }}</p>
                    <p class="mb-1"><span class="text-muted">Investigate Lead By: </span>{{ incForm.invest_lead }}</p>
                    <p class="mb-1"><span class="text-muted">Action Status: </span>{{ incForm.action_status }}</p>
                    <p class="mb-1"><span class="text-muted">Action Due Date: </span>{{ store.ddmmyyyy(incForm.action_duedate) }}</p>
                    <p class="mb-1"><span class="text-muted">Incident Manager: </span>{{ incForm.incident_manager }}</p>
                    <p class="mb-1"><span class="text-muted">Follow Up By: </span>{{ incForm.followup_by }}</p>
                  </div>
                </div>
              </div>
            </div>

            <div class="col-lg-12" v-if="incForm.incident_descr">
              <div class="card-body p-4 pt-0">
                <h6 class="text-muted text-uppercase fw-semibold">Incident Description</h6>
                <div class="alert p-0">
                  <p class="mb-0">
                    <span>
                      {{ incForm.incident_descr }}
                    </span>
                  </p>
                </div>
              </div>
            </div>

            <div class="col-lg-12" v-if="incForm.corrective_action">
              <div class="card-body p-4 pt-0">
                <h6 class="text-muted text-uppercase fw-semibold">Corrective Actions</h6>
                <div class="alert p-0">
                  <p class="mb-0">
                    <span>
                      {{ incForm.corrective_action }}
                    </span>
                  </p>
                </div>
              </div>
            </div>



            <div class="col-lg-12">
              <div class="card-body p-4 border-top border-top-dashed d-print-none" v-if="fileFilter.length > 0">
                <h6 class="text-muted text-uppercase fw-semibold">Attachments</h6>
                <div class="table-responsive border">
                  <table class="table align-middle table-borderless table-nowrap mb-0 table-sm">
                    <thead class="table-active">
                      <tr>
                        <th class="ps-3" style="width: 40px">#</th>
                        <th>File Name</th>
                        <th>File Type</th>
                        <th>File Size</th>
                        <th>Actions</th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr v-for="(item, index) in fileFilter" :key="index">
                        <td class="ps-3">{{ index + 1 }}</td>
                        <td>
                          <div class="d-flex align-items-center">
                            <div class="flex-shrink-0 fs-17 me-2 filelist-icon text-secondary">
                              <i v-if="item.file_type == 'txt'" class="ri-file-text-fill text-info"></i>
                              <i v-else-if="item.file_type == 'docx'" class="ri-file-word-fill"></i>
                              <i v-else-if="item.file_type == 'xlsx'" class="ri-file-excel-fill text-success"></i>
                              <i v-else-if="item.file_type == 'pptx'" class="ri-file-ppt-fill text-danger"></i>
                              <i v-else-if="item.file_type == 'pdf'" class="ri-file-pdf-fill text-danger"></i>
                              <i v-else-if="item.file_type == 'jpg'" class="ri-image-fill text-success"></i>
                              <i v-else-if="item.file_type == 'jpeg'" class="ri-image-fill text-success"></i>
                              <i v-else-if="item.file_type == 'png'" class="ri-image-fill text-success"></i>
                              <i v-else-if="item.file_type == 'zip'" class="ri-folder-zip-line"></i>
                              <i v-else-if="item.file_type == 'mp4'" class="ri-video-line"></i>
                              <i v-else class="ri-file-unknow-fill text-warning"></i>
                            </div>
                            <div class="flex-grow-1 filelist-name">{{ item.file_name }}</div>
                          </div>
                        </td>
                        <td>{{ item.file_type }}</td>
                        <td>{{ item.size }}</td>
                        <td>
                          <div class="d-flex gap-2 justify-content-start">
                            <div v-if="item.note == 'new'">
                              <a href="#" class="link-success text-decoration-none fs-16" @click="removeFile(index)"><i class="ri-delete-bin-5-line text-danger"></i></a>
                            </div>
                            <a v-if="item.note !== 'new' && (item.file_type == 'jpg' || item.file_type == 'txt' || item.file_type == 'pdf' || item.file_type == 'jpeg' || item.file_type == 'png')" href="#" class="link-success text-decoration-none fs-14 pt-1" @click="viewFile(item.new_name)" title="View"><i class="ri-eye-line"></i></a>
                            <a v-else href="#" class="link-success text-decoration-none fs-14 pt-1" title="Not available to view" @click="notView"><i class="ri-eye-off-line"></i></a>
                            <a v-if="item.note !== 'new'" href="#" class="link-success text-decoration-none fs-16" @click="downloadFile(item.new_name)" title="Download"><i class="ri-download-2-line"></i></a>
                          </div>
                        </td>
                      </tr>
                    </tbody>
                  </table>
                </div>
              </div>

              <div class="col-lg-12">
                <div class="card-body p-4 pt-0">
                  <div class="hstack gap-2 justify-content-end d-print-none">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal" @click="viewMode = 'main'"> Close</button>
                    <a href="javascript:window.print()" class="btn btn-success"><i class="ri-printer-line align-bottom me-1"></i> Print</a>
                    <a href="javascript:void(0);" class="btn btn-info" @click="viewMode = 'main', editIncident()"><i class="ri-pencil-fill align-bottom me-1"></i> Edit</a>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>



    <!-- Incident Modal -->
    <div class="modal fade" id="incident-modal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-modal="true" role="dialog">
      <div class="modal-dialog modal-xl">
        <div class="modal-content">
          <div class="modal-header">
            <h5 v-if="actMode == 'add'" class="modal-title" id="customer-modal-title">Add Incident</h5>
            <h5 v-if="actMode == 'edit'" class="modal-title" id="customer-modal-title">Edit Incident</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-content border-0 mt-3">
            <ul class="nav nav-tabs nav-tabs-custom nav-success p-2 pb-0 bg-light" role="tablist">
              <li class="nav-item" role="presentation">
                <a class="nav-link active" id="incident-tab" data-bs-toggle="tab" href="#incident" role="tab" aria-selected="true">
                  Incident Details
                </a>
              </li>
              <li class="nav-item" role="presentation">
                <a class="nav-link" id="description-tab" data-bs-toggle="tab" href="#description" role="tab" aria-selected="false" tabindex="-1">
                  Incident Description
                </a>
              </li>
              <li class="nav-item" role="presentation">
                <a class="nav-link" id="corrective-tab" data-bs-toggle="tab" href="#corrective" role="tab" aria-selected="false" tabindex="-1">
                  Corrective Action
                </a>
              </li>
              <li class="nav-item" role="presentation">
                <a class="nav-link" id="attachment-tab" data-bs-toggle="tab" href="#attachment" role="tab" aria-selected="false" tabindex="-1">
                  Attachments
                </a>
              </li>
            </ul>
          </div>
          <div class="modal-body">
            <div class="tab-content">
              <div class="tab-pane active show" id="incident" role="tabpanel">
                <div class="row">
                  <div class="col-xl-2 col-lg-3">
                    <div class="mb-3">
                      <label class="form-label">Incident No. <span class="text-danger">*</span></label>
                      <input type="text" class="form-control" placeholder="Incident number" v-model="incForm.incident_no">
                    </div>
                  </div>
                  <div class="col-xl-2 col-lg-3">
                    <div class="mb-3">
                      <label class="form-label">Date Time <span class="text-danger">*</span></label>
                      <input type="text" id="date-time" class="form-control flatpickr-input flatpickr-single cursor-pointer" placeholder="Select date" v-model="incForm.date_time">
                    </div>
                  </div>
                  <div class="col-xl-8 col-lg-6">
                    <div class="mb-3">
                      <label class="form-label">Incident Title <span class="text-danger">*</span></label>
                      <input type="text" class="form-control" placeholder="Enter incident title" v-model="incForm.incident_title">
                    </div>
                  </div>
                  <div class="col-lg-4">
                    <div class="mb-3">
                      <label class="form-label">Location <span class="text-danger">*</span></label>
                      <input type="text" class="form-control" placeholder="Enter location" v-model="incForm.location">
                    </div>
                  </div>
                  <div class="col-lg-4">
                    <div class="mb-3">
                      <label class="form-label">Company <span class="text-danger">*</span></label>
                      <multiselect placeholder="Select company" :searchable="true" :searchStart="false" :options="lkCompany" v-model="incForm.company" @select="incForm.department = ''" />
                    </div>
                  </div>
                  <div class="col-lg-4">
                    <div class="mb-3" v-if="incForm.company !== 'XPPL'">
                      <label class="form-label">Subcontractor </label>
                      <input type="text" class="form-control" placeholder="Enter department" v-model="incForm.department">
                    </div>
                    <div class="mb-3" v-if="incForm.company == 'XPPL'">
                      <label class="form-label">Department <span class="text-danger">*</span></label>
                      <multiselect placeholder="Select department" :searchable="true" :searchStart="false" :options="lkDepartment" v-model="incForm.department" />
                    </div>
                  </div>
                  <div class="col-xl-2 col-lg-4">
                    <div class="mb-3">
                      <label class="form-label">Significant <span class="text-danger">*</span></label>
                      <multiselect placeholder="Select" :searchable="false" :searchStart="true" :options="lkYesNo" v-model="incForm.significant" />
                    </div>
                  </div>
                  <div class="col-xl-2 col-lg-4">
                    <div class="mb-3">
                      <label class="form-label">Flash Alert 24hr <span class="text-danger">*</span></label>
                      <multiselect placeholder="Select" :searchable="false" :searchStart="true" :options="lkYesNo" v-model="incForm.flash_alert" />
                    </div>
                  </div>
                  <div class="col-lg-4">
                    <div class="mb-3">
                      <label class="form-label">Incident Group <span class="text-danger">*</span></label>
                      <multiselect placeholder="Select incident group" :searchable="true" :searchStart="true" :options="lkIncGroup" v-model="incForm.incident_group" />
                    </div>
                  </div>
                  <div class="col-lg-4">
                    <div class="mb-3">
                      <label class="form-label">Incident Type <span class="text-danger">*</span></label>
                      <multiselect placeholder="Select incident type" :searchable="true" :searchStart="true" :options="lkIncType" v-model="incForm.incident_type" />
                    </div>
                  </div>
                  <div class="col-lg-4">
                    <div class="mb-3">
                      <label class="form-label">Injury Type <span class="text-danger">*</span></label>
                      <multiselect placeholder="Select injury type" :searchable="true" :searchStart="true" :options="lkInjType" v-model="incForm.injury_type" />
                    </div>
                  </div>
                  <div class="col-lg-4">
                    <div class="mb-3">
                      <label class="form-label">Injury Group <span class="text-danger">*</span></label>
                      <multiselect placeholder="Select injury group" :searchable="true" :searchStart="true" :options="lkInjGroup" v-model="incForm.injury_group" />
                    </div>
                  </div>
                  <div class="col-lg-4">
                    <div class="mb-3">
                      <label class="form-label">Injury Body Parts</label>
                      <input type="text" class="form-control" placeholder="Enter injury body part" v-model="incForm.injury_part">
                    </div>
                  </div>

                  <div class="col-xl-2 col-lg-4">
                    <div class="mb-3">
                      <label class="form-label">Actual Severity <span class="text-danger">*</span></label>
                      <multiselect placeholder="Select" :searchable="false" :searchStart="true" :options="lkActualSev" v-model="incForm.actual_severity" />
                    </div>
                  </div>
                  <div class="col-xl-2 col-lg-4">
                    <div class="mb-3">
                      <label class="form-label">Potential Severity <span class="text-danger">*</span></label>
                      <multiselect placeholder="Select" :searchable="false" :searchStart="true" :options="lkPotentialSev" v-model="incForm.potential_severity" />
                    </div>
                  </div>
                  <div class="col-xl-2 col-lg-3">
                    <div class="mb-3">
                      <label class="form-label">Risk Rating </label>
                      <input type="text" class="form-control" placeholder="Auto filled" v-model="incForm.risk_rating" readonly>
                    </div>
                  </div>
                  <div class="col-lg-3">
                    <div class="mb-3">
                      <label class="form-label">Invest Status <span class="text-danger">*</span></label>
                      <multiselect placeholder="Select status" :searchable="false" :searchStart="true" :options="lkInvestStatus" v-model="incForm.invest_status" />
                    </div>
                  </div>
                  <div class="col-lg-3">
                    <div class="mb-3">
                      <label class="form-label">Invest Lead</label>
                      <input type="text" class="form-control" placeholder="Enter invest lead name" v-model="incForm.invest_lead">
                    </div>
                  </div>
                  <div class="col-lg-3">
                    <div class="mb-3 mb-lg-0">
                      <label class="form-label">Action Status <span class="text-danger">*</span></label>
                      <multiselect placeholder="Select action status" :searchable="false" :searchStart="true" :options="lkActionStatus" v-model="incForm.action_status" />
                    </div>
                  </div>
                  <div class="col-lg-3">
                    <div class="mb-3 mb-lg-0">
                      <label class="form-label">Action Due Date</label>
                      <input type="text" id="due-date" class="form-control cursor-pointer flatpickr-input flatpickr-single" placeholder="Enter action due date" v-model="incForm.action_duedate">
                    </div>
                  </div>
                  <div class="col-lg-3">
                    <div class="mb-3 mb-lg-0">
                      <label class="form-label">Incident Manager</label>
                      <input type="text" class="form-control" placeholder="Enter person in charge" v-model="incForm.incident_manager">
                    </div>
                  </div>
                  <div class="col-xl-3 col-md-6">
                    <div class="mb-0">
                      <label class="form-label">Follow Up By</label>
                      <input type="text" class="form-control" placeholder="Enter follow up name" v-model="incForm.followup_by">
                    </div>
                  </div>
                </div>
                {{ riskRatingCalc }}
              </div>

              <div class="tab-pane" id="description" role="tabpanel">
                <div class="col-12">
                  <label class="form-label">Incident Description <span class="text-danger">*</span></label>
                  <textarea class="form-control" rows="12" placeholder="Enter nncident description" v-model="incForm.incident_descr"></textarea>
                </div>
              </div>

              <div class="tab-pane" id="corrective" role="tabpanel">
                <div class="col-12">
                  <label class="form-label">Corrective Action</label>
                  <textarea class="form-control" rows="12" placeholder="Enter corrective action" v-model="incForm.corrective_action"></textarea>
                </div>
              </div>

              <!-- Attachments Tab -->
              <div class="tab-pane" id="attachment" role="tabpanel">
                <div class="card-header align-items-center d-flex border-0">
                  <div class="flex-shrink-0">
                    <button type="button" class="btn btn-soft-info btn-sm" @click="newFile()"><i class="ri-upload-2-fill me-1 align-bottom"></i> Upload</button>
                    <input class="d-none" ref="fileInput" type="file" multiple @change="addNewFile()">
                  </div>
                </div>
                <div class="table-responsive border">
                  <table class="table align-middle table-borderless table-nowrap mb-0 table-sm">
                    <thead class="table-active">
                      <tr>
                        <th class="ps-3" style="width: 40px">#</th>
                        <th>File Name</th>
                        <th>File Type</th>
                        <th>File Size</th>
                        <th>Actions</th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr v-for="(item, index) in fileFilter" :key="index">
                        <td class="ps-3">{{ index + 1 }}</td>
                        <td>
                          <div class="d-flex align-items-center">
                            <div class="flex-shrink-0 fs-17 me-2 filelist-icon text-secondary">
                              <i v-if="item.file_type == 'txt'" class="ri-file-text-fill text-info"></i>
                              <i v-else-if="item.file_type == 'docx'" class="ri-file-word-fill"></i>
                              <i v-else-if="item.file_type == 'xlsx'" class="ri-file-excel-fill text-success"></i>
                              <i v-else-if="item.file_type == 'pptx'" class="ri-file-ppt-fill text-danger"></i>
                              <i v-else-if="item.file_type == 'pdf'" class="ri-file-pdf-fill text-danger"></i>
                              <i v-else-if="item.file_type == 'jpg'" class="ri-image-2-fill text-success"></i>
                              <i v-else-if="item.file_type == 'jpeg'" class="ri-image-2-fill text-success"></i>
                              <i v-else-if="item.file_type == 'png'" class="ri-image-2-fill text-success"></i>
                              <i v-else-if="item.file_type == 'zip'" class="ri-folder-zip-line"></i>
                              <i v-else-if="item.file_type == 'mp4'" class="ri-video-line"></i>
                              <i v-else class="ri-file-unknow-fill text-warning"></i>
                            </div>
                            <div class="flex-grow-1 filelist-name">{{ item.file_name }}</div>
                          </div>
                        </td>
                        <td>{{ item.file_type }}</td>
                        <td>{{ item.size }}</td>
                        <td>
                          <div class="d-flex gap-2 justify-content-start">
                            <div v-if="item.note == 'new'">
                              <a href="#" class="link-success text-decoration-none fs-16" @click="removeFile(index)"><i class="ri-delete-bin-5-line text-danger"></i></a>
                            </div>
                            <a v-if="item.note !== 'new' && (item.file_type == 'jpg' || item.file_type == 'txt' || item.file_type == 'pdf' || item.file_type == 'jpeg' || item.file_type == 'png')" href="#" class="link-success text-decoration-none fs-14 pt-1" @click="viewFile(item.new_name)" title="View"><i class="ri-eye-line"></i></a>
                            <a v-else href="#" class="link-success text-decoration-none fs-14 pt-1" title="Not available to view" @click="notView"><i class="ri-eye-off-line"></i></a>
                            <a v-if="item.note !== 'new'" href="#" class="link-success text-decoration-none fs-16" @click="downloadFile(item.new_name)" title="Download"><i class="ri-download-2-line"></i></a>
                            <a v-if="item.note !== 'new'" href="#" class="link-success text-decoration-none fs-16" @click="delFile(item.file_id, item.new_name, index)" title="Delete"><i class="ri-delete-bin-5-line"></i></a>
                          </div>
                        </td>
                      </tr>
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
          </div>
          <div class="modal-footer" style="display: block;">
            <div class="hstack gap-2 justify-content-end">
              <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
              <button v-if="actMode == 'add'" type="button" class="btn btn-success" :class="incFormDis" @click="addIncident">Add Incident</button>
              <button v-if="actMode == 'edit'" type="button" class="btn btn-success" :class="incFormDis" @click="updIncident">Save Change</button>
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
              <h4 class="fs-semibold">You are about to delete a record ?</h4>
              <p class="text-muted fs-14 mb-4 pt-1">Deleting your record will remove all of your information from our database.</p>
              <div class="hstack gap-2 justify-content-center remove">
                <!-- <button class="btn btn-light" data-bs-dismiss="modal" data-bs-toggle="modal" data-bs-target="#incident-modal">Cancel</button> -->
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
import { useAuthStore } from '../stores/auth.js';
import { useStore } from '../stores/store.js';
import { useToastr } from '../toastr.js';
const toastr = useToastr();

export default {
  name: 'XpplAppSafetyIncident',
  components: { AgGridVue },
  setup() {
    const store = useStore();
    const authStore = useAuthStore();
    return { store, authStore };
  },

  data() {
    return {
      columnDefs: [
        {
          headerName: '#', minWidth: 50, maxWidth: 50, sortable: false, resizable: false, suppressMovable: true, suppressMenu: true, valueGetter: (params) => { return params.node.rowIndex + 1 },
          cellStyle: p => {
            if (Number(p.data.risk_rating) <= 3) {
              return { backgroundColor: '#3AB249', 'text-align': 'center' };
            } else if (Number(p.data.actual_severity) == 2 && Number(p.data.potential_severity) == 2) {
              return { backgroundColor: '#3AB249', 'text-align': 'center' };
            } else if (Number(p.data.actual_severity) !== Number(p.data.potential_severity) && Number(p.data.risk_rating) == 4) {
              return { backgroundColor: '#F7EC0F', 'text-align': 'center' };
            } else if (Number(p.data.risk_rating) >= 5 && Number(p.data.risk_rating) <= 9) {
              return { backgroundColor: '#F7EC0F', 'text-align': 'center' };
            } else if (Number(p.data.risk_rating) >= 10 && Number(p.data.risk_rating) <= 12) {
              return { backgroundColor: '#F89122', 'text-align': 'center' };
            } else if (Number(p.data.risk_rating) > 12) {
              return { backgroundColor: '#E52125', 'text-align': 'center' };
            };
            return { 'text-align': 'center' };
          },
        },
        { headerName: 'Incident ID', field: 'incident_id', filter: 'agSetColumnFilter', hide: true },
        { headerName: 'No', field: 'incident_no', maxWidth: 100, filter: 'agSetColumnFilter', valueGetter: p => Number(p.data.incident_no) },
        { headerName: 'Incident Title', field: 'incident_title', minWidth: 250, filter: 'agSetColumnFilter', },
        { headerName: 'Date Time', field: 'date_time', minWidth: 140, filter: 'agSetColumnFilter', valueFormatter: p => p.value ? moment(p.value).format('DD-MM-YYYY HH:mm') : '' },
        { headerName: 'Location', field: 'location', filter: 'agSetColumnFilter' },
        { headerName: 'Company', field: 'company', filter: 'agSetColumnFilter' },
        { headerName: 'Department', field: 'department', filter: 'agSetColumnFilter' },
        { headerName: 'Incident Group', field: 'incident_group', filter: 'agSetColumnFilter' },
        { headerName: 'Incident Type', field: 'incident_type', filter: 'agSetColumnFilter' },
        { headerName: 'Significant', field: 'significant', filter: 'agSetColumnFilter' },
        { headerName: 'Flash Alert 24hr', field: 'flash_alert', filter: 'agSetColumnFilter' },
        { headerName: 'Injury Type', field: 'injury_type', filter: 'agSetColumnFilter' },
        { headerName: 'Injury Group', field: 'injury_group', filter: 'agSetColumnFilter' },
        { headerName: 'Injury Body Part', field: 'injury_part', filter: 'agSetColumnFilter' },
        { headerName: 'Actual Severity', field: 'actual_severity', filter: 'agSetColumnFilter', valueGetter: p => Number(p.data.actual_severity) },
        { headerName: 'Potential Severity', field: 'potential_severity', filter: 'agSetColumnFilter', valueGetter: p => Number(p.data.potential_severity) },
        { headerName: 'Risk Rating', field: 'risk_rating', filter: 'agSetColumnFilter', valueGetter: p => Number(p.data.risk_rating) },
        { headerName: 'Invest Status', field: 'invest_status', filter: 'agSetColumnFilter' },
        { headerName: 'Invest Lead', field: 'invest_lead', filter: 'agSetColumnFilter' },
        { headerName: 'Action Status', field: 'action_status', filter: 'agSetColumnFilter' },
        { headerName: 'Action Due Date', field: 'action_duedate', valueFormatter: p => p.value ? moment(p.value).format('DD-MM-YYYY') : '' },
        { headerName: 'Incident Manager', field: 'incident_manager', filter: 'agSetColumnFilter' },
        { headerName: 'Followup By', field: 'followup_by', filter: 'agSetColumnFilter' },
        { headerName: 'Corrective Action', field: 'corrective_action' },
        { headerName: 'Incident Description', field: 'incident_descr' },
        { headerName: 'Created at', field: 'created_at', maxWidth: 145, hide: true, valueFormatter: p => p.value ? moment(p.value).format('DD-MM-YYYY HH:mm:ss') : '' },
        { headerName: 'Created by', field: 'created_by', maxWidth: 150, hide: true, filter: 'agSetColumnFilter' },
        { headerName: 'Updated at', field: 'updated_at', maxWidth: 145, hide: true, valueFormatter: p => p.value ? moment(p.value).format('DD-MM-YYYY HH:mm:ss') : '' },
        { headerName: 'Updated by', field: 'updated_by', maxWidth: 150, hide: true, filter: 'agSetColumnFilter' },

      ],

      defaultColDef: {
        sortable: true,
        resizable: true,
        flex: 1,
        filterParams: { buttons: ['reset'] },
        minWidth: 130,
      },

      incForm: { data_id: '', incident_id: '', incident_no: '', incident_title: '', date_time: '', location: '', company: null, department: null, incident_group: null, incident_type: null, injury_type: null, injury_group: null, injury_part: '', significant: null, flash_alert: null, actual_severity: null, potential_severity: null, risk_rating: '', invest_status: null, invest_lead: '', action_status: null, action_duedate: '', incident_manager: '', followup_by: '', incident_descr: '', corrective_action: '' },

      lkYesNo: ['Yes', 'No', 'N/A'],
      lkActionStatus: [],
      lkActualSev: [],
      lkCompany: [],
      lkDepartment: [],
      lkIncGroup: [],
      lkIncType: [],
      lkInjGroup: [],
      lkInjType: [],
      lkInvestStatus: [],
      lkPotentialSev: [],

      auth: [],
      search: '',
      incidents: [],
      years: [],
      files: [],
      fileFilter: [],

      mode: 'Month',
      value: '',
      actMode: '',
      viewMode: 'main',
      loading: false,


    };
  },

  mounted() {
    flatpickr(".flatpickr-single", {
      altInput: true,
      altFormat: 'd-m-Y'
    });

    flatpickr(".flatpickr-range", {
      altInput: true,
      mode: 'range',
      altFormat: 'd-m-Y'
    });

  },

  computed: {
    incidentList() {
      const searchTerm = this.search.trim().toLowerCase();
      if (!searchTerm) return this.incidents;
      const searchFields = ['incident_title', 'company', 'incident_no', 'invest_status', 'injury_type', 'injury_group', 'risk_rating'];
      return this.incidents.filter(e =>
        searchFields.some(field => e[field]?.toLowerCase().startsWith(searchTerm))
      );
    },

    incFormDis() {
      let f = this.incForm;
      if (f.company == 'XPPL') {
        if (f.incident_no == '' || f.date_time == '' || f.incident_title == '' || f.location == '' || f.company == null || f.department == null || f.department == '' || f.significant == null || f.flash_alert == null || f.incident_group == null || f.incident_type == null || f.injury_type == null || f.injury_group == null || f.actual_severity == null || f.potential_severity == null || f.invest_status == null || f.action_status == null || f.incident_descr == '') {
          return 'disabled';
        } else {
          return '';
        };
      } else {
        if (f.incident_no == '' || f.date_time == '' || f.incident_title == '' || f.location == '' || f.company == null || f.significant == null || f.flash_alert == null || f.incident_group == null || f.incident_type == null || f.injury_type == null || f.injury_group == null || f.actual_severity == null || f.potential_severity == null || f.invest_status == null || f.action_status == null || f.incident_descr == '') {
          return 'disabled';
        } else {
          return '';
        };
      };
    },

    riskRatingCalc() {
      let f = this.incForm;
      if (f.actual_severity && f.potential_severity) {
        f.risk_rating = Number(f.actual_severity) * Number(f.potential_severity);
      } else {
        f.risk_rating = '';
      };
    },
  },

  methods: {
    async onLoad() {
      this.loading = true;

      const submenu = 'M08S01';
      const authorise = await axios.get(`api/auth/auth-action?submenu=${submenu}`, { headers: { Authorization: 'Bearer ' + this.authStore.getToken } });
      this.auth = authorise.data[0];

      const date = new Date();
      let y = date.getFullYear();
      let m = String(date.getMonth() + 1).padStart(2, '0');
      this.value = `${y}-${m}`;

      const data = await this.getIncident('Month');
      const file = await this.getFile();
      const year = await axios.get('api/safety/years', { headers: { Authorization: 'Bearer ' + this.authStore.getToken } });
      this.years = year.data;

      document.getElementById('getBy-1').classList.add('disabled');

      const codes = await axios.get('api/safety/codes', { headers: { Authorization: 'Bearer ' + this.authStore.getToken } });
      const category = [
        { cate: 'Action Status', lk: 'lkActionStatus', lb: 'descr_eng' },
        { cate: 'Actual Severity', lk: 'lkActualSev', lb: 'descr_eng' },
        { cate: 'Company', lk: 'lkCompany', lb: 'code' },
        { cate: 'Incident Group', lk: 'lkIncGroup', lb: 'code' },
        { cate: 'Incident Type', lk: 'lkIncType', lb: 'code' },
        { cate: 'Injury Body Group', lk: 'lkInjGroup', lb: 'code' },
        { cate: 'Injury Type', lk: 'lkInjType', lb: 'code' },
        { cate: 'Investigation Status', lk: 'lkInvestStatus', lb: 'code' },
        { cate: 'Potential Severity', lk: 'lkPotentialSev', lb: 'descr_eng' },
      ];

      for (let j = 0; j < category.length; j++) {
        let cateName = category[j].cate;
        let lkName = category[j].lk;
        let labelCol = category[j].lb;

        let item = codes.data.filter(e => e.category == [cateName] && e.active == 1);
        this[lkName] = [];
        for (let i = 0; i < item.length; i++) {
          this[lkName].push({
            value: item[i].code,
            label: item[i][labelCol]
          });
        };
      };

      // Department Code
      const depts = await axios.get('/api/safety/departments', { headers: { Authorization: 'Bearer ' + this.authStore.getToken } });
      const items = depts.data.filter(e => e.active == 1);
      items.forEach(e => {
        this.lkDepartment.push(e.code);
      });


      this.loading = false;
    },

    async getFile() {
      const response = await axios.get('/api/safety/incident-files', { headers: { Authorization: 'Bearer ' + this.authStore.getToken } });
      this.files = response.data;
    },

    async getMonth() {
      this.mode = 'Month';
      this.incidents = [];

      this.selectedMode('mode-1');
      this.disableGetBy('getBy-1');

      const selected = document.getElementById('mode-1');
      selected.type = 'month';
      selected.classList.remove('d-none');

      const date = new Date();
      let y = date.getFullYear();
      let m = String(date.getMonth() + 1).padStart(2, '0');

      this.value = `${y}-${m}`;
      const data = await this.getIncident('Month')
    },

    async getYear() {
      this.mode = 'Year';
      this.incidents = [];
      this.selectedMode('mode-2');
      this.disableGetBy('getBy-2');

      const date = new Date();
      let y = date.getFullYear();
      this.value = `${y}`;
      const data = await this.getIncident('Year');
    },

    async getRange() {
      this.mode = 'Range';
      this.incidents = [];
      this.selectedMode('mode-3');
      this.disableGetBy('getBy-3');
    },

    async getIncident(mode) {
      this.loading = true;
      this.incidents = [];
      const response = await axios.get(`api/safety/incidents?requestValue=${this.value}&requestMode=${mode}`, { headers: { Authorization: 'Bearer ' + this.authStore.getToken } });
      this.incidents = response.data;
      this.loading = false;
    },

    async getIncidentRange() {
      this.incidents = [];
      let dateFr = moment(this.value.substring(0, 10)).format('YYYY-MM-DD');
      let dateTo = moment(this.value.substring(14, 24)).format('YYYY-MM-DD');

      if (this.value && this.value.length > 12) {
        this.loading = true;
        const result = await axios.get(`api/safety/incidents?dateFr=${dateFr}&dateTo=${dateTo}`, { headers: { Authorization: 'Bearer ' + this.authStore.getToken } });
        this.incidents = result.data;
        this.loading = false;
      }
    },

    selectedMode(id) {
      const elements = document.querySelectorAll('[id^="mode-"]');
      elements.forEach((e) => {
        e.classList.add('d-none');
      });

      const slected = document.getElementById(id);
      slected.type = 'text';
      slected.classList.remove('d-none');

      flatpickr(".flatpickr-single", {
        altInput: true,
        altFormat: 'd-m-Y'
      });

      flatpickr(".flatpickr-range", {
        altInput: true,
        mode: 'range',
        altFormat: 'd-m-Y'
      });
    },

    async newIncident() {
      if (this.auth.new == 0) {
        toastr.warning("You're not authorized to add!");
      } else {
        this.actMode = 'add';
        const lastNo = await axios.get('/api/safety/incident-nextno', { headers: { Authorization: 'Bearer ' + this.authStore.getToken } });

        let f = this.incForm;
        f.data_id = '';
        f.incident_id = '';
        f.incident_no = lastNo.data[0].next
        f.incident_title = '';
        f.location = '';
        f.company = null;
        f.department = null;
        f.incident_group = null;
        f.incident_type = null;
        f.injury_type = null;
        f.injury_group = null;
        f.injury_part = '';
        f.significant = null;
        f.flash_alert = null;
        f.actual_severity = null;
        f.potential_severity = null;
        f.risk_rating = '';
        f.invest_status = null;
        f.invest_lead = '';
        f.action_status = null;
        f.incident_manager = '';
        f.followup_by = '';
        f.incident_descr = '';
        f.corrective_action = '';

        this.fileFilter = [];

        flatpickr('#date-time', {
          altInput: true,
          altFormat: 'd-m-Y H:i',
          enableTime: true,
          time_24hr: true,
          enableSeconds: false,
          minuteIncrement: 1,
          hourIncrement: 1,
          time_disabled: ["00:00"],
        }).clear();

        flatpickr('#due-date', {
          altInput: true,
          altFormat: 'd-m-Y'
        }).clear();


        this.firstTabSelect();
        this.disableMenu();
        $('#incident-modal').modal('show');

      }
    },

    async addIncident() {
      let fd = new FormData();
      for (let i = 0; i < this.fileFilter.length; i++) {
        let f = this.fileFilter[i];
        fd.append('files[' + i + ']', f.file);
      }

      let f = this.incForm;
      fd.append('incident_no', f.incident_no);
      fd.append('date_time', f.date_time);
      fd.append('incident_title', f.incident_title);
      fd.append('location', f.location);
      fd.append('company', f.company);
      fd.append('significant', f.significant);
      fd.append('flash_alert', f.flash_alert);
      fd.append('incident_group', f.incident_group);
      fd.append('incident_type', f.incident_type);
      fd.append('injury_type', f.injury_type);
      fd.append('injury_group', f.injury_group);
      fd.append('actual_severity', f.actual_severity);
      fd.append('potential_severity', f.potential_severity);
      fd.append('risk_rating', f.risk_rating);
      fd.append('invest_status', f.invest_status);
      fd.append('action_status', f.action_status);
      fd.append('incident_descr', f.incident_descr);

      f.department ? fd.append('department', f.department) : '';
      f.injury_part ? fd.append('injury_part', f.injury_part) : '';
      f.invest_lead ? fd.append('invest_lead', f.invest_lead) : '';
      f.action_duedate ? fd.append('action_duedate', f.action_duedate) : '';
      f.incident_manager ? fd.append('incident_manager', f.incident_manager) : '';
      f.followup_by ? fd.append('followup_by', f.followup_by) : '';
      f.corrective_action ? fd.append('corrective_action', f.corrective_action) : '';

      const response = await axios.post('api/safety/add-incident', fd, { headers: { 'Content-Type': 'multipart/form-data', Authorization: 'Bearer ' + this.authStore.getToken } })
      if (response.data.success) {
        if (this.mode == 'Range') {
          const data = await this.getIncidentRange();
        } else {
          const data = await this.getIncident(this.mode);
        };
        const file = await this.getFile();
        $('#incident-modal').modal('hide');
        toastr.success('Add successfully!');
      } else {
        toastr.error(`${response.data.message}`);
      }
    },

    editIncident() {
      if (this.auth.edit == 0) {
        toastr.warning("You're not authorized to edit!");
      } else {
        this.actMode = 'edit';

        flatpickr('#date-time', {
          altInput: true,
          altFormat: 'd-m-Y H:i',
          enableTime: true,
          time_24hr: true,
          enableSeconds: false,
          minuteIncrement: 1,
          hourIncrement: 1,
          time_disabled: ["00:00"],
        });

        flatpickr('#due-date', {
          altInput: true,
          altFormat: 'd-m-Y'
        });

        this.firstTabSelect();
        $('#incident-modal').modal('show');
      }
    },

    async updIncident() {
      let fd = new FormData();
      for (let i = 0; i < this.fileFilter.length; i++) {
        let f = this.fileFilter[i];
        if (f.note == 'new') {
          fd.append('files[' + i + ']', f.file);
        };
      };

      let f = this.incForm;
      fd.append('data_id', f.data_id);
      fd.append('incident_id', f.incident_id);
      fd.append('incident_no', f.incident_no);
      fd.append('date_time', f.date_time);
      fd.append('incident_title', f.incident_title);
      fd.append('location', f.location);
      fd.append('company', f.company);
      fd.append('significant', f.significant);
      fd.append('flash_alert', f.flash_alert);
      fd.append('incident_group', f.incident_group);
      fd.append('incident_type', f.incident_type);
      fd.append('injury_type', f.injury_type);
      fd.append('injury_group', f.injury_group);
      fd.append('actual_severity', f.actual_severity);
      fd.append('potential_severity', f.potential_severity);
      fd.append('risk_rating', f.risk_rating);
      fd.append('invest_status', f.invest_status);
      fd.append('action_status', f.action_status);
      fd.append('incident_descr', f.incident_descr);

      f.department ? fd.append('department', f.department) : '';
      f.injury_part ? fd.append('injury_part', f.injury_part) : '';
      f.invest_lead ? fd.append('invest_lead', f.invest_lead) : '';
      f.action_duedate ? fd.append('action_duedate', f.action_duedate) : '';
      f.incident_manager ? fd.append('incident_manager', f.incident_manager) : '';
      f.followup_by ? fd.append('followup_by', f.followup_by) : '';
      f.corrective_action ? fd.append('corrective_action', f.corrective_action) : '';

      try {
        const response = await axios.post('api/safety/upd-incident', fd, { headers: { 'Content-Type': 'multipart/form-data', Authorization: 'Bearer ' + this.authStore.getToken } })

        if (this.mode == 'Range') {
          const data = await this.getIncidentRange();
        } else {
          const data = await this.getIncident(this.mode);
        };
        const file = await this.getFile();
        this.disableMenu();
        $('#incident-modal').modal('hide');
        toastr.success('Update successfully!');

      } catch (error) {
        toastr.error('This code already exists in the database.');
      };

    },

    newFile() {
      this.$refs.fileInput.click();
    },

    addNewFile() {
      let file = this.$refs.fileInput.files;
      for (let i = 0; i < file.length; i++) {
        let check = this.fileFilter.find((e) => e.file_name == file[i].name);
        if (!check) {
          this.fileFilter.push({
            file: file[i],
            file_name: file[i].name,
            file_type: this.store.fileType(file[i].name),
            size: (file[i].size / 1024).toFixed(0) + ' KB',
            note: 'new'
          });
        }
      }
    },

    removeFile(index) {
      this.fileFilter.splice(index, 1);
    },

    delFile(id, file, index) {
      if (this.auth.del == 0) {
        toastr.warning("You're not authorized to delete!");
      } else {
        this.$swal.fire({
          text: 'Do you want to delete this file?',
          icon: 'question',
          showCancelButton: true,
          confirmButtonText: '<i class="fe fe-trash-2"></i> <span class="fs-14 fw-light">Delete</span>',
          cancelButtonText: '<i class="fe fe-x"></i> <span class="fs-14 fw-light">Cancel</span>',
          confirmButtonColor: '#d33',
          allowEnterKey: false,
          allowOutsideClick: false,
        }).then((result) => {
          if (result.isConfirmed) {
            axios.post('api/safety/del-file', {
              file_id: id,
              new_name: file
            }, { headers: { Authorization: 'Bearer ' + this.authStore.getToken } }).then((response) => {

              toastr.success('Delete successfully!');
              this.fileFilter.splice(index, 1);
              this.getFile();

            }).catch((error) => {
              console.log(error);
            })
          }
        });
      }
    },

    delIncident() {
      if (this.auth.del == 0) {
        toastr.warning("You're not authorized to delete!");
      } else {
        $('#delete-modal').modal('show');
      };
    },

    async delConfirm() {
      try {
        const response = await axios.post('api/safety/del-incident', {
          incident_id: this.incForm.incident_id,
          fileList: this.fileFilter
        }, { headers: { Authorization: 'Bearer ' + this.authStore.getToken } });

        if (this.mode == 'Range') {
          const data = await this.getIncidentRange();
        } else {
          const data = await this.getIncident(this.mode);
        };
        const file = await this.getFile();
        this.disableMenu();
        $('#delete-modal').modal('hide');
        toastr.success('Delete Successfully.');

      } catch (err) {
        toastr.error(`${err}`);
      };
    },

    cellCicked(e) {
      this.enableMenu();
      let f = this.incForm;
      f.data_id = e.data.data_id;
      f.incident_id = e.data.incident_id;
      f.incident_no = e.data.incident_no;
      f.incident_title = e.data.incident_title;
      f.date_time = e.data.date_time;
      f.location = e.data.location;
      f.company = e.data.company;
      f.department = e.data.department;
      f.incident_group = e.data.incident_group;
      f.incident_type = e.data.incident_type;
      f.injury_type = e.data.injury_type;
      f.injury_group = e.data.injury_group;
      f.injury_part = e.data.injury_part;
      f.significant = e.data.significant;
      f.flash_alert = e.data.flash_alert;
      f.actual_severity = e.data.actual_severity;
      f.potential_severity = e.data.potential_severity;
      f.risk_rating = e.data.risk_rating;
      f.invest_status = e.data.invest_status;
      f.invest_lead = e.data.invest_lead;
      f.action_status = e.data.action_status;
      f.action_duedate = e.data.action_duedate;
      f.incident_manager = e.data.incident_manager;
      f.followup_by = e.data.followup_by;
      f.incident_descr = e.data.incident_descr;
      f.corrective_action = e.data.corrective_action;

      let file = this.files.filter(e => e.incident_id == this.incForm.incident_id);
      this.fileFilter = file;
    },

    viewIncident() {
      this.viewMode = 'view';
    },

    downloadFile(file) {
      const url = `/api/downloads/incident-file/${file}`;
      window.location.href = url;
    },

    viewFile(file) {
      window.open(window.location.origin + '/assets/images/incidents/' + file, '_blank')
    },

    notView() {
      toastr.info("File isn't viewable; please download instead.");
    },



    firstTabSelect() {
      const tab = document.querySelectorAll('[data-bs-toggle="tab"]');
      Array.from(tab).forEach(function (e) {
        e.classList.remove('active')
      });
      document.getElementById('incident-tab').classList.add('active');

      const cont = document.querySelectorAll('.tab-pane');
      Array.from(cont).forEach(function (e) {
        e.classList.remove('active', 'show')
      });
      document.getElementById('incident').classList.add('active', 'show');
    },

    enableMenu() {
      const elements = document.querySelectorAll('[id^="menu-"]');
      elements.forEach(e => {
        e.classList.remove('disabled');
      });
    },

    disableGetBy(id) {
      const elements = document.querySelectorAll('[id^="getBy-"]');
      elements.forEach(e => {
        e.classList.remove('disabled');
      });
      document.getElementById(id).classList.add('disabled');
    },

    disableMenu() {
      const elements = document.querySelectorAll('[id^="menu-"]');
      elements.forEach(e => {
        e.classList.add('disabled');
      });
      document.getElementById('menu-1').classList.remove('disabled');
    },

    onSearch() {
      this.search ? document.getElementById('search-close').classList.remove('d-none') : document.getElementById('search-close').classList.add('d-none');
    },

    searchClear() {
      document.getElementById('search-close').classList.add('d-none');
      this.search = '';
    },
  },

  created() {
    this.onLoad();
  }
};
</script>