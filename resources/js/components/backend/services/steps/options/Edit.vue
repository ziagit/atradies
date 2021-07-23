<template>
  <div>
    <form>
      <md-card>
        <md-card-content>
          <md-content class="md-layout">
            <md-field
              class="md-layout-item md-large-size-100 md-small-size-100 md-xsmall-size-100"
            >
              <md-input v-model="form.title" placeholder="Title"></md-input>
            </md-field>
            <md-field>
              <select @change="getOption" v-model="form.service" id="service" placeholder="Service" >
                <option v-for="service in services" :key="service.id" :value="service.id">{{
                  service.name
                }}</option>
              </select>
            </md-field>
            <md-field>
              <md-select v-model="form.step" placeholder="" id="step">
                <md-option v-for="step in steps" :key="step.id" :value="step.id">{{
                  step.title
                }}</md-option>
              </md-select>
            </md-field>
          </md-content>
        </md-card-content>
        <md-card-actions>
          <md-button v-on:click="update()">Done</md-button>
        </md-card-actions>
      </md-card>
    </form>
  </div>
</template>

<script lang="ts">
import axios from "axios";
export default {
  props: ["op"],
  data: () => {
    return {
      form: {
        title: null,
        step: null,
        service:null,
      },
      steps: null,
      services:null,
    };
  },
  methods: {
    update() {
      axios
        .put("options/" + this.op.id, this.form)
        .then((res) => {
          console.log("Updated successfully! ", res.data);
          this.$emit("close-dialog");
        })
        .catch((err) => {
          console.log("Error: ", err);
        });
    },
    get() {
      axios
        .get("options-steps/"+this.form.service)
        .then((res) => {
          console.log("options-steps: ", res.data);
          this.steps = res.data;
        })
        .catch((err) => {
          console.log("Error: ", err);
        });
    },
    getService(){
      axios
      .get('get-services')
      .then((response) => {
        this.services = response.data;
      })
      .catch((error) => {
        console.log(error);
      });
    },
    getOption(){
      // alert(this.form.service);
      axios
        .get("options-steps/"+this.form.service)
        .then((res) => {
          this.steps = res.data;
        })
        .catch((err) => {
          console.log("Error: ", err);
        });
    }
  },
  created() {
    console.log("xxxxxxxxx", this.op);
    this.form.title = this.op.title;
    this.form.step = this.op.step.id;
    this.form.service  = this.op.service.id;
    this.getService();
    this.get();

  },
};
</script>

<style scoped>
.md-card {
  box-shadow: none;
}
</style>
