<template>
  <div>
    <div class="app-menu navbar-menu">
      <!-- LOGO -->
      <div class="navbar-brand-box">
        <!-- Dark Logo-->
        <a href="index.html" class="logo logo-dark">
          <span class="logo-sm">
            <img src="/public/assets/images/logo-dark-sm.png" alt="" height="22" />
          </span>
          <span class="logo-lg">
            <img src="/public/assets/images/logo-dark.png" alt="" height="45" />
          </span>
        </a>
        <!-- Light Logo-->
        <a href="index.html" class="logo logo-light">
          <span class="logo-sm">
            <img src="/public/assets/images/logo-light-sm.png" alt="" height="22" />
          </span>
          <span class="logo-lg">
            <img src="/public/assets/images/logo-light.png" alt="" height="45" />
          </span>
        </a>
        <button type="button" class="btn btn-sm p-0 fs-20 header-item float-end btn-vertical-sm-hover" id="vertical-hover">
          <i class="ri-record-circle-line"></i>
        </button>
      </div>

      <!-- Profile on sidebar -->
      <div class="dropdown sidebar-user m-1 rounded">
        <button type="button" class="btn material-shadow-none" id="page-header-user-dropdown" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          <span class="d-flex align-items-center gap-2">
            <img class="rounded header-profile-user" src="/public/assets/images/users/avatar-1.jpg" alt="Header Avatar" />
            <span class="text-start">
              <span class="d-block fw-medium sidebar-user-name-text">Chamlong</span>
              <span class="d-block fs-14 sidebar-user-name-sub-text"><i class="ri ri-circle-fill fs-10 text-success align-baseline"></i>
                <span class="align-middle">Online</span></span>
            </span>
          </span>
        </button>
        <div class="dropdown-menu dropdown-menu-end">
          <h6 class="dropdown-header">Welcome Anna!</h6>
          <a class="dropdown-item" href="pages-profile.html"><i class="mdi mdi-account-circle text-muted fs-16 align-middle me-1"></i>
            <span class="align-middle">Profile</span></a>
          <a class="dropdown-item" href="apps-chat.html"><i class="mdi mdi-message-text-outline text-muted fs-16 align-middle me-1"></i>
            <span class="align-middle">Messages</span></a>
          <a class="dropdown-item" href="apps-tasks-kanban.html"><i class="mdi mdi-calendar-check-outline text-muted fs-16 align-middle me-1"></i>
            <span class="align-middle">Taskboard</span></a>
          <a class="dropdown-item" href="pages-faqs.html"><i class="mdi mdi-lifebuoy text-muted fs-16 align-middle me-1"></i>
            <span class="align-middle">Help</span></a>
          <div class="dropdown-divider"></div>
          <a class="dropdown-item" href="pages-profile.html"><i class="mdi mdi-wallet text-muted fs-16 align-middle me-1"></i>
            <span class="align-middle">Balance : <b>$5971.67</b></span></a>
          <a class="dropdown-item" href="pages-profile-settings.html"><span class="badge bg-success-subtle text-success mt-1 float-end">New</span><i class="mdi mdi-cog-outline text-muted fs-16 align-middle me-1"></i>
            <span class="align-middle">Settings</span></a>
          <a class="dropdown-item" href="auth-lockscreen-basic.html"><i class="mdi mdi-lock text-muted fs-16 align-middle me-1"></i>
            <span class="align-middle">Lock screen</span></a>
          <a class="dropdown-item" href="auth-logout-basic.html"><i class="mdi mdi-logout text-muted fs-16 align-middle me-1"></i>
            <span class="align-middle" data-key="t-logout">Logout</span></a>
        </div>
      </div>

      <!-- Menu -->
      <div id="scrollbar">
        <div class="container-fluid">
          <div id="two-column-menu"></div>
          <ul class="navbar-nav" id="navbar-nav">
            <li class="menu-title">
              <span data-key="t-menu">{{ $t('menu') }}</span>
            </li>
            <li class="nav-item">
              <router-link class="nav-link menu-link active" id="m-menu-1" to="/" @click="singleMenu('m-menu-1')">
                <i class="ri-home-4-line"></i><span>Home</span>
              </router-link>
            </li>

            <!-- Dashboards -->
            <li v-if="auth.M01" class="nav-item">
              <a class="nav-link menu-link" id="m-menu-2" href="#dashboard" data-bs-toggle="collapse" role="button" aria-expanded="false" @click="onMenuClick()">
                <i class="ri-dashboard-line"></i><span>{{ $t('dashboard') }}</span>
              </a>
              <div class="collapse menu-dropdown" id="dashboard">
                <ul class="nav nav-sm flex-column">
                  <li v-if="auth.M01S01 == 1" class="nav-item" @click="mobileMode('m-menu-2')"><router-link class="nav-link" to="/dashboard-sale">Coal Sales</router-link></li>
                  <li v-if="auth.M01S02 == 1" class="nav-item" @click="mobileMode('m-menu-2')"><router-link class="nav-link" to="/dashboard-production">Productions</router-link></li>
                  <!-- <li v-if="auth.M01S01" class="nav-item" @click="mobileMode"><router-link class="nav-link" to="/">Ecommerce</router-link></li> -->
                  <!-- <li v-if="auth.M01S01" class="nav-item" @click="mobileMode"><router-link class="nav-link" to="/">Crypto</router-link></li> -->
                  <li v-if="auth.M01S05" class="nav-item" @click="mobileMode('m-menu-2')"><router-link class="nav-link" to="/dashboard-sale-ldb">Coal Sales-LDB</router-link></li>
                </ul>
              </div>
            </li>

            <!-- Control Tower -->
            <li v-if="auth.M13" class="nav-item">
              <a class="nav-link menu-link" id="m-menu-2" href="#control-tower" data-bs-toggle="collapse" role="button" aria-expanded="false" @click="onMenuClick()">
                <i class="ri-bar-chart-2-line"></i><span>{{ $t('control-tower') }}</span>
              </a>
              <div class="collapse menu-dropdown" id="dashboard2">
                <div class="ms-3 fs-6 fw-bold text-white">Overview</div>
                <ul class="nav nav-sm flex-column">
                  <li class="nav-item" @click="mobileMode('m-menu-2')"><router-link class="nav-link" to="/control-tower">Control Tower</router-link></li>
                  <!-- <li class="nav-item" @click="mobileMode('m-menu-2')"><router-link class="nav-link" to="/value-chain">Value Chain</router-link></li> -->
                </ul>

                <div class="ms-3 mt-4 fs-6 fw-bold text-white">Drill Down</div>
                <ul class="nav nav-sm flex-column">
                  <li class="nav-item" @click="mobileMode('m-menu-2')"><router-link class="nav-link" to="/drilldown-mining">Mining</router-link></li>
                  <li class="nav-item" @click="mobileMode('m-menu-2')"><router-link class="nav-link" to="/drilldown-processing">Processing</router-link></li>
                </ul>
              </div>

            </li>

            <!-- Admin tasks -->
            <li v-if="auth.M02" class="nav-item">
              <a class="nav-link menu-link" id="m-menu-3" href="#empoyee" data-bs-toggle="collapse" role="button" aria-expanded="false" @click="onMenuClick()">
                <i class="ri-group-line"></i><span>Employee</span>
              </a>
              <div class="collapse menu-dropdown" id="empoyee">
                <ul class="nav nav-sm flex-column">
                  <li v-if="auth.M02S01" class="nav-item" @click="mobileMode('m-menu-3')"><router-link class="nav-link" to="/employee-name">Name List</router-link></li>
                  <li v-if="auth.M02S02" class="nav-item" @click="mobileMode('m-menu-3')"><router-link class="nav-link" to="/employee-roster">Roster</router-link></li>
                  <li v-if="auth.M02S03" class="nav-item" @click="mobileMode('m-menu-3')"><router-link class="nav-link" to="/employee-fingerprint">Fingerprint</router-link></li>
                  <li v-if="auth.M02S04" class="nav-item" @click="mobileMode('m-menu-3')"><router-link class="nav-link" to="/employee-overtime">Overtime</router-link></li>
                  <li v-if="auth.M02S05" class="nav-item" @click="mobileMode('m-menu-3')"><router-link class="nav-link" to="/employee-annualleave">Annual Leave</router-link></li>
                  <li v-if="auth.M02S06" class="nav-item" @click="mobileMode('m-menu-3')"><router-link class="nav-link" to="/employee-dayleave">Days Leave</router-link></li>
                  <li v-if="auth.M02S07" class="nav-item" @click="mobileMode('m-menu-3')"><router-link class="nav-link" to="/employee-code">Code</router-link></li>
                  <!-- <li class="nav-item">
                    <a class="nav-link" href="#surface" data-bs-toggle="collapse" role="button" aria-expanded="false" @click="onMenuClick()">Code</a>
                    <div class="collapse menu-dropdown" id="surface">
                      <ul class="nav nav-sm flex-column">
                        <li v-if="auth.M02S07" class="nav-item" @click="mobileMode('m-menu-3')"><router-link class="nav-link" to="/employee-code">General</router-link></li>
                        <li class="nav-item" @click="mobileMode('m-menu-3')"><router-link class="nav-link" to="/production-geodata">Company</router-link></li>
                        <li class="nav-item" @click="mobileMode('m-menu-3')"><router-link class="nav-link" to="/production-geodata">Country</router-link></li>
                      </ul>
                    </div>
                  </li> -->
                </ul>
              </div>
            </li>

            <!-- Fuels -->
            <li v-if="auth.M03" class="nav-item">
              <a class="nav-link menu-link" id="m-menu-4" href="#fuels" data-bs-toggle="collapse" role="button" aria-expanded="false" @click="onMenuClick()">
                <i class="ri-gas-station-line"></i><span>Fuels</span>
              </a>
              <div class="collapse menu-dropdown" id="fuels">
                <ul class="nav nav-sm flex-column">
                  <li v-if="auth.M03S01" class="nav-item" @click="mobileMode('m-menu-4')"><router-link class="nav-link" to="/">Reservation</router-link></li>
                  <li v-if="auth.M03S02" class="nav-item" @click="mobileMode('m-menu-4')"><router-link class="nav-link" to="/">Code</router-link></li>
                </ul>
              </div>
            </li>

            <!-- Geology -->
            <li v-if="auth.M04" class="nav-item">
              <a class="nav-link menu-link" id="m-menu-5" href="#geology" data-bs-toggle="collapse" role="button" aria-expanded="false" @click="onMenuClick()">
                <i class="mdi mdi-pickaxe"></i> <span data-key="t-authentication">Geology</span>
                <!-- <i class="mdi mdi-pickaxe mdi-rotate-270"></i> <span data-key="t-authentication">Geology</span> -->
              </a>
              <div class="collapse menu-dropdown" id="geology">
                <ul class="nav nav-sm flex-column">
                  <li class="nav-item">
                    <a v-if="auth.M04S01" class="nav-link" href="#generals" data-bs-toggle="collapse" role="button" aria-expanded="false" @click="onMenuClick()">General</a>
                    <div class="collapse menu-dropdown" id="generals">
                      <ul class="nav nav-sm flex-column">
                        <li v-if="auth.M04S02" class="nav-item" @click="mobileMode('m-menu-5')"><router-link class="nav-link" to="/sample-ticket">Sample Ticket</router-link></li>
                      </ul>
                    </div>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" href="#drilling" data-bs-toggle="collapse" role="button" aria-expanded="false" @click="onMenuClick()">Drilling</a>
                    <div class="collapse menu-dropdown" id="drilling">
                      <ul class="nav nav-sm flex-column">
                        <li class="nav-item" @click="mobileMode('m-menu-5')"><router-link class="nav-link" to="/production-geodata">Data Entry</router-link></li>
                      </ul>
                    </div>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" href="#trenching" data-bs-toggle="collapse" role="button" aria-expanded="false" @click="onMenuClick()">Trenching</a>
                    <div class="collapse menu-dropdown" id="trenching">
                      <ul class="nav nav-sm flex-column">
                        <li class="nav-item" @click="mobileMode('m-menu-5')"><router-link class="nav-link" to="/production-geodata">Data Entry</router-link></li>
                      </ul>
                    </div>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" href="#surface" data-bs-toggle="collapse" role="button" aria-expanded="false" @click="onMenuClick()">Surface</a>
                    <div class="collapse menu-dropdown" id="surface">
                      <ul class="nav nav-sm flex-column">
                        <li class="nav-item" @click="mobileMode"><router-link class="nav-link" to="/production-geodata">Mapping</router-link></li>
                        <li class="nav-item" @click="mobileMode"><router-link class="nav-link" to="/production-geodata">Sampling</router-link></li>
                      </ul>
                    </div>
                  </li>
                </ul>
              </div>
            </li>

            <!-- Productions -->
            <li v-if="auth.M05" class="nav-item">
              <a class="nav-link menu-link" id="m-menu-6" href="#productions" data-bs-toggle="collapse" role="button" aria-expanded="false" @click="onMenuClick()">
                <i class="mdi mdi-gold"></i> <span data-key="t-authentication">Productions</span>
              </a>
              <div class="collapse menu-dropdown" id="productions">
                <!-- <ul class="nav nav-sm flex-column">
                  <li v-if="auth.M05S01" class="nav-item" @click="mobileMode"><router-link class="nav-link" to="/production/geo-data">Production-Geo</router-link></li>
                  <li v-if="auth.M05S02" class="nav-item" @click="mobileMode"><router-link class="nav-link" to="/production/geo-report">Code</router-link></li>
                </ul> -->

                <ul class="nav nav-sm flex-column">
                  <li v-if="auth.M05S01" class="nav-item">
                    <a class="nav-link" href="#prod-geology" data-bs-toggle="collapse" role="button" aria-expanded="false" @click="onMenuClick()">Geology Dept.</a>
                    <div class="collapse menu-dropdown" id="prod-geology">
                      <ul class="nav nav-sm flex-column">
                        <li v-if="auth.M05S02" class="nav-item" @click="mobileMode('m-menu-6')"><router-link class="nav-link" to="/production-geodata">Data</router-link></li>
                        <li v-if="auth.M05S03" class="nav-item" @click="mobileMode('m-menu-6')"><router-link class="nav-link" to="/production-georeport">Report</router-link></li>
                      </ul>
                    </div>
                  </li>
                  <!-- <li v-if="auth.M05S02" class="nav-item">
                    <a href="#sidebarErrors" class="nav-link" data-bs-toggle="collapse" role="button" aria-expanded="false" @click="onMenuClick()">Processing</a>
                    <div class="collapse menu-dropdown" id="sidebarErrors">
                      <ul class="nav nav-sm flex-column">
                        <li class="nav-item"><a href="auth-404-basic.html" class="nav-link" data-key="t-404-basic">404 Basic</a></li>
                        <li class="nav-item"><a href="auth-404-cover.html" class="nav-link" data-key="t-404-cover">404 Cover</a></li>
                      </ul>
                    </div>
                  </li> -->
                </ul>
              </div>
            </li>

            <!-- Finance Accounting -->
            <li v-if="auth.M06" class="nav-item">
              <a class="nav-link menu-link" id="m-menu-7" href="#accounting" data-bs-toggle="collapse" role="button" aria-expanded="false" @click="onMenuClick()">
                <i class="ri-money-dollar-box-line"></i><span>Accounting</span>
              </a>
              <div class="collapse menu-dropdown" id="accounting">
                <ul class="nav nav-sm flex-column">
                  <li v-if="auth.M06S01" class="nav-item" @click="mobileMode('m-menu-7')"><router-link class="nav-link" to="/sale-data">Sales Data</router-link></li>
                  <li v-if="auth.M06S02" class="nav-item" @click="mobileMode('m-menu-7')"><router-link class="nav-link" to="/sale-customer">Customer</router-link></li>
                  <li v-if="auth.M06S03" class="nav-item" @click="mobileMode('m-menu-7')"><router-link class="nav-link" to="/sale-contract">Contract</router-link></li>
                  <li v-if="auth.M06S04" class="nav-item" @click="mobileMode('m-menu-7')"><router-link class="nav-link" to="/sale-code">Code</router-link></li>
                </ul>
              </div>
            </li>

            <!-- Sales -->
            <li v-if="auth.M07" class="nav-item">
              <a class="nav-link menu-link" id="m-menu-8" href="#sales" data-bs-toggle="collapse" role="button" aria-expanded="false" @click="onMenuClick()">
                <!-- <i class="mdi mdi-chart-line"></i><span>Marketing</span> -->
                <i class="ri-shopping-cart-2-line"></i><span>Marketing</span>
              </a>
              <div class="collapse menu-dropdown" id="sales">
                <ul class="nav nav-sm flex-column">
                  <li v-if="auth.M07S02" class="nav-item" @click="mobileMode('m-menu-8')"><router-link class="nav-link" to="/sale-customer">Customers</router-link></li>
                  <li v-if="auth.M07S03" class="nav-item" @click="mobileMode('m-menu-8')"><router-link class="nav-link" to="/sale-contract">Contracts</router-link></li>
                  <li v-if="auth.M07S01" class="nav-item" @click="mobileMode('m-menu-8')"><router-link class="nav-link" to="/sale-data">Sales Data</router-link></li>
                  <li v-if="auth.M07S05" class="nav-item" @click="mobileMode('m-menu-8')"><router-link class="nav-link" to="/sale-filemanager">File Manager</router-link></li>
                  <li v-if="auth.M07S04" class="nav-item" @click="mobileMode('m-menu-8')"><router-link class="nav-link" to="/sale-code">Code</router-link></li>
                </ul>
              </div>
            </li>

            <!-- Safety -->
            <li v-if="auth.M08" class="nav-item">
              <a class="nav-link menu-link" id="m-menu-9" href="#safety" data-bs-toggle="collapse" role="button" aria-expanded="false" @click="onMenuClick()">
                <i class="bx bx-hard-hat"></i><span>Safety</span>
              </a>
              <div class="collapse menu-dropdown" id="safety">
                <ul class="nav nav-sm flex-column">
                  <li v-if="auth.M08S01" class="nav-item" @click="mobileMode('m-menu-9')"><router-link class="nav-link" to="/safety-incident">Incidents</router-link></li>
                  <li v-if="auth.M08S02" class="nav-item" @click="mobileMode('m-menu-9')"><router-link class="nav-link" to="/safety-code">Code</router-link></li>
                </ul>
              </div>
            </li>

            <!-- Clinic -->
            <li v-if="auth.M09" class="nav-item">
              <a class="nav-link menu-link" id="m-menu-10" href="#clinic" data-bs-toggle="collapse" role="button" aria-expanded="false" @click="onMenuClick()">
                <i class="mdi mdi-bed-outline"></i><span>Clinic</span>
                <!-- <i class="ri-hospital-line"></i><span>Clinic</span> -->
              </a>
              <div class="collapse menu-dropdown" id="clinic">
                <ul class="nav nav-sm flex-column">
                  <li v-if="auth.M09S01" class="nav-item" @click="mobileMode('m-menu-10')"><router-link class="nav-link" to="/clinic-treatment">Treatments</router-link></li>
                  <li v-if="auth.M09S02" class="nav-item" @click="mobileMode('m-menu-10')"><router-link class="nav-link" to="/clinic-medicine">Medicines</router-link></li>
                  <li v-if="auth.M09S04" class="nav-item" @click="mobileMode('m-menu-10')"><router-link class="nav-link" to="/clinic-store">Medicine Store</router-link></li>
                  <li v-if="auth.M09S03" class="nav-item" @click="mobileMode('m-menu-10')"><router-link class="nav-link" to="/clinic-code">Code</router-link></li>
                </ul>
              </div>
            </li>

            <!-- Authorization -->
            <li v-if="auth.M10" class="nav-item">
              <a class="nav-link menu-link" id="m-menu-11" href="#authorizations" data-bs-toggle="collapse" role="button" aria-expanded="false" @click="onMenuClick()">
                <i class="ri-lock-unlock-line"></i><span>Authorization</span>
              </a>
              <div class="collapse menu-dropdown" id="authorizations">
                <ul class="nav nav-sm flex-column">
                  <li v-if="auth.M10S01" class="nav-item" @click="mobileMode('m-menu-11')"><router-link class="nav-link" to="/authorise">Basic</router-link></li>
                  <li v-if="auth.M10S02" class="nav-item" @click="mobileMode('m-menu-11')"><router-link class="nav-link disabled" to="/">Accounting</router-link></li>
                </ul>
              </div>
            </li>

            <!-- Admin Menu -->
            <li v-if="auth.M11" class="nav-item">
              <a class="nav-link menu-link" id="m-menu-12" href="#admin-menu" data-bs-toggle="collapse" role="button" aria-expanded="false" @click="onMenuClick()">
                <i class="ri-macbook-line"></i><span>Administrator</span>
              </a>
              <div class="collapse menu-dropdown" id="admin-menu">
                <ul class="nav nav-sm flex-column">
                  <li v-if="auth.M11S01" class="nav-item" @click="mobileMode('m-menu-12')"><router-link class="nav-link" to="/admin-menu">Menu</router-link></li>
                  <li v-if="auth.M11S02" class="nav-item" @click="mobileMode('m-menu-12')"><router-link class="nav-link" to="/">Code</router-link></li>
                  <li v-if="auth.M11S03" class="nav-item" @click="mobileMode('m-menu-12')"><router-link class="nav-link" to="/admin-email-register">Email</router-link></li>
                </ul>
              </div>
            </li>

            <li v-if="auth.M12" class="nav-item">
              <router-link class="nav-link menu-link" id="m-menu-13" to="/" @click="singleMenu('m-menu-13')">
                <i class="ri-file-excel-line"></i> <span>Excel Macro</span>
              </router-link>
            </li>

            <!-- <li class="nav-item">
              <a class="nav-link menu-link" href="#sidebarLayouts" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="sidebarLayouts">
                <i class="ri-layout-3-line"></i>
                <span data-key="t-layouts">Layouts</span>
                <span class="badge badge-pill bg-danger" data-key="t-hot">Hot</span>
              </a>
              <div class="collapse menu-dropdown" id="sidebarLayouts">
                <ul class="nav nav-sm flex-column">
                  <li class="nav-item">
                    <a href="layouts-horizontal.html" target="_blank" class="nav-link" data-key="t-horizontal">Horizontal</a>
                  </li>
                  <li class="nav-item">
                    <a href="layouts-detached.html" target="_blank" class="nav-link" data-key="t-detached">Detached</a>
                  </li>
                  <li class="nav-item">
                    <a href="layouts-two-column.html" target="_blank" class="nav-link" data-key="t-two-column">Two Column</a>
                  </li>
                  <li class="nav-item">
                    <a href="layouts-vertical-hovered.html" target="_blank" class="nav-link" data-key="t-hovered">Hovered</a>
                  </li>
                </ul>
              </div>
            </li> -->

            <!-- <li class="menu-title"><i class="ri-more-fill"></i> <span data-key="t-pages">Pages</span></li> -->

            <!-- More -->
            <!-- <li class="nav-item"> <a class="nav-link" href="#sidebarMore" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="sidebarMore"> <i class="ri-briefcase-2-line"></i> <span data-key="t-more">More</span> </a>
              <div class="collapse menu-dropdown" id="sidebarMore">
                <ul class="nav nav-sm flex-column">
                  <li class="nav-item">
                    <a class="nav-link menu-link" href="#sidebarAdvanceUI" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="sidebarAdvanceUI">
                      <i class="ri-stack-line"></i> <span data-key="t-advance-ui">Advance UI</span>
                    </a>
                    <div class="collapse menu-dropdown" id="sidebarAdvanceUI">
                      <ul class="nav nav-sm flex-column">
                        <li class="nav-item">
                          <a href="advance-ui-sweetalerts.html" class="nav-link" data-key="t-sweet-alerts">Sweet Alerts</a>
                        </li>
                        <li class="nav-item">
                          <a href="advance-ui-nestable.html" class="nav-link" data-key="t-nestable-list">Nestable List</a>
                        </li>
                      </ul>
                    </div>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link menu-link" href="widgets.html">
                      <i class="ri-honour-line"></i> <span data-key="t-widgets">Widgets</span>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link menu-link" href="#sidebarForms" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="sidebarForms">
                      <i class="ri-file-list-3-line"></i> <span data-key="t-forms">Forms</span>
                    </a>
                    <div class="collapse menu-dropdown" id="sidebarForms">
                      <ul class="nav nav-sm flex-column">
                        <li class="nav-item">
                          <a href="forms-elements.html" class="nav-link" data-key="t-basic-elements">Basic Elements</a>
                        </li>
                        <li class="nav-item">
                          <a href="forms-select.html" class="nav-link" data-key="t-form-select">Form Select</a>
                        </li>
                      </ul>
                    </div>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link menu-link" href="#sidebarTables" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="sidebarTables">
                      <i class="ri-layout-grid-line"></i> <span data-key="t-tables">Tables</span>
                    </a>
                    <div class="collapse menu-dropdown" id="sidebarTables">
                      <ul class="nav nav-sm flex-column">
                        <li class="nav-item">
                          <a href="tables-basic.html" class="nav-link" data-key="t-basic-tables">Basic Tables</a>
                        </li>
                        <li class="nav-item">
                          <a href="tables-gridjs.html" class="nav-link" data-key="t-grid-js">Grid Js</a>
                        </li>
                      </ul>
                    </div>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link menu-link" href="#sidebarCharts" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="sidebarCharts">
                      <i class="ri-pie-chart-line"></i> <span data-key="t-charts">Charts</span>
                    </a>
                    <div class="collapse menu-dropdown" id="sidebarCharts">
                      <ul class="nav nav-sm flex-column">
                        <li class="nav-item">
                          <a href="#sidebarApexcharts" class="nav-link" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="sidebarApexcharts" data-key="t-apexcharts">Apexcharts</a>
                          <div class="collapse menu-dropdown" id="sidebarApexcharts">
                            <ul class="nav nav-sm flex-column">
                              <li class="nav-item">
                                <a href="charts-apex-line.html" class="nav-link" data-key="t-line">Line</a>
                              </li>
                              <li class="nav-item">
                                <a href="charts-apex-area.html" class="nav-link" data-key="t-area">Area</a>
                              </li>
                              <li class="nav-item">
                                <a href="charts-apex-range-area.html" class="nav-link"><span data-key="t-range-area">Range Area</span> <span class="badge badge-pill bg-success" data-key="t-new">New</span></a>
                              </li>
                              <li class="nav-item">
                                <a href="charts-apex-funnel.html" class="nav-link"><span data-key="t-funnel">Funnel</span> <span class="badge badge-pill bg-success" data-key="t-new">New</span></a>
                              </li>
                            </ul>
                          </div>
                        </li>
                        <li class="nav-item">
                          <a href="charts-chartjs.html" class="nav-link" data-key="t-chartjs">Chartjs</a>
                        </li>
                        <li class="nav-item">
                          <a href="charts-echarts.html" class="nav-link" data-key="t-echarts">Echarts</a>
                        </li>
                      </ul>
                    </div>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link menu-link" href="#sidebarIcons" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="sidebarIcons">
                      <i class="ri-compasses-2-line"></i> <span data-key="t-icons">Icons</span>
                    </a>
                    <div class="collapse menu-dropdown" id="sidebarIcons">
                      <ul class="nav nav-sm flex-column">
                        <li class="nav-item">
                          <a href="icons-remix.html" class="nav-link"><span data-key="t-remix">Remix</span> <span class="badge badge-pill bg-info">v3.6</span></a>
                        </li>
                        <li class="nav-item">
                          <a href="icons-boxicons.html" class="nav-link"><span data-key="t-boxicons">Boxicons</span> <span class="badge badge-pill bg-info">v2.1.4</span></a>
                        </li>
                      </ul>
                    </div>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link menu-link" href="#sidebarMaps" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="sidebarMaps">
                      <i class="ri-map-pin-line"></i> <span data-key="t-maps">Maps</span>
                    </a>
                    <div class="collapse menu-dropdown" id="sidebarMaps">
                      <ul class="nav nav-sm flex-column">
                        <li class="nav-item">
                          <a href="maps-google.html" class="nav-link" data-key="t-google">Google</a>
                        </li>
                        <li class="nav-item">
                          <a href="maps-vector.html" class="nav-link" data-key="t-vector">Vector</a>
                        </li>
                        <li class="nav-item">
                          <a href="maps-leaflet.html" class="nav-link" data-key="t-leaflet">Leaflet</a>
                        </li>
                      </ul>
                    </div>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link menu-link" href="#sidebarMultilevel" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="sidebarMultilevel">
                      <i class="ri-share-line"></i> <span data-key="t-multi-level">Multi Level</span>
                    </a>
                    <div class="collapse menu-dropdown" id="sidebarMultilevel">
                      <ul class="nav nav-sm flex-column">
                        <li class="nav-item">
                          <a href="#" class="nav-link" data-key="t-level-1.1">Level 1.1</a>
                        </li>
                        <li class="nav-item">
                          <a href="#sidebarAccount" class="nav-link" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="sidebarAccount" data-key="t-level-1.2">Level 1.2</a>
                          <div class="collapse menu-dropdown" id="sidebarAccount">
                            <ul class="nav nav-sm flex-column">
                              <li class="nav-item">
                                <a href="#" class="nav-link" data-key="t-level-2.1">Level 2.1</a>
                              </li>
                              <li class="nav-item">
                                <a href="#sidebarCrm" class="nav-link" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="sidebarCrm" data-key="t-level-2.2">Level 2.2</a>
                                <div class="collapse menu-dropdown" id="sidebarCrm">
                                  <ul class="nav nav-sm flex-column">
                                    <li class="nav-item">
                                      <a href="#" class="nav-link" data-key="t-level-3.1">Level 3.1</a>
                                    </li>
                                    <li class="nav-item">
                                      <a href="#" class="nav-link" data-key="t-level-3.2">Level 3.2</a>
                                    </li>
                                  </ul>
                                </div>
                              </li>
                            </ul>
                          </div>
                        </li>
                      </ul>
                    </div>
                  </li>
                </ul>
              </div>
            </li> -->
          </ul>
        </div>
      </div>
      <div class="sidebar-background"></div>
    </div>
    <div class="vertical-overlay" @click="mobileMode"></div>
  </div>
