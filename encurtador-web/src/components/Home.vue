<template>
  <v-container align="center" class="mt-10" style="background-color: rgb(241, 241, 241); height: 100%;">
    <div class="card-list">
      <v-card class="card stats-card" flat style="background-color: rgb(241, 241, 241)">
        <v-card-title align="left" class="stats-title" style="color: rgb(129, 128, 127);"><h3>Stats</h3></v-card-title>
        <v-row>
          <v-col cols="6">
            <div class="d-flex align-center">
              <v-icon class="mdi mdi-paperclip stats-icon"></v-icon>
              <div class="d-flex flex-column ml-2">
                <div class="stats-number gray-text">{{ orderedItemList.length }}</div>
                <div class="stats-description gray-text">Links</div>
              </div>
            </div>
          </v-col>
          <v-col cols="6">
            <div class="d-flex align-center">
              <v-icon class="mdi mdi-eye stats-icon"></v-icon>
              <div class="d-flex flex-column ml-2">
                <div class="stats-number gray-text">{{ getTotalViews() }}</div>
                <div class="stats-description gray-text">Views</div>
              </div>
            </div>
          </v-col>
        </v-row>
      </v-card>

      <v-card class="card order-card" flat style="background-color: rgb(241, 241, 241)">
        <v-card-actions class="justify-end">
          <v-btn @click="toggleOrderBy('views')" outlined>
            <v-icon left>{{ orderBy === 'views' ? (reverseOrder ? 'mdi-sort-ascending' : 'mdi-sort-descending') : 'mdi-sort' }}</v-icon>
            {{ orderBy === 'views' ? (reverseOrder ? '9' : '1') : 'Views' }}
          </v-btn>
          <v-btn @click="toggleOrderBy('alphabet')" outlined>
            <v-icon left>{{ orderBy === 'alphabet' ? (reverseOrder ? 'mdi-sort-ascending' : 'mdi-sort-descending') : 'mdi-sort' }}</v-icon>
            {{ orderBy === 'alphabet' ? (reverseOrder ? 'ZA' : 'AZ') : 'Alphabet' }}
          </v-btn>
        </v-card-actions>
      </v-card>

      <v-card v-for="(item, index) in orderedItemList" :key="index" class="card" v-if="orderedItemList.length > 0">
        <v-row>
          <v-col cols="6" align="left">
            <v-card-title class="url-title">{{ item.url }}</v-card-title>
            <v-card-subtitle class="link-subtitle">
              <a :href="generateLink(item.slug)" class="link">{{ 'localhost:5173/' + item.slug }}</a>
            </v-card-subtitle>
          </v-col>
          <v-col cols="6">
            <v-card-actions class="icons-actions mt-3">
              <div style="font-size: 12px;">
                <span style="color:grey;" class="view-count">{{ item.views_count }}</span>
                <v-icon class="mdi mdi-chart-bar mr-3" color="grey"></v-icon>
              </div>
              <v-icon @click="editItem(index)" class="edit-icon" color="grey">mdi-pencil</v-icon>
              <v-icon @click="deleteItem(item.id, index)" class="delete-icon" color="grey">mdi-delete</v-icon>
            </v-card-actions>
          </v-col>
        </v-row>
      </v-card>
      <v-card class="card" v-else>
        <v-card-text>No results found.</v-card-text>
      </v-card>
    </div>

    <v-dialog v-model="editDialog" max-width="600">
      <v-card>
        <v-card-title>{{ editMode ? 'Edit Link' : 'Add Link' }}</v-card-title>
        <v-card-text>
          <v-form @submit.prevent="saveLink">
            <v-text-field v-model="formData.url" label="URL"></v-text-field>
            <v-text-field v-model="formData.slug" label="Slug"></v-text-field>
            <v-btn type="submit">{{ editMode ? 'Save' : 'Add' }}</v-btn>
          </v-form>
        </v-card-text>
      </v-card>
    </v-dialog>
  </v-container>
