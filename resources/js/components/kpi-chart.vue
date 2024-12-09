<template>
    <div class="custom-grid" v-if="loaded">
        <!-- Should Render -->
        <apexchart
            type="bar"
            height="500"
            :options="getChartOptions"
            :series="getSeries"
        ></apexchart>
    </div>
</template>

<script lang="ts">
import VueApexCharts from "vue3-apexcharts";
import { getCumulativeData, getYMax } from "../utils/chart";
import { format } from "numerable";

export default {
    name: "KpiChart",
    components: {
        apexchart: VueApexCharts,
    },
    data() {
        return {};
    },
    computed: {
        getSeries() {
            return [
                {
                    name: "Actual",
                    type: "column",
                    data: this.actualData,
                },
                {
                    name: "Plan",
                    type: "line",
                    data: this.planData,
                },
                {
                    name: "Cum Plan",
                    type: "line",
                    data: getCumulativeData(this.planData),
                },
                {
                    name: "Cum Actual",
                    type: "line",
                    data: getCumulativeData(this.actualData),
                },
            ];
        },
        getChartOptions() {
            const cumPlan = getCumulativeData(this.planData);
            const cumActual = getCumulativeData(this.actualData);
            const cumMax = Math.max(...cumPlan, ...cumActual);

            return {
                chart: {
                    height: 500,
                    type: "line",
                    stacked: false,
                    toolbar: {
                        show: true,
                    },
                    animations: {
                        enabled: false,
                    },
                },
                stroke: {
                    width: [2, 2, 2, 2, 2], // Match number of series
                    curve: "straight",
                    dashArray: [0, 0, 0, 0, 5], // Dashed line for Revised Plan
                },
                // markers: {
                //   size: 5,
                // },
                plotOptions: {
                    bar: {
                        columnWidth: "100%",
                    },
                },
                dataLabels: {
                    enabled: false,
                },
                // colors: [bar, redLine, blueLine, yellowLine],
                colors: ["#2A3B6C", "#F8876A", "#4F9AD6", "#F4C56E"],
                xaxis: {
                    categories: this.categories,
                },
                yaxis: [
                    {
                        title: {
                            // If the value displayed is 1000Ktonnes, it is likely that we are using the year-to-date (YTD) data. 
                            // In this case, the right-hand side (RHS) y-axis title should be used, such as Mtones. It should be noted that the base unit is already in Ktones.
                            text: getYMax([...this.actualData, ...this.planData]) >= 1000
                                ? this.rightYAxisTitle.replace("Cum. ", "")
                                : this.leftYAxisTitle
                        },
                        max: getYMax([...this.actualData, ...this.planData]),
                        min: 0,
                        labels: {
                            formatter: (value) => {
                                // value is in Ktonnes
                                // if we see 1000Ktonnes, we should show 1Mt
                                if (value >= 1000) {
                                    return format(value / 1000, "0,0.0a"); // Scale to Mt
                                } else {
                                    return format(value, "0,0.0a"); // keep it Kt
                                }
                            }
                        },
                        tickAmount: 10,
                    },
                    {
                        title: {
                            // If the value displayed is 1000Ktonnes, it is likely that we are using the year-to-date (YTD) data. 
                            // In this case, the right-hand side (RHS) y-axis title should be used, such as Mtones. It should be noted that the base unit is already in Ktones.
                            text: getYMax([...this.actualData, ...this.planData]) >= 1000
                                ? this.rightYAxisTitle.replace("Cum. ", "")
                                : this.leftYAxisTitle,
                        },
                        min: 0,
                        max: getYMax([...this.actualData, ...this.planData]),
                        show: false,
                        labels: {
                            formatter: (value) => {
                                // value is in Ktonnes
                                // if we see 1000Ktonnes, we should show 1Mt
                                if (value >= 1000) {
                                    return format(value / 1000, "0,0.0a"); // Scale to Mt
                                } else {
                                    return format(value, "0,0.0a"); // keep it Kt
                                }
                            }
                        },
                        tickAmount: 10,
                    },
                    {
                        opposite: true,
                        show: true,
                        title: {
                            text: this.rightYAxisTitle,
                        },
                        forceNiceScale: true,
                        decimalsInFloat: 2,
                        tickAmount: 10,
                        max: getYMax([...cumActual, ...cumPlan]),
                        labels: {
                            formatter: (value) => {
                                // value is in Ktonnes
                                // if we see 1000Ktonnes, we should show 1Mt
                                if (value >= 1000) {
                                    return format(value / 1000, "0,0.0a"); // Scale to Mt
                                } else {
                                    return format(value, "0,0.0a"); // keep it Kt
                                }
                            }
                       },
                    },
                    {
                        opposite: true,
                        show: false,
                        title: {
                            text: this.rightYAxisTitle,
                        },
                        forceNiceScale: true,
                        decimalsInFloat: 2,
                        tickAmount: 10,
                        max: getYMax([...cumActual, ...cumPlan]),
                        labels: {
                            formatter: (value) => {
                                // value is in Ktonnes
                                // if we see 1000Ktonnes, we should show 1Mt
                                if (value >= 1000) {
                                    return format(value / 1000, "0,0.0a"); // Scale to Mt
                                } else {
                                    return format(value, "0,0.0a"); // keep it Kt
                                }
                            }
                        },
                    },
                ],
                tooltip: {
                    shared: true,
                    intersect: false,
                },
                legend: {
                    position: "bottom",
                },
            };
        },
        loaded(): boolean {
            return this.actualData.length > 0 && this.planData.length > 0;
        },
    },
    props: {
        actualData: {
            type: Array<Number>,
            required: false,
            default: () => [],
        },
        planData: {
            type: Array<Number>,
            required: false,
            default: () => [],
        },
        categories: {
            type: Array<String>,
            required: false,
            default: () => [],
        },
        leftYAxisTitle: {
            type: String,
            required: false,
            default: "Daily Production (Ktonnes)",
        },
        rightYAxisTitle: {
            type: String,
            required: false,
            default: "Monthly Production (Mtonnes)",
        },
    },
};
</script>

<style>
.chart-container {
    position: relative;
    height: 500px;
    width: 100%;
}
</style>
