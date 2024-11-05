<template>
  <div>

    <!-- Report 1 -->
    <div class="col-xl-12">
      <div class="card">

        <div class="card-header border-bottom">
          <div class="row g-2 align-items-center">
            <div class="col-xl-6 col-lg-6">
              <h5 class="card-title mb-0 flex-grow-1 overflow-hidden">Coal mine production from <span class="text-danger fw-normal fs-14">{{ dateRangeText }}</span></h5>
            </div>
            <div class="col-xxl-2 col-xl-3 col-lg-3 col-md-4 col-sm-6 ms-auto">
              <input type="text" id="select-mode-3" class="form-control form-control-sm flatpickr-input flatpickr-range rounded-start-2 cursor-pointer text-center" placeholder="Select date range" v-model="dateRange" @input="getReport1">
            </div>
            <div class="col-sm-auto">
              <button type="button" class="btn btn-soft-primary btn-sm material-shadow-none" @click="export1"><i class="ri-file-excel-2-line me-1"></i>Export</button>
            </div>
          </div>
        </div>

        <div class="card-body">
          <div class="table-responsive table-card">
            <table class="table table-hover table-borderless table-centered align-middle table-nowrap mb-0 table-sm">
              <thead class="text-muted bg-light-subtle" style="height: 32px;">
                <tr class="text-end">
                  <th class="text-start">Grade Range</th>
                  <th class="text-start">Category</th>
                  <th class="text-start">Stockpile</th>
                  <th>Ton</th>
                  <th>GCV_ar</th>
                  <th>Ash_ad</th>
                </tr>
              </thead>
              <tbody v-if="report1DataTotal.ton" class="border-0">
                <tr class="border-bottom border-bottom-dashed text-secondary text-end fw-medium border-top">
                  <td class="text-start">Padou</td>
                  <td></td>
                  <td></td>
                  <td>{{ store.numInt(report1PadouTotal.ton) }}</td>
                  <td>{{ store.numInt(report1PadouTotal.gcv_ar) }}</td>
                  <td>{{ store.numDec(report1PadouTotal.ash_ad) }}</td>
                </tr>
              </tbody>
              <tbody v-if="report1PadouTotal.ton" class="border-0">
                <tr v-for="(item, index) in report1Padou" :key="index" class="text-end">
                  <td class="text-start">{{ item.grade_range }}</td>
                  <td class="text-start">{{ item.coal_category }}</td>
                  <td class="text-start">{{ item.stockpile }}</td>
                  <td>{{ store.numInt(item.ton) }}</td>
                  <td>{{ store.numInt(item.gcv_ar) }}</td>
                  <td>{{ store.numDec(item.ash_ad) }}</td>
                </tr>
              </tbody>
              <tbody v-if="report1PakxaiTotal.ton" class="border-0">
                <tr class="border-bottom border-bottom-dashed text-secondary text-end fw-medium border-top">
                  <td class="text-start">Pakxai</td>
                  <td></td>
                  <td></td>
                  <td>{{ store.numInt(report1PakxaiTotal.ton) }}</td>
                  <td>{{ store.numInt(report1PakxaiTotal.gcv_ar) }}</td>
                  <td>{{ store.numDec(report1PakxaiTotal.ash_ad) }}</td>
                </tr>
              </tbody>
              <tbody v-if="report1DataTotal.ton" class="border-0">
                <tr v-for="(item, index) in report1Pakxai" :key="index" class="text-end">
                  <td class="text-start">{{ item.grade_range }}</td>
                  <td class="text-start">{{ item.coal_category }}</td>
                  <td class="text-start">{{ item.stockpile }}</td>
                  <td>{{ store.numInt(item.ton) }}</td>
                  <td>{{ store.numInt(item.gcv_ar) }}</td>
                  <td>{{ store.numDec(item.ash_ad) }}</td>
                </tr>
              </tbody>
              <tbody v-if="report1DataTotal.ton" class="border-0">
                <tr class="border-bottom border-bottom-dashed text-secondary text-end fw-medium border-top">
                  <td class="text-start">Kaleum</td>
                  <td></td>
                  <td></td>
                  <td>{{ store.numInt(report1KaleumTotal.ton) }}</td>
                  <td>{{ store.numInt(report1KaleumTotal.gcv_ar) }}</td>
                  <td>{{ store.numDec(report1KaleumTotal.ash_ad) }}</td>
                </tr>
              </tbody>
              <tbody v-if="report1KaleumTotal.ton" class="border-0">
                <tr v-for="(item, index) in report1Kaleum" :key="index" class="text-end">
                  <td class="text-start">{{ item.grade_range }}</td>
                  <td class="text-start">{{ item.coal_category }}</td>
                  <td class="text-start">{{ item.stockpile }}</td>
                  <td>{{ store.numInt(item.ton) }}</td>
                  <td>{{ store.numInt(item.gcv_ar) }}</td>
                  <td>{{ store.numDec(item.ash_ad) }}</td>
                </tr>
              </tbody>
              <tbody v-if="report1DataTotal.ton">
                <tr class="border-top text-secondary fw-semibold text-end">
                  <td class="text-start">Grand Total</td>
                  <td></td>
                  <td></td>
                  <td>{{ store.numInt(report1DataTotal.ton) }}</td>
                  <td>{{ store.numInt(report1DataTotal.gcv_ar) }}</td>
                  <td>{{ store.numDec(report1DataTotal.ash_ad) }}</td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>








    <!-- Export -->
    <table class="table table-hover table-borderless table-centered align-middle table-nowrap mb-0 table-sm d-none" id="export1">
      <thead class="text-muted bg-light-subtle" style="height: 32px;">
        <tr class="text-end">
          <th class="text-start">Grade Range</th>
          <th class="text-start">Category</th>
          <th class="text-start">Stockpile</th>
          <th>Ton</th>
          <th>GCV_ar</th>
          <th>Ash_ad</th>
        </tr>
      </thead>
      <tbody v-if="report1DataTotal.ton" class="border-0">
        <tr class="border-bottom border-bottom-dashed text-secondary text-end fw-medium border-top">
          <td class="text-start">Padou</td>
          <td></td>
          <td></td>
          <td>{{ report1PadouTotal.ton }}</td>
          <td>{{ report1PadouTotal.gcv_ar }}</td>
          <td>{{ report1PadouTotal.ash_ad }}</td>
        </tr>
      </tbody>
      <tbody v-if="report1PadouTotal.ton" class="border-0">
        <tr v-for="(item, index) in report1Padou" :key="index" class="text-end">
          <td class="text-start">{{ item.grade_range }}</td>
          <td class="text-start">{{ item.coal_category }}</td>
          <td class="text-start">{{ item.stockpile }}</td>
          <td>{{ item.ton }}</td>
          <td>{{ item.gcv_ar }}</td>
          <td>{{ item.ash_ad }}</td>
        </tr>
      </tbody>
      <tbody v-if="report1PakxaiTotal.ton" class="border-0">
        <tr class="border-bottom border-bottom-dashed text-secondary text-end fw-medium border-top">
          <td class="text-start">Pakxai</td>
          <td></td>
          <td></td>
          <td>{{ report1PakxaiTotal.ton }}</td>
          <td>{{ report1PakxaiTotal.gcv_ar }}</td>
          <td>{{ report1PakxaiTotal.ash_ad }}</td>
        </tr>
      </tbody>
      <tbody v-if="report1DataTotal.ton" class="border-0">
        <tr v-for="(item, index) in report1Pakxai" :key="index" class="text-end">
          <td class="text-start">{{ item.grade_range }}</td>
          <td class="text-start">{{ item.coal_category }}</td>
          <td class="text-start">{{ item.stockpile }}</td>
          <td>{{ item.ton }}</td>
          <td>{{ item.gcv_ar }}</td>
          <td>{{ item.ash_ad }}</td>
        </tr>
      </tbody>
      <tbody v-if="report1DataTotal.ton" class="border-0">
        <tr class="border-bottom border-bottom-dashed text-secondary text-end fw-medium border-top">
          <td class="text-start">Kaleum</td>
          <td></td>
          <td></td>
          <td>{{ report1KaleumTotal.ton }}</td>
          <td>{{ report1KaleumTotal.gcv_ar }}</td>
          <td>{{ report1KaleumTotal.ash_ad }}</td>
        </tr>
      </tbody>
      <tbody v-if="report1KaleumTotal.ton" class="border-0">
        <tr v-for="(item, index) in report1Kaleum" :key="index" class="text-end">
          <td class="text-start">{{ item.grade_range }}</td>
          <td class="text-start">{{ item.coal_category }}</td>
          <td class="text-start">{{ item.stockpile }}</td>
          <td>{{ item.ton }}</td>
          <td>{{ item.gcv_ar }}</td>
          <td>{{ item.ash_ad }}</td>
        </tr>
      </tbody>
      <tbody v-if="report1DataTotal.ton">
        <tr class="border-top text-secondary fw-semibold text-end">
          <td class="text-start">Grand Total</td>
          <td></td>
          <td></td>
          <td>{{ report1DataTotal.ton }}</td>
          <td>{{ report1DataTotal.gcv_ar }}</td>
          <td>{{ report1DataTotal.ash_ad }}</td>
        </tr>
      </tbody>
    </table>

  </div>
