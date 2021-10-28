<template>
  <div class="origin">
    <span class="md-display-1">{{myTime.title}}</span>
    <div class="break">
        <div class="d-row">
            <form @submit.prevent="nextStep()">

                <b-form-group  v-slot="{ ariaDescribedby }">
                    <b-form-radio-group
                        id="radio-group-2"
                        v-model="form.time"
                        name="form.time"
                    >
                        <b-form-radio  class="form-control" :aria-describedby="ariaDescribedby"  v-for="option in options" v-bind:key="option.id" :value="option.title">
                            {{option.title}}
                        </b-form-radio>
                    </b-form-radio-group>
                    
                </b-form-group>
            </form>
            
        </div>
        
    </div>
   
  </div>
</template>

<script>
import axios from 'axios';
import localData from '../services/localData';
export default {
    name:"Time",
    props:['time'],
    data: () => ({
        myTime:null,
        options:[],
        date:null,
        form:{
            time:null,
            title:null,
        }
    }),
    methods:{
        async init() {
            this.myTime = this.time;
            if(localData.read("time").time != null){
              this.form.time = localData.read("time").time;
            }
            this.form.title = this.time.title;
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
            this.form.time === ""
            ) {
                this.snackbar.show = true;
                this.snackbar.message = "Please Select any one !";
                this.snackbar.statusCode = 404;
            } else {
                await localData.save("time", this.form);
                
            }
        },
    },
    created(){
        this.init();
        this.get(this.time.id);
    }
    
}
</script>

<style>
.form-control{
  border: none !important;
}
</style>