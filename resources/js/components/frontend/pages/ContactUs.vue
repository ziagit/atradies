<template>
  <div class="container">
    <div class="section0">
      <Header v-on:togal-menu="$emit('togal-menu')" />

      <!-- <iframe
        src="https://www.google.com/maps/embed?pb=!1m14!1m8!1m3!1d31958839.600046597!2d-128.4053053!3d60.7318475!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x537a66c7aa6b6aaf%3A0x881b41e937e7f1f9!2sBritish%20Columbia%2C%20Canada!5e0!3m2!1sen!2s!4v1603098152028!5m2!1sen!2s"
        width="600"
        height="278"
        frameborder="0"
        style="border: 0"
        allowfullscreen=""
        aria-hidden="false"
        tabindex="0"
      ></iframe> -->
    </div>
    <div class="section1">
      <div class="wrapper">
        <div class="left">
          <div class="md-display-1">Drop us a line</div>
          <form @submit.prevent="nextStep()">
            <md-field>
              <label>Name</label>
              <md-input type="text" ref="focusable" v-model="form.name" required></md-input>
            </md-field>
            <div class="row">
              <md-field>
                <label>Phone</label>
                <md-input type="text" v-model="form.phone" required></md-input>
              </md-field>
              <md-field>
                <label>Email</label>
                <md-input type="email" v-model="form.email" required></md-input>
                <md-icon class="md-primary">
                  <label>Info</label>
                  <md-tooltip>Use your account email!</md-tooltip>
                </md-icon>
              </md-field>
            </div>
            <md-field>
              <label>Work descriptions</label>
              <md-textarea v-model="form.instructions"></md-textarea>
            </md-field>
            <md-button
              @click="nextStep"
              class="md-raised md-primary"
              type="submit"
            >
              Save
            </md-button>
          </form>
        </div>
        <div class="right">
          <div class="content">
            <img :src="'/images/uploads/location.svg'" alt="2" width="80" />
            <div class="md-caption">xxxx</div>
            <div class="md-caption">xxx, xxx</div>
            <div class="md-caption">Aust</div>
            <div class="break"></div>
            <div class="md-caption">+43 xxxxxxxxxx</div>
          </div>
        </div>
      </div>
    </div>
    <Footer />
  </div>
</template>

<script>
import Footer from "../../shared/Footer";
import Header from "../../shared/Header";
import axio from "axios";
import localData from '../services/localData';
export default {
  name: "ContactUs",
  data: () => ({
    form: {
      instructions: null,
      name: null,
      phone: null,
      email: null,
    },
  }),
  methods: {
    nextStep() {
      if(this.validator){
        localData.save("contact", this.form);
        this.$router.push("/confirmation");
      }
    },
    validator() {
      if (
        this.form.name == null ||
        this.form.phone == null ||
        !functions.phoneValidator(this.form.phone) ||
        this.form.pickupEmail == null ||
        !functions.emailValidator(this.form.email)
      ) {
        return false;
      } else {
        return true;
      }
    },
    init() {
      let data = localData.read("contact");
      if (data) {
        this.form.name = data.name;
        this.form.phone = data.phone;
        this.form.email = data.email;
        this.form.instructions = data.instructions;
      }
    },
  },
  mounted() {
    this.$refs.focusable.$el.focus();
  },
  created() {
    this.$emit("progress", 8);
    this.init();
    localData.read("cRoute", this.$router.currentRoute.path);
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
  iframe {
    left: 0;
    top: 0;
    height: 268px;
    width: 100%;
  }

  .section1 {
    max-width: 1200px;
    margin: auto;
    padding: 30px;
    .wrapper {
      display: flex;
      justify-content: space-between;
      flex-wrap: wrap;

      .left {
        flex: 60%;
        padding: 60px;

        .md-display-1 {
          font-weight: 500;
          line-height: 70px;
          color: #000;
        }

        .md-button {
          float: right;
        }
      }

      .right {
        flex: 30%;
        padding: 82px 60px;

        .content {
          text-align: center;

          .md-headline {
            font-size: 18px;
          }
          img {
            margin: 30px;
          }
          .md-caption {
          }
        }
      }
    }
  }
}

@media only screen and (max-width: 600px) {
  .md-card {
    flex-direction: column;
    margin-bottom: 30px;
    margin: auto;
    padding: 0 !important;

    .left {
      text-align: center;
      align-items: center;

      .md-button {
        margin: 0;
      }
    }

    .md-display-1 {
      font-size: 30px;
    }
  }
}
</style>
