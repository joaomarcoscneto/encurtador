<template>
  <div>

  </div>
</template>

<script>
import axios from 'axios';
export default {
  name: 'Redirect',
  mounted() {
    const slug = this.$route.params.slug;
    this.redirectToLink(slug);
  },
  methods: {
    async redirectToLink(slug) {
      try {
        const response = await axios.get(`http://127.0.0.1:8989/api/links/${slug}/by-slug`);
        const link = response.data;

        await axios.post(`http://127.0.0.1:8989/api/links/${link.id}/access`);
        window.location.href = link.url;
      } catch (error) {
        console.error('Error redirecting to link:', error);
      }
    },
  },
};
</script>
