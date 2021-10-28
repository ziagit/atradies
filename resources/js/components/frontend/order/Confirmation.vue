<template>
  <div class="confirmation">
    <Header v-on:togal-menu="$emit('togal-menu')" />
    <div class="content">
      <div class="header">
        <span class="md-display-1">Confirmation</span>
        <div class="md-body-1">Please take a look at the details to confirm the job.</div>
      </div>
      <div class="break"></div>
      <div class="break"></div>
      <md-card v-if="job">
        <md-card-content>
          <div class="md-title">Job details</div>
          <div>
            <div class="item-head"><b>Address</b></div>
            <div class="item">
              <div class="md-body-1" v-if="job.address != null">
                Country : {{ job.address.country }} <br>
                State : {{job.address.state}}  <br>
                City : {{job.address.city}}  <br>
                Zip : {{job.address.zip}} <br>
                Street : {{job.address.street}} <br>
                Street Number : {{job.address.street_number}}

              </div>
            </div>
          </div>
          <md-divider class="md-inset"></md-divider>
          <div>
            <div class="item-head"><b>Contacts</b></div>
            <div class="item" v-if="job.contact != null">
              <div class="md-body-1">Name: {{ job.contact.name }}</div>
              <div class="md-body-1">Phone: {{ job.contact.phone }}</div>
              <div class="md-body-1">Email: {{ job.contact.email }}</div>
            </div>
          </div>
          <md-divider class="md-inset"></md-divider>
          <div>
            <div class="item-head"><b>Other informations</b></div>
            <div class="item">
              <div class="md-body-1" v-if="job.time != null">{{job.time.title}} : {{ job.time.time }}</div>
              <div class="md-body-1" v-if="job.locationtype != null">{{job.locationtype.title}}: {{ job.locationtype.locationtype }}</div>
              <div class="md-body-1" v-if="job.servicetype != null">{{job.servicetype.title}}: {{ job.servicetype.servicetype }}</div>
              <div class="md-body-1" v-if="job.budget != null">{{job.budget.title}}: {{ job.budget.budget }}</div>
              <div class="md-body-1" v-if="job.description != null">{{job.description.title}} : {{ job.description.description }}</div>
            </div>
          </div>

          <div>
            <p>Important notice</p>
            <ul>
              <li>
                All rates quoted are provided according to the Description of Goods
                declared by the Shipper and may be subject to additional charges in the
                case of misdeclaration.
              </li>
              <li>
                If your load needs Special Handling, please select it for an accurate
                quote. Carriers charge for Special Handling if needed, and this will
                affect your final invoice.
              </li>
              <li>
                The pickup date and transit time vary by the carrier and are not
                guaranteed unless otherwise stated.
              </li>
              <li>
                <md-menu md-direction="top-start" :md-active.sync="toggle">
                  Here is our
                  <span class="term-link" md-menu-trigger>Terms & Conditions</span>
                  for further details
                  <md-menu-content>
                    <TermsAndConditions />
                  </md-menu-content>
                </md-menu>
              </li>
            </ul>
            <div class="confirm">
              <p>By clicking on Confirm you accept our Terms & Conditions</p>
              <div>
                <Spinner v-if="dataLoading" />
                <md-button @click="confirm()" class="md-primary">Confirm</md-button>
              </div>
            </div>
          </div>
        </md-card-content>
      </md-card>
    </div>
    <Footer />
    <Snackbar :data="snackbar" />
  </div>
</template>

<script>
import axios from "axios";
import functions from "../services/functions";
import Spinner from "../../shared/Spinner";
import Snackbar from "../../shared/Snackbar";
import TermsAndConditions from "../../shared/TermsAndConditions";

import Header from "../../shared/Header";
import Footer from "../../shared/Footer";
import localData from '../services/localData';

export default {
  name: "Confirmation",
  data: () => ({
    job: null,
    dataLoading: false,
    paymentStatus: false,
    toggle: false,
    snackbar: {
      show: false,
      message: null,
      statusCode: null,
    },
      form:{
      time:null,
      service:null,
      contact:null,
      address:null,
      status:null,
      budget:null,
      need:null,
      locationtype:null,
      servicetype:null,
      description:null,
      order_service:null,
    }
  }),
  methods: {
    confirm() {
      this.dataLoading = true;
      this.$router.push("completion");
      axios
        .post("confirm", JSON.parse(localStorage.getItem("order")))
        .then((res) => {
          if(res.data.status)
          {
            this.$router.push("completion");
            this.emptyItem();
            this.dataLoading = false;
          }
          else{
            alert(res.data);
          }  
        })
        .catch((err) => {
          this.dataLoading = false;
          this.snackbar.show = true;
          this.snackbar.message = err.message;
          this.snackbar.statusCode = err.status;
          console.log(err);
        });
    },

    init() {
      this.$emit("progress", 10);
      functions.makeJob().then((res) => {
        this.job = res;
        console.log("xxxxxxxx", this.job);
      });
    },

    setItems(){
      this.form.time = localData.read('time');
      this.form.service = localData.read('service');
      this.form.contact = localData.read('contact');
      this.form.address = localData.read('address');
      this.form.status = localData.read('status');
      this.form.budget = localData.read('budget');
      this.form.need = localData.read('need');
      this.form.locationtype = localData.read('locationtype');
      this.form.servicetype = localData.read("servicetype");
      this.form.description = localData.read("description");
      this.form.order_service = localData.read('order_service');
      localData.save("order",this.form);
    },

    emptyItem(){
      localData.remove('time');
      localData.remove('service');
      localData.remove('contact');
      localData.remove('address');
      localData.remove('status');
      localData.remove('budget');
      localData.remove('need');
      localData.remove('locationtype');
      localData.remove("servicetype");
      localData.remove("description");
      localData.remove('order_service');
    }
  },
  created() {
    this.init();
    this.setItems();
    console.log(JSON.parse(localStorage.getItem("order")));
  },
  components: {
    Spinner,
    Snackbar,
    TermsAndConditions,
    Header,
    Footer,
  },
};
</script>

<style lang="scss" scoped>
.confirmation {
  text-align: center;
  .content {
    max-width: 600px;
    margin: auto;
    .md-card {
      text-align: left;
      margin: auto;
      .md-card-content {
        padding: 20px;

        .loading {
          text-align: right;
        }
      }
      .item {
        margin: 0 0 10px 10px;

        .green {
          color: green;
        }
      }
    }

    .md-body-1 {
      width: 100% !important;
    }
    .confirm {
      div {
        text-align: right;
      }
    }

    .term-link {
      color: #448aff;
    }

    .term-link:hover {
      cursor: pointer;
    }
  }
}
</style>
