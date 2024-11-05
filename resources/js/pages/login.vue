<template>
  <div>
    <div class="auth-page-wrapper pt-5">
      <div class="auth-one-bg-position auth-one-bg" id="auth-particles">
        <div class="bg-overlay"></div>

        <div class="shape">
          <svg xmlns="http://www.w3.org/2000/svg" version="1.1" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 1440 120">
            <path d="M 0,36 C 144,53.6 432,123.2 720,124 C 1008,124.8 1296,56.8 1440,40L1440 140L0 140z"></path>
          </svg>
        </div>
        <canvas class="particles-js-canvas-el" width="1394" height="380" style="width: 100%; height: 100%;"></canvas>
      </div>

      <div class="auth-page-content">
        <div class="container">
          <div class="row">
            <div class="col-lg-12">
              <div class="text-center mt-sm-5 mb-4 text-white-50">
                <div>
                  <a href="index.html" class="d-inline-block auth-logo">
                    <img src="/public/assets/images/logo-light.png" alt="" height="50">
                  </a>
                </div>
                <p class="mt-3 fs-15 fw-medium">Xekong Power Plant Co,.Ltd</p>
              </div>
            </div>
          </div>

          <div class="row justify-content-center">
            <div class="col-md-8 col-lg-6 col-xl-5">
              <div class="card mt-4 card-bg-fill">

                <div class="card-body p-4">
                  <div class="text-center mt-2">
                    <h5 class="text-primary">Welcome Back !</h5>
                    <p class="text-muted">Sign in to continue to xppl web application.</p>
                  </div>
                  <div class="p-2 mt-4">

                    <div class="mb-3">
                      <label for="email" class="form-label text-capitalize">{{ $t('email') }}</label>
                      <input type="text" class="form-control" id="email" :placeholder="$t('enter') + $t('email')" v-model="email">
                      <div v-if="errors && errors.email" class="text-danger fs-12"> {{ errors.email[0] }} </div>
                      <div v-if="incorrect" class="text-danger fs-12">Incorrect name or password</div>
                    </div>
                    <div class="mb-3">
                      <!-- <div class="float-end">
                        <a href="#" class="text-muted">Forgot password?</a>
                      </div> -->
                      <label class="form-label text-capitalize" for="password-input">{{ $t('password') }}</label>
                      <div class="position-relative auth-pass-inputgroup">
                        <input type="password" class="form-control pe-5 password-input" :placeholder="$t('enter') + $t('password')" id="password-input" v-model="password" @keydown.enter="login()">
                        <button class="btn btn-link position-absolute end-0 top-0 text-decoration-none text-muted password-addon" type="button" id="password-addon" @click="store.showPassword('#password-input')"><i class="ri-eye-fill align-middle"></i></button>
                        <div v-if="errors && errors.password" class="text-danger fs-12"> {{ errors.password[0] }} </div>
                        <div v-if="incorrect" class="text-danger fs-12">Incorrect name or password</div>
                      </div>
                    </div>
                    <div class="form-check">
                      <input class="form-check-input" type="checkbox" value="" id="auth-remember-check" v-model="rememberMe">
                      <label class="form-check-label" for="auth-remember-check">{{ $t('remember-me') }}</label>
                    </div>
                    <div class="mt-4 mb-4">
                      <button type="button" class="btn btn-success w-100" @click="login()">Login</button>
                    </div>
                  </div>
                </div>
              </div>
              <div class="mt-4 text-center">
                <p class="mb-0">Don't have an account ? <router-link to="/register" class="fw-semibold text-primary text-decoration-underline">Register</router-link> </p>
              </div>
            </div>
          </div>
        </div>
      </div>
      <footer class="footer">
        <div class="container">
          <div class="row">
            <div class="col-lg-12">
              <div class="text-center">
                <p class="mb-0 text-muted">©
                  2022 XPPL <i class="mdi mdi-heart text-danger"></i> by Chamlong.K
                </p>
              </div>
            </div>
          </div>
        </div>
      </footer>
    </div>
  </div>
</template>

<script>
import axios from 'axios';
import { useStore } from '../stores/store.js';
import { useAuthStore } from '../stores/auth.js';
import { useToastr } from '../toastr.js';
const toastr = useToastr();

export default {
  name: 'XpplAppLogin',
  setup() {
    const store = useStore();
    const authStore = useAuthStore();
    return { store, authStore };
  },

  data() {
    return {
      email: '',
      password: '',
      rememberMe: '',
      errors: '',
      incorrect: '',
    };
  },

  mounted() {

  },

  methods: {
    login() {
      this.errors = '';
      this.incorrect = '';

      axios.post('api/login', {
        email: this.email,
        password: this.password
      }).then((response) => {
        if (response.data.success) {
          toastr.success('Signin successfully!');

          localStorage.setItem('token', response.data.token);
          localStorage.setItem('user', JSON.stringify(response.data.loginData));
          this.rememberMe == true ? localStorage.setItem('remember-me', this.email) : localStorage.removeItem('remember-me');
          this.$router.push('/')

        } else {
          this.incorrect = 'err';
        }
      }).catch((error) => {
        if (error.response && error.response.status === 422) {
          this.errors = error.response.data.errors;
        }
      });
    },
  },

  created() {
    localStorage.getItem('remember-me') ? (this.email = localStorage.getItem('remember-me'), this.rememberMe = true) : '';
  }
};
</script>