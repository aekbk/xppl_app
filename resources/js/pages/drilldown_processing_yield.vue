<template>
    <div v-if="!isLoading" class="row justify-content-evenly mb-4">
        <card title="Yield">
            <yield-table
                :data="rawThroughputData"
                :sliceAttribute="'plant'"
                :attributeHeader="'Plants'"
                :actualAttrName="'yield_actual'"
                :planAttrName="'yield_plan'"
                :toDate="globalParamStore.getSelectedDate"
            ></yield-table>

            <chart-group
                :selectedTab="selectedByPlantTab"
                :availableFilter="availableByPlantFilter"
                :selectedFilter="selectedByPlantFilter"
                :defaultFilter="defaultByPlantFilter"
                @filterChange="setByPlantSelectedFilter"
                @tabSwitch="setByPlantSelectedTab"
            >
                <h5>Yield</h5>
                <month-line
                    :data="coalThroughputActualDataByPlant"
                    :categories="coalThroughputCategoriesByPlant"
                    :yAxisTitle="'Yield (%)'"
                    :units="''"
                    :labelFormat="'0 %'"
                    :yAxisFormat="'0 %'"
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
import Card from "../components/card.vue";
import ChartGroup from "../components/chart-group.vue";
import DepartmentSummary from "../components/department-summary.vue";
import KpiChart from "../components/kpi-chart.vue";
import MonthLine from "../components/month-line.vue";
import SummaryStatistic from "../components/summary-statistic.vue";
import YieldTable from "../components/yield-table.vue";
import { useAuthStore } from "../stores/auth";
import { useGlobalParamStore } from "../stores/globalParam";
import { useStore } from "../stores/store";
import {
    convertToYieldKpiDataByAttr
} from "../utils/chart";
import {
    formatDateToDayMonth,
    formatDateToMonthYear,
    getKeyDateFromSelectedDate,
} from "../utils/date";
import { numberOrNull } from "../utils/number";

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
        YieldTable,
        KpiChart,
        Card,
        ChartGroup,
        MonthLine,
    },

    data() {
        return {
            isLoading: false,
            rawThroughputData: [],

            // Input ByPlant filter
            selectedByPlantTab: "mtd",
            defaultByPlantFilter: "All Plants",
            selectedByPlantFilter: "All Plants",

            // Input ByGrade filter
            selectedByGradeTab: "mtd",
            selectedByGradeFilter: "Total",
        };
    },

    computed: {
        // Input screening section
        yieldData() {
            if (this.rawProcessingData.length === 0) {
                return {
                    daily: [],
                    monthly: [],
                };
            }

            const filteredData =
                this.selectedByPlantFilter === this.defaultByPlantFilter
                    ? this.rawProcessingData
                    : this.rawProcessingData.filter(
                          (i) => i.plant === this.selectedByPlantFilter
                      );

            const keyDates = getKeyDateFromSelectedDate(
                this.globalParamStore.selectedDate
            );
            return convertToYieldKpiDataByAttr(
                filteredData,
                keyDates.beginningOfMonth,
                keyDates.endOfMonth
            );
        },
        coalThroughputActualDataByPlant() {
            if (this.selectedByPlantTab === "mtd") {
                const yieldDailyData = this.yieldData.daily.filter(
                    (i) => i.date <= this.globalParamStore.selectedDate
                );
                return yieldDailyData.map(
                    (i) => numberOrNull(i.outputActual / i.inputActual)
                );
            }
            const yieldMonthlyData = this.yieldData.monthly.filter(
                (i) => i.date <= this.globalParamStore.selectedDate
            );
            return yieldMonthlyData.map((i) => numberOrNull(i.outputActual / i.inputActual));
        },
        coalThroughputCategoriesByPlant() {
            if (this.selectedByPlantTab === "mtd") {
                return this.yieldData.daily.map((i) =>
                    formatDateToDayMonth(i.date)
                );
            }
            return this.yieldData.monthly.map((i) =>
                formatDateToMonthYear(i.date)
            );
        },
        availableByPlantFilter() {
            return uniq(this.rawProcessingData.map((i) => i.plant));
        },
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
