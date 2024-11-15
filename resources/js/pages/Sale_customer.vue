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
                <button type="button" class="btn btn-soft-info add-btn" id="create-btn" @click="newCustomer()"><i class="ri-add-line align-bottom me-1"></i> Add Customer</button>
                <button class="btn btn-soft-info btn-icon" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                  <i class="ri-more-2-fill"></i>
                </button>
                <ul class="dropdown-menu dropdown-menu-end dropdownmenu-secondary">
                  <li><a class="dropdown-item disabled" id="customer-dw-1" href="javascript:void(0);" @click="viewMode = 'view'"><i class="ri-eye-fill align-bottom me-2 text-muted"></i>View</a></li>
                  <li><a class="dropdown-item disabled" id="customer-dw-2" href="javascript:void(0);" @click="editCustomer()"><i class="ri-pencil-fill align-bottom me-2 text-muted"></i>Edit</a></li>
                  <li><a class="dropdown-item disabled" id="customer-dw-3" href="javascript:void(0);" @click="delCustomer()"><i class="ri-delete-bin-fill align-bottom me-2 text-muted"></i>Delete</a></li>
                  <div class="dropdown-divider"></div>
                  <li><a class="dropdown-item disabled" id="customer-dw-4" href="javascript:void(0);" @click="editAttachment()"><i class="ri-attachment-line align-bottom me-2 text-muted"></i>Attachments</a></li>
                </ul>
              </div>
            </div>
          </div>
        </div>
        <ag-grid-vue style="height: calc(100vh - 15.80rem);" class="ag-theme-material" :columnDefs="columnDefs" :rowData="customerList" :defaultColDef="defaultColDef" :rowHeight="36" :headerHeight="44" :popupParent="popupParent" :suppressMenuHide="false" :suppressCellFocus="true" animateRows="false" rowSelection="single" @rowClicked="cellCicked" @cell-double-clicked="viewMode = 'view'"></ag-grid-vue>
        <div class="pb-1"></div>
      </div>

      <!-- View Customer -->
      <div class="row justify-content-center" v-if="viewMode == 'view'">
        <div class="col-xxl-8 col-lg-9">
          <div class="card" id="demo">
            <div class="row">
              <div class="col-lg-12">
                <div class="card-header border-bottom-dashed p-4">
                  <div class="d-xl-flex">
                    <div class="flex-grow-1">
                      <h5 class="text-uppercase fw-semibold">{{ customerForm.customer_name }}</h5>
                      <div class="mt-xl-4 mt-4">
                        <h6 class="text-muted text-uppercase fw-semibold">Address</h6>
                        <p class="mb-1">{{ customerForm.full_address }}</p>
                        <p class="mb-1"><span class="text-muted">Country: </span>{{ customerForm.country }}</p>
                        <p class="mb-1"><span class="text-muted">Destination: </span>{{ customerForm.destination }}</p>
                      </div>
                    </div>
                    <div class="flex-shrink-0 mt-xl-0 mt-3">
                      <!-- <h6><span class="text-muted fw-normal">Customer ID: </span><span>{{ customerForm.customer_id }}</span></h6> -->
                      <h6><span class="text-muted fw-normal">Customer Code: </span><span>{{ customerForm.customer_code }}</span></h6>
                      <h6><span class="text-muted fw-normal">Tax Code: </span><span>{{ customerForm.tax_code }}</span></h6>
                      <h6><span class="text-muted fw-normal">Email: </span><span id="email">{{ customerForm.email }}</span></h6>
                      <h6><span class="text-muted fw-normal">Contact: </span><span> {{ customerForm.contract }}</span></h6>
                      <h6><span class="text-muted fw-normal">Contact No: </span><span id="contact-no"> {{ customerForm.phone }}</span></h6>
                    </div>
                  </div>
                </div>
              </div>

              <div class="col-lg-12" v-if="customerForm.remarks">
                <div class="card-body p-4">
                  <h6 class="text-muted text-uppercase fw-semibold">Remarks</h6>
                  <p class="mb-1">{{ customerForm.remarks }}</p>
                </div>
              </div>
              <div class="col-lg-12" v-if="fileFilter.length > 0">
                <div class="card-body p-4 border-top border-top-dashed d-print-none">
                  <h6 class="text-muted text-uppercase fw-semibold">Attachments</h6>
                  <div class="table-responsive border">
                    <table class="table align-middle table-borderless table-nowrap mb-0">
                      <thead class="table-active text-muted">
                        <tr>
                          <th>#</th>
                          <th>Name</th>
                          <th>Type</th>
                          <th>Size</th>
                          <th>Actions</th>
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
                          <td>{{ item.file_type }}</td>
                          <td>{{ item.size }}</td>
                          <td>
                            <div class="d-flex gap-2 justify-content-start">
                              <a href="#" class="link-success text-decoration-none fs-16" @click="downloadFile(item.new_name)"><i class="ri-download-2-line"></i></a>
                              <a v-if="item.file_type == 'jpg' || item.file_type == 'txt' || item.file_type == 'pdf' || item.file_type == 'jpeg' || item.file_type == 'png'" href="#" class="link-success text-decoration-none fs-14 mt-1" @click="viewFile(item.new_name)"><i class="ri-eye-fill"></i></a>
                            </div>
                          </td>
                        </tr>
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>
              <div class="col-lg-12">
                <div class="card-body p-4">
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

      <!-- Customer Modal -->
      <div class="modal fade" id="customer-modal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-modal="true" role="dialog">
        <div class="modal-dialog modal-lg">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="customer-modal-title">Add Customer</h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-content border-0 mt-3">
              <ul class="nav nav-tabs nav-tabs-custom nav-success p-2 pb-0 bg-light" role="tablist">
                <li class="nav-item" role="presentation">
                  <a class="nav-link active" id="customer-tab" data-bs-toggle="tab" href="#customer" role="tab" aria-selected="true">
                    Customer Details
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
                <div class="tab-pane active show" id="customer" role="tabpanel">
                  <div class="row">
                    <div class="col-lg-12">
                      <div class="mb-3">
                        <label class="form-label">Customer's Name <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" placeholder="Enter customer name" v-model="customerForm.customer_name">
                      </div>
                    </div>
                    <div class="col-lg-12">
                      <div class="mb-3">
                        <label class="form-label">Full Addresses</label>
                        <input type="text" class="form-control" placeholder="Enter full address" v-model="customerForm.full_address">
                      </div>
                    </div>
                    <div class="col-lg-4">
                      <div class="mb-3">
                        <label class="form-label">Customer Code</label>
                        <input type="text" class="form-control" placeholder="Enter code from accounting" v-model="customerForm.customer_code">
                      </div>
                    </div>
                    <div class="col-lg-4">
                      <div class="mb-3">
                        <label class="form-label">Country <span class="text-danger">*</span></label>
                        <multiselect placeholder="Select country" :options="lkCountry" v-model="customerForm.country" />
                      </div>
                    </div>
                    <div class="col-lg-4">
                      <div class="mb-3">
                        <label class="form-label">Destination <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" placeholder="Autofill based on country" v-model="customerForm.destination" readonly>
                      </div>
                    </div>
                    <div class="col-lg-6">
                      <div class="mb-3">
                        <label class="form-label">Tax Code</label>
                        <input type="text" class="form-control" placeholder="Enter tax code" v-model="customerForm.tax_code">
                      </div>
                    </div>
                    <div class="col-lg-6">
                      <div class="mb-3">
                        <label class="form-label">Contract Name</label>
                        <input type="text" class="form-control" placeholder="Enter contract person's name" v-model="customerForm.contract">
                      </div>
                    </div>
                    <div class="col-lg-6">
                      <div class="mb-3">
                        <label class="form-label">Phone Number</label>
                        <input type="text" class="form-control" placeholder="Enter contract number" v-model="customerForm.phone">
                      </div>
                    </div>
                    <div class="col-lg-6">
                      <div class="mb-3">
                        <label class="form-label">Email</label>
                        <input type="text" class="form-control" placeholder="Enter contract email" v-model="customerForm.email">
                      </div>
                    </div>
                    <div class="col-lg-12">
                      <label class="form-label">Remarks</label>
                      <textarea class="form-control" rows="3" placeholder="Enter remarks" v-model="customerForm.remarks"></textarea>
                    </div>
                    {{ getDestination }}
                  </div>
                </div>

                <!-- Attachments Tab -->
                <div class="tab-pane" id="attachment" role="tabpanel">
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
                          <div>Size: {{ item.size }}</div>
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
                              <ul class="dropdown-menu dropdown-menu-end dropdownmenu-secondary" style="">
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
              </div>
            </div>
            <div class="modal-footer" style="display: block;">
              <div class="hstack gap-2 justify-content-end">
                <button type="button" class="btn btn-light" data-bs-dismiss="modal"><i class="ri-close-line me-1 align-middle"></i> {{ $t('close-btn') }}</button>
                <button type="button" class="btn btn-success" :class="addCustomerDis" @click="addCustomer()"><i class="ri-add-line align-bottom me-1"></i>{{ $t('add-customer') }}</button>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- Edit Customer Modal -->
      <div class="modal fade zoomIn" id="edit-customer-modal" data-bs-keyboard="false" tabindex="-1" aria-modal="true" role="dialog">
        <div class="modal-dialog modal-lg modal-dialog-centered">
          <div class="modal-content">
            <div class="modal-header bg-light p-3">
              <h5 class="modal-title">Edit Customer</h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
              <div class="row">
                <div class="col-lg-12">
                  <div class="mb-3">
                    <label class="form-label">Customer's Name<span class="text-danger">*</span></label>
                    <input type="text" class="form-control" placeholder="Enter customer name" v-model="customerForm.customer_name">
                  </div>
                </div>
                <div class="col-lg-12">
                  <div class="mb-3">
                    <label class="form-label">Full Addresses</label>
                    <input type="text" class="form-control" placeholder="Enter full address" v-model="customerForm.full_address">
                  </div>
                </div>
                <div class="col-lg-4">
                  <div class="mb-3">
                    <label class="form-label">Customer Code</label>
                    <input type="text" class="form-control" placeholder="Enter code from accounting" v-model="customerForm.customer_code">
                  </div>
                </div>
                <div class="col-lg-4">
                  <div class="mb-3">
                    <label class="form-label">Country <span class="text-danger">*</span></label>
                    <multiselect placeholder="Select country" :options="lkCountry" v-model="customerForm.country" />
                  </div>
                </div>
                <div class="col-lg-4">
                  <div class="mb-3">
                    <label class="form-label">Destination <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" placeholder="Autofill based on country" v-model="customerForm.destination" readonly>
                  </div>
                </div>
                <div class="col-lg-6">
                  <div class="mb-3">
                    <label class="form-label">Tax Code</label>
                    <input type="text" class="form-control" placeholder="Enter tax code" v-model="customerForm.tax_code">
                  </div>
                </div>
                <div class="col-lg-6">
                  <div class="mb-3">
                    <label class="form-label">Contract Name</label>
                    <input type="text" class="form-control" placeholder="Enter contract person's name" v-model="customerForm.contract">
                  </div>
                </div>
                <div class="col-lg-6">
                  <div class="mb-3">
                    <label class="form-label">Phone Number</label>
                    <input type="text" class="form-control" placeholder="Enter contract number" v-model="customerForm.phone">
                  </div>
                </div>
                <div class="col-lg-6">
                  <div class="mb-3">
                    <label class="form-label">Email</label>
                    <input type="text" class="form-control" placeholder="Enter contract email" v-model="customerForm.email">
                  </div>
                </div>
                <div class="col-lg-12">
                  <label class="form-label">Remarks</label>
                  <textarea class="form-control" rows="3" placeholder="Enter remarks" v-model="customerForm.remarks"></textarea>
                </div>
                {{ getDestination }}
              </div>
            </div>
            <div class="modal-footer" style="display: block;">
              <div class="hstack gap-2 justify-content-end">
                <button type="button" class="btn btn-light" data-bs-dismiss="modal"><i class="ri-close-line me-1 align-middle"></i>{{ $t('close-btn') }}</button>
                <button type="button" id="cus-upd" class="btn btn-success" :class="addCustomerDis" @click="updCustomer()"><i class="ri-save-3-line align-bottom me-1"></i>{{ $t('save-btn') }}</button>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- Edit Attachments Modal -->
      <div class="modal fade zoomIn" id="attachment-modal" data-bs-keyboard="false" tabindex="-1" aria-modal="true" role="dialog">
        <div class="modal-dialog modal-lg modal-dialog-centered">
          <div class="modal-content">
            <div class="modal-header bg-light p-3">
              <h5 class="modal-title">Customer Attachments</h5>
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
                      <div>Size: {{ item.size }}</div>
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
                          <ul class="dropdown-menu dropdown-menu-end dropdownmenu-secondary" style="">
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
                <button type="button" id="cus-upd" class="btn btn-success" :class="addAttachmentDis" @click="addAttachment()"><i class="ri-save-3-line align-bottom me-1"></i>{{ $t('save-btn') }}</button>
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
import "ag-grid-community/styles/ag-grid.css";
import "ag-grid-community/styles/ag-theme-material.css";
import "ag-grid-enterprise";
import { useToastr } from "../toastr.js";
import { useStore } from '../stores/store.js';
import { useAuthStore } from '../stores/auth.js';
const toastr = useToastr();

