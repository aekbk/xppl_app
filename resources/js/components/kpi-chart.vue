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

/**
 * Determines the appropriate scale (K, M, B) and divisor for formatting values.
 * Assumes that the base data unit is already in thousands (K).
 *
 * Example:
 * - A value of 57.4 represents 57.4K (57,400).
 * - Values >= 1,000 represent millions (M).
 * - Values >= 1,000,000 represent billions (B).
 *
 * @param value Max value in the dataset (assumed to be in K)
 * @returns Scale ("K", "M", "B") and divisor for formatting
 */
function getScaleAndDivisor(value: number): { scale: string; divisor: number } {
    if (value >= 1_000_000) {
        return { scale: "B", divisor: 1_000_000 }; // Billion (B)
    } else if (value >= 1_000) {
        return { scale: "M", divisor: 1_000 }; // Million (M)
    } else {
        return { scale: "K", divisor: 1 }; // Thousand (K) as default
    }
}

/**
 * Scales and formats a value based on a given divisor.
 *
 * @param value Value to format (assumed to be in K)
 * @param divisor Divisor to scale the value
 * @returns Formatted string (e.g., 5000Ktones -> 5.0Mtonnes)
 */
function scaleAndFormatValue(value: number, divisor: number): string {
    return format(value / divisor, "0,0.0a");
}

/**
 * Adjusts the Y-axis title to match the scale of the largest values.
 * Replaces the unit (e.g., "K", "M", "B") in the original title based on the scale.
 *
 * @param maxValue Max value in the dataset (assumed to be in K)
 * @param originalTitle Original title (e.g., "Daily Production (Kxxx)")
 * @returns Adjusted title (e.g., "Daily Production (Mxxx)")
 */
function adjustYAxisTitle(maxValue: number, originalTitle: string): string {
    const { scale } = getScaleAndDivisor(maxValue);
    return originalTitle.replace(/K|M|B/, scale); // Replace unit with the appropriate scale
}

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
            const maxDailyValue = getYMax([...this.actualData, ...this.planData]);
            const maxCumulativeValue = Math.max(...cumPlan, ...cumActual);

            // Adjust titles based on the maximum values
            const adjustedLeftTitle = adjustYAxisTitle(maxDailyValue, this.leftYAxisTitle);
            const adjustedRightTitle = adjustYAxisTitle(maxCumulativeValue, this.rightYAxisTitle);

            // Get scale and divisor for formatting
            const { divisor: dailyDivisor } = getScaleAndDivisor(maxDailyValue);
            const { divisor: cumulativeDivisor } = getScaleAndDivisor(maxCumulativeValue);

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
                            text: adjustedLeftTitle,
                        },
                        max: getYMax([...this.actualData, ...this.planData]),
                        min: 0,
                        labels: {
                            formatter: (value) => scaleAndFormatValue(value, dailyDivisor),
                        },
                        tickAmount: 10,
                    },
                    {
                        title: {
                            text: adjustedLeftTitle,
                        },
                        min: 0,
                        max: getYMax([...this.actualData, ...this.planData]),
                        show: false,
                        labels: {
                            formatter: (value) => scaleAndFormatValue(value, dailyDivisor),
                        },
                        tickAmount: 10,
                    },
                    {
                        opposite: true,
                        show: true,
                        title: {
                            text: adjustedRightTitle,
                        },
                        forceNiceScale: true,
                        decimalsInFloat: 2,
                        tickAmount: 10,
                        max: getYMax([...cumActual, ...cumPlan]),
                        labels: {
                            formatter: (value) => scaleAndFormatValue(value, cumulativeDivisor),
                       },
                    },
                    {
                        opposite: true,
                        show: false,
                        title: {
                            text: adjustedRightTitle,
                        },
                        forceNiceScale: true,
                        decimalsInFloat: 2,
                        tickAmount: 10,
                        max: getYMax([...cumActual, ...cumPlan]),
                        labels: {
                            formatter: (value) => scaleAndFormatValue(value, cumulativeDivisor),
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
