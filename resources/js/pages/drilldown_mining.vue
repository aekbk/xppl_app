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
                                        MINING
                                        <span class="ms-3 text-muted fs-6"
                                            >Last updated on </span
                                        ><span class="text-danger fs-6"
                                            >November 13, 2024, at
                                            15:32:06</span
                                        >
                                    </p>
                                </div>
                                <div>
                                    <ul class="nav nav-tabs">
										<li class="nav-item">
											<a
												class="nav-link"
												:class="{ active: activeTab === 'coalProduction' }"
												href="#"
												@click.prevent="activeTab = 'coalProduction'"
											>
												Coal Production
											</a>
										</li>
										<li class="nav-item">
											<a
												class="nav-link"
												:class="{ active: activeTab === 'wasteProduction' }"
												href="#"
												@click.prevent="activeTab = 'wasteProduction'"
											>
												Waste Production
											</a>
										</li>
										<li class="nav-item">
											<a
												class="nav-link"
												:class="{ active: activeTab === 'stripRatio' }"
												href="#"
												@click.prevent="activeTab = 'stripRatio'"
											>
												Strip Ratio
											</a>
										</li>
										<li class="nav-item">
											<a class="nav-link disabled" href="#">Broken Stock</a>
										</li>
										<li class="nav-item">
											<a class="nav-link disabled" href="#">Water Volume</a>
										</li>
									</ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Content : Coal Production-->
                <div class="row justify-content-evenly mb-4" v-if="activeTab === 'coalProduction'">
                    <card title="Total Mining Coal Production By Contractor">
                        <to-date-table
                            :data="miningData"
                            :sliceAttribute="'contractor'"
                            :attributeHeader="'Con.'"
                            :actualAttrName="'coal_plan_kt'"
                            :planAttrName="'coal_plan_kt'"
                        ></to-date-table>

                        <kpi-chart
                            :actualData="coalProductionActualData"
                            :planData="coalProductionPlanData"
                            :categories="coalProductionCategories"
                        ></kpi-chart>

                        <month-line
                            :data="tonesPerHourData"
                            :categories="coalProductionCategories"
                        ></month-line>
                    </card>

                    <card title="Total Mining Coal Production By Grade">
                        <to-date-table
                            :data="miningData"
                            :sliceAttribute="'category'"
                            :attributeHeader="'Grade'"
                            :actualAttrName="'coal_plan_kt'"
                            :planAttrName="'coal_plan_kt'"
                        ></to-date-table>

                        <kpi-chart
                            :actualData="coalProductionActualData"
                            :planData="coalProductionPlanData"
                            :categories="coalProductionCategories"
                        ></kpi-chart>

                        <month-line
                            :data="tonesPerHourData"
                            :categories="coalProductionCategories"
                        ></month-line>
                    </card>

                    <card title="Total Mining Coal Production By Contractor & Grade">
                        <to-date-table
                            :data="miningData"
                            :sliceAttribute="'contractor'"
                            :attributeHeader="'Con.'"
                            :actualAttrName="'coal_plan_kt'"
                            :planAttrName="'coal_plan_kt'"
                        ></to-date-table>

                        <kpi-chart
                            :actualData="coalProductionActualData"
                            :planData="coalProductionPlanData"
                            :categories="coalProductionCategories"
                        ></kpi-chart>

                        <month-line
                            :data="tonesPerHourData"
                            :categories="coalProductionCategories"
                        ></month-line>
                    </card>
                </div>

        		<!-- Content : Waste Production-->
             	<div class="row justify-content-evenly mb-4" v-if="activeTab === 'wasteProduction'">
                    <card title="Total Mining Coal Production By Contractor">
                        <to-date-table
                            :data="wasteData"
                            :sliceAttribute="'contractor'"
                            :attributeHeader="'Con.'"
                            :actualAttrName="'waste_actual_kbcm'"
                            :planAttrName="'waste_plan_kbcm'"
                        ></to-date-table>

                        <kpi-chart
                            :actualData="wasteProductionActualData"
                            :planData="wasteProductionPlanData"
                            :categories="wasteProductionCategories"
                        ></kpi-chart>

                        <month-line
                            :data="wasteBCMPerHourData"
                            :categories="wasteProductionCategories"
                        ></month-line>
                    </card>
                </div>

        		<!-- Content :  Strip Ratio-->
             	<div class="row justify-content-evenly mb-4" v-if="activeTab === 'stripRatio'">
                    <card title="Strip Ratio">
                        <month-line
                            :data="stripRatioData"
                            :categories="wasteProductionCategories"
                        ></month-line>
                    </card>
                </div>

            </div>
        </div>
    </div>