export default {
  name: 'XpplAppSaleCustomer',
  components: { AgGridVue },
  setup() {
    const store = useStore();
    const authStore = useAuthStore();
    return { store, authStore };
  },

  data() {
    return {
      columnDefs: [
        { headerName: '#', maxWidth: 50, valueGetter: (params) => { return params.node.rowIndex + 1 } },
        { headerName: "ID", field: 'customer_id', hide: true },
        { headerName: 'Customer Name', field: 'customer_name', minWidth: 250, filter: 'agSetColumnFilter' },
        { headerName: 'Full Address', field: 'full_address', filter: 'agSetColumnFilter' },
        { headerName: 'Customer Code', field: 'customer_code', filter: 'agSetColumnFilter' },
        { headerName: 'Country', field: 'country', filter: 'agSetColumnFilter' },
        { headerName: 'Destonation', field: 'destination', filter: 'agSetColumnFilter' },
        { headerName: 'Tax Code', field: 'tax_code', filter: 'agSetColumnFilter' },
        { headerName: 'Contract', field: 'contract', filter: 'agSetColumnFilter' },
        { headerName: 'Phone', field: 'phone', filter: 'agSetColumnFilter' },
        { headerName: 'Email', field: 'email', filter: 'agSetColumnFilter' },
        { headerName: 'Created at', field: 'created_at', hide: true, valueFormatter: p => p.value ? moment(p.value).format('DD/MM/YYYY HH:mm:ss') : '' },
        { headerName: 'Created by', field: 'created_by', filter: 'agSetColumnFilter', hide: true },
        { headerName: 'Updated at', field: 'updated_at', hide: true, valueFormatter: p => p.value ? moment(p.value).format('DD/MM/YYYY HH:mm:ss') : '' },
        { headerName: 'Updated by', field: 'updated_by', filter: 'agSetColumnFilter', hide: true },
      ],

      defaultColDef: {
        sortable: true,
        resizable: true,
        flex: 1,
        filterParams: { buttons: ['reset'] },
        popupParent: document.body,
        minWidth: 100,
        cellClassRules: { 'pointer': 'true' },
        menuTabs: ['filterMenuTab', 'generalMenuTab', 'columnsMenuTab']
      },

      customerData: [],
      fileData: [],
      lkCode: [],
      lkCountry: [],
      customerForm: { customer_id: '', customer_code: '', customer_name: '', full_address: '', country: null, destination: '', tax_code: '', contract: '', email: '', phone: '', remarks: '' },
      fileFilter: [],

      auth: [],
      search: '',
      viewMode: 'main',
      loading: false
    };
  },

  mounted() {

  },

  computed: {
    getDestination() {
      if (this.customerForm.country) {
        this.customerForm.country == "Laos" ? this.customerForm.destination = "Domestic" : this.customerForm.destination = "Oversea";
      } else {
        this.customerForm.destination = "";
      }
    },

    addCustomerDis() {
      if (this.customerForm.customer_name == "" || this.customerForm.country == null) {
        return "disabled";
      } else {
        return "";
      }
    },

    customerList() {
      if (this.search.trim().length > 0) {
        return this.customerData.filter((i) => i.customer_name.substring(0, this.search.trim().length).toLowerCase() == this.search.trim().toLowerCase());
      };
      return this.customerData;
    },

    addAttachmentDis() {
      if (this.fileFilter.length == 0) {
        return 'disabled';
      } else {
        return '';
      }
    },
  },

  methods: {
    async onLoad() {
      this.loading = true;
      const code = await axios.get('api/sales/codes', { headers: { Authorization: 'Bearer ' + this.authStore.getToken } });
      this.lkCode = code.data;

      const sub = 'M07S02';
      const subData = await axios.get(`api/auth/auth-action?submenu=${sub}`, { headers: { Authorization: 'Bearer ' + this.authStore.getToken } });
      this.auth = subData.data[0];

      const cusdata = await this.getCustomers();
      const cusFile = await this.getFiles();

      let countries = this.lkCode.filter((e) => e.category == 'Country');
      countries.forEach((e) => {
        this.lkCountry.push({
          value: e.code,
          label: e.code
        })
      })
      this.loading = false;
    },

    async getCustomers() {
      const customers = await axios.get('api/sales/customers', { headers: { Authorization: 'Bearer ' + this.authStore.getToken } });
      this.customerData = customers.data;
    },

    async getFiles() {
      const cusfile = await axios.get('api/sales/customer-file', { headers: { Authorization: 'Bearer ' + this.authStore.getToken } });
      this.fileData = cusfile.data;
    },

    newCustomer() {
      if (this.auth.new == 0) {
        toastr.warning("You're not authorized to add!");
      } else {
        this.customerForm = {};
        this.fileFilter = [];

        document.getElementById('attachment-tab').classList.remove('active');
        document.getElementById('attachment').classList.remove('active', 'show');
        document.getElementById('customer-tab').classList.add('active');
        document.getElementById('customer').classList.add('active', 'show');
        $('#customer-modal').modal('show');
      }
    },

    async addCustomer() {
      let fd = new FormData();
      for (let i = 0; i < this.fileFilter.length; i++) {
        let f = this.fileFilter[i];
        fd.append('files[' + i + ']', f.file);
      }

      let fm = this.customerForm;
      fd.append('customer_name', fm.customer_name.toUpperCase());
      fd.append('country', fm.country);
      fd.append('destination', fm.destination);
      fm.customer_code ? fd.append('customer_code', fm.customer_code) : '';
      fm.full_address ? fd.append('full_address', fm.full_address) : '';
      fm.tax_code ? fd.append('tax_code', fm.tax_code) : '';
      fm.contract ? fd.append('contract', fm.contract) : '';
      fm.phone ? fd.append('phone', fm.phone) : '';
      fm.email ? fd.append('email', fm.email) : '';
      fm.remarks ? fd.append('remarks', fm.remarks) : '';

      const response = await axios.post('api/sales/add-customer', fd, { headers: { 'Content-Type': 'multipart/form-data', Authorization: 'Bearer ' + this.authStore.getToken } })
      if (response.data.success) {
        $('#customer-modal').modal('hide');
        toastr.success('Successfully!');
        this.getCustomers();
        this.getFiles();
      } else {
        toastr.error(`${response.data.message}`);
      }
    },

    // async newCustomer() {
    //   if (this.auth.new == 0) {
    //     toastr.warning("You're not authorized to add!");
    //   } else {
    //     this.customerForm = {};
    //     this.fileFilter = [];

    //     this.customerModal();

    //     document.getElementById("customer-modal-header").textContent = "Add Customer";
    //     document.getElementById("cus-upd").style.display = "none";
    //     const addEvent = document.getElementById('cus-add');
    //     addEvent.style.display = 'block';


    //     addEvent.textContent = this.$t('addCustomer');
    //     $("#customer-modal").modal("show");


    //     const addCustomerClick = async () => {
    //       let fd = new FormData();
    //       for (let i = 0; i < this.fileFilter.length; i++) {
    //         let f = this.fileFilter[i];
    //         fd.append("files[" + i + "]", f.file);
    //       }

    //       let fm = this.customerForm;
    //       fd.append("customer_name", fm.customer_name.toUpperCase());
    //       fd.append("country", fm.country);
    //       fd.append("destination", fm.destination);
    //       fm.customer_code ? fd.append("customer_code", fm.customer_code) : "";
    //       fm.full_address ? fd.append("full_address", fm.full_address) : "";
    //       fm.tax_code ? fd.append("tax_code", fm.tax_code) : "";
    //       fm.contract ? fd.append("contract", fm.contract) : "";
    //       fm.phone ? fd.append("phone", fm.phone) : "";
    //       fm.email ? fd.append("email", fm.email) : "";
    //       fm.remarks ? fd.append("remarks", fm.remarks) : "";

    //       const response = await axios.post("/api/sales/addCustomer", fd, { headers: { "Content-Type": "multipart/form-date" } })
    //       if (response.data.success) {
    //         $("#customer-modal").modal("hide");
    //         toastr.success('Successfully!');
    //         this.getCustomers();
    //         this.getFiles();
    //       } else {
    //         toastr.error(`${response.data.message}`);
    //       }
    //     }
    //     addEvent.addEventListener('click', addCustomerClick);
    //   }
    // },

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

    removeFile(index) {
      this.fileFilter.splice(index, 1);
    },

    cellCicked(el) {
      this.enableDropdown();

      let fm = this.customerForm;
      fm.customer_id = el.data.customer_id;
      fm.customer_code = el.data.customer_code;
      fm.customer_name = el.data.customer_name;
      fm.full_address = el.data.full_address;
      fm.country = el.data.country;
      fm.destination = el.data.destination;
      fm.tax_code = el.data.tax_code;
      fm.contract = el.data.contract;
      fm.phone = el.data.phone;
      fm.email = el.data.email;
      fm.remarks = el.data.remarks;

      let item = this.fileData.filter((e) => e.customer_id == this.customerForm.customer_id);
      this.fileFilter = item;
    },

    editCustomer() {
      if (this.auth.edit == 0) {
        toastr.warning("You're not authorized to edit!");
      } else {
        $('#edit-customer-modal').modal('show');
      }
    },

    updCustomerOld() {
      let fd = new FormData();
      for (let i = 0; i < this.fileFilter.length; i++) {
        let f = this.fileFilter[i];
        if (f.note == 'new') {
          fd.append('files[' + i + ']', f.file);
        }
      }

      let fm = this.customerForm;
      fd.append('customer_id', fm.customer_id);
      fd.append('customer_name', fm.customer_name.toUpperCase());
      fd.append('country', fm.country);
      fd.append('destination', fm.destination);
      fm.customer_code ? fd.append('customer_code', fm.customer_code) : '';
      fm.full_address ? fd.append('full_address', fm.full_address) : '';
      fm.tax_code ? fd.append('tax_code', fm.tax_code) : '';
      fm.contract ? fd.append('contract', fm.contract) : '';
      fm.phone ? fd.append('phone', fm.phone) : '';
      fm.email ? fd.append('email', fm.email) : '';
      fm.remarks ? fd.append('remarks', fm.remarks) : '';

      axios.post('api/sales/upd-customer', fd, { headers: { 'Content-Type': 'multipart/form-date', Authorization: 'Bearer ' + this.authStore.getToken } })
        .then((response) => {
          if (response.data.success) {
            $('#customer-modal').modal('hide');
            toastr.success('Successfully!');
            this.getCustomers();
            this.getFiles();
          } else {
            toastr.error(`${response.data.message}`);
          }
        }).catch((error) => {
          toastr.error("The customer you've modified exists in the database!");
        })
    },

    updCustomer() {
      axios.post('api/sales/upd-customer', this.customerForm, { headers: { Authorization: 'Bearer ' + this.authStore.getToken } }).then((response) => {
        toastr.success('Update successfully!');
        $('#edit-customer-modal').modal('hide');
        this.getCustomers();
        this.disableDropdown();
      }).catch((error) => {
        toastr.error("The customer you've modified exists in the database!");
      })
    },

    editAttachment() {
      if (this.auth.edit == 0) {
        toastr.warning("You're not authorized to edit!");
      } else {
        $('#edit-customer-modal').modal('show');
      }
    },

    addAttachment() {
      let fd = new FormData();
      for (let i = 0; i < this.fileFilter.length; i++) {
        let f = this.fileFilter[i];
        if (f.note == 'new') {
          fd.append('files[' + i + ']', f.file);
        }
      };

      fd.append('customer_id', this.customerForm.customer_id);
      axios.post('api/sales/add-customer-file', fd, { headers: { 'Content-Type': 'multipart/form-data', Authorization: 'Bearer ' + this.authStore.getToken } })
        .then((response) => {

          $('#attachment-modal').modal('hide');
          toastr.success('Successfully!');
          this.getFiles();
          this.disableDropdown();

        }).catch((error) => {
          console.log(error);
        })
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
            axios.post('api/sales/del-customer-file', {
              id: id,
              file: file
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

    delCustomer() {
      if (this.auth.del == 0) {
        toastr.warning("You're not authorized to delete!");
      } else {
        this.$swal.fire({
          text: 'Do you want to delete this customer?',
          icon: 'question',
          showCancelButton: true,
          confirmButtonText: '<i class="fe fe-trash-2"></i> <span class="fs-14 fw-light">Delete</span>',
          cancelButtonText: '<i class="fe fe-x"></i> <span class="fs-14 fw-light">Cancel</span>',
          confirmButtonColor: '#d33',
          allowEnterKey: false,
          allowOutsideClick: false,
        }).then((result) => {
          if (result.isConfirmed) {
            axios.post('api/sales/del-customer', {
              id: this.customerForm.customer_id,
              listFile: this.fileFilter
            }, { headers: { Authorization: 'Bearer ' + this.authStore.getToken } }).then((response) => {
              if (response.data.success) {
                toastr.success('Successfully!');
                this.getCustomers();
                this.getFiles();
              } else {
                toastr.error(`${response.data.message}`);
              }
            }).catch((error) => {
              console.log(error);
            })
          }
        });
      }
    },

    downloadFile(file) {
      const url = `/api/sales/download-customer-file/${file}`;
      window.location.href = url;
    },

    viewFile(file) {
      window.open(window.location.origin + '/assets/images/customers/' + file, '_blank')
    },

    onSearch() {
      if (this.search.length > 0) {
        document.getElementById('search-close').classList.remove('d-none');
      } else {
        document.getElementById('search-close').classList.add('d-none');
      }
    },

    searchClear() {
      this.search = '';
      document.getElementById('search-close').classList.add('d-none');
    },

    enableDropdown() {
      const elements = document.querySelectorAll('[id^="customer-dw-"]');
      elements.forEach((e) => {
        e.classList.remove('disabled');
      });
    },

    disableDropdown() {
      const elements = document.querySelectorAll('[id^="customer-dw-"]');
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