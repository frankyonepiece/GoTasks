<template>
  <v-row class="my-5">
    <v-col cols="12">
      <v-card variant="flat">
        <h2 class="font-weight-medium mb-4 text-h4 text-sm-h4">Today </h2>

        <router-link :to="{ name: 'tasks.create' }"
          class="mb-2 border-md text-blue text-decoration-none px-5 py-2 d-inline-block">
            <v-icon icon="mdi-plus mr-2"></v-icon>
            Add New Task
        </router-link>

        <v-list color="bg-transparent" v-if="tasks.length">
          <template v-for="task in tasks" :key="task.id">
            <v-list-item class="mb-2 border-md px-2" v-if="task.completed == false">
              <!-- <template v-slot:prepend>
                <v-checkbox-btn v-model="task.completed"></v-checkbox-btn>
              </template> -->

              <router-link class="text-decoration-none text-black" :to="{ name: 'tasks.edit', params: { id: task.id } }">
                <v-list-item-title class="pl-4">
                  {{ task.title }}
                </v-list-item-title>
              </router-link>

              <template v-slot:append>
                <v-btn class="pa-2" size="xxl" @click="removeTask(task.id)">
                  <v-icon icon="mdi-delete-outline"></v-icon>
                </v-btn>
              </template>
            </v-list-item>
          </template>
        </v-list>
        <div class="w-100" v-else>
          <template v-for="n in 7" :key="n">
            <v-skeleton-loader type="list-item-avatar"></v-skeleton-loader>
          </template>
        </div>
      </v-card>
    </v-col>

    <v-col cols="12" v-if="tasks">
      <v-card variant="flat">
        <h2 class="font-weight-medium mb-4 text-h4 text-sm-h4">Completed </h2>

        <v-list color="bg-transparent">
          <template v-for="task in tasks" :key="task.id">
            <v-list-item class="mb-2 border-md px-2" v-if="task.completed == true">
              <!-- <template v-slot:prepend>
                <v-checkbox-btn v-model="task.completed"></v-checkbox-btn>
              </template> -->

              <router-link class="text-decoration-none text-black" :to="{ name: 'tasks.edit', params: { id: task.id } }">
                <v-list-item-title class="pl-4">
                  {{ task.title }}
                </v-list-item-title>
              </router-link>

              <template v-slot:append>
                <v-btn class="pa-2" size="xxl" @click="removeTask(task.id)">
                  <v-icon icon="mdi-delete-outline"></v-icon>
                </v-btn>
              </template>
            </v-list-item>
          </template>
        </v-list>
      </v-card>
    </v-col>
  </v-row>
</template>

<script>
  import { mapGetters, mapActions } from "vuex";
  import Notify from "@/services/notify";

  export default {
    data () {
      return {
        drawer: null,
      }
    },
    created: function () {
      this.GetTasks()
    },
    computed: {
      ...mapGetters({ tasks: "StateTasks" }),
    },
    methods: {
      ...mapActions(["GetTasks", "deleteTask"]),
      async removeTask(id) {
        try {
          await this.deleteTask(id)
          .then(() => {
            Notify.success('Task Deleted successfully');
          });
        } catch (error) {
          console.log(error);
        }
      }
    }


  }
</script>
