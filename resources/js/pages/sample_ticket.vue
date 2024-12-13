<template>
  <div>

    <div class="chat-wrapper d-lg-flex gap-1 mx-n4 mt-n4 p-1" v-if="sampleTemp.length == 0">
      <div class="chat-leftsidebar minimal-border">
        <div class="px-4 py-3 mb-0 border-0 pb-4">
          <div class="d-flex align-items-center">
            <div class="flex-grow-1 overflow-hidden">
              <h5 class="mb-0 text-truncate">Categories</h5>
            </div>
            <div class="flex-shrink-0">
              <button type="button" class="btn btn-soft-info btn-icon btn-sm material-shadow-none">
                <i class="ri-add-line align-bottom"></i>
              </button>
            </div>
          </div>
        </div>

        <div class="chat-room-list simplebar-scrollable-y" data-simplebar="init">
          <div class="simplebar-wrapper" style="margin: -16px 0px 0px;">
            <div class="simplebar-height-auto-observer-wrapper">
              <div class="simplebar-height-auto-observer"></div>
            </div>
            <div class="simplebar-mask">
              <div class="simplebar-offset" style="right: 0px; bottom: 0px;">
                <div class="simplebar-content-wrapper" tabindex="0" role="region" aria-label="scrollable content" style="height: auto; overflow: hidden scroll;">
                  <div class="simplebar-content" style="padding: 0px 0px 0px;">

                    <div class="chat-message-list">
                      <ul class="list-unstyled chat-list chat-user-list">
                        <li v-for="(item, index) in lkItem" :key="index" @click="selectedCate(item.label, item.value, index)" :id="'category-' + index">
                          <a href="javascript: void(0);" class="py-2">
                            <div class="d-flex align-items-center">
                              <!-- <div class="flex-shrink-0 chat-user-img align-self-center me-2 ms-0">
                                <div class="avatar-xxs">
                                  <div class="avatar-title bg-light rounded-circle text-body">#</div>
                                </div>
                              </div> -->
                              <div class="flex-grow-1 overflow-hidden">
                                <p class="text-truncate mb-0 fs-13">{{ item.label }}</p>
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
        </div>
      </div>

      <div class="user-chat w-100 overflow-hidden minimal-border user-chat-show" id="sample-detail">
        <!-- <div class="user-chat w-100 overflow-hidden minimal-border"> -->
        <div class="chat-content d-lg-flex">
          <div class="w-100 overflow-hidden position-relative">
            <div class="position-relative">

              <div class="position-relative" id="channel-chat" style="display: block;">
                <div class="p-3 user-chat-topbar border-0 pb-0">
                  <div class="row align-items-center">
                    <div class="col-sm-4 col-8">
                      <div class="d-flex align-items-center">
                        <div class="flex-shrink-0 d-block d-lg-none me-3" @click="backToMain">
                          <a href="javascript: void(0);" class="user-chat-remove fs-18 p-1"><i class="ri-arrow-left-s-line align-bottom"></i></a>
                        </div>
                        <div class="flex-grow-1 overflow-hidden">
                          <div class="d-flex align-items-center">
                            <!-- <div class="flex-shrink-0 chat-user-img online user-own-img align-self-center me-3 ms-0">
                              <img src="/public/assets/images/users/multi-user.jpg" class="rounded-circle avatar-xs" alt="">
                            </div> -->
                            <div class="flex-grow-1 overflow-hidden">
                              <h5 class="text-truncate mb-0 fs-16" id="sample-title">
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
                          <div class="d-flex gap-sm-1 email-topbar-link">
                            <button class="btn btn-sm btn-soft-info" id="btn-new" @click="newSampleTicket"><i class="ri-add-fill me-1 align-bottom"></i>New</button>
                            <!-- <button type="button" class="btn btn-ghost-secondary btn-icon btn-sm material-shadow-none">
                              <i class="bx bx-plus-circle align-bottom fs-18"></i>
                            </button>
                            <button type="button" class="btn btn-ghost-secondary btn-icon btn-sm material-shadow-none">
                              <i class="bx bx-edit align-bottom fs-18"></i>
                            </button>
                            <button type="button" class="btn btn-ghost-secondary btn-icon btn-sm material-shadow-none">
                              <i class="bx bx-trash align-bottom fs-18"></i>
                            </button>

                            <div class="dropdown">
                              <button class="btn btn-ghost-secondary btn-icon btn-sm material-shadow-none" type="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="bx bx-dots-vertical-rounded align-bottom fs-18"></i>
                              </button>
                              <div class="dropdown-menu dropdown-menu-end">
                                <a class="dropdown-item" href="#">Mark as Unread</a>
                                <a class="dropdown-item" href="#">Mark as Important</a>
                                <a class="dropdown-item" href="#">Add to Tasks</a>
                                <a class="dropdown-item" href="#">Add Star</a>
                                <a class="dropdown-item" href="#">Mute</a>
                              </div>
                            </div> -->
                          </div>
                        </li>
                      </ul>
                    </div>
                  </div>

                </div>
                <!-- end chat user head -->


                <!-- <div class="chat-conversation p-3 p-lg-3"> -->
                <div class="chat-conversation">

                  <!-- <div class="table-responsive table-card">
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
                  </div> -->
                  <div class="custom-grid p-3">
                    <ag-grid-vue style="height: calc(100vh - 14.2rem);" class="ag-theme-quartz" :columnDefs="columnDefs" :rowData="filtered" :defaultColDef="defaultColDef" :rowHeight="36" :headerHeight="44" :suppressMenuHide="false" :suppressCellFocus="true" animateRows="false" rowSelection="single"></ag-grid-vue>
                  </div>


                </div>
              </div>






            </div>
          </div>
        </div>
      </div>
    </div>



    <!-- <button v-if="sampleList.length == 0" type="button" class="btn btn-soft-info add-btn d-print-none" data-bs-toggle="modal" href="#sample-ticket-modal"><i class="ri-add-line align-bottom me-1"></i> New Sample Ticket</button> -->



    <div class="row justify-content-center" v-if="sampleTemp.length > 0">
      <div class="col-xxl-7 col-lg-8">
        <div class="card">

          <div class="row">
            <div class="col-lg-12 d-print-none">
              <div class="card-body p-4 border-bottom border-bottom-dashed">
                <div class="hstack gap-2 justify-content-end">
                  <button type="button" class="btn btn-light" @click="cancelToPrint"><i class="ri-close-line align-middle"></i> Cancel</button>
                  <button type="button" class="btn btn-success" @click="printSample"><i class=" ri-save-3-line align-middle"></i> Print</button>
                  <!-- <a href="javascript:window.print()" class="btn btn-success"><i class="ri-printer-line align-bottom"></i> Print</a> -->
                </div>
              </div>
            </div>

            <div class="col-lg-12">
              <div class="card-body">
                <div class="table-responsive">
                  <table class="table align-middle table-borderless table-nowrap mb-0 table-sm">
                    <tbody v-for="(item, index) in sampleTemp" :key="index">
                      <tr>
                        <td class="py-0">Sample ID</td>
                        <td class="py-0"><input type="text" style="height: 23px; margin-bottom: 2px;" class="form-control fw-medium" v-model="item.sample_id" readonly></td>
                        <td class="py-0"></td>
                        <td class="py-0"></td>
                        <td class="py-0 fs-20 fw-medium text-center" rowspan="2">ID</td>
                        <td class="py-0" rowspan="2"><input type="text" style="height: 42px;" class="form-control border-dashed fs-24 fw-semibold py-0 text-center border-2" v-model="item.sample_id" readonly></td>
                      </tr>
                      <tr>
                        <td v-if="itemId == 1" class="py-0">Sample Type</td>
                        <td v-else-if="itemId == 4" class="py-0">Trench ID</td>
                        <td v-else class="py-0">Hole ID</td>
                        <td class="py-0"><input type="text" style="height: 23px; margin-bottom: 2px;" class="form-control" readonly></td>
                        <td class="py-0">East</td>
                        <td class="py-0"><input type="text" style="height: 23px; margin-bottom: 2px;" class="form-control" readonly></td>
                      </tr>
                      <tr>
                        <td class="py-0">From</td>
                        <td class="py-0"><input type="text" style="height: 23px; margin-bottom: 2px;" class="form-control" readonly></td>
                        <td class="py-0">North</td>
                        <td class="py-0"><input type="text" style="height: 23px; margin-bottom: 2px;" class="form-control" readonly></td>
                        <td class="py-0 fs-20 fw-medium text-center" rowspan="2">ID</td>
                        <td class="py-0" rowspan="2"><input type="text" style="height: 42px;" class="form-control border-dashed fs-24 fw-semibold py-0 text-center border-2" v-model="item.sample_id" readonly></td>
                      </tr>
                      <tr>
                        <td class="py-0">To</td>
                        <td class="py-0"><input type="text" style="height: 23px; margin-bottom: 2px;" class="form-control" readonly></td>
                        <td class="py-0">RL</td>
                        <td class="py-0"><input type="text" style="height: 23px; margin-bottom: 2px;" class="form-control" readonly></td>
                      </tr>
                      <tr>
                        <td class="py-0">Date</td>
                        <td class="py-0"><input type="text" style="height: 23px; margin-bottom: 2px;" class="form-control" readonly></td>
                        <td class="py-0">Area</td>
                        <td class="py-0"><input type="text" style="height: 23px; margin-bottom: 2px;" class="form-control" readonly></td>
                        <td class="py-0 fs-20 fw-medium text-center" rowspan="2">ID</td>
                        <td class="py-0" rowspan="2" style="width: 170px;"><input type="text" style="height: 42px;" class="form-control border-dashed fs-24 fw-semibold py-0 text-center border-2" v-model="item.sample_id" readonly></td>
                      </tr>
                      <tr>
                        <td class="py-0">Sampler</td>
                        <td class="py-0"><input type="text" style="height: 23px; margin-bottom: 2px;" class="form-control" readonly></td>
                        <td class="py-0"></td>
                        <td class="py-0"></td>
                      </tr>
                    </tbody>
                  </table>
                </div>
              </div>

              <!-- <div class="col-lg-12">
                <div class="card-body p-4 pt-0">
                  <div class="hstack gap-2 justify-content-end d-print-none">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal" @click="viewMode = 'main'"><i class="ri-close-line me-1 align-middle"></i> Close</button>
                    <a href="javascript:window.print()" class="btn btn-success"><i class="ri-printer-line align-bottom me-1"></i> Print</a>
                    <a href="javascript:void(0);" class="btn btn-primary"><i class="ri-download-2-line align-bottom me-1"></i> Download</a>
                  </div>
                </div>
              </div> -->

            </div>
          </div>
        </div>
      </div>
    </div>



    <!-- New Sample Ticket Modal -->
    <div class="modal fade zoomIn" id="sample-ticket-modal" data-bs-keyboard="false" tabindex="-1" aria-modal="true" role="dialog">
      <div class="modal-dialog modal-sm modal-dialog-centered">
        <div class="modal-content">
          <div class="modal-header bg-light p-3">
            <h5 class="modal-title" id="modal-title">Add</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <!-- <div class="mb-3">
              <label class="form-label">Item <span class="text-danger">*</span></label>
              <multiselect placeholder="Select item" :options="lkItem" v-model="itemId" @select="lastNumber(itemId)" />
            </div> -->
            <div class="mb-3">
              <label class="form-label">Last Number </label>
              <input type="text" class="form-control" placeholder="Last number" v-model="last_number" readonly>
            </div>
            <div class="mb-3">
              <label class="form-label">Next Number </label>
              <input type="text" class="form-control" placeholder="Next number" v-model="next_number" readonly>
            </div>
            <div>
              <label class="form-label">Amount <span class="text-danger">*</span></label>
              <cleave :options="int" class="form-control" placeholder="Enter amount" v-model="amount" @keydown.enter="generateSample" />
            </div>
          </div>
          <div class="modal-footer" style="display: block;">
            <div class="hstack gap-2 justify-content-end">
              <button type="button" class="btn btn-light" data-bs-dismiss="modal">{{ $t('close-btn') }}</button>
              <button type="button" id="contract-upd" class="btn btn-success" :class="addDis" @click="generateSample">Generate</button>
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
import { useAuthStore } from '../stores/auth.js';
import { useToastr } from '../toastr.js';
const toastr = useToastr();


