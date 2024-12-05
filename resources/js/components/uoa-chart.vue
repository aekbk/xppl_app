<template>
    <div>
        <!-- Should Render -->
        <apexchart
            type="radialBar"
            height="500"
            :options="getChartOptions"
            :series="getSeries"
        ></apexchart>
        <div class="text-center fs-4">
            <div>
                Total UoA: <span class="fw-bold">{{ totalUoa }} hours</span>
            </div>
            <div>
                Total MA: <span class="fw-bold">{{ totalUoa }} hours</span>
            </div>
        </div>
    </div>
</template>

<script lang="ts">
import VueApexCharts from "vue3-apexcharts";
import { getCumulativeData, getYMax } from "../utils/chart";
import { format } from "numerable";

export default {
    name: "UoaChart",
    components: {
        apexchart: VueApexCharts,
    },
    data() {
        return {};
    },
    computed: {
        getSeries() {
            if (this.totalMa === 0) {
                return [0];
            }

            return [
                (this.totalUoa/this.totalMa) * 100,
            ];
        },
        getChartOptions() {

            return {
                chart: {
                    height: 500,
                    type: "radialBar",
                    offsetY: -30,
                    sparkline: {
                        enabled: true,
                    },
                },
                plotOptions: {
                    radialBar: {
                        startAngle: -90,
                        endAngle: 90,
                        track: {
                            margin: 5, // margin is in pixels
                        },
                        dataLabels: {
                            name: {
                                show: true, // Show the label name
                                fontSize: "18px",
                                offsetY: -16,
                                fontWeight: 'normal',
                            },
                            value: {
                                offsetY: -60,
                                fontSize: "32px",
                                fontWeight: "bold",
                            },
                        },
                    },
                },
                colors: ["#FF0000", "#FFB700"],
                legend: {
                    position: "bottom",
                },
                fill: {
                    type: "gradient",
                    gradient: {
                        type: "horizontal",
                        shade: "light",
                        shadeIntensity: 0.4,
                        inverseColors: false,
                        gradientToColors: ["orange"],
                        opacityFrom: 1,
                        opacityTo: 1,
                        stops: [0, 100],
                    },
                    colors: ["#FF0000"],
                },
                labels: ["Average Results"],
            };
        },
    },
    props: {
        totalUoa: {
            type: Number,
            required: false,
            default: 0,
        },
        totalMa: {
            type: Number,
            required: false,
            default: 0,
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
