<template>
  <v-app id="inspire">
    <default-bar />

    <v-main>
      <v-container
        class="py-8 px-6"
        fluid
      >
        <router-view />

      </v-container>
    </v-main>
  </v-app>
</template>

<script setup>
import DefaultBar from './AppBar.vue'
</script>
