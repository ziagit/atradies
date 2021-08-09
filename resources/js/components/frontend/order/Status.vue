<template>
  <div class="origin">
    <span class="md-display-1">{{myStatus.title}}</span>
    <div class="break">
        <form @submit.prevent="nextStep()">

                <b-form-group  v-slot="{ ariaDescribedby }">
                    <b-form-radio-group
                        id="radio-group-2"
                        v-model="form.status"
                        name="form.status"
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
    name:"Status",
    props:['status'],
    data: () => ({
        myStatus:null,
        options:[],
        date:null,
        form:{
            status:null,
            title:null,
        }
    }),
    methods:{
        async init() {
            this.myStatus = this.status;
            if(localData.read("status").status != null){
                this.form.status = localData.read("status").status;
            }
            this.form.title = this.status.title;
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
            this.form.status === ""
            ) {
                this.snackbar.show = true;
                this.snackbar.message = "Please Select any one !";
                this.snackbar.statusCode = 404;
            } else {
                await localData.save("status", this.form);
                
            }
        },
    },
    created(){
        this.init();
        this.get(this.status.id);
        
    }
    
}
</script>

<style>

</style>