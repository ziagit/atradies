<template>
  <div class="container">
    <div
      class="section0"
      v-bind:style="{ 'background-image': 'url(/images/uploads/help.svg)' }"
    >
      <Header v-on:togal-menu="$emit('togal-menu')" />
      <div class="content">
        <div class="md-display-1">{{ header }}</div>
        <div class="md-subheading">
          {{ subheader }}
          <div class="break"></div>
          <md-button class="custom-button" to="/register" v-if="carrierToggal"
            >Signup now</md-button
          >
          <md-button class="custom-button" to="/order" v-if="shipperToggal"
            >Post a new job</md-button
          >
        </div>
      </div>
    </div>

    <md-card class="section1">
      <md-tabs>
        <md-tab
          id="tab-how-works"
          md-label="How it Works"
          md-icon="help"
          @click="
            passData(
              (header = 'How it Works?'),
              (subheader = 'Most common quetions about our customers')
            )
          "
        >
          <HowItWorks />
        </md-tab>
        <md-tab
          id="tab-service"
          md-label="Services"
          md-icon="directions_boat"
          @click="
            passData(
              (header = 'Services'),
              (subheader = 'Most common questoins about our services')
            )
          "
        >
          <CarrierHelp />
        </md-tab>
        <md-tab
          id="tab-customer"
          md-label="Customers"
          md-icon="local_mall"
          @click="
            passData(
              (header = 'Customers'),
              (subheader = 'Top common questions about our customers')
            )
          "
        >
          <ShipperHelp />
        </md-tab>
      </md-tabs>
    </md-card>

    <Footer />
  </div>
</template>

<script>
import Footer from "../../shared/Footer";
import Header from "../../shared/Header";
import CarrierHelp from "./CarrierHelp";
import ShipperHelp from "./ShipperHelp";
import HowItWorks from "./HowItWorks";
import FAQ from "./FAQ";
export default {
  name: "ContactUs",
  data: () => ({
    form: {
      name: null,
      email: null,
      message: null,
    },
    header: "How it Works?",
    subheader: "Get done your work without leaving confort of home",
    carrierToggal: false,
    shipperToggal: false,
  }),
  methods: {
    passData(header, subheader) {
      this.header = header;
      this.subheader = subheader;
      this.carrierToggal = header == "Services" ? true : false;
      this.shipperToggal = header == "Customers" ? true : false;
    },
  },
  components: {
    Footer,
    Header,
    CarrierHelp,
    ShipperHelp,
    HowItWorks,
    FAQ,
  },
};
</script>
<style lang="scss" scoped>
.container {
  background: #fff;

  .section0 {
    background-repeat: no-repeat;
    background-size: cover;
    background-position: center center;
    align-items: center;
    border-bottom: #ddd 1px solid;
    .content {
      height: 268px;
      padding: 85px 200px 85px 106px;
      .md-display-1 {
        line-height: 60px;
        font-size: 53px;
        font-weight: 600;
        color: #000;
        max-width: 355px;
      }

      .md-subheading {
        color: #000;
      }

      .md-button {
        margin-top: 30px;
      }
    }
  }

  .section1 {
    max-width: 1200px;
    margin: auto;
    padding: 30px;
    margin-top: -30px;
    margin-bottom: 30px;
    .md-tabs {
      width: 100% !important;
      margin: auto;
    }
  }
}
@media only screen and (max-width: 600px) {
  .section0 {
    .content {
      padding: 20px !important;
      height: 188px !important;
      .md-display-1 {
        font-size: 32px !important;
        line-height: 48px !important;
      }
      .md-subheading {
        font-size: 14px !important;
      }
    }
  }

  .section1 {
    padding: 30 !important;

    .wrapper {
      flex-direction: column;
      .left,
      .right {
        padding: 0 !important;
      }
      .left {
        margin-bottom: 74px !important;
      }
      .md-button {
        margin: 30px 0 0 0;
      }
    }
  }
}
</style>
