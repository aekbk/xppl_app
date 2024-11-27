<template>
    <div>
        <div class="row">
            <div class="col-lg-12">
                <div class="card rounded-0 mx-n4 mt-n4 border-top sticky-top">
                    <div class="px-4">
                        <div class="row">
                            <div class="col-xxl-6 align-self-center">
                                <div class="">
                                    <p class="fs-15 mt-3">OVERALL hello</p>
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
                            :title="statistic1.title"
                            :mainMetricTitle="miningSummary.mainMetricTitle"
                            :mainMetricSubtitle="miningSummary.mainMetricSubtitle"
                            :secondaryMetricTitle="miningSummary.secondaryMetricTitle"
                            :secondaryMetricSubtitle="miningSummary.secondaryMetricSubtitle"
                        ></department-summary>
                    </div>
                    <div class="col-lg-4">
                        <department-summary
                            :title="statistic2.title"
                            :stats="statistic2.statisticsContent"
                        ></department-summary>
                    </div>
                    <div class="col-lg-4">
                        <department-summary
                            :title="statistic2.title"
                            :stats="statistic2.statisticsContent"
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

export default {
    name: "ControlTower",

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
            miningSummary: {
                title: "Mining",
                mainMetricTitle: "Total Coal Mined",
                mainMetricSubtitle: "(MTD)",
                mainMetricActualData: [],
                mainMetricPlanData: [],
                mainMetricCumPlanData: [],
                mainMetricCumActualData: [],
                secondaryMetricTitle: "Strip Ratio",
                secondaryMetricSubtitle: "(MTD)",
                secondaryMetricStats: [],
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
            processingSummary: {
                title: "Mining",
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
        };
    },

    mounted() {},

    methods: {},
};
</script>
