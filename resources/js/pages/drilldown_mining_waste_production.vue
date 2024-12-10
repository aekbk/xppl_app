<template>
    <!-- Content : Waste Production-->
    <div v-if="!isLoading" class="row justify-content-evenly mb-4">
        <card title="Total Mining Waste Production">
            <to-date-table
                :data="rawWasteData"
                :sliceAttribute="'contractor'"
                :attributeHeader="'Con.'"
                :actualAttrName="'waste_actual_kbcm'"
                :planAttrName="'waste_plan_kbcm'"
                :toDate="globalParamStore.getSelectedDate"
                :dayGroupHeader="globalParamStore.getSelectedDate + ' (Kbcm)'"
                :mtdGroupHeader="'MTD (Kbcm)'"
                :ytdGroupHeader="'YTD (Kbcm)'"
            ></to-date-table>

            <chart-group
                :selectedTab="selectedByContractorTab"
                :availableFilter="availableByContractorFilter"
                :selectedFilter="selectedByContractorFilter"
                :defaultFilter="defaultByContractorFilter"
                @filterChange="setByContractorSelectedFilter"
                @tabSwitch="setByContractorSelectedTab"
            >
                <h5>
                    Total Mining Waste Production:
                    {{ selectedByContractorFilter }}
                </h5>
                <kpi-chart
                    :actualData="wasteProductionActualDataByContractor"
                    :planData="wasteProductionPlanDataByContractor"
                    :categories="wasteProductionCategoriesByContractor"
                    :leftYAxisTitle="'Volume (Kbcm)'"
                    :rightYAxisTitle="'Cum. Volume (Mbcm)'"
                ></kpi-chart>

                <month-line
                    :data="wasteBCMPerHourByContractorData"
                    :categories="wasteProductionCategoriesByContractor"
                    :yAxisTitle="'Hourly Productivity (Kbcm/hour)'"
                    :units="''"
                ></month-line>
            </chart-group>
        </card>
    </div>
    <div v-if="isLoading" class="row justify-content-evenly mb-4">
        <div class="spinner-border text-primary" role="status">
            <span class="sr-only">Loading...</span>
        </div>
    </div>
</template>

<script>
import { uniq } from "lodash";
import moment from "moment";
import Card from "../components/card.vue";
import ChartGroup from "../components/chart-group.vue";
import DepartmentSummary from "../components/department-summary.vue";
import KpiChart from "../components/kpi-chart.vue";
import MonthLine from "../components/month-line.vue";
import SummaryStatistic from "../components/summary-statistic.vue";
import ToDateTable from "../components/to-date-table.vue";
import { useAuthStore } from "../stores/auth";
import { useStore } from "../stores/store";
import { convertToKpiDataByAttr } from "../utils/chart";
import {
    formatDateToDayMonth,
    formatDateToMonthYear,
    getKeyDateFromSelectedDate,
} from "../utils/date";
import { roundToDecimalPlace } from "../utils/number";
import { useGlobalParamStore } from "../stores/globalParam";

