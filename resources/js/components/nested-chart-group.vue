/
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
                        {{ primarySelectedFilter }}
                    </button>
                    <ul
                        class="dropdown-menu"
                        aria-labelledby="dropdownMenuButton1"
                    >
                        <li>
                            <button
                                class="dropdown-item"
                                :class="{ active: primarySelectedFilter === 'Total' }"
                                @click="onPrimaryFilterChange('Total')"
                            >
                                Total
                            </button>
                        </li>
                        <li><hr class="dropdown-divider" /></li>
                        <li>
                            <h6 class="dropdown-header">{{ primaryFilterHeader }}</h6>
                        </li>
                        <li v-for="primaryFilter in primaryAvailableFilter">
                            <button
                                class="dropdown-item"
                                :class="{ active: primarySelectedFilter === primaryFilter }"
                                @click="onPrimaryFilterChange(primaryFilter)"
                            >
                                {{ primaryFilter }}
                            </button>
                        </li>
                    </ul>
                </div>

                <div class="dropdown">
                    <button
                        class="btn btn-primary dropdown-toggle btn-sm btn-light btn-outline-primary"
                        type="button"
                        id="dropdownMenuButton2"
                        data-bs-toggle="dropdown"
                        aria-expanded="false"
                    >
                        {{ secondarySelectedFilter }}
                    </button>
                    <ul
                        class="dropdown-menu"
                        aria-labelledby="dropdownMenuButton2"
                    >
                        <li>
                            <button
                                class="dropdown-item"
                                :class="{ active: secondarySelectedFilter === 'Total' }"
                                @click="onSecondaryFilterChange('Total')"
                            >
                                Total
                            </button>
                        </li>
                        <li><hr class="dropdown-divider" /></li>
                        <li>
                            <h6 class="dropdown-header">{{ secondaryFilterHeader }}</h6>
                        </li>
                        <li v-for="secondaryFilter in secondaryAvailableFilter">
                            <button
                                class="dropdown-item"
                                :class="{ active: secondarySelectedFilter === secondaryFilter }"
                                @click="onSecondaryFilterChange(secondaryFilter)"
                            >
                                {{ secondaryFilter }}
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
/*
 *  This script is an extension of the original chart-group.vue script. Its
 *  purpose is to modify the script to accept two filters in the form of
 *  dropdown lists. All other functions remain unchanged. In the future, we
 *  plan to refactor this script to accept an array of filters, allowing for
 *  the number of filter lists to match the number of dropdown menus displayed
 *  on the screen.
*/
export default {
    name: "NestedChartGroup",
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
        primaryFilterHeader: {
            type: String,
            required: false,
            default: "Select Filter",
        },
        secondaryFilterHeader: {
            type: String,
            required: false,
            default: "Select Filter",
        },
        primaryAvailableFilter: {
            type: Array,
            required: false,
            default: [],
        },
        primarySelectedFilter: {
            type: String,
            required: false,
            default: "Total",
        },
        secondaryAvailableFilter: {
            type: Array,
            required: false,
            default: [],
        },
        secondarySelectedFilter: {
            type: String,
            required: false,
            default: "Total",
        },

    },
    emits: ["primaryFilterChange", "secondaryFilterChange", "tabSwitch"],
    methods: {
        onPrimaryFilterChange(value: string) {
            this.$emit("primaryFilterChange", value);
        },
        onSecondaryFilterChange(value: string) {
            this.$emit("secondaryFilterChange", value);
        },
        onTabSwitch(value: string) {
            this.$emit("tabSwitch", value);
        },
    },
};
</script>
