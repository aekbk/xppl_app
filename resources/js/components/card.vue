<template>
    <div class="card">
        <div class="card-header">
            <h5 class="mb-0 d-inline-block me-3">{{ title }}</h5>
            <p class="mb-0 d-inline">{{ subtitle }}</p>
        </div>
        <div class="card-body d-flex flex-column gap-5">
            <slot></slot>
        </div>
    </div>
</template>

<script lang="ts">

export default {
    name: "Card",
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
    },
};
</script>
