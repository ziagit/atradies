<template>
  <div class="origin">
    <span class="md-display-1">{{ title }}</span>
    <div class="break"></div>
    <form @submit.prevent="next()">
      <div class="search-container">
        <GoogleAddress
          v-on:google-valid-address="googleValidAddress"
          v-on:google-invalid-address="googleInvalidAddress"
          :initialData="initialData"
        />
      </div>
      <div class="break"></div>
      <div class="break"></div>

      <div v-if="supportedArea">
        <div class="break"></div>
        <div class="break"></div>
        <md-card>
          <md-card-content>
            <span style="color: red"
              >Sorry! <b>"{{ supportedArea }}" </b> is not in our coverage area yet.</span
            >
          </md-card-content>
        </md-card>
      </div>
      <div class="break"></div>
      <div class="break"></div>
      <div class="action">
        <md-button class="md-icon-button md-raised md-primary" type="submit">
          <md-icon>arrow_right</md-icon>
        </md-button>
      </div>
    </form>

    <Snackbar :data="snackbar" />
  </div>
</template>

<script>
import Snackbar from "../../shared/Snackbar";
import GoogleAddress from "../../shared/GoogleAddress";
import localData from "../services/localData";
export default {
  name: "Origin",
  data: () => ({
    supportedArea: null,
    initialData: null,
    title: null,
    address: {
      country: null,
      state: null,
      city: null,
      zip: null,
      street: null,
      street_number: null,
      formated_address: null,
    },
    snackbar: {
      show: false,
      message: null,
      statusCode: null,
    },
  }),

  methods: {
    async next() {
      if (
        this.address.country === "" ||
        this.address.state === "" ||
        this.address.city === "" ||
        this.address.zip === ""
      ) {
        this.snackbar.show = true;
        this.snackbar.message = "Please provide a valid address!";
        this.snackbar.statusCode = 404;
      } else {
        await localData.save("address", this.address);
        this.$router.push("date");
      }
    },
    googleValidAddress(address) {
      this.supportedArea = "";
      this.address.country = address.country;
      this.address.state = address.state;
      this.address.city = address.city;
      this.address.zip = address.zip;
      this.address.street = address.street;
      this.address.street_number = address.street_number;
    },
    googleInvalidAddress(address) {
      this.supportedArea = address.state;
      this.address.country = null;
      this.address.state = null;
      this.address.city = null;
      this.address.zip = null;
      this.address.street = null;
      this.address.street_number = null;
    },
    async init() {
      this.title = await localData.read("service").steps[0].title;
      let data = await localData.read("address");
      if (data != null) {
        this.address.country = data.country;
        this.address.state = data.state;
        this.address.city = data.city;
        this.address.zip = data.zip;
        this.address.street = data.street;
        this.address.street_number = data.street_number;
        this.address.address = data.address;
        this.address.appointmentTime = data.appointmentTime;
      }
    },
  },
  created() {
    this.$emit("progress", 0);
    this.init();
    localData.save("cRoute", this.$router.currentRoute.path);
  },
  components: {
    Snackbar,
    GoogleAddress,
  },
};
</script>

<style lang="scss" scoped>
.origin {
  text-align: center;
  .search-container {
    position: relative;
    .md-field {
      margin-bottom: 0;

      .select-country {
        position: absolute;
        top: 0;
        right: 0;
      }
    }
  }

  .options {
    .md-radio {
      margin: 8px 16px 8px 0;
    }
  }
  .action {
    display: flex;
    justify-content: center;
  }
}

@media only screen and (max-width: 600px) {
  .origin {
    .options {
      text-align: center;
    }
  }
}
</style>
