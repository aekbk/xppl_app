<template>
    <div>
        <apexchart
            type="line"
            height="500"
            :options="chartOptions"
            :series="series"
        ></apexchart>
    </div>
</template>

<script>
import VueApexCharts from "vue3-apexcharts";
import { roundToDecimalPlace } from "../utils/number";

export default {
    name: "MonthLine",
    components: {
        apexchart: VueApexCharts,
    },
    computed: {
        series() {
            return [
                {
                    name: "Actual",
                    type: "line",
                    data: this.data,
                },
                {
                    name: "TrendLine",
                    type: "line",
					// Compute trendline y = mx + b
                    data: this.data.map((y, i, arr) => {
                        const n = arr.length; // Total number of points
                        const xValues = arr.map((_, idx) => idx); // Use indices as x-values

                        // Compute the means of x and y
                        const xMean = xValues.reduce((sum, x) => sum + x, 0) / n;
                        const yMean = arr.reduce((sum, val) => sum + val, 0) / n;

                        // Compute the slope (m) using the least squares formula
                        const numerator = xValues.reduce((sum, x, k) => sum + (x - xMean) * (arr[k] - yMean), 0);
                        const denominator = xValues.reduce((sum, x) => sum + (x - xMean) ** 2, 0);
                        const slope = denominator !== 0 ? numerator / denominator : 0; // Avoid division by zero

                        // Compute the intercept (b)
                        const intercept = yMean - slope * xMean;

                        // Compute the trendline value for the current index (x = i)
                        return roundToDecimalPlace(slope * i + intercept);
                    }),
                }
            ];
        },
        chartOptions() {
            return {
                chart: {
                    height: 500,
                    type: "line",
                    toolbar: {
                        show: true,
                    },
                },
                dataLabels: {
                    enabled: true,
                },
                stroke: {
                    curve: "smooth",
                },
                markers: {
                    size: 1,
                },
                plotOptions: {
                    bar: {
                        columnWidth: "50%",
                    },
                },
                dataLabels: {
                    enabled: true,
                },
                xaxis: {
                    categories: this.categories,
                },
                yaxis: [
                    {
                        title: {
                            text: "Daily Production (Ktonnes)",
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
    },
    props: {
        data: {
            type: Array,
            required: false,
            default: [],
        },
        categories: {
            type: Array,
            required: false,
            default: [],
        },
    },
};
</script>