</template>

<script>
import axios from 'axios';
import { useStore } from '../stores/store';
import { useAuthStore } from '../stores/auth';

export default {
  name: 'XpplAppProdGeoReport',
  setup() {
    const store = useStore();
    const authStore = useAuthStore();
    return { store, authStore };
  },

  data() {
    return {

      report1Data: [],
      report1Padou: [],
      report1Pakxai: [],
      report1Kaleum: [],
      report1PadouTotal: '',
      report1PakxaiTotal: '',
      report1KaleumTotal: '',
      report1DataTotal: '',

      dateRange: '',
      dateRangeText: '',


    };
  },

  mounted() {
    flatpickr(".flatpickr-range", {
      altInput: true,
      mode: 'range',
      altFormat: 'd-m-Y'
    });
  },

  methods: {
    async onLoad() {

      // const today = new Date();
      // const currentMonth = today.getMonth();
      // const firstDayOfMonth = new Date(today.getFullYear(), currentMonth, 1);
      // const lastDayOfMonth = new Date(today.getFullYear(), currentMonth + 1, 0);
      // console.log('min-date:', moment(firstDayOfMonth).format('DD/MM/YYYY'));
      // console.log('max-date:', moment(lastDayOfMonth).format('DD/MM/YYYY'));

      // const mY = '2024-09'
      // const m = mY.split('-')[1];
      // const y = mY.split('-')[0];

      // const firstDayOfMonth = new Date(y, m - 1, 1);
      // const lastDayOfMonth = new Date(firstDayOfMonth);

      // lastDayOfMonth.setMonth(lastDayOfMonth.getMonth() + 1, 0);

      // let dateFr = moment(firstDayOfMonth).format('YYYY/MM/DD');
      // let dateTo = moment(lastDayOfMonth).format('YYYY/MM/DD');

      // this.cdate = moment(new Date()).format("YYYYMMDD");

      // while (firstDayOfMonth <= lastDayOfMonth) {
      //   this.dateColheader.push({
      //     colId: 'd' + moment(new Date(firstDayOfMonth)).format('YYYYMMDD'),
      //     colName: moment(new Date(firstDayOfMonth)).format('DD')
      //   });

      //   firstDayOfMonth.setDate(firstDayOfMonth.getDate() + 1);
      // }

      // console.log(this.dateColheader);

      // const dash10 = await axios.get(`api/dashboard-sale/dashboard10?dateFr=${dateFr}&dateTo=${dateTo}`, { headers: { Authorization: 'Bearer ' + this.authStore.getToken } });
      // this.dash10Data = dash10.data;


      // console.log(this.dash10Data);



    },

    headDate(text) {
      if (text) {
        return moment(text.split('d')[1]).format("YYYYMMDD");
      }
    },

    async getReport1() {

      let dateFr = moment(this.dateRange.substring(0, 10)).format('YYYY-MM-DD');
      let dateTo = moment(this.dateRange.substring(14, 24)).format('YYYY-MM-DD');

      if (this.dateRange && this.dateRange.length > 12) {
        // this.loading = true;


        this.dateRangeText = moment(this.dateRange.substring(0, 10)).format('DD-MM-YYYY') + ' to ' + moment(this.dateRange.substring(14, 24)).format('DD-MM-YYYY');
        const result = await axios.get(`api/production/report1?dateFr=${dateFr}&dateTo=${dateTo}`, { headers: { Authorization: 'Bearer ' + this.authStore.getToken } });
        this.report1Data = result.data;

        const padou = this.report1Data.filter(e => e.area == 'padou' && e.grade_range !== 'total-padou');
        this.report1Padou = padou;
        const padouTotal = this.report1Data.find(e => e.grade_range == 'total-padou');
        this.report1PadouTotal = padouTotal;

        const pakxai = this.report1Data.filter(e => e.area == 'pakxai' && e.grade_range !== 'total-pakxai');
        this.report1Pakxai = pakxai;
        const pakxaiTotal = this.report1Data.find(e => e.grade_range == 'total-pakxai');
        this.report1PakxaiTotal = pakxaiTotal;

        const kaleum = this.report1Data.filter(e => e.area == 'kaleum' && e.grade_range !== 'total-kaleum');
        this.report1Kaleum = kaleum;
        const kaleumTotal = this.report1Data.find(e => e.grade_range == 'total-kaleum');
        this.report1KaleumTotal = kaleumTotal;

        const total = this.report1Data.find(e => e.area == 'total');
        this.report1DataTotal = total;

        // this.loading = false;
      }
    },

    export1() {
      if (this.report1Data.length) {
        document.getElementById('export1').classList.remove('d-none');
        const table2excel = new Table2Excel();
        table2excel.export(document.getElementById('export1'));
        document.getElementById('export1').classList.add('d-none');
      }
    },

  },

  created() {
    this.onLoad();
  }
};
</script>