</template>

<script>
import axios from 'axios';

export default {
  data() {
    return {
      itemList: [],
      orderBy: 'views',
      reverseOrder: false,
      editDialog: false,
      editMode: false,
      formData: {
        id: null,
        url: '',
        slug: '',
      },
    };
  },
  mounted() {
    this.fetchDataFromAPI();
  },
  computed: {
    orderedItemList() {
      const filteredList = !this.$route.query?.search
        ? this.itemList
        : this.itemList.filter(
            (item) =>
              item.slug.toLowerCase().includes(this.$route.query.search.toLowerCase()) ||
              item.url.toLowerCase().includes(this.$route.query.search.toLowerCase())
          );

      const orderedList = [...filteredList].sort((a, b) => {
        const factor = this.reverseOrder ? -1 : 1;
        if (this.orderBy === 'views') {
          return factor * (b.views_count - a.views_count);
        } else if (this.orderBy === 'alphabet') {
          return factor * a.url.localeCompare(b.url);
        } else {
          return 0;
        }
      });

      return orderedList;
    },
  },
  methods: {
    async fetchDataFromAPI() {
      try {
        const response = await axios.get('http://127.0.0.1:8000/api/links');
        this.itemList = response.data;
      } catch (error) {
        console.error('Error fetching data from API:', error);
      }
    },
    toggleOrderBy(orderType) {
      if (this.orderBy === orderType) {
        this.reverseOrder = !this.reverseOrder;
      } else {
        this.orderBy = orderType;
        this.reverseOrder = false;
      }
    },
    getTotalViews() {
      return this.orderedItemList.reduce((totalViews, item) => totalViews + item.views_count, 0);
    },
    editItem(index) {
      const item = this.orderedItemList[index];
      this.editMode = true;
      this.formData.id = item.id;
      this.formData.url = item.url;
      this.formData.slug = item.slug;
      this.editDialog = true;
    },
    async saveLink() {
      try {
        const response = await axios.put(`http://127.0.0.1:8000/api/links/${this.formData.id}`, this.formData);
        this.editDialog = false;
        this.fetchDataFromAPI();
        this.clearFormData();
        location.reload();
      } catch (error) {
        console.error('Error saving link:', error);
      }
    },
    clearFormData() {
      this.formData.id = null;
      this.formData.url = '';
      this.formData.slug = '';
      this.editMode = false;
    },
    async deleteItem(id, index) {
      try {
        await axios.delete(`http://127.0.0.1:8000/api/links/${id}`);
        this.itemList.splice(index, 1);
        location.reload();
      } catch (error) {
        console.error('Error deleting link:', error);
      }
    },
    generateLink(slug) {
      return 'http://localhost:5173/' + slug;
    },
  },
};
</script>



<style scoped>
.card-list {
  display: flex;
  flex-direction: column;
  max-width: 1200px;
}

.card {
  margin-bottom: 10px;
}

.url-title {
  font-size: 18px;
}

.link-subtitle {
  font-size: 14px;
}

.link {
  color: blue;
  text-decoration: none;
}

.icons-actions {
  display: flex;
  justify-content: flex-end;
}

.edit-icon,
.delete-icon {
  cursor: pointer;
  margin-left: 10px;
  font-size: 20px;
}

.stats-card {
  padding: 20px;
  text-align: center;
  border-bottom: 1px solid rgb(129, 128, 127);
  margin-bottom: 20px;
}

.stats-title {
  font-size: 20px;
  font-weight: bold;
}

.stats-icon {
  font-size: 24px;
  margin-right: 10px;
}

.stats-number {
  font-size: 24px;
  font-weight: bold;
}

.stats-description {
  font-size: 14px;
}

.gray-text {
  color: #888;
}

.order-card {
  padding: 10px;
  text-align: right;
  margin-bottom: 10px;
}

.order-card .v-btn {
  margin: 5px;
}
</style>
