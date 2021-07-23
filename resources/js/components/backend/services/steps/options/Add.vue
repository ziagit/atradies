<template>
  <div>
    <form @submit.prevent="save()">
      <md-card>
        <md-card-content>
          <md-content class="md-layout">
            <md-field>
              <label>title</label>
              <md-input v-model="form.title" title="title"></md-input>
            </md-field>
            <md-field>
              <select @change="getOption" v-model="form.service" id="service" placeholder="Service" >
                <option v-for="service in services" :key="service.id" :value="service.id">{{
                  service.name
                }}</option>
              </select>
            </md-field>
            <md-field>
              <md-select v-model="form.step" id="op" placeholder="Step">
                <md-option v-for="step in steps" :key="step.id" :value="step.id">{{
                  step.title
                }}</md-option>
              </md-select>
            </md-field>
          </md-content>
        </md-card-content>
        
        <md-card-actions>
          <md-button type="submit" class="md-button md-raised"> Save </md-button>
        </md-card-actions>
      </md-card>
    </form>
  </div>
</template>

<script>
import Snackbar from "../../../../shared/Snackbar";
import Spinner from "../../../../shared/Spinner";
import axios from "axios";

export default {
  data: () => {
    return {
      form: {
        title: null,
        step: null,
        service:null
      },
      steps: null,
      services:null,
      snackbar: {
        show: false,
        message: null,
        statusCode: null,
      },
    };
  },
  methods: {
    save() {
      axios
        .post("options", this.form)
        .then((res) => {
          this.$emit("close-dialog");
        })
        .catch((err) => {
          this.snackbar.show = true;
          this.snackbar.message = err.response.data.message;
          this.snackbar.statusCode = err.response.status;
          console.log("Error: ", err.response);
        });
    },
    get() {
      axios
      .get('get-services')
      .then((response) => {
        this.services = response.data;
        console.log(response);
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
    this.get();
  },
  components: {
    Spinner,
    Snackbar,
  },
};
</script>

<style scoped>
.md-card {
  box-shadow: none;
}
</style>
