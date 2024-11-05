<template>
  <div>

    <div class="chat-wrapper d-lg-flex gap-1 mx-n4 mt-n4 p-1">
      <div class="chat-leftsidebar minimal-border">
        <div class="px-4 pt-4 mb-0">
          <div class="d-flex align-items-start">
            <div class="flex-grow-1">
              <h5 class="mb-4">Categories</h5>
            </div>
            <div class="flex-shrink-0">
              <div data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-placement="bottom" aria-label="Add Contact" data-bs-original-title="Add Contact">

                <!-- Button trigger modal -->
                <button type="button" class="btn btn-soft-success btn-sm material-shadow-none">
                  <i class="ri-add-line align-bottom"></i>
                </button>
              </div>
            </div>
          </div>

        </div>



        <div class="chat-room-list pt-3 simplebar-scrollable-y" data-simplebar="init">
          <div class="simplebar-wrapper" style="margin: -16px 0px 0px;">
            <div class="simplebar-height-auto-observer-wrapper">
              <div class="simplebar-height-auto-observer"></div>
            </div>



            <div class="simplebar-mask">
              <div class="simplebar-offset" style="right: 0px; bottom: 0px;">
                <div class="simplebar-content-wrapper" tabindex="0" role="region" aria-label="scrollable content" style="height: auto; overflow: hidden scroll;">
                  <div class="simplebar-content" style="padding: 0px 0px 0px;">

                    <div class="chat-message-list">
                      <ul class="list-unstyled chat-list chat-user-list mb-0" id="channelList">


                        <li class="" v-for="(item, index) in data" :key="index" @click="Selected(item, index)" :id="'item-' + index">
                          <a href="javascript: void(0);" class="unread-msg-user">
                            <div class="d-flex align-items-center">
                              <!-- <div class="flex-shrink-0 chat-user-img align-self-center me-2 ms-0">
                                <div class="avatar-xxs">
                                  <div class="avatar-title bg-light rounded-circle text-body">#</div>
                                </div>
                              </div> -->
                              <div class="flex-grow-1 overflow-hidden">
                                <p class="text-truncate mb-0">{{ item }}</p>
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
            <div class="simplebar-placeholder" style="width: 300px; height: 650px;"></div>
          </div>
          <!-- <div class="simplebar-track simplebar-horizontal" style="visibility: hidden;">
            <div class="simplebar-scrollbar" style="width: 0px; display: none;"></div>
          </div> -->
          <!-- <div class="simplebar-track simplebar-vertical" style="visibility: visible;">
            <div class="simplebar-scrollbar" style="height: 648px; transform: translate3d(0px, 1px, 0px); display: block;"></div>
          </div> -->
        </div>






      </div>
      <!-- end chat leftsidebar -->


      <!-- Start User chat -->
      <div class="user-chat w-100 overflow-hidden minimal-border user-chat-show" id="detail">
        <!-- <div class="user-chat w-100 overflow-hidden minimal-border"> -->

        <div class="chat-content d-lg-flex">
          <!-- start chat conversation section -->
          <div class="w-100 overflow-hidden position-relative">
            <!-- conversation user -->
            <div class="position-relative">

              <div class="position-relative" id="channel-chat" style="display: block;">
                <div class="p-3 user-chat-topbar">
                  <div class="row align-items-center">
                    <div class="col-sm-4 col-8">
                      <div class="d-flex align-items-center">
                        <div class="flex-shrink-0 d-block d-lg-none me-3" @click="Back">
                          <a href="javascript: void(0);" class="user-chat-remove fs-18 p-1"><i class="ri-arrow-left-s-line align-bottom"></i></a>
                        </div>
                        <div class="flex-grow-1 overflow-hidden">
                          <div class="d-flex align-items-center">
                            <div class="flex-shrink-0 chat-user-img online user-own-img align-self-center me-3 ms-0">
                              <img src="/public/assets/images/users/multi-user.jpg" class="rounded-circle avatar-xs" alt="">
                            </div>
                            <div class="flex-grow-1 overflow-hidden">
                              <h5 class="text-truncate mb-0 fs-16" id="title"> Document Name
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
                          <div class="dropdown">
                            <button class="btn btn-ghost-secondary btn-icon" type="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                              <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-search icon-sm">
                                <circle cx="11" cy="11" r="8"></circle>
                                <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
                              </svg>
                            </button>
                            <div class="dropdown-menu p-0 dropdown-menu-end dropdown-menu-lg">
                              <div class="p-2">
                                <div class="search-box">
                                  <input type="text" class="form-control bg-light border-light" placeholder="Search here..." onkeyup="searchMessages()" id="searchMessage">
                                  <i class="ri-search-2-line search-icon"></i>
                                </div>
                              </div>
                            </div>
                          </div>
                        </li>

                        <li class="list-inline-item d-none d-lg-inline-block m-0">
                          <button type="button" class="btn btn-ghost-secondary btn-icon" data-bs-toggle="offcanvas" data-bs-target="#userProfileCanvasExample" aria-controls="userProfileCanvasExample">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-info icon-sm">
                              <circle cx="12" cy="12" r="10"></circle>
                              <line x1="12" y1="16" x2="12" y2="12"></line>
                              <line x1="12" y1="8" x2="12.01" y2="8"></line>
                            </svg>
                          </button>
                        </li>

                        <li class="list-inline-item m-0">
                          <div class="dropdown">
                            <button class="btn btn-ghost-secondary btn-icon" type="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                              <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-more-vertical icon-sm">
                                <circle cx="12" cy="12" r="1"></circle>
                                <circle cx="12" cy="5" r="1"></circle>
                                <circle cx="12" cy="19" r="1"></circle>
                              </svg>
                            </button>
                            <div class="dropdown-menu dropdown-menu-end">
                              <a class="dropdown-item d-block d-lg-none user-profile-show" href="#"><i class="ri-user-2-fill align-bottom text-muted me-2"></i> View Profile</a>
                              <a class="dropdown-item" href="#"><i class="ri-inbox-archive-line align-bottom text-muted me-2"></i> Archive</a>
                              <a class="dropdown-item" href="#"><i class="ri-mic-off-line align-bottom text-muted me-2"></i> Muted</a>
                              <a class="dropdown-item" href="#"><i class="ri-delete-bin-5-line align-bottom text-muted me-2"></i> Delete</a>
                            </div>
                          </div>
                        </li>
                      </ul>
                    </div>
                  </div>

                </div>
                <!-- end chat user head -->


                <div class="chat-conversation p-3 p-lg-4" id="chat-conversation">

                  <div class="table-responsive table-card">
                    <table class="table table-nowrap mb-0">
                      <thead class="table-light">
                        <tr>
                          <th scope="col">Id</th>
                          <th scope="col">Name</th>
                          <th scope="col">Date</th>
                          <th scope="col">Total</th>
                          <th scope="col">Status</th>
                          <th scope="col">Action</th>
                        </tr>
                      </thead>
                      <tbody>
                        <tr>
                          <td><a href="#" class="fw-semibold">#VL2110</a></td>
                          <td>William Elmore</td>
                          <td>07 Oct, 2021</td>
                          <td>$24.05</td>
                          <td><span class="badge bg-success">Paid</span></td>
                          <td>
                            <button type="button" class="btn btn-sm btn-light">Details</button>
                          </td>
                        </tr>
                        <tr>
                          <td><a href="#" class="fw-semibold">#VL2109</a></td>
                          <td>Georgie Winters</td>
                          <td>07 Oct, 2021</td>
                          <td>$26.15</td>
                          <td><span class="badge bg-success">Paid</span></td>
                          <td>
                            <button type="button" class="btn btn-sm btn-light">Details</button>
                          </td>
                        </tr>
                        <tr>
                          <td><a href="#" class="fw-semibold">#VL2108</a></td>
                          <td>Whitney Meier</td>
                          <td>06 Oct, 2021</td>
                          <td>$21.25</td>
                          <td><span class="badge bg-danger">Refund</span></td>
                          <td>
                            <button type="button" class="btn btn-sm btn-light">Details</button>
                          </td>
                        </tr>
                        <tr>
                          <td><a href="#" class="fw-semibold">#VL2107</a></td>
                          <td>Justin Maier</td>
                          <td>05 Oct, 2021</td>
                          <td>$25.03</td>
                          <td><span class="badge bg-success">Paid</span></td>
                          <td>
                            <button type="button" class="btn btn-sm btn-light">Details</button>
                          </td>
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
    </div>





  </div>
