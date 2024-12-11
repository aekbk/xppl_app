<template>
  <div>

    <div class="auth-page-wrapper pt-5">
      <!-- auth page bg -->
      <div class="auth-one-bg-position auth-one-bg" id="auth-particles">
        <div class="bg-overlay"></div>

        <div class="shape">
          <svg xmlns="http://www.w3.org/2000/svg" version="1.1" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 1440 120">
            <path d="M 0,36 C 144,53.6 432,123.2 720,124 C 1008,124.8 1296,56.8 1440,40L1440 140L0 140z"></path>
          </svg>
        </div>
        <canvas class="particles-js-canvas-el" width="1394" height="380" style="width: 100%; height: 100%;"></canvas>
      </div>

      <!-- auth page content -->
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
          <!-- end row -->

          <div class="row justify-content-center">
            <div class="col-md-8 col-lg-6 col-xl-5">
              <div class="card mt-4 card-bg-fill">

                <div class="card-body p-4">
                  <div class="text-center mt-2">
                    <h5 class="text-primary">Create New Account</h5>
                    <p class="text-muted">Get your free xppl web application account now</p>
                  </div>
                  <div class="p-2 mt-4">

                    <div class="mb-3">
                      <label for="useremail" class="form-label text-capitalize">Email</label>
                      <input type="text" class="form-control" id="useremail" placeholder="Enter email address" v-model="email">
                      <div v-if="errors && errors.email" class="text-danger fs-12"> {{ errors.email[0] }} </div>
                      <div v-if="incorrect" class="text-danger fs-12"> Incorrect name or password </div>
                      <div v-if="check" class="text-danger fs-12"> {{ check }} </div>
                    </div>
                    <div class="mb-3">
                      <label class="form-label text-capitalize" for="password-input">{{ $t('password') }}</label>
                      <div class="position-relative auth-pass-inputgroup">
                        <input type="password" class="form-control pe-5 password-input" :placeholder="$t('enter') + $t('password')" id="password-input2" v-model="password">
                        <button class="btn btn-link position-absolute end-0 top-0 text-decoration-none text-muted password-addon" type="button" id="password-addon" @click="store.showPassword('#password-input2')"><i class="ri-eye-fill align-middle"></i></button>
                        <div v-if="errors && errors.password" class="text-danger fs-12"> {{ errors.password[0] }} </div>
                        <div v-if="incorrect" class="text-danger fs-12">Incorrect name or password</div>
                      </div>
                    </div>
                    <div class="mb-3">
                      <label class="form-label text-capitalize" for="password-input">{{ $t('confirm-password') }}</label>
                      <div class="position-relative auth-pass-inputgroup">
                        <input type="password" class="form-control pe-5 password-input" :placeholder="$t('confirm-password')" id="password-input-confirm" v-model="password_confirmation" @keydown.enter="register()">
                        <button class="btn btn-link position-absolute end-0 top-0 text-decoration-none text-muted password-addon" type="button" id="password-addon" @click="store.showPassword('#password-input-confirm')"><i class="ri-eye-fill align-middle"></i></button>
                        <div v-if="errors && errors.password" class="text-danger fs-12"> {{ errors.password[0] }} </div>
                        <div v-if="incorrect" class="text-danger fs-12">Incorrect name or password</div>
                      </div>
                    </div>

                    <div class="mt-4 mb-4">
                      <button type="button" class="btn btn-success w-100" @click="register()">Register</button>
                    </div>

                  </div>
                </div>
              </div>

              <div class="mt-4 text-center">
                <p class="mb-0">Already have an account ? <router-link to="/login" class="fw-semibold text-primary text-decoration-underline">Login</router-link> </p>
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
import { useToastr } from '../toastr.js';
const toastr = useToastr();

export default {
  name: 'XpplAppRegister',
  setup() {
    const store = useStore();
    return { store };
  },

  data() {
    return {
      email: '',
      password: '',
      password_confirmation: '',
      errors: '',
      incorrect: '',
      check: ''
    };
  },

  mounted() {

  },

  methods: {
    async register() {
      this.errors = '';
      this.incorrect = '';
      this.check = '';

      try {
        const response = await axios.post('api/register', {
          email: this.email,
          password: this.password,
          password_confirmation: this.password_confirmation
        });

        if (response.data.success) {
          localStorage.setItem('remember-me', this.email);
          this.$router.push('/login');
          toastr.success('Sign up succesfully!');
        } else {
          this.check = response.data.message;
        }
      } catch (error) {
        if (error.response && error.response.status === 422) {
          this.errors = error.response.data.errors;
        }
      }
    },
  },
};
</script>