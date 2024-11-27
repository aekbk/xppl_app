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
  data() {
    return {
      series: [
      {
        name: "High - 2013",
        data: [28, 29, 33, 36, 32, 32, 33, null, null, null, null,
            null, null, null, null, null, null, null, null, null, null,
            null, null, null, null, null, null, null, null, null, null],
      },
      ],
      chartOptions: {
        chart: {
          height: 500,
          type: "line",
          stacked: false,
          toolbar: {
            show: true,
          },
        },
        dataLabels: {
          enabled: true,
        },
        stroke: {
          curve: 'smooth'
        },
        markers: {
          size: 1
        },
        plotOptions: {
          bar: {
            columnWidth: "50%",
          },
        },
        dataLabels: {
          enabled: false,
        },
        xaxis: {
          categories: [
            "1 Nov",
            "2 Nov",
            "3 Nov",
            "4 Nov",
            "5 Nov",
            "6 Nov",
            "7 Nov",
            "8 Nov",
            "9 Nov",
            "10 Nov",
            "11 Nov",
            "12 Nov",
            "13 Nov",
            "14 Nov",
            "15 Nov",
            "16 Nov",
            "17 Nov",
            "18 Nov",
            "19 Nov",
            "20 Nov",
            "21 Nov",
            "22 Nov",
            "23 Nov",
            "24 Nov",
            "25 Nov",
            "26 Nov",
            "27 Nov",
            "28 Nov",
            "29 Nov",
            "30 Nov",
          ],
          title: {
            text: "Date",
          },
        },
        yaxis: [
          {
            seriesName: "High - 2013",
            title: {
              text: "Daily Production (Ktonnes)",
            },
          }
        ],
        tooltip: {
          shared: true,
          intersect: false,
        },
        legend: {
          position: "bottom",
        },
      },
    };
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
