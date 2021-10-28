<template>
  <div class="origin">
    <span class="md-display-1">{{myNeed.title}}</span>
    <div class="break">
        <form @submit.prevent="nextStep()">

                <b-form-group  v-slot="{ ariaDescribedby }">
                    <b-form-radio-group
                        id="radio-group-2"
                        v-model="form.need"
                        name="form.need"
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
    name:"Need",
    props:['need'],
    data: () => ({
        myNeed:null,
        options:[],
        date:null,
        form:{
            need:null,
            title:null,
        }
    }),
    methods:{
        async init() {
            this.myNeed = this.need;
            if(localData.read("need").need != null){
                this.form.need = localData.read("need").need;
            }
            this.form.title = this.need.title;
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
            this.form.need === ""
            ) {
                this.snackbar.show = true;
                this.snackbar.message = "Please Select any one !";
                this.snackbar.statusCode = 404;
            } else {
                await localData.save("need", this.form);
                
            }
        },
    },
    created(){
        this.init();
        this.get(this.need.id);
        
    }
    
}
</script>

<style>

</style>