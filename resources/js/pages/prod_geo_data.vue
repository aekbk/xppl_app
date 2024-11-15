<template>
  <div>
    <div class="card">
      <div class="card-header">
        <div class="row g-2 align-items-center">

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
            <div class="gap-2 d-sm-flex">
              <div class="input-group" style="width: 300px;">
                <input type="text" id="select-mode-1" class="form-control flatpickr-input flatpickr-single rounded-start-2 cursor-pointer" placeholder="Select date" aria-label="Text input with dropdown button" v-model="selectDate" @input="getData('d')">
                <input type="month" id="select-mode-2" class="form-control rounded-start-2 d-none" aria-label="Text input with dropdown button" v-model="selectMonth" @input="getData('m')">
                <input type="text" id="select-mode-3" class="form-control flatpickr-input flatpickr-range rounded-start-2 cursor-pointer d-none" placeholder="Select date range" aria-label="Text input with dropdown button" v-model="selectRange" @input="getRangeData('r')">

                <div id="select-mode-4" class="d-none">
                  <multiselect style="width: 223px; border-top-right-radius: 0px; border-bottom-right-radius: 0px;" aria-label="Text input with dropdown button" placeholder="Select year" :options="lkYear" v-model="selectYear" @select="getData('y')" />
                </div>
                <button class="btn btn-success dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">{{ selectBy }}</button>
                <ul class="dropdown-menu dropdown-menu-end dropdownmenu-secondary" style="">
                  <li><a class="dropdown-item" id="get-prod-1" href="#" @click="getByDate()">Date</a></li>
                  <li><a class="dropdown-item" id="get-prod-2" href="#" @click="getByMonth()">Month</a></li>
                  <li><a class="dropdown-item" id="get-prod-3" href="#" @click="getByYear()">Year</a></li>
                  <li><a class="dropdown-item" id="get-prod-4" href="#" @click="getByRange()">Range</a></li>
                </ul>
              </div>

              <!-- <button class="btn btn-soft-info btn-icon" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                <i class="ri-more-2-fill"></i>
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
        <ag-grid-vue style="height: calc(100vh - 15.65rem);" id="ag-sales-data" class="ag-theme-material" :columnDefs="columnDefs" :rowData="prodGeoList" :defaultColDef="defaultColDef" :rowHeight="36" :headerHeight="44" :popupParent="popupParent" :suppressMenuHide="false" :suppressCellFocus="true" animateRows="false" rowSelection="single" @rowClicked="cellCicked" @cell-double-clicked="viewContract"></ag-grid-vue>
      </div>
    </div>

  </div>
</template>

<script>
import { AgGridVue } from "ag-grid-vue3";
import "ag-grid-community/styles/ag-grid.css";
import "ag-grid-community/styles/ag-theme-material.css";
import "ag-grid-enterprise";
import { useAuthStore } from '../stores/auth.js';
import { useToastr } from '../toastr.js';
const toastr = useToastr();

