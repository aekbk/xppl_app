<template>
    <!-- Content :  Strip Ratio-->
    <div class="row justify-content-evenly mb-4">
        <card title="Strip Ratio">
            <nested-chart-group
                :selectedTab="selectedByContractorAndPitTab"
                :primaryAvailableFilter="availableByContractorFilter"
                :primarySelectedFilter="selectedByContractorFilter"
                :secondaryAvailableFilter="availableByPitFilter"
                :secondarySelectedFilter="selectedByPitFilter"
                @primaryFilterChange="setByContractorSelectedFilter"
                @secondaryFilterChange="setByPitSelectedFilter"
                @tabSwitch="setByContractorAndPitSelectedTab"
            >
                <month-line
                    :data="stripRatioDataByContractorAndPit"
                    :categories="wasteProductionCategoriesByContractorAndPit"
                 ></month-line>
            </nested-chart-group>
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
    convertToDailyKpiData,
    convertToKpiDataByAttr,
} from "../utils/chart";
import { formatDateToDayMonth, formatDateToMonthYear } from "../utils/date";
import { subset } from "../utils/data";
import { roundToDecimalPlace } from "../utils/number";
import MonthLine from "../components/month-line.vue";
import NestedChartGroup from "../components/nested-chart-group.vue";

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
        NestedChartGroup,
    },

    data() {
        return {

            rawMiningData: [],
            rawWasteData: [],

            // selected toggle value
            selectedByContractorAndPitTab: "mtd",

            // selected filter values for contractor and pit
            selectedByContractorFilter: "Total",
            selectedByPitFilter: "Total",
        };
    },
    computed: {
        stripRatioData() {
            return this.stripRatioProductionData;
        },
    },

    methods: {
        async fetchStripRatioData() {

            // mining data
            const miningResponse = await axios.get(
                "/api/control-tower/mining_detail?start_date=2024-01-01&end_date=2024-12-01",
                {
                    headers: {
                        Authorization: "Bearer " + this.authStore.getToken,
                    },
                }
            );
            this.rawMiningData = miningResponse.data;


            // waste data
            const wasteResponse = await axios.get(
                "/api/control-tower/waste_detail?start_date=2024-01-01&end_date=2024-12-01",
                {
                    headers: {
                        Authorization: "Bearer " + this.authStore.getToken,
                    },
                }
            );
            this.rawWasteData = wasteResponse.data;

        },
        async fetchData() {
            this.fetchStripRatioData();
        },

        // event listener for contractor dropdown list
        setByContractorSelectedFilter(contractor_filter_value) {
            this.selectedByContractorFilter = contractor_filter_value;
        },

        // event listener for pit dropdown list
        setByPitSelectedFilter(pit_filter_value) {
            this.selectedByPitFilter = pit_filter_value;
        },

        // event listener for the toggle tab
        setByContractorAndPitSelectedTab(toggle_value) {
            this.selectedByContractorAndPitTab = toggle_value;
        },


    },
    created() {
        this.fetchData();
    },
};
</script>
