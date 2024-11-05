<template>
  <div>
    <div class="card" v-if="viewMode == 'main'">
      <div class="card-header">
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
                <input type="text" id="selectMode-1" class="form-control flatpickr-input flatpickr-single rounded-start-2 cursor-pointer" placeholder="Select date" aria-label="Text input with dropdown button" v-model="selectDate" @input="getData('d')">
                <input type="month" id="selectMode-2" class="form-control rounded-start-2 d-none" aria-label="Text input with dropdown button" v-model="selectMonth" @input="getData('m')">
                <input type="text" id="selectMode-3" class="form-control flatpickr-input flatpickr-range rounded-start-2 cursor-pointer d-none" placeholder="Select date range" aria-label="Text input with dropdown button" v-model="selectRange" @input="getRangeData('r')">

                <div id="selectMode-4" class="d-none">
                  <multiselect style="width: 223px; border-top-right-radius: 0px; border-bottom-right-radius: 0px;" aria-label="Text input with dropdown button" placeholder="Select year" :options="lkYear" v-model="selectYear" @select="getData('y')" />
                </div>

                <button class="btn btn-success dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">{{ selectBy }}</button>
                <ul class="dropdown-menu dropdown-menu-end dropdownmenu-secondary" style="">
                  <li><a class="dropdown-item" id="selectBy-1" href="#" @click="getSalesDate">Date</a></li>
                  <li><a class="dropdown-item" id="selectBy-2" href="#" @click="getSalesMonth">Month</a></li>
                  <li><a class="dropdown-item" id="selectBy-3" href="#" @click="getSalesYear">Year</a></li>
                  <li><a class="dropdown-item" id="selectBy-4" href="#" @click="getSalesRange">Range</a></li>
                  <!-- <li><a class="dropdown-item disabled" href="#" @click="eportExecel()">Export</a></li> -->
                </ul>
                <button type="button" class="btn btn-info" title="Refresh current data" @click="getSalesDate"><i class="ri-refresh-line align-middle"></i></button>

              </div>
              <!-- <button class="btn btn-soft-info btn-icon" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                <i class="ri-more-2-fill fs-16"></i>
              </button>
              <ul class="dropdown-menu dropdown-menu-end dropdownmenu-secondary">
                <li><a class="dropdown-item disabled" id="contract-dw-1" href="javascript:void(0);" @click="viewContract()"><i class="ri-eye-fill align-bottom me-2 text-muted"></i>View</a></li>
                <li><a class="dropdown-item disabled" id="contract-dw-2" href="javascript:void(0);" @click="editContract()"><i class="ri-pencil-fill align-bottom me-2 text-muted"></i>Edit</a></li>
                <li><a class="dropdown-item disabled" id="contract-dw-3" href="javascript:void(0);" @click="delContract()"><i class="ri-delete-bin-fill align-bottom me-2 text-muted"></i>Delete</a></li>
                <div class="dropdown-divider"></div>
                <li><a class="dropdown-item disabled" id="contract-dw-4" href="javascript:void(0);" @click="orderOpen()"><i class="ri-todo-fill align-bottom me-2 text-muted"></i>Orders</a></li>
                <li><a class="dropdown-item disabled" id="contract-dw-5" href="javascript:void(0);" @click="editAttachment()"><i class="ri-attachment-line align-bottom me-2 text-muted"></i>Attachments</a></li>
              </ul> -->
            </div>

          </div>
        </div>
      </div>
      <div v-if="loading">
        <loading />
      </div>
      <div v-else>
        <ag-grid-vue style="height: calc(100vh - 15.65rem);" id="ag-sales-data" class="ag-theme-material" :columnDefs="columnDefs" :rowData="salesList" :defaultColDef="defaultColDef" :rowHeight="36" :headerHeight="44" :popupParent="popupParent" :suppressMenuHide="false" :suppressCellFocus="true" animateRows="false" rowSelection="single" @rowClicked="cellCicked" @cell-double-clicked="viewContract"></ag-grid-vue>
      </div>
    </div>

    <!-- View -->
    <div class="row justify-content-center" v-if="viewMode == 'view'">
      <div class="col-xxl-8 col-lg-9">
        <div class="card" id="demo">
          <div class="row">
            <div class="col-lg-12">
              <div class="card-header border-bottom-dashed p-4">
                <div class="d-xl-flex">
                  <div>
                    <a href="index.html" class="d-inline-block auth-logo">
                      <img src="/public/assets/images/logo-light.png" alt="" height="50">
                    </a>
                  </div>
                  <div class="flex-grow-1 ms-xl-2 mt-2 mt-xl-0">
                    <h5 class="text-uppercase fw-semibold">XEKONG POWER PLANT CO,.LTD</h5>
                    <!-- <div class="mt-xl-4 mt-4"> -->
                    <!-- <h6 class="text-muted text-uppercase fw-semibold">Address</h6> -->
                    <p class="mb-1">Email: info@phonesackgroup.com</p>
                    <p class="mb-1">Tel: +856 20 9516 6951</p>
                    <!-- <p class="mb-1"><span class="text-muted">Country: </span>{{ customerFilter.country }}</p>
                    <p class="mb-1"><span class="text-muted">Destination: </span>{{ customerFilter.destination }}</p>
                    <p class="mb-1"><span class="text-muted">Tax Code: </span>{{ customerFilter.tax_code }}</p> -->
                    <!-- </div> -->
                  </div>

                  <div class="flex-shrink-0 mt-xl-0 mt-3">
                    <h5 class="text-uppercase fw-semibold">WEIGHT TICKET</h5>
                    <h6><span class="text-muted fw-normal">ID: </span><span>{{ selectedData.TicketId }}</span></h6>
                    <h6><span class="text-muted fw-normal">WS Code: </span><span>{{ selectedData.WeightStationCode }}</span></h6>
                    <!-- <h6><span class="text-muted fw-normal">Customer Code: </span><span>{{ customerFilter.customer_code }}</span></h6>
                  <h6><span class="text-muted fw-normal">Tax Code: </span><span> {{ customerFilter.tax_code }}</span></h6>
                  <h6><span class="text-muted fw-normal">Email: </span><span>{{ customerFilter.email }}</span></h6>
                  <h6><span class="text-muted fw-normal">Contact: </span><span> {{ customerFilter.contract }}</span></h6>
                  <h6><span class="text-muted fw-normal">Contact No: </span><span> {{ customerFilter.phone }}</span></h6> -->
                  </div>
                </div>
              </div>
            </div>

            <div class="col-lg-12">
              <div class="card-header p-4 border-0">
                <div class="d-xl-flex">
                  <div class="flex-grow-1">
                    <!-- <h6 class="text-muted text-uppercase fw-semibold">Contract Details</h6> -->
                    <!-- <div class="row"> -->
                    <!-- <div class="col-lg-6"> -->
                    <p class="mb-1"><span class="text-muted">Contract No: </span>{{ selectedData.ContractNo }}</p>
                    <p class="mb-1"><span class="text-muted">CO No: </span>{{ selectedData.CoNo }}</p>
                    <p class="mb-1"><span class="text-muted">Invoice No: </span>{{ selectedData.InvoiceNo }}</p>
                    <p class="mb-1"><span class="text-muted">CargoLot: </span>{{ selectedData.CargoLotNo }}</p>
                    <p class="mb-3"><span class="text-muted">Customer: </span>{{ selectedData.CustomerName }}</p>
                    <p class="mb-1"><span class="text-muted">Truck No: </span>{{ selectedData.TruckPlate }}</p>
                    <!-- <p class="mb-1"><span class="text-muted">Signed Date: </span>{{ store.fullMonth(customerFilter.signed_date) }}</p> -->
                    <!-- </div> -->
                    <div class="col-12">
                      <p class="mb-1"><span class="text-muted">Note: </span>{{ selectedData.DataNote }}</p>
                      <!-- <p class="mb-1"><span class="text-muted">Delivery Place: </span>{{ customerFilter.delivery_place }}</p> -->
                    </div>
                    <!-- </div> -->
                  </div>
                  <div class="flex-shrink-0 mt-xl-0 mt-3">
                    <p class="mb-1"><span class="text-muted">Time In: </span>{{ store.dateTime(selectedData.DateIn) }} </p>
                    <p class="mb-1"><span class="text-muted">Time Out: </span>{{ store.dateTime(selectedData.DateOut) }}</p>
                    <p class="mb-3"><span class="text-muted">Product: </span>{{ selectedData.ProductName }}</p>
                    <h6 class=""><span class="text-muted">Gross Weight: </span>{{ store.numInt(selectedData.GrossWeight) }} Kg</h6>
                    <h6 class=""><span class="text-muted">Truck Weight: </span>{{ store.numInt(selectedData.TruckWeight) }} Kg</h6>
                    <h6 class=""><span class="text-muted">Net Weight: </span>{{ store.numInt(selectedData.NetWeight) }} Kg</h6>
                    <!-- <p class="mb-1"><span class="text-muted">Status: </span>
                    <span v-if="customerFilter.contract_status == 'Active'" class="badge bg-danger-subtle text-danger fs-14 ms-1">{{ customerFilter.contract_status }}</span>
                    <span v-else class="badge bg-success-subtle text-success fs-14 me-1">{{ customerFilter.contract_status }}</span>
                  </p> -->
                  </div>
                </div>
              </div>
            </div>

            <div class="col-lg-12">



              <!-- <div class="col-lg-12" v-if="customerFilter.contract_remarks">
              <div class="card-body p-4 border-top border-top-dashed">
                <div class="alert alert-info m-0">
                  <p class="mb-0"><span class="fw-semibold">NOTES:</span>
                    <span id="note"> {{ customerFilter.contract_remarks }}
                    </span>
                  </p>
                </div>
              </div>
            </div> -->

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
    </div>
  </div>
