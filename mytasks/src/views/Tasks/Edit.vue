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
          Edit Task
        </h2>

        <v-form v-model="form" @submit.prevent="onSubmit">


          <v-text-field v-model="task.title" label="Title" required variant="outlined" ></v-text-field>

          <v-textarea v-model="task.description" label="Description" required  variant="outlined"></v-textarea>

          <v-checkbox v-model="task.completed" label="Completed" type="checkbox"></v-checkbox>

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
import Notify from '@/services/notify';
import { mapGetters , mapActions } from "vuex";

export default {
  data: () => ({
    form: false,
    loading: false,
    task: {
      id: null,
      title: null,
      description: null,
      completed: null,
    }
  }),
  inject: ["tasks"],
  created() {
    const id = this.$route.params.id;
    const task = this.tasks.find(task => task.id == id);
    if (task) {
      this.task = task;
    }
  },
  computed: {
    ...mapGetters({ tasks: "StateTasks" }),
  },
  methods: {
    ...mapActions(["EditTask"]),
    async onSubmit() {
      const vm = this;
      if (!vm.form) return
        vm.loading = true

        const task = {
          title: vm.task.title,
          description: vm.task.description,
          completed: vm.task.completed,
        };


        try {
          await vm.EditTask({ task, id: vm.task.id })
          .then((data) => {
            Notify.success('Task Updated successfully');
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
