<template>
  <div>
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
      ]
    },
    getChartOptions() {
  return {
    chart: {
      height: 500,
      type: "line",
      stacked: false,
      toolbar: {
        show: true,
      },
    },
    stroke: {
      width: [2, 2, 2, 2, 2], // Match number of series
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
        "1 Nov", "2 Nov", "3 Nov", "4 Nov", "5 Nov", "6 Nov", "7 Nov", "8 Nov",
        "9 Nov", "10 Nov", "11 Nov", "12 Nov", "13 Nov", "14 Nov", "15 Nov",
        "16 Nov", "17 Nov", "18 Nov", "19 Nov", "20 Nov", "21 Nov", "22 Nov",
        "23 Nov", "24 Nov", "25 Nov", "26 Nov", "27 Nov", "28 Nov", "29 Nov",
        "30 Nov",
      ],
    },
    yaxis: [
      {
        title: {
          text: "Daily Production (Ktonnes)",
        },
        labels: {
          formatter: (value) => `${value} Kt`, // Example formatting
        },
      },
      {
        opposite: true,
        title: {
          text: "Cumulative Production (Mtonnes)",
        },
        labels: {
          formatter: (value) => `${value} Mt`, // Example formatting
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
}

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
  }
};
</script>

<style>
.chart-container {
  position: relative;
  height: 500px;
  width: 100%;
}
</style>
