<template>
    <div class="row justify-content-evenly mb-4">
        <card title="Input By Plant">
            <to-date-table
                :data="rawProcessingData"
                :sliceAttribute="'plant'"
                :attributeHeader="'Plants'"
                :actualAttrName="'input_actual'"
                :planAttrName="'input_target'"
            ></to-date-table>

            <chart-group
                :selectedTab="'mtd'"
                @filterChange="consoleEvent"
                @tabSwitch="setSelectedTab"
            >
                <kpi-chart
                    :actualData="coalProductionActualData"
                    :planData="coalProductionPlanData"
                    :categories="coalProductionCategories"
                ></kpi-chart>

                <month-line
                    :data="coalProductionActualData"
                    :categories="coalProductionCategories"
                ></month-line>
            </chart-group>
        </card>

        <card title="Input By ROM Grade">
            <to-date-table
                :data="rawProcessingData"
                :sliceAttribute="'input_grade'"
                :attributeHeader="'Coal Grade'"
                :actualAttrName="'input_actual'"
                :planAttrName="'input_target'"
            ></to-date-table>

            <kpi-chart
                :actualData="coalProductionActualData"
                :planData="coalProductionPlanData"
                :categories="coalProductionCategories"
            ></kpi-chart>
        </card>
    </div>
</template>

<script>
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
import { subset } from "../utils/data";
import ChartGroup from "../components/chart-group.vue";
import MonthLine from "../components/month-line.vue";

export default {
    name: "ProcessingDrilldown/Input",
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
        ChartGroup,
        MonthLine,
    },

    data() {
        return {
            rawProcessingData: [],
            processingData: {
                daily: [],
                monthly: [],
            },

            // Kpi chart data
            coalProductionPlanData: [],
            coalProductionCategories: [],

            selectedTab: 'mtd',
        };
    },

    computed: {
        coalProductionActualData() {
            console.log("recalculating coalProductionActualData");
            if (this.selectedTab === 'mtd') {
                return this.processingData.daily.map((i) => i.actual);
            }
            return this.processingData.monthly.map((i) => i.actual);
        },
        coalProductionPlanData() {
            if (this.selectedTab === 'mtd') {
                return this.processingData.daily.map((i) => i.plan);
            }
            return this.processingData.monthly.map((i) => i.plan);
        },
        coalProductionCategories() {
            if (this.selectedTab === 'mtd') {
                return this.processingData.daily.map((i) =>
                    formatDateToDayMonth(i.date)
                );
            }
            return this.processingData.monthly.map((i) =>
                formatDateToMonthYear(i.date)
            );
        },
    },

    methods: {
        async fetchProcessingData() {
            const response = await axios.get(
                "/api/control-tower/processing_detail?start_date=2024-01-01&end_date=2024-12-01",
                {
                    headers: {
                        Authorization: "Bearer " + this.authStore.getToken,
                    },
                }
            );
            this.rawProcessingData = response.data;
            this.processingData = convertToKpiDataByAttr(
                this.rawProcessingData,
                "input_target",
                "input_actual",
                "2024-11-01",
                "2024-11-30"
            );
        },
        async fetchData() {
            this.fetchProcessingData();
        },
        setSelectedTab(value) {
            this.selectedTab = value;
        },
    },
    created() {
        this.fetchData();
    },
};
</script>