</template>

<script>
import axios from "axios";
import { AgGridVue } from "ag-grid-vue3";
import "ag-grid-community/styles/ag-grid.css";
import "ag-grid-community/styles/ag-theme-material.css";
import "ag-grid-enterprise";
import flatpickr from "flatpickr";
import { useStore } from '../stores/store.js';
import { useToastr } from "../toastr.js";
import { useAuthStore } from '../stores/auth.js';
const toastr = useToastr();

export default {
  name: 'XpplAppSaleData',
  components: { AgGridVue },
  setup() {
    const store = useStore();
    const authStore = useAuthStore();
    return { store, authStore };
  },

  data() {
    return {
      columnDefs: [
        { headerName: '#', maxWidth: 60, valueGetter: (params) => { return params.node.rowIndex + 1 } },
        { headerName: 'WID', field: 'WId', minWidth: 70, filter: 'agSetColumnFilter' },
        { headerName: 'Ticket ID', field: 'TicketId', minWidth: 100, filter: 'agSetColumnFilter' },
        { headerName: 'Dest Port', field: 'DestPort', filter: 'agSetColumnFilter' },
        { headerName: 'Truck Plate', field: 'TruckPlate', minWidth: 100, filter: 'agSetColumnFilter' },
        { headerName: 'Weighing Type', field: 'WeighingType', filter: 'agSetColumnFilter' },
        { headerName: 'Order No', field: 'OrderNo', filter: 'agSetColumnFilter' },
        { headerName: 'Year', field: 'y', hide: true, filter: 'agSetColumnFilter' },
        { headerName: 'Month', field: 'm', hide: true, filter: 'agSetColumnFilter' },
        {
          headerName: "Date", minWidth: 100, maxWidth: 120, valueGetter: p => {
            if (p.data.Date) {
              return moment(p.data.Date).format("DD-MM-YYYY")
            }
          },
          filter: 'agMultiColumnFilter',
          filterParams: {
            filters: [
              {
                filter: 'agDateColumnFilter',
                filterParams: {
                  comparator: (filterDate, cellValue) => {
                    const dateParts = cellValue.split("-");
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
        { headerName: 'Date In', field: 'DateIn', minWidth: 155, valueFormatter: p => p.value ? moment(p.value).format('DD-MM-YYYY HH:mm:ss') : '' },
        { headerName: 'Date Out', field: 'DateOut', minWidth: 155, valueFormatter: p => p.value ? moment(p.value).format('DD-MM-YYYY HH:mm:ss') : '' },
        {
          headerName: 'Weight In', field: 'WeightIn',
          valueGetter: p => Number(p.data.WeightIn),
          valueFormatter: p => p.value ? p.value.toLocaleString('en-US', { minimumFractionDigits: 0, maximumFractionDigits: 0 }) : '',
          filter: 'agMultiColumnFilter',
          filterParams: {
            filters: [
              { filter: 'agNumberColumnFilter' },
              // { filter: 'agSetColumnFilter' },
            ]
          }
        },
        {
          headerName: 'Weight Out', field: 'WeightOut', filter: 'agNumberColumnFilter',
          valueGetter: p => Number(p.data.WeightOut),
          valueFormatter: p => p.value ? p.value.toLocaleString('en-US', { minimumFractionDigits: 0, maximumFractionDigits: 0 }) : ''
        },
        {
          headerName: 'Gross Weight', field: 'GrossWeight', filter: 'agNumberColumnFilter',
          valueGetter: p => Number(p.data.GrossWeight),
          valueFormatter: p => p.value ? p.value.toLocaleString('en-US', { minimumFractionDigits: 0, maximumFractionDigits: 0 }) : ''
        },
        {
          headerName: 'Truck Weight', field: 'TruckWeight', filter: 'agNumberColumnFilter',
          valueGetter: p => Number(p.data.TruckWeight),
          valueFormatter: p => p.value ? p.value.toLocaleString('en-US', { minimumFractionDigits: 0, maximumFractionDigits: 0 }) : ''
        },
        { headerName: 'Tare', field: 'Tare', hide: true, filter: 'agSetColumnFilter' },
        {
          headerName: 'Net Weight', field: 'NetWeight', filter: 'agNumberColumnFilter',
          valueGetter: p => Number(p.data.NetWeight),
          valueFormatter: p => p.value ? p.value.toLocaleString('en-US', { minimumFractionDigits: 0, maximumFractionDigits: 0 }) : ''
        },
        { headerName: 'Product Name', field: 'ProductName', filter: 'agSetColumnFilter' },
        { headerName: 'Grade', field: 'Grade', hide: true, filter: 'agSetColumnFilter' },
        { headerName: 'Grade GAR', field: 'Grade_GAR', filter: 'agSetColumnFilter' },
        { headerName: 'CargoLot No', field: 'CargoLotNo', filter: 'agSetColumnFilter' },
        { headerName: 'Customer Id', field: 'CustomerId', hide: true, filter: 'agSetColumnFilter' },
        { headerName: 'Customer Name', field: 'CustomerName', minWidth: 200, filter: 'agSetColumnFilter' },
        { headerName: 'Cargo Company', field: 'CargoCompany', minWidth: 150, filter: 'agSetColumnFilter' },
        { headerName: 'Cargo Name', field: 'CargoName', filter: 'agSetColumnFilter' },
        { headerName: 'Contract No', field: 'ContractNo', minWidth: 150, filter: 'agSetColumnFilter' },
        { headerName: 'Invoice No', field: 'InvoiceNo', filter: 'agSetColumnFilter' },
        { headerName: 'Co No', field: 'CoNo', filter: 'agSetColumnFilter' },
        { headerName: 'Driver Name', field: 'DriverName', filter: 'agSetColumnFilter' },
        { headerName: 'Passport ID', field: 'PassportID' },
        { headerName: 'Truck Conuntry', field: 'TruckCounty', filter: 'agSetColumnFilter' },
        { headerName: 'Truck Wheel', field: 'TruckWheel', filter: 'agSetColumnFilter' },
        { headerName: 'Weight Station', field: 'WeightStationCode', filter: 'agSetColumnFilter' },
        { headerName: 'Create User', field: 'CreateUser', hide: true, filter: 'agSetColumnFilter' },
        { headerName: 'Note', field: 'DataNote' },

      ],

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

      salesData: [],
      selectedData: [],
      selectDate: '',
      selectMonth: '',
      selectYear: '',
      selectRange: '',
      selectBy: 'Date',
      lkYear: '',
      search: '',
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

    setInterval(() => {
      this.getSalesDate();
    }, 300000);
  },

  computed: {
    salesList() {
      if (this.search.trim().length > 0) {
        return this.salesData.filter((i) =>
          i.Date.substring(0, this.search.trim().length).toLowerCase() == this.search.trim().toLowerCase() ||
          i.DestPort.substring(0, this.search.trim().length).toLowerCase() == this.search.trim().toLowerCase() ||
          i.InvoiceNo.substring(0, this.search.trim().length).toLowerCase() == this.search.trim().toLowerCase() ||
          i.ContractNo.substring(0, this.search.trim().length).toLowerCase() == this.search.trim().toLowerCase() ||
          i.WId.substring(0, this.search.trim().length).toLowerCase() == this.search.trim().toLowerCase() ||
          i.TruckPlate.substring(0, this.search.trim().length).toLowerCase() == this.search.trim().toLowerCase() ||
          i.CustomerName.substring(0, this.search.trim().length).toLowerCase() == this.search.trim().toLowerCase()
        );
      };
      return this.salesData;
    },
  },

  methods: {
    async onLoad() {
      this.loading = true;

      // const lastDate = await axios.get('api/dashboard-sale/last-date', { headers: { Authorization: 'Bearer ' + this.authStore.getToken } });
      // this.selectDate = moment(lastDate.data[0].lastDate).format('YYYY-MM-DD');

      this.selectDate = moment(new Date().getTime()).format('YYYY-MM-DD');
      // const fp = flatpickr('#selectMode-1', {
      //   altInput: true,
      //   altFormat: 'd-m-Y'
      // });
      // fp.setDate(this.selectDate);
      const sale = await this.getData('d');

      const year = await axios.get('api/sales/sale-year', { headers: { Authorization: 'Bearer ' + this.authStore.getToken } });
      this.lkYear = year.data;

      document.getElementById('selectBy-1').classList.add('disabled');

      this.loading = false;
    },

    functionSelect(id) {
      const elements = document.querySelectorAll('[id^="selectMode-"]');
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

    async getData(by) {
      this.loading = true;
      this.salesData = [];
      let value = '';

      if (by == 'd') {
        value = this.selectDate;
      } else if (by == 'm') {
        value = this.selectMonth;
      } else if (by == 'y') {
        value = this.selectYear;
      }
      const date = await axios.get(`api/sales/sale-data?value=${value}&by=${by}`, { headers: { Authorization: 'Bearer ' + this.authStore.getToken } });
      this.salesData = date.data;

      this.loading = false;
    },

    async getRangeData(by) {
      this.salesData = [];
      let dateFr = moment(this.selectRange.substring(0, 10)).format('YYYY-MM-DD');
      let dateTo = moment(this.selectRange.substring(14, 24)).format('YYYY-MM-DD');

      if (this.selectRange && this.selectRange.length > 12) {
        this.loading = true;
        const date = await axios.get(`api/sales/sale-data?dateFr=${dateFr}&dateTo=${dateTo}`, { headers: { Authorization: 'Bearer ' + this.authStore.getToken } });
        this.salesData = date.data;
        this.loading = false;
      }
    },

    async getSalesDate() {
      this.salesData = [];
      this.selectBy = 'Date';
      this.functionSelect('selectMode-1');
      this.disableDropdown('selectBy-1');

      this.selectDate = moment(new Date().getTime()).format('YYYY-MM-DD');
      const fp = flatpickr('#selectMode-1', {
        altInput: true,
        altFormat: 'd-m-Y'
      });
      fp.setDate(this.selectDate);
      const sale = await this.getData('d');
    },

    async getSalesMonth() {
      this.salesData = [];
      this.selectMonth = '';
      this.selectBy = 'Month';
      this.functionSelect('selectMode-2');
      this.disableDropdown('selectBy-2');

      const slected = document.getElementById('selectMode-2');
      slected.type = 'month';
      slected.classList.remove('d-none');

      // const currentDate = new Date();
      // let y = currentDate.getFullYear();
      // let m = String(currentDate.getMonth() + 1).padStart(2, '0');

      // this.selectMonth = `${y}-${m}`;
      // const data = await this.getData('m')

      // const months = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];
      // const currentMonthName = months[currentDate.getMonth()];
    },

    async getSalesYear() {
      this.salesData = [];
      this.selectYear = '';
      this.selectBy = 'Year';
      this.functionSelect('selectMode-4');
      this.disableDropdown('selectBy-3');

      // const currentDate = new Date();
      // let y = currentDate.getFullYear();
      // this.selectYear = `${y}`;
      // const data = await this.getData('y')
    },

    async getSalesRange() {
      this.selectBy = 'Range';
      this.functionSelect('selectMode-3');
      this.disableDropdown('selectBy-4');
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

    disableDropdown(id) {
      const elements = document.querySelectorAll('[id^="selectBy-"]');
      elements.forEach((e) => {
        e.classList.remove('disabled');
      });
      document.getElementById(id).classList.add('disabled');
    },

    cellCicked(e) {
      // this.enableDropdown();
      // let f = this.contractForm;
      // console.log(e.data);

      this.selectedData = e.data;

      // f.row_index = e.rowIndex;
      // f.contract_id = e.data.contract_id;
      // f.customer_id = e.data.customer_id;
      // f.contract_no = e.data.contract_no;
      // f.contract_appendix = e.data.contract_appendix;
      // f.contract_quantity = e.data.contract_quantity;
      // f.contract_grade_id = e.data.contract_grade_id;
      // f.contract_grade_gar = e.data.contract_grade_gar;
      // f.loading_place = e.data.loading_place;
      // f.delivery_place = e.data.delivery_place;
      // f.signed_date = this.store.yyyymmdd(e.data.signed_date);
      // f.contract_status = e.data.contract_status;
      // f.contract_remark = e.data.contract_remark;

      // let orderItems = this.orderData.filter((i) => i.contract_id == e.data.contract_id);
      // this.orderFilter = orderItems;

      // let fileItems = this.fileData.filter((i) => i.contract_id == e.data.contract_id);
      // this.fileFilter = fileItems;
    },


    viewContract() {
      this.viewMode = 'view';
      // let cusomer = this.contractData.find((e) => e.contract_id == this.contractForm.contract_id);
      // this.customerFilter = cusomer;
    },


    eportExecel() {

      const url = '/api/sales/export-excel';
      window.location.href = url;



      // this.$axios.get('/api/sales/export-excel').then((result) => {
      //   console.log('Completed!');

      // }).catch((err) => {
      //   console.log(err);

      // });

    },
  },

  created() {
    this.onLoad();
  },
};
</script>