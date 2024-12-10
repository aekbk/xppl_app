<template>
    <div v-if="!isLoading" class="row justify-content-evenly mb-4">
        <card title="Total Mining Coal Production By Contractor">
            <to-date-table
                :data="rawMiningData"
                :sliceAttribute="'contractor'"
                :attributeHeader="'Con.'"
                :actualAttrName="'coal_actual_kt'"
                :planAttrName="'coal_plan_kt'"
                :toDate="globalParamStore.getSelectedDate"
            ></to-date-table>
        </card>

        <card title="Total Mining Coal Production By Grade">
            <to-date-table
                :data="rawMiningData"
                :sliceAttribute="'category'"
                :attributeHeader="'Grade'"
                :actualAttrName="'coal_actual_kt'"
                :planAttrName="'coal_plan_kt'"
                :toDate="globalParamStore.getSelectedDate"
            ></to-date-table>

            <nested-chart-group
                :selectedTab="selectedByContractorAndGradeTab"
                :primaryAvailableFilter="availableByContractorFilter"
                :primarySelectedFilter="selectedByContractorFilter"
                :primaryDefaultFilter="defaultByContractorFilter"
                :secondaryAvailableFilter="availableByGradeFilter"
                :secondarySelectedFilter="selectedByGradeFilter"
                :secondaryDefaultFilter="defaultByGradeFilter"
                @primaryFilterChange="setByContractorSelectedFilter"
                @secondaryFilterChange="setByGradeSelectedFilter"
                @tabSwitch="setByContractorAndGradeSelectedTab"
            >
                <h5>
                    Mining Coal Production: {{ selectedByContractorFilter }},
                    {{ selectedByGradeFilter }}
                </h5>
                <kpi-chart
                    :actualData="miningProductionActualDataByContractorAndGrade"
                    :planData="miningProductionPlanDataByContractorAndGrade"
                    :categories="miningProductionCategoriesByContractorAndGrade"
                    :leftYAxisTitle="'Weight (Kt)'"
                    :rightYAxisTitle="'Cum. Weight (Mt)'"
                ></kpi-chart>

                <h5>
                    Mining Coal Production: {{ selectedByContractorFilter }},
                    {{ selectedByGradeFilter }}
                </h5>
                <month-line
                    :data="tonesPerHourData"
                    :categories="miningProductionCategoriesByContractorAndGrade"
                    :yAxisTitle="'Hourly Productivity (Kt/hour)'"
                    :units="''"
                ></month-line>
            </nested-chart-group>
        </card>

        <card title="Total Mining Coal Production By Contractor & Grade">
            <to-nested-date-table
                :data="rawMiningData"
                :primarySliceAttribute="'contractor'"
                :secondarySliceAttribute="'category'"
                :primaryAttributeHeader="'Cont.'"
                :secondaryAttributeHeader="'Grade.'"
                :actualAttrName="'coal_actual_kt'"
                :planAttrName="'coal_plan_kt'"
                :toDate="globalParamStore.getSelectedDate"
            ></to-nested-date-table>
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
import DepartmentSummary from "../components/department-summary.vue";
import KpiChart from "../components/kpi-chart.vue";
import MonthLine from "../components/month-line.vue";
import NestedChartGroup from "../components/nested-chart-group.vue";
import SummaryStatistic from "../components/summary-statistic.vue";
import ToDateTable from "../components/to-date-table.vue";
import ToNestedDateTable from "../components/to-nested-date-table.vue";
import { useAuthStore } from "../stores/auth";
import { useGlobalParamStore } from "../stores/globalParam";
import { useStore } from "../stores/store";
import { convertToKpiDataByAttr } from "../utils/chart";
import { formatDateToDayMonth, formatDateToMonthYear, getKeyDateFromSelectedDate } from "../utils/date";
import { roundToDecimalPlace } from "../utils/number";

/*
 Page layout:
 < table group by Contractor >
 < table group by Grade >
 < Contractor dropdown & Grade dropdown & Toggle[mtd/ytd] >
    < bar chart>
    < line chart>
 < table double group by Contractor&Grade >

 Please note that the bar chart and line chart will utilize the same set of two
 dropdown lists and one toggle button to filter the data. The first dropdown
 list will filter by Contractor, while the second dropdown list will filter by
 Grade. The toggle button will allow for switching between MTD and YTD data.

*/

