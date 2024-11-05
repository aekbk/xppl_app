<template>
  <div>
    <div class="offcanvas offcanvas-end border-0" tabindex="-1" id="theme-settings-offcanvas">
      <div class="d-flex align-items-center bg-primary bg-gradient p-3 offcanvas-header">
        <h5 class="m-0 me-2 text-white">Theme Customizer</h5>
        <button type="button" class="btn-close btn-close-white ms-auto" id="customizerclose-btn" data-bs-dismiss="offcanvas" aria-label="Close"></button>
      </div>
      <div class="offcanvas-body p-0">
        <div data-simplebar class="h-100 simplebar-scrollable-y">
          <div class="simplebar-wrapper" style="margin: 0px">
            <div class="simplebar-height-auto-observer-wrapper">
              <div class="simplebar-height-auto-observer"></div>
            </div>
            <div class="simplebar-mask">
              <div class="simplebar-offset" style="right: 0px; bottom: 0px">
                <div class="simplebar-content-wrapper" tabindex="0" role="region" aria-label="scrollable content" style="height: 100%; overflow: hidden scroll">
                  <div class="simplebar-content" style="padding: 0px">
                    <div class="p-4">
                      <h6 class="mb-0 fw-semibold text-uppercase">Layout</h6>
                      <p class="text-muted">Choose your layout</p>
                      <div class="row gy-3">
                        <div class="col-4">
                          <div class="form-check card-radio">
                            <input id="customizer-layout01" name="data-layout" type="radio" value="vertical" class="form-check-input" v-model="dataLayout" @click="store.setCustomizer('data-layout', 'vertical')" />
                            <label class="form-check-label p-0 avatar-md w-100 material-shadow" for="customizer-layout01">
                              <span class="d-flex gap-1 h-100">
                                <span class="flex-shrink-0">
                                  <span class="bg-light d-flex h-100 flex-column gap-1 p-1">
                                    <span class="d-block p-1 px-2 bg-primary-subtle rounded mb-2"></span>
                                    <span class="d-block p-1 px-2 pb-0 bg-primary-subtle"></span>
                                    <span class="d-block p-1 px-2 pb-0 bg-primary-subtle"></span>
                                    <span class="d-block p-1 px-2 pb-0 bg-primary-subtle"></span>
                                  </span>
                                </span>
                                <span class="flex-grow-1">
                                  <span class="d-flex h-100 flex-column">
                                    <span class="bg-light d-block p-1"></span>
                                    <span class="bg-light d-block p-1 mt-auto"></span>
                                  </span>
                                </span>
                              </span>
                            </label>
                          </div>
                          <h5 class="fs-13 text-center mt-2">Vertical</h5>
                        </div>
                        <div class="col-4">
                          <div class="form-check card-radio">
                            <input id="customizer-layout02" name="data-layout" type="radio" value="horizontal" class="form-check-input" v-model="dataLayout" @click="store.setCustomizer('data-layout', 'horizontal')" />
                            <label class="form-check-label p-0 avatar-md w-100 material-shadow" for="customizer-layout02">
                              <span class="d-flex h-100 flex-column gap-1">
                                <span class="bg-light d-flex p-1 gap-1 align-items-center">
                                  <span class="d-block p-1 bg-primary-subtle rounded me-1"></span>
                                  <span class="d-block p-1 pb-0 px-2 bg-primary-subtle ms-auto"></span>
                                  <span class="d-block p-1 pb-0 px-2 bg-primary-subtle"></span>
                                </span>
                                <span class="bg-light d-block p-1"></span>
                                <span class="bg-light d-block p-1 mt-auto"></span>
                              </span>
                            </label>
                          </div>
                          <h5 class="fs-13 text-center mt-2">Horizontal</h5>
                        </div>
                        <!-- <div class="col-4">
                          <div class="form-check card-radio">
                            <input id="customizer-layout03" name="data-layout" type="radio" value="twocolumn" class="form-check-input" v-model="dataLayout" @click="store.setCustomizer('data-layout', 'twocolumn')" />
                            <label class="form-check-label p-0 avatar-md w-100 material-shadow" for="customizer-layout03">
                              <span class="d-flex gap-1 h-100">
                                <span class="flex-shrink-0">
                                  <span class="bg-light d-flex h-100 flex-column gap-1">
                                    <span class="d-block p-1 bg-primary-subtle mb-2"></span>
                                    <span class="d-block p-1 pb-0 bg-primary-subtle"></span>
                                    <span class="d-block p-1 pb-0 bg-primary-subtle"></span>
                                    <span class="d-block p-1 pb-0 bg-primary-subtle"></span>
                                  </span>
                                </span>
                                <span class="flex-shrink-0">
                                  <span class="bg-light d-flex h-100 flex-column gap-1 p-1">
                                    <span class="d-block p-1 px-2 pb-0 bg-primary-subtle"></span>
                                    <span class="d-block p-1 px-2 pb-0 bg-primary-subtle"></span>
                                    <span class="d-block p-1 px-2 pb-0 bg-primary-subtle"></span>
                                    <span class="d-block p-1 px-2 pb-0 bg-primary-subtle"></span>
                                  </span>
                                </span>
                                <span class="flex-grow-1">
                                  <span class="d-flex h-100 flex-column">
                                    <span class="bg-light d-block p-1"></span>
                                    <span class="bg-light d-block p-1 mt-auto"></span>
                                  </span>
                                </span>
                              </span>
                            </label>
                          </div>
                          <h5 class="fs-13 text-center mt-2">Two Column</h5>
                        </div> -->
                        <div class="col-4">
                          <div class="form-check card-radio">
                            <input id="customizer-layout04" name="data-layout" type="radio" value="semibox" class="form-check-input" v-model="dataLayout" @click="store.setCustomizer('data-layout', 'semibox')" />
                            <label class="form-check-label p-0 avatar-md w-100 material-shadow" for="customizer-layout04">
                              <span class="d-flex gap-1 h-100">
                                <span class="flex-shrink-0 p-1">
                                  <span class="bg-light d-flex h-100 flex-column gap-1 p-1">
                                    <span class="d-block p-1 px-2 bg-primary-subtle rounded mb-2"></span>
                                    <span class="d-block p-1 px-2 pb-0 bg-primary-subtle"></span>
                                    <span class="d-block p-1 px-2 pb-0 bg-primary-subtle"></span>
                                    <span class="d-block p-1 px-2 pb-0 bg-primary-subtle"></span>
                                  </span>
                                </span>
                                <span class="flex-grow-1">
                                  <span class="d-flex h-100 flex-column pt-1 pe-2">
                                    <span class="bg-light d-block p-1"></span>
                                    <span class="bg-light d-block p-1 mt-auto"></span>
                                  </span>
                                </span>
                              </span>
                            </label>
                          </div>
                          <h5 class="fs-13 text-center mt-2">Semi Box</h5>
                        </div>
                      </div>

                      <div id="sidebar-size" style="display: block">
                        <h6 class="mt-4 mb-0 fw-semibold text-uppercase">
                          Sidebar Size
                        </h6>
                        <p class="text-muted">Choose a size of Sidebar.</p>

                        <div class="row">
                          <div class="col-4">
                            <div class="form-check sidebar-setting card-radio">
                              <input class="form-check-input" type="radio" name="data-sidebar-size" id="sidebar-size-default" value="lg" v-model="dataSidebarSize" @click="store.setCustomizer('data-sidebar-size', 'lg')" />
                              <label class="form-check-label p-0 avatar-md w-100 material-shadow" for="sidebar-size-default">
                                <span class="d-flex gap-1 h-100">
                                  <span class="flex-shrink-0">
                                    <span class="bg-light d-flex h-100 flex-column gap-1 p-1">
                                      <span class="d-block p-1 px-2 bg-primary-subtle rounded mb-2"></span>
                                      <span class="d-block p-1 px-2 pb-0 bg-primary-subtle"></span>
                                      <span class="d-block p-1 px-2 pb-0 bg-primary-subtle"></span>
                                      <span class="d-block p-1 px-2 pb-0 bg-primary-subtle"></span>
                                    </span>
                                  </span>
                                  <span class="flex-grow-1">
                                    <span class="d-flex h-100 flex-column">
                                      <span class="bg-light d-block p-1"></span>
                                      <span class="bg-light d-block p-1 mt-auto"></span>
                                    </span>
                                  </span>
                                </span>
                              </label>
                            </div>
                            <h5 class="fs-13 text-center mt-2">Default</h5>
                          </div>

                          <div class="col-4">
                            <div class="form-check sidebar-setting card-radio">
                              <input class="form-check-input" type="radio" name="data-sidebar-size" id="sidebar-size-small" value="sm" v-model="dataSidebarSize" @click="store.setCustomizer('data-sidebar-size', 'sm')" />
                              <label class="form-check-label p-0 avatar-md w-100 material-shadow" for="sidebar-size-small">
                                <span class="d-flex gap-1 h-100">
                                  <span class="flex-shrink-0">
                                    <span class="bg-light d-flex h-100 flex-column gap-1">
                                      <span class="d-block p-1 bg-primary-subtle mb-2"></span>
                                      <span class="d-block p-1 pb-0 bg-primary-subtle"></span>
                                      <span class="d-block p-1 pb-0 bg-primary-subtle"></span>
                                      <span class="d-block p-1 pb-0 bg-primary-subtle"></span>
                                    </span>
                                  </span>
                                  <span class="flex-grow-1">
                                    <span class="d-flex h-100 flex-column">
                                      <span class="bg-light d-block p-1"></span>
                                      <span class="bg-light d-block p-1 mt-auto"></span>
                                    </span>
                                  </span>
                                </span>
                              </label>
                            </div>
                            <h5 class="fs-13 text-center mt-2">
                              Small (Icon View)
                            </h5>
                          </div>

                          <div class="col-4">
                            <div class="form-check sidebar-setting card-radio">
                              <input class="form-check-input" type="radio" name="data-sidebar-size" id="sidebar-size-compact" value="md" v-model="dataSidebarSize" @click="store.setCustomizer('data-sidebar-size', 'md')" />
                              <label class="form-check-label p-0 avatar-md w-100 material-shadow" for="sidebar-size-compact">
                                <span class="d-flex gap-1 h-100">
                                  <span class="flex-shrink-0">
                                    <span class="bg-light d-flex h-100 flex-column gap-1 p-1">
                                      <span class="d-block p-1 bg-primary-subtle rounded mb-2"></span>
                                      <span class="d-block p-1 pb-0 bg-primary-subtle"></span>
                                      <span class="d-block p-1 pb-0 bg-primary-subtle"></span>
                                      <span class="d-block p-1 pb-0 bg-primary-subtle"></span>
                                    </span>
                                  </span>
                                  <span class="flex-grow-1">
                                    <span class="d-flex h-100 flex-column">
                                      <span class="bg-light d-block p-1"></span>
                                      <span class="bg-light d-block p-1 mt-auto"></span>
                                    </span>
                                  </span>
                                </span>
                              </label>
                            </div>
                            <h5 class="fs-13 text-center mt-2">Compact</h5>
                          </div>

                          <div class="col-4">
                            <div class="form-check sidebar-setting card-radio">
                              <input class="form-check-input" type="radio" name="data-sidebar-size" id="sidebar-size-small-hover" value="sm-hover" v-model="dataSidebarSize" @click="store.setCustomizer('data-sidebar-size', 'sm-hover')" />
                              <label class="form-check-label p-0 avatar-md w-100 material-shadow" for="sidebar-size-small-hover">
                                <span class="d-flex gap-1 h-100">
                                  <span class="flex-shrink-0">
                                    <span class="bg-light d-flex h-100 flex-column gap-1">
                                      <span class="d-block p-1 bg-primary-subtle mb-2"></span>
                                      <span class="d-block p-1 pb-0 bg-primary-subtle"></span>
                                      <span class="d-block p-1 pb-0 bg-primary-subtle"></span>
                                      <span class="d-block p-1 pb-0 bg-primary-subtle"></span>
                                    </span>
                                  </span>
                                  <span class="flex-grow-1">
                                    <span class="d-flex h-100 flex-column">
                                      <span class="bg-light d-block p-1"></span>
                                      <span class="bg-light d-block p-1 mt-auto"></span>
                                    </span>
                                  </span>
                                </span>
                              </label>
                            </div>
                            <h5 class="fs-13 text-center mt-2">
                              Small Hover View
                            </h5>
                          </div>
                        </div>
                      </div>

                      <div class="form-check form-switch form-switch-md mb-3 mt-4" @click="sidebarUserShow">
                        <input type="checkbox" class="form-check-input" id="sidebarUserProfile" v-model="dataSidebarUser" />
                        <label class="form-check-label" for="sidebarUserProfile">Sidebar User Profile Avatar</label>
                      </div>

                      <h6 class="mt-4 mb-0 fw-semibold text-uppercase">Theme</h6>
                      <p class="text-muted">Choose your suitable Theme.</p>

                      <div class="row">
                        <div class="col-6">
                          <div class="form-check card-radio">
                            <input id="customizer-theme01" name="data-theme" type="radio" value="default" class="form-check-input" v-model="dataTheme" @click="store.setCustomizer('data-theme', 'default')" />
                            <label class="form-check-label p-0" for="customizer-theme01">
                              <img src="/public/assets/images/demos/default.png" alt="" class="img-fluid" />
                            </label>
                          </div>
                          <h5 class="fs-13 text-center fw-medium mt-2">
                            Default
                          </h5>
                        </div>
                        <div class="col-6">
                          <div class="form-check card-radio">
                            <input id="customizer-theme07" name="data-theme" type="radio" value="minimal" class="form-check-input" v-model="dataTheme" @click="store.setCustomizer('data-theme', 'minimal')" />
                            <label class="form-check-label p-0" for="customizer-theme07">
                              <img src="/public/assets/images/demos/minimal.png" alt="" class="img-fluid" />
                            </label>
                          </div>
                          <h5 class="fs-13 text-center fw-medium mt-2">
                            Minimal
                          </h5>
                        </div>
                        <div class="col-6">
                          <div class="form-check card-radio">
                            <input id="customizer-theme05" name="data-theme" type="radio" value="material" class="form-check-input" v-model="dataTheme" @click="store.setCustomizer('data-theme', 'material')" />
                            <label class="form-check-label p-0" for="customizer-theme05">
                              <img src="/public/assets/images/demos/material.png" alt="" class="img-fluid" />
                            </label>
                          </div>
                          <h5 class="fs-13 text-center fw-medium mt-2">
                            Material
                          </h5>
                        </div>
                        <div class="col-6">
                          <div class="form-check card-radio">
                            <input id="customizer-theme02" name="data-theme" type="radio" value="saas" class="form-check-input" v-model="dataTheme" @click="store.setCustomizer('data-theme', 'saas')" />
                            <label class="form-check-label p-0" for="customizer-theme02">
                              <img src="/public/assets/images/demos/saas.png" alt="" class="img-fluid" />
                            </label>
                          </div>
                          <h5 class="fs-13 text-center fw-medium mt-2">Sass</h5>
                        </div>
                        <div class="col-6">
                          <div class="form-check card-radio">
                            <input id="customizer-theme03" name="data-theme" type="radio" value="corporate" class="form-check-input" v-model="dataTheme" @click="store.setCustomizer('data-theme', 'corporate')" />
                            <label class="form-check-label p-0" for="customizer-theme03">
                              <img src="/public/assets/images/demos/corporate.png" alt="" class="img-fluid" />
                            </label>
                          </div>
                          <h5 class="fs-13 text-center fw-medium mt-2">
                            Corporate
                          </h5>
                        </div>
                        <div class="col-6">
                          <div class="form-check card-radio">
                            <input id="customizer-theme04" name="data-theme" type="radio" value="galaxy" class="form-check-input" v-model="dataTheme" @click="store.setCustomizer('data-theme', 'galaxy')" />
                            <label class="form-check-label p-0" for="customizer-theme04">
                              <img src="/public/assets/images/demos/galaxy.png" alt="" class="img-fluid" />
                            </label>
                          </div>
                          <h5 class="fs-13 text-center fw-medium mt-2">
                            Galaxy
                          </h5>
                        </div>
                        <div class="col-6">
                          <div class="form-check card-radio">
                            <input id="customizer-theme06" name="data-theme" type="radio" value="creative" class="form-check-input" v-model="dataTheme" @click="store.setCustomizer('data-theme', 'creative')" />
                            <label class="form-check-label p-0" for="customizer-theme06">
                              <img src="/public/assets/images/demos/creative.png" alt="" class="img-fluid" />
                            </label>
                          </div>
                          <h5 class="fs-13 text-center fw-medium mt-2">
                            Creative
                          </h5>
                        </div>
                        <div class="col-6">
                          <div class="form-check card-radio">
                            <input id="customizer-theme08" name="data-theme" type="radio" value="modern" class="form-check-input" v-model="dataTheme" @click="store.setCustomizer('data-theme', 'modern')" />
                            <label class="form-check-label p-0" for="customizer-theme08">
                              <img src="/public/assets/images/demos/modern.png" alt="" class="img-fluid" />
                            </label>
                          </div>
                          <h5 class="fs-13 text-center fw-medium mt-2">
                            Modern
                          </h5>
                        </div>
                        <!-- end col -->
                        <div class="col-6">
                          <div class="form-check card-radio">
                            <input id="customizer-theme09" name="data-theme" type="radio" value="interactive" class="form-check-input" v-model="dataTheme" @click="store.setCustomizer('data-theme', 'interactive')" />
                            <label class="form-check-label p-0" for="customizer-theme09">
                              <img src="/public/assets/images/demos/interactive.png" alt="" class="img-fluid" />
                            </label>
                          </div>
                          <h5 class="fs-13 text-center fw-medium mt-2">
                            Interactive
                          </h5>
                        </div>
                        <!-- end col -->

                        <div class="col-6">
                          <div class="form-check card-radio">
                            <input id="customizer-theme10" name="data-theme" type="radio" value="classic" class="form-check-input" v-model="dataTheme" @click="store.setCustomizer('data-theme', 'classic')" />
                            <label class="form-check-label p-0" for="customizer-theme10">
                              <img src="/public/assets/images/demos/classic.png" alt="" class="img-fluid" />
                            </label>
                          </div>
                          <h5 class="fs-13 text-center fw-medium mt-2">
                            Classic
                          </h5>
                        </div>
                        <!-- end col -->

                        <div class="col-6">
                          <div class="form-check card-radio">
                            <input id="customizer-theme11" name="data-theme" type="radio" value="vintage" class="form-check-input" v-model="dataTheme" @click="store.setCustomizer('data-theme', 'vintage')" />
                            <label class="form-check-label p-0" for="customizer-theme11">
                              <img src="/public/assets/images/demos/vintage.png" alt="" class="img-fluid" />
                            </label>
                          </div>
                          <h5 class="fs-13 text-center fw-medium mt-2">
                            Vintage
                          </h5>
                        </div>
                        <!-- end col -->
                      </div>

                      <h6 class="mt-4 mb-0 fw-semibold text-uppercase">
                        Color Scheme
                      </h6>
                      <p class="text-muted">Choose Light or Dark Scheme.</p>

                      <div class="colorscheme-cardradio">
                        <div class="row">
                          <div class="col-4">
                            <div class="form-check card-radio">
                              <input class="form-check-input" type="radio" name="data-bs-theme" id="layout-mode-light" value="light" v-model="dataBsTheme" @click="store.setCustomizer('data-bs-theme', 'light')" />
                              <label class="form-check-label p-0 avatar-md w-100 material-shadow" for="layout-mode-light">
                                <span class="d-flex gap-1 h-100">
                                  <span class="flex-shrink-0">
                                    <span class="bg-light d-flex h-100 flex-column gap-1 p-1">
                                      <span class="d-block p-1 px-2 bg-primary-subtle rounded mb-2"></span>
                                      <span class="d-block p-1 px-2 pb-0 bg-primary-subtle"></span>
                                      <span class="d-block p-1 px-2 pb-0 bg-primary-subtle"></span>
                                      <span class="d-block p-1 px-2 pb-0 bg-primary-subtle"></span>
                                    </span>
                                  </span>
                                  <span class="flex-grow-1">
                                    <span class="d-flex h-100 flex-column">
                                      <span class="bg-light d-block p-1"></span>
                                      <span class="bg-light d-block p-1 mt-auto"></span>
                                    </span>
                                  </span>
                                </span>
                              </label>
                            </div>
                            <h5 class="fs-13 text-center mt-2">Light</h5>
                          </div>

                          <div class="col-4">
                            <div class="form-check card-radio dark">
                              <input class="form-check-input" type="radio" name="data-bs-theme" id="layout-mode-dark" value="dark" v-model="dataBsTheme" @click="store.setCustomizer('data-bs-theme', 'dark')" />
                              <label class="form-check-label p-0 avatar-md w-100 bg-dark material-shadow" for="layout-mode-dark">
                                <span class="d-flex gap-1 h-100">
                                  <span class="flex-shrink-0">
                                    <span class="bg-white bg-opacity-10 d-flex h-100 flex-column gap-1 p-1">
                                      <span class="d-block p-1 px-2 bg-white bg-opacity-10 rounded mb-2"></span>
                                      <span class="d-block p-1 px-2 pb-0 bg-white bg-opacity-10"></span>
                                      <span class="d-block p-1 px-2 pb-0 bg-white bg-opacity-10"></span>
                                      <span class="d-block p-1 px-2 pb-0 bg-white bg-opacity-10"></span>
                                    </span>
                                  </span>
                                  <span class="flex-grow-1">
                                    <span class="d-flex h-100 flex-column">
                                      <span class="bg-white bg-opacity-10 d-block p-1"></span>
                                      <span class="bg-white bg-opacity-10 d-block p-1 mt-auto"></span>
                                    </span>
                                  </span>
                                </span>
                              </label>
                            </div>
                            <h5 class="fs-13 text-center mt-2">Dark</h5>
                          </div>
                        </div>
                      </div>

                      <div id="layout-width" style="display: block">
                        <h6 class="mt-4 mb-0 fw-semibold text-uppercase">
                          Layout Width
                        </h6>
                        <p class="text-muted">Choose Fluid or Boxed layout.</p>

                        <div class="row">
                          <div class="col-4">
                            <div class="form-check card-radio">
                              <input class="form-check-input" type="radio" name="data-layout-width" id="layout-width-fluid" value="fluid" v-model="dataLayoutWidth" @click="store.setCustomizer('data-layout-width', 'fluid')" />
                              <label class="form-check-label p-0 avatar-md w-100 material-shadow" for="layout-width-fluid">
                                <span class="d-flex gap-1 h-100">
                                  <span class="flex-shrink-0">
                                    <span class="bg-light d-flex h-100 flex-column gap-1 p-1">
                                      <span class="d-block p-1 px-2 bg-primary-subtle rounded mb-2"></span>
                                      <span class="d-block p-1 px-2 pb-0 bg-primary-subtle"></span>
                                      <span class="d-block p-1 px-2 pb-0 bg-primary-subtle"></span>
                                      <span class="d-block p-1 px-2 pb-0 bg-primary-subtle"></span>
                                    </span>
                                  </span>
                                  <span class="flex-grow-1">
                                    <span class="d-flex h-100 flex-column">
                                      <span class="bg-light d-block p-1"></span>
                                      <span class="bg-light d-block p-1 mt-auto"></span>
                                    </span>
                                  </span>
                                </span>
                              </label>
                            </div>
                            <h5 class="fs-13 text-center mt-2">Fluid</h5>
                          </div>
                          <div class="col-4">
                            <div class="form-check card-radio">
                              <input class="form-check-input" type="radio" name="data-layout-width" id="layout-width-boxed" value="boxed" v-model="dataLayoutWidth" @click="store.setCustomizer('data-layout-width', 'boxed')" />
                              <label class="form-check-label p-0 avatar-md w-100 px-2 material-shadow" for="layout-width-boxed">
                                <span class="d-flex gap-1 h-100 border-start border-end">
                                  <span class="flex-shrink-0">
                                    <span class="bg-light d-flex h-100 flex-column gap-1 p-1">
                                      <span class="d-block p-1 px-2 bg-primary-subtle rounded mb-2"></span>
                                      <span class="d-block p-1 px-2 pb-0 bg-primary-subtle"></span>
                                      <span class="d-block p-1 px-2 pb-0 bg-primary-subtle"></span>
                                      <span class="d-block p-1 px-2 pb-0 bg-primary-subtle"></span>
                                    </span>
                                  </span>
                                  <span class="flex-grow-1">
                                    <span class="d-flex h-100 flex-column">
                                      <span class="bg-light d-block p-1"></span>
                                      <span class="bg-light d-block p-1 mt-auto"></span>
                                    </span>
                                  </span>
                                </span>
                              </label>
                            </div>
                            <h5 class="fs-13 text-center mt-2">Boxed</h5>
                          </div>
                        </div>
                      </div>

                      <!-- <div id="layout-position" style="display: block">
                        <h6 class="mt-4 mb-0 fw-semibold text-uppercase">
                          Layout Position
                        </h6>
                        <p class="text-muted">
                          Choose Fixed or Scrollable Layout Position.
                        </p>

                        <div class="btn-group radio" role="group">
                          <input type="radio" class="btn-check" name="data-layout-position" id="layout-position-fixed" value="fixed" v-model="dataLayoutPosition" @click="store.setCustomizer('data-layout-position', 'fixed')" />
                          <label class="btn btn-light w-sm" for="layout-position-fixed">Fixed</label>

                          <input type="radio" class="btn-check" name="data-layout-position" id="layout-position-scrollable" value="scrollable" v-model="dataLayoutPosition" @click="store.setCustomizer('data-layout-position', 'scrollable')" />
                          <label class="btn btn-light w-sm ms-0" for="layout-position-scrollable">Scrollable</label>
                        </div>
                      </div> -->

                      <h6 class="mt-4 mb-0 fw-semibold text-uppercase">
                        Topbar Color
                      </h6>
                      <p class="text-muted">
                        Choose Light or Dark Topbar Color.
                      </p>

                      <div class="row">
                        <div class="col-4">
                          <div class="form-check card-radio">
                            <input class="form-check-input" type="radio" name="data-topbar" id="topbar-color-light" value="light" v-model="dataTopbar" @click="store.setCustomizer('data-topbar', 'light')" />
                            <label class="form-check-label p-0 avatar-md w-100 material-shadow" for="topbar-color-light">
                              <span class="d-flex gap-1 h-100">
                                <span class="flex-shrink-0">
                                  <span class="bg-light d-flex h-100 flex-column gap-1 p-1">
                                    <span class="d-block p-1 px-2 bg-primary-subtle rounded mb-2"></span>
                                    <span class="d-block p-1 px-2 pb-0 bg-primary-subtle"></span>
                                    <span class="d-block p-1 px-2 pb-0 bg-primary-subtle"></span>
                                    <span class="d-block p-1 px-2 pb-0 bg-primary-subtle"></span>
                                  </span>
                                </span>
                                <span class="flex-grow-1">
                                  <span class="d-flex h-100 flex-column">
                                    <span class="bg-light d-block p-1"></span>
                                    <span class="bg-light d-block p-1 mt-auto"></span>
                                  </span>
                                </span>
                              </span>
                            </label>
                          </div>
                          <h5 class="fs-13 text-center mt-2">Light</h5>
                        </div>
                        <div class="col-4">
                          <div class="form-check card-radio">
                            <input class="form-check-input" type="radio" name="data-topbar" id="topbar-color-dark" value="dark" v-model="dataTopbar" @click="store.setCustomizer('data-topbar', 'dark')" />
                            <label class="form-check-label p-0 avatar-md w-100 material-shadow" for="topbar-color-dark">
                              <span class="d-flex gap-1 h-100">
                                <span class="flex-shrink-0">
                                  <span class="bg-light d-flex h-100 flex-column gap-1 p-1">
                                    <span class="d-block p-1 px-2 bg-primary-subtle rounded mb-2"></span>
                                    <span class="d-block p-1 px-2 pb-0 bg-primary-subtle"></span>
                                    <span class="d-block p-1 px-2 pb-0 bg-primary-subtle"></span>
                                    <span class="d-block p-1 px-2 pb-0 bg-primary-subtle"></span>
                                  </span>
                                </span>
                                <span class="flex-grow-1">
                                  <span class="d-flex h-100 flex-column">
                                    <span class="bg-primary d-block p-1"></span>
                                    <span class="bg-light d-block p-1 mt-auto"></span>
                                  </span>
                                </span>
                              </span>
                            </label>
                          </div>
                          <h5 class="fs-13 text-center mt-2">Dark</h5>
                        </div>
                      </div>

                      <div id="sidebar-view" style="display: block">
                        <h6 class="mt-4 mb-0 fw-semibold text-uppercase">
                          Sidebar View
                        </h6>
                        <p class="text-muted">
                          Choose Default or Detached Sidebar view.
                        </p>

                        <div class="row">
                          <div class="col-4">
                            <div class="form-check sidebar-setting card-radio">
                              <input class="form-check-input" type="radio" name="data-layout-style" id="sidebar-view-default" value="default" v-model="dataLayoutStyle" @click="store.setCustomizer('data-layout-style', 'default')" />
                              <label class="form-check-label p-0 avatar-md w-100 material-shadow" for="sidebar-view-default">
                                <span class="d-flex gap-1 h-100">
                                  <span class="flex-shrink-0">
                                    <span class="bg-light d-flex h-100 flex-column gap-1 p-1">
                                      <span class="d-block p-1 px-2 bg-primary-subtle rounded mb-2"></span>
                                      <span class="d-block p-1 px-2 pb-0 bg-primary-subtle"></span>
                                      <span class="d-block p-1 px-2 pb-0 bg-primary-subtle"></span>
                                      <span class="d-block p-1 px-2 pb-0 bg-primary-subtle"></span>
                                    </span>
                                  </span>
                                  <span class="flex-grow-1">
                                    <span class="d-flex h-100 flex-column">
                                      <span class="bg-light d-block p-1"></span>
                                      <span class="bg-light d-block p-1 mt-auto"></span>
                                    </span>
                                  </span>
                                </span>
                              </label>
                            </div>
                            <h5 class="fs-13 text-center mt-2">Default</h5>
                          </div>
                          <div class="col-4">
                            <div class="form-check sidebar-setting card-radio">
                              <input class="form-check-input" type="radio" name="data-layout-style" id="sidebar-view-detached" value="detached" v-model="dataLayoutStyle" @click="store.setCustomizer('data-layout-style', 'detached')" />
                              <label class="form-check-label p-0 avatar-md w-100 material-shadow" for="sidebar-view-detached">
                                <span class="d-flex h-100 flex-column">
                                  <span class="bg-light d-flex p-1 gap-1 align-items-center px-2">
                                    <span class="d-block p-1 bg-primary-subtle rounded me-1"></span>
                                    <span class="d-block p-1 pb-0 px-2 bg-primary-subtle ms-auto"></span>
                                    <span class="d-block p-1 pb-0 px-2 bg-primary-subtle"></span>
                                  </span>
                                  <span class="d-flex gap-1 h-100 p-1 px-2">
                                    <span class="flex-shrink-0">
                                      <span class="bg-light d-flex h-100 flex-column gap-1 p-1">
                                        <span class="d-block p-1 px-2 pb-0 bg-primary-subtle"></span>
                                        <span class="d-block p-1 px-2 pb-0 bg-primary-subtle"></span>
                                        <span class="d-block p-1 px-2 pb-0 bg-primary-subtle"></span>
                                      </span>
                                    </span>
                                  </span>
                                  <span class="bg-light d-block p-1 mt-auto px-2"></span>
                                </span>
                              </label>
                            </div>
                            <h5 class="fs-13 text-center mt-2">Detached</h5>
                          </div>
                        </div>
                      </div>
                      <div id="sidebar-color" style="display: block">
                        <h6 class="mt-4 mb-0 fw-semibold text-uppercase">
                          Sidebar Color
                        </h6>
                        <p class="text-muted">Choose a color of Sidebar.</p>

                        <div class="row">
                          <div class="col-4">
                            <div class="form-check sidebar-setting card-radio" data-bs-toggle="collapse" data-bs-target="#collapseBgGradient.show">
                              <input class="form-check-input" type="radio" name="data-sidebar" id="sidebar-color-light" value="light" v-model="dataSidebar" @click="store.setCustomizer('data-sidebar', 'light')" />
                              <label class="form-check-label p-0 avatar-md w-100 material-shadow" for="sidebar-color-light">
                                <span class="d-flex gap-1 h-100">
                                  <span class="flex-shrink-0">
                                    <span class="bg-white border-end d-flex h-100 flex-column gap-1 p-1">
                                      <span class="d-block p-1 px-2 bg-primary-subtle rounded mb-2"></span>
                                      <span class="d-block p-1 px-2 pb-0 bg-primary-subtle"></span>
                                      <span class="d-block p-1 px-2 pb-0 bg-primary-subtle"></span>
                                      <span class="d-block p-1 px-2 pb-0 bg-primary-subtle"></span>
                                    </span>
                                  </span>
                                  <span class="flex-grow-1">
                                    <span class="d-flex h-100 flex-column">
                                      <span class="bg-light d-block p-1"></span>
                                      <span class="bg-light d-block p-1 mt-auto"></span>
                                    </span>
                                  </span>
                                </span>
                              </label>
                            </div>
                            <h5 class="fs-13 text-center mt-2">Light</h5>
                          </div>
                          <div class="col-4">
                            <div class="form-check sidebar-setting card-radio" data-bs-toggle="collapse" data-bs-target="#collapseBgGradient.show">
                              <input class="form-check-input" type="radio" name="data-sidebar" id="sidebar-color-dark" value="dark" v-model="dataSidebar" @click="store.setCustomizer('data-sidebar', 'dark')" />
                              <label class="form-check-label p-0 avatar-md w-100 material-shadow" for="sidebar-color-dark">
                                <span class="d-flex gap-1 h-100">
                                  <span class="flex-shrink-0">
                                    <span class="bg-primary d-flex h-100 flex-column gap-1 p-1">
                                      <span class="d-block p-1 px-2 bg-white bg-opacity-10 rounded mb-2"></span>
                                      <span class="d-block p-1 px-2 pb-0 bg-white bg-opacity-10"></span>
                                      <span class="d-block p-1 px-2 pb-0 bg-white bg-opacity-10"></span>
                                      <span class="d-block p-1 px-2 pb-0 bg-white bg-opacity-10"></span>
                                    </span>
                                  </span>
                                  <span class="flex-grow-1">
                                    <span class="d-flex h-100 flex-column">
                                      <span class="bg-light d-block p-1"></span>
                                      <span class="bg-light d-block p-1 mt-auto"></span>
                                    </span>
                                  </span>
                                </span>
                              </label>
                            </div>
                            <h5 class="fs-13 text-center mt-2">Dark</h5>
                          </div>
                          <div class="col-4">
                            <button class="btn btn-link avatar-md w-100 p-0 overflow-hidden border collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseBgGradient" aria-expanded="false" aria-controls="collapseBgGradient">
                              <span class="d-flex gap-1 h-100">
                                <span class="flex-shrink-0">
                                  <span class="bg-vertical-gradient d-flex h-100 flex-column gap-1 p-1">
                                    <span class="d-block p-1 px-2 bg-white bg-opacity-10 rounded mb-2"></span>
                                    <span class="d-block p-1 px-2 pb-0 bg-white bg-opacity-10"></span>
                                    <span class="d-block p-1 px-2 pb-0 bg-white bg-opacity-10"></span>
                                    <span class="d-block p-1 px-2 pb-0 bg-white bg-opacity-10"></span>
                                  </span>
                                </span>
                                <span class="flex-grow-1">
                                  <span class="d-flex h-100 flex-column">
                                    <span class="bg-light d-block p-1"></span>
                                    <span class="bg-light d-block p-1 mt-auto"></span>
                                  </span>
                                </span>
                              </span>
                            </button>
                            <h5 class="fs-13 text-center mt-2">Gradient</h5>
                          </div>
                        </div>
                        <!-- end row -->

                        <div class="collapse" id="collapseBgGradient">
                          <div class="d-flex gap-2 flex-wrap img-switch p-2 px-3 bg-light rounded">
                            <div class="form-check sidebar-setting card-radio">
                              <input class="form-check-input" type="radio" name="data-sidebar" id="sidebar-color-gradient" value="gradient" v-model="dataSidebar" @click="store.setCustomizer('data-sidebar', 'gradient')" />
                              <label class="form-check-label p-0 avatar-xs rounded-circle" for="sidebar-color-gradient">
                                <span class="avatar-title rounded-circle bg-vertical-gradient"></span>
                              </label>
                            </div>
                            <div class="form-check sidebar-setting card-radio">
                              <input class="form-check-input" type="radio" name="data-sidebar" id="sidebar-color-gradient-2" value="gradient-2" v-model="dataSidebar" @click="store.setCustomizer('data-sidebar', 'gradient-2')" />
                              <label class="form-check-label p-0 avatar-xs rounded-circle" for="sidebar-color-gradient-2">
                                <span class="avatar-title rounded-circle bg-vertical-gradient-2"></span>
                              </label>
                            </div>
                            <div class="form-check sidebar-setting card-radio">
                              <input class="form-check-input" type="radio" name="data-sidebar" id="sidebar-color-gradient-3" value="gradient-3" v-model="dataSidebar" @click="store.setCustomizer('data-sidebar', 'gradient-3')" />
                              <label class="form-check-label p-0 avatar-xs rounded-circle" for="sidebar-color-gradient-3">
                                <span class="avatar-title rounded-circle bg-vertical-gradient-3"></span>
                              </label>
                            </div>
                            <div class="form-check sidebar-setting card-radio">
                              <input class="form-check-input" type="radio" name="data-sidebar" id="sidebar-color-gradient-4" value="gradient-4" v-model="dataSidebar" @click="store.setCustomizer('data-sidebar', 'gradient-4')" />
                              <label class="form-check-label p-0 avatar-xs rounded-circle" for="sidebar-color-gradient-4">
                                <span class="avatar-title rounded-circle bg-vertical-gradient-4"></span>
                              </label>
                            </div>
                          </div>
                        </div>
                      </div>

                      <div id="sidebar-img" style="display: block">
                        <h6 class="mt-4 mb-0 fw-semibold text-uppercase">
                          Sidebar Images
                        </h6>
                        <p class="text-muted">Choose a image of Sidebar.</p>

                        <div class="d-flex gap-2 flex-wrap img-switch">
                          <div class="form-check sidebar-setting card-radio">
                            <input class="form-check-input" type="radio" name="data-sidebar-image" id="sidebarimg-none" value="none" v-model="dataSidebarImage" @click="store.setCustomizer('data-sidebar-image', 'none')" />
                            <label class="form-check-label p-0 avatar-sm h-auto" for="sidebarimg-none">
                              <span class="avatar-md w-auto bg-light d-flex align-items-center justify-content-center">
                                <i class="ri-close-fill fs-20"></i>
                              </span>
                            </label>
                          </div>

                          <div class="form-check sidebar-setting card-radio">
                            <input class="form-check-input" type="radio" name="data-sidebar-image" id="sidebarimg-01" value="img-1" v-model="dataSidebarImage" @click="store.setCustomizer('data-sidebar-image', 'img-1')" />
                            <label class="form-check-label p-0 avatar-sm h-auto" for="sidebarimg-01">
                              <img src="/public/assets/images/sidebar/img-1.jpg" alt="" class="avatar-md w-auto object-fit-cover" />
                            </label>
                          </div>

                          <div class="form-check sidebar-setting card-radio">
                            <input class="form-check-input" type="radio" name="data-sidebar-image" id="sidebarimg-02" value="img-2" v-model="dataSidebarImage" @click="store.setCustomizer('data-sidebar-image', 'img-2')" />
                            <label class="form-check-label p-0 avatar-sm h-auto" for="sidebarimg-02">
                              <img src="/public/assets/images/sidebar/img-2.jpg" alt="" class="avatar-md w-auto object-fit-cover" />
                            </label>
                          </div>
                          <div class="form-check sidebar-setting card-radio">
                            <input class="form-check-input" type="radio" name="data-sidebar-image" id="sidebarimg-03" value="img-3" v-model="dataSidebarImage" @click="store.setCustomizer('data-sidebar-image', 'img-3')" />
                            <label class="form-check-label p-0 avatar-sm h-auto" for="sidebarimg-03">
                              <img src="/public/assets/images/sidebar/img-3.jpg" alt="" class="avatar-md w-auto object-fit-cover" />
                            </label>
                          </div>
                          <div class="form-check sidebar-setting card-radio">
                            <input class="form-check-input" type="radio" name="data-sidebar-image" id="sidebarimg-04" value="img-4" v-model="dataSidebarImage" @click="store.setCustomizer('data-sidebar-image', 'img-4')" />
                            <label class="form-check-label p-0 avatar-sm h-auto" for="sidebarimg-04">
                              <img src="/public/assets/images/sidebar/img-4.jpg" alt="" class="avatar-md w-auto object-fit-cover" />
                            </label>
                          </div>
                        </div>
                      </div>

                      <div id="sidebar-color">
                        <h6 class="mt-4 mb-0 fw-semibold text-uppercase">
                          Primary Color
                        </h6>
                        <p class="text-muted">Choose a color of Primary.</p>

                        <div class="d-flex flex-wrap gap-2">
                          <div class="form-check sidebar-setting card-radio">
                            <input class="form-check-input" type="radio" name="data-theme-colors" id="themeColor-01" value="default" v-model="dataThemeColors" @click="store.setCustomizer('data-theme-colors', 'default')" />
                            <label class="form-check-label avatar-xs p-0" for="themeColor-01"></label>
                          </div>
                          <div class="form-check sidebar-setting card-radio">
                            <input class="form-check-input" type="radio" name="data-theme-colors" id="themeColor-02" value="green" v-model="dataThemeColors" @click="store.setCustomizer('data-theme-colors', 'green')" />
                            <label class="form-check-label avatar-xs p-0" for="themeColor-02"></label>
                          </div>
                          <div class="form-check sidebar-setting card-radio">
                            <input class="form-check-input" type="radio" name="data-theme-colors" id="themeColor-03" value="purple" v-model="dataThemeColors" @click="store.setCustomizer('data-theme-colors', 'purple')" />
                            <label class="form-check-label avatar-xs p-0" for="themeColor-03"></label>
                          </div>
                          <div class="form-check sidebar-setting card-radio">
                            <input class="form-check-input" type="radio" name="data-theme-colors" id="themeColor-04" value="blue" v-model="dataThemeColors" @click="store.setCustomizer('data-theme-colors', 'blue')" />
                            <label class="form-check-label avatar-xs p-0" for="themeColor-04"></label>
                          </div>
                        </div>
                      </div>

                      <!-- <div id="preloader-menu">
                        <h6 class="mt-4 mb-0 fw-semibold text-uppercase">
                          Preloader
                        </h6>
                        <p class="text-muted">Choose a preloader.</p>

                        <div class="row">
                          <div class="col-4">
                            <div class="form-check sidebar-setting card-radio">
                              <input class="form-check-input" type="radio" name="data-preloader" id="preloader-view-custom" value="enable" v-model="dataPreloader" @click="store.setCustomizer('data-preloader', 'enable')" />
                              <label class="form-check-label p-0 avatar-md w-100 material-shadow" for="preloader-view-custom">
                                <span class="d-flex gap-1 h-100">
                                  <span class="flex-shrink-0">
                                    <span class="bg-light d-flex h-100 flex-column gap-1 p-1">
                                      <span class="d-block p-1 px-2 bg-primary-subtle rounded mb-2"></span>
                                      <span class="d-block p-1 px-2 pb-0 bg-primary-subtle"></span>
                                      <span class="d-block p-1 px-2 pb-0 bg-primary-subtle"></span>
                                      <span class="d-block p-1 px-2 pb-0 bg-primary-subtle"></span>
                                    </span>
                                  </span>
                                  <span class="flex-grow-1">
                                    <span class="d-flex h-100 flex-column">
                                      <span class="bg-light d-block p-1"></span>
                                      <span class="bg-light d-block p-1 mt-auto"></span>
                                    </span>
                                  </span>
                                </span>
                                <div id="status" class="d-flex align-items-center justify-content-center">
                                  <div class="spinner-border text-primary avatar-xxs m-auto" role="status">
                                    <span class="visually-hidden">Loading...</span>
                                  </div>
                                </div>
                              </label>
                            </div>
                            <h5 class="fs-13 text-center mt-2">Enable</h5>
                          </div>
                          <div class="col-4">
                            <div class="form-check sidebar-setting card-radio">
                              <input class="form-check-input" type="radio" name="data-preloader" id="preloader-view-none" value="disable" v-model="dataPreloader" @click="store.setCustomizer('data-preloader', 'disable')" />
                              <label class="form-check-label p-0 avatar-md w-100 material-shadow" for="preloader-view-none">
                                <span class="d-flex gap-1 h-100">
                                  <span class="flex-shrink-0">
                                    <span class="bg-light d-flex h-100 flex-column gap-1 p-1">
                                      <span class="d-block p-1 px-2 bg-primary-subtle rounded mb-2"></span>
                                      <span class="d-block p-1 px-2 pb-0 bg-primary-subtle"></span>
                                      <span class="d-block p-1 px-2 pb-0 bg-primary-subtle"></span>
                                      <span class="d-block p-1 px-2 pb-0 bg-primary-subtle"></span>
                                    </span>
                                  </span>
                                  <span class="flex-grow-1">
                                    <span class="d-flex h-100 flex-column">
                                      <span class="bg-light d-block p-1"></span>
                                      <span class="bg-light d-block p-1 mt-auto"></span>
                                    </span>
                                  </span>
                                </span>
                              </label>
                            </div>
                            <h5 class="fs-13 text-center mt-2">Disable</h5>
                          </div>
                        </div>
                      </div> -->

                      <div id="body-img" style="display: none">
                        <h6 class="mt-4 mb-0 fw-semibold text-uppercase">
                          Background Image
                        </h6>
                        <p class="text-muted">
                          Choose a body background image.
                        </p>

                        <div class="row">
                          <div class="col-4">
                            <div class="form-check sidebar-setting card-radio">
                              <input class="form-check-input" type="radio" name="data-body-image" id="body-img-none" value="none" />
                              <label class="form-check-label p-0 avatar-md w-100" data-body-image="none" for="body-img-none">
                                <span class="d-flex gap-1 h-100">
                                  <span class="flex-shrink-0">
                                    <span class="bg-light d-flex h-100 flex-column gap-1 p-1">
                                      <span class="d-block p-1 px-2 bg-primary-subtle rounded mb-2"></span>
                                      <span class="d-block p-1 px-2 pb-0 bg-primary-subtle"></span>
                                      <span class="d-block p-1 px-2 pb-0 bg-primary-subtle"></span>
                                      <span class="d-block p-1 px-2 pb-0 bg-primary-subtle"></span>
                                    </span>
                                  </span>
                                  <span class="flex-grow-1">
                                    <span class="d-flex h-100 flex-column">
                                      <span class="bg-light d-block p-1"></span>
                                      <span class="bg-light d-block p-1 mt-auto"></span>
                                    </span>
                                  </span>
                                </span>
                              </label>
                            </div>
                            <h5 class="fs-13 text-center mt-2">None</h5>
                          </div>
                          <!-- end col -->
                          <div class="col-4">
                            <div class="form-check sidebar-setting card-radio">
                              <input class="form-check-input" type="radio" name="data-body-image" id="body-img-one" value="img-1" />
                              <label class="form-check-label p-0 avatar-md w-100" data-body-image="img-1" for="body-img-one">
                              </label>
                            </div>
                            <h5 class="fs-13 text-center mt-2">One</h5>
                          </div>
                          <!-- end col -->

                          <div class="col-4">
                            <div class="form-check sidebar-setting card-radio">
                              <input class="form-check-input" type="radio" name="data-body-image" id="body-img-two" value="img-2" />
                              <label class="form-check-label p-0 avatar-md w-100" data-body-image="img-2" for="body-img-two">
                              </label>
                            </div>
                            <h5 class="fs-13 text-center mt-2">Two</h5>
                          </div>
                          <!-- end col -->

                          <div class="col-4">
                            <div class="form-check sidebar-setting card-radio">
                              <input class="form-check-input" type="radio" name="data-body-image" id="body-img-three" value="img-3" />
                              <label class="form-check-label p-0 avatar-md w-100" data-body-image="img-3" for="body-img-three">
                              </label>
                            </div>
                            <h5 class="fs-13 text-center mt-2">Three</h5>
                          </div>
                          <!-- end col -->
                        </div>
                        <!-- end row -->
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="simplebar-placeholder" style="width: 400px; height: 2960px"></div>
          </div>
          <div class="simplebar-track simplebar-horizontal" style="visibility: hidden">
            <div class="simplebar-scrollbar" style="width: 0px; display: none"></div>
          </div>
          <div class="simplebar-track simplebar-vertical" style="visibility: visible">
            <div class="simplebar-scrollbar" style="height: 232px;transform: translate3d(0px, 0px, 0px);display: block;"></div>
          </div>
        </div>
      </div>
      <div class="offcanvas-footer border-top p-3 text-center">
        <div class="row">
          <div class="col-6">
            <button type="button" class="btn btn-light w-100" id="reset-layout" @click="clearLocalStorage">
              Reset
            </button>
          </div>
          <div class="col-6">
            <!-- <a href="https://1.envato.market/velzon-admin" target="_blank" class="btn btn-primary w-100">Buy Now</a> -->
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import { useStore } from "../stores/store.js";

