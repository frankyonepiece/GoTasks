<template>
  <v-row class="my-5">
    <v-col cols="8">
      <v-card variant="flat">
        <router-link :to="{ name: 'Home' }"
          class="mb-2 text-blue text-decoration-none py-2 d-inline-block mb-4">
          <v-icon icon="mdi-chevron-left mr-2"></v-icon>
          Back to Tasks
        </router-link>
        <h2 class="font-weight-medium mb-10 text-h4 text-sm-h4">
          Add New Task
        </h2>

        <v-form v-model="form" @submit.prevent="onSubmit">
          <v-text-field v-model="title" label="Title" required variant="outlined" ></v-text-field>

          <v-textarea v-model="description" label="Description" required  variant="outlined"></v-textarea>

          <v-checkbox v-model="completed" label="Completed" type="checkbox"></v-checkbox>


          <div class="text-right">
            <v-btn
              :disabled="!form"
              :loading="loading"
              class="mb-8 px-12"
              color="blue"
              size="large"
              variant="tonal"
              type="submit"
            >
              Save
            </v-btn>
          </div>

        </v-form>
      </v-card>
    </v-col>
  </v-row>
</template>

<script>
import { mapActions } from "vuex";
import Notify from "@/services/notify";

export default {
  data: () => ({
    form: false,
    title: null,
    description: null,
    completed: false,
    loading: false,
  }),
  methods: {
    ...mapActions(["CreateTask"]),
    async onSubmit() {
      const vm = this;
      if (!vm.form) return
        vm.loading = true

        const task = new FormData();
        task.append("title", vm.title);
        task.append("description", vm.description);
        task.append("completed", vm.completed);
        try {
          await vm.CreateTask(task)
          .then((data) => {
            Notify.success('Task Created successfully');
            vm.$router.push({ name: 'Home' });
            vm.showError = false
          });
        } catch (error) {
          vm.showError = true
        }
        vm.loading = false
    },
    required(v) {
      return !!v || "Field is required";
    },
  },
};
</script>
