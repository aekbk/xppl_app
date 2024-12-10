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
import { format } from "numerable";
import VueApexCharts from "vue3-apexcharts";

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
                    data: this.data.map((dataNode) => {
                        return dataNode;
                    }),
                },
                {
                    name: "TrendLine",
                    type: "line",
                    // Compute trendline y = mx + b
                    data: (() => {
                        const filteredData = this.data.filter(item => item != null && item !== 0); // Exclude null and 0 values
                        const n = filteredData.length; // Total number of valid points
                        if (n < 2) return Array(this.data.length).fill(null); // Handle cases where there are not enough points
                        const xValues = filteredData.map((_, idx) => idx); // Use indices of filtered data

                        // Compute the means of x and y
                        const xMean = xValues.reduce((sum, x) => sum + x, 0) / n;
                        const yMean = filteredData.reduce((sum, val) => sum + val, 0) / n;

                        // Compute the slope (m) using the least squares formula
                        const numerator = xValues.reduce((sum, x, k) => sum + (x - xMean) * (filteredData[k] - yMean), 0);
                        const denominator = xValues.reduce((sum, x) => sum + (x - xMean) ** 2, 0);
                        const slope = denominator !== 0 ? numerator / denominator : 0; // Avoid division by zero

                        // Compute the intercept (b)
                        const intercept = yMean - slope * xMean;

                        // Return trendline values for all indices in the original data
                        // Modified: Ensure trendline spans all indices
                        return this.data.map((_, i) => slope * i + intercept);
                    })(),
                }
            ];
        },
        chartOptions() {
            const self = this;
            return {
                chart: {
                    height: 500,
                    type: "line",
                    toolbar: {
                        show: true,
                    },
                    animations: {
                        enabled: false,
                    }
                },
                dataLabels: {
                    enabled: true,
                },
                stroke: {
                    curve: "straight",
                },
                markers: {
                    size: 3,
                },
                plotOptions: {
                    bar: {
                        columnWidth: "50%",
                    },
                },
                dataLabels: {
                    enabled: true,
                    enabledOnSeries: [0],
                    formatter: function (value) {
                        return format(value, self.labelFormat)+ self.units; 
                    },
                },
                xaxis: {
                    categories: this.categories,
                },
                yaxis: [
                    {
                        title: {
                            text: self.yAxisTitle,
                        },
                        labels: {
                            formatter: function (value) {
                                return format(value, self.yAxisFormat) + self.units;
                            },
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
        units: {
            type: String,
            required: false,
            default: `t`,
        },
        yAxisTitle: {
            type: String,
            required: false,
            default: "Hourly Production (Ktonnes)",
        },
        labelFormat: {
            type: String,
            required: false,
            default: "0,0.0a",
        },
        yAxisFormat: {
            type: String,
            required: false,
            default: "0,0.0a",
        },
    },
};
</script>