export default {
  name: 'XpplAppSampleTicket',
  components: { AgGridVue },
  setup() {
    const authStore = useAuthStore();
    return { authStore };
  },

  data() {
    return {
      columnDefs: [

        { headerName: 'Item ID', field: 'item', minWidth: 80, maxWidth: 100, hide: true, filter: 'agSetColumnFilter', },
        { headerName: 'Sample ID', field: 'sample_id', minWidth: 120, maxWidth: 150, filter: 'agNumberColumnFilter', valueGetter: p => Number(p.data.sample_id) },
        {
          headerName: 'Print Status', field: 'status', maxWidth: 120, filter: 'agSetColumnFilter',
          cellRenderer: (p) => {
            if (p.value == false) {
              return 'No';
            } else {
              return 'Yes';
            }
          }
        },
        { headerName: 'Created at', field: 'created_at', valueFormatter: p => p.value ? moment(p.value).format('DD-MM-YYYY HH:mm:ss') : '' },
        { headerName: 'Created by', field: 'created_by', filter: 'agSetColumnFilter' },
        { headerName: 'Printed at', field: 'printed1_at', valueFormatter: p => p.value ? moment(p.value).format('DD-MM-YYYY HH:mm:ss') : '' },
        { headerName: 'Printed by', field: 'printed1_by', filter: 'agSetColumnFilter' },
      ],

      defaultColDef: {
        sortable: true,
        resizable: true,
        flex: 1,
        filterParams: { buttons: ['reset'] },
        minWidth: 80,
        cellClassRules: { 'pointer': 'true' },
        // menuTabs: ['filterMenuTab', 'generalMenuTab', 'columnsMenuTab']
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

      lkItem: [
        { value: 1, label: 'Grab Sample' },
        { value: 2, label: 'RES Drilling' },
        { value: 3, label: 'GC Drilling' },
        { value: 4, label: 'Trenching' },
      ],

      sampleTickets: [],
      filtered: [],


      sampleTemp: [],
      itemId: '',
      itemName: '',
      index: '',
      last_number: '',
      next_number: '',
      amount: '',
      auth: [],

    };
  },

  mounted() {

  },

  computed: {
    addDis() {
      if (this.itemId == null || this.last_number == '' || this.amount == '') {
        return 'disabled';
      } else {
        return '';
      }
    }
  },

  methods: {
    async onLoad() {
      const submenu = 'M04S02';
      const authorise = await axios.get(`api/auth/auth-action?submenu=${submenu}`, { headers: { Authorization: 'Bearer ' + this.authStore.getToken } });
      this.auth = authorise.data[0];

      const sample = await this.getSampleTicket();
      const select = await this.selectedCate('Grab Sample', 1, 0)

      const from = '2024/09/01';
      const to = '2024/09/02';

      const datas = await axios.get(`api/salesdata?from=${from}&to=${to}`);

      console.log(this.sampleTickets);

    },

    async getSampleTicket() {
      const result = await axios.get('api/geology/sampletickets', { headers: { Authorization: 'Bearer ' + this.authStore.getToken } });
      this.sampleTickets = result.data;
    },

    async selectedCate(cate, id, index) {
      this.itemId = id;
      this.itemName = cate;
      this.index = index;

      document.getElementById('sample-detail').classList.add('user-chat-show');
      const elements = document.querySelectorAll('[id^="category-"]');
      elements.forEach((e) => e.classList.remove('active'));

      let ix = 'category-' + this.index;
      document.getElementById(ix).classList.add('active')
      document.getElementById('sample-title').textContent = this.itemName;

      let items = this.sampleTickets.filter((e) => e.item == this.itemId);
      this.filtered = items;
    },

    newSampleTicket() {
      let item = this.lkItem.find(e => e.value == this.itemId);
      document.getElementById('modal-title').textContent = item.label;

      const maxValue = Math.max(...this.filtered.map(e => e.sample_id));
      this.last_number = maxValue;
      this.next_number = maxValue + 1;
      this.sampleTemp = [];
      this.amount = '';
      $('#sample-ticket-modal').modal('show');
    },

    backToMain() {
      document.getElementById('sample-detail').classList.remove('user-chat-show');
    },

    async cancelToPrint() {
      this.filtered = [];
      this.sampleTemp = [];
      setTimeout(() => {
        document.getElementById('sample-title').textContent = this.itemName;
      })
      const del = await axios.post('api/geology/del-sampleticket', {
        from: this.next_number,
        to: Number(this.last_number) + Number(this.amount)
      }, { headers: { Authorization: 'Bearer ' + this.authStore.getToken } });

      const sam = await this.getSampleTicket();
      const sel = await this.selectedCate(this.itemName, this.itemId, this.index)
    },

    printSample() {
      window.print();

      setTimeout(() => {
        this.$swal.fire({
          // text: 'Are you sure? You wish to update printed status in the database.',
          text: 'ທ່ານແນ່ໃຈບໍ່?: ທ່ານຕ້ອງການປ່ຽນແປງສະຖານະນ້ຳເບີຕົວຢ່າງເປັນພິມແລ້ວ.',
          icon: 'question',
          showCancelButton: true,
          confirmButtonText: '<i class="fe fe-trash-2"></i> <span class="fs-14 fw-light">ຕ້ອງການ</span>',
          cancelButtonText: '<i class="fe fe-x"></i> <span class="fs-14 fw-light">ຍົກເລີກ</span>',
          allowEnterKey: false,
          allowOutsideClick: false,
        }).then((ans) => {
          if (ans.isConfirmed) {

            axios.post('api/geology/upd-sampleticket', {
              from: this.next_number,
              to: Number(this.last_number) + Number(this.amount)
            }, { headers: { Authorization: 'Bearer ' + this.authStore.getToken } }).then((result) => {

              this.filtered = [];
              this.sampleTemp = [];
              setTimeout(() => {
                document.getElementById('sample-title').textContent = this.itemName;
              })
              this.getSampleTicket();

              setTimeout(() => {
                this.selectedCate(this.itemName, this.itemId, this.index)
              }, 1000);

            })
          }
          //else {
          //  this.cancelToPrint();
          //}
        });
      });
    },

    generateSample() {
      if (this.auth.new == 0) {
        toastr.warning("You're not authorized to add!");
      } else {

        let check = this.filtered.filter(e => e.item == this.itemId && e.status == 0);
        if (check.length > 0) {
          // toastr.error('Some sample IDs have not yet been printed; please double-check.');
          toastr.error('ນ້ຳເບີຕົວຢ່າງຈຳນວນໜື່ງຍັງບໍ່ທັນໄດ້ພິມອອກ; ກະລຸນນາກວດຄືນ.');
        } else {

          $('#sample-ticket-modal').modal('hide');
          this.$swal.fire({
            // text: 'Are you sure? You wish to produce and insert sample ids into the database.',
            text: 'ທ່ານແນ່ໃຈບໍ? ທ່ານຕ້ອງການນຳນ້ຳເບີຕົວຢ່າງເຂົ້າໄປໃນຖານຂໍ້ມູນ.',
            icon: 'question',
            showCancelButton: true,
            confirmButtonText: '<i class="fe fe-trash-2"></i> <span class="fs-14 fw-light">ຕ້ອງການ</span>',
            cancelButtonText: '<i class="fe fe-x"></i> <span class="fs-14 fw-light">ຍົກເລີກ</span>',
            allowEnterKey: false,
            allowOutsideClick: false,
          }).then((ans) => {
            if (ans.isConfirmed) {

              for (let i = 1; i <= Number(this.amount); i++) {
                this.sampleTemp.push({
                  sample_id: Number(this.last_number) + i
                })
              };

              axios.post('api/geology/add-sampleticket', {
                item: this.itemId,
                list: this.sampleTemp
              }, { headers: { Authorization: 'Bearer ' + this.authStore.getToken } }).then((result) => {
                this.getSampleTicket();
              });

            }
          });
        }
      }
    },

  },

  created() {
    this.onLoad();
  }
};
</script>