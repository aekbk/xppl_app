<template>
    <div>
        <div class="row">
            <div class="col-lg-12">
                <div
                    class="card rounded-0 mx-n4 mt-n4 border-top sticky-top"
                    style="top: 70px"
                >
                    <div class="px-4">
                        <div class="row">
                            <div class="col-xxl-6 align-self-center">
                                <div class="">
                                    <p class="fs-15 mt-3">
                                        PROCESSING
                                        <span class="ms-3 text-muted fs-6"
                                            >Last updated on </span
                                        ><span class="text-danger fs-6"
                                            >November 13, 2024, at
                                            15:32:06</span
                                        >
                                    </p>
                                </div>
                                <div>
                                    <nav-tabs :navs="navs">

                                    </nav-tabs>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <router-view />
            </div>
        </div>
    </div>
</template>

<script>
import { RouterView } from "vue-router";
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
import NavTabs from "../components/nav-tabs.vue";

export default {
    name: "ProcessingDrilldown",
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
        RouterView,
        NavTabs,
    },

    data() {
        return {
            miningData: [], 

            // Kpi chart data
            coalProductionActualData: [],
            coalProductionPlanData: [],
            coalProductionCategories: [],

            navs: [
                { label: "Input", to: "/drilldown-processing/input" },
                { label: "Throughput", to: "/drilldown-processing/throughput" },
                { label: "Yield", to: "/drilldown-processing/yield" },
                { label: "MA & UoA", to: "/drilldown-processing/ma-uoa" },
            ],
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
        // Need to decide if we do loading here or in the child components
        // this.fetchData();
    },
};
</script>