</template>

<script>
import SummaryStatistic from "../components/summary-statistic.vue";
import DepartmentSummary from "../components/department-summary.vue";
import MonthLine from "../components/month-line.vue";
import Card from "../components/card.vue";
import { useAuthStore } from "../stores/auth";
import { useStore } from "../stores/store";
import ToDateTable from "../components/to-date-table.vue";
import KpiChart from "../components/kpi-chart.vue";
import { convertToDailyKpiData, convertToDailyKpiDataByAttr} from "../utils/chart";
import { formatDateToDayMonth } from "../utils/date";
import { subset } from "../utils/data";
import { roundToDecimalPlace } from "../utils/number";

export default {
    name: "MinintDrilldown",
    setup() {
        const authStore = useAuthStore();
        const store = useStore();
        return { authStore, store };
    },
    components: {
        SummaryStatistic,
        DepartmentSummary,
        ToDateTable,
        KpiChart,
        Card,
        MonthLine,
    },

    data() {
        return {
			activeTab: "coalProduction", // Default active tab

            // Mining data
            miningData: [],

            coalProductionActualData: [],
            coalProductionPlanData: [],
            coalProductionCategories: [],

            // Waste Production
            wasteData: [],

            wasteProductionActualData: [],
            wasteProductionPlanData: [],
            wasteProductionCategories: [],

            // Strip Ratio
            stripRatioProductionData: [],
        };
    },

    computed: {
        tonesPerHourData() {
            return this.coalProductionActualData.map((i) => roundToDecimalPlace(i / 24));
        },
        wasteBCMPerHourData() {
            return this.wasteProductionActualData.map((i) => roundToDecimalPlace(i / 24));
        },
        stripRatioData() {
            return this.stripRatioProductionData;
        },
    },

    methods: {
        async fetchMiningData() {
            const response = await axios.get(
                "/api/control-tower/mining_detail?start_date=2024-01-01&end_date=2024-12-01",
                {
                    headers: {
                        Authorization: "Bearer " + this.authStore.getToken,
                    },
                }
            );
            this.miningData = response.data;

            const novemberData = subset(
                response.data,
                "2024-11-01",
                "2024-11-30"
            );
            const kpiData = convertToDailyKpiData(novemberData);
            this.coalProductionActualData = kpiData.map((i) => i.actual);
            this.coalProductionPlanData = kpiData.map((i) => i.plan);
            this.coalProductionCategories = kpiData.map((i) =>
                formatDateToDayMonth(i.date)
            );
        },
        async fetchWasteData() {
            const response = await axios.get(
                "/api/control-tower/waste_detail?start_date=2024-01-01&end_date=2024-12-01",
                {
                    headers: {
                        Authorization: "Bearer " + this.authStore.getToken,
                    },
                }
            );
            this.wasteData = response.data;

            const novemberData = subset(
                response.data,
                "2024-11-01",
                "2024-11-30"
            );
            const kpiData = convertToDailyKpiDataByAttr(novemberData, 'waste_plan_kbcm', 'waste_actual_kbcm');
            const wasteActualData = kpiData.map((i) => i.actual);
            const wastePlanData = kpiData.map((i) => i.plan);
            const wasteCategories = kpiData.map((i) =>
                formatDateToDayMonth(i.date)
            );

            this.wasteProductionActualData = wasteActualData;
            this.wasteProductionPlanData = wastePlanData;
            this.wasteProductionCategories = wasteCategories;

            this.stripRatioProductionData = wasteActualData.map((item, index) => {
                const result = item / this.coalProductionActualData[index];
                if (isNaN(result)) {
                    return null;
                }
                return roundToDecimalPlace(result, 2);
            });


        },

        async fetchData() {
            this.fetchMiningData();
            this.fetchWasteData();
        },
    },
    created() {
        this.fetchData();
    },
};
</script>
