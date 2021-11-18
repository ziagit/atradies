<template>
  <div class="containerr">
    <Header v-on:togal-menu="$emit('togal-menu')" />
    <div class="content">
      <div class="md-display-1">
        What service <span style="color: rgb(14, 126, 179)">do you need?</span>
      </div>
      <div class="break"></div>
      <div class="break"></div>
      <div class="break"></div>
        SHow here:
        <ul>
          <li v-for="(user,index) in users" :key="index">{{user.name}}</li>
        </ul>
      <div class="actions">
        
        <Category />
      </div>
    </div>
    <div class="image-footer">
      <div class="content-footer">
        <h2>
         <img src="https://assets.homeimprovementpages.com.au/images/tradie.37a3abda79d172232d6636084ed48339.svg"> For aTradies - list your business
        </h2>
        <router-link to="/register" class="btn btn-default" >Register Now</router-link>
      </div>
    </div>
   <Webinfo/>
    <Footer />
  </div>
</template>

<script>
import Footer from "../../shared/Footer";
import Header from "../../shared/Header";
import Category from "../order/Category";
import Webinfo from '../../shared/Webinfo';
import axios from 'axios';
export default {
  name: "HomeContent",
  props: ["scrollValue"],
  data: () => ({
    users:null,
  }),
  created(){
    this.getUsers();
  },
  methods: {
    getUsers(){
      axios.get('test').then(res=>{
        this.users = res.data;
        console.log("users: ",res.data);
      }).catch(err=>console.log(err))
    },
    menuTogal() {
      this.$emit("menu-togal");
    },
    getQoute() {
      this.$router.push("/order/location");
    },
  },

  components: {
    Header,
    Footer,
    Category,
    Webinfo
  },
};
</script>

<style lang="scss" scoped>
.containerr {
  .content {
    background:url('/images/divbackround.jpg');
    text-align: center;
    height: calc(80vh);
    text-align: center;
    margin: auto;
    padding-top: 5%;
    .md-display-1 {
      font-weight: 700;
      font-size: 29px;
    }
    .actions {
      .md-button {
        margin-right: 16px;
      }
    }
   
  }
   .image-footer{
      min-width: 90vw;
      position: relative;
      background-color: rgb(131, 28, 75);
      padding: 1rem 0px;
    }
    .content-footer{
      text-align: center;
      color: white;
    }

    .content-footer h2{
      display: inline;
    }

    

  @media only screen and (max-width: 600px) {
    .content {
      padding: 112px 10px !important;
      text-align: center !important;
      .md-display-1 {
        font-size: 42px !important;
        line-height: 48px !important;
      }
      .md-subheading {
        font-size: 14px !important;
      }
      .md-title {
        font-size: 17px !important;
      }
    }

    .md-body-1 {
      max-width: 100% !important;
    }
  }
}
</style>
