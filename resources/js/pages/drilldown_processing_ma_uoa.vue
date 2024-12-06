<template>
    <div v-if="!isLoading" class="row justify-content-evenly mb-4">
        <card title="Machine Availability (MA) & Utilisation (UoA)">
            <to-date-ma-uoa-table
                :data="rawUoaData"
                :sliceAttribute="'plant'"
                :attributeHeader="'Plants'"
                :toDate="globalParamStore.getSelectedDate"
            ></to-date-ma-uoa-table>

            <chart-group
                :selectedTab="selectedByPlantTab"
                :availableFilter="availableByPlantFilter"
                :selectedFilter="selectedByPlantFilter"
                :defaultFilter="defaultByPlantFilter"
                @filterChange="setByPlantSelectedFilter"
                @tabSwitch="setByPlantSelectedTab"
            >
                <h5>Machine Availability</h5>
                <ma-chart
                    :actualData="coalThroughputActualDataByPlant"
                    :planData="coalThroughputPlanDataByPlant"
                    :categories="coalThroughputCategoriesByPlant"
                ></ma-chart>
                <uoa-chart
                    :totalUoa="uoaChartData.totalUoa"
                    :totalMa="uoaChartData.totalMa"
                ></uoa-chart>
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
import MaChart from "../components/ma-chart.vue";
import MonthLine from "../components/month-line.vue";
import SummaryStatistic from "../components/summary-statistic.vue";
import ToDateMaUoaTable from "../components/to-date-ma-uoa-table.vue";
import UoaChart from "../components/uoa-chart.vue";
import { useAuthStore } from "../stores/auth";
import { useStore } from "../stores/store";
import {
    convertToKpiDataByAttr,
    transformToToDateUtilizationTableData,
} from "../utils/chart";
import { formatDateToDayMonth, formatDateToMonthYear, getKeyDateFromSelectedDate } from "../utils/date";
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
        ToDateMaUoaTable,
        UoaChart,
        MaChart,
        Card,
        ChartGroup,
        MonthLine,
    },

    data() {
        return {
            isLoading: false,
            rawUoaData: [],

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
        inputMAData() {
            if (this.rawUoaData.length === 0) {
                return {
                    daily: [],
                    monthly: [],
                };
            }

            const filteredData = this.selectedByPlantFilter === this.defaultByPlantFilter
                ? this.rawUoaData
                : this.rawUoaData.filter((i) => i.plant === this.selectedByPlantFilter);
            return convertToKpiDataByAttr(
                filteredData,
                "target_run_hrs",
                "actual_availability_hrs",
                "2024-11-01",
                "2024-11-30"
            );
        },
        coalThroughputActualDataByPlant() {
            if (this.selectedByPlantTab === 'mtd') {
                const filteredDailyData = this.inputMAData.daily.filter(
                    (i) => i.date <= this.globalParamStore.selectedDate
                );
                return filteredDailyData.map((i) => i.actual);
            }
            const filteredMonthlyData = this.inputMAData.monthly.filter(
                (i) => i.date <= this.globalParamStore.selectedDate
            );
            return filteredMonthlyData.map((i) => i.actual);
        },
        coalThroughputPlanDataByPlant() {
            if (this.selectedByPlantTab === 'mtd') {
                return this.inputMAData.daily.map((i) => i.plan);
            }
            return this.inputMAData.monthly.map((i) => i.plan);
        },
        coalThroughputCategoriesByPlant() {
            if (this.selectedByPlantTab === 'mtd') {
                return this.inputMAData.daily.map((i) =>
                    formatDateToDayMonth(i.date)
                );
            }
            return this.inputMAData.monthly.map((i) =>
                formatDateToMonthYear(i.date)
            );
        },
        availableByPlantFilter() {
            return uniq(this.rawUoaData.map((i) => i.plant));
        },
        maUoaData() {
            return transformToToDateUtilizationTableData(
                this.rawUoaData,
                new Date("2024-11-20"), 
                'plant', 
            )
        },
        uoaChartData() {
            let filteredData = this.maUoaData;
            if (this.selectedByPlantFilter !== 'Total') {
                filteredData = filteredData.filter((i) => i.attr === this.selectedByPlantFilter);
            }
            let totalMa = 0;
            let totalUoa = 0;
            filteredData.forEach((i) => {
                const plantMa = this.selectedByPlantTab === 'mtd'
                    ? i.mtdActualRunTime + i.mtdActualStandByTime
                    : i.ytdActualRunTime + i.ytdActualStandByTime;
                const plantUoa = this.selectedByPlantTab === 'mtd'
                    ? i.mtdActualRunTime
                    : i.ytdActualRunTime;

                totalMa += plantMa;
                totalUoa += plantUoa;
            });
            return {
                totalMa,
                totalUoa,
            };
        }
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
                `/api/control-tower/uoa_detail?start_date=${keyDates.beginningOfYear}&end_date=${keyDates.endOfYear}`,
                {
                    headers: {
                        Authorization: "Bearer " + this.authStore.getToken,
                    },
                }
            );
            this.rawUoaData = response.data.map((i) => ({
                ...i,
                actual_availability_hrs: i.actual_run_hrs + i.actual_standby_hrs,
            }));
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
    },
    created() {
        this.fetchData();
    },
};
</script>
