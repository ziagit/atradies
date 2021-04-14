<template>
  <div class="container">
    <div class="row">
      <div class="col" v-for="service in services" :key="service.id">
        <div @click="start(service.services)">
          <md-card v-if="service.services != ''" :value="service.services">
            <md-card-content>
              <div>
                <img :src="'images/uploads/' + service.icon" alt="" width="60" />
              </div>
              <div class="break"></div>
              <div>
                {{ service.name }}
              </div>
            </md-card-content>
          </md-card>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import localData from "../services/localData";
export default {
  name: "Origin",
  data: () => ({
    services: null,
  }),

  methods: {
    start(service) {
      localData.save("service", service);
      this.$router.push("/order/job-location");
    },

    get() {
      axios
        .get("steps-services")
        .then((res) => {
          console.log("services :", res.data);
          this.services = res.data;
        })
        .catch((err) => {
          console.log("Error: ", err);
        });
    },
  },
  created() {
    this.get();
    localData.save("cr", this.$router.currentRoute.path);
  },
  components: {},
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
        background: linear-gradient(45deg, transparent, #71c4ff29);
        margin: 10px;
        .md-card-content:last-of-type {
          padding-bottom: none;
        }

        .md-card-content {
          padding: 16px;
          font-size: 18px;
          line-height: 37px;
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
