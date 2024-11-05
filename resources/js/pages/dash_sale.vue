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
                  <p class="text-muted mb-0">Sales dashboard last updated on <span class="text-danger fw-medium">{{ store.fullMDY(selectDate) }}, at {{ refreshTime }}</span> </p>
                </div>
                <div class="mt-3 mt-lg-0">
                  <div class="row g-2 mb-0 align-items-center">
                    <div class="col-sm-auto">
                      <div class="input-group">
                        <input type="text" id="select-date" class="form-control flatpickr-input flatpickr-single rounded-start-2 cursor-pointer" placeholder="Select date" v-model="selectDate" @input="onSelectDate()">
                        <button type="button" class="btn btn-soft-primary" style="border-color: var(--vz-input-border-custom);" @click="refresh()"><i class="ri-refresh-line align-middle"></i></button>
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
                              <h4 class="fs-22 fw-semibold ff-secondary mb-0">{{ store.numInt(dash1Data[0].trip) }}<span class="text-muted fw-normal fs-13 ms-1">trip</span></h4>
                              <h4 class="fs-22 fw-semibold ff-secondary mb-0">{{ store.numInt(dash1Data[0].ton) }}<span class="text-muted fw-normal fs-13 ms-1">ton</span></h4>
                            </div>
                            <!-- <div class="avatar-sm flex-shrink-0" v-if="dash1Data[0].ton - dash1Data[1].ton > 0">
                              <span class="avatar-title bg-success-subtle rounded fs-3">
                                <i class="bx bx-up-arrow-circle text-success"></i>
                              </span>
                            </div>
                            <div class="avatar-sm flex-shrink-0" v-else>
                              <span class="avatar-title bg-warning-subtle rounded fs-3">
                                <i class="bx bx-down-arrow-circle text-warning"></i>
                              </span>
                            </div> -->
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
                              <h4 class="fs-22 fw-semibold ff-secondary mb-0">{{ store.numInt(dash1Data[2].trip) }}<span class="text-muted fw-normal fs-13 ms-1">trip</span></h4>
                              <h4 class="fs-22 fw-semibold ff-secondary mb-0">{{ store.numInt(dash1Data[2].ton) }}<span class="text-muted fw-normal fs-13 ms-1">ton</span></h4>
                            </div>
                            <!-- <div class="avatar-sm flex-shrink-0" v-if="dash1Data[2].ton - dash1Data[3].ton > 0">
                              <span class="avatar-title bg-success-subtle rounded fs-3">
                                <i class="bx bx-up-arrow-circle text-success"></i>
                              </span>
                            </div>
                            <div class="avatar-sm flex-shrink-0" v-else>
                              <span class="avatar-title bg-warning-subtle rounded fs-3">
                                <i class="bx bx-down-arrow-circle text-warning"></i>
                              </span>
                            </div> -->
                          </div>
                        </div>
                      </div>
                    </div>

                    <div class="col-lg-6">
                      <div class="card card-animate bg-danger-subtle">
                        <div class="card-body">
                          <div class="d-flex align-items-center">
                            <div class="flex-grow-1 overflow-hidden">
                              <p class="text-uppercase fw-semibold text-truncate mb-0 text-muted">YTD</p>
                            </div>
                            <!-- <div class="flex-shrink-0" v-if="(dash1Data[4].ton && dash1Data[5].ton) > 0">
                              <h5 class="text-success fs-14 mb-0" v-if="dash1Data[4].ton - dash1Data[5].ton > 0">+{{ store.numDec(((dash1Data[4].ton - dash1Data[5].ton) * 100) / dash1Data[5].ton) }} %</h5>
                              <h5 class="text-danger fs-14 mb-0" v-else>{{ store.numDec(((dash1Data[4].ton - dash1Data[5].ton) * 100) / dash1Data[5].ton) }} %</h5>
                            </div> -->
                          </div>
                          <div class="d-flex align-items-end justify-content-between mt-4">
                            <div>
                              <h4 class="fs-22 fw-semibold ff-secondary mb-0">{{ store.numInt(dash1Data[4].trip) }}<span class="text-muted fw-normal fs-13 ms-1">trip</span></h4>
                              <h4 class="fs-22 fw-semibold ff-secondary mb-0">{{ store.numInt(dash1Data[4].ton) }}<span class="text-muted fw-normal fs-13 ms-1">ton</span></h4>
                            </div>
                            <!-- <div class="avatar-sm flex-shrink-0" v-if="dash1Data[4].ton - dash1Data[5].ton > 0">
                              <span class="avatar-title bg-success-subtle rounded fs-3">
                                <i class="bx bx-up-arrow-circle text-success"></i>
                              </span>
                            </div>
                            <div class="avatar-sm flex-shrink-0" v-else>
                              <span class="avatar-title bg-warning-subtle rounded fs-3">
                                <i class="bx bx-down-arrow-circle text-warning"></i>
                              </span>
                            </div> -->
                          </div>
                        </div>
                      </div>
                    </div>

                    <div class="col-lg-6">
                      <div class="card card-animate">
                        <div class="card-body">
                          <div class="d-flex align-items-center">
                            <div class="flex-grow-1 overflow-hidden">
                              <p class="text-uppercase fw-semibold text-muted text-truncate mb-0">Domestic</p>
                            </div>
                            <!-- <div class="flex-shrink-0">
                              <h5 class="text-success fs-14 mb-0">{{ store.yyyy(selectDate) }}</h5>
                            </div> -->
                          </div>
                          <div class="d-flex align-items-end justify-content-between align-items-baseline">
                            <h4 class="fs-22 fw-semibold ff-secondary mb-0">{{ store.numInt(dash1Data[6].ton) }}<span class="text-muted fw-normal fs-13 ms-1">ton</span></h4>
                            <p class="mb-0 text-truncate ms-1 text-danger fw-medium">{{ store.numDec(dash1Data[6].ton * 100 / dash1Data[4].ton) }}%</p>
                          </div>

                          <div class="d-flex align-items-center" style="margin-top: 4.5px">
                            <div class="flex-grow-1 overflow-hidden">
                              <p class="text-uppercase fw-semibold text-muted text-truncate mb-0">Oversea</p>
                            </div>
                          </div>
                          <div class="d-flex align-items-end justify-content-between align-items-baseline">
                            <h4 class="fs-22 fw-semibold ff-secondary mb-0">{{ store.numInt(dash1Data[7].ton) }}<span class="text-muted fw-normal fs-13 ms-1">ton</span></h4>
                            <p class="mb-0 text-truncate ms-1 text-danger fw-medium">{{ store.numDec(dash1Data[7].ton * 100 / dash1Data[4].ton) }}%</p>
                          </div>
                        </div>
                      </div>
                    </div>

                    <div class="col-lg-6">
                      <div class="card card-animate bg-warning-subtle">
                        <div class="card-body">
                          <div class="d-flex align-items-center">
                            <div class="flex-grow-1 overflow-hidden">
                              <p class="text-uppercase fw-semibold text-truncate mb-0 text-muted">Target</p>
                            </div>
                            <!-- <div class="flex-shrink-0">
                              <h5 class="text-success fs-14 mb-0">{{ store.yyyy(selectDate) }}</h5>
                            </div> -->
                          </div>
                          <div class="d-flex align-items-end justify-content-between align-items-baseline">
                            <h4 class="fs-22 fw-semibold ff-secondary mb-0">4,500,000<span class="text-muted fw-normal fs-13 ms-1">ton</span></h4>
                          </div>

                          <div class="d-flex align-items-center" style="margin-top: 4.5px">
                            <div class="flex-grow-1 overflow-hidden">
                              <p class="text-uppercase fw-semibold text-truncate mb-0 text-muted">YTD Mined</p>
                            </div>
                          </div>
                          <div class="d-flex align-items-end justify-content-between align-items-baseline">
                            <h4 class="fs-22 fw-semibold ff-secondary mb-0">{{ store.numInt(dash1Data[4].ton) }}<span class="text-muted fw-normal fs-13 ms-1">ton</span></h4>
                            <p class="mb-0 text-truncate ms-1 text-secondary fw-semibold text-primary">{{ store.numDec(dash1Data[4].ton * 100 / 4500000) }}%</p>
                          </div>
                        </div>
                      </div>
                    </div>

                    <div class="col-lg-6">
                      <div class="card card-animate">
                        <div class="card-body">
                          <div class="d-flex align-items-center">
                            <div class="flex-grow-1 overflow-hidden">
                              <p class="text-uppercase fw-semibold text-muted text-truncate mb-0">Registered Truck</p>
                            </div>
                          </div>
                          <div class="d-flex align-items-end justify-content-between align-items-baseline">
                            <h4 class="fs-22 fw-semibold ff-secondary mb-0">{{ store.numInt(dash1Data[8].trip) }}</h4>
                          </div>

                          <div class="d-flex align-items-center" style="margin-top: 4.5px">
                            <div class="flex-grow-1 overflow-hidden">
                              <p class="text-uppercase fw-semibold text-muted text-truncate mb-0">In Progress Truck</p>
                            </div>
                          </div>
                          <div class="d-flex align-items-end justify-content-between align-items-baseline">
                            <h4 class="fs-22 fw-semibold ff-secondary mb-0">{{ store.numInt(dash1Data[9].trip) }}</h4>
                            <!-- <p class="mb-0 text-truncate ms-1 text-danger fw-medium">{{ store.numDec(dash1Data[9].trip * 100 / dash1Data[8].trip) }} %</p> -->
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
                            <p class="text-uppercase fw-semibold text-muted text-truncate mb-0">Domestic</p>
                          </div>
                          <div class="flex-shrink-0">
                            <h5 class="text-success fs-14 mb-0 text-danger">{{ store.ddmmyyyy(selectDate) }}</h5>
                          </div>
                        </div>
                        <div class="d-flex justify-content-between flex-wrap gap-2 ms-auto mt-4">
                          <div class="d-flex justify-content-between align-items-baseline">
                            <h4 class="fs-22 fw-semibold ff-secondary mb-0">{{ store.numInt(dash1Data[10].trip) }}</h4>
                            <p class="mb-0 text-truncate text-muted ms-1">trip</p>
                          </div>
                          <div class="d-flex justify-content-between align-items-baseline">
                            <h4 class="fs-22 fw-semibold ff-secondary mb-0">{{ store.numInt(dash1Data[10].ton) }}</h4>
                            <p class="mb-0 text-truncate text-muted ms-1">ton</p>
                          </div>
                        </div>
                        <div class="table-responsive table-card mt-4">
                          <table class="table table-borderless table-sm table-centered align-middle table-nowrap mb-1">
                            <thead class="text-muted border-dashed border border-start-0 border-end-0 bg-light-subtle">
                              <tr>
                                <th>Grade</th>
                                <th class="text-end" style="width: 30%;">Trip</th>
                                <th class="text-end" style="width: 30%;">Ton</th>
                              </tr>
                            </thead>
                            <tbody class="border-0">
                              <tr v-for="item in dash8Data" :key="item.grade">
                                <td>{{ item.grade }}</td>
                                <td class="text-end">{{ store.numInt(item.trip) }}</td>
                                <td class="text-end">{{ store.numInt(item.ton) }}</td>
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
                            <p class="text-uppercase fw-semibold text-muted text-truncate mb-0">Oversea</p>
                          </div>
                          <div class="flex-shrink-0">
                            <h5 class="text-success fs-14 mb-0 text-danger">{{ store.ddmmyyyy(selectDate) }}</h5>
                          </div>
                        </div>
                        <div class="d-flex justify-content-between flex-wrap gap-2 ms-auto mt-4">
                          <div class="d-flex justify-content-between align-items-baseline">
                            <h4 class="fs-22 fw-semibold ff-secondary mb-0">{{ store.numInt(dash1Data[11].trip) }}</h4>
                            <p class="mb-0 text-truncate text-muted ms-1">trip</p>
                          </div>
                          <div class="d-flex justify-content-between align-items-baseline">
                            <h4 class="fs-22 fw-semibold ff-secondary mb-0">{{ store.numInt(dash1Data[11].ton) }}</h4>
                            <p class="mb-0 text-truncate text-muted ms-1">ton</p>
                          </div>
                        </div>
                        <div class="table-responsive table-card mt-4">
                          <table class="table table-borderless table-sm table-centered align-middle table-nowrap mb-1">
                            <thead class="text-muted border-dashed border border-start-0 border-end-0 bg-light-subtle">
                              <tr>
                                <th>Grade</th>
                                <th class="text-end" style="width: 30%;">Trip</th>
                                <th class="text-end" style="width: 30%;">Ton</th>
                              </tr>
                            </thead>
                            <tbody class="border-0">
                              <tr v-for="item in dash9Data" :key="item.grade">
                                <td>{{ item.grade }}</td>
                                <td class="text-end">{{ store.numInt(item.trip) }}</td>
                                <td class="text-end">{{ store.numInt(item.ton) }}</td>
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

            <!-- Active by date -->
            <div class="col-xl-12">
              <div class="card">
                <div class="card-header border-bottom">
                  <div class="row g-2 align-items-center email-topbar-link">
                    <div class="col-xl-6 col-lg-6">
                      <h5 class="card-title mb-0 flex-grow-1 overflow-hidden">Coal sales on {{ store.fullMonY(selectMonth) }}</h5>
                    </div>
                    <div class="col-xxl-2 col-xl-3 col-lg-3 col-md-4 col-sm-6 ms-auto text-end">
                      <input type="month" class="form-control form-control-sm" v-model="selectMonth" @input="getDash10">
                    </div>
                    <button class="btn btn-ghost-secondary btn-icon btn-sm material-shadow-none active" @click="exportData5" title="Export to excel file.">
                      <i class="ri-file-excel-2-line align-bottom fs-15"></i>
                    </button>
                  </div>
                </div>
                <div class="card-body">
                  <div class="table-responsive table-card">
                    <table class="table table-hover table-borderless table-centered align-middle table-nowrap mb-0 table-sm">
                      <thead class="text-muted bg-light-subtle" style="height: 32px;">
                        <tr class="text-end">
                          <th class="text-start">Coal Sale (ton)</th>
                          <th v-for="(col, colInx) in dateColheader" :key="colInx" class="text-end" style="width: 100px; " :style="headDate(col.colId) == cdate ? 'color: red; font-weight: bold;' : ''">{{ col.colName }}</th>
                          <th style="width: 100px;">Total</th>
                        </tr>
                      </thead>
                      <tbody v-if="dash10DataTotal.total" class="border-0">
                        <tr class="border-bottom border-bottom-dashed text-secondary text-end fw-medium border-top">
                          <td class="text-start">Domestic</td>
                          <td v-for="(col, colInx) in dateColheader" :key="colInx">{{ store.numInt(dash10DomeTotal[col.colId]) }}</td>
                          <td class="fw-medium">{{ store.numInt(dash10DomeTotal.total) }}</td>
                        </tr>
                      </tbody>
                      <tbody v-if="dash10DomeTotal.total" class="border-0">
                        <tr v-for="(item, index) in dash10Dome" :key="index" class="text-end">
                          <td class="text-start">{{ item.grade }}</td>
                          <td v-for="(col, colInx) in dateColheader" :key="colInx">{{ store.numInt(item[col.colId]) }}</td>
                          <td class="fw-medium">{{ store.numInt(item.total) }}</td>
                        </tr>
                      </tbody>
                      <tbody v-if="dash10DataTotal.total" class="border-0">
                        <tr class="border-top border-bottom border-bottom-dashed text-secondary text-end fw-medium">
                          <td class="text-start">Oversea</td>
                          <td v-for="(col, colInx) in dateColheader" :key="colInx">{{ store.numInt(dash10OverTotal[col.colId]) }}</td>
                          <td class="fw-medium">{{ store.numInt(dash10OverTotal.total) }}</td>
                        </tr>
                      </tbody>
                      <tbody v-if="dash10OverTotal.total" class="border-0">
                        <tr v-for="(item, index) in dash10Over" :key="index" class="text-end">
                          <td class="text-start">{{ item.grade }}</td>
                          <td v-for="(col, colInx) in dateColheader" :key="colInx">{{ store.numInt(item[col.colId]) }}</td>
                          <td class="fw-medium">{{ store.numInt(item.total) }}</td>
                        </tr>
                      </tbody>
                      <tbody v-if="dash10DataTotal.total" class="border-0">
                        <tr class="border-top text-secondary fw-semibold text-end">
                          <td class="text-start">Grand Total</td>
                          <td v-for="(col, colInx) in dateColheader" :key="colInx">{{ store.numInt(dash10DataTotal[col.colId]) }}</td>
                          <td>{{ store.numInt(dash10DataTotal.total) }}</td>
                        </tr>
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>
            </div>

            <!-- By Month -->
            <div class="col-xl-12">
              <div class="card">
                <div class="card-header align-items-center d-flex email-topbar-link">
                  <h4 class="card-title mb-0 flex-grow-1">Actived coal sales {{ selYear }}</h4>
                  <div class="flex-shrink-0">
                    <div class="dropdown card-header-dropdown">
                      <a class="text-reset dropdown-btn" href="#" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <span class="text-muted">{{ selYear }}<i class="mdi mdi-chevron-down ms-1"></i></span>
                      </a>
                      <div class="dropdown-menu dropdown-menu-end overflow-auto" style="max-height: 300px">
                        <a class="dropdown-item" href="#" v-for="(item, index) in lkYear" :key="index" @click="getDash3(item.value)">
                          {{ item.value }}
                        </a>
                      </div>
                    </div>
                  </div>
                  <button class="btn btn-ghost-secondary btn-icon btn-sm material-shadow-none" @click="exportData1" title="Export to excel file.">
                    <i class="ri-file-excel-2-line align-bottom fs-15"></i>
                  </button>
                </div>

                <div class="card-body">
                  <div class="table-responsive table-card">
                    <table class="table table-hover table-borderless table-centered align-middle table-nowrap mb-0 table-sm">
                      <thead class="text-muted bg-light-subtle" style="height: 32px;">
                        <tr class="text-end">
                          <th class="text-start">Coal Sale (ton)</th>
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
                      <tbody v-if="dash3DataTotal.total" class="border-0">
                        <tr class="border-bottom border-bottom-dashed text-secondary text-end fw-medium border-top">
                          <td class="text-start">Domestic</td>
                          <td>{{ store.numInt(dash3DomeTotal.m1) }}</td>
                          <td>{{ store.numInt(dash3DomeTotal.m2) }}</td>
                          <td>{{ store.numInt(dash3DomeTotal.m3) }}</td>
                          <td>{{ store.numInt(dash3DomeTotal.m4) }}</td>
                          <td>{{ store.numInt(dash3DomeTotal.m5) }}</td>
                          <td>{{ store.numInt(dash3DomeTotal.m6) }}</td>
                          <td>{{ store.numInt(dash3DomeTotal.m7) }}</td>
                          <td>{{ store.numInt(dash3DomeTotal.m8) }}</td>
                          <td>{{ store.numInt(dash3DomeTotal.m9) }}</td>
                          <td>{{ store.numInt(dash3DomeTotal.m10) }}</td>
                          <td>{{ store.numInt(dash3DomeTotal.m11) }}</td>
                          <td>{{ store.numInt(dash3DomeTotal.m12) }}</td>
                          <td class="fw-medium">{{ store.numInt(dash3DomeTotal.total) }}</td>
                        </tr>
                      </tbody>
                      <tbody v-if="dash3DomeTotal.total" class="border-0">
                        <tr v-for="(item, index) in dash3Dome" :key="index" class="text-end">
                          <td class="text-start">{{ item.grade }}</td>
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
                      <tbody v-if="dash3DataTotal.total" class="border-0">
                        <tr class="border-top border-bottom border-bottom-dashed text-secondary text-end fw-medium">
                          <td class="text-start">Oversea</td>
                          <td>{{ store.numInt(dash3OverTotal.m1) }}</td>
                          <td>{{ store.numInt(dash3OverTotal.m2) }}</td>
                          <td>{{ store.numInt(dash3OverTotal.m3) }}</td>
                          <td>{{ store.numInt(dash3OverTotal.m4) }}</td>
                          <td>{{ store.numInt(dash3OverTotal.m5) }}</td>
                          <td>{{ store.numInt(dash3OverTotal.m6) }}</td>
                          <td>{{ store.numInt(dash3OverTotal.m7) }}</td>
                          <td>{{ store.numInt(dash3OverTotal.m8) }}</td>
                          <td>{{ store.numInt(dash3OverTotal.m9) }}</td>
                          <td>{{ store.numInt(dash3OverTotal.m10) }}</td>
                          <td>{{ store.numInt(dash3OverTotal.m11) }}</td>
                          <td>{{ store.numInt(dash3OverTotal.m12) }}</td>
                          <td class="fw-medium">{{ store.numInt(dash3OverTotal.total) }}</td>
                        </tr>
                      </tbody>
                      <tbody v-if="dash3OverTotal.total" class="border-0">
                        <tr v-for="(item, index) in dash3Over" :key="index" class="text-end">
                          <td class="text-start">{{ item.grade }}</td>
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
                      <tbody v-if="dash3DataTotal.total" class="border-0">
                        <tr class="border-top text-secondary fw-semibold text-end">
                          <td class="text-start">Grand Total</td>
                          <td>{{ store.numInt(dash3DataTotal.m1) }}</td>
                          <td>{{ store.numInt(dash3DataTotal.m2) }}</td>
                          <td>{{ store.numInt(dash3DataTotal.m3) }}</td>
                          <td>{{ store.numInt(dash3DataTotal.m4) }}</td>
                          <td>{{ store.numInt(dash3DataTotal.m5) }}</td>
                          <td>{{ store.numInt(dash3DataTotal.m6) }}</td>
                          <td>{{ store.numInt(dash3DataTotal.m7) }}</td>
                          <td>{{ store.numInt(dash3DataTotal.m8) }}</td>
                          <td>{{ store.numInt(dash3DataTotal.m9) }}</td>
                          <td>{{ store.numInt(dash3DataTotal.m10) }}</td>
                          <td>{{ store.numInt(dash3DataTotal.m11) }}</td>
                          <td>{{ store.numInt(dash3DataTotal.m12) }}</td>
                          <td>{{ store.numInt(dash3DataTotal.total) }}</td>
                        </tr>
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>
            </div>

            <!-- Statistic from 2017 -->
            <div class="row">
              <div class="col-xl-9">
                <div class="card">
                  <div class="card-header align-items-center d-flex email-topbar-link">
                    <h4 class="card-title mb-0 flex-grow-1">Statistic on coal sales by market from 2017</h4>
                    <button class="btn btn-ghost-secondary btn-icon btn-sm material-shadow-none" @click="exportData2" title="Export to excel file.">
                      <i class="ri-file-excel-2-line align-bottom fs-15"></i>
                    </button>
                  </div>
                  <div class="card-body">
                    <div class="table-responsive table-card">
                      <table class="table table-hover table-borderless table-centered align-middle table-nowrap mb-0 table-sm">
                        <thead class="text-muted bg-light-subtle" style="height: 32px;">
                          <tr class="text-end">
                            <th class="text-start">Market</th>
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
                          <tr v-for="(item, index) in dash4Filter" :key="index" class="text-end">
                            <td class="text-start">{{ item.DestPort }}</td>
                            <td>{{ store.numInt(item.y2017) }}</td>
                            <td>{{ store.numInt(item.y2018) }}</td>
                            <td>{{ store.numInt(item.y2019) }}</td>
                            <td>{{ store.numInt(item.y2020) }}</td>
                            <td>{{ store.numInt(item.y2021) }}</td>
                            <td>{{ store.numInt(item.y2022) }}</td>
                            <td>{{ store.numInt(item.y2023) }}</td>
                            <td>{{ store.numInt(item.y2024) }}</td>
                            <td class="fw-medium">{{ store.numInt(item.ytotal) }}</td>
                          </tr>
                          <tr class="border-top fw-semibold text-end">
                            <td class="text-start">Grand Total</td>
                            <td>{{ store.numInt(dash4Total.y2017) }}</td>
                            <td>{{ store.numInt(dash4Total.y2018) }}</td>
                            <td>{{ store.numInt(dash4Total.y2019) }}</td>
                            <td>{{ store.numInt(dash4Total.y2020) }}</td>
                            <td>{{ store.numInt(dash4Total.y2021) }}</td>
                            <td>{{ store.numInt(dash4Total.y2022) }}</td>
                            <td>{{ store.numInt(dash4Total.y2023) }}</td>
                            <td>{{ store.numInt(dash4Total.y2024) }}</td>
                            <td>{{ store.numInt(dash4Total.ytotal) }}</td>
                          </tr>
                        </tbody>
                      </table>
                    </div>
                  </div>
                </div>

                <div class="card">
                  <div class="card-header align-items-center d-flex email-topbar-link">
                    <h4 class="card-title mb-0 flex-grow-1">Statistics on coal sales by grade from 2017</h4>
                    <button class="btn btn-ghost-secondary btn-icon btn-sm material-shadow-none" @click="exportData3" title="Export to excel file.">
                      <i class="ri-file-excel-2-line align-bottom fs-15"></i>
                    </button>
                  </div>
                  <div class="card-body">
                    <div class="table-responsive table-card">
                      <table class="table table-hover table-borderless table-centered align-middle table-nowrap mb-0 table-sm">
                        <thead class="text-muted bg-light-subtle" style="height: 32px;">
                          <tr class="text-end">
                            <th class="text-start">Coal Grade</th>
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
                          <tr v-for="(item, index) in dash5Filter" :key="index" class="text-end border-bottom border-bottom-dashed">
                            <td class="text-start">{{ item.grade }}</td>
                            <td>{{ store.numInt(item.y2017) }}</td>
                            <td>{{ store.numInt(item.y2018) }}</td>
                            <td>{{ store.numInt(item.y2019) }}</td>
                            <td>{{ store.numInt(item.y2020) }}</td>
                            <td>{{ store.numInt(item.y2021) }}</td>
                            <td>{{ store.numInt(item.y2022) }}</td>
                            <td>{{ store.numInt(item.y2023) }}</td>
                            <td>{{ store.numInt(item.y2024) }}</td>
                            <td class="fw-medium">{{ store.numInt(item.ytotal) }}</td>
                          </tr>
                          <tr class="border-top fw-semibold text-end">
                            <td class="text-start">Grand Total</td>
                            <td>{{ store.numInt(dash5Total.y2017) }}</td>
                            <td>{{ store.numInt(dash5Total.y2018) }}</td>
                            <td>{{ store.numInt(dash5Total.y2019) }}</td>
                            <td>{{ store.numInt(dash5Total.y2020) }}</td>
                            <td>{{ store.numInt(dash5Total.y2021) }}</td>
                            <td>{{ store.numInt(dash5Total.y2022) }}</td>
                            <td>{{ store.numInt(dash5Total.y2023) }}</td>
                            <td>{{ store.numInt(dash5Total.y2024) }}</td>
                            <td>{{ store.numInt(dash5Total.ytotal) }}</td>
                          </tr>
                        </tbody>
                      </table>
                    </div>
                  </div>
                </div>
              </div>

              <div class="col-xl-3">
                <div class="card">
                  <div class="card-header d-flex align-items-center" style="height: 59.96px;">
                    <h4 class="card-title mb-0 flex-grow-1">Daily Loading</h4>
                    <div class="flex-shrink-0">
                      <h5 class="text-danger fs-14 mb-0">{{ store.ddmmyyyy(selectDate) }}</h5>
                    </div>
                  </div>
                  <div class="card-body">
                    <div class="table-responsive table-card">
                      <table class="table table-hover table-borderless table-centered align-middle table-nowrap mb-0 table-sm">
                        <thead class="text-muted bg-light-subtle" style="height: 32px;">
                          <tr class="text-end">
                            <th class="text-start">Market</th>
                            <th>Trip</th>
                            <th>Ton</th>
                          </tr>
                        </thead>
                        <tbody>
                          <tr v-for="(item, index) in dash6Filter" :key="index" class="text-end">
                            <td class="text-start">{{ item.DestPort }}</td>
                            <td>{{ store.numInt(item.trip) }}</td>
                            <td>{{ store.numInt(item.ton) }}</td>
                          </tr>
                          <tr class="border-top fw-semibold text-end">
                            <td class="text-start">Grand Total</td>
                            <td>{{ store.numInt(dash6Total.trip) }}</td>
                            <td>{{ store.numInt(dash6Total.ton) }}</td>
                          </tr>
                        </tbody>
                      </table>
                    </div>
                  </div>
                </div>

                <div class="card">
                  <div class="card-header align-items-center d-flex" style="height: 59.96px;">
                    <h4 class="card-title mb-0 flex-grow-1">Daily Loading</h4>
                    <div class="flex-shrink-0">
                      <h5 class="text-danger fs-14 mb-0">{{ store.ddmmyyyy(selectDate) }}</h5>
                    </div>
                  </div>
                  <div class="card-body">
                    <div class="table-responsive table-card">
                      <table class="table table-hover table-borderless table-centered align-middle table-nowrap mb-0 table-sm">
                        <thead class="text-muted bg-light-subtle" style="height: 32px;">
                          <tr class="text-end">
                            <th class="text-start">Coal Grade</th>
                            <th>Trip</th>
                            <th>Ton</th>
                          </tr>
                        </thead>
                        <tbody>
                          <tr v-for="(item, index) in dash7Filter" :key="index" class="text-end border-bottom border-bottom-dashed">
                            <td class="text-start">{{ item.grade }}</td>
                            <td class="text-end">{{ store.numInt(item.trip) }}</td>
                            <td class="text-end">{{ store.numInt(item.ton) }}</td>
                          </tr>
                          <tr class="border-top fw-semibold text-end">
                            <td class="text-start">Grand Total</td>
                            <td>{{ store.numInt(dash7Total.trip) }}</td>
                            <td>{{ store.numInt(dash7Total.ton) }}</td>
                          </tr>
                        </tbody>
                      </table>
                    </div>
                  </div>
                </div>
              </div>
            </div>

            <div class="col-xl-12">
              <div class="card">
                <div class="card-header align-items-center d-flex email-topbar-link">
                  <h4 class="card-title mb-0 flex-grow-1">Contract implementation {{ store.yyyy(selectDate) }}</h4>
                  <!-- <div class="flex-shrink-0 ms-2" @click="exportData4">
                    <a href="javascript:void(0)" class="link-primary">Export <i class=" ri-file-excel-2-line"></i></a>
                  </div> -->
                  <button id="btn-hide" class="btn btn-ghost-secondary btn-icon btn-sm material-shadow-none d-none" @click="hideContract" title="Hide selected row.">
                    <i class="ri-eye-off-fill align-bottom fs-15"></i>
                  </button>
                  <button class="btn btn-ghost-secondary btn-icon btn-sm material-shadow-none" @click="exportData4" title="Export to excel file.">
                    <i class="ri-file-excel-2-line align-bottom fs-15"></i>
                  </button>
                </div>
                <ag-grid-vue style="height: 500px" class="ag-theme-material" :columnDefs="columnDefs" :rowData="dash2Data" :defaultColDef="defaultColDef" :rowHeight="30" :headerHeight="31.99" :suppressMenuHide="false" :suppressCellFocus="true" animateRows="false" rowSelection="single" @rowClicked="cellCicked"></ag-grid-vue>
                <div class="pb-2"></div>
              </div>
            </div>

            <!-- Contract implementation -->
            <!-- <div class="col-xl-12">
              <div class="card">
                <div class="card-header align-items-center d-flex">
                  <h4 class="card-title mb-0 flex-grow-1">Contract implementation {{ store.yyyy(selectDate) }}</h4>
                  <div class="flex-shrink-0 ms-2" @click="exportData4">
                    <a href="javascript:void(0)" class="link-primary">Export <i class=" ri-file-excel-2-line"></i></a>
                  </div>
                </div>
                <div class="card-body">
                  <div class="table-responsive table-card" style="max-height: 482px;">
                    <table class="table table-hover table-borderless table-centered align-middle table-nowrap mb-0 table-sm">
                      <thead class="text-muted bg-light-subtle position-sticky" style="height: 32px; top: 0px; z-index: 1">
                        <tr class="text-end">
                          <th class="text-start">#</th>
                          <th class="text-start">Destination</th>
                          <th class="text-start">Customer Name</th>
                          <th class="text-start">Contract Number</th>
                          <th class="text-start">Signed Date</th>
                          <th class="text-start">Grade</th>
                          <th class="text-end">Contract Qty</th>
                          <th class="text-end">2023</th>
                          <th class="text-end">2024</th>
                          <th class="text-end text-danger">{{ store.ddmmyyyy(selectDate) }}</th>
                          <th class="text-end">Total Loaded</th>
                          <th class="text-end">Remaining</th>
                          <th class="text-end">Completed</th>
                          <th class="text-start">Remark</th>
                          <th class="text-start">Status</th>

                        </tr>
                      </thead>
                      <tbody>
                        <tr v-for="(item, index) in dash2Data" :key="index" class="border-top border-top-dashed ">
                          <td class="text-start">{{ index + 1 }}</td>
                          <td class="text-start">{{ item.destination }}</td>
                          <td class="text-start">{{ item.customer_name }}</td>
                          <td class="text-start">
                            <div v-if="item.contract_status == 'Active'">
                              {{ item.contract_no }}
                            </div>
                            <div v-else class="flex-grow-1">
                              <a class="link-secondary text-body dropdown" href="javascript:void(0)" data-bs-toggle="dropdown" aria-expanded="false">{{ item.contract_no }}</a>
                              <ul class="dropdown-menu dropdown-menu-end">
                                <li><a class="dropdown-item" href="javascript:void(0);" @click="hideContract(item.contract_id)"><i class="ri-eye-off-fill align-bottom me-2 text-muted"></i>Hide</a></li>
                              </ul>
                            </div>
                          </td>
                          <td class="text-start">{{ store.ddmmyyyy(item.signed_date) }}</td>
                          <td class="text-start">{{ item.grade_gar }}</td>
                          <td class="text-end">{{ store.numInt(item.contract_quantity) }}</td>
                          <td class="text-end">{{ store.numInt(item.c2023) }}</td>
                          <td class="text-end">{{ store.numInt(item.c2024) }}</td>
                          <td class="text-end">{{ store.numInt(item.date) }}</td>
                          <td class="text-end">{{ store.numInt(item.loaded) }}</td>
                          <td class="text-end">{{ store.numInt(item.remain) }}</td>
                          <td class="text-end">
                            <div v-if="item.pct">{{ store.numDec(item.pct) }} %</div>
                            <div v-else>{{ store.numDec(item.pct) }}</div>
                          </td>
                          <td class="text-start">{{ item.remark }}</td>
                          <td v-if="item.contract_status == 'Active'" class="text-start text-danger">{{ item.contract_status }}</td>
                          <td v-else-if="item.contract_status == 'Waiting'" class="text-start text-warning">{{ item.contract_status }}</td>
                          <td v-else class="text-start">{{ item.contract_status }}</td>
                        </tr>
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>
            </div> -->

            <!-- Export tables -->
            <table class="table table-hover table-borderless table-centered align-middle table-nowrap mb-0 table-sm d-none" id="export1">
              <thead class="text-muted bg-light-subtle" style="height: 32px;">
                <tr class="text-end">
                  <th class="text-start">Coal Sale (ton)</th>
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
                    Domestic
                  </td>
                  <td>{{ dash3DomeTotal.m1 }}</td>
                  <td>{{ dash3DomeTotal.m2 }}</td>
                  <td>{{ dash3DomeTotal.m3 }}</td>
                  <td>{{ dash3DomeTotal.m4 }}</td>
                  <td>{{ dash3DomeTotal.m5 }}</td>
                  <td>{{ dash3DomeTotal.m6 }}</td>
                  <td>{{ dash3DomeTotal.m7 }}</td>
                  <td>{{ dash3DomeTotal.m8 }}</td>
                  <td>{{ dash3DomeTotal.m9 }}</td>
                  <td>{{ dash3DomeTotal.m10 }}</td>
                  <td>{{ dash3DomeTotal.m11 }}</td>
                  <td>{{ dash3DomeTotal.m12 }}</td>
                  <td>{{ dash3DomeTotal.total }}</td>
                </tr>
              </tbody>
              <tbody v-if="dash3DomeTotal.total">
                <tr v-for="(item, index) in dash3Dome" :key="index" class="text-end">
                  <td class="text-start">{{ item.grade }}</td>
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
                    Oversea
                  </td>
                  <td>{{ dash3OverTotal.m1 }}</td>
                  <td>{{ dash3OverTotal.m2 }}</td>
                  <td>{{ dash3OverTotal.m3 }}</td>
                  <td>{{ dash3OverTotal.m4 }}</td>
                  <td>{{ dash3OverTotal.m5 }}</td>
                  <td>{{ dash3OverTotal.m6 }}</td>
                  <td>{{ dash3OverTotal.m7 }}</td>
                  <td>{{ dash3OverTotal.m8 }}</td>
                  <td>{{ dash3OverTotal.m9 }}</td>
                  <td>{{ dash3OverTotal.m10 }}</td>
                  <td>{{ dash3OverTotal.m11 }}</td>
                  <td>{{ dash3OverTotal.m12 }}</td>
                  <td>{{ dash3OverTotal.total }}</td>
                </tr>
              </tbody>
              <tbody v-if="dash3OverTotal.total">
                <tr v-for="(item, index) in dash3Over" :key="index" class="text-end">
                  <td class="text-start">{{ item.grade }}</td>
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
              <tbody v-if="dash3DataTotal.total">
                <tr class="border-top text-secondary fw-semibold text-end">
                  <td class="text-start">
                    Grand Total
                  </td>
                  <td>{{ dash3DataTotal.m1 }}</td>
                  <td>{{ dash3DataTotal.m2 }}</td>
                  <td>{{ dash3DataTotal.m3 }}</td>
                  <td>{{ dash3DataTotal.m4 }}</td>
                  <td>{{ dash3DataTotal.m5 }}</td>
                  <td>{{ dash3DataTotal.m6 }}</td>
                  <td>{{ dash3DataTotal.m7 }}</td>
                  <td>{{ dash3DataTotal.m8 }}</td>
                  <td>{{ dash3DataTotal.m9 }}</td>
                  <td>{{ dash3DataTotal.m10 }}</td>
                  <td>{{ dash3DataTotal.m11 }}</td>
                  <td>{{ dash3DataTotal.m12 }}</td>
                  <td>{{ dash3DataTotal.total }}</td>
                </tr>
              </tbody>
            </table>

            <table class="table table-hover table-borderless table-centered align-middle table-nowrap mb-0 table-sm d-none" id="export2">
              <thead class="text-muted bg-light-subtle" style="height: 32px;">
                <tr class="text-end">
                  <th class="text-start">Market</th>
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
                <tr v-for="(item, index) in dash4Filter" :key="index" class="text-end">
                  <td class="text-start">{{ item.DestPort }}</td>
                  <td>{{ item.y2017 }}</td>
                  <td>{{ item.y2018 }}</td>
                  <td>{{ item.y2019 }}</td>
                  <td>{{ item.y2020 }}</td>
                  <td>{{ item.y2021 }}</td>
                  <td>{{ item.y2022 }}</td>
                  <td>{{ item.y2023 }}</td>
                  <td>{{ item.y2024 }}</td>
                  <td class="fw-medium">{{ item.ytotal }}</td>
                </tr>
                <tr class="border-top fw-semibold text-end">
                  <td class="text-start">Grand Total</td>
                  <td>{{ dash4Total.y2017 }}</td>
                  <td>{{ dash4Total.y2018 }}</td>
                  <td>{{ dash4Total.y2019 }}</td>
                  <td>{{ dash4Total.y2020 }}</td>
                  <td>{{ dash4Total.y2021 }}</td>
                  <td>{{ dash4Total.y2022 }}</td>
                  <td>{{ dash4Total.y2023 }}</td>
                  <td>{{ dash4Total.y2024 }}</td>
                  <td>{{ dash4Total.ytotal }}</td>
                </tr>
              </tbody>
            </table>

            <table class="table table-hover table-borderless table-centered align-middle table-nowrap mb-0 table-sm d-none" id="export3">
              <thead class="text-muted bg-light-subtle" style="height: 32px;">
                <tr class="text-end">
                  <th class="text-start">Coal Grade</th>
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
                <tr v-for="(item, index) in dash5Filter" :key="index" class="text-end border-bottom border-bottom-dashed">
                  <td class="text-start">{{ item.grade }}</td>
                  <td>{{ item.y2017 }}</td>
                  <td>{{ item.y2018 }}</td>
                  <td>{{ item.y2019 }}</td>
                  <td>{{ item.y2020 }}</td>
                  <td>{{ item.y2021 }}</td>
                  <td>{{ item.y2022 }}</td>
                  <td>{{ item.y2023 }}</td>
                  <td>{{ item.y2024 }}</td>
                  <td class="fw-medium">{{ item.ytotal }}</td>
                </tr>
                <tr class="border-top fw-semibold text-end">
                  <td class="text-start">Grand Total</td>
                  <td>{{ dash5Total.y2017 }}</td>
                  <td>{{ dash5Total.y2018 }}</td>
                  <td>{{ dash5Total.y2019 }}</td>
                  <td>{{ dash5Total.y2020 }}</td>
                  <td>{{ dash5Total.y2021 }}</td>
                  <td>{{ dash5Total.y2022 }}</td>
                  <td>{{ dash5Total.y2023 }}</td>
                  <td>{{ dash5Total.y2024 }}</td>
                  <td>{{ dash5Total.ytotal }}</td>
                </tr>
              </tbody>
            </table>

            <table class="table table-hover table-borderless table-centered align-middle table-nowrap mb-0 table-sm d-none" id="export4">
              <thead class="text-muted bg-light-subtle" style="height: 32px;">
                <tr class="text-end">
                  <th class="text-start">No.</th>
                  <th class="text-start">Destination</th>
                  <th class="text-start">Customer Name</th>
                  <th class="text-start">Contract Number</th>
                  <th class="text-start">Signed Date</th>
                  <th class="text-start">Grade</th>
                  <th class="text-end">Contract Qty</th>
                  <th class="text-end">2023</th>
                  <th class="text-end">2024</th>
                  <th class="text-end text-danger">{{ store.ddmmyyyy(selectDate) }}</th>
                  <th class="text-end">Total Loaded</th>
                  <th class="text-end">Remaining</th>
                  <th class="text-end">Completed %</th>
                  <th class="text-start">Remark</th>
                  <th class="text-start">Status</th>
                </tr>
              </thead>
              <tbody>
                <tr v-for="(item, index) in dash2Data" :key="index" class="border-top border-top-dashed ">
                  <td class="text-start">{{ index + 1 }}</td>
                  <td class="text-start">{{ item.destination }}</td>
                  <td class="text-start">{{ item.customer_name }}</td>
                  <td class="text-start">{{ item.contract_no }}</td>
                  <td class="text-start">{{ store.yyyymmdd(item.signed_date) }}</td>
                  <td class="text-start">{{ item.grade_gar }}</td>
                  <td class="text-end">{{ item.contract_quantity }}</td>
                  <td class="text-end">{{ item.c2023 }}</td>
                  <td class="text-end">{{ item.c2024 }}</td>
                  <td class="text-end">{{ item.date }}</td>
                  <td class="text-end">{{ item.loaded }}</td>
                  <td class="text-end">{{ item.remain }}</td>
                  <td class="text-end">{{ item.pct }}</td>
                  <td class="text-start">{{ item.remark }}</td>
                  <td class="text-start">{{ item.contract_status }}</td>
                </tr>
              </tbody>
            </table>

            <table class="table table-hover table-borderless table-centered align-middle table-nowrap mb-0 table-sm d-none" id="export5">
              <thead class="text-muted bg-light-subtle" style="height: 32px;">
                <tr class="text-end">
                  <th class="text-start">Coal Sale (ton)</th>
                  <th v-for="(col, colInx) in dateColheader" :key="colInx" class="text-end" style="width: 100px;">{{ headDate2(col.colId) }}</th>
                  <th style="width: 100px;">Total</th>
                </tr>
              </thead>
              <tbody v-if="dash10DataTotal.total" class="border-0">
                <tr class="border-bottom border-bottom-dashed text-secondary text-end fw-medium border-top">
                  <td class="text-start">Domestic</td>
                  <td v-for="(col, colInx) in dateColheader" :key="colInx">{{ dash10DomeTotal[col.colId] }}</td>
                  <td class="fw-medium">{{ dash10DomeTotal.total }}</td>
                </tr>
              </tbody>
              <tbody v-if="dash10DomeTotal.total" class="border-0">
                <tr v-for="(item, index) in dash10Dome" :key="index" class="text-end">
                  <td class="text-start">{{ item.grade }}</td>
                  <td v-for="(col, colInx) in dateColheader" :key="colInx">{{ item[col.colId] }}</td>
                  <td class="fw-medium">{{ item.total }}</td>
                </tr>
              </tbody>
              <tbody v-if="dash10DataTotal.total" class="border-0">
                <tr class="border-top border-bottom border-bottom-dashed text-secondary text-end fw-medium">
                  <td class="text-start">Oversea</td>
                  <td v-for="(col, colInx) in dateColheader" :key="colInx">{{ dash10OverTotal[col.colId] }}</td>
                  <td class="fw-medium">{{ dash10OverTotal.total }}</td>
                </tr>
              </tbody>
              <tbody v-if="dash10OverTotal.total" class="border-0">
                <tr v-for="(item, index) in dash10Over" :key="index" class="text-end">
                  <td class="text-start">{{ item.grade }}</td>
                  <td v-for="(col, colInx) in dateColheader" :key="colInx">{{ item[col.colId] }}</td>
                  <td class="fw-medium">{{ item.total }}</td>
                </tr>
              </tbody>
              <tbody v-if="dash10DataTotal.total" class="border-0">
                <tr class="border-top text-secondary fw-semibold text-end">
                  <td class="text-start">Grand Total</td>
                  <td v-for="(col, colInx) in dateColheader" :key="colInx">{{ dash10DataTotal[col.colId] }}</td>
                  <td>{{ dash10DataTotal.total }}</td>
                </tr>
              </tbody>
            </table>


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
import { AgGridVue } from 'ag-grid-vue3';
import 'ag-grid-community/styles/ag-grid.css';
import 'ag-grid-community/styles/ag-theme-material.css';
import 'ag-grid-enterprise';
import flatpickr from 'flatpickr';

