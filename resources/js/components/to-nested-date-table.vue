<template>
    <div>
        <ag-grid-vue
            style="height: 90vh; width: 100%;"
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
import mapValues from "lodash/mapValues";
import { transformToNestedDateTableData } from "../utils/chart";

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
  				},
  				{
  					headerName: this.secondaryAttributeHeader,
  					field: "secondaryAttr",
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
        nestedGrouping() {
        	const result = this.groupByAttributes(this.data, [this.primarySliceAttribute, this.secondarySliceAttribute]);
            return result;
        },
        toDateData() {
            const result = transformToNestedDateTableData(
                this.data,
                new Date("2024-11-20"),
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
            if (!Array.isArray(attributes) || attributes.some(attr => typeof attr !== "string")) {
                throw new Error("Invalid attributes: attributes must be an array of strings.");
            }

            // Base case: if no attributes remain, return the data
            if (attributes.length === 0) {
                return data;
            }

            // Take the first attribute and group by it
            const [currentAttribute, ...remainingAttributes] = attributes;

            // Group by the current attribute and recurse for remaining attributes
            return mapValues(groupBy(data, currentAttribute), group =>
                this.groupByAttributes(group, remainingAttributes)
            );
        },
	}
};
</script>
