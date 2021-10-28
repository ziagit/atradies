<template>
  <div class="origin">
    <span class="md-display-1">{{myServiceType.title}}</span>
    <div class="break">
        <form @submit.prevent="nextStep()">

                <b-form-group  v-slot="{ ariaDescribedby }">
                    <b-form-radio-group
                        id="radio-group-2"
                        v-model="form.servicetype"
                        name="form.servicetype"
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
    name:"ServiceType",
    props:['servicetype'],
    data: () => ({
        myServiceType:null,
        options:[],
        date:null,
        form:{
            servicetype:null,
            title:null,
        }
    }),
    methods:{
        async init() {
            this.myServiceType = this.servicetype;
            if(localData.read("servicetype").servicetype != null){
                this.form.servicetype = localData.read("servicetype").servicetype;
            }
            this.form.title = this.servicetype.title;
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
            this.form.servicetype === ""
            ) {
                this.snackbar.show = true;
                this.snackbar.message = "Please Select any one !";
                this.snackbar.statusCode = 404;
            } else {
                await localData.save("servicetype", this.form);
                
            }
        },
    },
    created(){
        this.init();
        this.get(this.servicetype.id);
        
    }
    
}
</script>

<style>
.form-control{
  border: none !important;
}
</style>