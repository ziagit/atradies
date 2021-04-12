<template>
  <div class="container">
    <Header v-on:togal-menu="$emit('togal-menu')" />
    <div class="break"></div>
    <div class="break"></div>
    <div class="break"></div>
    <div class="break"></div>
    <div class="content">
      <md-card>
        <p style="font-size: 20px">Perfect! 👌</p>
        <p style="color: green">Your job has been successfully posted!</p>
        <p>Stay in touch, Job seekers near to your location will be contacting soon.</p>
        <p>Do you need other service?</p>
        <md-button to="/" class="md-primary">Yes</md-button>
        <md-button class="md-primary">No</md-button>
        <p>Look at bellow, our most popular categories</p>
      </md-card>
      <div class="category">
        <Category />
      </div>
    </div>
    <Footer />
  </div>
</template>

<script>
import Header from "../../shared/Header";
import Footer from "../../shared/Footer";
import Category from "./Category";
export default {
  name: "Complation",
  data: () => ({}),
  updated() {
    window.location.reload();
  },
  components: {
    Header,
    Footer,
    Category,
  },
};
</script>

<style lang="scss" scoped>
.header {
  .right {
    background: red !important;
    padding-right: 20px !important;
  }
}
.content {
  max-width: 600px;
  min-height: calc(100vh - 96px);
  margin: auto;

  .md-card {
    padding: 20px;
    text-align: center;
  }
  .category {
    padding: 10px 6px;
  }
}
</style>
