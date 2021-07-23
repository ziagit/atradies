<template>
  <div class="steps md-card md-default">
    <ul>
      <div v-for="(step, index) in service.steps" :key="index">
        <li v-if="index == stepNumber">
          <span v-if="step.route == 'location'" > <Location  :location="step" /> </span>
          <span v-else-if="step.route == 'contact'" > <Contact :contact="step" /> </span>
          <span v-else-if="step.route == 'multichoices'"><Multichoice :multichoice='step' /></span>
          <span v-else-if="step.route == 'onechoice'"><Onechoice :onechoice='step' /></span>
         
         
          <span v-else><Step :step="step" /></span>
          
          <div class="action">
             <md-button @click="$router.back()" class="md-raised">
              Preview
            </md-button>
            <md-button
              @click="next(index + 1)"
              class="md-raised md-primary"
              type="submit"
            >
              Continue
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
import Multichoice from './Multichoice';
import Description from './Description';
import Onechoice from './Onechoice';

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
    Multichoice,
    Onechoice,
    Description,
  },
  methods: {
    async next(index) {
      if(index == this.service.steps.length)
      {
       this.$router.push("/confirmation");
      }
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