export default {
  name: 'XpplAppTheme',
  setup() {
    const store = useStore();
    return { store };
  },

  data() {
    return {
      dataLayout: '',
      dataTopbar: '',
      dataSidebar: '',
      dataSidebarSize: '',
      dataSidebarImage: '',
      dataPreloader: '',
      dataTheme: '',
      dataThemeColors: '',
      dataBsTheme: '',
      dataLayoutWidth: '',
      dataLayoutPosition: '',
      dataLayoutStyle: '',
      dataBodyImage: '',
      dataSidebarVisibility: '',
      dataSidebarUser: 'false'
    };
  },

  mounted() {

  },

  methods: {
    onLoad() {
      document.documentElement.setAttribute('data-layout', this.store.dataLayout);
      document.documentElement.setAttribute('data-topbar', this.store.dataTopbar);
      document.documentElement.setAttribute('data-sidebar', this.store.dataSidebar);
      document.documentElement.setAttribute('data-sidebar-size', this.store.dataSidebarSize);
      document.documentElement.setAttribute('data-sidebar-image', this.store.dataSidebarImage);
      document.documentElement.setAttribute('data-preloader', this.store.dataPreloader);
      document.documentElement.setAttribute('data-theme', this.store.dataTheme);
      document.documentElement.setAttribute('data-theme-colors', this.store.dataThemeColors);
      document.documentElement.setAttribute('data-bs-theme', this.store.dataBsTheme);
      document.documentElement.setAttribute('data-layout-width', this.store.dataLayoutWidth);
      document.documentElement.setAttribute('data-layout-position', this.store.dataLayoutPosition);
      document.documentElement.setAttribute('data-layout-style', this.store.dataLayoutStyle);
      document.documentElement.setAttribute('data-body-image', this.store.dataBodyImage);
      document.documentElement.setAttribute('data-sidebar-visibility', this.store.dataSidebarVisibility);

      this.dataLayout = this.store.dataLayout;
      this.dataTopbar = this.store.dataTopbar;
      this.dataSidebar = this.store.dataSidebar;
      this.dataSidebarSize = this.store.dataSidebarSize;
      this.dataSidebarImage = this.store.dataSidebarImage;
      this.dataPreloader = this.store.dataPreloader;
      this.dataTheme = this.store.dataTheme;
      this.dataThemeColors = this.store.dataThemeColors;
      this.dataBsTheme = this.store.dataBsTheme;
      this.dataLayoutWidth = this.store.dataLayoutWidth;
      this.dataLayoutPosition = this.store.dataLayoutPosition;
      this.dataLayoutStyle = this.store.dataLayoutStyle;
      this.dataBodyImage = this.store.dataBodyImage;
      this.dataSidebarVisibility = this.store.dataSidebarVisibility;

      this.dataSidebarUser = this.store.dataSidebarUser;
      this.store.dataSidebarUser === 'true' ? document.documentElement.setAttribute('data-sidebar-user-show', '') : '';
    },

    sidebarUserShow() {
      document.getElementById('sidebarUserProfile')
        ?.addEventListener('click', function (e) {
          e.target.checked
            ? (document.documentElement.setAttribute('data-sidebar-user-show', ''), localStorage.setItem('data-sidebar-user', 'true')) : (document.documentElement.removeAttribute('data-sidebar-user-show'), localStorage.setItem('data-sidebar-user', 'false'));
        })
    },

    clearLocalStorage() {
      localStorage.clear();
      window.location.reload();
      // document.getElementById("theme-settings-offcanvas").classList.remove("show");
      // document.querySelector(".offcanvas-backdrop").classList.remove("show");
    },
  },

  created() {
    this.onLoad();
  }
};
</script>