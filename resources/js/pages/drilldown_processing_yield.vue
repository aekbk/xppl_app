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
import SummaryStatistic from "../components/summary-statistic.vue";
import DepartmentSummary from "../components/department-summary.vue";
import Card from "../components/card.vue";
import { useAuthStore } from "../stores/auth";
import { useStore } from "../stores/store";
import ToDateTable from "../components/to-date-table.vue";
import KpiChart from "../components/kpi-chart.vue";
import {
    convertToKpiDataByAttr,
} from "../utils/chart";
import { formatDateToDayMonth, formatDateToMonthYear, getKeyDateFromSelectedDate } from "../utils/date";
import ChartGroup from "../components/chart-group.vue";
import MonthLine from "../components/month-line.vue";
import YieldTable from "../components/yield-table.vue";
import { useGlobalParamStore } from "../stores/globalParam";

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
            selectedByPlantTab: 'mtd',
            defaultByPlantFilter: 'All Plants',
            selectedByPlantFilter: 'All Plants',

            // Input ByGrade filter
            selectedByGradeTab: 'mtd',
            selectedByGradeFilter: 'Total',
        };
    },

    computed: {
        // Input screening section
        yieldData() {
            if (this.rawThroughputData.length === 0) {
                return {
                    daily: [],
                    monthly: [],
                };
            }

            const filteredData = this.selectedByPlantFilter === this.defaultByPlantFilter
                ? this.rawThroughputData
                : this.rawThroughputData.filter((i) => i.plant === this.selectedByPlantFilter);

            const keyDates = getKeyDateFromSelectedDate(
                this.globalParamStore.selectedDate
            );
            return convertToKpiDataByAttr(
                filteredData,
                "yield_plan",
                "yield_actual",
                keyDates.beginningOfMonth,
                keyDates.endOfMonth
            );
        },
        coalThroughputActualDataByPlant() {
            if (this.selectedByPlantTab === 'mtd') {
                const yieldDailyData = this.yieldData.daily.filter(
                    (i) => i.date <= this.globalParamStore.selectedDate
                );
                return yieldDailyData.map((i) => i.actual);
            }
            const yieldMonthlyData = this.yieldData.monthly.filter(
                    (i) => i.date <= this.globalParamStore.selectedDate
                );
            return yieldMonthlyData.map((i) => i.actual);
        },
        coalThroughputPlanDataByPlant() {
            if (this.selectedByPlantTab === 'mtd') {
                return this.yieldData.daily.map((i) => i.plan);
            }
            return this.yieldData.monthly.map((i) => i.plan);
        },
        coalThroughputCategoriesByPlant() {
            if (this.selectedByPlantTab === 'mtd') {
                return this.yieldData.daily.map((i) =>
                    formatDateToDayMonth(i.date)
                );
            }
            return this.yieldData.monthly.map((i) =>
                formatDateToMonthYear(i.date)
            );
        },
        availableByPlantFilter() {
            return uniq(this.rawThroughputData.map((i) => i.plant));
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
            this.rawThroughputData = response.data.map(i => {
                return {
                    ...i,
                    yield_actual: i.output_actual / i.input_actual,
                    yield_plan: i.output_target / i.input_target,
                };
            });
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
