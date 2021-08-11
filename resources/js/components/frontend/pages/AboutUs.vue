<template>
  <div class="container">
    <div
      class="section0"
      v-bind:style="{ 'background-image': 'url(/images/uploads/about.svg)' }"
    >
      <Header v-on:togal-menu="$emit('togal-menu')" :scrollValue="scrollValue" />
      <div class="content">
        <div class="md-display-1">About Us</div>
        <div class="md-subheading">
          Everything we trying to do is to solve customer problems through technology.
        </div>
      </div>
    </div>

    <md-card class="section1">
      <div class="wrapper">
        <div class="left" v-for="about in abouts" v-bind:key="about.id">
          <div>
            <div class="md-display-1">{{about.title}}</div>
            <div class="md-body-1" v-html="about.body">
              
            </div>
          </div>
          <br />
          
        </div>
        
          
          
      </div>
    </md-card>

    <Footer />
  </div>
</template>

<script>
import axio from "axios";
import Footer from "../../shared/Footer";
import Header from "../../shared/Header";
import axios from 'axios';
export default {
  name: "ContactUs",
  props: ["scrollValue"],
  data: () => ({
    form: {
      name: null,
      email: null,
      message: null,
    },
    abouts:[],
  }),
  methods: {
    getAbount(){
      axios
      .get("about-us")
      .then((response) => {
        console.log(response);
        this.abouts = response.data;
      })
      .catch((err) => {
        console.log(err);
      });
    },
    
  },
  created(){
    this.getAbount();
  },
  components: {
    Footer,
    Header,
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
      }

      .md-subheading {
        color: #000;
        max-width: 70%;
      }
    }
  }

  .section1 {
    max-width: 1200px;
    margin: auto;
    padding: 30px;
    margin-top: -30px;
    margin-bottom: 30px;

    .wrapper {
      display: flex;
      justify-content: space-around;
      flex-wrap: wrap;

      .left {
        flex: 60%;
        padding: 60px;

        .md-display-1 {
          font-weight: 500;
          line-height: 70px;
          color: #000;
        }

        .md-body-1 {
          font-size: 16px;
          line-height: 24px;
        }
      }

      .right {
        flex: 30%;
        padding: 82px 60px;

        .md-icon {
          color: #66a9fb;
        }

        .qoute {
          .md-field {
            margin: 4px 0 8px;
          }

          .action {
            text-align: right;

            .md-button {
              margin: 0;
            }
          }
        }

        .qoute,
        .faq,
        .download-app,
        .privacy,
        .terms,
        .contact {
          margin-bottom: 30px;
        }

        .download-app {
          .md-button {
            margin-top: 20px;
          }
        }
      }
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