export default {
    name: "MiningDrilldown/Waste-Production",
    setup() {
        const authStore = useAuthStore();
        const store = useStore();
        const globalParamStore = useGlobalParamStore();
        return { authStore, store, globalParamStore };
    },
    components: {
        SummaryStatistic,
        DepartmentSummary,
        ToDateTable,
        KpiChart,
        Card,
        MonthLine,
        ChartGroup,
    },

    data() {
        return {
            isLoading: false,
            rawWasteData: [],

            // Waste Production byContractor toggle
            selectedByContractorTab: "mtd",

            // Waste Production byContractor dropdown/filter
            defaultByContractorFilter: "All Contractor",
            selectedByContractorFilter: "All Contractor",
        };
    },
    computed: {
        // function to get the filtered data for the selected contractor from dropdown list
        // return two types of data: daily and monthly
        wasteByContractorData() {
            if (this.rawWasteData.length === 0) {
                return {
                    daily: [],
                    monthly: [],
                };
            }

            const filteredData =
                this.selectedByContractorFilter ===
                this.defaultByContractorFilter
                    ? this.rawWasteData
                    : this.rawWasteData.filter(
                          (i) =>
                              i.contractor === this.selectedByContractorFilter
                      );

            const keyDates = getKeyDateFromSelectedDate(
                this.globalParamStore.selectedDate
            );

            return convertToKpiDataByAttr(
                filteredData,
                "waste_plan_kbcm",
                "waste_actual_kbcm",
                keyDates.beginningOfMonth,
                keyDates.endOfMonth
            );
        },

        // get the actual waste amount for the selected period from toggle tab
        wasteProductionActualDataByContractor() {
            if (this.selectedByContractorTab === "mtd") {
                const filteredDailyData =
                    this.wasteByContractorData.daily.filter(
                        (i) => i.date <= this.globalParamStore.selectedDate
                    );
                return filteredDailyData.map((i) => i.actual);
            }
            const filteredMonthlyData =
                this.wasteByContractorData.monthly.filter(
                    (i) => i.date <= this.globalParamStore.selectedDate
                );
            return filteredMonthlyData.map((i) => i.actual);
        },

        // get the plan waste amount for the selected period from toggle tab
        wasteProductionPlanDataByContractor() {
            if (this.selectedByContractorTab === "mtd") {
                return this.wasteByContractorData.daily.map((i) => i.plan);
            }
            return this.wasteByContractorData.monthly.map((i) => i.plan);
        },

        // get the categories for the selected period from toggle tab
        wasteProductionCategoriesByContractor() {
            if (this.selectedByContractorTab === "mtd") {
                return this.wasteByContractorData.daily.map((i) =>
                    formatDateToDayMonth(i.date)
                );
            }
            return this.wasteByContractorData.monthly.map((i) =>
                formatDateToMonthYear(i.date)
            );
        },

        // function return the list of available contractor for dropdown list
        availableByContractorFilter() {
            return uniq(this.rawWasteData.map((i) => i.contractor));
        },

        wasteBCMPerHourByContractorData() {
            if (this.selectedByContractorTab === "mtd") {
                const filteredDailyData =
                    this.wasteByContractorData.daily.filter(
                        (i) => i.date <= this.globalParamStore.selectedDate
                    );
                return filteredDailyData.map((i) =>
                    roundToDecimalPlace(i.actual / 24)
                );
            } else {
                const filteredMonthlyData =
                    this.wasteByContractorData.monthly.filter(
                        (i) => i.date <= this.globalParamStore.selectedDate
                    );
                return filteredMonthlyData.map((i) =>
                    roundToDecimalPlace(
                        i.actual / 24 / moment(i.date).daysInMonth()
                    )
                );
            }
        },
    },

    watch: {
        "globalParamStore.getSelectedDate": "fetchData",
    },

    methods: {
        async fetchWasteData() {
            this.isLoading = true;
            const keyDates = getKeyDateFromSelectedDate(
                this.globalParamStore.selectedDate
            );
            const response = await axios.get(
                `/api/control-tower/waste_detail?start_date=${keyDates.beginningOfYear}&end_date=${keyDates.endOfYear}`,
                {
                    headers: {
                        Authorization: "Bearer " + this.authStore.getToken,
                    },
                }
            );

            this.rawWasteData = response.data;
            this.isLoading = false;
        },

        async fetchData() {
            this.fetchWasteData();
        },

        // event listener for the dropdown list
        setByContractorSelectedFilter(filter_value) {
            this.selectedByContractorFilter = filter_value;
        },

        // event listener for the toggle tab
        setByContractorSelectedTab(toggle_value) {
            this.selectedByContractorTab = toggle_value;
        },
    },
    created() {
        this.fetchData();
    },
};
</script>
