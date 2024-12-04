<template>
    <div class="row justify-content-evenly mb-4">
        <card title="Throughput By Plant">
            <to-date-uoa-table
                :data="rawUoaData"
                :sliceAttribute="'plant'"
                :attributeHeader="'Plants'"
                :actualAttrName="'throughput_actual'"
                :planAttrName="'throughput_plan'"
            ></to-date-uoa-table>

            <chart-group
                :selectedTab="selectedByPlantTab"
                :availableFilter="availableByPlantFilter"
                :selectedFilter="selectedByPlantFilter"
                @filterChange="setByPlantSelectedFilter"
                @tabSwitch="setByPlantSelectedTab"
            >
                <h5>Total Throughput: {{ selectedByPlantFilter }}</h5>
                <kpi-chart
                    :actualData="coalThroughputActualDataByPlant"
                    :planData="coalThroughputPlanDataByPlant"
                    :categories="coalThroughputCategoriesByPlant"
                ></kpi-chart>
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
import { formatDateToDayMonth, formatDateToMonthYear } from "../utils/date";
import ChartGroup from "../components/chart-group.vue";
import MonthLine from "../components/month-line.vue";
import ToDateUoaTable from "../components/to-date-uoa-table.vue";

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
        ToDateUoaTable,
        KpiChart,
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
                "throughput_plan",
                "throughput_actual",
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
            this.rawUoaData = response.data;
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
