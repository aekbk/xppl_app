<template>
    <div>
        <div class="row">
            <div class="col-lg-12">
                <div
                    class="card rounded-0 mx-n4 mt-n4 border-top sticky-top z-3"
                    style="top: 70px"
                >
                    <div class="px-4">
                        <div class="row">
                            <div class="col-sm-6 align-self-center">
                                <div class="">
                                    <p class="fs-15 mt-3">
                                        MINING
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
                            <div
                                class="col-sm-6 align-self-center text-end text-muted"
                            >
                                Last updated on:
                                <span class="">{{
                                    globalParamStore.getLastUpdatedDate
                                }}</span>
                            </div>
                        </div>
                        <div>
                            <nav-tabs :navs="navs"> </nav-tabs>
                        </div>
                    </div>
                </div>
                <router-view />
            </div>
        </div>
    </div>
</template>

<script>
import { RouterView } from "vue-router";
import Card from "../components/card.vue";
import DepartmentSummary from "../components/department-summary.vue";
import KpiChart from "../components/kpi-chart.vue";
import MonthLine from "../components/month-line.vue";
import NavTabs from "../components/nav-tabs.vue";
import SummaryStatistic from "../components/summary-statistic.vue";
import ToDateTable from "../components/to-date-table.vue";
import { useAuthStore } from "../stores/auth";
import { useGlobalParamStore } from "../stores/globalParam";
import { useStore } from "../stores/store";

const DEFAULT_DATE = "2024-11-30";

export default {
    name: "MiningDrilldown",
    setup() {
        const authStore = useAuthStore();
        const store = useStore();
        const globalParamStore = useGlobalParamStore();
        return { authStore, store, globalParamStore };
    },
    components: {
        SummaryStatistic,
        DepartmentSummary,
        ToDateTable,
        KpiChart,
        Card,
        MonthLine,
        RouterView,
        NavTabs,
    },

    data() {
        return {
            // Strip Ratio
            stripRatioProductionData: [],

            navs: [
                {
                    label: "Coal Production",
                    to: "/drilldown-mining/coal-production",
                },
                {
                    label: "Waste Production",
                    to: "/drilldown-mining/waste-production",
                },
                { label: "Strip Ratio", to: "/drilldown-mining/strip-ratio" },
                // { label: "Broken Stock", to: "/drilldown-mining/broken-stock" },
                // { label: "Water Volume", to: "/drilldown-mining/water-volume" },
            ],
        };
    },

    methods: {
        onSelectDate() {
            this.globalParamStore.setSelectedDate(new Date(this.selectDate));
        },
    },
    created() {},
    mounted() {
        const self = this;
        flatpickr(".flatpickr-single", {
            altInput: true,
            altFormat: "d-m-Y",
            defaultDate: this.globalParamStore.getSelectedDate,
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
};
</script>
