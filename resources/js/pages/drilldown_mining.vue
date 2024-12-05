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
                                        MINING
                                        <span class="ms-3 text-muted fs-6"
                                            >Viewing data up to </span
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
import SummaryStatistic from "../components/summary-statistic.vue";
import DepartmentSummary from "../components/department-summary.vue";
import MonthLine from "../components/month-line.vue";
import Card from "../components/card.vue";
import { useAuthStore } from "../stores/auth";
import { useStore } from "../stores/store";
import ToDateTable from "../components/to-date-table.vue";
import KpiChart from "../components/kpi-chart.vue";
import { convertToDailyKpiData, convertToKpiDataByAttr} from "../utils/chart";
import { formatDateToDayMonth } from "../utils/date";
import { subset } from "../utils/data";
import { roundToDecimalPlace } from "../utils/number";
import {RouterView } from "vue-router";
import NavTabs from "../components/nav-tabs.vue";

export default {
    name: "MiningDrilldown",
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
        MonthLine,
        RouterView,
        NavTabs,
    },

    data() {
        return {
            // Strip Ratio
            stripRatioProductionData: [],

            navs: [
                { label: "Coal Production", to: "/drilldown-mining/coal-production" },
                { label: "Waste Production", to: "/drilldown-mining/waste-production" },
                { label: "Strip Ratio", to: "/drilldown-mining/strip-ratio" },
                // { label: "Broken Stock", to: "/drilldown-mining/broken-stock" },
                // { label: "Water Volume", to: "/drilldown-mining/water-volume" },
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

            const novemberData = subset(
                response.data,
                "2024-11-01",
                "2024-11-30"
            );
            const kpiData = convertToDailyKpiData(novemberData);
            this.coalProductionActualData = kpiData.map((i) => i.actual);
            this.coalProductionPlanData = kpiData.map((i) => i.plan);
            this.coalProductionCategories = kpiData.map((i) =>
                formatDateToDayMonth(i.date)
            );
        },
        async fetchWasteData() {
            const response = await axios.get(
                "/api/control-tower/waste_detail?start_date=2024-01-01&end_date=2024-12-01",
                {
                    headers: {
                        Authorization: "Bearer " + this.authStore.getToken,
                    },
                }
            );
            this.wasteData = response.data;

            const novemberData = subset(
                response.data,
                "2024-11-01",
                "2024-11-30"
            );
            const kpiData = convertToKpiDataByAttr(novemberData, 'waste_plan_kbcm', 'waste_actual_kbcm').daily;
            const wasteActualData = kpiData.map((i) => i.actual);
            const wastePlanData = kpiData.map((i) => i.plan);
            const wasteCategories = kpiData.map((i) =>
                formatDateToDayMonth(i.date)
            );

            this.wasteProductionActualData = wasteActualData;
            this.wasteProductionPlanData = wastePlanData;
            this.wasteProductionCategories = wasteCategories;

            this.stripRatioProductionData = wasteActualData.map((item, index) => {
                const result = item / this.coalProductionActualData[index];
                if (isNaN(result)) {
                    return null;
                }
                return roundToDecimalPlace(result, 2);
            });


        },

        async fetchData() {
            this.fetchMiningData();
            this.fetchWasteData();
        },
    },
    created() {
        //this.fetchData();
    },
};
</script>
