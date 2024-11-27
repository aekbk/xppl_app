<template>
  <div class="card">
      <div class="card-header">
        <h5 class="mb-0 d-inline-block me-3">{{ title }}</h5>
        <p class="mb-0 d-inline">{{ subtitle }}</p>
      </div>
      <div class="card-body">
        <div class="row text-center">
          <div 
            class="col-md-3" 
            v-for="(stat, index) in stats" 
            :key="index"
          >
            <div class="icon">
              <img :src="stat.icon" :alt="stat.label" width="64">
            </div>
            <p class="mb-2 text-primary">{{ stat.label }}</p>
            <p class="text-primary fs-3">{{ stat.value }}<span v-if="stat.unit" class="fs-6 d-inline-block ms-2 align-middle">{{stat.unit}}</span></p>
          </div>
        </div>
      </div>
    </div>
</template>

<script>
export default {
  name: "SummaryStatistic",
  props: {
    title: {
      type: String,
      required: true,
    },
    subtitle: {
      type: String,
      required: false,
      default: "",
    },
    stats: {
      type: Array,
      required: true,
      default: () => [],
    },
  },
};
</script>

<style scoped>
.icon {
  margin-bottom: 10px;
}
</style>
