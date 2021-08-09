<template>
  <div class="origin">
    <span class="md-display-1">{{myBudget.title}}</span>
    <div class="break">
        <form @submit.prevent="nextStep()">

                <b-form-group  v-slot="{ ariaDescribedby }">
                    <b-form-radio-group
                        id="radio-group-2"
                        v-model="form.budget"
                        name="form.budget"
                    >
                        <b-form-radio  class="form-control" :aria-describedby="ariaDescribedby"  v-for="option in options" v-bind:key="option.id" :value="option.title">
                            {{option.title}}
                        </b-form-radio>
                    </b-form-radio-group>
                    
                </b-form-group>
            </form>
    </div>
   
  </div>
</template>

<script>
import axios from 'axios';
import localData from '../services/localData';
export default {
    name:"Budget",
    props:['budget'],
    data: () => ({
        myBudger:null,
        options:[],
        date:null,
        form:{
            budget:null,
            title:null,
        }
    }),
    methods:{
        async init() {
            this.myBudget = this.budget;
            if(localData.read("budget").budget != null){
              this.form.budget = localData.read("budget").budget;
            }
            this.form.title = this.budget.title;
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
        },
        async nextStep() {
        if (
            this.form.budget === ""
            ) {
                this.snackbar.show = true;
                this.snackbar.message = "Please Select any one !";
                this.snackbar.statusCode = 404;
            } else {
                await localData.save("budget", this.form);
                
            }
        },
    },
    created(){
        this.init();
        this.get(this.budget.id);
        
    }
    
}
</script>

<style>

</style>