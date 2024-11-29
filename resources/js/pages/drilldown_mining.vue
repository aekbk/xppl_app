<template>
    <div>
        <div class="row">
            <div class="col-lg-12">
                <div class="card rounded-0 mx-n4 mt-n4 border-top sticky-top" style="top: 70px;">
                    <div class="px-4">
                        <div class="row">
                            <div class="col-xxl-6 align-self-center">
                                <div class="">
                                    <p class="fs-15 mt-3">MINING <span class="ms-3 text-muted fs-6">Last updated on
                                      </span><span class="text-danger fs-6">November 13, 2024, at 15:32:06</span></p>
                                </div>
                                <div>
                                    <ul class="nav nav-tabs">
  <li class="nav-item">
    <a class="nav-link active" href="#">Active</a>
  </li>
  <li class="nav-item">
    <a class="nav-link" href="#">Link</a>
  </li>
  <li class="nav-item">
    <a class="nav-link" href="#">Link</a>
  </li>
  <li class="nav-item">
    <a class="nav-link disabled" href="#">Disabled</a>
  </li>
</ul>
                                </div>
                            </div>
                        </div>
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
