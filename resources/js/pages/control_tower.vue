<template>
    <div>
        <div class="row">
            <div class="col-lg-12">
                <div
                    class="card rounded-0 mx-n4 mt-n4 border-top sticky-top"
                    style="top: 70px"
                >
                    <div class="px-4">
                        <div class="row">
                            <div class="col-xxl-6 align-self-center">
                                <div class="">
                                    <p class="fs-15 mt-3">
                                        OVERALL
                                        <span class="ms-3 text-muted fs-6"
                                            >Viewing data up to
                                            <div
                                                class="col-sm-auto d-inline-block"
                                            >
                                                <div class="input-group ms-2">
                                                    <input
                                                        type="text"
                                                        id="select-date"
                                                        class="form-control flatpickr-input flatpickr-single rounded-start-2 cursor-pointer"
                                                        placeholder="Select date"
                                                        v-model="selectDate"
                                                        @input="onSelectDate()"
                                                    />
                                                    <button
                                                        type="button"
                                                        class="btn btn-soft-primary disabled"
                                                        style="
                                                            border-color: var(
                                                                --vz-input-border-custom
                                                            );
                                                        "
                                                        @click="refresh()"
                                                    >
                                                        <i
                                                            class="ri-calendar-line align-middle"
                                                        ></i>
                                                    </button>
                                                </div>
                                            </div>
                                        </span>
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row justify-content-evenly mb-4">
                    <div class="col-lg-6">
                        <summary-statistic
                            :title="statistic1.title"
                            :subtitle="statistic1.subtitle"
                            :stats="statistic1.statisticsContent"
                        ></summary-statistic>
                    </div>
                    <div class="col-lg-6">
                        <summary-statistic
                            :title="statistic2.title"
                            :stats="statistic2.statisticsContent"
                        ></summary-statistic>
                    </div>
                </div>
                <div class="row justify-content-evenly mb-4">
                    <div class="col-lg-4">
                        <div
                            v-if="!(isLoadingMiningData || isLoadingWasteData)"
                        >
                            <department-summary
                                :title="miningSummary.title"
                                :mainMetricTitle="miningSummary.mainMetricTitle"
                                :mainMetricSubtitle="
                                    miningSummary.mainMetricSubtitle
                                "
                                :mainMetricActualData="
                                    miningSummary.mainMetricActualData
                                "
                                :mainMetricCategories="
                                    miningSummary.mainMetricCategories
                                "
                                :mainMetricPlanData="
                                    miningSummary.mainMetricPlanData
                                "
                                :mainMetricLeftYAxisTitle="
                                    miningSummary.mainMetricLeftYAxisTitle
                                "
                                :mainMetricRightYAxisTitle="
                                    miningSummary.mainMetricRightYAxisTitle
                                "
                                :secondaryMetricTitle="
                                    miningSummary.secondaryMetricTitle
                                "
                                :secondaryMetricSubtitle="
                                    miningSummary.secondaryMetricSubtitle
                                "
                                :secondaryMetricStats="
                                    miningSummary.secondaryMetricStats
                                "
                                :secondaryMetricCategories="
                                    miningSummary.secondaryMetricCategories
                                "
                                :secondarySummaryHeader="
                                    miningSummary.secondarySummaryHeader
                                "
                                :secondaryMetricYAxisTitle="
                                    miningSummary.secondaryMetricYAxisTitle
                                "
                                :secondaryMetricUnit="
                                    miningSummary.secondaryMetricUnit
                                "
                            ></department-summary>
                        </div>
                        <div
                            v-if="isLoadingMiningData || isLoadingWasteData"
                            class="row justify-content-evenly mb-4"
                        >
                            <div
                                class="spinner-border text-primary"
                                role="status"
                            >
                                <span class="sr-only">Loading...</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div v-if="!isLoadingProcessingData">
                            <department-summary
                                :title="processingSummary.title"
                                :mainMetricTitle="
                                    processingSummary.mainMetricTitle
                                "
                                :mainMetricSubtitle="
                                    processingSummary.mainMetricSubtitle
                                "
                                :mainMetricActualData="
                                    processingSummary.mainMetricActualData
                                "
                                :mainMetricCategories="
                                    processingSummary.mainMetricCategories
                                "
                                :mainMetricPlanData="
                                    processingSummary.mainMetricPlanData
                                "
                                :mainMetricLeftYAxisTitle="
                                    processingSummary.mainMetricLeftYAxisTitle
                                "
                                :mainMetricRightYAxisTitle="
                                    processingSummary.mainMetricRightYAxisTitle
                                "
                                :secondaryMetricTitle="
                                    processingSummary.secondaryMetricTitle
                                "
                                :secondaryMetricSubtitle="
                                    processingSummary.secondaryMetricSubtitle
                                "
                                :secondaryMetricStats="
                                    processingSummary.secondaryMetricStats
                                "
                                :secondaryMetricCategories="
                                    processingSummary.secondaryMetricCategories
                                "
                                :secondaryMetricYAxisTitle="
                                    processingSummary.secondaryMetricYAxisTitle
                                "
                                :secondaryMetricUnit="
                                    processingSummary.secondaryMetricUnit
                                "
                                :secondarySummaryHeader="
                                    processingSummary.secondarySummaryHeader
                                "
                            ></department-summary>
                        </div>
                        <div
                            v-if="isLoadingProcessingData"
                            class="row justify-content-evenly mb-4"
                        >
                            <div
                                class="spinner-border text-primary"
                                role="status"
                            >
                                <span class="sr-only">Loading...</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <department-summary
                            :title="salesLogisticsSummary.title"
                            :mainMetricTitle="
                                salesLogisticsSummary.mainMetricTitle
                            "
                            :mainMetricSubtitle="
                                salesLogisticsSummary.mainMetricSubtitle
                            "
                            :secondaryMetricTitle="
                                salesLogisticsSummary.secondaryMetricTitle
                            "
                            :secondaryMetricSubtitle="
                                salesLogisticsSummary.secondaryMetricSubtitle
                            "
                        ></department-summary>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import flatpickr from "flatpickr";
