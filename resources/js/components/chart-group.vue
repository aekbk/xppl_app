<template>
    <div class="card">
        <div class="card-header d-flex justify-content-between">
            <div>
                <h5 class="mb-0 d-inline-block me-3">{{ title }}</h5>
                <p class="mb-0 d-inline">{{ subtitle }}</p>
            </div>
            <div class="d-flex gap-2">
                <div class="dropdown">
                    <button
                        class="btn btn-primary dropdown-toggle btn-sm btn-light btn-outline-primary"
                        type="button"
                        id="dropdownMenuButton1"
                        data-bs-toggle="dropdown"
                        aria-expanded="false"
                    >
                        Dropdown button
                    </button>
                    <ul
                        class="dropdown-menu"
                        aria-labelledby="dropdownMenuButton1"
                    >
                        <li>
                            <a class="dropdown-item active" href="#">Total</a>
                        </li>
                        <li><hr class="dropdown-divider" /></li>
                        <li><h6 class="dropdown-header">By Grade</h6></li>
                        <li>
                            <a class="dropdown-item" href="#">Another action</a>
                        </li>
                        <li>
                            <a class="dropdown-item" href="#"
                                >Something else here</a
                            >
                        </li>
                    </ul>
                </div>
                <div
                    class="btn-group"
                    role="group"
                    aria-label="Basic radio toggle button group"
                >
                    <input
                        type="radio"
                        class="btn-check"
                        name="btnradio"
                        id="btnmtd"
                        autocomplete="off"
                        :checked="selectedTab === 'mtd'"
                    />
                    <label
                        class="btn btn-sm btn-outline-primary"
                        for="btnmtd"
                        @click="onTabSwitch('mtd')"
                        >MTD</label
                    >

                    <input
                        type="radio"
                        class="btn-check"
                        name="btnradio"
                        id="btnytd"
                        autocomplete="off"
                        :checked="selectedTab === 'ytd'"
                    />
                    <label
                        class="btn btn-sm btn-outline-primary"
                        for="btnytd"
                        @click="onTabSwitch('ytd')"
                        >YTD</label
                    >
                </div>
            </div>
        </div>
        <div class="card-body">
            <slot></slot>
        </div>
    </div>
</template>

<script lang="ts">
export default {
    name: "ChartGroup",
    props: {
        title: {
            type: String,
            required: false,
            default: "",
        },
        subtitle: {
            type: String,
            required: false,
            default: "",
        },
        filterOptions: {
            type: Array,
            required: false,
            default: [],
        },
        filterHeader: {
            type: String,
            required: false,
            default: "Select Filter",
        },
        selectedTab: {
            type: String,
            required: false,
            default: "mtd",
        },
        selectedFilter: {
            type: String,
            required: false,
            default: "",
        },
    },
    emits: ["filterChange", "tabSwitch"],
    methods: {
        onFilterChange(value: string) {
            this.$emit("filterChange", value);
            console.log(value);
        },
        onTabSwitch(value: string) {
            this.$emit("tabSwitch", value);
        },
    },
};
</script>