</template>

<script>
import axios from 'axios';
import { useAuthStore } from '../stores/auth.js'

export default {
  name: 'XpplAppSidebar',
  setup() {
    const authStore = useAuthStore();
    return { authStore };
  },

  data() {
    return {
      auth: []
    };
  },

  mounted() {

  },

  methods: {
    authAccess() {
      axios.get('/api/auth/auth-access', { headers: { Authorization: 'Bearer ' + this.authStore.getToken } }).then((response) => {
        this.auth = response.data[0];
      }).catch((error) => {
        console.log(error);
        if (error.response.status == 401) {
          this.authStore.removeToken();
          this.authStore.removeUser();
          localStorage.removeItem('token');
          localStorage.removeItem('user');
          this.$router.push('/login');
        }
      });
    },

    mobileMode(id) {
      document.body.classList.remove('vertical-sidebar-enable');

      const elements = document.querySelectorAll('[id^="m-menu-"]');
      elements.forEach((e) => {
        e.classList.remove('active');
      });

      const e = document.querySelectorAll(".nav-link.menu-link.active");
      Array.from(e).forEach(function (e) {
        e.classList.remove('active')
      })

      document.getElementById(id).classList.add('active');
    },

    singleMenu(id) {

      let c = document.querySelectorAll(".navbar-nav .collapse")
      Array.from(c).forEach(function (c) {
        c.classList.remove("show")
      });

      let e = document.querySelectorAll(".nav-link.menu-link");
      Array.from(e).forEach(function (e) {
        e.hasAttribute("aria-expanded") &&
          e.setAttribute(
            "aria-expanded",
            "false"
          );
      })


      const elements = document.querySelectorAll('[id^="m-menu-"]');
      elements.forEach((e) => {
        e.classList.remove('active');
      });
      document.getElementById(id).classList.add('active');
      document.body.classList.remove('vertical-sidebar-enable');




      // console.log(e)
    },

    onMenuClick() {
      // const ids = ["dashboard", "adminTask", "hotel", "fuel"];
      // ids.forEach((element) => {
      //   if (element != id) {
      //     document.getElementById(element).classList.remove("show");
      //     document.querySelector("a[href='#" + element + "']").setAttribute("aria-expanded", "false");
      //   }
      // });



      var e;
      document.querySelectorAll(".navbar-nav .collapse") &&
        ((e = document.querySelectorAll(".navbar-nav .collapse")),
          Array.from(e).forEach(function (t) {
            var a = new bootstrap.Collapse(t, { toggle: !1 });
            t.addEventListener("show.bs.collapse", function (e) {
              e.stopPropagation();
              var e = t.parentElement.closest(".collapse");
              e
                ? ((e = e.querySelectorAll(".collapse")),
                  Array.from(e).forEach(function (e) {
                    e = bootstrap.Collapse.getInstance(e);
                    e !== a && e.hide();
                  }))
                : ((e = (function (e) {
                  for (var t = [], a = e.parentNode.firstChild; a;)
                    1 === a.nodeType && a !== e && t.push(a),
                      (a = a.nextSibling);
                  return t;
                })(t.parentElement)),
                  Array.from(e).forEach(function (e) {
                    2 < e.childNodes.length &&
                      e.firstElementChild.setAttribute(
                        "aria-expanded",
                        "false"
                      );
                    e = e.querySelectorAll("*[id]");
                    Array.from(e).forEach(function (e) {
                      e.classList.remove("show"), 2 < e.childNodes.length && ((e = e.querySelectorAll("ul li a")),
                        Array.from(e).forEach(function (e) {
                          e.hasAttribute("aria-expanded") &&
                            e.setAttribute(
                              "aria-expanded",
                              "false"
                            );
                        }));
                    });
                  }));
            }),
              t.addEventListener("hide.bs.collapse", function (e) {
                e.stopPropagation();
                e = t.querySelectorAll(".collapse");
                Array.from(e).forEach(function (e) {
                  (childCollapseInstance = bootstrap.Collapse.getInstance(e)).hide();
                });
              });
          }));
    },
  },

  created() {
    console.log("Sidebar created");
    console.log(this.authStore.getToken);
    if (this.authStore.getToken) {
      this.authAccess();
    }
  },
};
</script>

<style>
*::-webkit-scrollbar {
  width: 6px;
  height: 6px;
  transition: .3s background;
}

::-webkit-scrollbar-thumb {
  background: #e1e6f1;
  /* border-bottom-left-radius: 10px;
  border-bottom-right-radius: 10px;
  border-top-left-radius: 10px;
  border-top-right-radius: 10px; */
}
</style>