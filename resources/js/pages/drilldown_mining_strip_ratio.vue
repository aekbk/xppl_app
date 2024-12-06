<template>
    <!-- Content :  Strip Ratio-->
    <div class="row justify-content-evenly mb-4">
        <card title="Strip Ratio">
            <nested-chart-group
                :selectedTab="selectedByContractorAndPitTab"
                :primaryAvailableFilter="availableByContractorFilter"
                :primarySelectedFilter="selectedByContractorFilter"
                :primaryDefaultFilter="defaultByContractorFilter"
                :secondaryAvailableFilter="availableByPitFilter"
                :secondarySelectedFilter="selectedByPitFilter"
                :secondaryDefaultFilter="defaultByPitFilter"
                @primaryFilterChange="setByContractorSelectedFilter"
                @secondaryFilterChange="setByPitSelectedFilter"
                @tabSwitch="setByContractorAndPitSelectedTab"
            >
                <h5>Strip Ratio: {{ selectedByContractorFilter }}, {{ selectedByPitFilter }}</h5>
                <month-line
                    :data="stripRatioDataByContractorAndPit"
                    :categories="wasteProductionCategoriesByContractorAndPit"
                    :yAxisTitle="'Strip Ratio'"
                 ></month-line>
            </nested-chart-group>
        </card>
    </div>
</template>

<script>
import { uniq } from "lodash";
import SummaryStatistic from "../components/summary-statistic.vue";
import DepartmentSummary from "../components/department-summary.vue";
import Card from "../components/card.vue";
import { useAuthStore } from "../stores/auth";
import { useStore } from "../stores/store";
import ToDateTable from "../components/to-date-table.vue";
import KpiChart from "../components/kpi-chart.vue";
import {
    convertToDailyKpiData,
    convertToKpiDataByAttr,
} from "../utils/chart";
import { formatDateToDayMonth, formatDateToMonthYear } from "../utils/date";
import { subset } from "../utils/data";
import { roundToDecimalPlace } from "../utils/number";
import MonthLine from "../components/month-line.vue";
import NestedChartGroup from "../components/nested-chart-group.vue";

