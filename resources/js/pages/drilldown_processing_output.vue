<template>
    <div v-if="!isLoading" class="row justify-content-evenly mb-4">
        <card title="Throughput By Plant">
            <to-date-table
                :data="rawOutputData"
                :sliceAttribute="'plant'"
                :attributeHeader="'Plants'"
                :actualAttrName="'output_actual'"
                :planAttrName="'output_target'"
                :toDate="globalParamStore.getSelectedDate"
            ></to-date-table>

            <chart-group
                :selectedTab="selectedByPlantTab"
                :availableFilter="availableByPlantFilter"
                :selectedFilter="selectedByPlantFilter"
                @filterChange="setByPlantSelectedFilter"
                @tabSwitch="setByPlantSelectedTab"
            >
                <h5>Total Throughput: {{ selectedByPlantFilter }}</h5>
                <kpi-chart
                    :actualData="coalOutputActualDataByPlant"
                    :planData="coalOutputPlanDataByPlant"
                    :categories="coalOutputCategoriesByPlant"
                ></kpi-chart>
                <!-- <h5>Mining Coal Production</h5>
                <month-line
                    :data="coalThroughputActualData"
                    :categories="coalThroughputCategories"
                ></month-line> -->
            </chart-group>
        </card>

        <card title="Throughput By Saleable Grade">
            <to-date-table
                :data="rawOutputData"
                :sliceAttribute="'input_grade'"
                :attributeHeader="'Coal Grade'"
                :actualAttrName="'output_actual'"
                :planAttrName="'output_target'"
                :toDate="globalParamStore.getSelectedDate"
            ></to-date-table>

            <chart-group
                :selectedTab="selectedByGradeTab"
                :availableFilter="availableByGradeFilter"
                :selectedFilter="selectedByGradeFilter"
                @filterChange="setByGradeSelectedFilter"
                @tabSwitch="setByGradeSelectedTab"
            >
                <h5>Total Throughput SHG</h5>
                <kpi-chart
                    :actualData="coalOutputActualDataByGrade"
                    :planData="coalOutputPlanDataByGrade"
                    :categories="coalOutputCategoriesByGrade"
                ></kpi-chart>
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
import Card from "../components/card.vue";
import ChartGroup from "../components/chart-group.vue";
import DepartmentSummary from "../components/department-summary.vue";
import KpiChart from "../components/kpi-chart.vue";
import MonthLine from "../components/month-line.vue";
import SummaryStatistic from "../components/summary-statistic.vue";
import ToDateTable from "../components/to-date-table.vue";
import { useAuthStore } from "../stores/auth";
import { useGlobalParamStore } from "../stores/globalParam";
import { useStore } from "../stores/store";
import { convertToKpiDataByAttr } from "../utils/chart";
import {
    formatDateToDayMonth,
    formatDateToMonthYear,
    getKeyDateFromSelectedDate,
} from "../utils/date";

