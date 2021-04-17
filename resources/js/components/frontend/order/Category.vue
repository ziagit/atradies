<template>
  <div class="container">
    <div class="row">
      <div class="col" v-for="service in services" :key="service.id">
        <div @click="start(service)">
          <md-card>
            <div class="image">
              <img :src="'images/uploads/' + '1618318023.icon.svg'" alt="" width="60" />
            </div>
            <div class="break"></div>
            <div class="text">
              <div class="md-display-1">{{ service.name }}</div>
              <div class="md-body-1">Some details about this service</div>
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
export default {
  name: "Origin",
  data: () => ({
    services: null,
  }),

  methods: {
    start(service) {
      localData.save("service", service);
      this.$router.push("/order/location");
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
  },
  created() {
    let routeData = new VueRouter({
      routes: [{ path: "/order/location", component: JobLocation }],
    });

    this.get();
    localData.save("cr", this.$router.currentRoute.path);
  },
  components: {
    JobLocation,
  },
};
</script>

<style lang="scss" scoped>
.container {
  text-align: center;
  .row {
    display: flex;
    justify-content: space-around;
    flex-wrap: wrap;
    .col {
      flex: 50%;
      .md-card {
        background: #383b3e;
        margin: 10px;
        font-size: 18px;
        line-height: 37px;
        display: flex;
        .image {
          align-items: center;
          display: flex;
          padding: 16px;
          background: rgb(14, 126, 179);
          border-top-left-radius: 5px;
          border-bottom-left-radius: 5px;
        }
        .text {
          padding: 16px;
          text-align: left;
          .md-display-1 {
            color: #fff;
          }
          .md-body-1 {
            color: rgb(230, 224, 224);
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
