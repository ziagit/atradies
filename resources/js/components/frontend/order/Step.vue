<template>
  <div class="need">
    <span class="md-display-1">{{ myStep.title }}</span>
    <div class="break"></div>
    <form @submit.prevent="nextStep()">
      <div class="break"></div>
      <div class="break"></div>
    </form>
    <Snackbar :data="snackbar" />
  </div>
</template>

<script>
import Snackbar from "../../shared/Snackbar";
import localData from "../services/localData";
export default {
  name: "Origin",
  props: ["step"],
  data: () => ({
    selected: null,
    myStep: null,
  }),

  methods: {
    async init() {
      console.log("list;", this.myList);
      this.myStep = this.step;
      this.selected = await localData.read("budget");
    },
  },
  created() {
    this.init();
    localData.save("cRoute", this.$router.currentRoute.path);
  },
  components: {
    Snackbar,
  },
};
</script>

<style lang="scss" scoped>
@media only screen and (max-width: 600px) {
}
</style>
