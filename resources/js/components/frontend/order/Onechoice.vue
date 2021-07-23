<template>
  <div class="origin">
    <span class="md-display-1">{{myOnechoice.title}}</span>
    <div class="break"></div>
    <form @submit.prevent="nextStep()"> 
      <div class="search-container">
          <div class="row" v-for="option in options" v-bind:key="option.id">
            <md-checkbox :v-model="option.title" :value="option.title">{{option.title}}</md-checkbox>
          </div>
      </div>
    </form>
  </div>
</template>

<script>
import axios from 'axios';
export default {
    name:"Onechoice",
    props:['onechoice'],
    data: () => ({
        myOnechoice:null,
        options:[],
        one:null,
    }),
    methods:{
        async init() {
            this.myOnechoice = this.onechoice;

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
        this.get(this.onechoice.id);
    }
    
}
</script>

<style>

</style>