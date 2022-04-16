<template>
  <v-row justify="center">
    <v-col cols="12" class="pa-0" md="5">
      <v-container fill-height fluid class="bg-white">
        <div style="width: 60%" class="mx-auto">
          <div class="mb-10">
            <h1 title="Login" class="mb-0">Login</h1>
            <p class="muted--text">Please login to continue</p>

            <v-alert v-if="undefined != err.message" type="error" class="mb-8" outlined dense>{{
              err.message
            }}</v-alert>
          </div>
          <form @submit.prevent="loginSubmit">
            <div class="mb-3">
              <v-text-field
                type="email"
                outlined
                label="Username"
                hide-details
                prepend-inner-icon="mdi-account"
                class="dt-text-field"
                v-model="email"
                required
              ></v-text-field>
            </div>
            <div>
              <v-text-field
                type="password"
                outlined
                label="Password"
                hide-details
                prepend-inner-icon="mdi-lock"
                class="dt-text-field"
                v-model="password"
                required
              ></v-text-field>
            </div>
            <div class="text-right mb-5">
              <small class="muted--text">Forgot Password</small>
            </div>
            <div class="text-center">
              <v-btn block x-large color="primary" exact type="submit">
                <span v-text="'Login'"></span>
              </v-btn>
            </div>
          </form>
        </div>
      </v-container>
    </v-col>
    <v-col cols="7" class="pa-0 d-none d-md-block pa-0">
      <v-img height="100%" :src="loginImg"></v-img>
    </v-col>
  </v-row>
</template>

<script>
import loginImg from "@/assets/login-page-cover-photo.jpg";
import hondaLogo from "@/assets/honda_logo.png";
import { mapGetters, mapActions } from "vuex";

export default {
  data() {
    return {
      loginImg,
      hondaLogo,
      email: null,
      password: null,
    };
  },
  computed: {
    ...mapGetters({
      err: "auth/GET_ERR",
    }),
  },
  mounted() {
    if (localStorage.user) {
      this.$router.push({
        name: "dashboard",
      });
    }
  },
  methods: {
    ...mapActions({
      authLogin: "auth/login",
    }),
    async loginSubmit() {
      await this.authLogin({
        email: this.email,
        password: this.password,
      });

      if (!this.err.message) {
        this.$router.push({
          name: "dashboard",
        });
      }
    },
  },
};
</script>

<style lang="scss" scoped>
.btnLogin {
  background-color: #00aad8 !important;
  color: white !important;
}

.bg-white {
  background: #fff !important;
}
</style>
