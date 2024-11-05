<template>
  <div>
    <!-- <div v-if="loading">
      <loading />
    </div> -->
    <!-- <div v-else> -->
    <div class="card" v-if="viewMode == 'main'">
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
              <button type="button" class="btn btn-soft-info add-btn" id="create-btn" @click="newEmployee"><i class="ri-add-line align-bottom me-1"></i> Add Employee</button>
              <button class="btn btn-soft-info btn-icon" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                <i class="ri-more-2-fill fs-16"></i>
              </button>
              <ul class="dropdown-menu dropdown-menu-end dropdownmenu-secondary">
                <li><a class="dropdown-item" id="customer-dw-1" href="javascript:void(0);" @click="test"><i class="ri-eye-fill align-bottom me-2 text-muted"></i>View</a></li>
                <li><a class="dropdown-item" id="customer-dw-2" href="javascript:void(0);" @click="viewMode = 'edit'"><i class="ri-pencil-fill align-bottom me-2 text-muted"></i>Edit</a></li>
                <li><a class="dropdown-item disabled" id="customer-dw-3" href="javascript:void(0);" @click="delCustomer"><i class="ri-delete-bin-fill align-bottom me-2 text-muted"></i>Delete</a></li>
                <div class="dropdown-divider"></div>
                <li><a class="dropdown-item disabled" id="customer-dw-4" href="javascript:void(0);" @click="editAttachment"><i class="ri-attachment-line align-bottom me-2 text-muted"></i>Attachments</a></li>
              </ul>
            </div>
          </div>
        </div>
      </div>
      <ag-grid-vue style="height: calc(100vh - 15.80rem);" class="ag-theme-material" :columnDefs="columnDefs" :rowData="employeeData" :defaultColDef="defaultColDef" :rowHeight="36" :headerHeight="44" :popupParent="popupParent" :suppressMenuHide="false" :suppressCellFocus="true" animateRows="false" rowSelection="single" @rowClicked="cellCicked" @cell-double-clicked="viewMode = 'view'"></ag-grid-vue>
      <div class="pb-1"></div>
    </div>
    <!-- </div> -->

    <div class="card" v-if="viewMode == 'edit'">
      <!-- <div class="card-header">
        Header
      </div> -->

      <div class="card-body">

        <div class="row">
          <div class="col-xxl-2">
            <div class="mt-4 pt-1">
              <img src="/public/assets/images/users/avatar-8.jpg" alt="" width="180" height="200" class="rounded material-shadow">
            </div>
          </div>

          <div class="col-xxl-10">
            <div class="row mt-4 mt-xxl-0">
              <div class="col-xl-2">
                <div class="mb-3">
                  <label class="form-label">Title <span class="text-danger">*</span></label>
                  <multiselect :searchable="false" :searchStart="true" placeholder="Select" :options="lkCustomer" />
                </div>
              </div>
              <div class="col-xl-5">
                <div class="mb-3">
                  <label class="form-label">Name Eng <span class="text-danger">*</span></label>
                  <input type="text" class="form-control" placeholder="Name english">
                </div>
              </div>
              <div class="col-xl-5">
                <div class="mb-3">
                  <label class="form-label">Name Eng <span class="text-danger">*</span></label>
                  <input type="text" class="form-control" placeholder="Name english">
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-xl-2">
                <div class="mb-3">
                  <label class="form-label">Title Lao <span class="text-danger">*</span></label>
                  <multiselect :searchable="false" :searchStart="true" placeholder="Select" :options="lkCustomer" />
                </div>
              </div>
              <div class="col-xl-5">
                <div class="mb-3">
                  <label class="form-label">Name Lao <span class="text-danger">*</span></label>
                  <input type="text" class="form-control" placeholder="Enter name in lao">
                </div>
              </div>
              <div class="col-xl-5">
                <div class="mb-3">
                  <label class="form-label">Surname Lao <span class="text-danger">*</span></label>
                  <input type="text" class="form-control" placeholder="Enter surname in lao">
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-xl-2">
                <div class="mb-3">
                  <label class="form-label">Date Of Birth </label>
                  <input type="text" class="form-control flatpickr-input flatpickr-single rounded-start-2" placeholder="Select date">
                </div>
              </div>
              <div class="col-xl-5">
                <div class="mb-3">
                  <label class="form-label">Phone Number </label>
                  <input type="text" class="form-control" placeholder="Enter phone number">
                </div>
              </div>
              <div class="col-xl-5">
                <div class="mb-3">
                  <label class="form-label">Email Address </label>
                  <input type="text" class="form-control" placeholder="Enter email Address">
                </div>
              </div>
            </div>
          </div>


          <div class="col-xl-2">
            <div class="mb-3">
              <label class="form-label">Education Level <span class="text-danger">*</span></label>
              <multiselect :searchable="false" :searchStart="true" placeholder="Select" :options="lkCustomer" />
            </div>
          </div>
          <div class="col-xl-4">
            <div class="mb-3">
              <label class="form-label">Education Major </label>
              <input type="text" class="form-control" placeholder="Enter email Address">
            </div>
          </div>
          <div class="col-xl-6">
            <div class="mb-3">
              <label class="form-label">Experience </label>
              <input type="text" class="form-control" placeholder="Enter email Address">
            </div>
          </div>

          <div class="col-xl-3">
            <div class="mb-3">
              <label class="form-label">Country <span class="text-danger">*</span></label>
              <multiselect :searchable="false" :searchStart="true" placeholder="Select" :options="lkCustomer" />
            </div>
          </div>
          <div class="col-xl-3">
            <div class="mb-3">
              <label class="form-label">Province </label>
              <multiselect :searchable="false" :searchStart="true" placeholder="Select" :options="lkCustomer" />
            </div>
          </div>
          <div class="col-xl-3">
            <div class="mb-3">
              <label class="form-label">District </label>
              <multiselect :searchable="false" :searchStart="true" placeholder="Select" :options="lkCustomer" />
            </div>
          </div>
          <div class="col-xl-3">
            <div class="mb-3">
              <label class="form-label">Village </label>
              <multiselect :searchable="false" :searchStart="true" placeholder="Select" :options="lkCustomer" />
            </div>
          </div>
          <div class="col-xl-6">
            <div class="mb-3">
              <label class="form-label">Home Address </label>
              <input type="text" class="form-control" placeholder="Enter email Address">
            </div>
          </div>
          <div class="col-xl-6">
            <div class="mb-3">
              <label class="form-label">Remarks </label>
              <input type="text" class="form-control" placeholder="Enter email Address">
            </div>
          </div>



        </div>








        <div class="mt-0">
          <ul class="nav nav-tabs nav-tabs-custom nav-success mb-3" role="tablist">
            <li class="nav-item" role="presentation">
              <a class="nav-link All py-3" data-bs-toggle="tab" id="All" href="#home1" role="tab" aria-selected="false" tabindex="-1">
                <!-- <i class="ri-store-2-fill me-1 align-bottom"></i>  -->
                Employee History
              </a>
            </li>
            <li class="nav-item" role="presentation">
              <a class="nav-link py-3 Delivered active" data-bs-toggle="tab" id="Delivered" href="#delivered" role="tab" aria-selected="true">
                <i class="ri-checkbox-circle-line me-1 align-bottom"></i> Delivered
              </a>
            </li>
            <li class="nav-item" role="presentation">
              <a class="nav-link py-3 Pickups" data-bs-toggle="tab" id="Pickups" href="#pickups" role="tab" aria-selected="false" tabindex="-1">
                <i class="ri-truck-line me-1 align-bottom"></i> Pickups <span class="badge bg-danger align-middle ms-1">2</span>
              </a>
            </li>
            <li class="nav-item" role="presentation">
              <a class="nav-link py-3 Returns" data-bs-toggle="tab" id="Returns" href="#returns" role="tab" aria-selected="false" tabindex="-1">
                <i class="ri-arrow-left-right-fill me-1 align-bottom"></i> Returns
              </a>
            </li>
            <li class="nav-item" role="presentation">
              <a class="nav-link py-3 Cancelled" data-bs-toggle="tab" id="Cancelled" href="#cancelled" role="tab" aria-selected="false" tabindex="-1">
                <i class="ri-close-circle-line me-1 align-bottom"></i> Cancelled
              </a>
            </li>
          </ul>

          <div class="table-responsive table-card mb-1">
            <table class="table table-nowrap align-middle" id="orderTable">
              <thead class="text-muted table-light">
                <tr class="text-uppercase">
                  <th scope="col" style="width: 25px;">
                    <div class="form-check">
                      <input class="form-check-input" type="checkbox" id="checkAll" value="option">
                    </div>
                  </th>
                  <th class="sort" data-sort="id">Order ID</th>
                  <th class="sort" data-sort="customer_name">Customer</th>
                  <th class="sort" data-sort="product_name">Product</th>
                  <th class="sort" data-sort="date">Order Date</th>
                  <th class="sort" data-sort="amount">Amount</th>
                  <th class="sort" data-sort="payment">Payment Method</th>
                  <th class="sort" data-sort="status">Delivery Status</th>
                  <th class="sort" data-sort="city">Action</th>
                </tr>
              </thead>
              <tbody class="list form-check-all">
                <tr>
                  <th scope="row">
                    <div class="form-check">
                      <input class="form-check-input" type="checkbox" name="checkAll" value="option1">
                    </div>
                  </th>
                  <td class="id"><a href="apps-ecommerce-order-details.html" class="fw-medium link-primary">#VZ11</a></td>
                  <td class="customer_name">Diana Kohler</td>
                  <td class="product_name">Half Sleeve T-Shirts (Blue)</td>
                  <td class="date">20 Apr,2022 <small class="text-muted">4:05 PM</small></td>
                  <td class="amount">$874</td>
                  <td class="payment">Visa</td>
                  <td class="status"><span class="badge bg-success-subtle text-success text-uppercase">Delivered</span></td>
                  <td>
                    <ul class="list-inline hstack gap-2 mb-0">
                      <li class="list-inline-item" data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-placement="top" title="View">
                        <a href="apps-ecommerce-order-details.html" class="text-primary d-inline-block">
                          <i class="ri-eye-fill fs-16"></i>
                        </a>
                      </li>
                      <li class="list-inline-item edit" data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-placement="top" title="Edit">
                        <a href="#showModal" data-bs-toggle="modal" class="text-primary d-inline-block edit-item-btn">
                          <i class="ri-pencil-fill fs-16"></i>
                        </a>
                      </li>
                      <li class="list-inline-item" data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-placement="top" title="Remove">
                        <a class="text-danger d-inline-block remove-item-btn" data-bs-toggle="modal" href="#deleteOrder">
                          <i class="ri-delete-bin-5-fill fs-16"></i>
                        </a>
                      </li>
                    </ul>
                  </td>
                </tr>
                <tr>
                  <th scope="row">
                    <div class="form-check">
                      <input class="form-check-input" type="checkbox" name="checkAll" value="option1">
                    </div>
                  </th>
                  <td class="id"><a href="apps-ecommerce-order-details.html" class="fw-medium link-primary">#VZ8</a></td>
                  <td class="customer_name">Alexis Clarke</td>
                  <td class="product_name">USB Flash Drive Personalized wi</td>
                  <td class="date">20 Apr,2022 <small class="text-muted">4:05 PM</small></td>
                  <td class="amount">$247</td>
                  <td class="payment">Paypal</td>
                  <td class="status"><span class="badge bg-success-subtle text-success text-uppercase">Delivered</span></td>
                  <td>
                    <ul class="list-inline hstack gap-2 mb-0">
                      <li class="list-inline-item" data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-placement="top" title="View">
                        <a href="apps-ecommerce-order-details.html" class="text-primary d-inline-block">
                          <i class="ri-eye-fill fs-16"></i>
                        </a>
                      </li>
                      <li class="list-inline-item edit" data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-placement="top" title="Edit">
                        <a href="#showModal" data-bs-toggle="modal" class="text-primary d-inline-block edit-item-btn">
                          <i class="ri-pencil-fill fs-16"></i>
                        </a>
                      </li>
                      <li class="list-inline-item" data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-placement="top" title="Remove">
                        <a class="text-danger d-inline-block remove-item-btn" data-bs-toggle="modal" href="#deleteOrder">
                          <i class="ri-delete-bin-5-fill fs-16"></i>
                        </a>
                      </li>
                    </ul>
                  </td>
                </tr>
              </tbody>
            </table>
            <div class="noresult" style="display: none">
              <div class="text-center">
                <lord-icon src="https://cdn.lordicon.com/msoeawqm.json" trigger="loop" colors="primary:#405189,secondary:#0ab39c" style="width:75px;height:75px"></lord-icon>
                <h5 class="mt-2">Sorry! No Result Found</h5>
                <p class="text-muted">We've searched more than 150+ Orders We did not find any orders for you search.</p>
              </div>
            </div>
          </div>



        </div>


        <!-- Modal -->
        <div class="modal fade flip" id="deleteOrder" tabindex="-1" aria-hidden="true">
          <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
              <div class="modal-body p-5 text-center">
                <lord-icon src="https://cdn.lordicon.com/gsqxdxog.json" trigger="loop" colors="primary:#405189,secondary:#f06548" style="width:90px;height:90px"></lord-icon>
                <div class="mt-4 text-center">
                  <h4>You are about to delete a order ?</h4>
                  <p class="text-muted fs-15 mb-4">Deleting your order will remove all of your information from our database.</p>
                  <div class="hstack gap-2 justify-content-center remove">
                    <button class="btn btn-link link-success fw-medium text-decoration-none" id="deleteRecord-close" data-bs-dismiss="modal"><i class="ri-close-line me-1 align-middle"></i> Close</button>
                    <button class="btn btn-danger" id="delete-record">Yes, Delete It</button>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <!--end modal -->


      </div>
    </div>

    <!-- New Employee Modal -->
    <div class="modal fade" id="add-employee-modal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-modal="true" role="dialog">
      <div class="modal-dialog modal-xl">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title">Add Employee</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-content border-0 mt-3">
            <ul class="nav nav-tabs nav-tabs-custom nav-success p-2 pb-0 bg-light" role="tablist">
              <li class="nav-item" role="presentation">
                <a class="nav-link active" id="add-personal-tab" data-bs-toggle="tab" href="#add-personal" role="tab" aria-selected="true">
                  Personal Info
                </a>
              </li>
              <li class="nav-item" role="presentation">
                <a class="nav-link" id="add-employee-tab" data-bs-toggle="tab" href="#add-employee" role="tab" aria-selected="false">
                  Employee Details
                </a>
              </li>
              <li class="nav-item" role="presentation">
                <a class="nav-link" id="add-probation-tab" data-bs-toggle="tab" href="#add-probation" role="tab" aria-selected="false">
                  Probation
                </a>
              </li>
              <li class="nav-item" role="presentation">
                <a class="nav-link" id="add-accommodation-tab" data-bs-toggle="tab" href="#add-accommodation" role="tab" aria-selected="false">
                  Accommodation
                </a>
              </li>
              <li class="nav-item" role="presentation">
                <a class="nav-link" id="add-bank-tab" data-bs-toggle="tab" href="#add-bank" role="tab" aria-selected="false">
                  Bank Account
                </a>
              </li>
              <li class="nav-item" role="presentation">
                <a class="nav-link" id="add-contact-tab" data-bs-toggle="tab" href="#add-contact" role="tab" aria-selected="false">
                  Contact Person
                </a>
              </li>
              <li class="nav-item" role="presentation">
                <a class="nav-link" id="add-card-tab" data-bs-toggle="tab" href="#add-card" role="tab" aria-selected="false">
                  Cards
                </a>
              </li>
              <li class="nav-item" role="presentation">
                <a class="nav-link" id="add-document-tab" data-bs-toggle="tab" href="#add-document" role="tab" aria-selected="false">
                  Documents
                </a>
              </li>
            </ul>
          </div>
          <div class="modal-body">
            <div class="tab-content">

              <!-- Personal Info Tab-->
              <div class="tab-pane active show" id="add-personal" role="tabpanel">
                <div class="row">
                  <div class="col-xl-2 mb-3 mb-xl-0">
                    <div class="mt-xl-4 mt-0">
                      <img :src="employeePhoto" alt="" class="rounded avatar-xl material-shadow border cursor-pointer" @click="choosePhoto" title="Choose Photo">
                      <input type="file" class="d-none" ref="empPhotoFile" accept="image/*" @change="seclectPhoto">
                    </div>
                  </div>
                  <div class="col-xl-10">
                    <div class="row">
                      <div class="col-xl-2 col-lg-3">
                        <div class="mb-3">
                          <label class="form-label">Title <span class="text-danger">*</span></label>
                          <multiselect :searchable="false" :searchStart="true" placeholder="Select" :options="lkTitleEng" v-model="personalForm.title_eng" />
                        </div>
                      </div>
                      <div class="col-xl-5 col-lg-4">
                        <div class="mb-3">
                          <label class="form-label">Name <span class="text-danger">*</span></label>
                          <input type="text" class="form-control" placeholder="Enter name in english" v-model="personalForm.name_eng">
                        </div>
                      </div>
                      <div class="col-lg-5">
                        <div class="mb-3">
                          <label class="form-label">Surname </label>
                          <input type="text" class="form-control" placeholder="Enter surname in english" v-model="personalForm.surname_eng">
                        </div>
                      </div>
                      <div class="col-xl-2 col-lg-3">
                        <div class="mb-3">
                          <label class="form-label">Title in Lao <span class="text-danger">*</span></label>
                          <multiselect :searchable="false" :searchStart="true" placeholder="Select" :options="lkTitleLao" v-model="personalForm.title_lao" />
                        </div>
                      </div>
                      <div class="col-xl-5 col-lg-4">
                        <div class="mb-3">
                          <label class="form-label">Name in Lao <span class="text-danger">*</span></label>
                          <input type="text" class="form-control" placeholder="Enter name in lao" v-model="personalForm.name_lao">
                        </div>
                      </div>
                      <div class="col-lg-5">
                        <div class="mb-3">
                          <label class="form-label">Surname in Lao</label>
                          <input type="text" class="form-control" placeholder="Enter surname in lao" v-model="personalForm.surname_lao">
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="col-lg-2">
                    <div class="mb-3">
                      <label class="form-label">Date of Birth </label>
                      <input type="date" class="form-control" placeholder="Enter surname in lao" v-model="personalForm.birthday">
                    </div>
                  </div>
                  <div class="col-lg-5">
                    <div class="mb-3">
                      <label class="form-label">Phone Number</label>
                      <input type="text" class="form-control" placeholder="Enter phone number" v-model="personalForm.phone_number">
                    </div>
                  </div>
                  <div class="col-lg-5">
                    <div class="mb-3">
                      <label class="form-label">Email Address</label>
                      <input type="text" class="form-control" placeholder="Enter email address" v-model="personalForm.email">
                    </div>
                  </div>
                  <div class="col-xl-2 col-lg-4">
                    <div class="mb-3">
                      <label class="form-label">Employee Status <span class="text-danger">*</span></label>
                      <multiselect :searchable="false" :searchStart="true" placeholder="Select status" :options="lkEmpStatus" v-model="personalForm.emp_status" />
                    </div>
                  </div>
                  <div class="col-xl-3 col-lg-4">
                    <div class="mb-3">
                      <label class="form-label">Education Level <span class="text-danger">*</span></label>
                      <multiselect :searchable="false" :searchStart="true" placeholder="Select education lavel" :options="lkEduLevel" v-model="personalForm.education_level" />
                    </div>
                  </div>
                  <div class="col-xl-7 col-lg-8">
                    <div class="mb-3">
                      <label class="form-label">Education Major</label>
                      <textarea class="form-control" rows="1" placeholder="Enter education major" v-model="personalForm.education_major"></textarea>
                    </div>
                  </div>
                  <div class="col-xl-12">
                    <div class="mb-3">
                      <label class="form-label">Experience </label>
                      <textarea class="form-control" rows="1" placeholder="Enter work experience" v-model="personalForm.experience"></textarea>
                    </div>
                  </div>

                  <div class="col-xl-3 col-lg-6">
                    <div class="mb-3">
                      <label class="form-label">Country <span class="text-danger">*</span></label>
                      <multiselect :searchable="true" :searchStart="true" placeholder="Select country" :options="lkCountry" v-model="personalForm.country" />
                    </div>
                  </div>
                  <div class="col-xl-3 col-lg-6">
                    <div class="mb-3">
                      <label class="form-label">Province <span class="text-danger">*</span></label>
                      <multiselect :searchable="true" :searchStart="true" placeholder="Select province" :options="lkProvince" v-model="personalForm.province" />
                    </div>
                  </div>
                  <div class="col-xl-3 col-lg-6">
                    <div class="mb-3">
                      <label class="form-label">District <span class="text-danger">*</span></label>
                      <multiselect :searchable="true" :searchStart="true" placeholder="Select district" :options="lkDistrict" v-model="personalForm.district" />
                    </div>
                  </div>
                  <div class="col-xl-3 col-lg-6">
                    <div class="mb-3">
                      <label class="form-label">Village </label>
                      <multiselect :searchable="true" :searchStart="true" placeholder="Select village" :options="lkVillage" v-model="personalForm.village" />
                    </div>
                  </div>

                  <div class="col-lg-6 mb-3 mb-xl-0">
                    <label class="form-label">Home Address</label>
                    <textarea class="form-control" rows="1" placeholder="Enter home address" v-model="personalForm.home_address"></textarea>
                  </div>
                  <div class="col-lg-6">
                    <label class="form-label">Remarks</label>
                    <textarea class="form-control" rows="1" placeholder="Enter remarks" v-model="personalForm.remark"></textarea>
                  </div>
                </div>
              </div>

              <!-- Employee Details Tab -->
              <div class="tab-pane" id="add-employee" role="tabpanel">
                <div class="row">
                  <div class="col-xl-2 col-lg-4">
                    <div class="mb-3">
                      <label class="form-label">Start Date <span class="text-danger">*</span></label>
                      <input type="text" id="start-date" class="form-control cursor-pointer flatpickr-input flatpickr-single" placeholder="Enter start date" v-model="detailForm.start_date">
                    </div>
                  </div>
                  <div class="col-xl-4 col-lg-8">
                    <div class="mb-3">
                      <label class="form-label">Company <span class="text-danger">*</span></label>
                      <multiselect :searchable="false" :searchStart="true" placeholder="Select site" :options="lkCompany" v-model="detailForm.company" @select="getDept" />
                    </div>
                  </div>
                  <div class="col-xl-6 col-lg-8">
                    <div class="mb-3">
                      <label class="form-label">Position <span class="text-danger">*</span></label>
                      <multiselect :searchable="true" :searchStart="false" placeholder="Select position" :options="lkPosition" v-model="detailForm.position" />
                    </div>
                  </div>
                  <div class="col-xl-2 col-lg-4 col-6">
                    <div class="mb-3">
                      <label class="form-label">Levels <span class="text-danger">*</span></label>
                      <multiselect :searchable="false" :searchStart="true" placeholder="Select" :options="lkLevel" v-model="detailForm.levels" />
                    </div>
                  </div>
                  <div class="col-xl-2 col-lg-4 col-6">
                    <div class="mb-3">
                      <label class="form-label">Contact Type <span class="text-danger">*</span></label>
                      <multiselect :searchable="false" :searchStart="true" placeholder="Select" :options="lkContType" v-model="detailForm.contract_type" />
                    </div>
                  </div>
                  <div class="col-xl-4 col-lg-8">
                    <div class="mb-3">
                      <label class="form-label">Department <span class="text-danger">*</span></label>
                      <multiselect :searchable="true" :searchStart="false" placeholder="Select department" :options="lkDept" v-model="detailForm.department" />
                    </div>
                  </div>
                  <div class="col-xl-4 col-lg-4">
                    <div class="mb-3">
                      <label class="form-label">Division </label>
                      <multiselect :searchable="true" :searchStart="false" placeholder="Select division" :options="lkDivision" v-model="detailForm.division" />
                    </div>
                  </div>
                  <div class="col-xl-2 col-lg-4">
                    <div class="mb-3">
                      <label class="form-label">PR No </label>
                      <input type="text" class="form-control" placeholder="Enter PR number" v-model="detailForm.pr_number">
                    </div>
                  </div>
                  <div class="col-xl-2 col-lg-4 col-6">
                    <div class="mb-3">
                      <label class="form-label">Employee ID </label>
                      <input type="text" class="form-control" placeholder="Enter employee id" v-model="detailForm.employee_id">
                    </div>
                  </div>
                  <div class="col-xl-2 col-lg-4 col-6">
                    <div class="mb-3">
                      <label class="form-label">Scan ID <span class="text-danger">*</span></label>
                      <input type="text" class="form-control" placeholder="Enter scan id" v-model="detailForm.scan_id">
                    </div>
                  </div>
                  <div class="col-xl-2 col-lg-4 col-6">
                    <div class="mb-3">
                      <label class="form-label">Food ID </label>
                      <input type="text" class="form-control" placeholder="Enter food id" v-model="detailForm.food_id">
                    </div>
                  </div>
                  <div class="col-xl-2 col-lg-4 col-6">
                    <div class="mb-3">
                      <label class="form-label">Roster <span class="text-danger">*</span></label>
                      <multiselect :searchable="false" :searchStart="true" placeholder="Select roster" :options="lkRoster" v-model="detailForm.roster" />
                    </div>
                  </div>
                  <div class="col-xl-2 col-lg-4 col-6">
                    <div class="mb-3">
                      <label class="form-label">Working Hours <span class="text-danger">*</span></label>
                      <multiselect :searchable="false" :searchStart="true" placeholder="Select hours" :options="lkWorkHrs" v-model="detailForm.work_hour" />
                    </div>
                  </div>
                  <div class="col-xl-2 col-lg-4 col-6">
                    <div class="mb-3">
                      <label class="form-label">Scan/Day <span class="text-danger">*</span></label>
                      <multiselect :searchable="false" :searchStart="true" placeholder="Select scan-day" :options="lkScanDay" v-model="detailForm.scan_day" />
                    </div>
                  </div>
                  <div class="col-xl-6 col-lg-4">
                    <div class="mb-3">
                      <label class="form-label">Report To </label>
                      <input type="text" class="form-control" placeholder="Enter the person report to" v-model="detailForm.report_to">
                    </div>
                  </div>
                  <div class="col-xl-4 col-lg-4">
                    <div class="mb-3">
                      <label class="form-label">File-Docs </label>
                      <input type="file" class="form-control">
                    </div>
                  </div>
                  <div class="col-xl-12 col-lg-8">
                    <label class="form-label">Remarks</label>
                    <textarea class="form-control" rows="1" placeholder="Enter remarks" v-model="detailForm.remark"></textarea>
                  </div>
                </div>
              </div>

              <!-- Probation Tab -->
              <div class="tab-pane" id="add-probation" role="tabpanel">
                <div class="row">
                  <div class="col-xl-5 col-lg-6">
                    <div class="mb-3">
                      <label class="form-label">Probation Period <span class="text-danger">*</span></label>
                      <input type="text" id="probation-range" class="form-control flatpickr-input flatpickr-range cursor-pointer" placeholder="Emter date range" v-model="probationForm.period">
                    </div>
                  </div>
                  <div class="col-xl-3 col-lg-6">
                    <div class="mb-3">
                      <label class="form-label">Days </label>
                      <input type="text" class="form-control" placeholder="Auto fill" readonly>
                    </div>
                  </div>
                  <div class="col-xl-4 col-lg-6">
                    <div class="mb-3">
                      <label class="form-label">Probation Status <span class="text-danger">*</span></label>
                      <multiselect :searchable="false" :searchStart="true" placeholder="Select grade" :options="lkProbStatus" />
                    </div>
                  </div>
                  <div class="col-xl-8 order-lg-last order-xl-0">
                    <div class="mb-3 mb-lg-0">
                      <label class="form-label">Remarks </label>
                      <textarea class="form-control" rows="1" placeholder="Enter remarks" v-model="probationForm.remark"></textarea>
                    </div>
                  </div>
                  <div class="col-xl-4 col-lg-6">
                    <div class="mb-0">
                      <label class="form-label">File-Docs</label>
                      <input type="file" class="form-control">
                    </div>
                  </div>
                </div>
              </div>

              <!-- Accommodation Tab -->
              <div class="tab-pane" id="add-accommodation" role="tabpanel">
                <div class="row">
                  <div class="col-xl-4 col-lg-6">
                    <div class="mb-3">
                      <label class="form-label">Room Zone <span class="text-danger">*</span></label>
                      <multiselect :searchable="true" :searchStart="true" placeholder="Select room zone" :options="lkRoomZone" v-model="accomForm.room_zone" />
                    </div>
                  </div>
                  <div class="col-xl-3 col-lg-6">
                    <div class="mb-3">
                      <label class="form-label">Room Number <span class="text-danger">*</span></label>
                      <multiselect :searchable="true" :searchStart="true" placeholder="Select room number" :options="lkRoomNo" v-model="accomForm.room_number" />
                    </div>
                  </div>

                  <div class="col-xl-3">
                    <div class="mb-3">
                      <label class="form-label">Probation Period</label>
                      <input type="text" id="selectMode-3" class="form-control flatpickr-input flatpickr-range rounded-start-2 cursor-pointer" placeholder="Select date range" aria-label="Text input with dropdown button" @input="getRangeData('r')">
                    </div>
                  </div>
                  <div class="col-xl-2">
                    <div class="mb-3">
                      <label class="form-label">Days </label>
                      <input type="text" class="form-control" placeholder="Enter loading place">
                    </div>
                  </div>

                  <div class="col-12">
                    <label class="form-label">Remarks </label>
                    <textarea class="form-control" rows="1" placeholder="Enter remarks" v-model="accomForm.remark"></textarea>
                  </div>
                </div>
              </div>

              <!-- Bank Account Tab -->
              <div class="tab-pane" id="add-bank" role="tabpanel">
                <div class="row">
                  <div class="col-xl-5 col-lg-6">
                    <div class="mb-3">
                      <label class="form-label">Bank Name <span class="text-danger">*</span></label>
                      <multiselect :searchable="false" :searchStart="true" placeholder="Select bank name" :options="lkBankName" v-model="bankForm.bank_name" />
                    </div>
                  </div>
                  <div class="col-xl-7 col-lg-6">
                    <div class="mb-3">
                      <label class="form-label">Account Number <span class="text-danger">*</span></label>
                      <input type="text" class="form-control" placeholder="Enter account number" v-model="bankForm.account_number">
                    </div>
                  </div>
                  <div class="col-xl-5 col-lg-6">
                    <div class="mb-3">
                      <label class="form-label">Account Name <span class="text-danger">*</span></label>
                      <input type="text" class="form-control" placeholder="Enter account name" v-model="bankForm.account_name">
                    </div>
                  </div>
                  <div class="col-xl-3 col-lg-6">
                    <div class="mb-3">
                      <label class="form-label">Account Type <span class="text-danger">*</span></label>
                      <multiselect :searchable="false" :searchStart="true" placeholder="Select account type" :options="lkAccType" v-model="bankForm.acount_type" />
                    </div>
                  </div>
                  <div class="col-xl-4 col-lg-6">
                    <div class="mb-3">
                      <label class="form-label"> Account Status <span class="text-danger">*</span></label>
                      <multiselect :searchable="false" :searchStart="true" placeholder="Select account status" :options="lkAccStatus" v-model="bankForm.status" />
                    </div>
                  </div>

                  <div class="col-xl-8 order-lg-last order-xl-0">
                    <div class="mb-3 mb-lg-0">
                      <label class="form-label">Remarks</label>
                      <textarea class="form-control" rows="1" placeholder="Enter remarks" v-model="cardForm.remark"></textarea>
                    </div>
                  </div>
                  <div class="col-xl-4 col-lg-6">
                    <div class="mb-0">
                      <label class="form-label">File-Docs</label>
                      <input type="file" class="form-control">
                    </div>
                  </div>

                  <!-- <div class="col-xl-5 col-lg-6 order-last order-lg-0">
                    <div class="mb-0 mb-lg-3">
                      <label class="form-label">File-Docs</label>
                      <input type="file" class="form-control">
                    </div>
                  </div> -->
                  <!-- <div class="col-12">
                    <div class="mb-3 mb-lg-0">
                      <label class="form-label">Remarks</label>
                      <textarea class="form-control" rows="1" placeholder="Enter notes"></textarea>
                    </div>
                  </div> -->
                </div>
              </div>

              <!-- Contact Person Tab -->
              <div class="tab-pane" id="add-contact" role="tabpanel">
                <div class="row">
                  <div class="col-xl-4">
                    <div class="mb-3">
                      <label class="form-label">Contact Person <span class="text-danger">*</span></label>
                      <input type="text" class="form-control" placeholder="Enter contact person name" v-model="contactForm.contact_person">
                    </div>
                  </div>
                  <div class="col-xl-4 col-lg-6">
                    <div class="mb-3">
                      <label class="form-label">Phone Number <span class="text-danger">*</span></label>
                      <input type="text" class="form-control" placeholder="Enter contact phone number" v-model="contactForm.phone_number">
                    </div>
                  </div>
                  <div class="col-xl-4 col-lg-6">
                    <div class="mb-3">
                      <label class="form-label">Relationship <span class="text-danger">*</span></label>
                      <multiselect :searchable="true" :searchStart="true" placeholder="Select relationship" :options="lkRelate" v-model="contactForm.relationship" />
                    </div>
                  </div>
                  <div class="col-xl-4 col-lg-6">
                    <div class="mb-3">
                      <label class="form-label">Country </label>
                      <multiselect :searchable="true" :searchStart="true" placeholder="Select country" :options="lkCountry" v-model="contactForm.country" />
                    </div>
                  </div>
                  <div class="col-xl-4 col-lg-6">
                    <div class="mb-3">
                      <label class="form-label">Province </label>
                      <multiselect :searchable="true" :searchStart="true" placeholder="Select province" :options="lkProvince" v-model="contactForm.province" />
                    </div>
                  </div>
                  <div class="col-xl-4 col-lg-6">
                    <div class="mb-3">
                      <label class="form-label">District </label>
                      <multiselect :searchable="true" :searchStart="true" placeholder="Select district" :options="lkDistrict" v-model="contactForm.district" />
                    </div>
                  </div>
                  <div class="col-xl-4 col-lg-6">
                    <div class="mb-3">
                      <label class="form-label">Village </label>
                      <multiselect :searchable="true" :searchStart="true" placeholder="Select village" :options="lkVillage" v-model="contactForm.village" />
                    </div>
                  </div>
                  <div class="col-xl-8">
                    <label class="form-label">Remarks </label>
                    <textarea class="form-control" rows="1" placeholder="Enter remarks" v-model="contactForm.remark"></textarea>
                  </div>

                </div>
              </div>

              <!-- Personal Cards Tab -->
              <div class="tab-pane" id="add-card" role="tabpanel">
                <div class="row">
                  <div class="col-xl-4 col-lg-6">
                    <div class="mb-3">
                      <label class="form-label">Card Type <span class="text-danger">*</span></label>
                      <multiselect :searchable="false" :searchStart="true" placeholder="Select card type" :options="lkCardType" v-model="cardForm.card_type" />
                    </div>
                  </div>
                  <div class="col-xl-4 col-lg-6">
                    <div class="mb-3">
                      <label class="form-label">Card ID <span class="text-danger">*</span></label>
                      <input type="text" class="form-control" placeholder="Enter card id" v-model="cardForm.card_id">
                    </div>
                  </div>
                  <div class="col-xl-4 col-lg-6">
                    <div class="mb-3">
                      <label class="form-label">Expiry Date </label>
                      <input type="text" id="expiry-date" class="form-control flatpickr-input flatpickr-single cursor-pointer" placeholder="Eenter expiry date" v-model="cardForm.expiry_date">
                    </div>
                  </div>
                  <div class="col-xl-8 order-lg-last order-xl-0">
                    <div class="mb-3 mb-lg-0">
                      <label class="form-label">Remarks</label>
                      <textarea class="form-control" rows="1" placeholder="Enter remarks" v-model="cardForm.remark"></textarea>
                    </div>
                  </div>
                  <div class="col-xl-4 col-lg-6">
                    <div class="mb-0">
                      <label class="form-label">File-Docs</label>
                      <input type="file" class="form-control">
                    </div>
                  </div>
                </div>
              </div>

              <!-- Documents Tab -->
              <div class="tab-pane" id="add-document" role="tabpanel">
                <div class="card-header align-items-center d-flex border-0">
                  <div class="flex-shrink-0">
                    <button type="button" class="btn btn-soft-info btn-sm" @click="newAttached()"><i class="ri-upload-2-fill me-1 align-bottom"></i> Choose File</button>
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

            </div>
          </div>
          <div class="modal-footer" style="display: block;">
            <div class="hstack gap-2 justify-content-end">
              <button type="button" class="btn btn-light" data-bs-dismiss="modal">{{ $t('close-btn') }}</button>
              <button type="button" class="btn btn-success" :class="addContractDis" @click="addContract()">{{ $t('add-contract') }}</button>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Employee Detaial Add/Edit Modal -->
    <div class="modal fade" id="edit-detail-modal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-modal="true" role="dialog">
      <div class="modal-dialog modal-xl modal-dialog-centered">
        <div class="modal-content">
          <div class="modal-header bg-light p-3">
            <h5 class="modal-title">Edit Contract</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <div class="row">
              <div class="col-xl-2 col-lg-4">
                <div class="mb-3">
                  <label class="form-label">Work Site <span class="text-danger">*</span></label>
                  <multiselect :searchable="false" :searchStart="true" placeholder="Select site" :options="lkSite" v-model="detailForm.work_site" />
                </div>
              </div>
              <div class="col-xl-2 col-lg-4 col-6">
                <div class="mb-3">
                  <label class="form-label">Start Date <span class="text-danger">*</span></label>
                  <input type="text" id="start-date" class="form-control cursor-pointer flatpickr-input flatpickr-single" placeholder="Enter start date" v-model="detailForm.start_date">
                </div>
              </div>
              <div class="col-xl-2 col-lg-4 col-6">
                <div class="mb-3">
                  <label class="form-label">End Date </label>
                  <input type="text" id="end-date" class="form-control cursor-pointer flatpickr-input flatpickr-single" placeholder="Enter end date" v-model="detailForm.end_date">
                </div>
              </div>
              <div class="col-xl-3 col-lg-6">
                <div class="mb-3">
                  <label class="form-label">Employee Status <span class="text-danger">*</span></label>
                  <multiselect :searchable="true" :searchStart="true" placeholder="Select status" :options="lkEmpStatus" v-model="detailForm.emp_status" />
                </div>
              </div>
              <div class="col-xl-3 col-lg-6">
                <div class="mb-3">
                  <label class="form-label">Employee Note <span class="text-danger">*</span></label>
                  <multiselect :searchable="true" :searchStart="true" placeholder="Select note" :options="lkEmpNote" v-model="detailForm.emp_note" />
                </div>
              </div>
              <div class="col-xl-6 col-lg-8">
                <div class="mb-3">
                  <label class="form-label">Position <span class="text-danger">*</span></label>
                  <multiselect :searchable="true" :searchStart="true" placeholder="Select position" :options="lkPosition" v-model="detailForm.position" />
                </div>
              </div>
              <div class="col-xl-3 col-lg-4 col-6">
                <div class="mb-3">
                  <label class="form-label">Levels <span class="text-danger">*</span></label>
                  <multiselect :searchable="true" :searchStart="true" placeholder="Select levels" :options="lkLevels" v-model="detailForm.levels" />
                </div>
              </div>
              <div class="col-xl-3 col-lg-4 col-6">
                <div class="mb-3">
                  <label class="form-label">Contact Type <span class="text-danger">*</span></label>
                  <multiselect :searchable="true" :searchStart="true" placeholder="Select contract type" :options="lkContract" v-model="detailForm.contract_type" />
                </div>
              </div>
              <div class="col-xl-6 col-lg-8">
                <div class="mb-3">
                  <label class="form-label">Department <span class="text-danger">*</span></label>
                  <multiselect :searchable="true" :searchStart="true" placeholder="Select department" :options="lkDept" v-model="detailForm.department" />
                </div>
              </div>
              <div class="col-xl-6 col-lg-8">
                <div class="mb-3">
                  <label class="form-label">Division </label>
                  <multiselect :searchable="true" :searchStart="true" placeholder="Select division" :options="lkDivision" v-model="detailForm.division" />
                </div>
              </div>
              <div class="col-xl-2 col-lg-4">
                <div class="mb-3">
                  <label class="form-label">PR No </label>
                  <input type="text" class="form-control" placeholder="Enter PR number" v-model="detailForm.pr_number">
                </div>
              </div>
              <div class="col-xl-2 col-lg-4 col-6">
                <div class="mb-3">
                  <label class="form-label">Employee ID </label>
                  <input type="text" class="form-control" placeholder="Enter employee id" v-model="detailForm.employee_id">
                </div>
              </div>
              <div class="col-xl-2 col-lg-4 col-6">
                <div class="mb-3">
                  <label class="form-label">Scan ID <span class="text-danger">*</span></label>
                  <input type="text" class="form-control" placeholder="Enter scan id" v-model="detailForm.scan_id">
                </div>
              </div>
              <div class="col-xl-2 col-lg-4 col-6">
                <div class="mb-3">
                  <label class="form-label">Food ID </label>
                  <input type="text" class="form-control" placeholder="Enter food id" v-model="detailForm.food_id">
                </div>
              </div>
              <div class="col-xl-2 col-lg-4 col-6">
                <div class="mb-3">
                  <label class="form-label">Roster <span class="text-danger">*</span></label>
                  <multiselect :searchable="false" :searchStart="true" placeholder="Select roster" :options="lkRoster" v-model="detailForm.roster" />
                </div>
              </div>
              <div class="col-xl-2 col-lg-4 col-6">
                <div class="mb-3">
                  <label class="form-label">Working Hours <span class="text-danger">*</span></label>
                  <multiselect :searchable="false" :searchStart="true" placeholder="Select hours" :options="lkHours" v-model="detailForm.work_hour" />
                </div>
              </div>
              <div class="col-xl-2 col-lg-4 col-6">
                <div class="mb-3">
                  <label class="form-label">Scan/Day <span class="text-danger">*</span></label>
                  <multiselect :searchable="true" :searchStart="true" placeholder="Select scan-day" :options="lkScanDay" v-model="detailForm.scan_day" />
                </div>
              </div>
              <div class="col-xl-4 col-lg-6">
                <div class="mb-3">
                  <label class="form-label">Report To </label>
                  <input type="text" class="form-control" placeholder="Enter the person report to" v-model="detailForm.report_to">
                </div>
              </div>
              <div class="col-lg-6">
                <div class="mb-3">
                  <label class="form-label">File-Docs </label>
                  <input type="file" class="form-control">
                </div>
              </div>
              <div class="col-12">
                <label class="form-label">Remarks</label>
                <textarea class="form-control" rows="2" placeholder="Enter remarks" v-model="detailForm.remark"></textarea>
              </div>
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

    <!-- Probation Add/Edit Modal -->
    <div class="modal fade" id="edit-probation-modal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-modal="true" role="dialog">
      <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
          <div class="modal-header bg-light p-3">
            <h5 class="modal-title">Add/Edit Probation</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <div class="row">
              <div class="col-lg-6">
                <div class="mb-3">
                  <label class="form-label">Probation Period <span class="text-danger">*</span></label>
                  <input type="text" id="probation-range" class="form-control flatpickr-input flatpickr-range cursor-pointer" placeholder="Emter date range" v-model="probationForm.period">
                </div>
              </div>
              <div class="col-lg-2">
                <div class="mb-3">
                  <label class="form-label">Days </label>
                  <input type="text" class="form-control" placeholder="Auto fill" readonly>
                </div>
              </div>
              <div class="col-lg-4">
                <div class="mb-3">
                  <label class="form-label">Probation Status <span class="text-danger">*</span></label>
                  <multiselect :searchable="false" :searchStart="true" placeholder="Select grade" :options="lkProbStatus" />
                </div>
              </div>
              <div class="col-lg-8">
                <div class="mb-3">
                  <label class="form-label">Remarks </label>
                  <textarea class="form-control" rows="1" placeholder="Enter remarks" v-model="probationForm.remark"></textarea>
                </div>
              </div>
              <div class="col-lg-4">
                <div class="mb-3">
                  <label class="form-label">File-Docs</label>
                  <input type="file" class="form-control">
                </div>
              </div>

            </div>
          </div>
          <div class="modal-footer" style="display: block;">
            <div class="hstack gap-2 justify-content-end">
              <button type="button" class="btn btn-light" data-bs-dismiss="modal">{{ $t('close-btn') }}</button>
              <button type="button" id="contract-upd" class="btn btn-success" :class="editContractDis" @click="updContract()">{{ $t('save-btn') }}</button>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Accommodation Add/Edit Modal -->
    <div class="modal fade" id="edit-accommodation-modal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-modal="true" role="dialog">
      <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
          <div class="modal-header bg-light p-3">
            <h5 class="modal-title">Add/Edit Accommodation</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <div class="row">
              <div class="col-lg-6">
                <div class="mb-3">
                  <label class="form-label">Room Zone <span class="text-danger">*</span></label>
                  <multiselect :searchable="true" :searchStart="true" placeholder="Select room zone" :options="lkRoomZone" v-model="accomForm.room_zone" />
                </div>
              </div>
              <div class="col-lg-6">
                <div class="mb-3">
                  <label class="form-label">Room Number <span class="text-danger">*</span></label>
                  <multiselect :searchable="true" :searchStart="true" placeholder="Select room number" :options="lkRoomNo" v-model="accomForm.room_number" />
                </div>
              </div>

              <div class="col-xl-3">
                <div class="mb-3">
                  <label class="form-label">Probation Period</label>
                  <input type="text" id="selectMode-3" class="form-control flatpickr-input flatpickr-range rounded-start-2 cursor-pointer" placeholder="Select date range" aria-label="Text input with dropdown button" @input="getRangeData('r')">
                </div>
              </div>
              <div class="col-xl-2">
                <div class="mb-3">
                  <label class="form-label">Days </label>
                  <input type="text" class="form-control" placeholder="Enter loading place">
                </div>
              </div>

              <div class="col-12">
                <label class="form-label">Remarks </label>
                <textarea class="form-control" rows="2" placeholder="Enter remarks" v-model="accomForm.remark"></textarea>
              </div>
            </div>
          </div>
          <div class="modal-footer" style="display: block;">
            <div class="hstack gap-2 justify-content-end">
              <button type="button" class="btn btn-light" data-bs-dismiss="modal">{{ $t('close-btn') }}</button>
              <button type="button" id="contract-upd" class="btn btn-success" :class="editContractDis" @click="updContract()">{{ $t('save-btn') }}</button>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Bank Account Add/Edit Modal -->
    <div class="modal fade" id="edit-bankaccount-modal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-modal="true" role="dialog">
      <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
          <div class="modal-header bg-light p-3">
            <h5 class="modal-title">Add/Edit Bank Account</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <div class="row">
              <div class="col-lg-6">
                <div class="mb-3">
                  <label class="form-label">Bank Name <span class="text-danger">*</span></label>
                  <multiselect :searchable="false" :searchStart="true" placeholder="Select bank name" :options="lkBankName" v-model="bankForm.bank_name" />
                </div>
              </div>
              <div class="col-lg-6">
                <div class="mb-3">
                  <label class="form-label">Account Number <span class="text-danger">*</span></label>
                  <input type="text" class="form-control" placeholder="Enter account number" v-model="bankForm.account_number">
                </div>
              </div>
              <div class="col-lg-6">
                <div class="mb-3">
                  <label class="form-label">Account Name <span class="text-danger">*</span></label>
                  <input type="text" class="form-control" placeholder="Enter account name" v-model="bankForm.account_name">
                </div>
              </div>
              <div class="col-lg-6">
                <div class="mb-3">
                  <label class="form-label">Account Type <span class="text-danger">*</span></label>
                  <multiselect :searchable="false" :searchStart="true" placeholder="Select account type" :options="lkAccType" v-model="bankForm.acount_type" />
                </div>
              </div>
              <div class="col-lg-6">
                <div class="mb-3">
                  <label class="form-label"> Account Status <span class="text-danger">*</span></label>
                  <multiselect :searchable="false" :searchStart="true" placeholder="Select account status" :options="lkAccStatus" v-model="bankForm.status" />
                </div>
              </div>
              <div class="col-lg-6">
                <div class="mb-3">
                  <label class="form-label">File-Docs</label>
                  <input type="file" class="form-control">
                </div>
              </div>
              <div class="col-12">
                <label class="form-label">Remarks</label>
                <textarea class="form-control" rows="2" placeholder="Enter notes"></textarea>
              </div>
            </div>
          </div>
          <div class="modal-footer" style="display: block;">
            <div class="hstack gap-2 justify-content-end">
              <button type="button" class="btn btn-light" data-bs-dismiss="modal">{{ $t('close-btn') }}</button>
              <button type="button" id="contract-upd" class="btn btn-success" :class="editContractDis" @click="updContract()">{{ $t('save-btn') }}</button>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Contact Person Add/Edit Modal -->
    <div class="modal fade" id="edit-contactperson-modal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-modal="true" role="dialog">
      <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
          <div class="modal-header bg-light p-3">
            <h5 class="modal-title">Add/Edit Contact Person</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <div class="row">
              <div class="col-lg-6">
                <div class="mb-3">
                  <label class="form-label">Contact Person <span class="text-danger">*</span></label>
                  <input type="text" class="form-control" placeholder="Enter contact person name" v-model="contactForm.contact_person">
                </div>
              </div>
              <div class="col-lg-6">
                <div class="mb-3">
                  <label class="form-label">Phone Number <span class="text-danger">*</span></label>
                  <input type="text" class="form-control" placeholder="Enter contact phone number" v-model="contactForm.phone_number">
                </div>
              </div>
              <div class="col-lg-6">
                <div class="mb-3">
                  <label class="form-label">Relationship <span class="text-danger">*</span></label>
                  <multiselect :searchable="true" :searchStart="true" placeholder="Select relationship" :options="lkRelate" v-model="contactForm.relationship" />
                </div>
              </div>
              <div class="col-lg-6">
                <div class="mb-3">
                  <label class="form-label">Country </label>
                  <multiselect :searchable="true" :searchStart="true" placeholder="Select country" :options="lkCountry" v-model="contactForm.country" />
                </div>
              </div>
              <div class="col-lg-6">
                <div class="mb-3">
                  <label class="form-label">Province </label>
                  <multiselect :searchable="true" :searchStart="true" placeholder="Select province" :options="lkProvince" v-model="contactForm.province" />
                </div>
              </div>
              <div class="col-lg-6">
                <div class="mb-3">
                  <label class="form-label">District </label>
                  <multiselect :searchable="true" :searchStart="true" placeholder="Select district" :options="lkDistrict" v-model="contactForm.district" />
                </div>
              </div>
              <div class="col-lg-6">
                <div class="mb-3 mb-lg-0">
                  <label class="form-label">Village </label>
                  <multiselect :searchable="true" :searchStart="true" placeholder="Select village" :options="lkVillage" v-model="contactForm.village" />
                </div>
              </div>
              <div class="col-lg-6">
                <label class="form-label">Remarks </label>
                <textarea class="form-control" rows="1" placeholder="Enter remarks" v-model="contactForm.remark"></textarea>
              </div>
            </div>
          </div>
          <div class="modal-footer" style="display: block;">
            <div class="hstack gap-2 justify-content-end">
              <button type="button" class="btn btn-light" data-bs-dismiss="modal">{{ $t('close-btn') }}</button>
              <button type="button" id="contract-upd" class="btn btn-success" :class="editContractDis" @click="updContract()">{{ $t('save-btn') }}</button>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Personal Card Add/Edit Modal -->
    <div class="modal fade" id="edit-personalcard-modal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-modal="true" role="dialog">
      <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
          <div class="modal-header bg-light p-3">
            <h5 class="modal-title">Add/Edit Personal Card</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <div class="row">
              <div class="col-lg-6">
                <div class="mb-3">
                  <label class="form-label">Card Type <span class="text-danger">*</span></label>
                  <multiselect :searchable="false" :searchStart="true" placeholder="Select card type" :options="lkCardType" v-model="cardForm.card_type" />
                </div>
              </div>
              <div class="col-lg-6">
                <div class="mb-3">
                  <label class="form-label">Card ID <span class="text-danger">*</span></label>
                  <input type="text" class="form-control" placeholder="Enter card id" v-model="cardForm.card_id">
                </div>
              </div>
              <div class="col-lg-6">
                <div class="mb-3">
                  <label class="form-label">Expiry Date </label>
                  <input type="text" id="expiry-date" class="form-control flatpickr-input flatpickr-single cursor-pointer" placeholder="Eenter expiry date" v-model="cardForm.expiry_date">
                </div>
              </div>
              <div class="col-lg-6">
                <div class="mb-3">
                  <label class="form-label">File-Docs</label>
                  <input type="file" class="form-control">
                </div>
              </div>
              <div class="col-12">
                <label class="form-label">Remarks</label>
                <textarea class="form-control" rows="2" placeholder="Enter remarks" v-model="cardForm.remark"></textarea>
              </div>
            </div>
          </div>
          <div class="modal-footer" style="display: block;">
            <div class="hstack gap-2 justify-content-end">
              <button type="button" class="btn btn-light" data-bs-dismiss="modal">{{ $t('close-btn') }}</button>
              <button type="button" id="contract-upd" class="btn btn-success" :class="editContractDis" @click="updContract()">{{ $t('save-btn') }}</button>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Warning Add/Edit Modal -->
    <div class="modal fade" id="edit-warning-modal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-modal="true" role="dialog">
      <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
          <div class="modal-header bg-light p-3">
            <h5 class="modal-title">Add/Edit Warning</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <div class="row">
              <div class="col-lg-6">
                <div class="mb-3">
                  <label class="form-label">Warning Date <span class="text-danger">*</span></label>
                  <input type="text" id="expiry-date" class="form-control flatpickr-input flatpickr-single cursor-pointer" placeholder="Eenter expiry date" v-model="warningForm.warning_date">
                </div>
              </div>
              <div class="col-lg-6">
                <div class="mb-3">
                  <label class="form-label">File-Docs</label>
                  <input type="file" class="form-control">
                </div>
              </div>
              <div class="col-12">
                <label class="form-label">Remarks</label>
                <textarea class="form-control" rows="2" placeholder="Enter remarks" v-model="warningForm.remark"></textarea>
              </div>
            </div>
          </div>
          <div class="modal-footer" style="display: block;">
            <div class="hstack gap-2 justify-content-end">
              <button type="button" class="btn btn-light" data-bs-dismiss="modal">{{ $t('close-btn') }}</button>
              <button type="button" id="contract-upd" class="btn btn-success" :class="editContractDis" @click="updContract()">{{ $t('save-btn') }}</button>
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
import { useToastr } from '../toastr.js';
import { useStore } from '../stores/store.js';
import { useAuthStore } from '../stores/auth.js';
const toastr = useToastr();

