<template>
    <!-- Content :  Strip Ratio-->
    <div class="row justify-content-evenly mb-4">
        <card title="Strip Ratio">
        <month-line
                :data="stripRatioData"
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
    convertToKpiDataByAttr,
} from "../utils/chart";
import { formatDateToDayMonth } from "../utils/date";
import { subset } from "../utils/data";
import { roundToDecimalPlace } from "../utils/number";
import MonthLine from "../components/month-line.vue";

export default {
    name: "MiningDrilldown/Strip-Ratio",
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
            stripRatioProductionData: [],
            wasteProductionCategories: [],
        };
    },
    computed: {
        stripRatioData() {
            return this.stripRatioProductionData;
        },
    },

    methods: {
        async fetchStripRatioData() {

            // mining data: to fetch daily actual mined volume
            const miningResponse = await axios.get(
                "/api/control-tower/mining_detail?start_date=2024-01-01&end_date=2024-12-01",
                {
                    headers: {
                        Authorization: "Bearer " + this.authStore.getToken,
                    },
                }
            );

            const novemberMiningData = subset(
                miningResponse.data,
                "2024-11-01",
                "2024-11-30"
            );
            const kpiData = convertToKpiDataByAttr(novemberMiningData, 'coat_actual_kt', 'coal_plan_kt').daily;
            const coalProductionActualData = kpiData.map((i) => i.actual);


            // waste data: daily actual waste volume
            const wasteResponse = await axios.get(
                "/api/control-tower/waste_detail?start_date=2024-01-01&end_date=2024-12-01",
                {
                    headers: {
                        Authorization: "Bearer " + this.authStore.getToken,
                    },
                }
            );
            const novemberWasteData = subset(
                wasteResponse.data,
                "2024-11-01",
                "2024-11-30"
            );
            const wasteKPIData = convertToKpiDataByAttr(novemberWasteData, 'waste_plan_kbcm', 'waste_actual_kbcm').daily;
            const wasteActualData = wasteKPIData.map((i) => i.actual);
            const wasteCategories = wasteKPIData.map((i) =>
                formatDateToDayMonth(i.date)
            );

            this.wasteProductionCategories = wasteCategories;
            this.stripRatioProductionData = wasteActualData.map((item, index) => {
                const result = item / coalProductionActualData[index];
                if (isNaN(result)) {
                    return null;
                }
                return roundToDecimalPlace(result, 2);
            });

        },

        async fetchData() {
            this.fetchStripRatioData();
        },
    },
    created() {
        this.fetchData();
    },
};
</script>
