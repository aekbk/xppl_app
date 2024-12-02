<template>
    <div class="row justify-content-evenly mb-4">
        <card title="Total Mining Coal Production By Contractor">
            <to-date-table :data="miningData" :sliceAttribute="'contractor'" :attributeHeader="'Con.'"></to-date-table>

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
import { convertToDailyKpiData } from "../utils/chart";
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
            miningData: [],

            // Kpi chart data
            coalProductionActualData: [],
            coalProductionPlanData: [],
            coalProductionCategories: [],
        };
    },

    methods: {
        async fetchMiningData() {
            const response = await axios.get(
                "/api/control-tower/mining_detail?start_date=2024-01-01&end_date=2024-12-01",
                {
                    headers: {
                        Authorization: "Bearer " + this.authStore.getToken,
                    },
                }
            );
            this.miningData = response.data;

            const novemberData = subset(response.data, "2024-11-01", "2024-11-30");
            const kpiData = convertToDailyKpiData(novemberData);
            this.coalProductionActualData = kpiData.map(i => i.actual);
            this.coalProductionPlanData = kpiData.map(i => i.plan);
            this.coalProductionCategories = kpiData.map(i => formatDateToDayMonth(i.date));
        },
        async fetchData() {
            this.fetchMiningData();
        },
    },
    created() {
        this.fetchData();
    },
};
</script>
