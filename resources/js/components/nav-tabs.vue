<template>
  <ul class="nav nav-tabs">
    <li v-for="nav in navs" class="nav-item">
        <router-link class="nav-link" activeClass="active" :to="nav.to">
            {{ nav.label }}
        </router-link>
    </li>
</ul>
</template>

<script lang="ts">
import { RouterLink } from 'vue-router';

interface NavProps {
  label: string;
  to: string;
}

export default {
  name: "NavTabs",
  props: {
      navs: {
          type: Array<NavProps>,
          required: false,
          default: [],
      },
  },
  components: {
      RouterLink,
  },
};
</script>
