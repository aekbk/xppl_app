<template>
  <div>
    <div v-if="loading">
      <loading />
    </div>
    <div v-else>
      <div class="card" id="main" v-if="viewMode == 'main'">
        <div class="card-header">
          <div class="row g-4 align-items-center">
            <div class="col-sm-3">
              <form class="app-search d-md-block py-0 ps-0">
                <div class="position-relative">
                  <input type="text" class="form-control" placeholder="Search..." v-model="search" @input="onSearch()">
                  <span class="ri-search-line search-icon search-widget-icon fs-14"></span>
                  <span class="mdi mdi-close-circle search-widget-icon search-widget-icon-close cursor-pointer d-none" id="search-close" @click="searchClear()"></span>
                </div>
              </form>
            </div>
            <div class="col-sm-auto ms-auto">
              <div class="hstack gap-2">
                <button type="button" class="btn btn-soft-info add-btn" id="create-btn" @click="newContract()"><i class="ri-add-line align-bottom me-1"></i> Add Contract</button>
                <button class="btn btn-soft-info btn-icon" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                  <i class="ri-more-2-fill"></i>
                </button>
                <ul class="dropdown-menu dropdown-menu-end dropdownmenu-secondary">
                  <li><a class="dropdown-item disabled" id="contract-dw-1" href="javascript:void(0);" @click="viewContract()"><i class="ri-eye-fill align-bottom me-2 text-muted"></i>View</a></li>
                  <li><a class="dropdown-item disabled" id="contract-dw-2" href="javascript:void(0);" @click="editContract()"><i class="ri-pencil-fill align-bottom me-2 text-muted"></i>Edit</a></li>
                  <li><a class="dropdown-item disabled" id="contract-dw-3" href="javascript:void(0);" @click="delContract()"><i class="ri-delete-bin-fill align-bottom me-2 text-muted"></i>Delete</a></li>
                  <div class="dropdown-divider"></div>
                  <li><a class="dropdown-item disabled" id="contract-dw-4" href="javascript:void(0);" @click="orderOpen()"><i class="ri-todo-fill align-bottom me-2 text-muted"></i>Orders</a></li>
                  <li><a class="dropdown-item disabled" id="contract-dw-5" href="javascript:void(0);" @click="editAttachment()"><i class="ri-attachment-line align-bottom me-2 text-muted"></i>Attachments</a></li>
                </ul>
              </div>
            </div>
          </div>
        </div>
        <ag-grid-vue style="height: calc(100vh - 15.80rem);" class="ag-theme-material" :columnDefs="columnDefs" :rowData="contractList" :defaultColDef="defaultColDef" :rowHeight="36" :headerHeight="44" :suppressMenuHide="false" :suppressCellFocus="true" animateRows="false" rowSelection="single" @rowClicked="cellCicked" @cell-double-clicked="viewContract"></ag-grid-vue>
        <div class="pb-1"></div>
      </div>
    </div>

    <!-- View Contracts -->
    <div class="row justify-content-center" v-if="viewMode == 'view'">
      <div class="col-xxl-8 col-lg-9">
        <div class="card" id="demo">
          <div class="row">
            <div class="col-lg-12">
              <div class="card-header border-bottom-dashed p-4">
                <div class="d-xl-flex">
                  <div class="flex-grow-1">
                    <h5 class="text-uppercase fw-semibold">{{ customerFilter.customer_name }}</h5>
                    <div class="mt-xl-4 mt-4">
                      <h6 class="text-muted text-uppercase fw-semibold">Address</h6>
                      <p class="mb-1">{{ customerFilter.full_address }}</p>
                      <p class="mb-1"><span class="text-muted">Country: </span>{{ customerFilter.country }}</p>
                      <p class="mb-1"><span class="text-muted">Destination: </span>{{ customerFilter.destination }}</p>
                      <!-- <p class="mb-1"><span class="text-muted">Tax Code: </span>{{ customerFilter.tax_code }}</p> -->
                    </div>
                  </div>
                  <div class="flex-shrink-0 mt-xl-0 mt-3">
                    <!-- <h6><span class="text-muted fw-normal">Customer ID: </span><span>{{ customerFilter.customer_id }}</span></h6> -->
                    <h6><span class="text-muted fw-normal">Customer Code: </span><span>{{ customerFilter.customer_code }}</span></h6>
                    <h6><span class="text-muted fw-normal">Tax Code: </span><span> {{ customerFilter.tax_code }}</span></h6>
                    <h6><span class="text-muted fw-normal">Email: </span><span>{{ customerFilter.email }}</span></h6>
                    <h6><span class="text-muted fw-normal">Contact: </span><span> {{ customerFilter.contract }}</span></h6>
                    <h6><span class="text-muted fw-normal">Contact No: </span><span> {{ customerFilter.phone }}</span></h6>
                  </div>
                </div>
              </div>
            </div>

            <div class="col-lg-12">
              <div class="card-header p-4 border-0">
                <div class="d-xl-flex">
                  <div class="flex-grow-1">
                    <h6 class="text-muted text-uppercase fw-semibold">Contract Details</h6>
                    <div class="row">
                      <div class="col-lg-6">
                        <p class="mb-1"><span class="text-muted">Contract No: </span>{{ customerFilter.contract_no }}</p>
                        <p class="mb-1"><span class="text-muted">Appendix: </span>{{ customerFilter.appendix }}</p>
                        <p class="mb-1"><span class="text-muted">Signed Date: </span>{{ store.fullMonth(customerFilter.signed_date) }}</p>
                      </div>
                      <div class="col-12">
                        <p class="mb-1"><span class="text-muted">Loading Place: </span>{{ customerFilter.loading_place }}</p>
                        <p class="mb-1"><span class="text-muted">Delivery Place: </span>{{ customerFilter.delivery_place }}</p>
                      </div>
                    </div>
                  </div>
                  <div class="flex-shrink-0 mt-xl-0 mt-3">
                    <p class="mb-1"><span class="text-muted">Quantity: </span>{{ store.numInt(customerFilter.contract_quantity) }} T</p>
                    <p class="mb-1"><span class="text-muted">Grade: </span>{{ customerFilter.contract_grade_name }}</p>
                    <p class="mb-1"><span class="text-muted">Grade GAR: </span>{{ customerFilter.contract_grade_gar }}</p>
                    <p class="mb-1"><span class="text-muted">Status: </span>
                      <span v-if="customerFilter.contract_status == 'Active'" class="badge bg-danger-subtle text-danger fs-14 ms-1">{{ customerFilter.contract_status }}</span>
                      <span v-else class="badge bg-success-subtle text-success fs-14 me-1">{{ customerFilter.contract_status }}</span>
                    </p>
                  </div>
                </div>
              </div>
            </div>

            <div class="col-lg-12">
              <div class="card-body p-4 border-top border-top-dashed">
                <h6 class="text-muted text-uppercase fw-semibold">Order Details</h6>
                <div class="table-responsive border">
                  <table class="table align-middle table-borderless table-nowrap mb-0">
                    <thead class="table-active text-muted">
                      <tr>
                        <th style="width: 30px;">#</th>
                        <th>Order Date</th>
                        <th>Grade</th>
                        <th>Grade GAR</th>
                        <th>Quantity</th>
                        <th>Initial Price</th>
                        <th>Currency</th>
                        <th>VAT Remark</th>
                        <th>Price Term</th>
                        <th>CO Number</th>
                        <th>Appendix</th>
                        <th>Status</th>
                        <th class="d-print-none">Remark</th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr v-for="(item, index) in orderFilter" :key="index">
                        <td>{{ index + 1 }}</td>
                        <td>{{ store.ddmmyyyy(item.order_date) }}</td>
                        <td>{{ item.grade_name }}</td>
                        <td>{{ item.grade_gar }}</td>
                        <td>{{ store.numInt(item.quantity) }}</td>
                        <td>{{ store.numDec(item.initial_price) }}</td>
                        <td>{{ item.currency }}</td>
                        <td>{{ item.vat_remark }}</td>
                        <td>{{ item.price_term }}</td>
                        <td>{{ item.co_number }}</td>
                        <td>{{ item.order_appendix }}</td>
                        <td>{{ item.order_status }}</td>
                        <td class="d-print-none">{{ item.order_remark }}</td>
                      </tr>
                    </tbody>
                  </table>
                </div>
              </div>

              <div class="card-body p-4 border-top border-top-dashed d-print-none" v-if="fileFilter.length > 0">
                <h6 class="text-muted text-uppercase fw-semibold">Attachments</h6>
                <div class="table-responsive border">
                  <table class="table align-middle table-borderless table-nowrap mb-0">
                    <thead class="table-active text-muted">
                      <tr>
                        <th style="width: 00px;">#</th>
                        <th>Name</th>
                        <th>Action</th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr v-for="(item, index) in fileFilter" :key="index">
                        <td>{{ index + 1 }}</td>
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
                              <i v-else class="ri-file-unknow-fill text-warning"></i>
                            </div>
                            <div class="flex-grow-1 filelist-name">{{ item.file_name }}</div>
                          </div>
                        </td>
                        <td>
                          <div class="d-flex gap-2 justify-content-start">
                            <a v-if="item.file_type == 'jpg' || item.file_type == 'txt' || item.file_type == 'pdf' || item.file_type == 'jpeg' || item.file_type == 'png'" href="#" class="link-success text-decoration-none fs-14 mt-1" @click="viewFile(item.new_name)"><i class="ri-eye-line"></i></a>
                            <a v-else href="#" class="link-success text-decoration-none fs-14 pt-1" title="Not available to view" @click="notView"><i class="ri-eye-off-line"></i></a>
                            <a href="#" class="link-success text-decoration-none fs-16" @click="downloadFile(item.new_name)"><i class="ri-download-2-line"></i></a>
                          </div>
                        </td>
                      </tr>
                    </tbody>
                  </table>
                </div>
              </div>
              <div class="col-lg-12" v-if="customerFilter.contract_remarks">
                <div class="card-body p-4 border-top border-top-dashed">
                  <div class="alert alert-info m-0">
                    <p class="mb-0"><span class="fw-semibold">NOTES:</span>
                      <span id="note"> {{ customerFilter.contract_remarks }}
                      </span>
                    </p>
                  </div>
                </div>
              </div>
              <div class="col-lg-12">
                <div class="card-body p-4 pt-0">
                  <div class="hstack gap-2 justify-content-end d-print-none">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal" @click="viewMode = 'main'"><i class="ri-close-line me-1 align-middle"></i> Close</button>
                    <a href="javascript:window.print()" class="btn btn-success"><i class="ri-printer-line align-bottom me-1"></i> Print</a>
                    <!-- <a href="javascript:void(0);" class="btn btn-primary"><i class="ri-download-2-line align-bottom me-1"></i> Download</a> -->
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Add Contract Modal -->
    <div class="modal fade" id="add-contract-modal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-modal="true" role="dialog">
      <div class="modal-dialog modal-lg">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title">Add Contract</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-content border-0 mt-3">
            <ul class="nav nav-tabs nav-tabs-custom nav-success p-2 pb-0 bg-light" role="tablist">
              <li class="nav-item" role="presentation">
                <a class="nav-link active" id="add-contract-tab" data-bs-toggle="tab" href="#add-contract" role="tab" aria-selected="true">
                  Contracts
                </a>
              </li>
              <li class="nav-item" role="presentation">
                <a class="nav-link" id="add-order-tab" data-bs-toggle="tab" href="#add-order" role="tab" aria-selected="false">
                  Orders
                </a>
              </li>
              <li class="nav-item" role="presentation">
                <a class="nav-link" id="add-attachment-tab" data-bs-toggle="tab" href="#add-attachment" role="tab" aria-selected="false">
                  Attachments
                </a>
              </li>
            </ul>
          </div>
          <div class="modal-body">
            <div class="tab-content">
              <div class="tab-pane active show" id="add-contract" role="tabpanel">
                <div class="row">
                  <div class="col-lg-12">
                    <div class="mb-3">
                      <label class="form-label">Customer Name <span class="text-danger">*</span></label>
                      <multiselect :searchable="true" :searchStart="true" placeholder="Select customer name" :options="lkCustomer" v-model="contractForm.customer_id" />
                    </div>
                  </div>
                  <div class="col-lg-8">
                    <div class="mb-3">
                      <label class="form-label">Contract Number <span class="text-danger">*</span></label>
                      <input type="text" class="form-control" placeholder="Enter contract number" v-model="contractForm.contract_no">
                    </div>
                  </div>
                  <div class="col-lg-4">
                    <div class="mb-3">
                      <label class="form-label">Signed Date <span class="text-danger">*</span></label>
                      <input type="text" class="form-control flatpickr-input flatpickr-single rounded-start-2" placeholder="Select date" v-model="contractForm.signed_date">
                    </div>
                  </div>
                  <div class="col-lg-4">
                    <div class="mb-3">
                      <label class="form-label">Total Quantity <span class="text-danger">*</span></label>
                      <cleave :options="int" class="form-control" placeholder="Enter quantity ton" v-model="contractForm.contract_quantity" />
                    </div>
                  </div>
                  <div class="col-lg-4">
                    <div class="mb-3">
                      <label class="form-label">Grade <span class="text-danger">*</span></label>
                      <multiselect :searchable="true" :searchStart="true" placeholder="Select grade" :options="lkGrade" v-model="contractForm.contract_grade_id" />
                    </div>
                  </div>
                  <div class="col-lg-4">
                    <div class="mb-3">
                      <label class="form-label">Grade GAR</label>
                      <input type="text" class="form-control" placeholder="Enter loading place" v-model="contractForm.contract_grade_gar" readonly>
                    </div>
                  </div>
                  <div class="col-lg-12">
                    <div class="mb-3">
                      <label class="form-label">Loading Place</label>
                      <input type="text" class="form-control" placeholder="Enter loading place" v-model="contractForm.loading_place">
                    </div>
                  </div>
                  <div class="col-lg-12">
                    <div class="mb-3">
                      <label class="form-label">Delivery Place</label>
                      <input type="text" class="form-control" placeholder="Enter delivery place" v-model="contractForm.delivery_place">
                    </div>
                  </div>
                  <div class="col-lg-8">
                    <div class="mb-3">
                      <label class="form-label">Appendix</label>
                      <input type="text" class="form-control" placeholder="Enter appendix" v-model="contractForm.contract_appendix">
                    </div>
                  </div>
                  <div class="col-lg-4">
                    <div class="mb-3">
                      <label class="form-label">Status <span class="text-danger">*</span></label>
                      <multiselect placeholder="Select status" :options="lkStatus" v-model="contractForm.contract_status" />
                    </div>
                  </div>
                  <div class="col-lg-12">
                    <label class="form-label">Notes</label>
                    <textarea class="form-control" rows="2" placeholder="Enter notes" v-model="contractForm.contract_remark"></textarea>
                  </div>
                  {{ getGradeGAR2 }}
                </div>
              </div>

              <!-- Order Tab -->
              <div class="tab-pane active show" id="add-order" role="tabpanel">
                <div class="row">
                  <div class="col-lg-4">
                    <div class="mb-3">
                      <label class="form-label">Order Date <span class="text-danger">*</span></label>
                      <input type="text" class="form-control flatpickr-input flatpickr-single rounded-start-2" placeholder="Select date" v-model="orderForm.order_date">
                    </div>
                  </div>
                  <div class="col-lg-4">
                    <div class="mb-3">
                      <label class="form-label">Grade <span class="text-danger">*</span></label>
                      <multiselect :searchable="true" :searchStart="true" placeholder="Select grade" :options="lkGrade" v-model="orderForm.grade_id" />
                    </div>
                  </div>
                  <div class="col-lg-4">
                    <div class="mb-3">
                      <label class="form-label">Grade GAR </label>
                      <input type="text" class="form-control" placeholder="Autofill based on grade" v-model="orderForm.grade_gar" readonly>
                    </div>
                  </div>
                  <div class="col-lg-4">
                    <div class="mb-3">
                      <label class="form-label">Quantity </label>
                      <cleave :options="int" class="form-control" placeholder="Enter quantity ton" v-model="orderForm.quantity" />
                    </div>
                  </div>
                  <div class="col-lg-4">
                    <div class="mb-3">
                      <label class="form-label">Initail Price</label>
                      <cleave :options="dec" class="form-control" placeholder="Enter initial price" v-model="orderForm.initial_price" />
                    </div>
                  </div>
                  <div class="col-lg-4">
                    <div class="mb-3">
                      <label class="form-label">Currency</label>
                      <multiselect placeholder="Select currency" :options="lkCurrency" v-model="orderForm.currency" />
                    </div>
                  </div>
                  <div class="col-lg-4">
                    <div class="mb-3">
                      <label class="form-label">VAT Remark <span class="text-danger">*</span></label>
                      <multiselect placeholder="Select VAT remark" :options="lkVat" v-model="orderForm.vat_remark" />
                    </div>
                  </div>
                  <div class="col-lg-8">
                    <div class="mb-3">
                      <label class="form-label">Price Term <span class="text-danger">*</span></label>
                      <multiselect placeholder="Select price term" :options="lkPriceTerm" v-model="orderForm.price_term" />
                    </div>
                  </div>
                  <div class="col-lg-12">
                    <div class="mb-3">
                      <label class="form-label">Appendix</label>
                      <input type="text" class="form-control" placeholder="Enter appendix" v-model="orderForm.order_appendix">
                    </div>
                  </div>
                  <div class="col-lg-8">
                    <div class="mb-3">
                      <label class="form-label">CO Number</label>
                      <input type="text" class="form-control" placeholder="Enter CO number" v-model="orderForm.co_number">
                    </div>
                  </div>
                  <div class="col-lg-4">
                    <div class="mb-3">
                      <label class="form-label">Status <span class="text-danger">*</span></label>
                      <multiselect placeholder="Select status" :options="lkStatus" v-model="orderForm.order_status" />
                    </div>
                  </div>
                  <div class="col-lg-12">
                    <label class="form-label">Remarks</label>
                    <textarea class="form-control" placeholder="Enter remarks" v-model="orderForm.order_remark"></textarea>
                  </div>
                </div>
                {{ getGradeGAR }}{{ autoFill }}
              </div>

              <!-- Attachment Tab -->
              <div class="tab-pane" id="add-attachment" role="tabpanel">
                <div class="card-header align-items-center d-flex border-0">
                  <div class="flex-shrink-0">
                    <button type="button" class="btn btn-soft-info btn-sm" @click="newAttached()"><i class="ri-upload-2-fill me-1 align-bottom"></i> Upload</button>
                    <input class="d-none" ref="fileInput" type="file" multiple @change="addAttachedTemp()">
                  </div>
                </div>
                <div class="vstack gap-2">
                  <div class="border rounded border-dashed p-2" v-for="(item, index) in fileFilter" :key="index">
                    <div class="d-flex align-items-center">
                      <div class="flex-shrink-0 me-3">
                        <div class="avatar-sm">
                          <div class="avatar-title bg-light text-secondary rounded fs-24">
                            <i v-if="store.fileType(item.file_name) == 'txt'" class="ri-file-text-fill text-info"></i>
                            <i v-else-if="store.fileType(item.file_name) == 'docx'" class="ri-file-word-fill"></i>
                            <i v-else-if="store.fileType(item.file_name) == 'xlsx'" class="ri-file-excel-fill text-success"></i>
                            <i v-else-if="store.fileType(item.file_name) == 'pptx'" class="ri-file-ppt-fill text-danger"></i>
                            <i v-else-if="store.fileType(item.file_name) == 'pdf'" class="ri-file-pdf-fill text-danger"></i>
                            <i v-else-if="store.fileType(item.file_name) == 'jpg'" class="ri-image-fill text-success"></i>
                            <i v-else-if="store.fileType(item.file_name) == 'jpeg'" class="ri-image-fill text-success"></i>
                            <i v-else-if="store.fileType(item.file_name) == 'png'" class="ri-image-fill text-success"></i>
                            <i v-else-if="store.fileType(item.file_name) == 'zip'" class="ri-folder-zip-line"></i>
                            <i v-else class="ri-file-unknow-fill text-warning"></i>
                          </div>
                        </div>
                      </div>
                      <div class="flex-grow-1 overflow-hidden">
                        <h5 class="fs-13 mb-1"><a href="#" class="text-body text-truncate d-block">{{ item.file_name }}</a></h5>
                        <div>Size: {{ item.size }} KB</div>
                      </div>
                      <div class="flex-shrink-0 ms-2">
                        <div class="d-flex gap-1">
                          <div v-if="item.note == 'new'">
                            <button type="button" class="btn btn-icon text-muted btn-sm fs-18 material-shadow-none" @click="removeFile(index)"><i class="ri-delete-bin-line text-danger"></i></button>
                          </div>
                          <div v-else>
                            <a href="javascript:void(0);" class="btn btn-soft-success btn-sm btn-icon dropdown" data-bs-toggle="dropdown" aria-expanded="false">
                              <i class="ri-more-fill"></i>
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end dropdownmenu-secondary" style=''>
                              <li v-if="item.file_type == 'jpg' || item.file_type == 'txt' || item.file_type == 'pdf' || item.file_type == 'jpeg' || item.file_type == 'png'"><a class="dropdown-item" href="javascript:void(0);" @click="viewFile(item.new_name)"><i class="ri-eye-line me-2 align-bottom text-muted"></i>View</a></li>
                              <a v-else href="#" class="link-success text-decoration-none fs-14 pt-1" title="Not available to view" @click="notView"><i class="ri-eye-off-line"></i></a>
                              <li><a class="dropdown-item" href="javascript:void(0);" @click="downloadFile(item.new_name)"><i class="ri-download-2-line me-2 align-bottom text-muted"></i>Download</a></li>
                              <li><a class="dropdown-item" href="javascript:void(0);" @click="delFile(item.file_id, item.new_name, index)"><i class="ri-delete-bin-5-line me-2 align-bottom text-muted"></i>Delete</a></li>
                            </ul>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="modal-footer" style="display: block;">
            <div class="hstack gap-2 justify-content-end">
              <button type="button" class="btn btn-light" data-bs-dismiss="modal"><i class="ri-close-line me-1 align-middle"></i>{{ $t('close-btn') }}</button>
              <button type="button" class="btn btn-success" :class="addContractDis" @click="addContract()"><i class="ri-add-line align-bottom me-1"></i>{{ $t('add-contract') }}</button>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Edit Contract Modal -->
    <div class="modal fade zoomIn" id="edit-contract-modal" data-bs-keyboard="false" tabindex="-1" aria-modal="true" role="dialog">
      <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
          <div class="modal-header bg-light p-3">
            <h5 class="modal-title">Edit Contract</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <div class="row">
              <div class="col-lg-12">
                <div class="mb-3">
                  <label class="form-label">Customer Name <span class="text-danger">*</span></label>
                  <multiselect :searchable="true" :searchStart="true" placeholder="Select customer name" :options="lkCustomer" v-model="contractForm.customer_id" />
                </div>
              </div>
              <div class="col-lg-8">
                <div class="mb-3">
                  <label class="form-label">Contract Number <span class="text-danger">*</span></label>
                  <input type="text" class="form-control" placeholder="Enter contract number" v-model="contractForm.contract_no">
                </div>
              </div>
              <div class="col-lg-4">
                <div class="mb-3">
                  <label class="form-label">Signed Date <span class="text-danger">*</span></label>
                  <input type="text" class="form-control" v-model="contractForm.signed_date">
                </div>
              </div>
              <div class="col-lg-4">
                <div class="mb-3">
                  <label class="form-label">Total Quantity <span class="text-danger">*</span></label>
                  <cleave :options="int" class="form-control" placeholder="Enter quantity ton" v-model="contractForm.contract_quantity" />
                </div>
              </div>
              <div class="col-lg-4">
                <div class="mb-3">
                  <label class="form-label">Grade <span class="text-danger">*</span></label>
                  <multiselect :searchable="true" :searchStart="true" placeholder="Select grade" :options="lkGrade" v-model="contractForm.contract_grade_id" />
                </div>
              </div>
              <div class="col-lg-4">
                <div class="mb-3">
                  <label class="form-label">Grade GAR</label>
                  <input type="text" class="form-control" placeholder="Enter loading place" v-model="contractForm.contract_grade_gar" readonly>
                </div>
              </div>
              <div class="col-lg-12">
                <div class="mb-3">
                  <label class="form-label">Loading Place</label>
                  <input type="text" class="form-control" placeholder="Enter loading place" v-model="contractForm.loading_place">
                </div>
              </div>
              <div class="col-lg-12">
                <div class="mb-3">
                  <label class="form-label">Delivery Place</label>
                  <input type="text" class="form-control" placeholder="Enter delivery place" v-model="contractForm.delivery_place">
                </div>
              </div>
              <div class="col-lg-6">
                <div class="mb-3">
                  <label class="form-label">Appendix</label>
                  <input type="text" class="form-control" placeholder="Enter appendix" v-model="contractForm.contract_appendix">
                </div>
              </div>
              <div class="col-lg-3">
                <div class="mb-3">
                  <label class="form-label">Status <span class="text-danger">*</span></label>
                  <multiselect placeholder="Select status" :options="lkStatus" v-model="contractForm.contract_status" />
                </div>
              </div>
              <div class="col-lg-3">
                <div class="mb-3">
                  <label class="form-label">Dasboards </label>
                  <multiselect placeholder="Select..." :options="lkHide" v-model="contractForm.hide" />
                </div>
              </div>
              <div class="col-lg-12">
                <label class="form-label">Remarks</label>
                <textarea class="form-control" rows="2" placeholder="Enter remarks" v-model="contractForm.contract_remark"></textarea>
              </div>
              {{ getGradeGAR2 }}
            </div>
          </div>
          <div class="modal-footer" style="display: block;">
            <div class="hstack gap-2 justify-content-end">
              <button type="button" class="btn btn-light" data-bs-dismiss="modal"><i class="ri-close-line me-1 align-middle"></i>{{ $t('close-btn') }}</button>
              <button type="button" id="contract-upd" class="btn btn-success" :class="editContractDis" @click="updContract()"><i class="ri-save-3-line align-bottom me-1"></i> {{ $t('save-btn') }}</button>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Edit Order Modal -->
    <div class="modal fade zoomIn" id="order-modal" data-bs-keyboard="false" tabindex="-1" aria-modal="true" role="dialog">
      <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
          <div class="modal-header bg-light p-3">
            <h5 class="modal-title">Order Details</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <div class="row">
              <div class="col-lg-4">
                <div class="mb-3">
                  <label class="form-label">Order Date <span class="text-danger">*</span></label>
                  <input type="text" class="form-control" v-model="orderForm.order_date">
                </div>
              </div>
              <div class="col-lg-4">
                <div class="mb-3">
                  <label class="form-label">Grade <span class="text-danger">*</span></label>
                  <multiselect :searchable="true" :searchStart="true" placeholder="Select grade" :options="lkGrade" v-model="orderForm.grade_id" />
                </div>
              </div>
              <div class="col-lg-4">
                <div class="mb-3">
                  <label class="form-label">Grade GAR </label>
                  <input type="text" class="form-control" placeholder="Autofill based on grade" v-model="orderForm.grade_gar" readonly>
                </div>
              </div>
              <div class="col-lg-4">
                <div class="mb-3">
                  <label class="form-label">Quantity </label>
                  <cleave :options="int" class="form-control" placeholder="Enter quantity ton" v-model="orderForm.quantity" />
                </div>
              </div>
              <div class="col-lg-4">
                <div class="mb-3">
                  <label class="form-label">Initail Price</label>
                  <cleave :options="dec" class="form-control" placeholder="Enter initial price" v-model="orderForm.initial_price" />
                </div>
              </div>
              <div class="col-lg-4">
                <div class="mb-3">
                  <label class="form-label">Currency</label>
                  <multiselect placeholder="Select currency" :options="lkCurrency" v-model="orderForm.currency" />
                </div>
              </div>
              <div class="col-lg-4">
                <div class="mb-3">
                  <label class="form-label">VAT Remark <span class="text-danger">*</span></label>
                  <multiselect placeholder="Select VAT remark" :options="lkVat" v-model="orderForm.vat_remark" />
                </div>
              </div>
              <div class="col-lg-8">
                <div class="mb-3">
                  <label class="form-label">Price Term <span class="text-danger">*</span></label>
                  <multiselect placeholder="Select price term" :options="lkPriceTerm" v-model="orderForm.price_term" />
                </div>
              </div>
              <div class="col-lg-4">
                <div class="mb-3">
                  <label class="form-label">CO Number</label>
                  <input type="text" class="form-control" placeholder="Enter CO number" v-model="orderForm.co_number">
                </div>
              </div>
              <div class="col-lg-8">
                <div class="mb-3">
                  <label class="form-label">Appendix</label>
                  <input type="text" class="form-control" placeholder="Enter appendix" v-model="orderForm.order_appendix">
                </div>
              </div>
              <div class="col-lg-4">
                <div class="mb-3">
                  <label class="form-label">Status <span class="text-danger">*</span></label>
                  <multiselect placeholder="Select status" :options="lkStatus" v-model="orderForm.order_status" />
                </div>
              </div>
              <div class="col-lg-8">
                <div class="mb-3">
                  <label class="form-label">Remarks</label>
                  <input class="form-control" rows="3" placeholder="Enter remarks" v-model="orderForm.order_remark">
                </div>
              </div>
              {{ getGradeGAR }}
            </div>
            <div class="card-body">
              <div class="table-responsive">
                <table class="table align-middle border table-nowrap mb-0 table-hover cursor-pointer table-sm">
                  <thead class="table-active text-muted">
                    <tr>
                      <th style="width: 30px;">#</th>
                      <th>Order Date</th>
                      <th>Grade</th>
                      <th>Grade GAR</th>
                      <th>Quantity</th>
                      <th>Init Price</th>
                      <th>Currency</th>
                      <th>VAT</th>
                      <th>Price Term</th>
                      <th>CO Number</th>
                      <th>Appendix</th>
                      <th>Status</th>
                      <th>Remark</th>
                      <th>Actions</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr v-for="(item, index) in orderFilter" :key="index" @dblclick="editOrder(item.order_id)" title="Double click to edit">
                      <td>{{ index + 1 }}</td>
                      <td>{{ store.ddmmyyyy(item.order_date) }}</td>
                      <td>{{ item.grade_name }}</td>
                      <td>{{ item.grade_gar }}</td>
                      <td>{{ store.numInt(item.quantity) }}</td>
                      <td>{{ store.numDec(item.initial_price) }}</td>
                      <td>{{ item.currency }}</td>
                      <td>{{ item.vat_remark }}</td>
                      <td>{{ item.price_term }}</td>
                      <td>{{ item.co_number }}</td>
                      <td>{{ item.order_appendix }}</td>
                      <td>{{ item.order_status }}</td>
                      <td>{{ item.order_remark }}</td>
                      <td>
                        <div class="d-flex gap-1">
                          <a href="javascript:void(0);" class="btn btn-soft-success btn-sm btn-icon dropdown" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="ri-more-fill"></i>
                          </a>
                          <ul class="dropdown-menu dropdown-menu-end dropdownmenu-secondary" style=''>
                            <li><a class="dropdown-item" href="javascript:void(0);" @click="editOrder(item.order_id)"><i class="ri-pencil-fill me-2 align-bottom text-muted"></i>Edit</a></li>
                            <li><a class="dropdown-item" href="javascript:void(0);" @click="delOrder(item.order_id, index)"><i class="ri-delete-bin-5-fill me-2 align-bottom text-muted"></i>Delete</a></li>
                          </ul>
                        </div>
                      </td>
                    </tr>
                  </tbody>
                </table>
              </div>
            </div>
          </div>
          <div class="modal-footer" style="display: block;">
            <div class="hstack gap-2 justify-content-end">
              <button type="button" id="order-close" class="btn btn-light" data-bs-dismiss="modal"><i class="ri-close-line me-1 align-middle"></i>{{ $t('close-btn') }}</button>
              <button type="button" id="order-addbtn" class="btn btn-success" :class="addOrderDis" @click="addOrder()"><i class="ri-add-line align-bottom me-1"></i>{{ $t('add-order') }}</button>
              <button type="button" id="order-cancel" class="btn btn-soft-info" @click="cancelOrder()"><i class="ri-close-line me-1 align-middle"></i>{{ $t('cancel-btn') }}</button>
              <button type="button" id="order-updbtn" class="btn btn-success" :class="addOrderDis" @click="updOrder()"><i class="ri-save-3-line align-bottom me-1"></i>{{ $t('save-btn') }}</button>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Edit Attachment Modal -->
    <div class="modal fade zoomIn" id="attachment-modal" data-bs-keyboard="false" tabindex="-1" aria-modal="true" role="dialog">
      <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
          <div class="modal-header bg-light p-3">
            <h5 class="modal-title">Contract Attachments</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <div class="card-header align-items-center d-flex border-0">
              <div class="flex-shrink-0">
                <button type="button" class="btn btn-soft-info btn-sm" @click="newAttached()"><i class="ri-upload-2-fill me-1 align-bottom"></i> Upload</button>
                <input class="d-none" ref="fileInput" type="file" multiple @change="addAttachedTemp()">
              </div>
            </div>
            <div class="vstack gap-2">
              <div class="border rounded border-dashed p-2" v-for="(item, index) in fileFilter" :key="index">
                <div class="d-flex align-items-center">
                  <div class="flex-shrink-0 me-3">
                    <div class="avatar-sm">
                      <div class="avatar-title bg-light text-secondary rounded fs-24">
                        <i v-if="store.fileType(item.file_name) == 'txt'" class="ri-file-text-fill text-info"></i>
                        <i v-else-if="store.fileType(item.file_name) == 'docx'" class="ri-file-word-fill"></i>
                        <i v-else-if="store.fileType(item.file_name) == 'xlsx'" class="ri-file-excel-fill text-success"></i>
                        <i v-else-if="store.fileType(item.file_name) == 'pptx'" class="ri-file-ppt-fill text-danger"></i>
                        <i v-else-if="store.fileType(item.file_name) == 'pdf'" class="ri-file-pdf-fill text-danger"></i>
                        <i v-else-if="store.fileType(item.file_name) == 'jpg'" class="ri-image-2-fill text-success"></i>
                        <i v-else-if="store.fileType(item.file_name) == 'jpeg'" class="ri-image-2-fill text-success"></i>
                        <i v-else-if="store.fileType(item.file_name) == 'png'" class="ri-image-2-fill text-success"></i>
                        <i v-else-if="store.fileType(item.file_name) == 'zip'" class="ri-folder-zip-line"></i>
                        <i v-else class="ri-file-unknow-fill text-warning"></i>
                      </div>
                    </div>
                  </div>
                  <div class="flex-grow-1 overflow-hidden">
                    <h5 class="fs-13 mb-1"><a href="#" class="text-body text-truncate d-block">{{ item.file_name }}</a></h5>
                    <div>Size: {{ item.size }} KB</div>
                  </div>
                  <div class="flex-shrink-0 ms-2">
                    <div class="d-flex gap-1">
                      <div v-if="item.note == 'new'">
                        <button type="button" class="btn btn-icon text-muted btn-sm fs-18 material-shadow-none" @click="removeFile(index)"><i class="ri-delete-bin-line text-danger"></i></button>
                      </div>
                      <div v-else>
                        <a href="javascript:void(0);" class="btn btn-soft-success btn-sm btn-icon dropdown" data-bs-toggle="dropdown" aria-expanded="false">
                          <i class="ri-more-fill"></i>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end dropdownmenu-secondary" style=''>
                          <li v-if="item.file_type == 'jpg' || item.file_type == 'txt' || item.file_type == 'pdf' || item.file_type == 'jpeg' || item.file_type == 'png'"><a class="dropdown-item" href="javascript:void(0);" @click="viewFile(item.new_name)"><i class="ri-eye-fill me-2 align-bottom text-muted"></i>View</a></li>
                          <li><a class="dropdown-item" href="javascript:void(0);" @click="downloadFile(item.new_name)"><i class="ri-download-2-fill me-2 align-bottom text-muted"></i>Download</a></li>
                          <li><a class="dropdown-item" href="javascript:void(0);" @click="delFile(item.file_id, item.new_name, index)"><i class="ri-delete-bin-5-fill me-2 align-bottom text-muted"></i>Delete</a></li>
                        </ul>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="modal-footer" style="display: block;">
            <div class="hstack gap-2 justify-content-end">
              <button type="button" class="btn btn-light" data-bs-dismiss="modal"><i class="ri-close-line me-1 align-middle"></i>{{ $t('close-btn') }}</button>
              <button type="button" class="btn btn-success" :class="addAttachmentDis" @click="addAttachment()"><i class="ri-add-line align-bottom me-1"></i>{{ $t('add-attachment') }}</button>
            </div>
          </div>
        </div>
      </div>
    </div>

  </div>
