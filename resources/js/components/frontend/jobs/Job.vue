<template>
  <div class="container">
      <Header v-on:togal-menu="$emit('togal-menu')" :scrollValue="scrollValue"  />
        <md-card md-theme="orange-card">
            <md-card-header>
                <div class="md-title">Job history</div>
            </md-card-header>
            <md-card-content>
                <div class="row">
                    <!--Grid column-->
                    
                    <div class="col col-md-12 md-content pinter" v-for="job in jobs" :key="job.id">
                        <div>
                            <md-card>
                                <div class="row">
                                    <div class="com-md-4">
                                        <img v-if="job.service.icon != ''" :src="'images/uploads/' + job.service.icon" alt="" width="60" style="" />
                                        <img v-else :src="'images/uploads/' + '1618318023.icon.svg'" alt="" width="60" />
                                
                                    </div>
                                    <div class="col-md-8">
                                        <router-link :to="'jobs/details/'+job.user_jobId" >
                                            <h3>
                                                {{job.service.name}}
                                            </h3>
                                            {{job.service.description.substring(0,30)+"..."}}|
                                        </router-link>
                                        
                                        {{job.addresses.country}}
                                        |{{job.addresses.city}}|
                                        {{job.created_at.substring(0,10)}}
                                    
                                    </div>
                                </div>
                                    
                                    
                                
                            </md-card>
                        </div>
                    </div>
                </div>

            <md-empty-state class="md-primary" md-icon="done" md-label="Nothing in Done" md-description="Anything you mark done will be safely stored here." v-if="jobs.length == 0"></md-empty-state>
        </md-card-content>
    </md-card>
    <Footer />
</div>
</template>

<script>
import axios from "axios";
import Header from '../../shared/Header.vue';
import Footer from '../../shared/Footer.vue';
export default {
    name: "Job",
    data: () => ({
        jobs: [],
    }),
    components:{
        Header,
        Footer
    },
    methods: {
        getJobs() {
            axios
                .get("carrier/jobs")
                .then((res) => {
                    this.jobs = res.data;
                    console.log("job list ", this.jobs[0].user.name);
                })
                .catch((err) => {
                    console.log("error", err);
                });
        },
    },
    
    created() {
        this.getJobs();
    },
};
</script>


<style lang="scss" scoped>
.md-card {
    box-shadow: none;
    border: 1px solid #ddd;
    .md-card-content {
        overflow-x: auto;
    }

    .table {
        width: 100%;
        border-collapse: collapse;

        th,
        td {
            border: 1px solid #ddd;
        }

        .delivered {
            color: green !important;
        }
    }

    .add-btn {
        position: absolute;
        top: 0;
        right: 0;
    }
    .md-content{
        margin-top: 10px;
    }
    .com-md-4 img{
        border-radius: 50px;
        margin-left: 20px;
    }
}
</style>