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
                                        OVERALL <span class="ms-3 text-muted fs-6"
                                            >Last updated on </span
                                        ><span class="text-danger fs-6"
                                            >November 13, 2024, at
                                            15:32:06</span
                                        >
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row justify-content-evenly mb-4">
                    <div class="col-lg-6">
                        <summary-statistic
                            :title="statistic1.title"
                            :subtitle="statistic1.subtitle"
                            :stats="statistic1.statisticsContent"
                        ></summary-statistic>
                    </div>
                    <div class="col-lg-6">
                        <summary-statistic
                            :title="statistic2.title"
                            :stats="statistic2.statisticsContent"
                        ></summary-statistic>
                    </div>
                </div>
                <div class="row justify-content-evenly mb-4">
                    <div class="col-lg-4">
                        <department-summary
                            :title="miningSummary.title"
                            :mainMetricTitle="miningSummary.mainMetricTitle"
                            :mainMetricSubtitle="
                                miningSummary.mainMetricSubtitle
                            "
                            :mainMetricActualData="
                                miningSummary.mainMetricActualData
                            "
                            :mainMetricCategories="
                                miningSummary.mainMetricCategories
                            "
                            :mainMetricPlanData="
                                miningSummary.mainMetricPlanData
                            "
                            :secondaryMetricTitle="
                                miningSummary.secondaryMetricTitle
                            "
                            :secondaryMetricSubtitle="
                                miningSummary.secondaryMetricSubtitle
                            "
                            :secondaryMetricStats="
                                miningSummary.secondaryMetricStats
                            "
                            :secondaryMetricCategories="
                                miningSummary.secondaryMetricCategories
                            "
                            :secondarySummaryHeader="
                                miningSummary.secondarySummaryHeader
                            "
                        ></department-summary>
                    </div>
                    <div class="col-lg-4">
                        <department-summary
                            :title="processingSummary.title"
                            :mainMetricTitle="processingSummary.mainMetricTitle"
                            :mainMetricSubtitle="
                                processingSummary.mainMetricSubtitle
                            "
                            :mainMetricActualData="
                                processingSummary.mainMetricActualData
                            "
                            :mainMetricCategories="
                                processingSummary.mainMetricCategories
                            "
                            :mainMetricPlanData="
                                processingSummary.mainMetricPlanData
                            "
                            :secondaryMetricTitle="
                                processingSummary.secondaryMetricTitle
                            "
                            :secondaryMetricSubtitle="
                                processingSummary.secondaryMetricSubtitle
                            "
                            :secondaryMetricStats="
                                processingSummary.secondaryMetricStats
                            "
                            :secondaryMetricCategories="
                                processingSummary.secondaryMetricCategories
                            "
                            :secondarySummaryHeader="
                                processingSummary.secondarySummaryHeader
                            "
                        ></department-summary>
                    </div>
                    <div class="col-lg-4">
                        <department-summary
                            :title="salesLogisticsSummary.title"
                            :mainMetricTitle="salesLogisticsSummary.mainMetricTitle"
                            :mainMetricSubtitle="
                                salesLogisticsSummary.mainMetricSubtitle
                            "
                            :secondaryMetricTitle="
                                salesLogisticsSummary.secondaryMetricTitle
                            "
                            :secondaryMetricSubtitle="
                                salesLogisticsSummary.secondaryMetricSubtitle
                            "
                        ></department-summary>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import SummaryStatistic from "../components/summary-statistic.vue";
import DepartmentSummary from "../components/department-summary.vue";
import { useAuthStore } from "../stores/auth";
import { useStore } from "../stores/store";
import { convertToDailyKpiData, convertToDailyKpiDataByAttr } from "../utils/chart";
import { formatDateToDayMonth } from "../utils/date";
import { roundToDecimalPlace } from "../utils/number";

