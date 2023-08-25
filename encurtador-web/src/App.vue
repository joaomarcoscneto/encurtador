<template>
  <v-layout class="rounded rounded-md">
    <v-main class="d-flex align-center justify-center"  style="min-height: 300px;">
      <RouterView />
    </v-main>
  </v-layout>
</template>


<script>
export default {
  data() {
    return {
      search: ''
    };
  },
  methods: {
    addLink() {
      // Lógica para adicionar um novo link
    }
  }
};
</script>
