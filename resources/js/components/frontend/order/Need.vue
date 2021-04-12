<template>
  <div class="need">
    <span class="md-display-1">What needs the work?</span>
    <div class="break"></div>
    <form @submit.prevent="nextStep()">
      <div class="break"></div>
      <div class="break"></div>
      <div class="options" v-for="need in needs" :key="need.id">
        <md-radio
          class="md-primary"
          v-if="need.needs"
          v-model="selected"
          :value="need.needs"
          >{{ need.needs }}</md-radio
        >
      </div>

      <div class="break"></div>
      <div class="break"></div>
      <div class="action">
        <md-button to="/order/service" class="md-icon-button md-raised">
          <md-icon>arrow_left</md-icon>
        </md-button>
        <div class="tab"></div>
        <md-button class="md-icon-button md-raised md-primary" type="submit">
          <md-icon>arrow_right</md-icon>
        </md-button>
      </div>
    </form>
    <Snackbar :data="snackbar" />
  </div>
</template>

<script>
import Snackbar from "../../shared/Snackbar";
import localData from "../services/localData";
export default {
  name: "Origin",
  data: () => ({
    selected: null,
    needs: null,

    snackbar: {
      show: false,
      message: null,
      statusCode: null,
    },
  }),

  methods: {
    async nextStep() {
      await localData.save("need", this.selected);
      this.$router.push("/order/budget");
    },

    async init() {
      this.selected = await localData.read("budget");
    },
    getneeds() {
      axios
        .get("needs")
        .then((res) => {
          this.needs = res.data;
          this.selected = res.data[0].needs;
        })
        .catch((err) => {
          console.log("Error: ", err);
        });
    },
  },
  created() {
    this.$emit("progress", 4);
    this.init();
    this.getneeds();
    localData.save("cRoute", this.$router.currentRoute.path);
  },
  components: {
    Snackbar,
  },
};
</script>

<style lang="scss" scoped>
.need {
  text-align: center;
  form {
    text-align: left;
    width: 300px;
    margin: auto;
    .options {
      .md-radio {
        margin: 8px 16px 8px 0;
      }
    }
    .action {
      display: flex;
      justify-content: center;
    }
  }
}

@media only screen and (max-width: 600px) {
}
</style>
