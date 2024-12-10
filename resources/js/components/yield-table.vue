<template>
    <div>
        <ag-grid-vue
            style="height: 700px"
            class="ag-theme-quartz"
            :columnDefs="columnDefs"
            :suppressMenuHide="false"
            :suppressCellFocus="true"
            :rowData="toDateData"
            animateRows="false"
            :defaultColDef="defaultColDef"
            :groupDefaultExpanded="1"
            :suppressAggFuncInHeader="true"
        ></ag-grid-vue>
    </div>
</template>

<script lang="ts">
import { AgGridVue } from "ag-grid-vue3";
import { format } from "numerable";
import {
    transformToYieldTableData,
} from "../utils/chart";

const NUMBER_FORMAT = "0,0%";

export default {
    name: "YieldTable",
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
    },
    data() {
        return {
            defaultColDef: {
                flex: 1,
                minWidth: 120,
            },
        };
    },
    computed: {
        columnDefs() {
            return [
                {
                    headerName: "group",
                    field: "plant_group",
                    rowGroup: true,
                    hide: true,
                },
                {
                    headerName: this.attributeHeader,
                    field: "attr",
                    sortable: true,
                    filter: true,
                },
                {
                    headerName: this.toDate + " (Kt)",
                    children: [
                        {
                            headerName: "Today Input Plan",
                            field: "todayInputPlan",
                            sortable: true,
                            cellClass: "text-end",
                            hide: true,
                        },
                        {
                            headerName: "Today Output Plan",
                            field: "todayOutputPlan",
                            sortable: true,
                            cellClass: "text-end",
                            hide: true,
                        },
                        {
                            headerName: "Plan",
                            sortable: true,
                            cellClass: "text-end",
                            valueGetter: (params) => {
                                if (params.node.group) {
                                    return 0;
                                }
                                return (
                                    params.data.todayOutputPlan /
                                    params.data.todayInputPlan
                                );
                            },
                            valueFormatter: (params) => {
                                return params.value
                                    ? format(params.value, NUMBER_FORMAT)
                                    : "";
                            },
                        },
                        {
                            headerName: "Actual",
                            sortable: true,
                            cellClass: "text-end",
                            valueGetter: (params) => {
                                if (params.node.group) {
                                    return 0;
                                }
                                return (
                                    params.data.todayOutputActual /
                                    params.data.todayInputActual
                                );
                            },
                            valueFormatter: (params) => {
                                return params.value
                                    ? format(params.value, NUMBER_FORMAT)
                                    : "";
                            },
                        },
                    ],
                },
                {
                    headerName: "MTD (Mt)",
                    children: [
                        {
                            headerName: "MTD Input Plan",
                            field: "mtdInputPlan",
                            sortable: true,
                            cellClass: "text-end",
                            hide: true,
                        },
                        {
                            headerName: "MTD Output Plan",
                            field: "mtdOutputPlan",
                            sortable: true,
                            cellClass: "text-end",
                            hide: true,
                        },
                        {
                            headerName: "MTD Plan",
                            sortable: true,
                            cellClass: "text-end",
                            valueGetter: (params) => {
                                if (params.node.group) {
                                    return 0;
                                }
                                return (
                                    params.data.mtdOutputPlan /
                                    params.data.mtdInputPlan
                                );
                            },
                            valueFormatter: (params) => {
                                return params.value
                                    ? format(params.value, NUMBER_FORMAT)
                                    : "";
                            },
                        },
                        {
                            headerName: "Actual",
                            sortable: true,
                            cellClass: "text-end",
                            valueGetter: (params) => {
                                if (params.node.group) {
                                    return 0;
                                }
                                return (
                                    params.data.mtdOutputActual /
                                    params.data.mtdInputActual
                                );
                            },
                            valueFormatter: (params) => {
                                return params.value
                                    ? format(params.value, NUMBER_FORMAT)
                                    : "";
                            },
                        },
                    ],
                },
                {
                    headerName: "YTD (Mt)",
                    children: [
                    {
                            headerName: "YTD Input Plan",
                            field: "ytdInputPlan",
                            sortable: true,
                            cellClass: "text-end",
                            hide: true,
                        },
                        {
                            headerName: "YTD Output Plan",
                            field: "ytdOutputPlan",
                            sortable: true,
                            cellClass: "text-end",
                            hide: true,
                        },
                        {
                            headerName: "YTD Plan",
                            sortable: true,
                            cellClass: "text-end",
                            valueGetter: (params) => {
                                if (params.node.group) {
                                    return 0;
                                }
                                return (
                                    params.data.ytdOutputPlan /
                                    params.data.ytdInputPlan
                                );
                            },
                            valueFormatter: (params) => {
                                return params.value
                                    ? format(params.value, NUMBER_FORMAT)
                                    : "";
                            },
                        },
                        {
                            headerName: "Actual",
                            sortable: true,
                            cellClass: "text-end",
                            valueGetter: (params) => {
                                if (params.node.group) {
                                    return 0;
                                }
                                return (
                                    params.data.ytdOutputActual /
                                    params.data.ytdInputActual
                                );
                            },
                            valueFormatter: (params) => {
                                return params.value
                                    ? format(params.value, NUMBER_FORMAT)
                                    : "";
                            },
                        },
                    ],
                },
            ];
        },
        toDateData() {
            console.log(this.data);
            const result = transformToYieldTableData(
                this.data,
                new Date(this.toDate),
                this.sliceAttribute,
                this.planAttrName,
                this.actualAttrName
            );
            return result.map((i) => {
                return {
                    ...i,
                    plant_group: i.attr.substring(0, 2),
                };
            });
        },
    },
};
</script>

<style></style>