</template>

<script>
import axios from "axios";
import { AgGridVue } from 'ag-grid-vue3';
import 'ag-grid-community/styles/ag-grid.css';
import 'ag-grid-community/styles/ag-theme-material.css';
import 'ag-grid-enterprise';
import { useToastr } from "../toastr.js";
import { useStore } from '../stores/store.js';
import { useAuthStore } from '../stores/auth.js';
const toastr = useToastr();

import Test from '../components/test.vue';
import but from '../components/buttons.vue';


export default {
  name: 'XpplAppSaleContract',
  components: { AgGridVue, Test, but },

  setup() {
    const store = useStore();
    const authStore = useAuthStore();
    return { store, authStore };
  },

  data() {
    return {
      columnDefs: [
        { headerName: '#', maxWidth: 50, sortable: false, resizable: false, suppressMovable: true, suppressMenu: true, valueGetter: (params) => { return params.node.rowIndex + 1 } },
        { headerName: 'Customer ID', field: 'customer_id', hide: true },
        // {
        //   headerName: 'Customer Name', field: 'customer_name', minWidth: 250,
        //   cellRenderer: "Test",
        //   filter: 'agSetColumnFilter'
        // },
        // {
        //   headerName: 'Customer Name', field: 'customer_name', minWidth: 250,
        //   cellRenderer: 'but',
        //   filter: 'agSetColumnFilter'
        // },
        { headerName: 'Customer Name', field: 'customer_name', minWidth: 250, filter: 'agSetColumnFilter' },
        { headerName: 'Contract Number', field: 'contract_no', minWidth: 220, filter: 'agSetColumnFilter' },
        {
          headerName: 'Signed Date', minWidth: 120, maxWidth: 120, valueGetter: p => {
            if (p.data.signed_date) {
              return moment(p.data.signed_date).format('DD-MM-YYYY')
            }
          },
          filter: 'agMultiColumnFilter',
          filterParams: {
            filters: [
              {
                filter: 'agDateColumnFilter',
                filterParams: {
                  comparator: (filterDate, cellValue) => {
                    const dateParts = cellValue.split('-');
                    const day = Number(dateParts[0]);
                    const month = Number(dateParts[1]) - 1;
                    const year = Number(dateParts[2]);
                    const cellDate = new Date(year, month, day);
                    if (cellValue == null) return -1;
                    return cellDate.getTime() - filterDate.getTime();
                  },
                },
              },
              {
                filter: 'agSetColumnFilter',
              },
            ],
          },
        },
        {
          headerName: 'Quantity', field: 'contract_quantity',
          valueGetter: p => Number(p.data.contract_quantity),
          valueFormatter: p => p.value ? p.value.toLocaleString('en-US', { minimumFractionDigits: 0, maximumFractionDigits: 0 }) : '',
          filter: 'agMultiColumnFilter',
          filterParams: {
            filters: [
              { filter: 'agNumberColumnFilter' },
              { filter: 'agSetColumnFilter' },
            ]
          }
        },
        { headerName: 'Grade', field: 'contract_grade_name', filter: 'agSetColumnFilter' },
        { headerName: 'Grade GAR', field: 'contract_grade_gar', filter: 'agSetColumnFilter' },
        { headerName: 'Country', field: 'country', filter: 'agSetColumnFilter' },
        { headerName: 'Destination', field: 'destination', filter: 'agSetColumnFilter' },
        { headerName: 'Loading Place', field: 'loading_place', filter: 'agSetColumnFilter' },
        { headerName: 'Delivery Place', field: 'delivery_place', filter: 'agSetColumnFilter' },
        {
          headerName: 'Status', field: 'contract_status', filter: 'agSetColumnFilter',
          cellRenderer: p => {
            if (p.value == 'Active') {
              return '<span class="text-danger fw-normal fs-12 py-1 px-2"><i class="ri-checkbox-circle-line fs-13 pe-1"></i>' + p.value + '</span>'
            } else if (p.value == 'Closed') {
              return '<span class="text-success fw-normal fs-12 py-1 px-2"><i class=" ri-close-circle-line fs-13 pe-1"></i>' + p.value + '</span>'
            } else if (p.value == 'Waiting') {
              return '<span class="text-warning fw-normal fs-12 py-1 px-2"><i class="ri-alarm-line fs-13 pe-1"></i>' + p.value + '</span>'
            }
            return p.value
          }
        },
        { headerName: 'Appendix', field: 'contract_appendix', filter: 'agSetColumnFilter' },
        { headerName: 'Remarks', field: 'contract_remarks', filter: 'agSetColumnFilter' },
        {
          headerName: 'Dashboard', field: 'hide', hide: true, filter: 'agSetColumnFilter',
          cellRenderer: p => {
            if (p.value == false) {
              return 'Show';
            } else {
              return 'Hide';
            }
          }

        },
        { headerName: 'Created at', field: 'created_at', hide: true, valueFormatter: p => p.value ? moment(p.value).format('DD/MM/YYYY HH:mm:ss') : '' },
        { headerName: 'Created by', field: 'created_by', filter: 'agSetColumnFilter', hide: true },
        { headerName: 'Updated at', field: 'updated_at', hide: true, valueFormatter: p => p.value ? moment(p.value).format('DD/MM/YYYY HH:mm:ss') : '' },
        { headerName: 'Updated by', field: 'updated_by', filter: 'agSetColumnFilter', hide: true },
        // {
        //   headerName: 'Actions', field: 'contract_id', pinned: 'right',
        //   cellRenderer: 'but'
        // },
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

      contractData: [],
      orderData: [],
      fileData: [],
      fileFilter: [],
      customerFilter: [],

      gradeData: [],
      lkCurrency: [],
      lkPriceTerm: [],
      lkVat: [],
      lkStatus: [],
      lkGrade: [],
      lkCustomer: [],

      contractForm: { row_index: '', contract_id: '', customer_id: null, contract_no: '', contract_appendix: '', signed_date: '', contract_quantity: '', contract_grade_id: null, contract_grade_gar: '', loading_place: '', delivery_place: '', contract_status: null, hide: null, contract_remark: '' },
      orderForm: { contract_id: '', order_id: '', order_date: '', grade_id: null, grade_gar: '', quantity: '', initial_price: '', currency: null, vat_remark: null, price_term: null, co_number: '', order_appendix: '', order_status: null, order_remark: '' },
      orderFilter: [],

      auth: [],
      search: '',
      viewMode: 'main',
      lkHide: [{ value: 0, label: 'Show' }, { value: 1, label: 'Hide' }],

      loading: false,

      dec: {
        numeral: true,
        numeralPositiveOnly: true,
        noImmediatePrefix: true,
        rawValueTrimPrefix: true,
        numeralIntegerScale: 15,
        numeralDecimalScale: 2,
        numeralDecimalMark: '.',
        delimiter: ','
      },

      int: {
        numeral: true,
        numeralPositiveOnly: true,
        noImmediatePrefix: true,
        rawValueTrimPrefix: true,
        numeralIntegerScale: 15,
        numeralDecimalScale: 0,
        numeralDecimalMark: '.',
        delimiter: ','
      },
    };
  },

  mounted() {
    flatpickr('.flatpickr-single', {
      altInput: true,
      altFormat: 'd-m-Y'
    });
  },

  computed: {
    contractList() {
      if (this.search.trim().length > 0) {
        return this.contractData.filter((i) =>
          i.contract_no.substring(0, this.search.trim().length).toLowerCase() == this.search.trim().toLowerCase() ||
          i.customer_name.substring(0, this.search.trim().length).toLowerCase() == this.search.trim().toLowerCase() ||
          i.contract_status.substring(0, this.search.trim().length).toLowerCase() == this.search.trim().toLowerCase() ||
          i.destination.substring(0, this.search.trim().length).toLowerCase() == this.search.trim().toLowerCase() ||
          i.country.substring(0, this.search.trim().length).toLowerCase() == this.search.trim().toLowerCase()
        );
      };
      return this.contractData;
    },

    getGradeGAR() {
      if (this.orderForm.grade_id) {
        let g = this.gradeData.find((e) => e.grade_id == this.orderForm.grade_id);
        this.orderForm.grade_gar = g.grade_gar;
        this.contractForm.contract_grade_gar = g.grade_gar;
      } else {
        this.orderForm.grade_gar = '';
        this.contractForm.contract_grade_gar = '';
      }
    },

    getGradeGAR2() {
      if (this.contractForm.contract_grade_id) {
        let g = this.gradeData.find((e) => e.grade_id == this.contractForm.contract_grade_id);
        this.contractForm.contract_grade_gar = g.grade_gar;
      } else {
        this.contractForm.contract_grade_gar = '';
      }
    },

    autoFill() {
      if (this.contractForm.contract_grade_id) {
        this.orderForm.grade_id = this.contractForm.contract_grade_id;
      } else {
        this.orderForm.grade_id = '';
      }

      if (this.contractForm.contract_quantity) {
        this.orderForm.quantity = this.contractForm.contract_quantity;
      } else {
        this.orderForm.quantity = '';
      }
    },

    addContractDis() {
      let fc = this.contractForm;
      let fr = this.orderForm;
      if (fc.customer_id == null || fc.contract_no == '' || fc.signed_date == '' || fc.contract_quantity == '' || fc.contract_grade_id == null || fc.contract_status == null || fr.order_date == '' || fr.grade_id == null || fr.vat_remark == null || fr.price_term == null || fr.order_status == null) {
        return 'disabled';
      } else {
        return '';
      }
    },

    editContractDis() {
      let f = this.contractForm;
      if (f.customer_id == null || f.contract_no == '' || f.signed_date == '' || f.contract_quantity == '' || f.contract_grade_id == null || f.contract_status == null) {
        return 'disabled';
      } else {
        return '';
      }
    },

    addOrderDis() {
      if (this.orderForm.order_date == '' || this.orderForm.grade_id == null || this.orderForm.vat_remark == null || this.orderForm.price_term == null || this.orderForm.order_status == null) {
        return 'disabled';
      } else {
        return '';
      }
    },

    addAttachmentDis() {
      if (this.fileFilter.length == 0) {
        return 'disabled';
      } else {
        return '';
      }
    }
  },

  methods: {
    async onLoad() {
      this.loading = true;

      const sub = 'M07S03';// contracts
      const subData = await axios.get(`api/auth/auth-action?submenu=${sub}`, { headers: { Authorization: 'Bearer ' + this.authStore.getToken } });
      this.auth = subData.data[0];

      const cusdata = await this.getContracts();
      const orddata = await this.getOrders();
      const cusFile = await this.getFiles();

      let codes = [
        { cate: 'Price Term', lk: 'lkPriceTerm' },
        { cate: 'Currency', lk: 'lkCurrency' },
        { cate: 'VAT Remark', lk: 'lkVat' },
        { cate: 'Status', lk: 'lkStatus' },
      ];

      const code = await axios.get('api/sales/codes', { headers: { Authorization: 'Bearer ' + this.authStore.getToken } });
      for (let j = 0; j < codes.length; j++) {
        let cateName = codes[j].cate;
        let lkName = codes[j].lk;
        let item = code.data.filter((i) => i.category == [cateName]);
        for (let e = 0; e < item.length; e++) {
          if (cateName == 'Price Term' || cateName == 'Currency') {
            this[lkName].push({
              value: item[e].code,
              label: item[e].code + ' | ' + item[e].descr
            });
          } else {
            this[lkName].push({
              value: item[e].code,
              label: item[e].descr
            });
          }
        };
      };

      const g = await axios.get('api/sales/grades', { headers: { Authorization: 'Bearer ' + this.authStore.getToken } });
      this.gradeData = g.data;
      this.gradeData.forEach((e) => {
        this.lkGrade.push({
          value: e.grade_id,
          label: e.grade_name
        })
      })

      const customers = await axios.get('api/sales/customers', { headers: { Authorization: 'Bearer ' + this.authStore.getToken } });
      customers.data.forEach((e) => {
        this.lkCustomer.push({
          value: e.customer_id,
          label: e.customer_name
        })
      })
      this.loading = false;
    },

    async getContracts() {
      const contracts = await axios.get('api/sales/contracts', { headers: { Authorization: 'Bearer ' + this.authStore.getToken } });
      this.contractData = contracts.data;
    },

    async getOrders() {
      const orData = await axios.get('api/sales/orders', { headers: { Authorization: 'Bearer ' + this.authStore.getToken } });
      this.orderData = orData.data;
    },

    async getFiles() {
      const cusfile = await axios.get('api/sales/contract-file', { headers: { Authorization: 'Bearer ' + this.authStore.getToken } });
      this.fileData = cusfile.data;
    },

    newContract() {
      if (this.auth.new == 0) {
        toastr.warning("You're not authorized to add!");
      } else {
        this.contractForm = {};
        this.orderForm = {};
        this.fileFilter = [];
        this.contractForm.contract_no = '';
        this.contractForm.contract_status = 'Active';
        this.orderForm.order_status = 'Active';
        document.getElementById('add-attachment-tab').classList.remove('active');
        document.getElementById('add-attachment').classList.remove('active', 'show');
        document.getElementById('add-order-tab').classList.remove('active');
        document.getElementById('add-order').classList.remove('active', 'show');
        document.getElementById('add-contract-tab').classList.add('active');
        document.getElementById('add-contract').classList.add('active', 'show');
        $('#add-contract-modal').modal('show');
      }
    },

    addContract() {
      let fd = new FormData();
      for (let i = 0; i < this.fileFilter.length; i++) {
        let f = this.fileFilter[i];
        fd.append('files[' + i + ']', f.file);
      }

      //order object array
      // this.orderFilter.forEach((obj, index) => {
      //   for (const key in obj) {
      //     obj[key] ? fd.append(`orderList[${index}][${key}]`, obj[key]) : fd.append(`orderList[${index}][${key}]`, "");
      //   }
      // });

      let fc = this.contractForm;
      fd.append('customer_id', fc.customer_id);
      fd.append('contract_no', fc.contract_no);
      fd.append('signed_date', fc.signed_date);
      fd.append('contract_quantity', fc.contract_quantity);
      fd.append('contract_grade_id', fc.contract_grade_id);
      fd.append('contract_status', fc.contract_status);
      fc.loading_place ? fd.append('loading_place', fc.loading_place) : '';
      fc.delivery_place ? fd.append('delivery_place', fc.delivery_place) : '';
      fc.contract_appendix ? fd.append('contract_appendix', fc.contract_appendix) : '';
      fc.contract_remark ? fd.append('contract_remark', fc.contract_remark) : '';

      let fr = this.orderForm;
      fd.append('order_date', fr.order_date);
      fd.append('grade_id', fr.grade_id);
      fd.append('vat_remark', fr.vat_remark);
      fd.append('price_term', fr.price_term);
      fd.append('order_status', fr.order_status);
      fr.quantity ? fd.append('quantity', fr.quantity) : '';
      fr.initial_price ? fd.append('initial_price', fr.initial_price) : '';
      fr.currency ? fd.append('currency', fr.currency) : '';
      fr.order_appendix ? fd.append('order_appendix', fr.order_appendix) : '';
      fr.co_number ? fd.append('co_number', fr.co_number) : '';
      fr.order_remark ? fd.append('order_remark', fr.order_remark) : '';

      axios.post('api/sales/add-contract', fd, { headers: { 'Content-Type': 'multipart/form-data', Authorization: 'Bearer ' + this.authStore.getToken } }).then((response) => {
        if (response.data.success) {
          $('#add-contract-modal').modal('hide');
          toastr.success('Successfully!');
          this.getContracts();
          this.getOrders();
          this.getFiles();
          this.disableDropdown();
        } else {
          toastr.error(`${response.data.message}`);
        }
      }).catch((error) => {
        console.log(error);
      });
    },

    cellCicked(e) {
      this.enableDropdown();
      let f = this.contractForm;

      f.row_index = e.rowIndex;
      f.contract_id = e.data.contract_id;
      f.customer_id = e.data.customer_id;
      f.contract_no = e.data.contract_no;
      f.contract_appendix = e.data.contract_appendix;
      f.contract_quantity = e.data.contract_quantity;
      f.contract_grade_id = e.data.contract_grade_id;
      f.contract_grade_gar = e.data.contract_grade_gar;
      f.loading_place = e.data.loading_place;
      f.delivery_place = e.data.delivery_place;
      f.signed_date = this.store.yyyymmdd(e.data.signed_date);
      f.contract_status = e.data.contract_status;
      f.hide = e.data.hide;
      f.contract_remark = e.data.contract_remark;

      let orderItems = this.orderData.filter((i) => i.contract_id == e.data.contract_id);
      this.orderFilter = orderItems;

      let fileItems = this.fileData.filter((i) => i.contract_id == e.data.contract_id);
      this.fileFilter = fileItems;
    },

    editContract() {
      if (this.auth.edit == 0) {
        toastr.warning("You're not authorized to edit!");
      } else {
        $('#edit-contract-modal').modal('show');
      }
    },

    updContract() {
      axios.post('api/sales/upd-contract', this.contractForm, { headers: { Authorization: 'Bearer ' + this.authStore.getToken } }).then((response) => {
        toastr.success('Update successfully!');
        $('#edit-contract-modal').modal('hide');
        this.getContracts();
        this.disableDropdown();
      }).catch((error) => {
        toastr.error('This contract already exists in the database!');
      })
    },

    delContract() {
      if (this.auth.del == 0) {
        toastr.warning("You're not authorized to delete!");
      } else {
        this.$swal.fire({
          text: this.$t('delete?'),
          icon: 'question',
          showCancelButton: true,
          confirmButtonText: '<i class="fe fe-trash-2"></i> <span class="fs-14 fw-light">' + this.$t('del-btn') + '</span>',
          cancelButtonText: '<i class="fe fe-x"></i> <span class="fs-14 fw-light">' + this.$t('cancel-btn') + '</span>',
          confirmButtonColor: '#d33',
          allowEnterKey: false,
          allowOutsideClick: false,
        }).then((result) => {
          if (result.isConfirmed) {
            axios.post('api/sales/del-contract', {
              contract_id: this.contractForm.contract_id,
              fileList: this.fileFilter
            }, { headers: { Authorization: 'Bearer ' + this.authStore.getToken } }).then((response) => {
              this.contractData.splice(this.contractForm.row_index, 1);
              toastr.success('Delete successfully!');
              this.getContracts();
              this.getOrders();
              this.getFiles();
              this.disableDropdown();
            }).catch((error) => {
              console.log(error);
            })
          }
        });
      }
    },

    orderOpen() {
      if (this.auth.edit == 0) {
        toastr.warning("You're not authorized to edit!");
      } else {
        this.orderForm = {};
        this.orderForm.order_status = 'Active';
        document.getElementById('order-close').style.display = 'block';
        document.getElementById('order-addbtn').style.display = 'block';
        document.getElementById('order-updbtn').style.display = 'none';
        document.getElementById('order-cancel').style.display = 'none';
        $('#order-modal').modal('show');
      }
    },

    async addOrder() {
      if (this.auth.new == 0) {
        toastr.warning("You're not authorized to add!");
      } else {
        let f = this.orderForm;
        const response = await axios.post('api/sales/add-order', {
          contract_id: this.contractForm.contract_id,
          order_date: f.order_date,
          grade_id: f.grade_id,
          quantity: f.quantity,
          initial_price: f.initial_price,
          currency: f.currency,
          vat_remark: f.vat_remark,
          price_term: f.price_term,
          co_number: f.co_number,
          order_appendix: f.order_appendix,
          order_status: f.order_status,
          order_remark: f.order_remark
        }, { headers: { Authorization: 'Bearer ' + this.authStore.getToken } });
        if (response.data.success) {
          toastr.success('Successfully!');
          this.orderForm = {};
          const data = await this.getOrders();
          let items = this.orderData.filter((e) => e.contract_id == this.contractForm.contract_id);
          this.orderFilter = items;
          this.disableDropdown();
        } else {
          toastr.error(`${response.data.message}`);
        }
      }
    },

    editOrder(order_id) {
      let item = this.orderFilter.find((e) => e.order_id == order_id);
      let f = this.orderForm;

      f.order_id = order_id;
      f.order_date = this.store.yyyymmdd(item.order_date);
      f.grade_id = item.grade_id;
      f.grade_gar = item.grade_gar;
      f.quantity = item.quantity;
      f.initial_price = item.initial_price;
      f.currency = item.currency;
      f.vat_remark = item.vat_remark;
      f.price_term = item.price_term;
      f.co_number = item.co_number;
      f.order_appendix = item.order_appendix;
      f.order_status = item.order_status;
      f.order_remark = item.order_remark;

      document.getElementById('order-addbtn').style.display = 'none';
      document.getElementById('order-close').style.display = 'none';
      document.getElementById('order-cancel').style.display = 'block';
      document.getElementById('order-updbtn').style.display = 'block';
    },

    cancelOrder() {
      this.orderForm = {};
      this.orderForm.order_status = 'Active';
      document.getElementById('order-addbtn').style.display = 'block';
      document.getElementById('order-close').style.display = 'block';
      document.getElementById('order-cancel').style.display = 'none';
      document.getElementById('order-updbtn').style.display = 'none';
    },

    async updOrder() {
      if (this.auth.edit == 0) {
        toastr.warning("You're not authorized to edit!");
      } else {
        try {
          const data = await axios.post('api/sales/upd-order', this.orderForm, { headers: { Authorization: 'Bearer ' + this.authStore.getToken } });
          toastr.success('Successfully!');
          this.orderForm = {};
          const wait = await this.getOrders();
          let items = this.orderData.filter((e) => e.contract_id == this.contractForm.contract_id);
          this.orderFilter = items;
          this.disableDropdown();
          document.getElementById('order-addbtn').style.display = 'block';
          document.getElementById('order-close').style.display = 'block';
          document.getElementById('order-cancel').style.display = 'none';
          document.getElementById('order-updbtn').style.display = 'none';
        } catch (error) {
          toastr.error('Duplicates data!');
        }
      }
    },

    delOrder(ord_id, index) {
      if (this.auth.del == 0) {
        toastr.warning("You're not authorized to delete!");
      } else {
        this.$swal.fire({
          text: this.$t('delete?'),
          icon: 'question',
          showCancelButton: true,
          confirmButtonText: '<i class="fe fe-trash-2"></i> <span class="fs-14 fw-light">' + this.$t('del-btn') + '</span>',
          cancelButtonText: '<i class="fe fe-x"></i> <span class="fs-14 fw-light">' + this.$t('cancel-btn') + '</span>',
          confirmButtonColor: '#d33',
          allowEnterKey: false,
          allowOutsideClick: false,
        }).then((result) => {
          if (result.isConfirmed) {
            axios.post('api/sales/del-order', {
              id: ord_id
            }, { headers: { Authorization: 'Bearer ' + this.authStore.getToken } }).then((response) => {
              toastr.success('Successfully!');
              this.orderFilter.splice(index, 1);
              this.getOrders();
            }).catch((error) => {
              console.log(error);
            })
          }
        });
      }
    },

    editAttachment() {
      if (this.auth.edit == 0) {
        toastr.warning("You're not authorized to edit!");
      } else {
        $('#attachment-modal').modal('show');
      }
    },

    addAttachment() {
      let fd = new FormData();
      for (let i = 0; i < this.fileFilter.length; i++) {
        let f = this.fileFilter[i];
        if (f.note == 'new') {
          fd.append('files[' + i + ']', f.file);
        }
      }

      fd.append('contract_id', this.contractForm.contract_id);
      axios.post('api/sales/add-contract-file', fd, { headers: { 'Content-Type': 'multipart/form-data', Authorization: 'Bearer ' + this.authStore.getToken } })
        .then((response) => {

          $('#attachment-modal').modal('hide');
          toastr.success('Successfully!');
          this.getFiles();
          this.disableDropdown();

        }).catch((error) => {
          console.log(error);
        })
    },

    removeFile(index) {
      this.fileFilter.splice(index, 1);
    },

    newAttached() {
      this.$refs.fileInput.click();
    },

    addAttachedTemp() {
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

    delFile(file_id, file_name, index) {
      if (this.auth.del == 0) {
        toastr.warning("You're not authorized to delete!");
      } else {
        this.$swal.fire({
          text: this.$t('delete?'),
          icon: 'question',
          showCancelButton: true,
          confirmButtonText: '<i class="fe fe-trash-2"></i> <span class="fs-14 fw-light">' + this.$t('del-btn') + '</span>',
          cancelButtonText: '<i class="fe fe-x"></i> <span class="fs-14 fw-light">' + this.$t('cancel-btn') + '</span>',
          confirmButtonColor: '#d33',
          allowEnterKey: false,
          allowOutsideClick: false,
        }).then((result) => {
          if (result.isConfirmed) {
            axios.post('api/sales/del-contract-file', {
              id: file_id,
              file: file_name
            }, { headers: { Authorization: 'Bearer ' + this.authStore.getToken } }).then((response) => {
              toastr.success('Successfully!');
              this.fileFilter.splice(index, 1);
              this.getFiles();
            }).catch((error) => {
              console.log(error);
            })
          }
        });
      }
    },

    downloadFile(file) {
      const url = `/api/sales/download-contract-file/${file}`;
      window.location.href = url;
    },

    viewFile(file) {
      window.open(window.location.origin + '/assets/images/contracts/' + file, '_blank');
    },

    notView() {
      toastr.info("File isn't viewable; please download instead.");
    },


    viewContract() {
      this.viewMode = 'view';
      let cusomer = this.contractData.find((e) => e.contract_id == this.contractForm.contract_id);
      this.customerFilter = cusomer;
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

    enableDropdown() {
      const elements = document.querySelectorAll('[id^="contract-dw-"]');
      elements.forEach((e) => {
        e.classList.remove('disabled');
      });
    },

    disableDropdown() {
      const elements = document.querySelectorAll('[id^="contract-dw-"]');
      elements.forEach((e) => {
        e.classList.add('disabled');
      });
    },
  },

  created() {
    this.onLoad();
  },
};
</script>
