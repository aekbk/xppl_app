<template>
  <div>
    <apexchart
      type="bar"
      height="500"
      :options="chartOptions"
      :series="series"
    ></apexchart>
  </div>
</template>

<script>
import VueApexCharts from "vue3-apexcharts";

export default {
  name: "KpiChart",
  components: {
    apexchart: VueApexCharts,
  },
  data() {
    return {
      series: [
        {
          name: "Actual",
          type: "column",
          data: [
            57.44, 51.36, 49.61, 53.11, 51.99, 56.09, 56.34, 62.46, 50.5,
            53.11, 43.54, 3.6, 3.6, null, null, null, null, null, null,
            null, null, null, null, null, null, null, null, null, null,
            null,
          ],
        },
        {
          name: "Plan",
          type: "line",
          data: new Array(30).fill(40),
        },
        {
          name: "Cum Plan",
          type: "line",
          data: Array.from({ length: 30 }, (_, i) => Math.round((i + 1) * 28.3)),
        },
        {
          name: "Cum Actual",
          type: "line",
          data: [
            57.44, 108.8, 158.41, 211.52, 263.51, 319.6, 375.94, 438.4,
            488.9, 542.01, 585.55, 589.15, 592.75, null, null, null, null,
            null, null, null, null, null, null, null, null, null, null,
            null, null, null,
          ],
        },
        {
          name: "Revised Plan",
          type: "line",
          data: new Array(30).fill(28.3),
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
        stroke: {
          width: [0, 2, 2, 2, 2],
          curve: "smooth",
          dashArray: [0, 0, 0, 0, 5], // Dashed line for Revised Plan
        },
        plotOptions: {
          bar: {
            columnWidth: "50%",
          },
        },
        dataLabels: {
          enabled: false,
        },
        colors: ["#2c3e50", "#2ecc71", "#3498db", "#f1c40f", "#34495e"],
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
            seriesName: "Actual",
            title: {
              text: "Daily Production (Ktonnes)",
            },
          },
          {
            opposite: true,
            seriesName: "Cum. Plan",
            title: {
              text: "Cumulative Production (Mtonnes)",
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
