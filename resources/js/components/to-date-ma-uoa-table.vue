<template>
    <div class="custom-grid">
        <ag-grid-vue
            style="height: 600px"
            class="ag-theme-quartz"
            :columnDefs="columnDefs"
            :suppressMenuHide="false"
            :suppressCellFocus="true"
            :rowData="toDateData"
            animateRows="false"
            :defaultColDef="defaultColDef"
            :groupDefaultExpanded="1"
            :suppressAggFuncInHeader="true"
            :grandTotalRow="'bottom'"
            :autoGroupColumnDef="autoGroupColumnDef"
        ></ag-grid-vue>
    </div>
</template>

<script lang="ts">
import { AgGridVue } from "ag-grid-vue3";
import { getUOATableBgCellClass, transformToToDateUtilizationTableData } from "../utils/chart";
import { format } from "numerable";

const NUMBER_FORMAT = "0,0.00"
const PERCENT_FORMAT = "0%"

export default {
    name: "ToDateMaUoaTable",
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
        attributeHeader: {
            type: String,
            required: true,
        },
        toDate: {
            type: String,
            false: true,
        }
    },
    data() {
        return {
            columnDefs: [
                {
                    headerName: 'group',
                    valueGetter: (params) => {
                        return params.data.attr.substring(0, 2);
                    },
                    rowGroup: true,
                    hide: true,
                    pinned: 'left',
                },
                {
                    headerName: this.attributeHeader,
                    field: 'attr',
                    sortable: true,
                    filter: true,
                    pinned: 'left',
                },
                {
                    headerName: this.toDate + " (Kt)",
                    children: [
                        {
                            headerName: "Target Run Time (hrs)",
                            field: "todayTargetRunTime",
                            sortable: true,
                            aggFunc: 'sum',
                            cellClass: 'text-end',
                            width: 200,
                            valueFormatter: (params) => {
                                return format((params.value || 0), NUMBER_FORMAT)
                            },
                        },
                        {
                            headerName: "Run Time (hrs)",
                            field: "todayActualRunTime",
                            sortable: true,
                            aggFunc: 'sum',
                            cellClass: 'text-end',
                            valueFormatter: (params) => {
                                return format((params.value || 0), NUMBER_FORMAT)
                            },
                            suppressAggFuncInHeader: true,
                        },
                        {
                            headerName: "B/Down (hrs)",
                            field: "todayActualDownTime",
                            sortable: true,
                            aggFunc: 'sum',
                            cellClass: 'text-end',
                            valueFormatter: (params) => {
                                return format((params.value || 0), NUMBER_FORMAT)
                            },
                        },
                        {
                            headerName: "Standby (hrs)",
                            field: "todayActualStandByTime",
                            sortable: true,
                            aggFunc: 'sum',
                            cellClass: 'text-end',
                            valueFormatter: (params) => {
                                return format((params.value || 0), NUMBER_FORMAT)
                            },
                        },
                        {
                            headerName: "Target Avail (%)",
                            sortable: true,
                            aggFunc: (params) => {
                                return 0.95;
                            },
                            cellClass: 'text-end',
                            valueGetter: (params) => {
                                return 0.95;
                            },
                            valueFormatter: (params) => {
                                return format(params.value, PERCENT_FORMAT);
                            },
                        },
                        {
                            headerName: "Actual Avail (%)",
                            sortable: true,
                            cellClass: (params) => {
                                const tableClass = getUOATableBgCellClass(params.value, 0.95, 0.855);
                                return `${tableClass} text-end`;
                            },
                            aggFunc: (params) => {
                                const leafNodes = params.rowNode.allLeafChildren;

                                // Calculate total actual availability
                                const totalActualAvailability = leafNodes.reduce((acc, childNode) => {
                                    const childData = childNode.data;
                                    return acc + (childData.todayActualRunTime + childData.todayActualStandByTime || 0); // Safely add values
                                }, 0);

                                // Calculate total target availability
                                const totalTargetAvailability = leafNodes.reduce((acc, childNode) => {
                                    const childData = childNode.data;
                                    return acc + (childData.todayTargetRunTime || 0); // Safely add values
                                }, 0);


                                return totalTargetAvailability ? (totalActualAvailability / totalTargetAvailability) : 0;
                            },
                            valueGetter: (params) => {
                                if (params.node.group) {
                                    return 0;
                                }
                                const targetAvailability = (params.data.todayTargetRunTime || 0);
                                const actualAvailability = (params.data.todayActualRunTime || 0) + (params.data.todayActualStandByTime || 0);
                                return targetAvailability ? (actualAvailability / targetAvailability) : 0;
                            },
                            valueFormatter: (params) => {
                                return format(params.value, PERCENT_FORMAT);
                            },
                        },
                        {
                            headerName: "Target UoA (%)",
                            sortable: true,
                            cellClass: 'text-end',
                            aggFunc: (params) => {
                                return .85;
                            },
                            valueGetter: (params) => {
                                return .85;
                            },
                            valueFormatter: (params) => {
                                return format(params.value, PERCENT_FORMAT);
                            },
                        },
                        {
                            headerName: "UoA (%)",
                            sortable: true,
                            aggFunc: (params) => {
                                const leafNodes = params.rowNode.allLeafChildren;

                                // Calculate total actual availability
                                const totalActualRunTime = leafNodes.reduce((acc, childNode) => {
                                    const childData = childNode.data;
                                    return acc + (childData.todayActualRunTime || 0); // Safely add values
                                }, 0);

                                // Calculate total actual availability
                                const totalActualAvailability = leafNodes.reduce((acc, childNode) => {
                                    const childData = childNode.data;
                                    return acc + (childData.todayActualRunTime + childData.todayActualStandByTime || 0); // Safely add values
                                }, 0);

                                return totalActualAvailability ? (totalActualRunTime / totalActualAvailability) : 0;
                            },
                            cellClass: (params) => {
                                const tableClass = getUOATableBgCellClass(params.value, 1, 0.85);
                                return `${tableClass} text-end`;
                            },
                            valueGetter: (params) => {
                                if (params.node.group) {
                                    return 0;
                                }
                                const actualAvailability = params.data.todayActualRunTime + params.data.todayActualStandByTime;
                                const actualRuntime = params.data.todayActualRunTime;
                                return actualRuntime / actualAvailability;
                            },
                            valueFormatter: (params) => {
                                return format(params.value, PERCENT_FORMAT);
                            },
                        }
                    ],
                },
                {
                    headerName: "MTD (Mt)",
                    children: [
                    {
                            headerName: "Target Run Time (hrs)",
                            field: "mtdTargetRunTime",
                            sortable: true,
                            aggFunc: 'sum',
                            cellClass: 'text-end',
                            valueFormatter: (params) => {
                                return format((params.value || 0), NUMBER_FORMAT)
                            },
                            suppressAggFuncInHeader: true,
                        },
                        {
                            headerName: "Run Time (hrs)",
                            field: "mtdActualRunTime",
                            sortable: true,
                            aggFunc: 'sum',
                            cellClass: 'text-end',
                            valueFormatter: (params) => {
                                return format((params.value || 0), NUMBER_FORMAT)
                            },
                        },
                        {
                            headerName: "B/Down (hrs)",
                            field: "mtdActualDownTime",
                            sortable: true,
                            aggFunc: 'sum',
                            cellClass: 'text-end',
                            valueFormatter: (params) => {
                                return format((params.value || 0), NUMBER_FORMAT)
                            },
                        },
                        {
                            headerName: "Standby (hrs)",
                            field: "mtdActualStandByTime",
                            sortable: true,
                            aggFunc: 'sum',
                            cellClass: 'text-end',
                            valueFormatter: (params) => {
                                return format((params.value || 0), NUMBER_FORMAT)
                            },
                        },
                        {
                            headerName: "Actual Avail (%)",
                            sortable: true,
                            aggFunc: (params) => {
                                const leafNodes = params.rowNode.allLeafChildren;

                                // Calculate total actual availability
                                const totalActualAvailability = leafNodes.reduce((acc, childNode) => {
                                    const childData = childNode.data;
                                    return acc + (childData.mtdActualRunTime + childData.mtdActualStandByTime || 0); // Safely add values
                                }, 0);

                                // Calculate total target availability
                                const totalTargetAvailability = leafNodes.reduce((acc, childNode) => {
                                    const childData = childNode.data;
                                    return acc + (childData.mtdTargetRunTime || 0); // Safely add values
                                }, 0);

                                return totalTargetAvailability ? (totalActualAvailability / totalTargetAvailability) : 0;
                            },
                            cellClass: (params) => {
                                const tableClass = getUOATableBgCellClass(params.value, 0.95, 0.855);
                                return `${tableClass} text-end`;
                            },
                            valueGetter: (params) => {
                                if (params.node.group) {
                                    return 0;
                                }
                                const targetAvailability = params.data.mtdTargetRunTime;
                                const actualAvailability = params.data.mtdActualRunTime + params.data.mtdActualStandByTime;
                                return targetAvailability ? (actualAvailability / targetAvailability) : 0;
                            },
                            valueFormatter: (params) => {
                                return format(params.value, PERCENT_FORMAT);
                            },
                        },
                        {
                            headerName: "UoA (%)",
                            sortable: true,
                            aggFunc: (params) => {
                                const leafNodes = params.rowNode.allLeafChildren;

                                // Calculate total actual availability
                                const totalActualRunTime = leafNodes.reduce((acc, childNode) => {
                                    const childData = childNode.data;
                                    return acc + (childData.mtdActualRunTime || 0); // Safely add values
                                }, 0);

                                // Calculate total actual availability
                                const totalActualAvailability = leafNodes.reduce((acc, childNode) => {
                                    const childData = childNode.data;
                                    return acc + (childData.mtdActualRunTime + childData.mtdActualStandByTime || 0); // Safely add values
                                }, 0);

                                return totalActualAvailability ? (totalActualRunTime / totalActualAvailability) : 0;
                            },
                            cellClass: (params) => {
                                const tableClass = getUOATableBgCellClass(params.value, 1, 0.85);
                                return `${tableClass} text-end`;
                            },
                            valueGetter: (params) => {
                                if (params.node.group) {
                                    return 0;
                                }
                                const actualAvailability = params.data.mtdActualRunTime + params.data.mtdActualStandByTime;
                                const actualRuntime = params.data.mtdActualRunTime;
                                return actualRuntime / actualAvailability;
                            },
                            valueFormatter: (params) => {
                                return format(params.value, PERCENT_FORMAT);
                            },
                        }

                    ],
                },
                {
                    headerName: "YTD (Mt)",
                    children: [
                    {
                            headerName: "Target Run Time (hrs)",
                            field: "ytdTargetRunTime",
                            sortable: true,
                            aggFunc: 'sum',
                            cellClass: 'text-end',
                            valueFormatter: (params) => {
                                return format((params.value || 0), NUMBER_FORMAT)
                            },
                        },
                        {
                            headerName: "Run Time (hrs)",
                            field: "ytdActualRunTime",
                            sortable: true,
                            aggFunc: 'sum',
                            cellClass: 'text-end',
                            valueFormatter: (params) => {
                                return format((params.value || 0), NUMBER_FORMAT)
                            },
                        },
                        {
                            headerName: "B/Down (hrs)",
                            field: "ytdActualDownTime",
                            sortable: true,
                            aggFunc: 'sum',
                            cellClass: 'text-end',
                            valueFormatter: (params) => {
                                return format((params.value || 0), NUMBER_FORMAT)
                            },
                        },
                        {
                            headerName: "Standby (hrs)",
                            field: "ytdActualStandByTime",
                            sortable: true,
                            aggFunc: 'sum',
                            cellClass: 'text-end',
                            valueFormatter: (params) => {
                                return format((params.value || 0), NUMBER_FORMAT)
                            },
                        },
                        {
                            headerName: "Actual Avail (%)",
                            sortable: true,
                            aggFunc: (params) => {
                                const leafNodes = params.rowNode.allLeafChildren;

                                // Calculate total actual availability
                                const totalActualAvailability = leafNodes.reduce((acc, childNode) => {
                                    const childData = childNode.data;
                                    return acc + (childData.ytdActualRunTime + childData.ytdActualStandByTime || 0); // Safely add values
                                }, 0);

                                // Calculate total target availability
                                const totalTargetAvailability = leafNodes.reduce((acc, childNode) => {
                                    const childData = childNode.data;
                                    return acc + (childData.ytdTargetRunTime || 0); // Safely add values
                                }, 0);

                                return totalTargetAvailability ? (totalActualAvailability / totalTargetAvailability) : 0;
                            },
                            cellClass: (params) => {
                                const tableClass = getUOATableBgCellClass(params.value, 0.95, 0.855);
                                return `${tableClass} text-end`;
                            },
                            valueGetter: (params) => {
                                if (params.node.group) {
                                    return 0;
                                }
                                const targetAvailability = params.data.ytdTargetRunTime;
                                const actualAvailability = params.data.ytdActualRunTime + params.data.ytdActualStandByTime;
                                return targetAvailability ? (actualAvailability / targetAvailability) : 0;
                            },
                            valueFormatter: (params) => {
                                return format(params.value, PERCENT_FORMAT);
                            },
                        },
                        {
                            headerName: "UoA (%)",
                            sortable: true,
                            aggFunc: (params) => {
                                const leafNodes = params.rowNode.allLeafChildren;

                                // Calculate total actual availability
                                const totalActualRunTime = leafNodes.reduce((acc, childNode) => {
                                    const childData = childNode.data;
                                    return acc + (childData.ytdActualRunTime || 0); // Safely add values
                                }, 0);

                                // Calculate total actual availability
                                const totalActualAvailability = leafNodes.reduce((acc, childNode) => {
                                    const childData = childNode.data;
                                    return acc + (childData.ytdActualRunTime + childData.ytdActualStandByTime || 0); // Safely add values
                                }, 0);

                                return totalActualAvailability ? (totalActualRunTime / totalActualAvailability) : 0;
                            },
                            cellClass: (params) => {
                                const tableClass = getUOATableBgCellClass(params.value, 1, 0.85);
                                return `${tableClass} text-end`;
                            },
                            valueGetter: (params) => {
                                if (params.node.group) {
                                    return 0;
                                }
                                const actualAvailability = params.data.ytdActualRunTime + params.data.ytdActualStandByTime;
                                const actualRuntime = params.data.ytdActualRunTime;
                                return actualRuntime / actualAvailability;
                            },
                            valueFormatter: (params) => {
                                return format(params.value, PERCENT_FORMAT);
                            },
                        }
                    ],
                },
            ],
            autoGroupColumnDef: {
                cellRenderer: 'agGroupCellRenderer',
                pinned: 'left',
            },
            defaultColDef: {
                flex: 1,
                minWidth: 120,
            },
        };
    },
    computed: {
        toDateData() {
            const result = transformToToDateUtilizationTableData(
                this.data,
                new Date(this.toDate),
                this.sliceAttribute,
            );
            return result;
        },
    },
};
</script>
