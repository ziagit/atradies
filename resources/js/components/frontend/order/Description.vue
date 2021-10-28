<template>
  <div class="origin">
    <span class="md-display-1">{{myDescription.title}}</span>
    <div class="break"></div>
    <form @submit.prevent="nextStep()">
      <div class="search-container">
          <b-form-textarea  v-model="form.description">Description</b-form-textarea>
      </div>
    </form>
  </div>
</template>

<script>
import axios from 'axios';
import localData from '../services/localData';
export default {
    name:"Description",
    props:['description'],
    data: () => ({
        myDescription:null,
        options:[],
        form:{
          description:null,
          title:null,
        }
    }),
    methods:{
        async init() {
            this.myDescription = this.description;
            this.form.description = await localData.read("description").description;
            this.form.title  = this.description.title;
        },
        async nextStep() {
        if (
            this.description === ""
            ) {
                this.snackbar.show = true;
                this.snackbar.message = "Please Select any one !";
                this.snackbar.statusCode = 404;
            } else {
                await localData.save("description", this.form);
                
            }
        },
    },
    created(){
        this.init();
    }
    
}
</script>

<style>

</style>