<template>
    <div class="custom-grid">
        <ag-grid-vue
            style="height: 90vh; width: 100%"
            class="ag-theme-quartz"
            :columnDefs="columnDefs"
            :suppressMenuHide="false"
            :suppressCellFocus="true"
            :rowData="toDateData"
            animateRows="false"
            :defaultColDef="defaultColDef"
            :groupDefaultExpanded="1"
            :suppressAggFuncInHeader="true"
            :groupRowTotal="true"
            :grandTotalRow="'bottom'"
        ></ag-grid-vue>
    </div>
</template>

<script lang="ts">
import { AgGridVue } from "ag-grid-vue3";
import groupBy from "lodash/groupBy";
import mapValues from "lodash/mapValues";
import { transformToNestedDateTableData } from "../utils/chart";
import { format } from "numerable";

const NUMBER_FORMAT = "0,0.00";
const PERCENT_FORMAT = "0.00%";

export default {
    name: "ToNestedDateTable",
    components: { AgGridVue },
    props: {
        data: {
            type: Array,
            required: false,
            default: "",
        },
        primarySliceAttribute: {
            type: String,
            required: true,
        },
        secondarySliceAttribute: {
            type: String,
            required: true,
        },
        primaryAttributeHeader: {
            type: String,
            required: true,
        },
        secondaryAttributeHeader: {
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
        toDate: {
            type: String,
            false: true,
        },
    },
    data() {
        return {
            columnDefs: [
                {
                    // headerName customise text display at the top of column
                    headerName: this.primaryAttributeHeader,
                    // field refer to the `keys` in your returned data object; check the `ProcessedNestedDataItem` interface in `utils/chart.ts` script.
                    field: "primaryAttr",
                    sortable: true,
                    filter: true,
                    rowGroup: true,
                    hide: true,
                },
                {
                    headerName: this.secondaryAttributeHeader,
                    field: "secondaryAttr",
                    sortable: true,
                    filter: true,
                },
                {
                    headerName: this.toDate + " (Kt)",
                    children: [
                        {
                            headerName: "Plan",
                            field: "todayPlan",
                            sortable: true,
                            aggFunc: "sum",
                            valueFormatter: (params) => {
                                return format(params.value || 0, NUMBER_FORMAT);
                            },
                        },
                        {
                            headerName: "Actual",
                            field: "todayActual",
                            sortable: true,
                            aggFunc: "sum",
                            valueFormatter: (params) => {
                                return format(params.value || 0, NUMBER_FORMAT);
                            },
                        },
                        {
                            headerName: "% Plan Diff",
                            field: "todayPlanDiff",
                            sortable: true,
                            aggFunc: (params) => {
                                const leafNodes =
                                    params.rowNode.allLeafChildren;
                                console.log("params", params);

                                // Calculate total actual availability
                                const totalActual = leafNodes.reduce(
                                    (acc, childNode) => {
                                        const childData = childNode.data;
                                        return (
                                            acc + (childData.todayActual || 0)
                                        ); // Safely add values
                                    },
                                    0
                                );

                                // Calculate total target availability
                                const totalPlan = leafNodes.reduce(
                                    (acc, childNode) => {
                                        const childData = childNode.data;
                                        return acc + (childData.todayPlan || 0); // Safely add values
                                    },
                                    0
                                );

                                return totalPlan ? totalActual / totalPlan : 0;
                            },
                            cellClass: (params) => {
                                if (params.value > 1.1) {
                                    return "bg-warning text-end"; // Apply this class if value > 100
                                } else if (params.value < 0.9) {
                                    return "bg-danger text-end"; // Apply this class if value < 100
                                }
                                return "bg-success text-end"; // No class for other cases
                            },
                            valueFormatter: (params) => {
                                return format(params.value, PERCENT_FORMAT);
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
                            aggFunc: "sum",
                            valueFormatter: (params) => {
                                return format(params.value || 0, NUMBER_FORMAT);
                            },
                        },
                        {
                            headerName: "Actual",
                            field: "mtdActual",
                            sortable: true,
                            aggFunc: "sum",
                            valueFormatter: (params) => {
                                return format(params.value || 0, NUMBER_FORMAT);
                            },
                        },
                        {
                            headerName: "% Plan Diff",
                            field: "mtdPlanDiff",
                            sortable: true,
                            aggFunc: (params) => {
                                const leafNodes =
                                    params.rowNode.allLeafChildren;
                                console.log("params", params);

                                // Calculate total actual availability
                                const totalActual = leafNodes.reduce(
                                    (acc, childNode) => {
                                        const childData = childNode.data;
                                        return (
                                            acc + (childData.todayActual || 0)
                                        ); // Safely add values
                                    },
                                    0
                                );

                                // Calculate total target availability
                                const totalPlan = leafNodes.reduce(
                                    (acc, childNode) => {
                                        const childData = childNode.data;
                                        return acc + (childData.todayPlan || 0); // Safely add values
                                    },
                                    0
                                );

                                return totalPlan ? totalActual / totalPlan : 0;
                            },
                            cellClass: (params) => {
                                if (params.value > 1.1) {
                                    return "bg-warning text-end"; // Apply this class if value > 100
                                } else if (params.value < 0.9) {
                                    return "bg-danger text-end"; // Apply this class if value < 100
                                }
                                return "bg-success text-end"; // No class for other cases
                            },
                            valueFormatter: (params) => {
                                return format(params.value, PERCENT_FORMAT);
                            },
                        },
                        {
                            headerName: "Month Plan",
                            field: "mthPlan",
                            sortable: true,
                            aggFunc: "sum",
                            valueFormatter: (params) => {
                                return format(params.value || 0, NUMBER_FORMAT);
                            },
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
                            aggFunc: "sum",
                            valueFormatter: (params) => {
                                return format(params.value || 0, NUMBER_FORMAT);
                            },
                        },
                        {
                            headerName: "Actual",
                            field: "ytdActual",
                            sortable: true,
                            aggFunc: "sum",
                            valueFormatter: (params) => {
                                return format(params.value, NUMBER_FORMAT);
                            },
                        },
                        {
                            headerName: "% Plan Diff",
                            field: "ytdPlanDiff",
                            sortable: true,
                            aggFunc: (params) => {
                                const leafNodes =
                                    params.rowNode.allLeafChildren;
                                console.log("params", params);

                                // Calculate total actual availability
                                const totalActual = leafNodes.reduce(
                                    (acc, childNode) => {
                                        const childData = childNode.data;
                                        return (
                                            acc + (childData.todayActual || 0)
                                        ); // Safely add values
                                    },
                                    0
                                );

                                // Calculate total target availability
                                const totalPlan = leafNodes.reduce(
                                    (acc, childNode) => {
                                        const childData = childNode.data;
                                        return acc + (childData.todayPlan || 0); // Safely add values
                                    },
                                    0
                                );

                                return totalPlan ? totalActual / totalPlan : 0;
                            },
                            cellClass: (params) => {
                                if (params.value > 1.1) {
                                    return "bg-warning text-end"; // Apply this class if value > 100
                                } else if (params.value < 0.9) {
                                    return "bg-danger text-end"; // Apply this class if value < 100
                                }
                                return "bg-success text-end"; // No class for other cases
                            },
                            valueFormatter: (params) => {
                                return format(params.value, PERCENT_FORMAT);
                            },
                        },
                        {
                            headerName: "Year Plan",
                            field: "yearPlan",
                            sortable: true,
                            aggFunc: "sum",
                            valueFormatter: (params) => {
                                return format(params.value || 0, NUMBER_FORMAT);
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
        nestedGrouping() {
            const result = this.groupByAttributes(this.data, [
                this.primarySliceAttribute,
                this.secondarySliceAttribute,
            ]);
            return result;
        },
        toDateData() {
            const result = transformToNestedDateTableData(
                this.data,
                new Date(this.toDate),
                this.primarySliceAttribute,
                this.secondarySliceAttribute,
                this.planAttrName,
                this.actualAttrName
            );
            return result;
        },
    },
    methods: {
        /**
         * Helper function to group data by a variable number of attributes in a nested structure.
         * Example: Group the data by `Contractor`, followed by `Grade`, and so on.
         *
         * @param {Array} data - The array of objects to group.
         * @param {string[]} attributes - An array of attributes to group by, in order.
         * @returns {Object} - A nested object grouped by the specified attributes.
         */
        groupByAttributes(data, attributes) {
            // Input validation
            if (!Array.isArray(data)) {
                throw new Error("Invalid input: data must be an array.");
            }
            if (
                !Array.isArray(attributes) ||
                attributes.some((attr) => typeof attr !== "string")
            ) {
                throw new Error(
                    "Invalid attributes: attributes must be an array of strings."
                );
            }

            // Base case: if no attributes remain, return the data
            if (attributes.length === 0) {
                return data;
            }

            // Take the first attribute and group by it
            const [currentAttribute, ...remainingAttributes] = attributes;

            // Group by the current attribute and recurse for remaining attributes
            return mapValues(groupBy(data, currentAttribute), (group) =>
                this.groupByAttributes(group, remainingAttributes)
            );
        },
    },
};
</script>