export default {
    name: "ControlTower",

    setup() {
        const authStore = useAuthStore();
        const store = useStore();
        return { authStore, store };
    },

    components: {
        SummaryStatistic,
        DepartmentSummary,
    },

    data() {
        return {
            statistic1: {
                title: "Health, Safety & Environment",
                section1Title: "Total Coal Mined",
                section1Subtitle: "(MTD)",
                statisticsContent: [
                    {
                        label: "Lost Time Injury (LTI)",
                        value: 7,
                        icon: "assets/images/icons/icon_stopwatch.png",
                    },
                    {
                        label: "First Aid Injury (FAI)",
                        value: 5,
                        icon: "assets/images/icons/icon_briefcase.png",
                    },
                    {
                        label: "Medical Treatment Injury (MTI)",
                        value: 23,
                        icon: "assets/images/icons/icon_hospital.png",
                    },
                    {
                        label: "Restricted Work Injury (RWI)",
                        value: 12,
                        icon: "assets/images/icons/icon_vest.png",
                    },
                ],
            },
            statistic2: {
                title: "Inventory",
                statisticsContent: [
                    {
                        label: "Raw Coal From Mine",
                        value: 32.4,
                        icon: "assets/images/icons/icon_coal_pile.png",
                        unit: "Mt",
                    },
                    {
                        label: "Processed Coal On-Site",
                        value: 20.1,
                        icon: "assets/images/icons/icon_coal_pile.png",
                        unit: "Mt",
                    },
                    {
                        label: "Saleable Coal In-transit",
                        value: 10.8,
                        icon: "assets/images/icons/icon_truck.png",
                        unit: "Mt",
                    },
                    {
                        label: "Saleable Coal Off-site",
                        value: 8.3,
                        icon: "assets/images/icons/icon_coal_pile.png",
                        unit: "Mt",
                    },
                ],
            },
            processingSummary: {
                title: "Processing",
                mainMetricTitle: "Total Processing Throughput",
                mainMetricSubtitle: "(MTD)",
                mainMetricActualData: [],
                mainMetricPlanData: [],
                mainMetricCumPlanData: [],
                mainMetricCumActualData: [],
                secondaryMetricTitle: "Yield",
                secondaryMetricSubtitle: "(MTD)",
                secondaryMetricStats: [],
            },
            salesLogisticSummary: {
                title: "Sales & Logistics",
                mainMetricTitle: "Total Coal Sales Volume",
                mainMetricSubtitle: "(MTD)",
                mainMetricActualData: [],
                mainMetricPlanData: [],
                mainMetricCumPlanData: [],
                mainMetricCumActualData: [],
                secondaryMetricTitle: "Sales over Production Ratio",
                secondaryMetricSubtitle: "(MTD)",
                secondaryMetricStats: [],
            },
            miningData: [],
            isLoadingMiningData: false,
            miningDataLoaded: false,

            wasteData: [],
            isLoadingWasteData: false,
            wasteDataLoaded: false,
        };
    },

    mounted() {},

    methods: {
        async fetchMiningData() {
            this.isLoadingMiningData = true;
            const response = await axios.get(
                "/api/control-tower/mining_detail?start_date=2024-11-01&end_date=2024-12-01",
                {
                    headers: {
                        Authorization: "Bearer " + this.authStore.getToken,
                    },
                }
            );
            this.isLoadingMiningData = false;
            this.miningData = response.data;
            this.miningDataLoaded = true;
        },
        async fetchWasteData() {
            this.isLoadingWasteData = true;
            const response = await axios.get(
                "/api/control-tower/waste_detail?start_date=2024-11-01&end_date=2024-12-01",
                {
                    headers: {
                        Authorization: "Bearer " + this.authStore.getToken,
                    },
                }
            );
            this.isLoadingWasteData = false;
            this.wasteData = response.data;
            this.wasteDataLoaded = true;
        },
        async fetchData() {
            this.fetchMiningData();
            this.fetchWasteData();
        },
    },
    created() {
        this.fetchData();
    },
    computed: {
        miningSummary() {
            const mainKpiData = convertToDailyKpiData(this.miningData);
            const miningActualData = mainKpiData.map(
                (i) => i.actual
            );
            const miningPlanData = mainKpiData.map((i) => i.plan);
            const miningCategories = mainKpiData.map((i) =>
                formatDateToDayMonth(i.date)
            );
            
            const secondaryKpiData = convertToDailyKpiDataByAttr(this.wasteData, 'waste_plan_kbcm', 'waste_actual_kbcm');
            const wasteActualData = secondaryKpiData.map(
                (i) => i.actual
            );
            const stripRatio = wasteActualData.map((item, index) => {
                const result = item / miningActualData[index];
                if (isNaN(result)) {
                    return null;
                }
                return roundToDecimalPlace(result, 2);
            });

            return {
                title: "Mining",
                mainMetricTitle: "Total Coal Mined",
                mainMetricSubtitle: "(MTD)",
                mainMetricActualData: miningActualData,
                mainMetricPlanData: miningPlanData,
                mainMetricCategories: miningCategories,
                secondaryMetricTitle: "Strip Ratio",
                secondaryMetricSubtitle: "(MTD)",
                secondaryMetricStats: stripRatio,
                secondaryMetricCategories: miningCategories,
                secondarySummaryHeader: "MTD Avg", 
            };
        },
    },
};
</script>
