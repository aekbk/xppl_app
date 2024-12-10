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
                            // note the base data unit in db is always ktonnes
                            // if the value >= 1000, we should use RHS y-axis title (Mtonnes) and divide the value by 1000
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
                            // note the base data unit in db is always ktonnes
                            // if the value >= 1000, we should use RHS y-axis title (Mtonnes) and divide the value by 1000
                            text: getYMax([...this.actualData, ...this.planData]) >= 1000
                                ? this.rightYAxisTitle.replace("Cum. ", "")
                                : this.leftYAxisTitle
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
                            formatter: (value) => format(value/1000, "0,0.0a"), // divide by 1000 to convert to Mt
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
                            formatter: (value) => format(value/1000, "0,0.0a"), // divide by 1000 to convert to Mt
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