</template>

<script>
export default {
  name: 'XpplAppSaleFilemanager',

  data() {
    return {


      data: ['Documents', 'In Bounds', 'Out Bounds', 'Invoices', 'Contracts', 'Transport', 'Payments', 'Tax', 'Others',]

    };
  },

  mounted() {

  },

  methods: {


    Back() {
      document.getElementById('detail').classList.remove('user-chat-show');
    },

    async Selected(cate, index) {

      document.getElementById('detail').classList.add('user-chat-show');

      const elements = document.querySelectorAll('[id^="item-"]');
      elements.forEach((e) => e.classList.remove('active'));

      let ix = 'item-' + index;
      document.getElementById(ix).classList.add('active')
      document.getElementById('title').textContent = cate;

    },

    async cateSelected(index, cate) {
      const elements = document.querySelectorAll('.filter-list, .active');

      elements.forEach(e => {
        e.classList.remove('active');
      })

      // document.getElementById(index).classList.add('active');

      // this.lkCodeFilter = [];
      // this.lkForm.category = cate;

      // if (cate == 'Coal Grade') {
      //   this.category = 'grade'
      // } else {
      //   this.category = 'general'
      //   let item = this.lkCodeData.filter((i) => i.category == cate);
      //   this.lkCodeFilter = item;
      // }

      // const elements = document.querySelectorAll('[id^="selectMode-"]');
      // elements.forEach((e) => {
      //   e.classList.add('d-none');
      // });

      // const slected = document.getElementById(id);
      // slected.type = 'text';
      // slected.classList.remove('d-none');


    },

  },
};
</script>
