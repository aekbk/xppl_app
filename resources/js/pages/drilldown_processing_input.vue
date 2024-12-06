<template>
    <div v-if="!isLoading" class="row justify-content-evenly mb-4">
        <card title="Input By Plant">
            <to-date-table
                :data="rawProcessingData"
                :sliceAttribute="'plant'"
                :attributeHeader="'Plants'"
                :actualAttrName="'input_actual'"
                :planAttrName="'input_target'"
                :toDate="globalParamStore.getSelectedDate"
            ></to-date-table>

            <chart-group
                :selectedTab="selectedByPlantTab"
                :availableFilter="availableByPlantFilter"
                :selectedFilter="selectedByPlantFilter"
                @filterChange="setByPlantSelectedFilter"
                @tabSwitch="setByPlantSelectedTab"
            >
                <h5>Total Input: {{ selectedByPlantFilter }}</h5>
                <kpi-chart
                    :actualData="coalProductionActualDataByPlant"
                    :planData="coalProductionPlanDataByPlant"
                    :categories="coalProductionCategoriesByPlant"
                ></kpi-chart>
            </chart-group>
        </card>

        <card title="Input By ROM Grade">
            <to-date-table
                :data="rawProcessingData"
                :sliceAttribute="'input_grade'"
                :attributeHeader="'Coal Grade'"
                :actualAttrName="'input_actual'"
                :planAttrName="'input_target'"
                :toDate="globalParamStore.getSelectedDate"
            ></to-date-table>

            <chart-group
                :selectedTab="selectedByGradeTab"
                :availableFilter="availableByGradeFilter"
                :selectedFilter="selectedByGradeFilter"
                @filterChange="setByGradeSelectedFilter"
                @tabSwitch="setByGradeSelectedTab"
            >
                <h5>Total Input SHG</h5>
                <kpi-chart
                    :actualData="coalProductionActualDataByGrade"
                    :planData="coalProductionPlanDataByGrade"
                    :categories="coalProductionCategoriesByGrade"
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
import SummaryStatistic from "../components/summary-statistic.vue";
import DepartmentSummary from "../components/department-summary.vue";
import Card from "../components/card.vue";
import { useAuthStore } from "../stores/auth";
import { useStore } from "../stores/store";
import ToDateTable from "../components/to-date-table.vue";
import KpiChart from "../components/kpi-chart.vue";
import { convertToKpiDataByAttr } from "../utils/chart";
import {
    formatDateToDayMonth,
    formatDateToMonthYear,
    getKeyDateFromSelectedDate,
} from "../utils/date";
import { subset } from "../utils/data";
import ChartGroup from "../components/chart-group.vue";
import MonthLine from "../components/month-line.vue";
import { useGlobalParamStore } from "../stores/globalParam";

export default {
    name: "ProcessingDrilldown/Input",
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
            rawProcessingData: [],

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
        inputScreeningData() {
            if (this.rawProcessingData.length === 0) {
                return {
                    daily: [],
                    monthly: [],
                };
            }

            const filteredData =
                this.selectedByPlantFilter === "Total"
                    ? this.rawProcessingData
                    : this.rawProcessingData.filter(
                          (i) => i.plant === this.selectedByPlantFilter
                      );
            const keyDates = getKeyDateFromSelectedDate(
                this.globalParamStore.selectedDate
            );
            return convertToKpiDataByAttr(
                filteredData,
                "input_target",
                "input_actual",
                keyDates.beginningOfMonth,
                keyDates.endOfMonth
            );
        },
        coalProductionActualDataByPlant() {
            if (this.selectedByPlantTab === "mtd") {
                const filteredDailyData = this.inputScreeningData.daily.filter(
                    (i) => i.date <= this.globalParamStore.selectedDate
                );
                return filteredDailyData.map((i) => i.actual);
            }
            const filteredMonthlyData = this.inputScreeningData.monthly.filter(
                (i) => i.date <= this.globalParamStore.selectedDate
            );
            return filteredMonthlyData.map((i) => i.actual);
        },
        coalProductionPlanDataByPlant() {
            if (this.selectedByPlantTab === "mtd") {
                return this.inputScreeningData.daily.map((i) => i.plan);
            }
            return this.inputScreeningData.monthly.map((i) => i.plan);
        },
        coalProductionCategoriesByPlant() {
            if (this.selectedByPlantTab === "mtd") {
                return this.inputScreeningData.daily.map((i) =>
                    formatDateToDayMonth(i.date)
                );
            }
            return this.inputScreeningData.monthly.map((i) =>
                formatDateToMonthYear(i.date)
            );
        },
        availableByPlantFilter() {
            return uniq(this.rawProcessingData.map((i) => i.plant));
        },

        // Input grade chart data
        inputGradeData() {
            if (this.rawProcessingData.length === 0) {
                return {
                    daily: [],
                    monthly: [],
                };
            }

            const filteredData =
                this.selectedByGradeFilter === "Total"
                    ? this.rawProcessingData
                    : this.rawProcessingData.filter(
                          (i) => i.input_grade === this.selectedByGradeFilter
                      );
            const keyDates = getKeyDateFromSelectedDate(
                this.globalParamStore.selectedDate
            );
            return convertToKpiDataByAttr(
                filteredData,
                "input_target",
                "input_actual",
                keyDates.beginningOfMonth,
                keyDates.endOfMonth
            );
        },
        coalProductionActualDataByGrade() {
            if (this.selectedByGradeTab === "mtd") {
                const dateFilteredData = this.inputGradeData.daily.filter(
                    (i) => i.date <= this.globalParamStore.selectedDate
                );
                return dateFilteredData.map((i) => i.actual);
            }
            const dateFilteredData = this.inputGradeData.monthly.filter(
                (i) => i.date <= this.globalParamStore.selectedDate
            );
            return dateFilteredData.map((i) => i.actual);
        },
        coalProductionPlanDataByGrade() {
            if (this.selectedByGradeTab === "mtd") {
                return this.inputGradeData.daily.map((i) => i.plan);
            }
            return this.inputGradeData.monthly.map((i) => i.plan);
        },
        coalProductionCategoriesByGrade() {
            if (this.selectedByGradeTab === "mtd") {
                return this.inputGradeData.daily.map((i) =>
                    formatDateToDayMonth(i.date)
                );
            }
            return this.inputGradeData.monthly.map((i) =>
                formatDateToMonthYear(i.date)
            );
        },
        availableByGradeFilter() {
            return uniq(this.rawProcessingData.map((i) => i["input_grade"]));
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
            this.rawProcessingData = response.data;
            this.isLoading = false;
        },
        async fetchData() {
            this.fetchProcessingData();
        },

        setByPlantSelectedTab(value) {
            console.log(value);
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
