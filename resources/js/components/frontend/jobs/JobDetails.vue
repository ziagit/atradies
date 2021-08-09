<template>
<div class="container">
      <Header v-on:togal-menu="$emit('togal-menu')" :scrollValue="scrollValue"  />
    <md-card class="no-shadow-bordered">
        <md-card-header>
            <md-button @click="$router.back()" class="md-icon-button close-btn">
                <md-icon>close</md-icon>
                <md-tooltip>Cancel</md-tooltip>
            </md-button>
            <div>
                <div class="md-title">Job details</div>
                <div v-if="dataLoaded" class="job-id">
                    <span>{{job.id}}</span> |
                    <span>{{formatedDate}}</span>
                </div>
            </div>
        </md-card-header>
            <div class="src-des">
                <md-card class="src">
                    <md-card-content>
                    <h3 class="md-subheading">Service details</h3>
                        <div class="body-1">Service name: {{job.service.name}}</div>
                        <div class="body-1">Description: {{job.service.description}}</div>
                    </md-card-content>
                </md-card>
            </div>
            <div class="src-des">
                <md-card class="src">
                    <md-card-content>
                        <h3 class="md-subheading">Addresses details</h3>
                        <div class="body-1">Country: {{job.addresses.country}}</div>
                        <div class="body-1">State: {{job.addresses.state}}</div>
                        <div class="body-1">City: {{job.addresses.city}}</div>
                        <div class="body-1">Address: {{job.addresses.address}}</div>
                        <div class="body-1">Zip code: {{job.addresses.zip}}</div>
                        <div class="body-1">Contact name: {{job.contacts.name}}</div>
                        <div class="body-1">Phone: {{job.contacts.phone}}</div>
                        <div class="body-1">Email: {{job.contacts.email}}</div>
                    </md-card-content>
                </md-card>
                <md-card class="des">
                    <md-card-content>
                        <h3 class="md-subheading">Item details</h3>
                        <div class="body-1">Budget: {{job.budget}}</div>
                        <div class="body-1">How many need: {{job.need}}</div>
                        <div class="body-1">Services: {{job.jobservice}}</div>
                        <div class="body-1">Location type: {{job.location_type}}</div>
                        <div class="body-1">Status : {{job.status}}</div>
                        <div class="body-1">Job time: {{job.time}}</div>
                        <div class="body-1">Description : {{job.description}}</div>
                    </md-card-content>
                </md-card>
            </div>

            
        </md-card-content>
        <md-card-actions>
            <md-button class="md-icon-button mark-as-read" @click="markAsRead()">
                <md-icon>done</md-icon>
                <md-tooltip>Mark as read</md-tooltip>
            </md-button>
        </md-card-actions>
    </md-card>
    <Footer />
</div>
</template>

<script>
import axios from "axios";
import Spinner from "../../shared/Spinner.vue";
import functions from '../services/functions';
import Header from '../../shared/Header.vue';
import Footer from '../../shared/Footer.vue';
export default {
    name: "JobDetails",
    data: () => ({
        job: null,
        active: false,
        hasHistory: false,
        notification: null,
        notificationId: null,
        dataLoaded: false,
        status: [],
        selectedStatus: null,
        dataLoading: false,
        formatedDate: null,
        emails: {
            src: null,
            des: null,
        },
    }),
    methods: {
        jobDetails() {
            axios
                .get("carrier/jobs/" + this.$route.params.id)
                .then((res) => {
                    console.log("job details ", res.data);
                    
                        this.dataLoaded = true;
                        this.job = res.data;
                        this.formatedDate = functions.myDateFormat(this.job.created_at);
                        
                    
                })
                .catch((err) => {
                    console.log(err);
                });
        },
        markAsRead() {
            axios
                .get("auth/read-notification/" + this.notificationId)
                .then((res) => {
                    console.log(res.data);
                    this.$router.replace("../jobs");
                })
                .catch((err) => {
                    console.log(err);
                });
        },

        
        getJobStatus() {
            axios
                .get("carrier/job-status")
                .then((res) => {
                    console.log("job statues: ", res.data);
                    this.status = res.data;
                })
                .catch((err) => {
                    console.log(err);
                });
        },
    },
    created() {
         this.jobDetails();
         this.getJobStatus();
        // this.notificationId = this.$store.state.shared.notificationId;
    },
    // watch: {
    //     $route() {
    //         this.notificationId = this.$store.state.shared.notificationId;
    //         this.jobDetails();
    //     },
    // },
    components: {
        Spinner,
        Header,
        Footer,
    },
};
</script>

<style lang="scss" scoped>
.md-card {
    text-align: center;

    .status {
        display: flex;
        justify-content: flex-end;
        align-items: center;

        .delivered {
            color: green !important;
        }
    }

    .md-card {
        margin: 5px;
    }

    .src,
    .des,
    .items,
    .order_detail {
        box-shadow: none;
        border: 1px solid rgb(241, 241, 241);
        text-align: left;
    }

    .order_detail {
        margin-top: 11px;
    }

    .src-des {
        display: flex;
        justify-content: space-between;
        flex-wrap: wrap;

        .src {
            flex: 1;
        }

        .des {
            flex: 1;
        }
    }

    .close-btn {
        position: absolute;
        top: 0;
        right: 0;
    }

    .job-id {
        span {
            font-size: 11px;
            margin: 0;
            padding: 0;
        }
    }

    .md-subheading {
        font-size: 18px;
    }
}
</style>
