<template>
  <v-app-bar app color="white" class="pt-4" elevation="0">
    <v-row align="center">
      <v-col cols="4" class="text-center">
        <v-toolbar-title class="align-center">Encurtador</v-toolbar-title>
      </v-col>
      <v-col cols="4" class="d-flex justify-center align-center">
        <v-icon class="mr-2">mdi-magnify</v-icon>
        <v-text-field v-model="search" @keydown.enter="performSearch" placeholder="Pesquisar por slug ou url" outlined dense />
        <v-btn icon @click="openAddLinkDialog" class="ml-2">
          <v-icon>mdi-plus</v-icon>
        </v-btn>
      </v-col>
    </v-row>

    <v-dialog v-model="addLinkDialog" max-width="500px">
      <v-card>
        <v-card-title class="headline">Adicionar Link</v-card-title>
        <v-card-text>
          <v-form @submit.prevent="submitLink">
            <v-text-field v-model="newLink.url" label="URL" required></v-text-field>
            <v-text-field v-model="newLink.slug" label="Slug" required></v-text-field>
            <v-alert v-if="addError" type="error">{{ addError }}</v-alert>
            <v-btn type="submit" color="primary">Adicionar</v-btn>
            <v-btn @click="closeAddLinkDialog">Cancelar</v-btn>
          </v-form>
        </v-card-text>
      </v-card>
    </v-dialog>
  </v-app-bar>
</template>

<script>
import axios from 'axios';
export default {
  data() {
    return {
      search: '',
      addLinkDialog: false,
      newLink: {
        url: '',
        slug: '',
      },
      addError: '',
    };
  },
  methods: {
    performSearch() {
      this.$router.push({ path: '/', query: { search: this.search } });
    },
    openAddLinkDialog() {
      this.addLinkDialog = true;
    },
    closeAddLinkDialog() {
      this.addLinkDialog = false;
      this.newLink.url = '';
      this.newLink.slug = '';
      this.addError = '';
    },
    async submitLink() {
      this.addError = ''; // Clear previous error message
      try {
        const response = await axios.post('http://127.0.0.1:8000/api/links', this.newLink);
        this.closeAddLinkDialog(); // Close the dialog after successful addition
        window.location.href = '/?search=' + encodeURIComponent(response.data.slug);
      } catch (error) {
        this.addError = 'Erro ao adicionar o link. Verifique os dados e tente novamente.';
      }
    },
    // ... your other methods ...
  },
};
</script>

<style scoped>
/* ... your existing styles ... */
</style>
