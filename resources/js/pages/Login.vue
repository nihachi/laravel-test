<template>
  <div class="form-wrapper">
    <div class="container">
      <form
        class="border border-light p-5 w-50 m-auto"
        autocomplete="off"
        @submit.prevent="authenticate"
      >
        <p class="h4 mb-4 text-center">Sign in</p>
        <div
          v-if="authError"
          class="alert alert-danger alert-dismissible"
          role="alert"
        >
          <span>{{ authError.error }}</span>
        </div>
        <div class="form-group">
          <input
            v-model="form.email"
            class="form-control"
            type="email"
            name="email"
            placeholder="Email"
          />
        </div>
        <div class="form-group">
          <input
            v-model="form.password"
            class="form-control"
            type="password"
            placeholder="Password"
            name="password"
          />
        </div>
        <button class="btn btn-info btn-block my-4" type="submit">
          Sign in
        </button>
      </form>
    </div>
  </div>
</template>

<script>
import { login } from "../services/auth";

export default {
  name: "Login",
  data() {
    return {
      form: {
        email: "",
        password: "",
      },
    };
  },
  computed: {
    authError() {
      return this.$store.getters["auth/authError"];
    },
  },
  methods: {
    authenticate() {
      this.$store.dispatch("auth/login");

      login(this.form)
        .then((response) => {
          this.$store.commit("auth/LOGIN_SUCCESS", response);
          this.$router.push({ path: "/" });
        })
        .catch((error) => {
          this.$store.commit("auth/LOGIN_FAILED", error);
        });
    },
  },
};
</script>
