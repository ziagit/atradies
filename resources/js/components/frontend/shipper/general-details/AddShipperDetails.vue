<template>
  <div>
      <div>
        <h1>These services you know</h1>
        <div class="container well">
          <table class="table table-border table-hovered table-responsive">
            <thead>
              <th>Name</th>
              <th>Type</th>
              <th>Description</th>
              <th>Action</th>
            </thead>
            <tbody>
              <tr v-for="user_service in user_services" v-bind:key="user_service.id">
                <td>{{user_service.name}}</td>
                <td>
                  {{user_service.type.title}}
                </td>
                <td>
                  {{user_service.description}}
                </td>
                <td>
                  <a class="btn btn-danger glyphicon glyphicon-trash">Delete</a>
                </td>
              </tr>
            </tbody>
          </table>
          <h1>What do you know ?</h1>

          <div class="row">
            <div class="col-md-4"></div>
            <div class="col-md-4">
              <form @submit.prevent="submit" >

                <div class="form-group" >
                  <label>Select the services you know </label>
                  <select  class="form-control" v-model="form.service">
                    <option v-for="service in services" v-bind:key="service.id" :value="service.id">{{service.name}}</option>
                  </select>
                </div>
                <div class="form-control">
                  <button  class="btn btn-success form-control" type="submit">Save</button>
                </div>
              </form>
            </div>
            <div class="col-md-4"></div>
          </div>
        </div>
      </div>
  </div>
</template>

<script>
import axios from "axios";
import Snackbar from "../../../shared/Snackbar";
export default {
  name: "AddGeneralInfo",
  data: () => ({
    form: {
      service:null,
    },
    services:[],
    user_services:[],
    snackbar: {
      show: false,
      message: null,
      statusCode: null,
    },
  }),

  methods: {
    submit() {
      axios
        .post("set-selected-services", this.form)
        .then((res) => {
          this.user_services.push(res.data.user_service);
          this.services.splice(res.data.user_service);
        })
        .catch((error) => {
          console.log("eerrr: ", error.response);
          this.snackbar.message = error.response.data.errors;
          this.snackbar.statusCode = error.response.status;
          this.snackbar.show = true;
        });
    },

    getService(){
      axios
      .get("/get-not-selected-services")
      .then((response)  => {
        console.log(response);
        this.user_services = response.data.user_services;
        this.services = response.data.services;
      })
      .catch((err) => {
        console.log("Error ocord "+err);
      });
    }
  },
  
  created() {
    this.getService();
  },
  components: {
    Snackbar,
  },
};
</script>

<style lang="scss" scoped>
.main-card {
  padding: 30px;
  text-align: center;
  box-shadow: none;
  border: solid 1px #ddd;

  .shipper-logo {
    text-align: center;
    margin-top: -40px;

    .md-large {
      background: #ddd;
    }
  }

  .inputs-container {
    .row {
      display: flex;
      justify-content: space-between;
      flex-wrap: wrap;

      .md-field {
        flex: 32%;
      }

      .zip-address {
        flex: 50%;
      }
    }
  }
}
</style>
