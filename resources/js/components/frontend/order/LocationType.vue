<template>
  <div class="origin">
    <span class="md-display-1">{{myLocationType.title}}</span>
    <div class="break">
        <div class="d-row">
            <form @submit.prevent="nextStep()">

                <b-form-group  v-slot="{ ariaDescribedby }">
                    <b-form-radio-group
                        id="radio-group-2"
                        v-model="form.locationtype"
                        name="form.locationtype"
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
    name:"LocationType",
    props:['locationtype'],
    data: () => ({
        myLocationType:null,
        options:[],
        date:null,
        form:{
            locationtype:null,
            title:null,
        }
    }),
    methods:{
        async init() {
            this.myLocationType = this.locationtype;
            if(localData.read("locationtype").locationtype != null){
                this.form.locationtype = localData.read("locationtype").locationtype;
            }
            this.form.title = this.locationtype.title;
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
            this.form.locationtype === ""
            ) {
                this.snackbar.show = true;
                this.snackbar.message = "Please Select any one !";
                this.snackbar.statusCode = 404;
            } else {
                await localData.save("locationtype", this.form);
                
                
            }
        },
    },
    created(){
        this.init();
        this.get(this.locationtype.id);
        

    }
    
}
</script>

<style>

</style>