export default {
  name: 'XpplAppDashSale',
  components: { AgGridVue },
  setup() {
    const store = useStore();
    const authStore = useAuthStore();
    return { store, authStore };
  },

  data() {
    return {
      saleData: [],
      selectDate: '',
      refreshTime: '',

      dash1Data: [],
      dash2Data: [],

      dash3Data: [],
      dash3Dome: [],
      dash3Over: [],
      dash3DomeTotal: '',
      dash3OverTotal: '',
      dash3DataTotal: '',

      dash4Data: [],
      dash4Filter: [],
      dash4Total: [],

      dash5Data: [],
      dash5Filter: [],
      dash5Total: [],

      dash6Data: [],
      dash6Filter: [],
      dash6Total: [],

      dash7Data: [],
      dash7Filter: [],
      dash7Total: [],

      dash8Data: [],
      dash9Data: [],

      dateColheader: [],
      dash10Data: [],
      dash10Dome: [],
      dash10Over: [],
      dash10DomeTotal: '',
      dash10OverTotal: '',
      dash10DataTotal: '',
      selectMonth: '',
      cdate: '',

      lkYear: [],
      selYear: '',

      contId: '',
      auth: [],

      loading: false,

      columnDefs: [{
        headerName: '#', maxWidth: 47, valueGetter: (params) => { return params.node.rowIndex + 1 },
        cellStyle: (params) => {
          if (params.data.contract_status == 'Active') {
            return { backgroundColor: 'lightblue' };
          } else if (params.data.contract_status == 'Waiting') {
            return { backgroundColor: 'lightgray' };
          }
          return {};
        },
      },
      {
        headerName: 'Destination', field: 'destination', filter: 'agSetColumnFilter',
        cellStyle: (params) => {
          if (params.data.contract_status == 'Active') {
            return { backgroundColor: 'lightblue' };
          } else if (params.data.contract_status == 'Waiting') {
            return { backgroundColor: 'lightgray' };
          }
          return {};
        },
      },
      {
        headerName: 'Customer Name', field: 'customer_name', minWidth: 180, filter: 'agSetColumnFilter',
        cellStyle: (params) => {
          if (params.data.contract_status == 'Active') {
            return { backgroundColor: 'lightblue' };
          } else if (params.data.contract_status == 'Waiting') {
            return { backgroundColor: 'lightgray' };
          }
          return {};
        },
      },
      {
        headerName: 'Contract Number', field: 'contract_no', minWidth: 210, filter: 'agSetColumnFilter',
        cellStyle: (params) => {
          if (params.data.contract_status == 'Active') {
            return { backgroundColor: 'lightblue' };
          } else if (params.data.contract_status == 'Waiting') {
            return { backgroundColor: 'lightgray' };
          }
          return {};
        },
      },
      {
        headerName: 'Signed Date', minWidth: 120, maxWidth: 120, valueGetter: p => {
          if (p.data.signed_date) {
            return moment(p.data.signed_date).format('DD-MM-YYYY')
          }
        },
        cellStyle: (params) => {
          if (params.data.contract_status == 'Active') {
            return { backgroundColor: 'lightblue' };
          } else if (params.data.contract_status == 'Waiting') {
            return { backgroundColor: 'lightgray' };
          }
          return {};
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
            // {
            //   filter: 'agSetColumnFilter',
            // },
          ],
        },
      },
      {
        headerName: 'Grade', field: 'grade_gar', filter: 'agSetColumnFilter',
        cellStyle: (params) => {
          if (params.data.contract_status == 'Active') {
            return { backgroundColor: 'lightblue' };
          } else if (params.data.contract_status == 'Waiting') {
            return { backgroundColor: 'lightgray' };
          }
          return {};
        },
      },
      {
        headerName: 'Quantity', field: 'contract_quantity',
        // cellStyle: (params) => {
        //   return {
        //     textAlign: 'right',
        //   };
        // },
        cellStyle: (params) => {
          if (params.data.contract_status == 'Active') {
            return { backgroundColor: 'lightblue' };
          } else if (params.data.contract_status == 'Waiting') {
            return { backgroundColor: 'lightgray' };
          }
          return {};
        },
        valueGetter: p => Number(p.data.contract_quantity),
        valueFormatter: p => p.value ? p.value.toLocaleString('en-US', { minimumFractionDigits: 0, maximumFractionDigits: 0 }) : '-',
        filter: 'agMultiColumnFilter',
        filterParams: {
          filters: [
            // { filter: 'agNumberColumnFilter' },
            { filter: 'agSetColumnFilter' },
          ]
        }
      },
      {
        headerName: '2023', field: 'c2023',
        cellStyle: (params) => {
          if (params.data.contract_status == 'Active') {
            return { backgroundColor: 'lightblue' };
          } else if (params.data.contract_status == 'Waiting') {
            return { backgroundColor: 'lightgray' };
          }
          return {};
        },
        valueGetter: p => Number(p.data.c2023),
        valueFormatter: p => p.value ? p.value.toLocaleString('en-US', { minimumFractionDigits: 0, maximumFractionDigits: 0 }) : '-',
      },
      {
        headerName: '2024', field: 'c2024',
        cellStyle: (params) => {
          if (params.data.contract_status == 'Active') {
            return { backgroundColor: 'lightblue' };
          } else if (params.data.contract_status == 'Waiting') {
            return { backgroundColor: 'lightgray' };
          }
          return {};
        },
        valueGetter: p => Number(p.data.c2024),
        valueFormatter: p => p.value ? p.value.toLocaleString('en-US', { minimumFractionDigits: 0, maximumFractionDigits: 0 }) : '-',
      },
      {
        headerName: 'Today', field: 'date',
        cellStyle: (params) => {
          if (params.data.contract_status == 'Active') {
            return { backgroundColor: 'lightblue' };
          } else if (params.data.contract_status == 'Waiting') {
            return { backgroundColor: 'lightgray' };
          }
          return {};
        },
        valueGetter: p => Number(p.data.date),
        valueFormatter: p => p.value ? p.value.toLocaleString('en-US', { minimumFractionDigits: 0, maximumFractionDigits: 0 }) : '-',
      },
      {
        headerName: 'Loading', field: 'loaded',
        cellStyle: (params) => {
          if (params.data.contract_status == 'Active') {
            return { backgroundColor: 'lightblue' };
          } else if (params.data.contract_status == 'Waiting') {
            return { backgroundColor: 'lightgray' };
          }
          return {};
        },
        valueGetter: p => Number(p.data.loaded),
        valueFormatter: p => p.value ? p.value.toLocaleString('en-US', { minimumFractionDigits: 0, maximumFractionDigits: 0 }) : '-',
      },
      {
        headerName: 'Remaining', field: 'reamin',
        cellStyle: (params) => {
          if (params.data.contract_status == 'Active') {
            return { backgroundColor: 'lightblue' };
          } else if (params.data.contract_status == 'Waiting') {
            return { backgroundColor: 'lightgray' };
          }
          return {};
        },
        valueGetter: p => Number(p.data.remain),
        valueFormatter: p => p.value ? p.value.toLocaleString('en-US', { minimumFractionDigits: 0, maximumFractionDigits: 0 }) : '-',
      },
      {
        headerName: 'Complete', field: 'pct',
        cellStyle: (params) => {
          if (params.data.contract_status == 'Active') {
            return { backgroundColor: 'lightblue' };
          } else if (params.data.contract_status == 'Waiting') {
            return { backgroundColor: 'lightgray' };
          }
          return {};
        },
        valueGetter: p => Number(p.data.pct),
        valueFormatter: p => p.value ? p.value.toLocaleString('en-US', { minimumFractionDigits: 2, maximumFractionDigits: 2 }) + '%' : '-',
      },
      {
        headerName: 'Remark', field: 'remark', filter: 'agSetColumnFilter',
        cellStyle: (params) => {
          if (params.data.contract_status == 'Active') {
            return { backgroundColor: 'lightblue' };
          } else if (params.data.contract_status == 'Waiting') {
            return { backgroundColor: 'lightgray' };
          }
          return {};
        },
        cellRenderer: p => {
          if (p.value == 'Under') {
            return p.value
          } else if (p.value == 'Over') {
            return '<span class="text-danger">' + p.value + '</span>'
          } else {
            return '-'
          }
        }
      },
      {
        headerName: 'Status', field: 'contract_status', filter: 'agSetColumnFilter',
        cellStyle: (params) => {
          if (params.data.contract_status == 'Active') {
            return { backgroundColor: 'lightblue' };
          } else if (params.data.contract_status == 'Waiting') {
            return { backgroundColor: 'lightgray' };
          }
          return {};
        },
        cellRenderer: p => {
          if (p.value == 'Active') {
            return '<span class="text-danger fw-medium">' + p.value + '</span>'
          } else if (p.value == 'Waiting') {
            return '<span class="text-secondary fw-medium">' + p.value + '</span>'
          }
          return p.value
        }
      },],

      defaultColDef: {
        sortable: true,
        resizable: true,
        flex: 1,
        filterParams: { buttons: ['reset'] },
        popupParent: document.body,
        minWidth: 80,
        cellClassRules: { 'pointer': 'true' },
        menuTabs: ['filterMenuTab', 'generalMenuTab', 'columnsMenuTab']
      },
    };
  },

  mounted() {
    flatpickr(".flatpickr-single", {
      altInput: true,
      altFormat: 'd-m-Y'
    });

    setInterval(() => {
      this.autoRefresh();
    }, 300000);
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
      const dash10 = await this.getDash10();

      const year = await axios.get('api/sales/sale-year', { headers: { Authorization: 'Bearer ' + this.authStore.getToken } });
      this.lkYear = year.data;

      const sub = 'M01S01';
      const subData = await axios.get(`api/auth/auth-action?submenu=${sub}`, { headers: { Authorization: 'Bearer ' + this.authStore.getToken } });
      this.auth = subData.data[0];

      this.loading = false;
    },

    async getCurrentDateTime() {
      // try {

      this.selectDate = moment(new Date().getTime()).format('YYYY-MM-DD');
      const now = new Date();
      const hours = now.getHours().toString().padStart(2, '0');
      const minutes = now.getMinutes().toString().padStart(2, '0');
      const seconds = now.getSeconds().toString().padStart(2, '0');
      this.refreshTime = `${hours}:${minutes}:${seconds}`;

      // const lastDate = await axios.get('api/dashboard-sale/last-date', { headers: { Authorization: 'Bearer ' + this.authStore.getToken } });
      // this.selectDate = moment(lastDate.data[0].lastDate).format('YYYY-MM-DD');
      // this.refreshTime = lastDate.data[0].lastTime;

      // const fp = flatpickr('#select-date', {
      //   altInput: true,
      //   altFormat: 'd-m-Y'
      // });
      // fp.setDate(this.selectDate);

      // } catch (error) {  
      //   if (error.response.status === 401) {
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
      // const fp = flatpickr("#select-date");
      // fp.clear();
      const time = await this.getCurrentDateTime();
      const dash = await this.getDashboards();
      this.loading = false;
    },

    async autoRefresh() {
      const time = await this.getCurrentDateTime();
      const dash = await this.getDashboards();
    },

    async onSelectDate() {
      this.loading = true;
      // this.refreshTime = '';
      const dash1 = await this.getDashboards();
      this.loading = false;
    },


    async getDashboards() {
      try {

        const dash1 = await axios.get(`api/dashboard-sale/dashboard1?date=${this.selectDate}`, { headers: { Authorization: 'Bearer ' + this.authStore.getToken } });
        this.dash1Data = dash1.data;

        const dash2 = await axios.get(`api/dashboard-sale/dashboard2?date=${this.selectDate}`, { headers: { Authorization: 'Bearer ' + this.authStore.getToken } });
        this.dash2Data = dash2.data;

        this.selYear = moment(new Date().getTime()).format('YYYY');
        const dash3 = await axios.get(`api/dashboard-sale/dashboard3?year=${this.selYear}`, { headers: { Authorization: 'Bearer ' + this.authStore.getToken } });
        this.dash3Data = dash3.data;
        let dome = this.dash3Data.filter((e) => e.DestPort == 'Domestic');
        this.dash3Dome = dome;
        let over = this.dash3Data.filter((e) => e.DestPort == 'Oversea');
        this.dash3Over = over;
        let domeTotal = this.dash3Data.find((e) => e.DestPort == 'dom_total');
        this.dash3DomeTotal = domeTotal;
        let overTotal = this.dash3Data.find((e) => e.DestPort == 'over_total');
        this.dash3OverTotal = overTotal;
        let dash3total = this.dash3Data.find((e) => e.DestPort == 'total');
        this.dash3DataTotal = dash3total;

        const dash4 = await axios.get(`api/dashboard-sale/dashboard4?date=${this.selectDate}`, { headers: { Authorization: 'Bearer ' + this.authStore.getToken } });
        this.dash4Data = dash4.data;
        let dash4Filter = this.dash4Data.filter((e) => e.DestPort != 'total');
        this.dash4Filter = dash4Filter;
        let dash4total = this.dash4Data.find((e) => e.DestPort == 'total');
        this.dash4Total = dash4total;

        const dash5 = await axios.get(`api/dashboard-sale/dashboard5?date=${this.selectDate}`, { headers: { Authorization: 'Bearer ' + this.authStore.getToken } });
        this.dash5Data = dash5.data;
        let dash5Filter = this.dash5Data.filter((e) => e.grade != 'total');
        this.dash5Filter = dash5Filter;
        let dash5total = this.dash5Data.find((e) => e.grade == 'total');
        this.dash5Total = dash5total;

        const dash6 = await axios.get(`api/dashboard-sale/dashboard6?date=${this.selectDate}`, { headers: { Authorization: 'Bearer ' + this.authStore.getToken } });
        this.dash6Data = dash6.data;
        let dash6Filter = this.dash6Data.filter((e) => e.DestPort != 'total');
        this.dash6Filter = dash6Filter;
        let dash6total = this.dash6Data.find((e) => e.DestPort == 'total');
        this.dash6Total = dash6total;

        const dash7 = await axios.get(`api/dashboard-sale/dashboard7?date=${this.selectDate}`, { headers: { Authorization: 'Bearer ' + this.authStore.getToken } });
        this.dash7Data = dash7.data;
        let dash7Filter = this.dash7Data.filter((e) => e.grade != 'total');
        this.dash7Filter = dash7Filter;
        let dash7total = this.dash7Data.find((e) => e.grade == 'total');
        this.dash7Total = dash7total;

        const dash8 = await axios.get(`api/dashboard-sale/dashboard8?date=${this.selectDate}`, { headers: { Authorization: 'Bearer ' + this.authStore.getToken } });
        this.dash8Data = dash8.data;

        const dash9 = await axios.get(`api/dashboard-sale/dashboard9?date=${this.selectDate}`, { headers: { Authorization: 'Bearer ' + this.authStore.getToken } });
        this.dash9Data = dash9.data;

        const currentDate = new Date();
        let y = currentDate.getFullYear();
        let m = String(currentDate.getMonth() + 1).padStart(2, '0');
        this.selectMonth = `${y}-${m}`;
        const dash10 = await this.getDash10();

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

    async getDash3(y) {
      this.dash3Data = [];
      this.dash3Dome = [];
      this.dash3Over = [];
      this.dash3DomeTotal = '';
      this.dash3OverTotal = '';
      this.dash3DataTotal = '';

      this.selYear = y;
      const dash3 = await axios.get(`api/dashboard-sale/dashboard3?year=${this.selYear}`, { headers: { Authorization: 'Bearer ' + this.authStore.getToken } });
      this.dash3Data = dash3.data;

      let dome = this.dash3Data.filter((e) => e.DestPort == 'Domestic');
      this.dash3Dome = dome;

      let over = this.dash3Data.filter((e) => e.DestPort == 'Oversea');
      this.dash3Over = over;

      let domeTotal = this.dash3Data.find((e) => e.DestPort == 'dom_total');
      this.dash3DomeTotal = domeTotal;
      let overTotal = this.dash3Data.find((e) => e.DestPort == 'over_total');
      this.dash3OverTotal = overTotal;
      let dash3total = this.dash3Data.find((e) => e.DestPort == 'total');
      this.dash3DataTotal = dash3total;
    },

    async getDash10() {
      this.dash10Data = [];
      this.dash10Dome = [];
      this.dash10Over = [];
      this.dash10DomeTotal = '';
      this.dash10OverTotal = '';
      this.dash10DataTotal = '';
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

      const dash10 = await axios.get(`api/dashboard-sale/dashboard10?dateFr=${dateFr}&dateTo=${dateTo}`, { headers: { Authorization: 'Bearer ' + this.authStore.getToken } });
      this.dash10Data = dash10.data;
      let dome = this.dash10Data.filter((e) => e.DestPort == 'domestic');
      this.dash10Dome = dome;
      let over = this.dash10Data.filter((e) => e.DestPort == 'oversea');
      this.dash10Over = over;
      let domeTotal = this.dash10Data.find((e) => e.DestPort == 'dom_total');
      this.dash10DomeTotal = domeTotal;
      let overTotal = this.dash10Data.find((e) => e.DestPort == 'over_total');
      this.dash10OverTotal = overTotal;
      let dash10total = this.dash10Data.find((e) => e.DestPort == 'total');
      this.dash10DataTotal = dash10total;

    },

    cellCicked(e) {
      if (this.auth.edit == 1) {
        document.getElementById('btn-hide').classList.remove('d-none')
        this.contId = e.data.contract_id;
      }
    },

    async hideContract() {
      const sent = await axios.post(`api/dashboard-sale/hide-contract?id=${this.contId}`);

      // this.dash2Data = [];
      let curDate = moment(new Date().getTime()).format('YYYY-MM-DD');
      const dash2 = await axios.get(`api/dashboard-sale/dashboard2?date=${curDate}`, { headers: { Authorization: 'Bearer ' + this.authStore.getToken } });
      this.dash2Data = dash2.data;

      document.getElementById('btn-hide').classList.add('d-none')

    },

    headDate(text) {
      if (text) {
        return moment(text.split('d')[1]).format("YYYYMMDD");
      }
    },

    headDate2(text) {
      if (text) {
        return moment(text.split('d')[1]).format("YYYY/MM/DD");
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

    exportData5() {
      document.getElementById('export5').classList.remove('d-none');
      const table2excel = new Table2Excel();
      table2excel.export(document.getElementById('export5'));
      document.getElementById('export5').classList.add('d-none');
    },


  },

  created() {
    this.onLoad();
  }
};
</script>
