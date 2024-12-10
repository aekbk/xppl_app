<template>
    <div class="custom-grid">
        <ag-grid-vue
            style="height: 500px"
            class="ag-theme-quartz"
            :columnDefs="columnDefs"
            :suppressMenuHide="false"
            :suppressCellFocus="true"
            :rowData="toDateData"
            animateRows="false"
            :defaultColDef="defaultColDef"
            :suppressAggFuncInHeader="true"
            :grandTotalRow="'bottom'"
        ></ag-grid-vue>
    </div>
</template>

<script lang="ts">
import { AgGridVue } from "ag-grid-vue3";
import { transformToToDateTableData } from "../utils/chart";
import { format } from "numerable";

const NUMBER_FORMAT = "0,0.00"
const PERCENT_FORMAT = "0.00%"

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
        toDate: {
            type: String,
            false: true,
        },
        dayGroupHeader: {
            type: String,
            required: false,
            default: null,
        },
        mtdGroupHeader: {
            type: String,
            required: false,
            default: "MTD (Kt)",
        },
        ytdGroupHeader: {
            type: String,
            required: false,
            default: "YTD (Kt)",
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
                    headerName: this.dayGroupHeader || this.toDate + " (Kt)",
                    children: [
                        {
                            headerName: "Plan",
                            field: "todayPlan",
                            sortable: true,
                            aggFunc: 'sum',
                            cellClass: 'text-end',
                            valueFormatter: (params) => {
                                return format((params.value || 0), NUMBER_FORMAT);
                            },
                        },
                        {
                            headerName: "Actual",
                            field: "todayActual",
                            sortable: true,
                            aggFunc: 'sum',
                            cellClass: 'text-end',
                            valueFormatter: (params) => {
                                return format((params.value || 0), NUMBER_FORMAT);
                            },
                        },
                        {
                            headerName: "% Plan Diff",
                            field: "todayPlanDiff",
                            sortable: true,
                            aggFunc: (params) => {
                                const leafNodes = params.rowNode.allLeafChildren;

                                // Calculate total actual availability
                                const totalActual = leafNodes.reduce((acc, childNode) => {
                                    const childData = childNode.data;
                                    return acc + (childData.todayActual || 0); // Safely add values
                                }, 0);

                                // Calculate total target availability
                                const totalPlan = leafNodes.reduce((acc, childNode) => {
                                    const childData = childNode.data;
                                    return acc + (childData.todayPlan || 0); // Safely add values
                                }, 0);


                                return totalPlan ? (totalActual / totalPlan) : 0;
                            },
                            cellClass: (params) => {
                                if (params.value > 1.10) {
                                    return "bg-warning text-end"; // Apply this class if value > 100
                                } else if (params.value < .90) {
                                    return "bg-danger text-end"; // Apply this class if value < 100
                                }
                                return 'bg-success text-end'; // No class for other cases
                            },
                            valueFormatter: (params) => {
                                return format(params.value, PERCENT_FORMAT);
                            },
                        },
                    ],
                },
                {
                    headerName: this.mtdGroupHeader,
                    children: [
                        {
                            headerName: "MTD Plan",
                            field: "mtdPlan",
                            sortable: true,
                            aggFunc: 'sum',
                            cellClass: 'text-end',
                            valueFormatter: (params) => {
                                return format((params.value || 0), NUMBER_FORMAT);
                            },
                        },
                        {
                            headerName: "Actual",
                            field: "mtdActual",
                            sortable: true,
                            aggFunc: 'sum',
                            cellClass: 'text-end',
                            valueFormatter: (params) => {
                                return format((params.value || 0), NUMBER_FORMAT);
                            },
                        },
                        {
                            headerName: "% Plan Diff",
                            field: "mtdPlanDiff",
                            sortable: true,
                            aggFunc: (params) => {
                                const leafNodes = params.rowNode.allLeafChildren;
                                console.log('params', params);

                                // Calculate total actual availability
                                const totalActual = leafNodes.reduce((acc, childNode) => {
                                    const childData = childNode.data;
                                    return acc + (childData.mtdActual || 0); // Safely add values
                                }, 0);

                                // Calculate total target availability
                                const totalPlan = leafNodes.reduce((acc, childNode) => {
                                    const childData = childNode.data;
                                    return acc + (childData.mtdPlan || 0); // Safely add values
                                }, 0);


                                return totalPlan ? (totalActual / totalPlan) : 0;
                            },
                            cellClass: (params) => {
                                if (params.value > 1.10) {
                                    return "bg-warning text-end"; // Apply this class if value > 100
                                } else if (params.value < .90) {
                                    return "bg-danger text-end"; // Apply this class if value < 100
                                }
                                return 'bg-success text-end'; // No class for other cases
                            },
                            valueFormatter: (params) => {
                                return format(params.value, PERCENT_FORMAT);
                            },
                        },
                        {
                            headerName: "Month Plan",
                            field: "mthPlan",
                            sortable: true,
                            aggFunc: 'sum',
                            cellClass: 'text-end',
                            valueFormatter: (params) => {
                                return format((params.value || 0), NUMBER_FORMAT);
                            },
                        },
                    ],
                },
                {
                    headerName: this.ytdGroupHeader,
                    children: [
                        {
                            headerName: "YTD Plan",
                            field: "ytdPlan",
                            sortable: true,
                            aggFunc: 'sum',
                            cellClass: 'text-end',
                            valueFormatter: (params) => {
                                return format((params.value || 0), NUMBER_FORMAT);
                            },
                        },
                        {
                            headerName: "Actual",
                            field: "ytdActual",
                            sortable: true,
                            aggFunc: 'sum',
                            cellClass: 'text-end',
                            valueFormatter: (params) => {
                                return format((params.value || 0), NUMBER_FORMAT);
                            },
                        },
                        {
                            headerName: "% Plan Diff",
                            field: "ytdPlanDiff",
                            sortable: true,
                            aggFunc: (params) => {
                                const leafNodes = params.rowNode.allLeafChildren;

                                // Calculate total actual availability
                                const totalActual = leafNodes.reduce((acc, childNode) => {
                                    const childData = childNode.data;
                                    return acc + (childData.ytdActual || 0); // Safely add values
                                }, 0);

                                // Calculate total target availability
                                const totalPlan = leafNodes.reduce((acc, childNode) => {
                                    const childData = childNode.data;
                                    return acc + (childData.ytdPlan || 0); // Safely add values
                                }, 0);

                                return totalPlan ? (totalActual / totalPlan) : 0;
                            },
                            cellClass: (params) => {
                                if (params.value > 1.10) {
                                    return "bg-warning text-end"; // Apply this class if value > 100
                                } else if (params.value < .90) {
                                    return "bg-danger text-end"; // Apply this class if value < 100
                                }
                                return 'bg-success text-end'; // No class for other cases
                            },
                            valueFormatter: (params) => {
                                return format(params.value, PERCENT_FORMAT);
                            },
                        },
                        {
                            headerName: "Year Plan",
                            field: "yearPlan",
                            sortable: true,
                            aggFunc: 'sum',
                            cellClass: 'text-end',
                            valueFormatter: (params) => {
                                return params.value ? format(params.value, NUMBER_FORMAT) : "";
                            },
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
        toDateData() {
            const result = transformToToDateTableData(
                this.data,
                new Date(this.toDate),
                this.sliceAttribute,
                this.planAttrName,
                this.actualAttrName
            );
            return result;
        },
    },
};
</script>
