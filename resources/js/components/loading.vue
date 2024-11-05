<template>
  <div>
    <div class="d-flex align-items-center justify-content-center" style="height: 72vh;">
      <div>
        <div class="text-center" style="width: 57.64px">
          <!-- <div class="spinner-border text-primary" style="width: 3rem; height: 3rem;" role="status" aria-hidden="true"></div> -->
          <div class="ri-loader-2-line fs-36 text-primary" role="status" aria-hidden="true"></div>
        </div>
        <div class="fw-semibold text-danger fs-14">{{ $t('loading') }}</div>
      </div>
    </div>
  </div>
</template>

<style>
.ri-loader-2-line {
  animation: spin 1.2s infinite linear;
}

@keyframes spin {
  0% {
    transform: rotate(0deg);
  }

  100% {
    transform: rotate(360deg);
  }
}
</style>
