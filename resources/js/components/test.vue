<template>


  <!-- <span class="imgSpanLogo"> -->
  <!-- <img :src="'https://www.ag-grid.com/example-assets/software-company-logos/' + cellValueLowerCase + '.svg'" class="logo" /> -->
  <!-- <img src='/public/assets/images/logo-light.png' class=" logo" width="32" />
  </span> -->

  <div class="d-flex gap-2 align-items-center">
    <div class="flex-shrink-0">
      <img src="/public/assets/images/users/avatar-3.jpg" alt="" class="avatar-xs rounded-circle border">
    </div>
    <div class="overflow-hidden">
      {{ cellValue }}

    </div>
    <!-- <div class="flex-grow-1">
      <a class="link-secondary text-body text-lowercase" href="javascript:void(0)" @click="userSelected(item.username, item.id)">{{ item.username }}</a>
    </div> -->
  </div>


</template>

<script>
export default {
  name: 'XpplAppTest',

  data() {
    return {
      cellValue: '',
      cellValueLowerCase: '',
    };
  },

  beforeMount() {
    this.cellValue = this.params.value;
    this.cellValueLowerCase = this.params.value.toLowerCase();
  },

  mounted() {

  },

  methods: {

  },
};
</script>