import DepartmentSummary from "../components/department-summary.vue";
import SummaryStatistic from "../components/summary-statistic.vue";
import { useAuthStore } from "../stores/auth";
import { useGlobalParamStore } from "../stores/globalParam";
import { useStore } from "../stores/store";
import { convertToDailyKpiData, convertToKpiDataByAttr } from "../utils/chart";
import {
    formatDateToDayMonth,
    getKeyDateFromSelectedDate,
} from "../utils/date";
import { roundToDecimalPlace } from "../utils/number";

const DEFAULT_DATE = "2024-11-30";

export default {
    name: "ControlTower",

    setup() {
        const authStore = useAuthStore();
        const store = useStore();
        const globalParamStore = useGlobalParamStore();
        return { authStore, store, globalParamStore };
    },

    components: {
        SummaryStatistic,
        DepartmentSummary,
    },

    data() {
        return {
            statistic1: {
                title: "Health, Safety & Environment",
                section1Title: "Total Coal Mined",
                section1Subtitle: "(MTD)",
                statisticsContent: [
                    {
                        label: "Lost Time Injury (LTI)",
                        value: 7,
                        icon: "assets/images/icons/icon_stopwatch.png",
                    },
                    {
                        label: "First Aid Injury (FAI)",
                        value: 5,
                        icon: "assets/images/icons/icon_briefcase.png",
                    },
                    {
                        label: "Medical Treatment Injury (MTI)",
                        value: 23,
                        icon: "assets/images/icons/icon_hospital.png",
                    },
                    {
                        label: "Restricted Work Injury (RWI)",
                        value: 12,
                        icon: "assets/images/icons/icon_vest.png",
                    },
                ],
            },
            statistic2: {
                title: "Inventory",
                statisticsContent: [
                    {
                        label: "Raw Coal From Mine",
                        value: 32.4,
                        icon: "assets/images/icons/icon_coal_pile.png",
                        unit: "Mt",
                    },
                    {
                        label: "Processed Coal On-Site",
                        value: 20.1,
                        icon: "assets/images/icons/icon_coal_pile.png",
                        unit: "Mt",
                    },
                    {
                        label: "Saleable Coal In-transit",
                        value: 10.8,
                        icon: "assets/images/icons/icon_truck.png",
                        unit: "Mt",
                    },
                    {
                        label: "Saleable Coal Off-site",
                        value: 8.3,
                        icon: "assets/images/icons/icon_coal_pile.png",
                        unit: "Mt",
                    },
                ],
            },
            salesLogisticsSummary: {
                title: "Sales & Logistics",
                mainMetricTitle: "Total Coal Sales Volume",
                mainMetricSubtitle: "(MTD)",
                mainMetricActualData: [],
                mainMetricPlanData: [],
                mainMetricCumPlanData: [],
                mainMetricCumActualData: [],
                secondaryMetricTitle: "Sales over Production Ratio",
                secondaryMetricSubtitle: "(MTD)",
                secondaryMetricStats: [],
            },
            miningData: [],
            isLoadingMiningData: false,
            miningDataLoaded: false,

            processingData: [],
            isLoadingProcessingData: false,
            processingDataLoaded: false,

            wasteData: [],
            isLoadingWasteData: false,
            wasteDataLoaded: false,
        };
    },

    mounted() {
        const self = this;
        flatpickr(".flatpickr-single", {
            altInput: true,
            altFormat: "d-m-Y",
            defaultDate: this.globalParamStore.getSelectedDate || DEFAULT_DATE,
            disable: [
                function (date) {
                    // return true to disable
                    return (
                        date > self.globalParamStore.getLastAvailableDateData
                    );
                },
            ],
        });
    },

    watch: {
        "globalParamStore.getSelectedDate": "fetchData",
    },

    methods: {
        onSelectDate() {
            this.globalParamStore.setSelectedDate(new Date(this.selectDate));
        },
        async fetchMiningData() {
            this.isLoadingMiningData = true;

            const keyDates = getKeyDateFromSelectedDate(
                this.globalParamStore.selectedDate
            );
            const response = await axios.get(
                `/api/control-tower/mining_detail?start_date=${keyDates.beginningOfMonth}&end_date=${keyDates.today}`,
                {
                    headers: {
                        Authorization: "Bearer " + this.authStore.getToken,
                    },
                }
            );

            this.miningData = response.data;
            this.miningDataLoaded = true;
            this.isLoadingMiningData = false;
        },
        async fetchProcessingData() {
            this.isLoadingProcessingData = true;
            const keyDates = getKeyDateFromSelectedDate(
                this.globalParamStore.selectedDate
            );
            const response = await axios.get(
                `/api/control-tower/processing_detail?start_date=${keyDates.beginningOfMonth}&end_date=${keyDates.today}`,
                {
                    headers: {
                        Authorization: "Bearer " + this.authStore.getToken,
                    },
                }
            );

            this.processingData = response.data;
            this.isLoadingProcessingData = false;
        },
        async fetchWasteData() {
            this.isLoadingWasteData = true;
            const keyDates = getKeyDateFromSelectedDate(
                this.globalParamStore.selectedDate
            );
            const response = await axios.get(
                `/api/control-tower/waste_detail?start_date=${keyDates.beginningOfMonth}&end_date=${keyDates.today}`,
                {
                    headers: {
                        Authorization: "Bearer " + this.authStore.getToken,
                    },
                }
            );
            this.isLoadingWasteData = false;
            this.wasteData = response.data;
            this.wasteDataLoaded = true;
        },
        async fetchData() {
            this.fetchMiningData();
            this.fetchProcessingData();
            this.fetchWasteData();
        },
    },
    created() {
        this.fetchData();
    },
    computed: {
        miningSummary() {
            const mainKpiData = convertToDailyKpiData(this.miningData);
            const miningActualData = mainKpiData.map((i) => i.actual);
            const miningPlanData = mainKpiData.map((i) => i.plan);
            const miningCategories = mainKpiData.map((i) =>
                formatDateToDayMonth(i.date)
            );

            const secondaryKpiData = convertToKpiDataByAttr(
                this.wasteData,
                "waste_plan_kbcm",
                "waste_actual_kbcm"
            ).daily;
            const wasteActualData = secondaryKpiData.map((i) => i.actual);
            const stripRatio = wasteActualData.map((item, index) => {
                const result = item / miningActualData[index];
                if (isNaN(result)) {
                    return null;
                }
                return roundToDecimalPlace(result, 2);
            });

            return {
                title: "Mining",
                mainMetricTitle: "Total Coal Mined",
                mainMetricSubtitle: "(MTD)",
                mainMetricActualData: miningActualData,
                mainMetricPlanData: miningPlanData,
                mainMetricCategories: miningCategories,
                mainMetricLeftYAxisTitle: "Weight (Kt)",
                mainMetricRightYAxisTitle: "Cum. Weight (Kt)",
                secondaryMetricTitle: "Strip Ratio",
                secondaryMetricSubtitle: "(MTD)",
                secondaryMetricStats: stripRatio,
                secondaryMetricCategories: miningCategories,
                secondarySummaryHeader: "MTD Avg",
            };
        },
        processingSummary() {
            // plant processing output - top part
            const processingOutputData = convertToKpiDataByAttr(
                this.processingData,
                "output_target",
                "output_actual"
            ).daily;
            const processingOutputActualData = processingOutputData.map(
                (i) => i.actual
            );
            const processingOutputPlanData = processingOutputData.map(
                (i) => i.plan
            );
            const processingCategories = processingOutputData.map((i) =>
                formatDateToDayMonth(i.date)
            );

            // this.processingSummary.mainMetricActualData =
            // this.processingSummary.mainMetricPlanData = ;
            // this.processingSummary.mainMetricCategories = ;

            // plant processing input - bottom part
            const processingInputData = convertToKpiDataByAttr(
                this.processingData,
                "input_target",
                "input_actual"
            ).daily;
            const processingInputActualData = processingInputData.map(
                (i) => i.actual
            );
            const yieldRatio = processingInputActualData.map((item, index) => {
                const result = item / processingOutputActualData[index];
                if (isNaN(result)) {
                    return null;
                }
                return roundToDecimalPlace(result, 2);
            });

            // this.processingSummary.secondaryMetricStats = yieldRatio;
            // this.processingSummary.secondaryMetricCategories = processingCategories;

            return {
                title: "Processing",
                mainMetricTitle: "Total Processing Throughput",
                mainMetricSubtitle: "(MTD)",
                mainMetricLeftYAxisTitle: "Weight (Kt)",
                mainMetricRightYAxisTitle: "Cum. Weight (Kt)",
                mainMetricActualData: processingOutputActualData,
                mainMetricPlanData: processingOutputData.map((i) => i.plan),
                mainMetricCategories: processingOutputData.map((i) =>
                    formatDateToDayMonth(i.date)
                ),
                secondaryMetricTitle: "Yield",
                secondaryMetricSubtitle: "(MTD)",
                secondaryMetricStats: yieldRatio,
                secondaryMetricCategories: processingCategories,
                secondaryMetricYAxisTitle: "Yield (%)",
                secondaryMetricUnit: "%",
                secondarySummaryHeader: "MTD Avg",
            };
        },
    },
};
</script>
