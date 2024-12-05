<template>
    <!-- Content : Waste Production-->
    <div class="row justify-content-evenly mb-4">
        <card title="Total Mining Waste Production">
            <to-date-table
                    :data="rawWasteData"
                    :sliceAttribute="'contractor'"
                    :attributeHeader="'Con.'"
                    :actualAttrName="'waste_actual_kbcm'"
                    :planAttrName="'waste_plan_kbcm'"
                    ></to-date-table>

            <chart-group
                :selectedTab="selectedByContractorTab"
                :availableFilter="availableByContractorFilter"
                :selectedFilter="selectedByContractorFilter"
                @filterChange="setByContractorSelectedFilter"
                @tabSwitch="setByContractorSelectedTab"
            >
                <h5>Total Mining Waste Production: {{ selectedByContractorFilter }}</h5>
                <kpi-chart
                    :actualData="wasteProductionActualDataByContractor"
                    :planData="wasteProductionPlanDataByContractor"
                    :categories="wasteProductionCategoriesByContractor"
                 ></kpi-chart>

                <month-line
                    :data="wasteBCMPerHourByContractorData"
                    :categories="wasteProductionCategoriesByContractor"
                ></month-line>
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
    convertToDailyKpiData,
    convertToKpiDataByAttr,
} from "../utils/chart";
import { formatDateToDayMonth, formatDateToMonthYear } from "../utils/date";
import { subset } from "../utils/data";
import { roundToDecimalPlace } from "../utils/number";
import ChartGroup from "../components/chart-group.vue";
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
        ChartGroup,
    },

    data() {
        return {
            rawWasteData: [],

            // Waste Production byContractor toggle
            selectedByContractorTab: 'mtd',
            // Waste Production byContractor dropdown/filter
            selectedByContractorFilter: 'Total',

            wasteProductionActualData: [],
            wasteProductionPlanData: [],
            wasteProductionCategories: [],
        };
    },
    computed: {

        // function to get the filtered data for the selected contractor from dropdown list
        // return two types of data: daily and monthly
        wasteByContractorData() {
            if (this.rawWasteData.length === 0) {
                return {
                    daily: [],
                    monthly: [],
                };
            }

            const filteredData = this.selectedByContractorFilter === 'Total'
                ? this.rawWasteData
                : this.rawWasteData.filter((i) => i.contractor === this.selectedByContractorFilter);

            return convertToKpiDataByAttr(filteredData, 'waste_plan_kbcm', 'waste_actual_kbcm', '2024-11-01', '2024-11-30', );
        },

        // get the actual waste amount for the selected period from toggle tab
        wasteProductionActualDataByContractor() {
            if (this.selectedByContractorTab === 'mtd') {

                return this.wasteByContractorData.daily.map((i) => i.actual);
            }
            return this.wasteByContractorData.monthly.map((i) => i.actual);
        },

        // get the plan waste amount for the selected period from toggle tab
        wasteProductionPlanDataByContractor() {
            if (this.selectedByContractorTab === 'mtd') {
                return this.wasteByContractorData.daily.map((i) => i.plan);
            }
            return this.wasteByContractorData.monthly.map((i) => i.plan);
        },

        // get the categories for the selected period from toggle tab
        wasteProductionCategoriesByContractor() {
            if (this.selectedByContractorTab === 'mtd') {
                return this.wasteByContractorData.daily.map((i) => formatDateToDayMonth(i.date));
            }
            return this.wasteByContractorData.monthly.map((i) => formatDateToMonthYear(i.date));
        },

        // function return the list of available contractor for dropdown list
        availableByContractorFilter() {
            return uniq(this.rawWasteData.map((i) => i.contractor));
        },

        wasteBCMPerHourByContractorData() {
            return this.wasteProductionActualDataByContractor.map((i) => roundToDecimalPlace(i / 24));
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

            this.rawWasteData = response.data;
        },

        async fetchData() {
            this.fetchWasteData();
        },

        // event listener for the dropdown list
        setByContractorSelectedFilter(filter_value) {
            this.selectedByContractorFilter = filter_value;
        },

        // event listener for the toggle tab
        setByContractorSelectedTab(toggle_value) {
            this.selectedByContractorTab = toggle_value;
        },

    },
    created() {
        this.fetchData();
    },
};
</script>
