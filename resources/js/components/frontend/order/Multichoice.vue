<template>
  <div class="origin">
    <span class="md-display-1">{{myMultichoice.title}}</span>
    <div class="break"></div>
    <form @submit.prevent="nextStep()">
      <div class="search-container">
          <div class="row" v-for="option in options" v-bind:key="option.id">
            <md-checkbox :v-model="title" :value="option.title">{{option.title}}</md-checkbox>
          </div>
      </div>
    </form>
  </div>
</template>

<script>
import axios from 'axios';
export default {
    name:"Multichoice",
    props:['multichoice'],
    data: () => ({
        myMultichoice:null,
        options:[],
        values:[],
        one:null,
       
            title:null,
        
    }),
    methods:{
        async init() {
            this.myMultichoice = this.multichoice;
        },
        get(step_id){
            axios
            .get('/step-option/'+step_id)
            .then((response) => {
                this.options = response.data;
            })
            .catch((error) => {
                console.log(error);
            });
        }
    },
    created(){
        this.init();
        this.get(this.multichoice.id);
    }
    
}
</script>

<style>

</style>