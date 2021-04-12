<template>
  <div class="status">
    <span class="md-display-1">What is the status of your job?</span>
    <div class="break"></div>
    <form @submit.prevent="nextStep()">
      <div class="break"></div>
      <div class="break"></div>
      <div class="options" v-for="status in status" :key="status.id">
        <md-radio
          v-if="status.status != ''"
          class="md-primary"
          v-model="selected"
          :value="status.status"
          >{{ status.status }}</md-radio
        >
      </div>

      <div class="break"></div>
      <div class="break"></div>
      <div class="action">
        <md-button to="/order/budget" class="md-icon-button md-raised">
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
    status: null,

    snackbar: {
      show: false,
      message: null,
      statusCode: null,
    },
  }),

  methods: {
    async nextStep() {
      await localData.save("status", this.selected);
      this.$router.push("/order/contact");
    },

    async init() {
      this.selected = await localData.read("status");
    },
    getstatus() {
      axios
        .get("status")
        .then((res) => {
          this.status = res.data;
          this.selected = res.data[0].status;
        })
        .catch((err) => {
          console.log("Error: ", err);
        });
    },
  },
  created() {
    this.$emit("progress", 6);
    this.init();
    this.getstatus();
    localData.save("cRoute", this.$router.currentRoute.path);
  },
  components: {
    Snackbar,
  },
};
</script>

<style lang="scss" scoped>
.status {
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