export default {
    name: "MiningDrilldown/Coal-Production",
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
        ToNestedDateTable,
        KpiChart,
        Card,
        MonthLine,
        NestedChartGroup,
    },

    data() {
        return {
            isLoading: false,
            rawMiningData: [],

            // Coal Production byContractAndGrade toggle
            selectedByContractorAndGradeTab: "mtd",

            // Coal Production byContractor filter
            defaultByContractorFilter: "All Contractors",
            selectedByContractorFilter: "All Contractors",

            // Coal Production byGrade filter
            defaultByGradeFilter: "All Grades",
            selectedByGradeFilter: "All Grades",
        };
    },
    computed: {
        // function to get filtered data for total mining coal production
        // filtered by contractor then grade if selected otherwise raw data
        // returns an object with daily and monthly data
        miningByContractorAndGradeData() {
            if (this.rawMiningData.length === 0) {
                return {
                    daily: [],
                    monthly: [],
                };
            }

            // filter by contractor first
            const filteredByContractorData =
                this.selectedByContractorFilter ===
                this.defaultByContractorFilter
                    ? this.rawMiningData
                    : this.rawMiningData.filter(
                          (i) =>
                              i.contractor === this.selectedByContractorFilter
                      );

            // filter by grade next
            const filteredData =
                this.selectedByGradeFilter === this.defaultByGradeFilter
                    ? filteredByContractorData
                    : filteredByContractorData.filter(
                          (i) => i.category === this.selectedByGradeFilter
                      );

            const keyDates = getKeyDateFromSelectedDate(
                this.globalParamStore.selectedDate
            );

            return convertToKpiDataByAttr(
                filteredData,
                "coal_plan_kt",
                "coal_actual_kt",
                keyDates.beginningOfMonth,
                keyDates.endOfMonth
            );
        },

        // get the actual mining amount for the selected period from toggle tab
        miningProductionActualDataByContractorAndGrade() {
            if (this.selectedByContractorAndGradeTab === "mtd") {
                const filteredDailyData =
                    this.miningByContractorAndGradeData.daily.filter(
                        (i) => i.date <= this.globalParamStore.selectedDate
                    );
                return filteredDailyData.map((i) => i.actual);
            } else {
                const filteredMonthlyData =
                    this.miningByContractorAndGradeData.monthly.filter(
                        (i) => i.date <= this.globalParamStore.selectedDate
                    );
                return filteredMonthlyData.map((i) => i.actual);
            }
        },

        // get the planned mining amount for the selected period from toggle tab
        miningProductionPlanDataByContractorAndGrade() {
            if (this.selectedByContractorAndGradeTab === "mtd") {
                return this.miningByContractorAndGradeData.daily.map(
                    (i) => i.plan
                );
            } else {
                return this.miningByContractorAndGradeData.monthly.map(
                    (i) => i.plan
                );
            }
        },

        // get the categories for the selected period from toggle tab
        miningProductionCategoriesByContractorAndGrade() {
            if (this.selectedByContractorAndGradeTab === "mtd") {
                return this.miningByContractorAndGradeData.daily.map((i) =>
                    formatDateToDayMonth(i.date)
                );
            } else {
                return this.miningByContractorAndGradeData.monthly.map((i) =>
                    formatDateToMonthYear(i.date)
                );
            }
        },

        // return unique list of available contractor for dropdown menu
        availableByContractorFilter() {
            return uniq(this.rawMiningData.map((i) => i.contractor));
        },

        // return unique list of available grade for dropdown menu
        availableByGradeFilter() {
            return uniq(this.rawMiningData.map((i) => i.category));
        },

        tonesPerHourData() {
            if (this.selectedByContractorAndGradeTab === "mtd") {
                const filteredDailyData =
                    this.miningByContractorAndGradeData.daily.filter(
                        (i) => i.date <= this.globalParamStore.selectedDate
                    );
                return filteredDailyData.map((i) =>
                    roundToDecimalPlace(i.actual / 24)
                );
            } else {
                const filteredMonthlyData =
                    this.miningByContractorAndGradeData.monthly.filter(
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
        async fetchMiningData() {
            this.isLoading = true;
            const keyDates = getKeyDateFromSelectedDate(
                this.globalParamStore.selectedDate
            );
            const response = await axios.get(
                `/api/control-tower/mining_detail?start_date=${keyDates.beginningOfYear}&end_date=${keyDates.endOfYear}`,
                {
                    headers: {
                        Authorization: "Bearer " + this.authStore.getToken,
                    },
                }
            );
            this.rawMiningData = response.data;
            this.isLoading = false;
        },
        async fetchData() {
            this.fetchMiningData();
        },

        // event listener for contractor dropdown list
        setByContractorSelectedFilter(contractor_filter_value) {
            this.selectedByContractorFilter = contractor_filter_value;
        },

        // event listener for grade dropdown list
        setByGradeSelectedFilter(grade_filter_value) {
            this.selectedByGradeFilter = grade_filter_value;
        },

        // event listener for the toggle tab
        setByContractorAndGradeSelectedTab(toggle_value) {
            this.selectedByContractorAndGradeTab = toggle_value;
        },
    },
    created() {
        this.fetchData();
    },
};
</script>