export default {
  name: 'XpplAppEmpName',
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
        minWidth: 100,
        cellClassRules: { 'pointer': 'true' },
        menuTabs: ['filterMenuTab', 'generalMenuTab', 'columnsMenuTab']
      },


      personalForm: { emp_id: '', title_eng: null, title_lao: null, name_eng: '', surname_eng: '', name_lao: '', surname_lao: '', phone_number: '', birthday: '', email: '', country: null, province: null, district: null, village: null, home_address: '', education_level: null, education_major: '', experience: '', remark: '', photo: '' },
      detailForm: { id: '', company: null, pr_number: '', start_date: '', end_date: '', emp_status: null, emp_note: null, position: null, levels: null, department: null, division: null, employee_id: '', scan_id: '', food_id: '', roster: null, work_hour: '', scan_day: null, report_to: '', contract_type: '', remark: '', file_name: '' },
      probationForm: { id: '', period: '', days: '', status: '', remark: '', file_name: '' },
      accomForm: { id: '', room_zone: null, room_number: '', remark: '' },
      bankForm: { id: '', bank_name: null, account_number: '', account_name: '', acount_type: null, remark: '', file_name: '' },
      warningForm: { id: '', warning_date: '', remark: '', file_name: '' },
      contactForm: { id: '', contact_person: '', phone_number: '', relationship: null, country: null, province: null, district: null, village: null },
      cardForm: { id: '', card_type: null, card_id: '', expiry_date: '', remark: '', file_name: '' },
      documentForm: { id: '', file_name: '', file_descr: '' },


      auth: [],
      employeeData: [],

      code: [],
      department: [],

      lkCountry: [],
      lkCompany: [],
      lkDept: [],
      lkAccStatus: [],
      lkAccType: [],
      lkBankName: [],
      lkCardType: [],
      lkContType: [],
      lkEduLevel: [],
      lkEmpDetial: [],
      lkEmpStatus: [],
      lkLevel: [],
      lkPosition: [],
      lkProbStatus: [],
      lkRelate: [],
      lkRoster: [],
      lkScanDay: [],
      lkTitleEng: [],
      lkTitleLao: [],
      lkWorkHrs: [],
      lkWorkSite: [],
      lkDivision: [],





      search: '',
      viewMode: 'main',
      loading: false,

      employeePhoto: window.location.origin + '/assets/images/users/avatar-1.jpg',


    };
  },

  mounted() {
    flatpickr('.flatpickr-single', {
      altInput: true,
      altFormat: 'd-m-Y'
    });
  },

  methods: {
    async onLoad() {
      const submenu = 'M02S01';
      const authorise = await axios.get(`api/auth/auth-action?submenu=${submenu}`, { headers: { Authorization: 'Bearer ' + this.authStore.getToken } });
      this.auth = authorise.data[0];

      const lkCode = await axios.get('api/employee/codes', { headers: { Authorization: 'Bearer ' + this.authStore.getToken } });
      this.code = lkCode.data;


      const category = [
        { cate: 'Account Status', lk: 'lkAccStatus', lb: 'descr_eng' },
        { cate: 'Account Type', lk: 'lkAccType', lb: 'descr_eng' },
        { cate: 'Bank Name', lk: 'lkBankName', lb: 'descr_eng' },
        { cate: 'Card Type', lk: 'lkCardType', lb: 'code' },
        { cate: 'Contract Type', lk: 'lkContType', lb: 'code' },
        { cate: 'Education Level', lk: 'lkEduLevel', lb: 'code' },
        { cate: 'Employee Detail', lk: 'lkEmpDetial', lb: 'code' },
        { cate: 'Employee Status', lk: 'lkEmpStatus', lb: 'code' },
        { cate: 'Levels', lk: 'lkLevel', lb: 'code' },
        { cate: 'Position', lk: 'lkPosition', lb: 'code' },
        { cate: 'Probation Status', lk: 'lkProbStatus', lb: 'code' },
        { cate: 'Relationship', lk: 'lkRelate', lb: 'code' },
        { cate: 'Roster', lk: 'lkRoster', lb: 'code' },
        { cate: 'Scan per Day', lk: 'lkScanDay', lb: 'code' },
        { cate: 'Title Eng', lk: 'lkTitleEng', lb: 'code' },
        { cate: 'Title Lao', lk: 'lkTitleLao', lb: 'code' },
        { cate: 'Working Hours', lk: 'lkWorkHrs', lb: 'descr_eng' },
        { cate: 'Working Site', lk: 'lkWorkSite', lb: 'descr_eng' },
        { cate: 'Company', lk: 'lkCompany', lb: 'descr_eng' },
        { cate: 'Division', lk: 'lkDivision', lb: 'code' },
        { cate: 'Country', lk: 'lkCountry', lb: 'code' },
      ];

      for (let j = 0; j < category.length; j++) {
        let cateName = category[j].cate;
        let lkName = category[j].lk;
        let labelCol = category[j].lb;

        let item = this.code.filter((e) => e.category == [cateName] && e.active == 1);

        for (let i = 0; i < item.length; i++) {
          this[lkName].push({
            value: item[i].code,
            label: item[i][labelCol]
          });
        };
      };




    },

    getDept() {
      this.lkDept = [];
      this.detailForm.department = null;
      const depts = this.department.filter((e) => e.company_code == this.detailForm.company);
      depts.forEach((e) => {
        this.lkDept.push({
          value: e.dept_eng,
          label: e.dept_eng
        });
      });
    },

    newEmployee() {
      if (this.auth.new == 0) {
        toastr.warning("You're not authorized to add!");
      } else {
        this.mode = 'add';

        const tab = document.querySelectorAll('[data-bs-toggle="tab"]');
        Array.from(tab).forEach(function (e) {
          e.classList.remove('active')
        });
        document.getElementById('add-personal-tab').classList.add('active');

        const cont = document.querySelectorAll('.tab-pane');
        Array.from(cont).forEach(function (e) {
          e.classList.remove('active', 'show')
        });
        document.getElementById('add-personal').classList.add('active', 'show');





        // this.codeForm.code_id = '';
        // this.codeForm.code = '';
        // this.codeForm.descr_eng = '';
        // this.codeForm.descr_lao = '';
        // this.codeForm.active = 1;
        $('#add-employee-modal').modal('show');
      }
    },

    test() {
      // $('#edit-detail-modal').modal('show');
      // $('#edit-probation-modal').modal('show');
      // $('#edit-accommodation-modal').modal('show');
      // $('#edit-bankaccount-modal').modal('show');
      // $('#edit-contactperson-modal').modal('show');
      // $('#edit-personalcard-modal').modal('show');
      $('#edit-warning-modal').modal('show');
    },

    choosePhoto() {
      this.$refs.empPhotoFile.click()
    },

    seclectPhoto(event) {
      this.personalForm.photo = event.target.files[0];
      if (event.target.files[0]) {
        let reader = new FileReader();
        reader.readAsDataURL(this.personalForm.photo);
        reader.addEventListener("load", function () {
          this.employeePhoto = reader.result;
        }.bind(this), false);
      }
    },





  },

  created() {
    this.onLoad();
  }
};
</script>