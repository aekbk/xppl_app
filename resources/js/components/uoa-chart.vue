<template>
    <div>
        <!-- Should Render -->
        <apexchart
            type="radialBar"
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
    name: "UoaChart",
    components: {
        apexchart: VueApexCharts,
    },
    data() {
        return {};
    },
    computed: {
        getSeries() {
            return [
                70
            ];
        },
        getChartOptions() {
            // const cumPlan = getCumulativeData(this.planData);
            // const cumActual = getCumulativeData(this.actualData);
            // const cumMax = Math.max(...cumPlan, ...cumActual);

            return {
                chart: {
                    height: 500,
                    type: "radialBar",
                },
                // markers: {
                //   size: 5,
                // },
                plotOptions: {
                    radialBar: {
                hollow: {
                  size: '70%',
                }
              },
                },
                colors: ["#20E647"],
                legend: {
                    position: "bottom",
                },
            };
        },
    },
    props: {
        
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
