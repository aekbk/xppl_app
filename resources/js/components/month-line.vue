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
