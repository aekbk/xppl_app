import { defineStore } from "pinia";
export const useAuthStore = defineStore('auth', {

  state: () => ({
    token: null,
    user: null
  }),
  getters: {
    getToken: (state) => state.token,
    getUser: (state) => state.user
  },
  actions: {
    setToken(newToken) {
      this.token = newToken
    },
    setUser(newUser) {
      this.user = newUser
    },
    removeToken() {
      this.token = null
    },
    removeUser() {
      this.user = null
    }
  }
})