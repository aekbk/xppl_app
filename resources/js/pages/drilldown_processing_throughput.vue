<template>
    <div class="row justify-content-evenly mb-4">
        <card title="Throughput By Plant">
            <to-date-table
                :data="throughputData"
                :sliceAttribute="'plant'"
                :attributeHeader="'Plants'"
                :actualAttrName="'throughput_actual'"
                :planAttrName="'throughput_plan'"
            ></to-date-table>

            <kpi-chart
                :actualData="coalProductionActualData"
                :planData="coalProductionPlanData"
                :categories="coalProductionCategories"
            ></kpi-chart>
        </card>

        <card title="Throughput By Saleable Grade">
            <to-date-table
                :data="processingData"
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
    convertToDailyKpiData,
    convertToDailyKpiDataByAttr,
} from "../utils/chart";
import { formatDateToDayMonth } from "../utils/date";
import { subset } from "../utils/data";

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
    },

    data() {
        return {
            processingData: [],

            // Kpi chart data
            coalProductionActualData: [],
            coalProductionPlanData: [],
            coalProductionCategories: [],
        };
    },

    computed: {
        throughputData() {
            return this.processingData.map((i) => {
                return {
                    ...i,
                    throughput_actual: i.input_actual / 24,
                    throughput_plan: i.input_target / 24,
                };
            });
        }    
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
            this.processingData = response.data;

            const novemberData = subset(
                response.data,
                "2024-11-01",
                "2024-11-30"
            );
            const kpiData = convertToDailyKpiDataByAttr(
                novemberData,
                "input_target",
                "input_actual"
            );
            this.coalProductionActualData = kpiData.map((i) => i.actual);
            this.coalProductionPlanData = kpiData.map((i) => i.plan);
            this.coalProductionCategories = kpiData.map((i) =>
                formatDateToDayMonth(i.date)
            );
        },
        async fetchData() {
            this.fetchProcessingData();
        },
    },
    created() {
        this.fetchData();
    },
};
</script>
