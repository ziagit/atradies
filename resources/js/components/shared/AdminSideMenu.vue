<template>
  <div>
    <md-list :md-expand-single="expandSingle">
      <md-list-item to="/admin" @click="hideMenu()">
        <span class="md-list-item-text">Dashboard</span>
      </md-list-item>
      <md-list-item to="/admin/services" @click="hideMenu()">
        <span class="md-list-item-text">Services</span>
      </md-list-item>
      <md-list-item to="/admin/steps" @click="hideMenu()">
        <span class="md-list-item-text">Steps</span>
      </md-list-item>

      <md-list-item to="/admin/options" @click="hideMenu()">
        <span class="md-list-item-text">Options</span>
      </md-list-item>

      <md-list-item to="/admin/orders" @click="hideMenu()">
        <span class="md-list-item-text">Orders</span>
      </md-list-item>

      <md-list-item md-expand :md-expanded.sync="expandLookups">
        <span class="md-list-item-text">Lookups</span>
        <md-list slot="md-expand">
          <md-list-item class="md-inset" to="/admin/countries" @click="hideMenu()"
            >Country</md-list-item
          >
          
        </md-list>
      </md-list-item>


      <md-list-item to="/admin/users" @click="hideMenu()">
        <span class="md-list-item-text">Users list</span>
      </md-list-item>
      <md-list-item md-expand :md-expanded.sync="expandCompany">
        <span class="md-list-item-text">Company</span>
        <md-list slot="md-expand">
          <md-list-item class="md-inset" to="/admin/about" @click="hideMenu()"
            >About</md-list-item
          >
          <md-list-item class="md-inset" to="/admin/contact" @click="hideMenu()"
            >Contact</md-list-item
          >
          
        </md-list>
      </md-list-item>

      <md-divider></md-divider>
      <div v-if="authenticated">
        <md-list-item md-expand :md-expanded.sync="expandUser">
          <span class="md-list-item-text">User</span>
          <md-list slot="md-expand">
            <md-list-item class="md-inset" @click="profile()">Dashboard</md-list-item>
            <md-list-item class="md-inset" @click="signOut()">Logout</md-list-item>
          </md-list>
        </md-list-item>
        <md-badge class="md-danger" :md-content="notifications.length" md-dense>
          <md-list-item md-expand :md-expanded.sync="expandNotification">
            <span class="md-list-item-text">Notifications</span>

            <md-list slot="md-expand" v-if="user.role[0].name === 'admin'">
              <md-list-item
                class="md-inset"
                v-for="notification in notifications"
                :key="notification.id"
                @click="notificationDetails(notification)"
                >Job ({{ notification.data.job.order_id }})</md-list-item
              >
            </md-list>
          </md-list-item>
        </md-badge>
      </div>
    </md-list>
  </div>
</template>

<script>
import { mapGetters, mapActions } from "vuex";
export default {
  name: "AdminMenu",
  data: () => ({
    expandCompany: false,
    expandShippers: false,
    expandLookups: false,
    expandCarriers: false,
    expandSingle: false,
    expandUser: false,
    menuVisible: false,
    expandNotification: false,
    notifications: [],
  }),
  computed: {
    ...mapGetters({
      authenticated: "auth/authenticated",
      user: "auth/user",
    }),
  },
  methods: {
    ...mapActions({
      signOutAction: "auth/signOut",
      setNotification: "shared/setNotification",
    }),
    signOut() {
      this.signOutAction().then(() => {
        this.$router.push("/");
      });
      this.hideMenu();
    },
    profile() {
      switch (this.user.role[0].name) {
        case "shipper":
          this.$router.push("/shipper");
          this.toggleCard = !this.toggleCard;
          break;
        case "carrier":
          this.$router.push("/carrier");
          this.toggleCard = !this.toggleCard;
          break;
        case "admin":
          this.$router.push("/admin");
          this.toggleCard = !this.toggleCard;
          break;
        default:
          this.$router.push("/");
      }
      this.hideMenu();
    },
    notificationDetails(notification) {
      this.setNotification(notification.id).then((res) => {});
      switch (this.user.role[0].name) {
        case "shipper":
          this.$router.push("/shipper/orders/details/" + notification.data.job.order_id);
          break;
        case "carrier":
          this.$router.push("/carrier/history/details/" + notification.data.job.id);
          break;
        case "admin":
          this.$router.push("/admin/order/" + notification.data.job.order_id);
          break;
        default:
          this.$router.push("/");
      }
      this.hideMenu();
    },
    markAsRead(id) {
      axios
        .get("auth/read-notification/" + id)
        .then((res) => {
          this.getNotifications();
        })
        .catch((err) => {
          console.log(err);
        });
    },

    getNotifications() {
      if (this.authenticated) {
        this.notifications = this.user.notifications;
        Echo.private("App.User." + this.user.id).notification((res) => {
          this.notifications.push(res.notification);
        });
      }
    },
    hideMenu() {
      this.$emit("hideSideMenu");
    },
  },
};
</script>

<style lang="scss" scoped>
.md-badge-content {
  width: 97% !important;
}
</style>
