<template>
  <div class="pickup-services">
    <span class="md-display-1">Do you need other services?</span>
    <div class="break"></div>
    <div class="break"></div>
    <form @submit.prevent="nextStep()">
      <div class="options">
        <md-checkbox
          v-for="service in accessories"
          :key="service.id"
          v-model="services"
          :value="service.code"
          >{{ service.name }}</md-checkbox
        >
      </div>
      <div class="break"></div>
      <div class="break"></div>
      <div class="action">
        <md-button class="md-icon-button md-raised" @click="$router.back()">
          <md-icon>arrow_left</md-icon>
        </md-button>
        <md-button type="submit" class="md-primary md-raised md-icon-button">
          <md-icon>arrow_right</md-icon>
        </md-button>
      </div>
    </form>
  </div>
</template>

<script>
export default {
  name: "PickupService",
  data: () => ({
    accessories: null,
    services: [],
  }),
  methods: {
    getAccessories() {
      axios
        .get("pick-services")
        .then((res) => {
          this.accessories = res.data;
        })
        .catch((err) => {
          console.log("Error: ", err);
        });
    },
    async nextStep() {
      await storage.save("services", this.services);
      this.$router.push("pickup-date");
    },

    async init() {
      let data = await storage.read("services");
      if (data != null) {
        this.services = data;
      }
    },
  },

  created() {
    this.$emit("progress", 1);
    this.init();
    this.getAccessories();
    storage.setItem("cRoute", this.$router.currentRoute.path);
  },
};
</script>

<style lang="scss" scoped>
.pickup-services {
  text-align: center;

  .action {
    display: flex;
    justify-content: center;
  }
}
</style>
