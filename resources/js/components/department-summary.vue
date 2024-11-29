<template>
  <div class="card">
    <div class="card-header">
      <h5 class="mb-0 d-inline-block me-3">{{ title }}</h5>
    </div>
    <div class="card-body">
      <div>
        <h6 class="fs-5">
          {{ mainMetricTitle }}&nbsp;{{ mainMetricSubtitle }}
        </h6>
        <div class="row text-center" style="
                        border-radius: 5px;
                        padding: 8px;
                        background: #eceef3;
                        margin: 8px 0px 8px 8px;
                    ">
          <div class="col">
            <div class="">MTD Plan</div>
            <div class="fs-3">
              7.36 &nbsp;<span class="fs-6">Mt</span>
            </div>
          </div>
          <div class="col">
            <div class="">Actual</div>
            <div class="fs-3">
              7.36 &nbsp;<span class="fs-6">Mt</span>
            </div>
          </div>
          <div class="col">
            <div>% Plan Diff.</div>
            <div class="fs-4">
              <span class="badge text-bg-success fs-4">36%</span>
            </div>
          </div>
        </div>
        <kpi-chart
          :actualData="mainMetricActual"
          :planData="mainMetricPlan"
        ></kpi-chart>
      </div>

      <div>
        <h6 class="fs-5">{{ secondaryMetricTitle }}&nbsp;{{ secondaryMetricSubtitle }}</h6>
        <div class="row text-center" style="
                        border-radius: 5px;
                        padding: 8px;
                        background: #eceef3;
                        margin: 8px 0px 8px 8px;
                    ">
          <div class="col">
            <div class="">MTD Plan</div>
            <div class="fs-4">
              7.36 &nbsp;<span class="fs-6">Mt</span>
            </div>
          </div>
        </div>
        <month-line></month-line>
      </div>
    </div>
  </div>
</template>

<script>
import KpiChart from "./kpi-chart.vue";
import MonthLine from "./month-line.vue";

export default {
  name: "DepartmentSummary",

  components: {
    KpiChart,
    MonthLine,
  },
  props: {
    title: {
      type: String,
      required: true,
    },
    mainMetricTitle: {
      type: String,
      required: true,
    },
    mainMetricSubtitle: {
      type: String,
      required: false,
      default: "",
    },
    mainMetricActual: {
      type: Array,
      required: false,
    },
    mainMetricPlan: {
      type: Array,
      required: false,
    },
    secondaryMetricTitle: {
      type: String,
      required: true,
    },
    secondaryMetricSubtitle: {
      type: String,
      required: false,
      default: "",
    },
  },
};
</script>

<style scoped>
.icon {
  margin-bottom: 10px;
}
</style>
