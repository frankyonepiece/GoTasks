<template>
  <div>
    <v-img
      class="mx-auto my-6"
      max-width="120"
      src="../../assets/logo.png"
    ></v-img>

    <v-card
      class="mx-auto pa-12 pb-8 text-left"
      elevation="8"
      max-width="448"
      rounded="lg"
    >
      <v-form v-model="form" @submit.prevent="onSubmit">
      <div class="text-subtitle-1 text-medium-emphasis text-left">Account</div>
      <v-text-field
        v-model="email"
        :readonly="loading"
        :rules="emailRules"
        clearable
        density="compact"
        placeholder="Email address"
        prepend-inner-icon="mdi-email-outline"
        variant="outlined"
      ></v-text-field>

      <div class="text-subtitle-1 text-medium-emphasis d-flex align-center justify-space-between">
        Password
      </div>

      <v-text-field
        v-model="password"
        :readonly="loading"
        :rules="[required]"
        clearable

        :append-inner-icon="visible ? 'mdi-eye-off' : 'mdi-eye'"
        :type="visible ? 'text' : 'password'"
        density="compact"
        placeholder="Enter your password"
        prepend-inner-icon="mdi-lock-outline"
        variant="outlined"
        @click:append-inner="visible = !visible"
      ></v-text-field>

      <p v-if="showError" class="mb-3" id="error">Username or Password is incorrect</p>

      <v-btn
        :disabled="!form"
        :loading="loading"
        block
        class="mb-8"
        color="blue"
        size="large"
        variant="tonal"
        type="submit"
      >
        Log In
      </v-btn>

      <v-card-text class="text-center">
        <router-link to="register"
          class="text-blue text-decoration-none">
          Sign up now <v-icon icon="mdi-chevron-right"></v-icon>
        </router-link>
      </v-card-text>

      </v-form>
    </v-card>
  </div>
</template>

<script>
  import { mapActions } from "vuex";

  export default {
    data: () => ({
      form: false,
      email: null,
      password: null,
      loading: false,
      visible: false,
      showError: false,
      emailRules: [
        value => {
          if (value) return true
          return 'E-mail is requred.'
        },
        value => {
          if (/.+@.+\..+/.test(value)) return true
          return 'E-mail must be valid.'
        },
      ],
    }),
    methods: {
      ...mapActions(["LogIn"]),
      async onSubmit() {
        if (!this.form) return
        this.loading = true

        const User = new FormData();
        User.append("email", this.email);
        User.append("password", this.password);
        try {
          await this.LogIn(User);
          this.$router.push({ name: 'Home' });
          this.showError = false
        } catch (error) {
          this.showError = true
        }
        this.loading = false
      },
      required (v) {
        return !!v || 'Field is required'
      },
    },
  }
</script>
