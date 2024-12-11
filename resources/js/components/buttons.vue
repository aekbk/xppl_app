<template>

  <div class="d-flex gap-sm-0 email-topbar-link align-items-center">
    <!-- <button class="btn btn-sm btn-soft-info" id="btn-new" @click="newSampleTicket"><i class="ri-add-fill me-1 align-bottom"></i>New</button> -->
    <!-- <button type="button" class="btn btn-ghost-secondary btn-icon btn-sm material-shadow-none">
      <i class="bx bx-plus-circle align-bottom fs-18"></i>
    </button> -->

    <button type="button" class="btn btn-ghost-secondary btn-icon btn-sm material-shadow-none mt-1" @click="EditClick">
      <i class="bx bx-edit align-bottom fs-18"></i>
    </button>
    <button type="button" class="btn btn-ghost-secondary btn-icon btn-sm material-shadow-none mt-1" @click="DelClick">
      <i class="bx bx-trash align-bottom fs-18"></i>
    </button>

    <!-- <div class="dropdown">
      <button class="btn btn-ghost-secondary btn-icon btn-sm material-shadow-none" type="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        <i class="bx bx-dots-vertical-rounded align-bottom fs-18"></i>
      </button>
      <div class="dropdown-menu dropdown-menu-end">
        <a class="dropdown-item" href="#">Mark as Unread</a>
        <a class="dropdown-item" href="#">Mark as Important</a>
        <a class="dropdown-item" href="#">Add to Tasks</a>
        <a class="dropdown-item" href="#">Add Star</a>
        <a class="dropdown-item" href="#">Mute</a>
      </div>
    </div> -->
  </div>



</template>

<script>
export default {
  name: 'XpplAppButtons',

  data() {
    return {
      cellValue: '',
    };
  },

  beforeMount() {
    this.cellValue = this.params.value;
    this.cellValueLowerCase = this.params.value.toLowerCase();
  },

  mounted() {

  },

  methods: {

    EditClick() {
      alert(this.params)
      console.log(this.params.data);

    },

    DelClick() {
      alert(this.cellValue)
    }


  },
};
</script>