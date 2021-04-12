<template>
  <div class="pickup-date">
    <span class="md-display-1">When you need this worker?</span>
    <div class="break"></div>
    <div class="break"></div>
    <form @submit.prevent="nextStep()">
      <div>
        <md-field>
          <input type="date" v-model="selectedDate" required :min="validDate" />
        </md-field>
      </div>
      <div class="options">
        <md-checkbox
          v-for="accessory in accessories"
          :key="accessory.id"
          v-model="appointment"
          :value="accessory.code"
          >{{ accessory.name }}?</md-checkbox
        >
        <md-field v-if="appointment">
          <md-input
            type="time"
            v-model="appointmentTime"
            :required="appointment"
          ></md-input>
        </md-field>
      </div>
      <div class="break"></div>
      <div class="break"></div>
      <div class="action">
        <md-button class="md-raised md-icon-button" @click="$router.back()">
          <md-icon>arrow_left</md-icon>
        </md-button>
        <md-button class="md-primary md-raised md-icon-button" type="submit">
          <md-icon>arrow_right</md-icon>
        </md-button>
      </div>
    </form>
  </div>
</template>

<script>
import functions from "../services/functions";
export default {
  name: "PickupDate",
  data: () => ({
    selectedDate: null,
    accessories: null,
    appointment: null,
    appointmentTime: null,
    boxChecked: false,
    validDate: functions.validDate(),
  }),

  methods: {
    nextStep() {
      if (this.selectedDate != null) {
        let storage = JSON.parse(localStorage.getItem("order"));
        storage.pickDate = this.selectedDate;
        if (this.appointment != null) {
          if (!storage.src.accessories.includes("ap")) {
            storage.src.accessories.push(this.appointment);
          }
          storage.src.appointmentTime = this.appointmentTime;
        } else {
          if (storage.src.accessories.includes("ap")) {
            for (let i = 0; i < storage.src.accessories.length; i++) {
              if (storage.src.accessories[i] === "ap") {
                storage.src.accessories.splice(i, 1);
              }
            }
          }
          storage.src.appointmentTime = null;
        }

        storage.save("date", this.selectedDate);
        this.$router.push("additional-details");
      }
    },

    init() {
      let data = storage.read("date");
      if (data != null) {
        this.selectedDate = date;
        if (storage.src.accessories.includes("ap")) {
          this.appointment = "ap";
          this.appointmentTime = storage.src.appointmentTime;
        }
      }
    },
    getAccessories() {
      axios
        .get("pick-date")
        .then((res) => {
          this.accessories = res.data;
        })
        .catch((err) => {
          console.log("Error: ", err);
        });
    },
  },
  created() {
    this.$emit("progress", 2);
    this.init();
    this.getAccessories();
    storage.save("cRoute", this.$router.currentRoute.path);
  },
};
</script>

<style lang="scss" scoped>
.pickup-date {
  text-align: center;
  input {
    width: 100%;
    background: #f0f2f5;
    border: none;
    font-family: "Roboto";
    font-size: 16px;
  }

  input:focus {
    outline: none;
  }
}

@media only screen and (max-width: 600px) {
}
</style>
