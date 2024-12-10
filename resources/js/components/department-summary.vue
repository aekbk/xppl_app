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
                <div
                    class="row text-center"
                    style="
                        border-radius: 5px;
                        padding: 8px;
                        background: #eceef3;
                        margin: 8px 0px 8px 8px;
                    "
                >
                    <div class="col">
                        <div class="">MTD Plan</div>
                        <div class="fs-3">
                            {{ mtdPlan }} &nbsp;<span class="fs-6">Mt</span>
                        </div>
                    </div>
                    <div class="col">
                        <div class="">Actual</div>
                        <div class="fs-3">
                            {{ mtdActual }} &nbsp;<span class="fs-6">Mt</span>
                        </div>
                    </div>
                    <div class="col">
                        <div>% Plan Diff.</div>
                        <div class="fs-4">
                            <span class="badge fs-4" :class="badgeClass">{{
                                planDiff
                            }}</span>
                        </div>
                    </div>
                </div>
                <kpi-chart
                    :actualData="mainMetricActualData"
                    :planData="mainMetricPlanData"
                    :categories="mainMetricCategories"
                    :leftYAxisTitle="mainMetricLeftYAxisTitle"
                    :rightYAxisTitle="mainMetricRightYAxisTitle"
                ></kpi-chart>
            </div>

            <div>
                <h6 class="fs-5">
                    {{ secondaryMetricTitle }}&nbsp;{{
                        secondaryMetricSubtitle
                    }}
                </h6>
                <div
                    class="row text-center"
                    style="
                        border-radius: 5px;
                        padding: 8px;
                        background: #eceef3;
                        margin: 8px 0px 8px 8px;
                    "
                >
                    <div class="col">
                        <div class="">{{ secondarySummaryHeader }}</div>
                        <div class="fs-4">
                            {{ avgStat }} &nbsp;<span
                                v-if="secondarySummaryUnit"
                                class="fs-6"
                                >{{ secondarySummaryUnit }}</span
                            >
                        </div>
                    </div>
                </div>
                <month-line
                    :data="secondaryMetricStats"
                    :categories="secondaryMetricCategories"
                    :yAxisTitle="secondaryMetricYAxisTitle"
                    :units="secondaryMetricUnit"
                    :labelFormat="secondMetricLabelFormat"
                    :yAxisFormat="secondMedtricYAxisFormat"
                ></month-line>
            </div>
        </div>
    </div>
</template>

<script>
import { format } from "numerable";
import { addAll, getKpiCategory } from "../utils/chart";
import { average, roundToDecimalPlace } from "../utils/number";
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
        mainMetricActualData: {
            type: Array,
            required: false,
            default: [],
        },
        mainMetricPlanData: {
            type: Array,
            required: false,
            default: [],
        },
        mainMetricCategories: {
            type: Array,
            required: false,
            default: [],
        },
        mainMetricLeftYAxisTitle: {
            type: String,
            required: false,
            default: "",
        },
        mainMetricRightYAxisTitle: {
            type: String,
            required: false,
            default: "",
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
        secondaryMetricStats: {
            type: Array,
            required: false,
            default: [],
        },
        secondaryMetricCategories: {
            type: Array,
            required: false,
            default: [],
        },
        secondaryMetricYAxisTitle: {
            type: String,
            required: false,
            default: "",
        },
        secondaryMetricUnit: {
            type: String,
            required: false,
            default: "",
        },
        secondMetricLabelFormat: {
            type: String,
            required: false,
            default: "0,0.0a",
        },
        secondMedtricYAxisFormat: {
            type: String,
            required: false,
            default: "0,0.0a",
        },
        secondarySummaryHeader: {
            type: String,
            required: false,
            default: "",
        },
        secondarySummaryUnit: {
            type: String,
            required: false,
            default: "",
        },
        averageFormat: {
            type: String,
            required: false,
            default: "0,0.00",
        },
    },
    computed: {
        mtdPlan() {
            return roundToDecimalPlace(
                addAll(this.mainMetricPlanData) / 1000,
                2
            );
        },
        mtdActual() {
            return roundToDecimalPlace(
                addAll(this.mainMetricActualData) / 1000,
                2
            );
        },
        planDiff() {
            return roundToDecimalPlace(
                (this.mtdActual / this.mtdPlan) * 100,
                2
            );
        },
        planDiffCategory() {
            return getKpiCategory(this.planDiff, 10);
        },
        badgeClass() {
            return {
                "text-bg-success": this.planDiffCategory === "success",
                "text-bg-warning": this.planDiffCategory === "warning",
                "text-bg-danger": this.planDiffCategory === "danger",
            };
        },

        // TODO: Implement this outside of department-summary to just receive the value
        avgStat() {
            // Get the average value of stringRatio that is not null
            return format(
                average(
                    this.secondaryMetricStats.filter((item) => item !== null)
                ),
                this.averageFormat
            );
        },
    },
};
</script>
