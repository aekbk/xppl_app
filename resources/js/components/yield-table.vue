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
        ></ag-grid-vue>
    </div>
</template>

<script lang="ts">
import { AgGridVue } from "ag-grid-vue3";
import { format } from "numerable";
import { transformToToDateTableData } from "../utils/chart";

const NUMBER_FORMAT = "0,0%"

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
    },
    data() {
        return {
            columnDefs: [
                {
                    headerName: 'group',
                    field: 'plant_group',
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
                            headerName: "Plan",
                            field: "todayPlan",
                            sortable: true,
                            aggFunc: 'avg',
                            cellClass: 'text-end',
                            valueFormatter: (params) => {
                                return params.value ? format(params.value, NUMBER_FORMAT) : "";
                            },
                        },
                        {
                            headerName: "Actual",
                            field: "todayActual",
                            sortable: true,
                            aggFunc: 'avg',
                            cellClass: 'text-end',
                            valueFormatter: (params) => {
                                return params.value ? format(params.value, NUMBER_FORMAT) : "";
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
                            aggFunc: 'avg',
                            cellClass: 'text-end',
                            valueFormatter: (params) => {
                                return params.value ? format(params.value, NUMBER_FORMAT) : "";
                            },
                        },
                        {
                            headerName: "Actual",
                            field: "mtdActual",
                            sortable: true,
                            aggFunc: 'avg',
                            cellClass: 'text-end',
                            valueFormatter: (params) => {
                                return params.value ? format(params.value, NUMBER_FORMAT) : "";
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
                            aggFunc: 'avg',
                            cellClass: 'text-end',
                            valueFormatter: (params) => {
                                return params.value ? format(params.value, NUMBER_FORMAT) : "";
                            },
                        },
                        {
                            headerName: "Actual",
                            field: "ytdActual",
                            sortable: true,
                            aggFunc: 'avg',
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
                new Date("2024-11-20"),
                this.sliceAttribute,
                this.planAttrName,
                this.actualAttrName
            );
            return result.map(i => {
                return {
                    ...i,
                    plant_group: i.attr.substring(0, 2),
                };
            });
        },
    },
};
</script>

<style>
.ag-row-footer {
    background-color: #ECEEF3;
    font-weight: bold;
}
</style>