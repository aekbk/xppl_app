<template>
    <!-- Content : Waste Production-->
    <div class="row justify-content-evenly mb-4">
        <card title="Total Mining Coal Production By Contractor">
        <to-date-table
                :data="wasteData"
                :sliceAttribute="'contractor'"
                :attributeHeader="'Con.'"
                :actualAttrName="'waste_actual_kbcm'"
                :planAttrName="'waste_plan_kbcm'"
                ></to-date-table>

        <kpi-chart
                :actualData="wasteProductionActualData"
                :planData="wasteProductionPlanData"
                :categories="wasteProductionCategories"
                ></kpi-chart>

        <month-line
                :data="wasteBCMPerHourData"
                :categories="wasteProductionCategories"
                ></month-line>
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
import { roundToDecimalPlace } from "../utils/number";
import MonthLine from "../components/month-line.vue";

export default {
    name: "MiningDrilldown/Waste-Production",
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
    },

    data() {
        return {
            wasteData: [],

            wasteProductionActualData: [],
            wasteProductionPlanData: [],
            wasteProductionCategories: [],
        };
    },
    computed: {
        wasteBCMPerHourData() {
            return this.wasteProductionActualData.map((i) => roundToDecimalPlace(i / 24));
        },
    },

    methods: {
        async fetchWasteData() {
            const response = await axios.get(
                "/api/control-tower/waste_detail?start_date=2024-01-01&end_date=2024-12-01",
                {
                    headers: {
                        Authorization: "Bearer " + this.authStore.getToken,
                    },
                }
            );
            const novemberData = subset(
                response.data,
                "2024-11-01",
                "2024-11-30"
            );
            const kpiData = convertToDailyKpiDataByAttr(novemberData, 'waste_plan_kbcm', 'waste_actual_kbcm');
            const wasteActualData = kpiData.map((i) => i.actual);
            const wastePlanData = kpiData.map((i) => i.plan);
            const wasteCategories = kpiData.map((i) =>
                formatDateToDayMonth(i.date)
            );

            this.wasteData = response.data;
            this.wasteProductionActualData = wasteActualData;
            this.wasteProductionPlanData = wastePlanData;
            this.wasteProductionCategories = wasteCategories;

//            this.stripRatioProductionData = wasteActualData.map((item, index) => {
//                const result = item / this.coalProductionActualData[index];
//                if (isNaN(result)) {
//                    return null;
//                }
//                return roundToDecimalPlace(result, 2);
//            });

        },

        async fetchData() {
            this.fetchWasteData();
        },
    },
    created() {
        this.fetchData();
    },
};
</script>
