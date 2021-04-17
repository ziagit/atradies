<template>
  <div class="order">
    <span class="md-display-1">{{ title }}</span>
    <div class="break"></div>
    <form @submit.prevent="next()">
      <div class="options">
        <md-radio
          v-for="option in options"
          :key="option.id"
          v-model="selected"
          :value="option"
          >{{ option.title }}?</md-radio
        >
      </div>
      <div class="break"></div>
      <div class="break"></div>
      <div class="action">
        <md-button class="md-raised md-icon-button" @click="$router.back()">
          <md-icon>arrow_left</md-icon>
        </md-button>
        <md-button class="md-primary md-raised md-icon-button" type="submit">
          <md-icon>arrow_right</md-icon>
        </md-button>
      </div>
    </form>
  </div>
</template>

<script>
import localData from "../services/localData";
export default {
  name: "PickupDate",
  data: () => ({
    title: null,
    time: null,
    options: null,
    selected: null,
  }),
  methods: {
    next() {
      localData.save("time", this.selected);
      this.$router.push("/order/budget");
    },
    async init() {},
    get() {
      axios
        .get("get-options/" + 2)
        .then((res) => {
          this.options = res.data;
          this.selected = this.options[0];
        })
        .catch((err) => {
          console.log("Error: ", err);
        });
    },
    async init() {
      this.title = await localData.read("service").steps[1].title;
      this.time = await localData.read("time");
    },
  },
  created() {
    this.init();
    this.$emit("progress", 2);
    this.get();
    localData.save("cRoute", this.$router.currentRoute.path);
  },
};
</script>
