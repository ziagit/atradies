<template>
  <div class="origin">
    <span class="md-display-1">{{myDescription.title}}</span>
    <div class="break"></div>
    <form @submit.prevent="nextStep()">
      <div class="search-container">
          <md-textarea v-model="description">Description</md-textarea>
      </div>
    </form>
  </div>
</template>

<script>
import axios from 'axios';
export default {
    name:"Description",
    props:['description'],
    data: () => ({
        myDescription:null,
        options:[],
        description:null,
    }),
    methods:{
        async init() {
            this.myDescription = this.description;

        },
    },
    created(){
        this.init();
    }
    
}
</script>

<style>

</style>