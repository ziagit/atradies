<template>
  <div class="budget">
    <span class="md-display-1">How mouch is the budget?</span>
    <form @submit.prevent="nextStep()">
      <div class="break"></div>
      <div class="break"></div>
      <div class="options" v-for="(budget, index) in budgets" :key="index">
        <md-radio
          v-if="budget.budgets != ''"
          class="md-primary"
          v-model="selected"
          :value="budget.budgets"
          >{{ budget.budgets }}</md-radio
        >
      </div>

      <div class="break"></div>
      <div class="break"></div>
      <div class="action">
        <md-button to="/order/need" class="md-icon-button md-raised">
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
    budgets: null,

    snackbar: {
      show: false,
      message: null,
      statusCode: null,
    },
  }),

  methods: {
    async nextStep() {
      await localData.save("budget", this.selected);
      this.$router.push("/order/status");
    },

    async init() {
      this.selected = await localData.read("job-budgets");
    },
    getbudgets() {
      axios
        .get("budgets")
        .then((res) => {
          this.budgets = res.data;
          this.selected = res.data[0].budgets;
        })
        .catch((err) => {
          console.log("Error: ", err);
        });
    },
  },
  created() {
    this.$emit("progress", 5);
    this.init();
    this.getbudgets();
    localData.save("cRoute", this.$router.currentRoute.path);
  },
  components: {
    Snackbar,
  },
};
</script>

<style lang="scss" scoped>
.budget {
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
