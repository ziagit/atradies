<template>
  <div class="container">
    <Header v-on:togal-menu="$emit('togal-menu')" />
    <div class="content">
      <div class="row progress-bar">
        <radial-progress-bar
          :diameter="120"
          :completed-steps="completedSteps"
          :total-steps="totalSteps"
          innerStrokeColor="#F0F2F5"
          startColor="#448aff"
          stopColor="#0f57d0"
        >
          <p style="font-weight: bold">{{ percentage }}%</p>
        </radial-progress-bar>
      </div>
      <div class="break"></div>
      <div class="break"></div>
      <div class="row inputs">
        <router-view v-on:progress="progress"></router-view>
      </div>
    </div>
    <Footer />
  </div>
</template>

<script>
import RadialProgressBar from "vue-radial-progress";
import Header from "../../shared/Header";
import Footer from "../../shared/Footer";
export default {
  name: "StepperLinear",
  data: () => ({
    completedSteps: 0,
    totalSteps: 10,
    percentage: 0,
  }),

  methods: {
    progress(prgValue) {
      this.completedSteps = prgValue;
      this.percentage = Math.floor((prgValue * 100) / this.totalSteps);
    },
  },

  created() {},
  components: {
    RadialProgressBar,
    Header,
    Footer,
  },
};
</script>

<style lang="scss" scoped>
.container {
  .content {
    max-width: 600px;
    min-height: calc(100vh - 15px);
    margin: auto;
    padding: 30px;
    .progress-bar {
      display: flex;
      justify-content: center;
      align-items: center;
    }
  }
}

@media only screen and (max-width: 600px) {
}
</style>
