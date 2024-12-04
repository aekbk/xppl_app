<template>
    <div>
        <ag-grid-vue
            style="height: 300px"
            class="ag-theme-quartz"
            :columnDefs="columnDefs"
            :rowHeight="30"
            :headerHeight="31.99"
            :suppressMenuHide="false"
            :suppressCellFocus="true"
            :rowData="toDateData"
            animateRows="false"
            :defaultColDef="defaultColDef"
        ></ag-grid-vue>
    </div>
</template>

<script lang="ts">
import { AgGridVue } from "ag-grid-vue3";
import groupBy from "lodash/groupBy";
import { transformToToDateTableData } from "../utils/chart";

export default {
    name: "ToDateTable",
    components: { AgGridVue },
    props: {
        data: {
            type: Array,
            required: false,
            default: "",
        },
        sliceAttribute: {
            type: String,
            required: true,
        },
        planAttrName: {
            type: String,
            required: true,
        },
        actualAttrName: {
            type: String,
            required: true,
        },
        attributeHeader: {
            type: String,
            required: true,
        },
    },
    data() {
        return {
            columnDefs: [
                {
                    headerName: this.attributeHeader,
                    field: 'attr',
                    sortable: true,
                    filter: true,
                },
                {
                    headerName: "Today (Kt)",
                    children: [
                        {
                            headerName: "Plan",
                            field: "todayPlan",
                            sortable: true,
                        },
                        {
                            headerName: "Actual",
                            field: "todayActual",
                            sortable: true,
                        },
                        {
                            headerName: "% Plan Diff",
                            field: "todayPlanDiff",
                            sortable: true,
                            cellClass: (params) => {
                                if (params.value > 110) {
                                    return "bg-warning"; // Apply this class if value > 100
                                } else if (params.value < 90) {
                                    return "bg-danger"; // Apply this class if value < 100
                                }
                                return 'bg-success'; // No class for other cases
                            },
                            valueFormatter: (params) => {
                                return `${params.value.toFixed(2)}%`;
                            },
                        },
                    ],
                },
                {
                    headerName: "MTD (Mt)",
                    children: [
                        {
                            headerName: "MTD Plan",
                            field: "mtdPlan",
                            sortable: true,
                        },
                        {
                            headerName: "Actual",
                            field: "mtdActual",
                            sortable: true,
                        },
                        {
                            headerName: "% Plan Diff",
                            field: "mtdPlanDiff",
                            sortable: true,
                            cellClass: (params) => {
                                if (params.value > 110) {
                                    return "bg-warning"; // Apply this class if value > 100
                                } else if (params.value < 90) {
                                    return "bg-danger"; // Apply this class if value < 100
                                }
                                return 'bg-success'; // No class for other cases
                            },
                            valueFormatter: (params) => {
                                return `${params.value.toFixed(2)}%`;
                            },
                        },
                        {
                            headerName: "Month Plan",
                            field: "mthPlan",
                            sortable: true,
                        },
                    ],
                },
                {
                    headerName: "YTD (Mt)",
                    children: [
                        {
                            headerName: "YTD Plan",
                            field: "ytdPlan",
                            sortable: true,
                        },
                        {
                            headerName: "Actual",
                            field: "ytdActual",
                            sortable: true,
                        },
                        {
                            headerName: "% Plan Diff",
                            field: "ytdPlanDiff",
                            sortable: true,
                            cellClass: (params) => {
                                if (params.value > 110) {
                                    return "bg-warning"; // Apply this class if value > 100
                                } else if (params.value < 90) {
                                    return "bg-danger"; // Apply this class if value < 100
                                }
                                return 'bg-success'; // No class for other cases
                            },
                            valueFormatter: (params) => {
                                return `${params.value.toFixed(2)}%`;
                            },
                        },
                        {
                            headerName: "Year Plan",
                            field: "yearPlan",
                            sortable: true,
                        },
                    ],
                },
            ],
            defaultColDef: {
                flex: 1,
                minWidth: 120,
            },
        };
    },
    computed: {
        byContractor() {
            const result = groupBy(this.data, this.sliceAttribute);
            return result;
        },
        toDateData() {
            const result = transformToToDateTableData(
                this.data,
                new Date("2024-11-20"),
                this.sliceAttribute,
                this.planAttrName,
                this.actualAttrName
            );
            return result;
        },
    },
};
</script>
