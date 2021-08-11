<template>
<div>
  
  <div class="steps md-card md-default col-md-12">
    
    <ul>
      <div v-for="(step, index) in service.steps" :key="index">
        <li v-if="index == stepNumber">
         
          <span v-if="step.route == 'location'"> 
            <Location :location="step" ref="form" />
         
          </span>
          <span v-else-if="step.route == 'locationtype'">
             <LocationType :locationtype="step" ref="form" />
           </span>
          <span v-else-if="step.route == 'contact'" >
            <Contact :contact="step" ref="form" /> 
          </span>
          <span v-else-if="step.route == 'servicetype'">
            <service-type :servicetype='step' ref="form" />
          </span>
          <span v-else-if="step.route == 'budget'">
            <budget :budget='step' ref="form" />
          </span>
          <span v-else-if="step.route == 'time'">
            <Time :time='step' ref="form" />
          </span>
          <span v-else-if="step.route == 'description'">
            <Description :description='step' ref="form" />
          </span>
          
          <span v-else-if="step.route == 'status'">
            <Status :status='step' ref="form" />
          </span>

          <span v-else-if="step.route == 'need'">
            <Need :need='step' ref="form" />
          </span>
          
          <span v-else>
            <Step :step="step" />
          </span>
          <div class="action">
             <md-button @click="next(index-1,'preview')" class="md-raised">
              Preview
            </md-button>
            <md-button
              @click.prevent="next(index + 1,'next')"
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
</div>
</template>

<script>
import Location from "./Location";
import Contact from "./Contact";
import Description from './Description';
import LocationType from './LocationType';
import Step from "./Step";
import localData from "../services/localData";
import ServiceType from './ServiceType';
import Budget from './Budget.vue';
import Time from './Time.vue';
import Status from './Status';
import Need from './Need.vue';
import { mapActions, mapGetters } from "vuex";

export default {
  name: "Steps",
  data: () => ({
    service: null,
    stepNumber: 0,
    parentMsg:null,
    completedSteps:null,
    totalSteps:null,
    percentage:null
  }),
  components: {
    Location,
    Step,
    Contact,
    Description,
    LocationType,
    ServiceType,
    Budget,
    Time,
    Status,
    Need,
    
  },
  methods: {
    async next(index,step) {
      this.setProgress(index);
      // console.log(JSON.parse(localStorage.getItem("budget")));
      if(step == "next")
      {
        try{
          console.log(this.$refs['form'][0].nextStep());
        }
        catch($err){
          console.log($err);
        }
        if(index == this.service.steps.length)
        {
          if(localData.read("contact") == null || localData.read("contact") =="")
          {
            this.$router.push("/contact");
          }
          else{
            this.$router.push("/confirmation");
          }
        }
        if(index < 0){
          this.$router.push('/home');
        }
        if (index == this.service.steps.length) {
          console.log("you reached to last step", index);
        } else {
          this.stepNumber = index;
        }
        
      }
      else{
        if(index == this.service.steps.length)
        {
        this.$router.push("/confirmation");
        }
        if(index < 0){
          this.$router.push('/home');
        }
        if (index == this.service.steps.length) {
          console.log("you reached to last step", index);
        } else {
          this.stepNumber = index;
        }
      }
      
    },
    init() {
      this.service = localData.read("service");
      localData.save("order_service",this.service.id);

    },
    setProgress(index){
      this.totalSteps = this.service.steps.length;
      this.completedSteps = index;
      this.percentage   =  index*(100/this.totalSteps);
      this.$parent.setProgressValue(this.completedSteps,this.totalSteps,this.percentage);

    }
  },
  created() {
    this.init();
    this.setProgress();
    this.setProgress(0);
  },
  computed: {
    ...mapGetters({
      authenticated: "auth/authenticated",
      user: "auth/user",
    }),
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
