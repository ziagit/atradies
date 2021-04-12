<template>
  <div class="service">
    <span class="md-display-1">What type of service do you require?</span>
    <div class="break"></div>
    <form @submit.prevent="nextStep()">
      <div class="break"></div>
      <div class="break"></div>
      <div class="options" v-for="service in services" :key="service.id">
        <md-radio
          v-if="service.services != ''"
          class="md-primary"
          v-model="selected"
          :value="service.services"
          >{{ service.services }}</md-radio
        >
      </div>

      <div class="break"></div>
      <div class="break"></div>
      <div class="action">
        <md-button to="/order/time" class="md-icon-button md-raised">
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
    services: null,

    snackbar: {
      show: false,
      message: null,
      statusCode: null,
    },
  }),

  methods: {
    async nextStep() {
      await localData.save("service", this.selected);
      this.$router.push("/order/need");
    },

    async init() {
      this.selected = await localData.read("job-services");
    },
    getservices() {
      axios
        .get("services")
        .then((res) => {
          this.services = res.data;
          this.selected = res.data[0].services;
        })
        .catch((err) => {
          console.log("Error: ", err);
        });
    },
  },
  created() {
    this.$emit("progress", 3);
    this.init();
    this.getservices();
    localData.save("cRoute", this.$router.currentRoute.path);
  },
  components: {
    Snackbar,
  },
};
</script>

<style lang="scss" scoped>
.service {
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
