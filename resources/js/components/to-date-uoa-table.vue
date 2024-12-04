<template>
    <div>
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
        ></ag-grid-vue>
    </div>
</template>

<script lang="ts">
import { AgGridVue } from "ag-grid-vue3";
import { getTableBgCellClass, transformToToDateUtilizationTableData } from "../utils/chart";
import { format } from "numerable";

const NUMBER_FORMAT = "0,0.00"
const PERCENT_FORMAT = "0%"

export default {
    name: "ToDateUoaTable",
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
                    headerName: 'group',
                    valueGetter: (params) => {
                        return params.data.attr.substring(0, 2);
                    },
                    rowGroup: true,
                    hide: true,
                },
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
                            headerName: "Target Run Time (hrs)",
                            field: "todayTargetRunTime",
                            sortable: true,
                            aggFunc: 'sum',
                            cellClass: 'text-end',
                            valueFormatter: (params) => {
                                return params.value ? format(params.value, NUMBER_FORMAT) : "";
                            },
                        },
                        {
                            headerName: "Run Time (hrs)",
                            field: "todayActualRunTime",
                            sortable: true,
                            aggFunc: 'sum',
                            cellClass: 'text-end',
                            valueFormatter: (params) => {
                                return params.value ? format(params.value, NUMBER_FORMAT) : "";
                            },
                        },
                        {
                            headerName: "B/Down (hrs)",
                            field: "todayActualDownTime",
                            sortable: true,
                            aggFunc: 'sum',
                            cellClass: 'text-end',
                            valueFormatter: (params) => {
                                return params.value ? format(params.value, NUMBER_FORMAT) : "";
                            },
                        },
                        {
                            headerName: "Standby (hrs)",
                            field: "todayActualStandByTime",
                            sortable: true,
                            aggFunc: 'sum',
                            cellClass: 'text-end',
                            valueFormatter: (params) => {
                                return params.value ? format(params.value, NUMBER_FORMAT) : "";
                            },
                        },
                        {
                            headerName: "Target Avail (%)",
                            sortable: true,
                            aggFunc: 'avg',
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
                            aggFunc: 'avg',
                            cellClass: (params) => {
                                const tableClass = getTableBgCellClass(params.value, 1, 0.95);
                                return `${tableClass} text-end`;
                            },
                            valueGetter: (params) => {
                                const targetAvailability = params.data.todayTargetRunTime;
                                const actualAvailability = params.data.todayActualRunTime + params.data.todayActualStandByTime;
                                return targetAvailability ? (actualAvailability / targetAvailability) : 0;
                            },
                            valueFormatter: (params) => {
                                return format(params.value, PERCENT_FORMAT);
                            },
                        },
                        {
                            headerName: "Target UoA (%)",
                            sortable: true,
                            aggFunc: 'avg',
                            cellClass: 'text-end',
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
                            aggFunc: 'avg',
                            cellClass: (params) => {
                                const tableClass = getTableBgCellClass(params.value, 1, 0.85);
                                return `${tableClass} text-end`;
                            },
                            valueGetter: (params) => {
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
                                return params.value ? format(params.value, NUMBER_FORMAT) : "";
                            },
                        },
                        {
                            headerName: "Run Time (hrs)",
                            field: "mtdActualRunTime",
                            sortable: true,
                            aggFunc: 'sum',
                            cellClass: 'text-end',
                            valueFormatter: (params) => {
                                return params.value ? format(params.value, NUMBER_FORMAT) : "";
                            },
                        },
                        {
                            headerName: "B/Down (hrs)",
                            field: "mtdActualDownTime",
                            sortable: true,
                            aggFunc: 'sum',
                            cellClass: 'text-end',
                            valueFormatter: (params) => {
                                return params.value ? format(params.value, NUMBER_FORMAT) : "";
                            },
                        },
                        {
                            headerName: "Standby (hrs)",
                            field: "mtdActualStandByTime",
                            sortable: true,
                            aggFunc: 'sum',
                            cellClass: 'text-end',
                            valueFormatter: (params) => {
                                return params.value ? format(params.value, NUMBER_FORMAT) : "";
                            },
                        },
                        {
                            headerName: "Target Avail (%)",
                            sortable: true,
                            aggFunc: 'avg',
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
                            aggFunc: 'avg',
                            cellClass: (params) => {
                                const tableClass = getTableBgCellClass(params.value, 1, 0.95);
                                return `${tableClass} text-end`;
                            },
                            valueGetter: (params) => {
                                const targetAvailability = params.data.mtdTargetRunTime;
                                const actualAvailability = params.data.mtdActualRunTime + params.data.mtdActualStandByTime;
                                return targetAvailability ? (actualAvailability / targetAvailability) : 0;
                            },
                            valueFormatter: (params) => {
                                return format(params.value, PERCENT_FORMAT);
                            },
                        },
                        {
                            headerName: "Target UoA (%)",
                            sortable: true,
                            aggFunc: 'avg',
                            cellClass: 'text-end',
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
                            aggFunc: 'avg',
                            cellClass: (params) => {
                                const tableClass = getTableBgCellClass(params.value, 1, 0.85);
                                return `${tableClass} text-end`;
                            },
                            valueGetter: (params) => {
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
                                return params.value ? format(params.value, NUMBER_FORMAT) : "";
                            },
                        },
                        {
                            headerName: "Run Time (hrs)",
                            field: "ytdActualRunTime",
                            sortable: true,
                            aggFunc: 'sum',
                            cellClass: 'text-end',
                            valueFormatter: (params) => {
                                return params.value ? format(params.value, NUMBER_FORMAT) : "";
                            },
                        },
                        {
                            headerName: "B/Down (hrs)",
                            field: "ytdActualDownTime",
                            sortable: true,
                            aggFunc: 'sum',
                            cellClass: 'text-end',
                            valueFormatter: (params) => {
                                return params.value ? format(params.value, NUMBER_FORMAT) : "";
                            },
                        },
                        {
                            headerName: "Standby (hrs)",
                            field: "ytdActualStandByTime",
                            sortable: true,
                            aggFunc: 'sum',
                            cellClass: 'text-end',
                            valueFormatter: (params) => {
                                return params.value ? format(params.value, NUMBER_FORMAT) : "";
                            },
                        },
                        {
                            headerName: "Target Avail (%)",
                            sortable: true,
                            aggFunc: 'avg',
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
                            aggFunc: 'avg',
                            cellClass: (params) => {
                                const tableClass = getTableBgCellClass(params.value, 1, 0.95);
                                return `${tableClass} text-end`;
                            },
                            valueGetter: (params) => {
                                const targetAvailability = params.data.ytdTargetRunTime;
                                const actualAvailability = params.data.ytdActualRunTime + params.data.ytdActualStandByTime;
                                return targetAvailability ? (actualAvailability / targetAvailability) : 0;
                            },
                            valueFormatter: (params) => {
                                return format(params.value, PERCENT_FORMAT);
                            },
                        },
                        {
                            headerName: "Target UoA (%)",
                            sortable: true,
                            aggFunc: 'avg',
                            cellClass: 'text-end',
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
                            aggFunc: 'avg',
                            cellClass: (params) => {
                                const tableClass = getTableBgCellClass(params.value, 1, 0.85);
                                return `${tableClass} text-end`;
                            },
                            valueGetter: (params) => {
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
                new Date("2024-11-20"),
                this.sliceAttribute,
            );
            return result;
        },
    },
};
</script>
