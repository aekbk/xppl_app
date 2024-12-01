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
                                            <a class="nav-link active" href="#"
                                                >Active</a
                                            >
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" href="#"
                                                >Link</a
                                            >
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" href="#"
                                                >Link</a
                                            >
                                        </li>
                                        <li class="nav-item">
                                            <a
                                                class="nav-link disabled"
                                                href="#"
                                                >Disabled</a
                                            >
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row justify-content-evenly mb-4">
                    <card title="Total Mining Coal Production By Contractor">
                        <to-date-table :data="miningData" :sliceAttribute="'contractor'" :attributeHeader="'Con.'"></to-date-table>
                    </card>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import SummaryStatistic from "../components/summary-statistic.vue";
import DepartmentSummary from "../components/department-summary.vue";
import Card from "../components/card.vue";
import { useAuthStore } from "../stores/auth";
import { useStore } from "../stores/store";
import ToDateTable from "../components/to-date-table.vue";

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
        Card,
    },

    data() {
        return {
            miningData: [],
        };
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
        },
        async fetchData() {
            this.fetchMiningData();
        },
    },
    created() {
        this.fetchData();
    },
};
</script>
