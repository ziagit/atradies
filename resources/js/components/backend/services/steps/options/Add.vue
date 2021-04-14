<template>
  <div>
    <form @submit.prevent="save()">
      <md-card>
        <md-card-content>
          <md-field>
            <label>title</label>
            <md-input v-model="form.title" title="title"></md-input>
          </md-field>
          <md-field>
            <md-select v-model="form.step" id="op" placeholder="Option">
              <md-option v-for="step in steps" :key="step.id" :value="step.id">{{
                step.title
              }}</md-option>
            </md-select>
          </md-field>
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
      },
      steps: null,
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
          console.log("saved successfully! ", res.data);
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
        .get("options-steps")
        .then((res) => {
          console.log("steps: , ", res.data);
          this.steps = res.data;
        })
        .catch((err) => {
          console.log("Error: ", err);
        });
    },
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
