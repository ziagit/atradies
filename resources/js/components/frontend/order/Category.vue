<template>
  <div class="container">
    <div class="row">
      <div class="col" v-for="category in categories" :key="category.id">
        <div @click="start(category.categories)">
          <md-card v-if="category.categories != ''" :value="category.categories">
            <md-card-content>
              <md-icon>{{ category.icon }}</md-icon>
              {{ category.categories }}
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
    categories: null,
  }),

  methods: {
    start(category) {
      localData.save("category", category);
      this.$router.push("/order/job-location");
    },

    getcategories() {
      axios
        .get("categories")
        .then((res) => {
          console.log("xxxxxxxxxx", res.data);
          this.categories = res.data;
        })
        .catch((err) => {
          console.log("Error: ", err);
        });
    },
  },
  created() {
    this.getcategories();
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