export default {
    name: "MiningDrilldown/Strip-Ratio",
    setup() {
        const authStore = useAuthStore();
        const store = useStore();
        return { authStore, store };
    },
    components: {
        SummaryStatistic,
        DepartmentSummary,
        ToDateTable,
        KpiChart,
        Card,
        MonthLine,
        NestedChartGroup,
    },

    data() {
        return {

            rawMiningData: [],
            rawWasteData: [],

            // selected toggle value
            selectedByContractorAndPitTab: "mtd",

            // selected filter values for contractor and pit
            defaultByContractorFilter: "All Contractors",
            selectedByContractorFilter: "All Contractors",

            selectedByPitFilter: "All Pits",
            defaultByPitFilter: "All Pits",
        };
    },
    computed: {
        /**
         * Mining data filtered by contractor and pit
         * @returns {Object} - Object with daily and monthly data
         */
        miningByContractorAndPitData(){
            if (this.rawMiningData.length === 0) {
                return {
                    daily: [],
                    monthly: [],
                };
            }

            // filter by contractor first
            const filteredByContractorData = this.selectedByContractorFilter === this.defaultByContractorFilter
                ? this.rawMiningData
                : this.rawMiningData.filter((i) => i.contractor === this.selectedByContractorFilter);

            // filter by pit next
            const filteredData = this.selectedByPitFilter === this.defaultByPitFilter
                ? filteredByContractorData
                : filteredByContractorData.filter((i) => i.pit === this.selectedByPitFilter);

            return convertToKpiDataByAttr(filteredData, 'coal_plan_kt', 'coal_actual_kt', '2024-11-01', '2024-11-30');
        },

        /**
         * Get the actual mining amount for the selected period from toggle tab
         * @returns {Array} - Array of actual mining amount
         */
        miningProductionActualDataByContractorAndPit() {
            if (this.selectedByContractorAndPitTab === "mtd") {
                return this.miningByContractorAndPitData.daily.map((i) => i.actual);
            } else {
                return this.miningByContractorAndPitData.monthly.map((i) => i.actual);
            }
        },


        /*
         * Waste data filtered by contractor and pit
         * @returns {object} - Object with daily and monthly data
         */
        wasteByContractorAndPitData(){
            if (this.rawWasteData.length === 0) {
                return {
                    daily: [],
                    monthly: [],
                };
            }

            // filter by contractor first
            const filteredByContractorData = this.selectedByContractorFilter === this.defaultByContractorFilter
                ? this.rawWasteData
                : this.rawWasteData.filter((i) => i.contractor === this.selectedByContractorFilter);

            // filter by pit next
            const filteredData = this.selectedByPitFilter === this.defaultByPitFilter
                ? filteredByContractorData
                : filteredByContractorData.filter((i) => i.pit === this.selectedByPitFilter);

            return convertToKpiDataByAttr(filteredData, 'waste_plan_kbcm', 'waste_actual_kbcm', '2024-11-01', '2024-11-30');
        },

        /**
         * Get the actual waste amount for the selected period from toggle tab
         * @returns {Array} - Array of actual waste amount
         */
        wasteProductionActualDataByContractorAndPit() {
            if (this.selectedByContractorAndPitTab === "mtd") {
                return this.wasteByContractorAndPitData.daily.map((i) => i.actual);
            } else {
                return this.wasteByContractorAndPitData.monthly.map((i) => i.actual);
            }
        },

        /**
         * Get the categories for the waste production data
         * @returns {Array} - Array of categories
         */
        wasteProductionCategoriesByContractorAndPit() {
            if (this.selectedByContractorAndPitTab === "mtd") {
                return this.wasteByContractorAndPitData.daily.map((i) => formatDateToDayMonth(i.date));
            } else {
                return this.wasteByContractorAndPitData.monthly.map((i) => formatDateToMonthYear(i.date));
            }
        },

        /**
         * Compute the strip ratio using the actual waste and actual mining data from above
         * @returns {Array} - Array of strip ratio data
         * If the waste value is non-zero and the mining value is 0, the strip ratio is considered to be infinity.
         * In this case, we set the value to null, which will be filtered out when we compute the trend line.
         * Otherwise, we calculate the strip ratio as usual.
         * If the result is NaN, we return null to indicate that the data is not valid.
         */
        stripRatioDataByContractorAndPit() {
			const _miningData = this.miningProductionActualDataByContractorAndPit;
			const _wasteData = this.wasteProductionActualDataByContractorAndPit;

			const results = [];

			_wasteData.forEach((item, index) => {
				const miningValue = _miningData[index];
				let result;

				if (item !== 0 && miningValue === 0) {
					result = null;
				} else {
					result = item / miningValue;
				}

				if (isNaN(result)) {
					results.push(null);
				} else {
					results.push(roundToDecimalPlace(result, 2));
				}
			});

			return results;
        },


        /**
         * Get the available contractor for the dropdown menu
         * @returns {Array} - Array of contractor names
         */
        availableByContractorFilter() {
            return uniq(this.rawMiningData.map((i) => i.contractor));
        },

        /**
         * Get the available pit for the dropdown menu
         * @returns {Array} - Array of pit names
         */
        availableByPitFilter() {
            return uniq(this.rawMiningData.map((i) => i.pit));
        },
    },

    methods: {
        async fetchStripRatioData() {

            // mining data
            const miningResponse = await axios.get(
                "/api/control-tower/mining_detail?start_date=2024-01-01&end_date=2024-12-01",
                {
                    headers: {
                        Authorization: "Bearer " + this.authStore.getToken,
                    },
                }
            );
            this.rawMiningData = miningResponse.data;


            // waste data
            const wasteResponse = await axios.get(
                "/api/control-tower/waste_detail?start_date=2024-01-01&end_date=2024-12-01",
                {
                    headers: {
                        Authorization: "Bearer " + this.authStore.getToken,
                    },
                }
            );
            this.rawWasteData = wasteResponse.data;

        },
        async fetchData() {
            this.fetchStripRatioData();
        },

        // event listener for contractor dropdown list
        setByContractorSelectedFilter(contractor_filter_value) {
            this.selectedByContractorFilter = contractor_filter_value;
        },

        // event listener for pit dropdown list
        setByPitSelectedFilter(pit_filter_value) {
            this.selectedByPitFilter = pit_filter_value;
        },

        // event listener for the toggle tab
        setByContractorAndPitSelectedTab(toggle_value) {
            this.selectedByContractorAndPitTab = toggle_value;
        },


    },
    created() {
        this.fetchData();
    },
};
</script>
