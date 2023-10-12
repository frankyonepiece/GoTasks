<template>
  <div>
    <v-img
      class="mx-auto my-6"
      max-width="120"
      src="../../assets/logo.png"
    ></v-img>

    <v-card
      class="mx-auto pa-12 pb-8"
      elevation="8"
      max-width="448"
      rounded="lg"
    >
      <v-form v-model="form" @submit.prevent="onSubmit">

        <v-text-field class="mb-5"
            density="compact"
            placeholder="First name"
            label="First name"
            prepend-inner-icon="mdi-account-outline"
            variant="outlined"
            v-model="firstname"
            :rules="nameRules"
            :counter="10"
            :readonly="loading"
            required hide-details ></v-text-field>

        <v-text-field class="mb-5"
            density="compact"
            placeholder="Last name"
            label="Last name"
            prepend-inner-icon="mdi-account-outline"
            variant="outlined"
            v-model="lastname"
            :rules="nameRules"
            :counter="10"
            :readonly="loading"
            required hide-details ></v-text-field>


        <v-text-field class="mb-5"
          density="compact"
          placeholder="Email address"
          prepend-inner-icon="mdi-email-outline"
          variant="outlined"
          v-model="email"
          :rules="emailRules"
          label="E-mail"
          :readonly="loading"
          hide-details required ></v-text-field>

        <v-text-field class="mb-5"
          :append-inner-icon="visible ? 'mdi-eye-off' : 'mdi-eye'"
          :type="visible ? 'text' : 'password'"
          density="compact"
          placeholder="Enter your password"
          prepend-inner-icon="mdi-lock-outline"
          variant="outlined"
          :readonly="loading"
          @click:append-inner="visible = !visible"
          hide-details required
        ></v-text-field>


        <v-btn
          :disabled="!form"
          :loading="loading"
          type="submit"
          block
          class="mb-8"
          color="blue"
          size="large"
          variant="tonal"
        >
          Register
        </v-btn>
      </v-form>
      <v-card-text class="text-center">
        <router-link to="login"
          class="text-blue text-decoration-none"
          rel="noopener noreferrer">
          Sign-in now <v-icon icon="mdi-chevron-right"></v-icon>
        </router-link>
      </v-card-text>
    </v-card>
  </div>
</template>

<script scope>
  import { mapActions } from "vuex";

  export default {
    data: () => ({
      form: false,
      loading: false,
      visible: false,
      valid: false,
      firstname: '',
      lastname: '',
      nameRules: [
        value => {
          if (value) return true

          return 'Name is required.'
        },
        value => {
          if (value?.length <= 10) return true
          return 'Name must be less than 10 characters.'
        },
      ],
      email: '',
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
      ...mapActions(["Register"]),
      async onSubmit() {
        if (!this.form) return
        this.loading = true

        const User = new FormData();
        User.append("firstname", this.firstname);
        User.append("lastname", this.lastname);
        User.append("email", this.email);
        User.append("password", this.password);

        try {
          await this.Register(User);
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
