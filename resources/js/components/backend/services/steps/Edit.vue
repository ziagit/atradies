<template>
  <div>
    <form @submit.prevent="submit()">
      <md-card>
        <md-card-content>
          <md-field>
            <label>Title</label>
            <md-input v-model="form.title"></md-input>
          </md-field>
          <md-field>
            <md-select v-model="form.route" id="route" placeholder="Route name">
              <md-option value="location">Location</md-option>
              <md-option value="locationtype">Location Type</md-option>
              <md-option value="servicetype">Service Type</md-option>
              
              <md-option value="budget">Budget</md-option>
              <md-option value="time">Time</md-option>
              <md-option value="status">Status</md-option>
              <md-option value="need">Need</md-option>
              <md-option value="description">Description</md-option>
              <md-option value="contact">Contact</md-option>
            </md-select>
          </md-field>
          <md-field>
            <md-select v-model="form.service" id="service" placeholder="service">
              <md-option
                v-for="service in services"
                :key="service.id"
                :value="service.id"
                >{{ service.name }}</md-option
              >
            </md-select>
          </md-field>
        </md-card-content>
        <md-card-actions>
          <md-button type="submit" class="md-button md-raised"> Update </md-button>
        </md-card-actions>
      </md-card>
    </form>
  </div>
</template>

<script>
import Snackbar from "../../../shared/Snackbar";
import Spinner from "../../../shared/Spinner";
import axios from "axios";

export default {
  props: ["step"],
  data: () => {
    return {
      form: {
        title: null,
        route: null,
        service: null,
      },
      services: null,
      icon: null,
      snackbar: {
        show: false,
        message: null,
        statusCode: null,
      },
    };
  },
  methods: {
    submit() {
      axios
        .put("steps/" + this.step.id, this.form)
        .then((res) => {
          console.log("updated successfully! ", res.data);
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
        .get("steps-services")
        .then((res) => {
          console.log("services: , ", res.data);
          this.services = res.data;
        })
        .catch((err) => {
          console.log("Error: ", err);
        });
    },
  },
  created() {
    this.form.title = this.step.title;
    this.form.service = this.step.service.id;
    this.form.route   = this.step.route;
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
