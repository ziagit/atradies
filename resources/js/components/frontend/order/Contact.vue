<template>
  <div class="additional-details">
    <span class="md-display-1">Add your contact info</span>
    <form @submit.prevent="nextStep()">
      <md-field>
        <label>Name</label>
        <md-input type="text" ref="focusable" v-model="form.name" required></md-input>
      </md-field>
      <div class="row">
        <md-field>
          <label>Phone</label>
          <md-input type="text" v-model="form.phone" required></md-input>
        </md-field>
        <md-field>
          <label>Email</label>
          <md-input type="email" v-model="form.email" required></md-input>
          <md-icon class="md-primary">
            info
            <md-tooltip>Use your account email!</md-tooltip>
          </md-icon>
        </md-field>
      </div>
      <md-field>
        <label>Work descriptions</label>
        <md-textarea v-model="form.instructions"></md-textarea>
      </md-field>
      <div class="action">
        <md-button @click="$router.back()" class="md-icon-button md-raised">
          <md-icon>arrow_left</md-icon>
        </md-button>
        <div class="tab"></div>
        <md-button class="md-icon-button md-raised md-primary" type="submit">
          <md-icon>arrow_right</md-icon>
        </md-button>
      </div>
    </form>
  </div>
</template>

<script>
import functions from "../services/functions";
import localData from "../services/localData";
export default {
  name: "Contact",
  data: () => ({
    form: {
      instructions: null,
      name: null,
      phone: null,
      email: null,
    },
    error: null,
  }),

  methods: {
    nextStep() {
      localData.save("contact", this.form);
      this.$router.push("/order/confirmation");
    },
    validator() {
      if (
        this.form.name == null ||
        this.form.phone == null ||
        !functions.phoneValidator(this.form.phone) ||
        this.form.pickupEmail == null ||
        !functions.emailValidator(this.form.email)
      ) {
        return false;
      } else {
        return true;
      }
    },
    init() {
      let data = localData.read("contact");
      if (data) {
        this.form.name = data.name;
        this.form.phone = data.phone;
        this.form.email = data.email;
        this.form.instructions = data.instructions;
      }
    },
  },
  mounted() {
    this.$refs.focusable.$el.focus();
  },
  created() {
    this.$emit("progress", 8);
    this.init();
    localData.read("cRoute", this.$router.currentRoute.path);
  },
};
</script>

<style lang="scss" scoped>
.additional-details {
  text-align: center;

  .pick-time {
    display: flex;
    justify-content: space-between;

    .md-field {
      width: 48%;
    }
  }

  .row {
    display: flex;
    justify-content: space-between;
    flex-wrap: wrap;

    .md-field {
      flex: 50%;
    }
  }

  .md-vertical {
    background: none;
  }
  .action {
    display: flex;
    justify-content: center;
  }
}

@media only screen and (min-width: 600px) {
}
</style>
