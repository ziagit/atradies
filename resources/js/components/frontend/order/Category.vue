<template>
  <div class="containerr">
    <div class="row">
          <!--Grid column-->
          <div class="col-md-2"></div>
          <div class="col-md-8 mb-4">

            <div class="input-group md-form form-sm form-1 pl-0 ">
              
              <input class="form-control my-0 py-4 " type="text" @keyup="filterService" placeholder="Search by service name or description..." aria-label="Search" v-model="form.service" style="border: 1px solid #ced4da !important;" >
              <div class="input-group-prepend">
                <span @click="filterService" style="background-color:rgb(255, 102, 0);color:white" class="input-group-text btn purple lighten-3" id="basic-text1"><i class="fas fa-search text-white"
                  aria-hidden="true" ></i>Go</span>
              </div>
            </div>

          </div>
          <div class="col-md-2"></div>

            <div class="col col-md-8"  v-for="service in services" :key="service.id">
              <div @click="next(service)" >
                <md-card>
                  <div class="image">
                    <img v-if="service.icon != ''" :src="'images/uploads/' + service.icon" alt="" width="60" />
                    <img v-else :src="'images/uploads/' + '1618318023.icon.svg'" alt="" width="60" />
                  </div>
                  <div class="break"></div>
                  <div class="text">
                    <div class="md-display-1">{{ service.name }}</div>
                    <div class="md-body-1">{{service.description}}</div>
                  </div>
                </md-card>
              </div>
            </div>
          </div>
    </div>
</template>

<script>
import VueRouter from "vue-router";
import localData from "../services/localData";
import JobLocation from "./JobLocation";
import router from "../../../routes";
import axios from 'axios';
export default {
  name: "Origin",
  data: () => ({
    services: null,
    form:{
      service:null,
    }
  }),

  methods: {
    async next(service) {
      localData.save("service",service);
      this.$router.push("/order/steps");
    },

    get() {
      axios
        .get("get-services")
        .then((res) => {
          this.services = res.data;
        })
        .catch((err) => {
          console.log("Error: ", err);
        });
    },
    
    filterService(){
      if(this.form.service == "")
      {
        this.services = null;     
      }
      else{
        axios
        .post('filter-services',this.form)
        .then((res) => {
          // console.log(res);
          this.services = res.data;
        })
        .catch((err) => {
          console.log("Error : ",err);
        });
      }
    },

    checkKey(event){
      if(event.keyCode == 13){
        this.filterService();
      }
    }
  },
  created() {
    let routeData = new VueRouter({
      routes: [{ path: "/order/location", component: JobLocation }],
    });

    // this.get();
    localData.save("cr", this.$router.currentRoute.path);
  },
  components: {
    JobLocation,
  },
};
</script>

<style lang="scss" scoped>
.containerr {
  text-align: center;
  .row {
    display: flex;
    justify-content: space-around;
    flex-wrap: wrap;
    .col {
      flex: 100%;
      .md-card {
        margin: 4px;
        font-size: 18px;
        line-height: 37px;
        display: flex;
        max-height: 70px;
        .image {
          align-items: center;
          display: flex;
          padding: 16px;
          background: rgb(255, 102, 0);
          border-top-left-radius: 5px;
          border-bottom-left-radius: 5px;
        }
        .text {
          // padding: 16px;
          padding-left: 10px;
          text-align: left;
          .md-display-1 {
            color: #000;
          }
          .md-body-1 {
            //color: rgb(230, 224, 224);
          }
        }
        .md-icon {
          position: absolute;
          left: 17px;
          top: 50%;
          bottom: 50%;
        }
      }
      .md-card:hover {
        cursor: pointer;
        opacity: 0.8;
      }
    }
  }
}

@media only screen and (max-width: 600px) {
}
</style>
