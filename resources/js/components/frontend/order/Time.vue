<template>
  <div class="time">
    <span class="md-display-1">When do you need the work to satart?</span>
    <div class="break"></div>
    <form @submit.prevent="nextStep()">
      <div class="break"></div>
      <div class="break"></div>
      <div class="options" v-for="time in times" :key="time.id">
        <md-radio
          v-if="time.times != ''"
          class="md-primary"
          v-model="selected"
          :value="time.times"
          >{{ time.times }}</md-radio
        >
      </div>

      <div class="break"></div>
      <div class="break"></div>
      <div class="action">
        <md-button to="/order/location" class="md-icon-button md-raised">
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
  name: "Time",
  data: () => ({
    selected: null,
    times: null,

    snackbar: {
      show: false,
      message: null,
      statusCode: null,
    },
  }),

  methods: {
    async nextStep() {
      await localData.save("time", this.selected);
      this.$router.push("/order/service");
    },

    async init() {
      this.selected = await localData.read("descriptin");
    },
    gettimes() {
      axios
        .get("times")
        .then((res) => {
          this.times = res.data;
          this.selected = res.data[0].times;
        })
        .catch((err) => {
          console.log("Error: ", err);
        });
    },
  },
  created() {
    this.$emit("progress", 1);
    this.init();
    this.gettimes();
    localData.save("cRoute", this.$router.currentRoute.path);
  },
  components: {
    Snackbar,
  },
};
</script>

<style lang="scss" scoped>
.time {
  text-align: center;
  form {
    width: 300px;
    margin: auto;
    text-align: left;
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
