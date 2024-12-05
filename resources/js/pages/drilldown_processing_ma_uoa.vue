<template>
    <div class="row justify-content-evenly mb-4">
        <card title="Throughput By Plant">
            <to-date-ma-uoa-table
                :data="rawUoaData"
                :sliceAttribute="'plant'"
                :attributeHeader="'Plants'"
                :actualAttrName="'throughput_actual'"
                :planAttrName="'throughput_plan'"
            ></to-date-ma-uoa-table>

            <chart-group
                :selectedTab="selectedByPlantTab"
                :availableFilter="availableByPlantFilter"
                :selectedFilter="selectedByPlantFilter"
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
                    :actualData="coalThroughputActualDataByPlant"
                    :planData="coalThroughputPlanDataByPlant"
                    :categories="coalThroughputCategoriesByPlant"
                ></uoa-chart>
                <!-- <h5>Mining Coal Production</h5>
                <month-line
                    :data="coalThroughputActualData"
                    :categories="coalThroughputCategories"
                ></month-line> -->
            </chart-group>
        </card>
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
} from "../utils/chart";
import { formatDateToDayMonth, formatDateToMonthYear } from "../utils/date";

export default {
    name: "ProcessingDrilldown/Throughput",
    setup() {
        const authStore = useAuthStore();
        const store = useStore();
        return { authStore, store };
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
            rawUoaData: [],

            // Input ByPlant filter
            selectedByPlantTab: 'mtd',
            selectedByPlantFilter: 'Total',

            // Input ByGrade filter
            selectedByGradeTab: 'mtd',
            selectedByGradeFilter: 'Total',
        };
    },

    computed: {
        // Input screening section
        inputScreeningData() {
            if (this.rawUoaData.length === 0) {
                return {
                    daily: [],
                    monthly: [],
                };
            }

            const filteredData = this.selectedByPlantFilter === "Total"
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
            console.log("recalculating coalThroughputActualData");
            if (this.selectedByPlantTab === 'mtd') {
                return this.inputScreeningData.daily.map((i) => i.actual);
            }
            return this.inputScreeningData.monthly.map((i) => i.actual);
        },
        coalThroughputPlanDataByPlant() {
            if (this.selectedByPlantTab === 'mtd') {
                return this.inputScreeningData.daily.map((i) => i.plan);
            }
            return this.inputScreeningData.monthly.map((i) => i.plan);
        },
        coalThroughputCategoriesByPlant() {
            if (this.selectedByPlantTab === 'mtd') {
                return this.inputScreeningData.daily.map((i) =>
                    formatDateToDayMonth(i.date)
                );
            }
            return this.inputScreeningData.monthly.map((i) =>
                formatDateToMonthYear(i.date)
            );
        },
        availableByPlantFilter() {
            return uniq(this.rawUoaData.map((i) => i.plant));
        },
    },

    methods: {
        async fetchProcessingData() {
            const response = await axios.get(
                "/api/control-tower/uoa_detail?start_date=2024-01-01&end_date=2024-12-01",
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
    },
    created() {
        this.fetchData();
    },
};
</script>
