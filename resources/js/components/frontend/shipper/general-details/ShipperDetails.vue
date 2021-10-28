<template>
<div>
      <div>
          <md-dialog-confirm
            :md-active.sync="deleteTogal"
            md-title="Are your sure you want to delete?"
            md-content
            md-confirm-text="OK"
            md-cancel-text="Cancel"
            @md-confirm="confirm()"
            @md-cancel="cancel"
        />
        <h1>These services you know</h1>
        <div class="container well">
          <table class="table table-border table-hovered">
            <thead>
              <th>Name</th>
              <th>Type</th>
              <th>Description</th>
              <th>Actions</th>
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
                  <a class="btn btn-danger btn-sm btn-round glyphicon glyphicon-trash" @click="remove(user_service.id)">X</a>
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
    name: "GeneralInfo",
    

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
    selectedId:null,
    deleteTogal:false
  }),

  methods: {
    submit() {
      axios
        .post("set-selected-services", this.form)
        .then((res) => {
        //   this.user_services.push(res.data.user_service);
        //   this.services.splice(res.data.user_service);
        this.getService();
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
    },
    remove(id) {
      this.deleteTogal = true;
      this.selectedId = id;
    },

    confirm() {
      axios
        .delete("/shipper/service/delete/" + this.selectedId)
        .then((res) => {
          console.log("deleted", res.data);
          this.getService();
        })
        .catch((err) => {
          console.log("Error: ", err);
        });
    },
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
.md-card {
    box-shadow: none;
    text-align: center;

    .md-display-1 {
        font-size: 30px;
    }

    .md-card-actions {
        display: flex;
        justify-content: space-around;
    }
}
</style>
