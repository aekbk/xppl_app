<template>
    <div class="card">
        <div class="card-header d-flex justify-content-between border">
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
                        {{ selectedFilter }}
                    </button>
                    <ul
                        class="dropdown-menu"
                        aria-labelledby="dropdownMenuButton1"
                    >
                        <li>
                            <button
                                class="dropdown-item"
                                :class="{ active: selectedFilter === 'Total' }"
                                @click="onFilterChange('Total')"
                            >
                                Total
                            </button>
                        </li>
                        <li><hr class="dropdown-divider" /></li>
                        <li>
                            <h6 class="dropdown-header">{{ filterHeader }}</h6>
                        </li>
                        <li v-for="filter in availableFilter">
                            <button
                                class="dropdown-item"
                                :class="{ active: selectedFilter === filter }"
                                @click="onFilterChange(filter)"
                            >
                                {{ filter }}
                            </button>
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
                        autocomplete="off"
                    />
                    <label
                        class="btn btn-sm btn-outline-primary"
                        :class="{ active: selectedTab === 'mtd' }"
                        @click="onTabSwitch('mtd')"
                        >MTD</label
                    >

                    <input
                        type="radio"
                        class="btn-check"
                        autocomplete="off"
                    />
                    <label
                        class="btn btn-sm btn-outline-primary"
                        :class="{ active: selectedTab === 'ytd' }"
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
        selectedTab: {
            type: String,
            required: false,
            default: "mtd",
        },
        filterHeader: {
            type: String,
            required: false,
            default: "Select Filter",
        },
        availableFilter: {
            type: Array,
            required: false,
            default: [],
        },
        selectedFilter: {
            type: String,
            required: false,
            default: "Total",
        },
    },
    emits: ["filterChange", "tabSwitch"],
    methods: {
        onFilterChange(value: string) {
            this.$emit("filterChange", value);
        },
        onTabSwitch(value: string) {
            this.$emit("tabSwitch", value);
        },
    },
};
</script>
