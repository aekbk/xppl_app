<template>
  <div>
    <div class="row">
      <div class="col">
        <div class="h-100">
          <div class="row mb-3 pb-1">
            <div class="col-12">
              <div class="d-flex align-items-lg-center flex-lg-row flex-column">
                <div class="flex-grow-1">
                  <h4 class="fs-16 mb-1">Xekong Power Plant Co,.Ltd</h4>
                  <p class="text-muted mb-0">Mine production dashboards updated on <span
                      class="text-danger fw-semibold">{{ store.fullMDY(selectDate) }}</span> (Geology's data)</p>
                </div>
                <div class="mt-3 mt-lg-0">

                  <div class="row g-2 mb-0 align-items-center">
                    <div class="col-sm-auto">
                      <div class="input-group">
                        <input type="text" id="select-date"
                          class="form-control flatpickr-input flatpickr-single rounded-start-2 cursor-pointer"
                          placeholder="Select date" v-model="selectDate" @input="onSelectDate()">
                        <button type="button" class="btn btn-soft-info"
                          style="border-color: var(--vz-input-border-custom);" @click="refresh()"><i
                            class="ri-refresh-line align-middle"></i></button>
                      </div>
                    </div>
                    <!-- <div class="col-auto">
                      <button type="button" class="btn btn-soft-info btn-icon waves-effect material-shadow-none waves-light layout-rightside-btn" @click="refresh()"><i class="ri-refresh-line"></i></button>
                    </div> -->
                  </div>
                </div>
              </div>
            </div>
          </div>

          <div v-if="loading">
            <loading />
          </div>
          <div v-else>
            <div class="row">
              <div class="col-xxl-6">
                <div class="d-flex flex-column h-100">
                  <div class="row">

                    <div class="col-md-6">
                      <div class="card card-animate">
                        <div class="card-body">
                          <div class="d-flex align-items-center">
                            <div class="flex-grow-1 overflow-hidden">
                              <p class="text-uppercase fw-semibold text-muted text-truncate mb-0">Today</p>
                            </div>
                            <!-- <div class="flex-shrink-0" v-if="(dash1Data[0].ton && dash1Data[1].ton) > 0">
                              <h5 class="text-success fs-14 mb-0" v-if="dash1Data[0].ton - dash1Data[1].ton > 0">+{{ store.numDec(((dash1Data[0].ton - dash1Data[1].ton) * 100) / dash1Data[1].ton) }} %</h5>
                              <h5 class="text-danger fs-14 mb-0" v-else>{{ store.numDec(((dash1Data[0].ton - dash1Data[1].ton) * 100) / dash1Data[1].ton) }} %</h5>
                            </div> -->
                          </div>
                          <div class="d-flex align-items-end justify-content-between mt-4">
                            <div>
                              <h4 class="fs-22 fw-semibold ff-secondary mb-0">{{ store.numInt(dash1Data[0].trip) }}<span
                                  class="text-muted fw-normal fs-13 ms-1">trip</span></h4>
                              <h4 class="fs-22 fw-semibold ff-secondary mb-0">{{ store.numInt(dash1Data[0].ton) }}<span
                                  class="text-muted fw-normal fs-13 ms-1">ton</span></h4>
                            </div>
                            <div class="avatar-sm flex-shrink-0" v-if="dash1Data[0].ton - dash1Data[1].ton > 0">
                              <span class="avatar-title bg-success-subtle rounded fs-3">
                                <i class="bx bx-up-arrow-circle text-success"></i>
                              </span>
                            </div>
                            <div class="avatar-sm flex-shrink-0" v-else>
                              <span class="avatar-title bg-warning-subtle rounded fs-3">
                                <i class="bx bx-down-arrow-circle text-warning"></i>
                              </span>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>

                    <div class="col-md-6">
                      <div class="card card-animate">
                        <div class="card-body">
                          <div class="d-flex align-items-center">
                            <div class="flex-grow-1 overflow-hidden">
                              <p class="text-uppercase fw-semibold text-muted text-truncate mb-0">MTD</p>
                            </div>
                            <!-- <div class="flex-shrink-0" v-if="(dash1Data[2].ton && dash1Data[3].ton) > 0">
                              <h5 class="text-success fs-14 mb-0" v-if="dash1Data[2].ton - dash1Data[3].ton > 0">+{{ store.numDec(((dash1Data[2].ton - dash1Data[3].ton) * 100) / dash1Data[3].ton) }} %</h5>
                              <h5 class="text-danger fs-14 mb-0" v-else>{{ store.numDec(((dash1Data[2].ton - dash1Data[3].ton) * 100) / dash1Data[3].ton) }} %</h5>
                            </div> -->
                          </div>
                          <div class="d-flex align-items-end justify-content-between mt-4">
                            <div>
                              <h4 class="fs-22 fw-semibold ff-secondary mb-0">{{ store.numInt(dash1Data[2].trip) }}<span
                                  class="text-muted fw-normal fs-13 ms-1">trip</span></h4>
                              <h4 class="fs-22 fw-semibold ff-secondary mb-0">{{ store.numInt(dash1Data[2].ton) }}<span
                                  class="text-muted fw-normal fs-13 ms-1">ton</span></h4>
                            </div>
                            <div class="avatar-sm flex-shrink-0" v-if="dash1Data[2].ton - dash1Data[3].ton > 0">
                              <span class="avatar-title bg-success-subtle rounded fs-3">
                                <i class="bx bx-up-arrow-circle text-success"></i>
                              </span>
                            </div>
                            <div class="avatar-sm flex-shrink-0" v-else>
                              <span class="avatar-title bg-warning-subtle rounded fs-3">
                                <i class="bx bx-down-arrow-circle text-warning"></i>
                              </span>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>

                  <div class="row">
                    <div class="col-lg-6">
                      <div class="card card-animate">
                        <div class="card-body">
                          <div class="d-flex align-items-center">
                            <div class="flex-grow-1 overflow-hidden">
                              <p class="text-uppercase fw-semibold text-muted text-truncate mb-0">YTD</p>
                            </div>
                            <!-- <div class="flex-shrink-0" v-if="(dash1Data[4].ton && dash1Data[5].ton) > 0">
                              <h5 class="text-success fs-14 mb-0" v-if="dash1Data[4].ton - dash1Data[5].ton > 0">+{{ store.numDec(((dash1Data[4].ton - dash1Data[5].ton) * 100) / dash1Data[5].ton) }} %</h5>
                              <h5 class="text-danger fs-14 mb-0" v-else>{{ store.numDec(((dash1Data[4].ton - dash1Data[5].ton) * 100) / dash1Data[5].ton) }} %</h5>
                            </div> -->
                          </div>
                          <div class="d-flex align-items-end justify-content-between mt-4">
                            <div>
                              <h4 class="fs-22 fw-semibold ff-secondary mb-0">{{ store.numInt(dash1Data[4].trip) }}<span
                                  class="text-muted fw-normal fs-13 ms-1">trip</span></h4>
                              <h4 class="fs-22 fw-semibold ff-secondary mb-0">{{ store.numInt(dash1Data[4].ton) }}<span
                                  class="text-muted fw-normal fs-13 ms-1">ton</span></h4>
                            </div>
                            <div class="avatar-sm flex-shrink-0" v-if="dash1Data[4].ton - dash1Data[5].ton > 0">
                              <span class="avatar-title bg-success-subtle rounded fs-3">
                                <i class="bx bx-up-arrow-circle text-success"></i>
                              </span>
                            </div>
                            <div class="avatar-sm flex-shrink-0" v-else>
                              <span class="avatar-title bg-warning-subtle rounded fs-3">
                                <i class="bx bx-down-arrow-circle text-warning"></i>
                              </span>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>

                    <div class="col-lg-6">
                      <div class="card card-animate">
                        <div class="card-body">
                          <div class="d-flex align-items-center">
                            <div class="flex-grow-1 overflow-hidden">
                              <p class="text-uppercase fw-semibold text-muted text-truncate mb-0">Target</p>
                            </div>
                            <!-- <div class="flex-shrink-0">
                              <h5 class="text-success fs-14 mb-0">{{ store.yyyy(selectDate) }}</h5>
                            </div> -->
                          </div>
                          <div class="d-flex align-items-end justify-content-between align-items-baseline">
                            <h4 class="fs-22 fw-semibold ff-secondary mb-0">15,000,000<span
                                class="text-muted fw-normal fs-13 ms-1">ton</span></h4>
                          </div>

                          <div class="d-flex align-items-center" style="margin-top: 4.5px">
                            <div class="flex-grow-1 overflow-hidden">
                              <p class="text-uppercase fw-semibold text-muted text-truncate mb-0">YTD Mined</p>
                            </div>
                          </div>
                          <div class="d-flex align-items-end justify-content-between align-items-baseline">
                            <h4 class="fs-22 fw-semibold ff-secondary mb-0">{{ store.numInt(dash1Data[4].ton) }}<span
                                class="text-muted fw-normal fs-13 ms-1">ton</span></h4>
                            <p class="mb-0 text-truncate ms-1 text-secondary fw-medium">{{ store.numDec(dash1Data[4].ton
                              * 100 / 15000000) }}%</p>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>

              <div class="col-xxl-6">
                <div class="row h-100">
                  <div class="col-lg-6">
                    <div class="card card-height-100 card-animate">
                      <div class="card-body">
                        <div class="d-flex align-items-center">
                          <div class="flex-grow-1 overflow-hidden">
                            <p class="text-uppercase fw-semibold text-muted text-truncate mb-0">Pakxai Pit</p>
                          </div>
                          <div class="flex-shrink-0">
                            <h5 class="text-success fs-14 mb-0 text-danger">{{ store.ddmmyyyy(selectDate) }}</h5>
                          </div>
                        </div>
                        <div class="d-flex justify-content-between flex-wrap gap-2 ms-auto mt-4">
                          <div class="d-flex justify-content-between align-items-baseline">
                            <h4 class="fs-22 fw-semibold ff-secondary mb-0">{{ store.numInt(dash1Data[6].trip) }}</h4>
                            <p class="mb-0 text-truncate text-muted ms-1">trip</p>
                          </div>
                          <div class="d-flex justify-content-between align-items-baseline">
                            <h4 class="fs-22 fw-semibold ff-secondary mb-0">{{ store.numInt(dash1Data[6].ton) }}</h4>
                            <p class="mb-0 text-truncate text-muted ms-1">ton</p>
                          </div>
                        </div>
                        <div class="table-responsive table-card mt-2">
                          <table class="table table-borderless table-sm table-centered align-middle table-nowrap mb-1">
                            <thead class="text-muted border-dashed border border-start-0 border-end-0 bg-light-subtle">
                              <tr>
                                <th>Range</th>
                                <th>Cate.</th>
                                <th class="text-end">Trip</th>
                                <th class="text-end">Ton</th>
                                <th class="text-end">GCV</th>
                                <th class="text-end">Ash</th>
                              </tr>
                            </thead>
                            <tbody class="border-0">
                              <tr v-for="item in dash2Data" :key="item.grade_range">
                                <td>{{ item.grade_range }}</td>
                                <td>{{ item.coal_category }}</td>
                                <td class="text-end">{{ store.numInt(item.trip) }}</td>
                                <td class="text-end">{{ store.numInt(item.ton) }}</td>
                                <td class="text-end">{{ store.numInt(item.gcv_ar) }}</td>
                                <td class="text-end">{{ store.numDec(item.ash_ad) }}</td>
                              </tr>
                            </tbody>
                          </table>
                        </div>
                      </div>
                    </div>
                  </div>

                  <div class="col-lg-6">
                    <div class="card card-height-100 card-animate">
                      <div class="card-body">
                        <div class="d-flex align-items-center">
                          <div class="flex-grow-1 overflow-hidden">
                            <p class="text-uppercase fw-semibold text-muted text-truncate mb-0">Kaleum Area</p>
                          </div>
                          <div class="flex-shrink-0">
                            <h5 class="text-success fs-14 mb-0 text-danger">{{ store.ddmmyyyy(selectDate) }}</h5>
                          </div>
                        </div>
                        <div class="d-flex justify-content-between flex-wrap gap-2 ms-auto mt-4">
                          <div class="d-flex justify-content-between align-items-baseline">
                            <h4 class="fs-22 fw-semibold ff-secondary mb-0">{{ store.numInt(dash1Data[7].trip) }}</h4>
                            <p class="mb-0 text-truncate text-muted ms-1">trip</p>
                          </div>
                          <div class="d-flex justify-content-between align-items-baseline">
                            <h4 class="fs-22 fw-semibold ff-secondary mb-0">{{ store.numInt(dash1Data[7].ton) }}</h4>
                            <p class="mb-0 text-truncate text-muted ms-1">ton</p>
                          </div>
                        </div>
                        <div class="table-responsive table-card mt-2">
                          <table class="table table-borderless table-sm table-centered align-middle table-nowrap mb-1">
                            <thead class="text-muted border-dashed border border-start-0 border-end-0 bg-light-subtle">
                              <tr>
                                <th>Range</th>
                                <th>Cate.</th>
                                <th class="text-end">Trip</th>
                                <th class="text-end">Ton</th>
                                <th class="text-end">GCV</th>
                                <th class="text-end">Ash</th>
                              </tr>
                            </thead>
                            <tbody class="border-0">
                              <tr v-for="item in dash3Data" :key="item.grade_range">
                                <td>{{ item.grade_range }}</td>
                                <td>{{ item.coal_category }}</td>
                                <td class="text-end">{{ store.numInt(item.trip) }}</td>
                                <td class="text-end">{{ store.numInt(item.ton) }}</td>
                                <td class="text-end">{{ store.numInt(item.gcv_ar) }}</td>
                                <td class="text-end">{{ store.numDec(item.ash_ad) }}</td>
                              </tr>
                            </tbody>
                          </table>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>

              <div class="col-xl-12">
                <div class="card">
                  <div class="card-header border-bottom">
                    <div class="row g-2 align-items-center email-topbar-link">
                      <div class="col-xl-6 col-lg-6">
                        <h5 class="card-title mb-0 flex-grow-1 overflow-hidden">Coal mined on {{
                          store.fullMonY(selectMonth) }} (ton)</h5>
                      </div>
                      <div class="col-xxl-2 col-xl-3 col-lg-3 col-md-4 col-sm-6 ms-auto text-end">
                        <input type="month" class="form-control form-control-sm" v-model="selectMonth"
                          @input="getDash7">
                      </div>
                      <button class="btn btn-ghost-secondary btn-icon btn-sm material-shadow-none active"
                        @click="exportData4" title="Export to excel file.">
                        <i class="ri-file-excel-2-line align-bottom fs-15"></i>
                      </button>
                    </div>
                  </div>
                  <div class="card-body">
                    <div class="table-responsive table-card">
                      <table
                        class="table table-hover table-borderless table-centered align-middle table-nowrap mb-0 table-sm">
                        <thead class="text-muted bg-light-subtle" style="height: 32px;">
                          <tr class="text-end">
                            <th class="text-start">Grade Range</th>
                            <th class="text-start">Category</th>
                            <th class="text-start">Stockpile</th>
                            <th v-for="(col, colInx) in dateColheader" :key="colInx" class="text-end"
                              style="width: 100px; "
                              :style="headDate(col.colId) == cdate ? 'color: red; font-weight: bold;' : ''">{{
                              col.colName }}</th>
                            <th style="width: 100px;">Total</th>
                          </tr>
                        </thead>
                        <tbody v-if="dash7DataTotal.total" class="border-0">
                          <tr class="border-bottom border-bottom-dashed text-secondary text-end fw-medium border-top">
                            <td class="text-start">Padou</td>
                            <td></td>
                            <td></td>
                            <td v-for="(col, colInx) in dateColheader" :key="colInx">{{
                              store.numInt(dash7PadouTotal[col.colId]) }}</td>
                            <td class="fw-medium">{{ store.numInt(dash7PadouTotal.total) }}</td>
                          </tr>
                        </tbody>
                        <tbody v-if="dash7PadouTotal.total" class="border-0">
                          <tr v-for="(item, index) in dash7Padou" :key="index" class="text-end">
                            <td class="text-start">{{ item.grade_range }}</td>
                            <td class="text-start">{{ item.coal_category }}</td>
                            <td class="text-start">{{ item.stockpile }}</td>
                            <td v-for="(col, colInx) in dateColheader" :key="colInx">{{ store.numInt(item[col.colId]) }}
                            </td>
                            <td class="fw-medium">{{ store.numInt(item.total) }}</td>
                          </tr>
                        </tbody>
                        <tbody v-if="dash7DataTotal.total" class="border-0">
                          <tr class="border-top border-bottom border-bottom-dashed text-secondary text-end fw-medium">
                            <td class="text-start">Pakxai</td>
                            <td></td>
                            <td></td>
                            <td v-for="(col, colInx) in dateColheader" :key="colInx">{{
                              store.numInt(dash7PakxaiTotal[col.colId]) }}</td>
                            <td class="fw-medium">{{ store.numInt(dash7PakxaiTotal.total) }}</td>
                          </tr>
                        </tbody>
                        <tbody v-if="dash7PakxaiTotal.total" class="border-0">
                          <tr v-for="(item, index) in dash7Pakxai" :key="index" class="text-end">
                            <td class="text-start">{{ item.grade_range }}</td>
                            <td class="text-start">{{ item.coal_category }}</td>
                            <td class="text-start">{{ item.stockpile }}</td>
                            <td v-for="(col, colInx) in dateColheader" :key="colInx">{{ store.numInt(item[col.colId]) }}
                            </td>
                            <td class="fw-medium">{{ store.numInt(item.total) }}</td>
                          </tr>
                        </tbody>
                        <tbody v-if="dash7DataTotal.total" class="border-0">
                          <tr class="border-top border-bottom border-bottom-dashed text-secondary text-end fw-medium">
                            <td class="text-start">Kaleum</td>
                            <td></td>
                            <td></td>
                            <td v-for="(col, colInx) in dateColheader" :key="colInx">{{
                              store.numInt(dash7KaleumTotal[col.colId]) }}</td>
                            <td class="fw-medium">{{ store.numInt(dash7KaleumTotal.total) }}</td>
                          </tr>
                        </tbody>
                        <tbody v-if="dash7KaleumTotal.total" class="border-0">
                          <tr v-for="(item, index) in dash7Kaleum" :key="index" class="text-end">
                            <td class="text-start">{{ item.grade_range }}</td>
                            <td class="text-start">{{ item.coal_category }}</td>
                            <td class="text-start">{{ item.stockpile }}</td>
                            <td v-for="(col, colInx) in dateColheader" :key="colInx">{{ store.numInt(item[col.colId]) }}
                            </td>
                            <td class="fw-medium">{{ store.numInt(item.total) }}</td>
                          </tr>
                        </tbody>
                        <tbody v-if="dash7DataTotal.total" class="border-0">
                          <tr class="border-top text-secondary fw-semibold text-end">
                            <td class="text-start">Grand Total</td>
                            <td></td>
                            <td></td>
                            <td v-for="(col, colInx) in dateColheader" :key="colInx">{{
                              store.numInt(dash7DataTotal[col.colId]) }}</td>
                            <td>{{ store.numInt(dash7DataTotal.total) }}</td>
                          </tr>
                        </tbody>
                      </table>
                    </div>
                  </div>
                </div>
              </div>

              <div class="col-xl-12">
                <div class="card">
                  <div class="card-header align-items-center d-flex email-topbar-link">
                    <h4 class="card-title mb-0 flex-grow-1 overflow-hidden">Coal mined by month in {{ selectYear }}
                      (ton)</h4>
                    <div class="flex-shrink-0">
                      <div class="dropdown card-header-dropdown">
                        <a class="text-reset dropdown-btn" href="#" data-bs-toggle="dropdown" aria-haspopup="true"
                          aria-expanded="false">
                          <span class="text-muted">{{ selectYear }}<i class="mdi mdi-chevron-down ms-1"></i></span>
                        </a>
                        <div class="dropdown-menu dropdown-menu-end overflow-auto" style="max-height: 300px">
                          <a class="dropdown-item" href="#" v-for="(item, index) in lkYear" :key="index"
                            @click="getDashboard4(item.value)">
                            {{ item.value }}
                          </a>
                        </div>
                      </div>
                    </div>
                    <button class="btn btn-ghost-secondary btn-icon btn-sm material-shadow-none" @click="exportData1"
                      title="Export to excel file.">
                      <i class="ri-file-excel-2-line align-bottom fs-15"></i>
                    </button>
                  </div>
                  <div class="card-body">
                    <div class="table-responsive table-card">
                      <table
                        class="table table-hover table-borderless table-centered align-middle table-nowrap mb-0 table-sm">
                        <thead class="text-muted bg-light-subtle" style="height: 32px;">
                          <tr class="text-end">
                            <th class="text-start">Grade Range</th>
                            <th class="text-start">Category</th>
                            <th class="text-start">Stockpile</th>
                            <th style="width: 250px;">Jan</th>
                            <th style="width: 250px;">Feb</th>
                            <th style="width: 250px;">Mar</th>
                            <th style="width: 250px;">Apr</th>
                            <th style="width: 250px;">May</th>
                            <th style="width: 250px;">Jun</th>
                            <th style="width: 250px;">Jul</th>
                            <th style="width: 250px;">Aug</th>
                            <th style="width: 250px;">Sep</th>
                            <th style="width: 250px;">Oct</th>
                            <th style="width: 250px;">Nov</th>
                            <th style="width: 250px;">Dec</th>
                            <th style="width: 250px;">Total</th>
                          </tr>
                        </thead>
                        <tbody v-if="dash4DataTotal.total" class="border-0">
                          <tr class="border-top border-bottom border-bottom-dashed text-secondary text-end fw-medium">
                            <td class="text-start">Padou</td>
                            <td></td>
                            <td></td>
                            <td>{{ store.numInt(dash4PadouTotal.m1) }}</td>
                            <td>{{ store.numInt(dash4PadouTotal.m2) }}</td>
                            <td>{{ store.numInt(dash4PadouTotal.m3) }}</td>
                            <td>{{ store.numInt(dash4PadouTotal.m4) }}</td>
                            <td>{{ store.numInt(dash4PadouTotal.m5) }}</td>
                            <td>{{ store.numInt(dash4PadouTotal.m6) }}</td>
                            <td>{{ store.numInt(dash4PadouTotal.m7) }}</td>
                            <td>{{ store.numInt(dash4PadouTotal.m8) }}</td>
                            <td>{{ store.numInt(dash4PadouTotal.m9) }}</td>
                            <td>{{ store.numInt(dash4PadouTotal.m10) }}</td>
                            <td>{{ store.numInt(dash4PadouTotal.m11) }}</td>
                            <td>{{ store.numInt(dash4PadouTotal.m12) }}</td>
                            <td class="fw-medium">{{ store.numInt(dash4PadouTotal.total) }}</td>
                          </tr>
                        </tbody>
                        <tbody v-if="dash4PadouTotal.total">
                          <tr v-for="(item, index) in dash4Padou" :key="index" class="text-end">
                            <td class="text-start">{{ item.grade_range }}</td>
                            <td class="text-start">{{ item.coal_category }}</td>
                            <td class="text-start">{{ item.stockpile }}</td>
                            <td>{{ store.numInt(item.m1) }}</td>
                            <td>{{ store.numInt(item.m2) }}</td>
                            <td>{{ store.numInt(item.m3) }}</td>
                            <td>{{ store.numInt(item.m4) }}</td>
                            <td>{{ store.numInt(item.m5) }}</td>
                            <td>{{ store.numInt(item.m6) }}</td>
                            <td>{{ store.numInt(item.m7) }}</td>
                            <td>{{ store.numInt(item.m8) }}</td>
                            <td>{{ store.numInt(item.m9) }}</td>
                            <td>{{ store.numInt(item.m10) }}</td>
                            <td>{{ store.numInt(item.m11) }}</td>
                            <td>{{ store.numInt(item.m12) }}</td>
                            <td class="fw-medium">{{ store.numInt(item.total) }}</td>
                          </tr>
                        </tbody>
                        <tbody v-if="dash4DataTotal.total" class="border-0">
                          <tr class="border-top border-bottom border-bottom-dashed text-secondary text-end fw-medium">
                            <td class="text-start">Pakxai</td>
                            <td></td>
                            <td></td>
                            <td>{{ store.numInt(dash4PakxaiTotal.m1) }}</td>
                            <td>{{ store.numInt(dash4PakxaiTotal.m2) }}</td>
                            <td>{{ store.numInt(dash4PakxaiTotal.m3) }}</td>
                            <td>{{ store.numInt(dash4PakxaiTotal.m4) }}</td>
                            <td>{{ store.numInt(dash4PakxaiTotal.m5) }}</td>
                            <td>{{ store.numInt(dash4PakxaiTotal.m6) }}</td>
                            <td>{{ store.numInt(dash4PakxaiTotal.m7) }}</td>
                            <td>{{ store.numInt(dash4PakxaiTotal.m8) }}</td>
                            <td>{{ store.numInt(dash4PakxaiTotal.m9) }}</td>
                            <td>{{ store.numInt(dash4PakxaiTotal.m10) }}</td>
                            <td>{{ store.numInt(dash4PakxaiTotal.m11) }}</td>
                            <td>{{ store.numInt(dash4PakxaiTotal.m12) }}</td>
                            <td class="fw-medium">{{ store.numInt(dash4PakxaiTotal.total) }}</td>
                          </tr>
                        </tbody>
                        <tbody v-if="dash4PakxaiTotal.total" class="border-0">
                          <tr v-for="(item, index) in dash4Pakxai" :key="index" class="text-end">
                            <td class="text-start">{{ item.grade_range }}</td>
                            <td class="text-start">{{ item.coal_category }}</td>
                            <td class="text-start">{{ item.stockpile }}</td>
                            <td>{{ store.numInt(item.m1) }}</td>
                            <td>{{ store.numInt(item.m2) }}</td>
                            <td>{{ store.numInt(item.m3) }}</td>
                            <td>{{ store.numInt(item.m4) }}</td>
                            <td>{{ store.numInt(item.m5) }}</td>
                            <td>{{ store.numInt(item.m6) }}</td>
                            <td>{{ store.numInt(item.m7) }}</td>
                            <td>{{ store.numInt(item.m8) }}</td>
                            <td>{{ store.numInt(item.m9) }}</td>
                            <td>{{ store.numInt(item.m10) }}</td>
                            <td>{{ store.numInt(item.m11) }}</td>
                            <td>{{ store.numInt(item.m12) }}</td>
                            <td class="fw-medium">{{ store.numInt(item.total) }}</td>
                          </tr>
                        </tbody>
                        <tbody v-if="dash4DataTotal.total" class="border-0">
                          <tr class="border-top border-bottom border-bottom-dashed text-secondary text-end fw-medium">
                            <td class="text-start">Kaleum</td>
                            <td></td>
                            <td></td>
                            <td>{{ store.numInt(dash4KaleumTotal.m1) }}</td>
                            <td>{{ store.numInt(dash4KaleumTotal.m2) }}</td>
                            <td>{{ store.numInt(dash4KaleumTotal.m3) }}</td>
                            <td>{{ store.numInt(dash4KaleumTotal.m4) }}</td>
                            <td>{{ store.numInt(dash4KaleumTotal.m5) }}</td>
                            <td>{{ store.numInt(dash4KaleumTotal.m6) }}</td>
                            <td>{{ store.numInt(dash4KaleumTotal.m7) }}</td>
                            <td>{{ store.numInt(dash4KaleumTotal.m8) }}</td>
                            <td>{{ store.numInt(dash4KaleumTotal.m9) }}</td>
                            <td>{{ store.numInt(dash4KaleumTotal.m10) }}</td>
                            <td>{{ store.numInt(dash4KaleumTotal.m11) }}</td>
                            <td>{{ store.numInt(dash4KaleumTotal.m12) }}</td>
                            <td class="fw-medium">{{ store.numInt(dash4KaleumTotal.total) }}</td>
                          </tr>
                        </tbody>
                        <tbody v-if="dash4KaleumTotal.total" class="border-0">
                          <tr v-for="(item, index) in dash4Kaleum" :key="index" class="text-end">
                            <td class="text-start">{{ item.grade_range }}</td>
                            <td class="text-start">{{ item.coal_category }}</td>
                            <td class="text-start">{{ item.stockpile }}</td>
                            <td>{{ store.numInt(item.m1) }}</td>
                            <td>{{ store.numInt(item.m2) }}</td>
                            <td>{{ store.numInt(item.m3) }}</td>
                            <td>{{ store.numInt(item.m4) }}</td>
                            <td>{{ store.numInt(item.m5) }}</td>
                            <td>{{ store.numInt(item.m6) }}</td>
                            <td>{{ store.numInt(item.m7) }}</td>
                            <td>{{ store.numInt(item.m8) }}</td>
                            <td>{{ store.numInt(item.m9) }}</td>
                            <td>{{ store.numInt(item.m10) }}</td>
                            <td>{{ store.numInt(item.m11) }}</td>
                            <td>{{ store.numInt(item.m12) }}</td>
                            <td class="fw-medium">{{ store.numInt(item.total) }}</td>
                          </tr>
                        </tbody>
                        <tbody v-if="dash4DataTotal.total" class="border-0">
                          <tr class="border-top text-secondary fw-semibold text-end">
                            <td class="text-start">Grand Total</td>
                            <td></td>
                            <td></td>
                            <td>{{ store.numInt(dash4DataTotal.m1) }}</td>
                            <td>{{ store.numInt(dash4DataTotal.m2) }}</td>
                            <td>{{ store.numInt(dash4DataTotal.m3) }}</td>
                            <td>{{ store.numInt(dash4DataTotal.m4) }}</td>
                            <td>{{ store.numInt(dash4DataTotal.m5) }}</td>
                            <td>{{ store.numInt(dash4DataTotal.m6) }}</td>
                            <td>{{ store.numInt(dash4DataTotal.m7) }}</td>
                            <td>{{ store.numInt(dash4DataTotal.m8) }}</td>
                            <td>{{ store.numInt(dash4DataTotal.m9) }}</td>
                            <td>{{ store.numInt(dash4DataTotal.m10) }}</td>
                            <td>{{ store.numInt(dash4DataTotal.m11) }}</td>
                            <td>{{ store.numInt(dash4DataTotal.m12) }}</td>
                            <td>{{ store.numInt(dash4DataTotal.total) }}</td>
                          </tr>
                        </tbody>
                      </table>
                    </div>
                  </div>
                </div>
              </div>

              <div class="col-xl-12">
                <div class="card">
                  <div class="card-header align-items-center d-flex email-topbar-link">
                    <h4 class="card-title mb-0 flex-grow-1">Statistic on coal mined by area from 2013 (ton)</h4>
                    <button class="btn btn-ghost-secondary btn-icon btn-sm material-shadow-none" @click="exportData2"
                      title="Export to excel file.">
                      <i class="ri-file-excel-2-line align-bottom fs-15"></i>
                    </button>
                  </div>
                  <div class="card-body">
                    <div class="table-responsive table-card">
                      <table
                        class="table table-hover table-borderless table-centered align-middle table-nowrap mb-0 table-sm">
                        <thead class="text-muted bg-light-subtle" style="height: 32px;">
                          <tr class="text-end">
                            <th class="text-start">Area</th>
                            <th style="width: 250px;">2013</th>
                            <th style="width: 250px;">2014</th>
                            <th style="width: 250px;">2015</th>
                            <th style="width: 250px;">2016</th>
                            <th style="width: 250px;">2017</th>
                            <th style="width: 250px;">2018</th>
                            <th style="width: 250px;">2019</th>
                            <th style="width: 250px;">2020</th>
                            <th style="width: 250px;">2021</th>
                            <th style="width: 250px;">2022</th>
                            <th style="width: 250px;">2023</th>
                            <th style="width: 250px;">2024</th>
                            <th style="width: 250px;">Total</th>
                          </tr>
                        </thead>
                        <tbody>
                          <tr v-for="(item, index) in dash5Filter" :key="index" class="text-end">
                            <td class="text-start">{{ item.area }}</td>
                            <td>{{ store.numInt(item.y2013) }}</td>
                            <td>{{ store.numInt(item.y2014) }}</td>
                            <td>{{ store.numInt(item.y2015) }}</td>
                            <td>{{ store.numInt(item.y2016) }}</td>
                            <td>{{ store.numInt(item.y2017) }}</td>
                            <td>{{ store.numInt(item.y2018) }}</td>
                            <td>{{ store.numInt(item.y2019) }}</td>
                            <td>{{ store.numInt(item.y2020) }}</td>
                            <td>{{ store.numInt(item.y2021) }}</td>
                            <td>{{ store.numInt(item.y2022) }}</td>
                            <td>{{ store.numInt(item.y2023) }}</td>
                            <td>{{ store.numInt(item.y2024) }}</td>
                            <td class="fw-medium">{{ store.numInt(item.total) }}</td>
                          </tr>
                          <tr class="border-top fw-semibold text-end">
                            <td class="text-start">Grand Total</td>
                            <td>{{ store.numInt(dash5Total.y2013) }}</td>
                            <td>{{ store.numInt(dash5Total.y2014) }}</td>
                            <td>{{ store.numInt(dash5Total.y2015) }}</td>
                            <td>{{ store.numInt(dash5Total.y2016) }}</td>
                            <td>{{ store.numInt(dash5Total.y2017) }}</td>
                            <td>{{ store.numInt(dash5Total.y2018) }}</td>
                            <td>{{ store.numInt(dash5Total.y2019) }}</td>
                            <td>{{ store.numInt(dash5Total.y2020) }}</td>
                            <td>{{ store.numInt(dash5Total.y2021) }}</td>
                            <td>{{ store.numInt(dash5Total.y2022) }}</td>
                            <td>{{ store.numInt(dash5Total.y2023) }}</td>
                            <td>{{ store.numInt(dash5Total.y2024) }}</td>
                            <td>{{ store.numInt(dash5Total.total) }}</td>
                          </tr>
                        </tbody>
                      </table>
                    </div>
                  </div>
                </div>
              </div>

              <div class="col-xl-12">
                <div class="card">
                  <div class="card-header align-items-center d-flex email-topbar-link">
                    <h4 class="card-title mb-0 flex-grow-1">Statistics on coal mined by grade from 2013 (ton)</h4>
                    <button class="btn btn-ghost-secondary btn-icon btn-sm material-shadow-none" @click="exportData3"
                      title="Export to excel file.">
                      <i class="ri-file-excel-2-line align-bottom fs-15"></i>
                    </button>
                  </div>
                  <div class="card-body">
                    <div class="table-responsive table-card">
                      <table
                        class="table table-hover table-borderless table-centered align-middle table-nowrap mb-0 table-sm">
                        <thead class="text-muted bg-light-subtle" style="height: 32px;">
                          <tr class="text-end">
                            <th class="text-start">Grade Range</th>
                            <th class="text-start">Category</th>
                            <th style="width: 250px;">2013</th>
                            <th style="width: 250px;">2014</th>
                            <th style="width: 250px;">2015</th>
                            <th style="width: 250px;">2016</th>
                            <th style="width: 250px;">2017</th>
                            <th style="width: 250px;">2018</th>
                            <th style="width: 250px;">2019</th>
                            <th style="width: 250px;">2020</th>
                            <th style="width: 250px;">2021</th>
                            <th style="width: 250px;">2022</th>
                            <th style="width: 250px;">2023</th>
                            <th style="width: 250px;">2024</th>
                            <th style="width: 250px;">Total</th>
                          </tr>
                        </thead>
                        <tbody>
                          <tr v-for="(item, index) in dash6Filter" :key="index"
                            class="text-end border-bottom border-bottom-dashed">
                            <td class="text-start">{{ item.grade_range }}</td>
                            <td class="text-start">{{ item.coal_category }}</td>
                            <td>{{ store.numInt(item.y2013) }}</td>
                            <td>{{ store.numInt(item.y2014) }}</td>
                            <td>{{ store.numInt(item.y2015) }}</td>
                            <td>{{ store.numInt(item.y2016) }}</td>
                            <td>{{ store.numInt(item.y2017) }}</td>
                            <td>{{ store.numInt(item.y2018) }}</td>
                            <td>{{ store.numInt(item.y2019) }}</td>
                            <td>{{ store.numInt(item.y2020) }}</td>
                            <td>{{ store.numInt(item.y2021) }}</td>
                            <td>{{ store.numInt(item.y2022) }}</td>
                            <td>{{ store.numInt(item.y2023) }}</td>
                            <td>{{ store.numInt(item.y2024) }}</td>
                            <td class="fw-medium">{{ store.numInt(item.total) }}</td>
                          </tr>
                          <tr class="border-top fw-semibold text-end">
                            <td class="text-start">Grand Total</td>
                            <td></td>
                            <td>{{ store.numInt(dash6Total.y2013) }}</td>
                            <td>{{ store.numInt(dash6Total.y2014) }}</td>
                            <td>{{ store.numInt(dash6Total.y2015) }}</td>
                            <td>{{ store.numInt(dash6Total.y2016) }}</td>
                            <td>{{ store.numInt(dash6Total.y2017) }}</td>
                            <td>{{ store.numInt(dash6Total.y2018) }}</td>
                            <td>{{ store.numInt(dash6Total.y2019) }}</td>
                            <td>{{ store.numInt(dash6Total.y2020) }}</td>
                            <td>{{ store.numInt(dash6Total.y2021) }}</td>
                            <td>{{ store.numInt(dash6Total.y2022) }}</td>
                            <td>{{ store.numInt(dash6Total.y2023) }}</td>
                            <td>{{ store.numInt(dash6Total.y2024) }}</td>
                            <td>{{ store.numInt(dash6Total.total) }}</td>
                          </tr>
                        </tbody>
                      </table>
                    </div>
                  </div>
                </div>
              </div>


              <!-- Export table -->
              <table
                class="table table-hover table-borderless table-centered align-middle table-nowrap mb-0 table-sm d-none"
                id="export1">
                <thead class="text-muted bg-light-subtle" style="height: 32px;">
                  <tr class="text-end">
                    <th class="text-start">Grade Range</th>
                    <th class="text-start">Category</th>
                    <th class="text-start">Stockpile</th>
                    <th style="width: 250px;">Jan</th>
                    <th style="width: 250px;">Feb</th>
                    <th style="width: 250px;">Mar</th>
                    <th style="width: 250px;">Apr</th>
                    <th style="width: 250px;">May</th>
                    <th style="width: 250px;">Jun</th>
                    <th style="width: 250px;">Jul</th>
                    <th style="width: 250px;">Aug</th>
                    <th style="width: 250px;">Sep</th>
                    <th style="width: 250px;">Oct</th>
                    <th style="width: 250px;">Nov</th>
                    <th style="width: 250px;">Dec</th>
                    <th style="width: 250px;">Total</th>
                  </tr>
                </thead>
                <tbody>
                  <tr class="border-bottom border-bottom-dashed text-secondary text-end fw-medium">
                    <td class="text-start">
                      Padou
                    </td>
                    <td></td>
                    <td></td>
                    <td>{{ dash4PadouTotal.m1 }}</td>
                    <td>{{ dash4PadouTotal.m2 }}</td>
                    <td>{{ dash4PadouTotal.m3 }}</td>
                    <td>{{ dash4PadouTotal.m4 }}</td>
                    <td>{{ dash4PadouTotal.m5 }}</td>
                    <td>{{ dash4PadouTotal.m6 }}</td>
                    <td>{{ dash4PadouTotal.m7 }}</td>
                    <td>{{ dash4PadouTotal.m8 }}</td>
                    <td>{{ dash4PadouTotal.m9 }}</td>
                    <td>{{ dash4PadouTotal.m10 }}</td>
                    <td>{{ dash4PadouTotal.m11 }}</td>
                    <td>{{ dash4PadouTotal.m12 }}</td>
                    <td>{{ dash4PadouTotal.total }}</td>
                  </tr>
                </tbody>
                <tbody v-if="dash4PadouTotal.total">
                  <tr v-for="(item, index) in dash4Padou" :key="index" class="text-end">
                    <td class="text-start">{{ item.grade_range }}</td>
                    <td class="text-start">{{ item.coal_category }}</td>
                    <td class="text-start">{{ item.stockpile }}</td>
                    <td>{{ item.m1 }}</td>
                    <td>{{ item.m2 }}</td>
                    <td>{{ item.m3 }}</td>
                    <td>{{ item.m4 }}</td>
                    <td>{{ item.m5 }}</td>
                    <td>{{ item.m6 }}</td>
                    <td>{{ item.m7 }}</td>
                    <td>{{ item.m8 }}</td>
                    <td>{{ item.m9 }}</td>
                    <td>{{ item.m10 }}</td>
                    <td>{{ item.m11 }}</td>
                    <td>{{ item.m12 }}</td>
                    <td>{{ item.total }}</td>
                  </tr>
                </tbody>
                <tbody>
                  <tr class="border-top border-bottom border-bottom-dashed text-secondary text-end fw-medium">
                    <td class="text-start">
                      Pakxai
                    </td>
                    <td></td>
                    <td></td>
                    <td>{{ dash4PakxaiTotal.m1 }}</td>
                    <td>{{ dash4PakxaiTotal.m2 }}</td>
                    <td>{{ dash4PakxaiTotal.m3 }}</td>
                    <td>{{ dash4PakxaiTotal.m4 }}</td>
                    <td>{{ dash4PakxaiTotal.m5 }}</td>
                    <td>{{ dash4PakxaiTotal.m6 }}</td>
                    <td>{{ dash4PakxaiTotal.m7 }}</td>
                    <td>{{ dash4PakxaiTotal.m8 }}</td>
                    <td>{{ dash4PakxaiTotal.m9 }}</td>
                    <td>{{ dash4PakxaiTotal.m10 }}</td>
                    <td>{{ dash4PakxaiTotal.m11 }}</td>
                    <td>{{ dash4PakxaiTotal.m12 }}</td>
                    <td>{{ dash4PakxaiTotal.total }}</td>
                  </tr>
                </tbody>
                <tbody v-if="dash4PakxaiTotal.total">
                  <tr v-for="(item, index) in dash4Pakxai" :key="index" class="text-end">
                    <td class="text-start">{{ item.grade_range }}</td>
                    <td class="text-start">{{ item.coal_category }}</td>
                    <td class="text-start">{{ item.stockpile }}</td>
                    <td>{{ item.m1 }}</td>
                    <td>{{ item.m2 }}</td>
                    <td>{{ item.m3 }}</td>
                    <td>{{ item.m4 }}</td>
                    <td>{{ item.m5 }}</td>
                    <td>{{ item.m6 }}</td>
                    <td>{{ item.m7 }}</td>
                    <td>{{ item.m8 }}</td>
                    <td>{{ item.m9 }}</td>
                    <td>{{ item.m10 }}</td>
                    <td>{{ item.m11 }}</td>
                    <td>{{ item.m12 }}</td>
                    <td>{{ item.total }}</td>
                  </tr>
                </tbody>
                <tbody>
                  <tr class="border-top border-bottom border-bottom-dashed text-secondary text-end fw-medium">
                    <td class="text-start">
                      Kaleum
                    </td>
                    <td></td>
                    <td></td>
                    <td>{{ dash4KaleumTotal.m1 }}</td>
                    <td>{{ dash4KaleumTotal.m2 }}</td>
                    <td>{{ dash4KaleumTotal.m3 }}</td>
                    <td>{{ dash4KaleumTotal.m4 }}</td>
                    <td>{{ dash4KaleumTotal.m5 }}</td>
                    <td>{{ dash4KaleumTotal.m6 }}</td>
                    <td>{{ dash4KaleumTotal.m7 }}</td>
                    <td>{{ dash4KaleumTotal.m8 }}</td>
                    <td>{{ dash4KaleumTotal.m9 }}</td>
                    <td>{{ dash4KaleumTotal.m10 }}</td>
                    <td>{{ dash4KaleumTotal.m11 }}</td>
                    <td>{{ dash4KaleumTotal.m12 }}</td>
                    <td>{{ dash4KaleumTotal.total }}</td>
                  </tr>
                </tbody>
                <tbody v-if="dash4KaleumTotal.total">
                  <tr v-for="(item, index) in dash4Kaleum" :key="index" class="text-end">
                    <td class="text-start">{{ item.grade_range }}</td>
                    <td class="text-start">{{ item.coal_category }}</td>
                    <td class="text-start">{{ item.stockpile }}</td>
                    <td>{{ item.m1 }}</td>
                    <td>{{ item.m2 }}</td>
                    <td>{{ item.m3 }}</td>
                    <td>{{ item.m4 }}</td>
                    <td>{{ item.m5 }}</td>
                    <td>{{ item.m6 }}</td>
                    <td>{{ item.m7 }}</td>
                    <td>{{ item.m8 }}</td>
                    <td>{{ item.m9 }}</td>
                    <td>{{ item.m10 }}</td>
                    <td>{{ item.m11 }}</td>
                    <td>{{ item.m12 }}</td>
                    <td>{{ item.total }}</td>
                  </tr>
                </tbody>
                <tbody v-if="dash4DataTotal.total">
                  <tr class="border-top text-secondary fw-semibold text-end">
                    <td class="text-start">
                      Grand Total
                    </td>
                    <td></td>
                    <td></td>
                    <td>{{ dash4DataTotal.m1 }}</td>
                    <td>{{ dash4DataTotal.m2 }}</td>
                    <td>{{ dash4DataTotal.m3 }}</td>
                    <td>{{ dash4DataTotal.m4 }}</td>
                    <td>{{ dash4DataTotal.m5 }}</td>
                    <td>{{ dash4DataTotal.m6 }}</td>
                    <td>{{ dash4DataTotal.m7 }}</td>
                    <td>{{ dash4DataTotal.m8 }}</td>
                    <td>{{ dash4DataTotal.m9 }}</td>
                    <td>{{ dash4DataTotal.m10 }}</td>
                    <td>{{ dash4DataTotal.m11 }}</td>
                    <td>{{ dash4DataTotal.m12 }}</td>
                    <td>{{ dash4DataTotal.total }}</td>
                  </tr>
                </tbody>
              </table>

              <table
                class="table table-hover table-borderless table-centered align-middle table-nowrap mb-0 table-sm d-none"
                id="export2">
                <thead class="text-muted bg-light-subtle" style="height: 32px;">
                  <tr class="text-end">
                    <th class="text-start">Area</th>
                    <th style="width: 250px;">2013</th>
                    <th style="width: 250px;">2014</th>
                    <th style="width: 250px;">2015</th>
                    <th style="width: 250px;">2016</th>
                    <th style="width: 250px;">2017</th>
                    <th style="width: 250px;">2018</th>
                    <th style="width: 250px;">2019</th>
                    <th style="width: 250px;">2020</th>
                    <th style="width: 250px;">2021</th>
                    <th style="width: 250px;">2022</th>
                    <th style="width: 250px;">2023</th>
                    <th style="width: 250px;">2024</th>
                    <th style="width: 250px;">Total</th>
                  </tr>
                </thead>
                <tbody>
                  <tr v-for="(item, index) in dash5Filter" :key="index" class="text-end">
                    <td class="text-start">{{ item.area }}</td>
                    <td>{{ item.y2013 }}</td>
                    <td>{{ item.y2014 }}</td>
                    <td>{{ item.y2015 }}</td>
                    <td>{{ item.y2016 }}</td>
                    <td>{{ item.y2017 }}</td>
                    <td>{{ item.y2018 }}</td>
                    <td>{{ item.y2019 }}</td>
                    <td>{{ item.y2020 }}</td>
                    <td>{{ item.y2021 }}</td>
                    <td>{{ item.y2022 }}</td>
                    <td>{{ item.y2023 }}</td>
                    <td>{{ item.y2024 }}</td>
                    <td class="fw-medium">{{ item.total }}</td>
                  </tr>
                  <tr class="border-top fw-semibold text-end">
                    <td class="text-start">Grand Total</td>
                    <td>{{ dash5Total.y2013 }}</td>
                    <td>{{ dash5Total.y2014 }}</td>
                    <td>{{ dash5Total.y2015 }}</td>
                    <td>{{ dash5Total.y2016 }}</td>
                    <td>{{ dash5Total.y2017 }}</td>
                    <td>{{ dash5Total.y2018 }}</td>
                    <td>{{ dash5Total.y2019 }}</td>
                    <td>{{ dash5Total.y2020 }}</td>
                    <td>{{ dash5Total.y2021 }}</td>
                    <td>{{ dash5Total.y2022 }}</td>
                    <td>{{ dash5Total.y2023 }}</td>
                    <td>{{ dash5Total.y2024 }}</td>
                    <td>{{ dash5Total.total }}</td>
                  </tr>
                </tbody>
              </table>

              <table
                class="table table-hover table-borderless table-centered align-middle table-nowrap mb-0 table-sm d-none"
                id="export3">
                <thead class="text-muted bg-light-subtle" style="height: 32px;">
                  <tr class="text-end">
                    <th class="text-start">Grade Range</th>
                    <th class="text-start">Category</th>
                    <th style="width: 250px;">2013</th>
                    <th style="width: 250px;">2014</th>
                    <th style="width: 250px;">2015</th>
                    <th style="width: 250px;">2016</th>
                    <th style="width: 250px;">2017</th>
                    <th style="width: 250px;">2018</th>
                    <th style="width: 250px;">2019</th>
                    <th style="width: 250px;">2020</th>
                    <th style="width: 250px;">2021</th>
                    <th style="width: 250px;">2022</th>
                    <th style="width: 250px;">2023</th>
                    <th style="width: 250px;">2024</th>
                    <th style="width: 250px;">Total</th>
                  </tr>
                </thead>
                <tbody>
                  <tr v-for="(item, index) in dash6Filter" :key="index"
                    class="text-end border-bottom border-bottom-dashed">
                    <td class="text-start">{{ item.grade_range }}</td>
                    <td class="text-start">{{ item.coal_category }}</td>
                    <td>{{ item.y2013 }}</td>
                    <td>{{ item.y2014 }}</td>
                    <td>{{ item.y2015 }}</td>
                    <td>{{ item.y2016 }}</td>
                    <td>{{ item.y2017 }}</td>
                    <td>{{ item.y2018 }}</td>
                    <td>{{ item.y2019 }}</td>
                    <td>{{ item.y2020 }}</td>
                    <td>{{ item.y2021 }}</td>
                    <td>{{ item.y2022 }}</td>
                    <td>{{ item.y2023 }}</td>
                    <td>{{ item.y2024 }}</td>
                    <td class="fw-medium">{{ item.total }}</td>
                  </tr>
                  <tr class="border-top fw-semibold text-end">
                    <td class="text-start">Grand Total</td>
                    <td></td>
                    <td>{{ dash6Total.y2013 }}</td>
                    <td>{{ dash6Total.y2014 }}</td>
                    <td>{{ dash6Total.y2015 }}</td>
                    <td>{{ dash6Total.y2016 }}</td>
                    <td>{{ dash6Total.y2017 }}</td>
                    <td>{{ dash6Total.y2018 }}</td>
                    <td>{{ dash6Total.y2019 }}</td>
                    <td>{{ dash6Total.y2020 }}</td>
                    <td>{{ dash6Total.y2021 }}</td>
                    <td>{{ dash6Total.y2022 }}</td>
                    <td>{{ dash6Total.y2023 }}</td>
                    <td>{{ dash6Total.y2024 }}</td>
                    <td>{{ dash6Total.total }}</td>
                  </tr>
                </tbody>
              </table>

              <table
                class="table table-hover table-borderless table-centered align-middle table-nowrap mb-0 table-sm d-none"
                id="export4">
                <thead class="text-muted bg-light-subtle" style="height: 32px;">
                  <tr class="text-end">
                    <th class="text-start">Grade Range</th>
                    <th class="text-start">Category</th>
                    <th class="text-start">Stockpile</th>
                    <th v-for="(col, colInx) in dateColheader" :key="colInx" class="text-end" style="width: 100px; ">{{
                      headDate2(col.colId) }}</th>
                    <th style="width: 100px;">Total</th>
                  </tr>
                </thead>
                <tbody v-if="dash7DataTotal.total" class="border-0">
                  <tr class="border-bottom border-bottom-dashed text-secondary text-end fw-medium border-top">
                    <td class="text-start">Padou</td>
                    <td></td>
                    <td></td>
                    <td v-for="(col, colInx) in dateColheader" :key="colInx">{{ dash7PadouTotal[col.colId] }}</td>
                    <td class="fw-medium">{{ dash7PadouTotal.total }}</td>
                  </tr>
                </tbody>
                <tbody v-if="dash7PadouTotal.total" class="border-0">
                  <tr v-for="(item, index) in dash7Padou" :key="index" class="text-end">
                    <td class="text-start">{{ item.grade_range }}</td>
                    <td class="text-start">{{ item.coal_category }}</td>
                    <td class="text-start">{{ item.stockpile }}</td>
                    <td v-for="(col, colInx) in dateColheader" :key="colInx">{{ item[col.colId] }}</td>
                    <td class="fw-medium">{{ item.total }}</td>
                  </tr>
                </tbody>
                <tbody v-if="dash7DataTotal.total" class="border-0">
                  <tr class="border-top border-bottom border-bottom-dashed text-secondary text-end fw-medium">
                    <td class="text-start">Pakxai</td>
                    <td></td>
                    <td></td>
                    <td v-for="(col, colInx) in dateColheader" :key="colInx">{{ dash7PakxaiTotal[col.colId] }}</td>
                    <td class="fw-medium">{{ dash7PakxaiTotal.total }}</td>
                  </tr>
                </tbody>
                <tbody v-if="dash7PakxaiTotal.total" class="border-0">
                  <tr v-for="(item, index) in dash7Pakxai" :key="index" class="text-end">
                    <td class="text-start">{{ item.grade_range }}</td>
                    <td class="text-start">{{ item.coal_category }}</td>
                    <td class="text-start">{{ item.stockpile }}</td>
                    <td v-for="(col, colInx) in dateColheader" :key="colInx">{{ item[col.colId] }}</td>
                    <td class="fw-medium">{{ item.total }}</td>
                  </tr>
                </tbody>
                <tbody v-if="dash7DataTotal.total" class="border-0">
                  <tr class="border-top border-bottom border-bottom-dashed text-secondary text-end fw-medium">
                    <td class="text-start">Kaleum</td>
                    <td></td>
                    <td></td>
                    <td v-for="(col, colInx) in dateColheader" :key="colInx">{{ dash7KaleumTotal[col.colId] }}</td>
                    <td class="fw-medium">{{ dash7KaleumTotal.total }}</td>
                  </tr>
                </tbody>
                <tbody v-if="dash7KaleumTotal.total" class="border-0">
                  <tr v-for="(item, index) in dash7Kaleum" :key="index" class="text-end">
                    <td class="text-start">{{ item.grade_range }}</td>
                    <td class="text-start">{{ item.coal_category }}</td>
                    <td class="text-start">{{ item.stockpile }}</td>
                    <td v-for="(col, colInx) in dateColheader" :key="colInx">{{ item[col.colId] }}</td>
                    <td class="fw-medium">{{ item.total }}</td>
                  </tr>
                </tbody>
                <tbody v-if="dash7DataTotal.total" class="border-0">
                  <tr class="border-top text-secondary fw-semibold text-end">
                    <td class="text-start">Grand Total</td>
                    <td></td>
                    <td></td>
                    <td v-for="(col, colInx) in dateColheader" :key="colInx">{{ dash7DataTotal[col.colId] }}</td>
                    <td>{{ dash7DataTotal.total }}</td>
                  </tr>
                </tbody>
              </table>
            </div>

          </div>
        </div>
      </div>
    </div>


  </div>
</template>

<script>
import axios from 'axios';
import { useAuthStore } from '../stores/auth';
import { useStore } from '../stores/store';

export default {
  name: 'XpplAppDashProduction',
  setup() {
    const authStore = useAuthStore();
    const store = useStore();
    return { authStore, store };
  },

  data() {
    return {


      dash1Data: [],
      dash2Data: [],
      dash3Data: [],

      dash4Data: [],
      dash4Padou: [],
      dash4Pakxai: [],
      dash4Kaleum: [],
      dash4PadouTotal: '',
      dash4PakxaiTotal: '',
      dash4KaleumTotal: '',
      dash4DataTotal: '',

      dash5Data: [],
      dash5Filter: [],
      dash5Total: [],

      dash6Data: [],
      dash6Filter: [],
      dash6Total: [],

      dateColheader: [],
      dash7Data: [],
      dash7Padou: [],
      dash7Pakxai: [],
      dash7Kaleum: [],
      dash7PadouTotal: '',
      dash7PakxaiTotal: '',
      dash7KaleumTotal: '',
      dash7DataTotal: '',
      selectMonth: '',
      cdate: '',


      selectDate: '',
      lkYear: [],
      selectYear: '',
      loading: false
    };
  },

  mounted() {
    flatpickr(".flatpickr-single", {
      altInput: true,
      altFormat: 'd-m-Y'
    });
  },

  methods: {
    async onLoad() {
      this.loading = true;

      const date = await this.getCurrentDateTime();
      const dash1 = await this.getDashboards();

      const currentDate = new Date();
      let y = currentDate.getFullYear();
      let m = String(currentDate.getMonth() + 1).padStart(2, '0');
      this.selectMonth = `${y}-${m}`;
      const dash10 = await this.getDash7();

      const year = await axios.get('api/production/mine-year', { headers: { Authorization: 'Bearer ' + this.authStore.getToken } });
      this.lkYear = year.data;

      this.loading = false;
    },

    async getCurrentDateTime() {
      // try {
      // const lastDate = await axios.get('api/production-dash/last-date', { headers: { Authorization: 'Bearer ' + this.authStore.getToken } });
      // this.selectDate = moment(lastDate.data[0].lastDate).format('YYYY-MM-DD');
      // const fp = flatpickr('#select-date', {
      //   altInput: true,
      //   altFormat: 'd-m-Y'
      // });
      // fp.setDate(this.selectDate);

      this.selectDate = moment(new Date(new Date().getTime() - 24 * 60 * 60 * 1000)).format('YYYY-MM-DD');

      // } catch (error) {
      //   if (error.response.status == 401) {
      //     this.authStore.removeToken();
      //     this.authStore.removeUser();
      //     localStorage.removeItem('token');
      //     localStorage.removeItem('user');
      //     this.$router.push('/login');
      //   }
      // }
    },

    async refresh() {
      this.loading = true;
      const time = await this.getCurrentDateTime();
      const dash = await this.getDashboards();
      this.loading = false;
    },

    async onSelectDate() {
      this.loading = true;
      const dash1 = await this.getDashboards();
      this.loading = false;
    },

    async getDashboards() {

      const dash1 = await axios.get(`api/production-dash/dashboard1?date=${this.selectDate}`, { headers: { Authorization: 'Bearer ' + this.authStore.getToken } });
      this.dash1Data = dash1.data;

      const dash2 = await axios.get(`api/production-dash/dashboard2?date=${this.selectDate}`, { headers: { Authorization: 'Bearer ' + this.authStore.getToken } });
      this.dash2Data = dash2.data;

      const dash3 = await axios.get(`api/production-dash/dashboard3?date=${this.selectDate}`, { headers: { Authorization: 'Bearer ' + this.authStore.getToken } });
      this.dash3Data = dash3.data;

      this.selectYear = moment(new Date().getTime()).format('YYYY');
      const dash4 = await axios.get(`api/production-dash/dashboard4?year=${this.selectYear}`, { headers: { Authorization: 'Bearer ' + this.authStore.getToken } });
      this.dash4Data = dash4.data;
      const padou = this.dash4Data.filter(e => e.area == 'Padou');
      this.dash4Padou = padou;
      const padouTotal = this.dash4Data.find(e => e.area == 'total_padou');
      this.dash4PadouTotal = padouTotal;
      const pakxai = this.dash4Data.filter(e => e.area == 'Pakxai');
      this.dash4Pakxai = pakxai;
      const pakxaiTotal = this.dash4Data.find(e => e.area == 'total_pakxai');
      this.dash4PakxaiTotal = pakxaiTotal;
      const kaleum = this.dash4Data.filter(e => e.area == 'Kaleum');
      this.dash4Kaleum = kaleum;
      const kaleumTotal = this.dash4Data.find(e => e.area == 'total_kaleum');
      this.dash4KaleumTotal = kaleumTotal;
      const total = this.dash4Data.find(e => e.area == 'total');
      this.dash4DataTotal = total;

      const dash5 = await axios.get(`api/production-dash/dashboard5?date=${this.selectDate}`, { headers: { Authorization: 'Bearer ' + this.authStore.getToken } });
      this.dash5Data = dash5.data;
      let dash5Filter = this.dash5Data.filter(e => e.area != 'total');
      this.dash5Filter = dash5Filter;
      let dash5total = this.dash5Data.find(e => e.area == 'total');
      this.dash5Total = dash5total;

      const dash6 = await axios.get(`api/production-dash/dashboard6?date=${this.selectDate}`, { headers: { Authorization: 'Bearer ' + this.authStore.getToken } });
      this.dash6Data = dash6.data;
      let dash6Filter = this.dash6Data.filter(e => e.grade_range != 'total');
      this.dash6Filter = dash6Filter;
      let dash6total = this.dash6Data.find(e => e.grade_range == 'total');
      this.dash6Total = dash6total;

      const currentDate = new Date();
      let y = currentDate.getFullYear();
      let m = String(currentDate.getMonth() + 1).padStart(2, '0');
      this.selectMonth = `${y}-${m}`;
      const dash10 = await this.getDash7();
    },

    async getDashboard4(y) {

      this.dash4Data = [];
      this.dash4Padou = [];
      this.dash4Pakxai = [];
      this.dash4Kaleum = [];
      this.dash4PadouTotal = '';
      this.dash4PakxaiTotal = '';
      this.dash4KaleumTotal = '';
      this.dash4DataTotal = '';

      this.selectYear = y;
      const dash4 = await axios.get(`api/production-dash/dashboard4?year=${this.selectYear}`, { headers: { Authorization: 'Bearer ' + this.authStore.getToken } });
      this.dash4Data = dash4.data;

      const padou = this.dash4Data.filter(e => e.area == 'Padou');
      this.dash4Padou = padou;
      const padouTotal = this.dash4Data.find(e => e.area == 'total_padou');
      this.dash4PadouTotal = padouTotal;

      const pakxai = this.dash4Data.filter(e => e.area == 'Pakxai');
      this.dash4Pakxai = pakxai;
      const pakxaiTotal = this.dash4Data.find(e => e.area == 'total_pakxai');
      this.dash4PakxaiTotal = pakxaiTotal;

      const kaleum = this.dash4Data.filter(e => e.area == 'Kaleum');
      this.dash4Kaleum = kaleum;
      const kaleumTotal = this.dash4Data.find(e => e.area == 'total_kaleum');
      this.dash4KaleumTotal = kaleumTotal;

      const total = this.dash4Data.find(e => e.area == 'total');
      this.dash4DataTotal = total;
    },

    async getDash7() {
      this.dash7Data = [];
      this.dash7Padou = [];
      this.dash7Pakxai = [];
      this.dash7Kaleum = [];
      this.dash7PadouTotal = '';
      this.dash7PakxaiTotal = '';
      this.dash7KaleumTotal = '';
      this.dash7DataTotal = '';
      this.dateColheader = [];

      const m = this.selectMonth.split('-')[1];
      const y = this.selectMonth.split('-')[0];

      const firstDayOfMonth = new Date(y, m - 1, 1);
      const lastDayOfMonth = new Date(firstDayOfMonth);

      lastDayOfMonth.setMonth(lastDayOfMonth.getMonth() + 1, 0);

      let dateFr = moment(firstDayOfMonth).format('YYYY/MM/DD');
      let dateTo = moment(lastDayOfMonth).format('YYYY/MM/DD');

      this.cdate = moment(new Date()).format("YYYYMMDD");

      while (firstDayOfMonth <= lastDayOfMonth) {
        this.dateColheader.push({
          colId: 'd' + moment(new Date(firstDayOfMonth)).format('YYYYMMDD'),
          colName: moment(new Date(firstDayOfMonth)).format('DD')
        });

        firstDayOfMonth.setDate(firstDayOfMonth.getDate() + 1);
      }

      const dash7 = await axios.get(`api/production-dash/dashboard7?dateFr=${dateFr}&dateTo=${dateTo}`, { headers: { Authorization: 'Bearer ' + this.authStore.getToken } });
      this.dash7Data = dash7.data;

      let padou = this.dash7Data.filter((e) => e.area == 'padou');
      this.dash7Padou = padou;
      let padouTotal = this.dash7Data.find((e) => e.area == 'total_padou');
      this.dash7PadouTotal = padouTotal;

      let pakxai = this.dash7Data.filter((e) => e.area == 'pakxai');
      this.dash7Pakxai = pakxai;
      let pakxaiTotal = this.dash7Data.find((e) => e.area == 'total_pakxai');
      this.dash7PakxaiTotal = pakxaiTotal;

      let kaleum = this.dash7Data.filter((e) => e.area == 'kaleum');
      this.dash7Kaleum = kaleum;
      let kaleumTotal = this.dash7Data.find((e) => e.area == 'total_kaleum');
      this.dash7KaleumTotal = kaleumTotal;

      let dash7total = this.dash7Data.find((e) => e.area == 'total');
      this.dash7DataTotal = dash7total;

    },

    headDate(text) {
      if (text) {
        return moment(text.split('d')[1]).format("YYYYMMDD");
      }
    },

    headDate2(text) {
      if (text) {
        return moment(text.split('d')[1]).format("YYYY-MM-DD");
      }
    },

    exportData1() {
      document.getElementById('export1').classList.remove('d-none');
      const table2excel = new Table2Excel();
      table2excel.export(document.getElementById('export1'));
      document.getElementById('export1').classList.add('d-none');
    },

    exportData2() {
      document.getElementById('export2').classList.remove('d-none');
      const table2excel = new Table2Excel();
      table2excel.export(document.getElementById('export2'));
      document.getElementById('export2').classList.add('d-none');
    },

    exportData3() {
      document.getElementById('export3').classList.remove('d-none');
      const table2excel = new Table2Excel();
      table2excel.export(document.getElementById('export3'));
      document.getElementById('export3').classList.add('d-none');
    },

    exportData4() {
      document.getElementById('export4').classList.remove('d-none');
      const table2excel = new Table2Excel();
      table2excel.export(document.getElementById('export4'));
      document.getElementById('export4').classList.add('d-none');
    },


  },

  created() {
    this.onLoad();
  }
};
</script>