export default {
    name: "ProcessingDrilldown/Throughput",
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
        ChartGroup,
        MonthLine,
    },

    data() {
        return {
            isLoading: false,
            rawOutputData: [],

            // Input ByPlant filter
            selectedByPlantTab: "mtd",
            selectedByPlantFilter: "Total",

            // Input ByGrade filter
            selectedByGradeTab: "mtd",
            selectedByGradeFilter: "Total",
        };
    },

    computed: {
        // Input screening section
        outputScreeningData() {
            if (this.rawOutputData.length === 0) {
                return {
                    daily: [],
                    monthly: [],
                };
            }

            const filteredData =
                this.selectedByPlantFilter === "Total"
                    ? this.rawOutputData
                    : this.rawOutputData.filter(
                          (i) => i.plant === this.selectedByPlantFilter
                      );

            const keyDates = getKeyDateFromSelectedDate(
                this.globalParamStore.selectedDate
            );
            return convertToKpiDataByAttr(
                filteredData,
                "output_target",
                "output_actual",
                keyDates.beginningOfMonth,
                keyDates.endOfMonth
            );
        },
        coalOutputActualDataByPlant() {
            if (this.selectedByPlantTab === "mtd") {
                const dateFilteredData = this.outputScreeningData.daily.filter(
                    (i) => i.date <= this.globalParamStore.selectedDate
                );
                return dateFilteredData.map((i) => i.actual);
            }
            const dateFilteredData = this.outputScreeningData.monthly.filter(
                (i) => i.date <= this.globalParamStore.selectedDate
            );
            return dateFilteredData.map((i) => i.actual);
        },
        coalOutputPlanDataByPlant() {
            if (this.selectedByPlantTab === "mtd") {
                return this.outputScreeningData.daily.map((i) => i.plan);
            }
            return this.outputScreeningData.monthly.map((i) => i.plan);
        },
        coalOutputCategoriesByPlant() {
            if (this.selectedByPlantTab === "mtd") {
                return this.outputScreeningData.daily.map((i) =>
                    formatDateToDayMonth(i.date)
                );
            }
            return this.outputScreeningData.monthly.map((i) =>
                formatDateToMonthYear(i.date)
            );
        },
        availableByPlantFilter() {
            return uniq(this.rawOutputData.map((i) => i.plant));
        },

        // Input grade chart data
        outputGradeData() {
            if (this.rawOutputData.length === 0) {
                return {
                    daily: [],
                    monthly: [],
                };
            }

            const filteredData =
                this.selectedByGradeFilter === "Total"
                    ? this.rawOutputData
                    : this.rawOutputData.filter(
                          (i) => i.input_grade === this.selectedByGradeFilter
                      );

            const keyDates = getKeyDateFromSelectedDate(
                this.globalParamStore.selectedDate
            );
            return convertToKpiDataByAttr(
                filteredData,
                "output_target",
                "output_actual",
                keyDates.beginningOfMonth,
                keyDates.endOfMonth
            );
        },
        coalOutputActualDataByGrade() {
            if (this.selectedByGradeTab === "mtd") {
                const dateFilteredData = this.outputGradeData.daily.filter(
                    (i) => i.date <= this.globalParamStore.selectedDate
                );
                return dateFilteredData.map((i) => i.actual);
            }
            const dateFilteredData = this.outputGradeData.monthly.filter(
                (i) => i.date <= this.globalParamStore.selectedDate
            );
            return dateFilteredData.map((i) => i.actual);
        },
        coalOutputPlanDataByGrade() {
            if (this.selectedByGradeTab === "mtd") {
                return this.outputGradeData.daily.map((i) => i.plan);
            }
            return this.outputGradeData.monthly.map((i) => i.plan);
        },
        coalOutputCategoriesByGrade() {
            if (this.selectedByGradeTab === "mtd") {
                return this.outputGradeData.daily.map((i) =>
                    formatDateToDayMonth(i.date)
                );
            }
            return this.outputGradeData.monthly.map((i) =>
                formatDateToMonthYear(i.date)
            );
        },
        availableByGradeFilter() {
            return uniq(this.rawOutputData.map((i) => i["input_grade"]));
        },
    },

    watch: {
        "globalParamStore.getSelectedDate": "fetchData",
    },

    methods: {
        async fetchProcessingData() {
            this.isLoading = true;
            const keyDates = getKeyDateFromSelectedDate(
                this.globalParamStore.selectedDate
            );
            const response = await axios.get(
                `/api/control-tower/processing_detail?start_date=${keyDates.beginningOfYear}&end_date=${keyDates.endOfYear}`,
                {
                    headers: {
                        Authorization: "Bearer " + this.authStore.getToken,
                    },
                }
            );
            this.rawOutputData = response.data;
            this.isLoading = false;
        },
        async fetchData() {
            this.fetchProcessingData();
        },

        setByPlantSelectedTab(value) {
            this.selectedByPlantTab = value;
        },
        setByPlantSelectedFilter(value) {
            this.selectedByPlantFilter = value;
        },

        setByGradeSelectedTab(value) {
            this.selectedByGradeTab = value;
        },
        setByGradeSelectedFilter(value) {
            this.selectedByGradeFilter = value;
        },
    },
    created() {
        this.fetchData();
    },
};
</script>
