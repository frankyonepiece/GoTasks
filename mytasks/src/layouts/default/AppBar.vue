<template>
  <v-navigation-drawer color="teal-lighten-5 border-none" v-model="drawer" :width="350">

    <v-list class="pl-4 pt-8" v-if="user.firstname">
      <v-list-item class="pb-8" prepend-avatar="https://cdn.vuetifyjs.com/images/john.jpg" :title="`${user.firstname} ${user.lastname}`"
        :subtitle="user.email">
        <template v-slot:append>
          <v-menu location="bottom">
            <template v-slot:activator="{ props }">
              <v-btn icon="mdi-dots-vertical" variant="text" v-bind="props"></v-btn>
            </template>

            <v-list width="200">
              <v-list-item title="Logout" link append-icon="mdi-logout" @click="logout()"></v-list-item>
            </v-list>
          </v-menu>
        </template>
      </v-list-item>
      <v-list-item rounded="xl" v-for="[icon, text] in links" :key="icon" :prepend-icon="icon" :title="text" link></v-list-item>
    </v-list>
    <div class="w-100 pl-4" v-else>
      <v-skeleton-loader color="transparent" type="list-item-avatar"></v-skeleton-loader>
    </div>
  </v-navigation-drawer>
</template>


<script>
  import { mapGetters, mapActions } from "vuex";
  import { ref } from 'vue'

  // const drawer = ref(null)
  export default {
    data: () => ({
      cards: ['Today', 'Yesterday'],
      links: [
        ['mdi-white-balance-sunny', 'Today'],
        ['mdi-star-outline', 'Importent'],
        ['mdi-calendar-text-outline', 'Planned'],
        ['mdi-progress-check', 'Tasks'],
      ],
      drawer: ref(null)
    }),
    computed: {
      ...mapGetters({ user: 'StateUser' })
    },
    methods: {
      ...mapActions(["LogOut"]),
      async logout () {
        await this.LogOut();
        this.$router.push({ name: 'Login' });
      }
    }
  }

</script>
