<template>
  <div class="steps">
    <ul>
      <div v-for="(step, index) in service.steps" :key="index">
        <li v-if="index == stepNumber">
          <span v-if="step.route == 'location'"> <Location /> </span>
          <span v-if="step.route == 'contact'"> <Contact /> </span>
          <span v-else><Step :step="step" /></span>
          <div class="tab"></div>
          <div class="action">
            <md-button
              @click="next(index + 1)"
              class="md-icon-button md-raised md-primary"
              type="submit"
            >
              <md-icon>arrow_right</md-icon>
            </md-button>
          </div>
        </li>
      </div>
    </ul>
  </div>
</template>

<script>
import Location from "./Location";
import Contact from "./Contact";
import Step from "./Step";
import localData from "../services/localData";
export default {
  name: "Steps",
  data: () => ({
    service: null,
    stepNumber: 0,
  }),
  components: {
    Location,
    Step,
    Contact,
  },
  methods: {
    async next(index) {
      if (index == this.service.steps.length) {
        console.log("you reached to last step", index);
      } else {
        this.stepNumber = index;
        console.log("index is: ", index);
      }
    },
    init() {
      this.service = localData.read("service");
      console.log("steps lenght: ", this.service.steps);
    },
  },
  created() {
    this.init();
  },
};
</script>

<style lang="scss" scoped>
.steps {
  text-align: center;
  ul {
    li {
      list-style-type: none;
    }
  }
}

@media only screen and (max-width: 600px) {
  .steps {
    .options {
      text-align: center;
    }
  }
}
</style>
