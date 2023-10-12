<template>
  <v-list-item class="mb-2 border-md px-2" v-if="task.completed == true">
    <template v-slot:prepend>
      <v-checkbox-btn v-model="task.completed"></v-checkbox-btn>
    </template>

    <router-link class="text-decoration-none text-black" :to="{ name: 'tasks.edit', params: { id: task.id } }">
      <v-list-item-title>
        {{ task.title }}
      </v-list-item-title>
    </router-link>

    <template v-slot:append>
      <router-link class="text-decoration-none text-black" :to="{ name: 'tasks.edit', params: { id: task.id } }">
        <v-icon icon="mdi-chevron-right"></v-icon>
      </router-link>
    </template>
  </v-list-item>
</template>

<script>
export default {
  props: {
    task: {},
  }
}
</script>
