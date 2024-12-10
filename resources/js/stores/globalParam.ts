import { defineStore } from "pinia";
import moment from 'moment';

const LAST_AVAILABLE_DATE_DATA = new Date('2024-12-09');
const DATE_FORMAT = 'YYYY-MM-DD';

export const useGlobalParamStore = defineStore('globalParam', {

  state: () => ({
    // hardcode selectedDate to the latest available data
    selectedDate: new Date(LAST_AVAILABLE_DATE_DATA),
    lastAvaliableDateData: new Date(LAST_AVAILABLE_DATE_DATA),
    lastUpdatedDate: new Date('2024-12-5'),
  }),
  getters: {
    getSelectedDate: (state) => moment(state.selectedDate).format(DATE_FORMAT),

    getLastAvailableDateData: (state) => state.lastAvaliableDateData,

    // Return date format example: Nov 13, 2024, at 15:32
    getLastUpdatedDate: (state) => moment(state.lastUpdatedDate).format(DATE_FORMAT),
  },
  actions: {
    setSelectedDate(selectedDate: Date) {
      this.selectedDate = new Date(selectedDate);
    },
    setLastUpdatedDate(lastUpdatedDate: Date) {
      this.lastUpdatedDate = new Date(lastUpdatedDate);
    },
  }
})