export default {
  name: 'XpplAppProdGeoData',
  components: { AgGridVue },

  setup() {
    const authStore = useAuthStore();
    return { authStore };
  },

  data() {
    return {
      columnDefs: [
        { headerName: '#', minWidth: 50, maxWidth: 60, valueGetter: (params) => { return params.node.rowIndex + 1 } },
        { headerName: 'Data ID', field: 'data_id', hide: true },
        { headerName: 'Company', field: 'company', filter: 'agSetColumnFilter', hide: true },
        {
          headerName: "Date", minWidth: 100, maxWidth: 120, valueGetter: p => {
            if (p.data.mined_date) {
              return moment(p.data.mined_date).format("DD-MM-YYYY")
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

        { headerName: 'Shift', field: 'work_shift', filter: 'agSetColumnFilter' },
        { headerName: 'Project', field: 'project', filter: 'agSetColumnFilter' },
        { headerName: 'Pit', field: 'pit', filter: 'agSetColumnFilter' },
        { headerName: 'Block', field: 'mining_block', filter: 'agSetColumnFilter' },
        { headerName: 'Bench', field: 'bench', filter: 'agSetColumnFilter' },
        { headerName: 'Coal Block ID', field: 'coal_block_id', minWidth: 130, filter: 'agSetColumnFilter' },
        { headerName: 'Coal Category', field: 'coal_category', filter: 'agSetColumnFilter' },
        {
          headerName: 'GCV_ar', field: 'gcv_ar', minWidth: 80, filter: 'agNumberColumnFilter',
          valueGetter: p => Number(p.data.gcv_ar),
          valueFormatter: p => p.value ? p.value.toLocaleString('en-US', { minimumFractionDigits: 0, maximumFractionDigits: 0 }) : ''
        },
        {
          headerName: 'Ash_ad', field: 'ash_ar', minWidth: 80, filter: 'agNumberColumnFilter',
          valueGetter: p => Number(p.data.ash_ad),
          valueFormatter: p => p.value ? p.value.toLocaleString('en-US', { minimumFractionDigits: 2, maximumFractionDigits: 2 }) : ''
        },
        { headerName: 'Spotted', field: 'spotted', filter: 'agSetColumnFilter' },
        { headerName: 'Stockpile', field: 'stockpile', filter: 'agSetColumnFilter' },
        { headerName: 'Contractor', field: 'mined_contractor', filter: 'agSetColumnFilter' },
        { headerName: 'Truck No', field: 'truck_no', filter: 'agSetColumnFilter' },
        {
          headerName: 'Gross Weight kg', field: 'gross_weight_kg', filter: 'agNumberColumnFilter',
          valueGetter: p => Number(p.data.gross_weight_kg),
          valueFormatter: p => p.value ? p.value.toLocaleString('en-US', { minimumFractionDigits: 0, maximumFractionDigits: 0 }) : ''
        },
        {
          headerName: 'Truck Weight kg', field: 'truck_weight_kg', filter: 'agNumberColumnFilter',
          valueGetter: p => Number(p.data.truck_weight_kg),
          valueFormatter: p => p.value ? p.value.toLocaleString('en-US', { minimumFractionDigits: 0, maximumFractionDigits: 0 }) : ''
        },
        {
          headerName: 'Net Weight kg', field: 'net_weight_kg', filter: 'agNumberColumnFilter',
          valueGetter: p => Number(p.data.net_weight_kg),
          valueFormatter: p => p.value ? p.value.toLocaleString('en-US', { minimumFractionDigits: 0, maximumFractionDigits: 0 }) : ''
        },
        { headerName: 'Weight Type', field: 'weight_type', filter: 'agSetColumnFilter' },
        { headerName: 'Grade Range', field: 'grade_range', minWidth: 120, filter: 'agSetColumnFilter' },
        { headerName: 'Notes', field: 'notes', filter: 'agSetColumnFilter' },
        { headerName: 'Mining ID', field: 'mining_id', hide: true },
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

      lkYear: [],
      prodGeoData: [],
      search: '',

      selectDate: '',
      selectMonth: '',
      selectYear: '',
      selectRange: '',
      selectBy: 'Date',
      loading: false


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
  },

  computed: {
    prodGeoList() {
      if (this.search.trim().length > 0) {
        return this.prodGeoData.filter((i) =>
          i.company.substring(0, this.search.trim().length).toLowerCase() == this.search.trim().toLowerCase() ||
          i.pit.substring(0, this.search.trim().length).toLowerCase() == this.search.trim().toLowerCase() ||
          i.mining_block.substring(0, this.search.trim().length).toLowerCase() == this.search.trim().toLowerCase() ||
          i.bench.substring(0, this.search.trim().length).toLowerCase() == this.search.trim().toLowerCase() ||
          i.coal_block_id.substring(0, this.search.trim().length).toLowerCase() == this.search.trim().toLowerCase() ||
          i.coal_category.substring(0, this.search.trim().length).toLowerCase() == this.search.trim().toLowerCase() ||
          i.mined_contractor.substring(0, this.search.trim().length).toLowerCase() == this.search.trim().toLowerCase() ||
          i.stockpile.substring(0, this.search.trim().length).toLowerCase() == this.search.trim().toLowerCase()
        );
      };
      return this.prodGeoData;
    },
  },

  methods: {
    async onLoad() {

      this.selectDate = moment(new Date(new Date().getTime() - 24 * 60 * 60 * 1000)).format('YYYY-MM-DD');

      // const lastDate = await axios.get('api/production-dash/last-date', { headers: { Authorization: 'Bearer ' + this.authStore.getToken } });
      // this.selectDate = moment(lastDate.data[0].lastDate).format('YYYY-MM-DD');
      // const fp = flatpickr('#select-mode-1', {
      //   altInput: true,
      //   altFormat: 'd-m-Y'
      // });
      // fp.setDate(this.selectDate);
      const prod = await this.getData('d');

      const year = await axios.get('api/production/mine-year', { headers: { Authorization: 'Bearer ' + this.authStore.getToken } });
      this.lkYear = year.data;

      document.getElementById('get-prod-1').classList.add('disabled');

    },

    async getData(by) {
      try {
        this.loading = true;
        this.prodGeoData = [];
        let value = '';

        if (by == 'd') {
          value = this.selectDate;
        } else if (by == 'm') {
          value = this.selectMonth;
        } else if (by == 'y') {
          value = this.selectYear;
        }
        const result = await axios.get(`api/production/mine-production-data?value=${value}&getBy=${by}`, { headers: { Authorization: 'Bearer ' + this.authStore.getToken } });
        this.prodGeoData = result.data;
        this.loading = false;

      } catch (error) {
        if (error.response.status == 500) {
          this.loading = false;
          toastr.error('Data so big size!');
        } else if (error.response.status == 401) {
          this.authStore.removeToken();
          this.authStore.removeUser();
          localStorage.removeItem('token');
          localStorage.removeItem('user');
          this.$router.push('/login');
        }
      }
    },

    async getByDate() {
      this.prodGeoData = [];
      this.selectBy = 'Date';
      this.functionSelect('select-mode-1');
      this.disableDropdown('get-prod-1');

      this.selectDate = moment(new Date(new Date().getTime() - 24 * 60 * 60 * 1000)).format('YYYY-MM-DD');
      const sale = await this.getData('d');
    },

    async getByMonth() {
      this.prodGeoData = [];
      this.selectMonth = '';
      this.selectBy = 'Month';
      this.functionSelect('select-mode-2');
      this.disableDropdown('get-prod-2');

      const selected = document.getElementById('select-mode-2');
      selected.type = 'month';
      selected.classList.remove('d-none');

      // const currentDate = new Date();
      // let y = currentDate.getFullYear();
      // let m = String(currentDate.getMonth() + 1).padStart(2, '0');

      // this.selectMonth = `${y}-${m}`;
      // const data = await this.getData('m')
    },

    async getByYear() {
      this.prodGeoData = [];
      this.selectYear = '';
      this.selectBy = 'Year';
      this.functionSelect('select-mode-4');
      this.disableDropdown('get-prod-3');

      // const currentDate = new Date();
      // let y = currentDate.getFullYear();
      // this.selectYear = `${y}`;
      // const data = await this.getData('y')
    },

    async getByRange() {
      this.prodGeoData = [];
      this.selectBy = 'Range';
      this.functionSelect('select-mode-3');
      this.disableDropdown('get-prod-4');
    },

    async getRangeData(by) {
      this.prodGeoData = [];
      let dateFr = moment(this.selectRange.substring(0, 10)).format('YYYY-MM-DD');
      let dateTo = moment(this.selectRange.substring(14, 24)).format('YYYY-MM-DD');

      if (this.selectRange && this.selectRange.length > 12) {
        this.loading = true;

        const result = await axios.get(`api/production/mine-production-data?dateFr=${dateFr}&dateTo=${dateTo}`, { headers: { Authorization: 'Bearer ' + this.authStore.getToken } });
        this.prodGeoData = result.data;

        this.loading = false;
      }
    },

    functionSelect(id) {
      const elements = document.querySelectorAll('[id^="select-mode-"]');
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

    disableDropdown(id) {
      const elements = document.querySelectorAll('[id^="get-prod-"]');
      elements.forEach((e) => {
        e.classList.remove('disabled');
      });
      document.getElementById(id).classList.add('disabled');
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
  },

  created() {
    this.onLoad();
  }
};
</script>